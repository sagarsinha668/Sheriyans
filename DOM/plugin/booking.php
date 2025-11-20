<?php
/**
 * Plugin Name: Clinic Booking Appointment
 * Plugin URI: https://yourwebsite.com
 * Description: Booking appointment system for Flatsome theme with state-based clinic filtering
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 * License: GPL2
 */

if (!defined('ABSPATH')) exit;

class Clinic_Booking_Plugin {
    
    public function __construct() {
        register_activation_hook(__FILE__, array($this, 'activate'));
        add_action('admin_menu', array($this, 'admin_menu'));
        add_shortcode('clinic_booking_form', array($this, 'booking_form_shortcode'));
        add_action('wp_ajax_get_clinics', array($this, 'ajax_get_clinics'));
        add_action('wp_ajax_nopriv_get_clinics', array($this, 'ajax_get_clinics'));
        add_action('wp_ajax_get_available_slots', array($this, 'ajax_get_available_slots'));
        add_action('wp_ajax_nopriv_get_available_slots', array($this, 'ajax_get_available_slots'));
        add_action('wp_ajax_submit_booking', array($this, 'ajax_submit_booking'));
        add_action('wp_ajax_nopriv_submit_booking', array($this, 'ajax_submit_booking'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }
    
    public function activate() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        
        // Bookings table
        $bookings_table = $wpdb->prefix . 'clinic_bookings';
        $sql1 = "CREATE TABLE IF NOT EXISTS $bookings_table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            client_name varchar(100) NOT NULL,
            client_email varchar(100) NOT NULL,
            client_mobile varchar(20) NOT NULL,
            state varchar(50) NOT NULL,
            clinic varchar(100) NOT NULL,
            booking_date date NOT NULL,
            booking_time time NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY unique_booking (clinic, booking_date, booking_time)
        ) $charset_collate;";
        
        // Clinics table
        $clinics_table = $wpdb->prefix . 'clinic_locations';
        $sql2 = "CREATE TABLE IF NOT EXISTS $clinics_table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            state varchar(50) NOT NULL,
            clinic_name varchar(100) NOT NULL,
            owner_email varchar(100) NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql1);
        dbDelta($sql2);
        
