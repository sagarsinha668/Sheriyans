jQuery(document).ready(function($) {
    
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    $('#bookingDate').attr('min', today);
    
    // Disable Sundays
    $('#bookingDate').on('change', function() {
        const selectedDate = new Date(this.value);
        if (selectedDate.getDay() === 0) {
            alert('Clinic is closed on Sundays. Please select another date.');
            this.value = '';
            return;
        }
    });
    
    // Load clinics based on state
    $('#stateSelect').on('change', function() {
        const state = $(this).val();
        
        if (!state) {
            $('#clinicSelect').prop('disabled', true).html('<option value="">First select a state</option>');
            $('#timeSlot').prop('disabled', true).html('<option value="">First select clinic and date</option>');
            return;
        }
        
        $.ajax({
            url: clinicBooking.ajax_url,
            type: 'POST',
            data: {
                action: 'get_clinics',
                nonce: clinicBooking.nonce,
                state: state
            },
            beforeSend: function() {
                $('#clinicSelect').html('<option value="">Loading...</option>');
            },
            success: function(response) {
                if (response.success) {
                    let options = '<option value="">Choose Clinic</option>';
                    response.data.forEach(function(clinic) {
                        options += `<option value="${clinic.clinic_name}" data-email="${clinic.owner_email}">${clinic.clinic_name}</option>`;
                    });
                    $('#clinicSelect').prop('disabled', false).html(options);
                }
            },
            error: function() {
                alert('Error loading clinics. Please try again.');
            }
        });
    });
    
    // Load available time slots
    function loadTimeSlots() {
        const clinic = $('#clinicSelect').val();
        const date = $('#bookingDate').val();
        
        if (!clinic || !date) {
            $('#timeSlot').prop('disabled', true).html('<option value="">First select clinic and date</option>');
            return;
        }
        
        $.ajax({
            url: clinicBooking.ajax_url,
            type: 'POST',
            data: {
                action: 'get_available_slots',
                nonce: clinicBooking.nonce,
                clinic: clinic,
                date: date
            },
            beforeSend: function() {
                $('#timeSlot').html('<option value="">Loading slots...</option>');
            },
            success: function(response) {
                if (response.success) {
                    if (response.data.length === 0) {
                        $('#timeSlot').prop('disabled', true).html('<option value="">No slots available for this date</option>');
                    } else {
                        let options = '<option value="">Choose Time Slot</option>';
                        response.data.forEach(function(slot) {
                            options += `<option value="${slot.value}">${slot.label}</option>`;
                        });
                        $('#timeSlot').prop('disabled', false).html(options);
                    }
                }
            },
            error: function() {
                alert('Error loading time slots. Please try again.');
            }
        });
    }
    
    $('#clinicSelect, #bookingDate').on('change', loadTimeSlots);
    
    // Submit booking
    $('#clinicBookingForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        
        $.ajax({
            url: clinicBooking.ajax_url,
            type: 'POST',
            data: formData + '&action=submit_booking&nonce=' + clinicBooking.nonce,
            beforeSend: function() {
                $('.submit-btn').prop('disabled', true).text('Booking...');
                $('.form-message').html('');
            },
            success: function(response) {
                if (response.success) {
                    $('.form-message').html('<div class="success-message">' + response.data + '</div>');
                    $('#clinicBookingForm')[0].reset();
                    $('#clinicSelect').prop('disabled', true).html('<option value="">First select a state</option>');
                    $('#timeSlot').prop('disabled', true).html('<option value="">First select clinic and date</option>');
                } else {
                    $('.form-message').html('<div class="error-message">' + response.data + '</div>');
                    loadTimeSlots(); // Reload slots to remove booked one
                }
                $('.submit-btn').prop('disabled', false).text('Book Appointment');
            },
            error: function() {
                $('.form-message').html('<div class="error-message">An error occurred. Please try again.</div>');
                $('.submit-btn').prop('disabled', false).text('Book Appointment');
            }
        });
    });
    
});