        // Insert sample clinics
        $wpdb->insert($clinics_table, array(
            'state' => 'Maharashtra',
            'clinic_name' => 'Pune Clinic',
            'owner_email' => 'pune@clinic.com'
        ));
        $wpdb->insert($clinics_table, array(
            'state' => 'Maharashtra',
            'clinic_name' => 'Solapur Clinic',
            'owner_email' => 'solapur@clinic.com'
        ));
        $wpdb->insert($clinics_table, array(
            'state' => 'Delhi',
            'clinic_name' => 'Rohini Clinic',
            'owner_email' => 'rohini@clinic.com'
        ));
        $wpdb->insert($clinics_table, array(
            'state' => 'Delhi',
            'clinic_name' => 'Badarpur Clinic',
            'owner_email' => 'badarpur@clinic.com'
        ));
    }
    
    public function admin_menu() {
        add_menu_page(
            'Clinic Bookings',
            'Clinic Bookings',
            'manage_options',
            'clinic-bookings',
            array($this, 'bookings_page'),
            'dashicons-calendar-alt',
            30
        );
    }
    
    public function bookings_page() {
        global $wpdb;
        $bookings_table = $wpdb->prefix . 'clinic_bookings';
        $bookings = $wpdb->get_results("SELECT * FROM $bookings_table ORDER BY booking_date DESC, booking_time DESC");
        
        ?>
        <div class="wrap">
            <h1>All Clinic Bookings</h1>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>State</th>
                        <th>Clinic</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Booked On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($bookings): ?>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><?php echo $booking->id; ?></td>
                                <td><?php echo esc_html($booking->client_name); ?></td>
                                <td><?php echo esc_html($booking->client_email); ?></td>
                                <td><?php echo esc_html($booking->client_mobile); ?></td>
                                <td><?php echo esc_html($booking->state); ?></td>
                                <td><?php echo esc_html($booking->clinic); ?></td>
                                <td><?php echo date('d M Y', strtotime($booking->booking_date)); ?></td>
                                <td><?php echo date('h:i A', strtotime($booking->booking_time)); ?></td>
                                <td><?php echo date('d M Y H:i', strtotime($booking->created_at)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="9">No bookings found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
    
    public function enqueue_scripts() {
        wp_enqueue_style('clinic-booking-css', plugin_dir_url(__FILE__) . 'style.css');
        wp_enqueue_script('clinic-booking-js', plugin_dir_url(__FILE__) . 'script.js', array('jquery'), '1.0', true);
        wp_localize_script('clinic-booking-js', 'clinicBooking', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('clinic_booking_nonce')
        ));
    }
    
    public function booking_form_shortcode() {
        ob_start();
        ?>
        <div class="clinic-booking-form">
            <h2>Book Your Appointment</h2>
            <form id="clinicBookingForm">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="client_name" required>
                </div>
                
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="client_email" required>
                </div>
                
                <div class="form-group">
                    <label>Mobile Number *</label>
                    <input type="tel" name="client_mobile" pattern="[0-9]{10}" required>
                </div>
                
                <div class="form-group">
                    <label>Select State *</label>
                    <select name="state" id="stateSelect" required>
                        <option value="">Choose State</option>
                        <option value="Maharashtra">Maharashtra</option>
                        <option value="Delhi">Delhi</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Select Clinic *</label>
                    <select name="clinic" id="clinicSelect" required disabled>
                        <option value="">First select a state</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Select Date *</label>
                    <input type="date" name="booking_date" id="bookingDate" required>
                </div>
                
                <div class="form-group">
                    <label>Select Time Slot *</label>
                    <select name="booking_time" id="timeSlot" required disabled>
                        <option value="">First select clinic and date</option>
                    </select>
                </div>
                
                <div class="form-message"></div>
                
                <button type="submit" class="submit-btn">Book Appointment</button>
            </form>
        </div>
        <?php
        return ob_get_clean();
    }
    
    public function ajax_get_clinics() {
        check_ajax_referer('clinic_booking_nonce', 'nonce');
        
        global $wpdb;
        $state = sanitize_text_field($_POST['state']);
        $clinics_table = $wpdb->prefix . 'clinic_locations';
        
        $clinics = $wpdb->get_results($wpdb->prepare(
            "SELECT clinic_name, owner_email FROM $clinics_table WHERE state = %s",
            $state
        ));
        
        wp_send_json_success($clinics);
    }
    
    public function ajax_get_available_slots() {
        check_ajax_referer('clinic_booking_nonce', 'nonce');
        
        global $wpdb;
        $clinic = sanitize_text_field($_POST['clinic']);
        $date = sanitize_text_field($_POST['date']);
        $bookings_table = $wpdb->prefix . 'clinic_bookings';
        
        // Get booked slots
        $booked_slots = $wpdb->get_col($wpdb->prepare(
            "SELECT booking_time FROM $bookings_table WHERE clinic = %s AND booking_date = %s",
            $clinic, $date
        ));
        
        // Generate all time slots (9 AM to 6 PM, 10-minute intervals)
        $all_slots = array();
        $start = strtotime('09:00:00');
        $end = strtotime('18:00:00');
        
        while ($start < $end) {
            $time = date('H:i:s', $start);
            if (!in_array($time, $booked_slots)) {
                $all_slots[] = array(
                    'value' => $time,
                    'label' => date('h:i A', $start)
                );
            }
            $start += 600; // 10 minutes
        }
        
        wp_send_json_success($all_slots);
    }
    
    public function ajax_submit_booking() {
        check_ajax_referer('clinic_booking_nonce', 'nonce');
        
        global $wpdb;
        $bookings_table = $wpdb->prefix . 'clinic_bookings';
        $clinics_table = $wpdb->prefix . 'clinic_locations';
        
        $data = array(
            'client_name' => sanitize_text_field($_POST['client_name']),
            'client_email' => sanitize_email($_POST['client_email']),
            'client_mobile' => sanitize_text_field($_POST['client_mobile']),
            'state' => sanitize_text_field($_POST['state']),
            'clinic' => sanitize_text_field($_POST['clinic']),
            'booking_date' => sanitize_text_field($_POST['booking_date']),
            'booking_time' => sanitize_text_field($_POST['booking_time'])
        );
        
        $result = $wpdb->insert($bookings_table, $data);
        
        if ($result) {
            // Get owner email
            $owner = $wpdb->get_row($wpdb->prepare(
                "SELECT owner_email FROM $clinics_table WHERE clinic_name = %s",
                $data['clinic']
            ));
            
            // Send email to client
            $client_subject = 'Booking Confirmation - ' . $data['clinic'];
            $client_message = "Dear {$data['client_name']},\n\n";
            $client_message .= "Your appointment has been confirmed!\n\n";
            $client_message .= "Clinic: {$data['clinic']}\n";
            $client_message .= "Date: " . date('d M Y', strtotime($data['booking_date'])) . "\n";
            $client_message .= "Time: " . date('h:i A', strtotime($data['booking_time'])) . "\n\n";
            $client_message .= "Thank you for choosing our clinic.";
            
            wp_mail($data['client_email'], $client_subject, $client_message);
            
            // Send email to owner
            if ($owner) {
                $owner_subject = 'New Booking - ' . $data['clinic'];
                $owner_message = "New appointment booked:\n\n";
                $owner_message .= "Client: {$data['client_name']}\n";
                $owner_message .= "Email: {$data['client_email']}\n";
                $owner_message .= "Mobile: {$data['client_mobile']}\n";
                $owner_message .= "Date: " . date('d M Y', strtotime($data['booking_date'])) . "\n";
                $owner_message .= "Time: " . date('h:i A', strtotime($data['booking_time']));
                
                wp_mail($owner->owner_email, $owner_subject, $owner_message);
            }
            
            wp_send_json_success('Booking confirmed! Check your email for details.');
        } else {
            wp_send_json_error('This time slot is already booked. Please select another.');
        }
    }
}

new Clinic_Booking_Plugin();
?>