const reels = [
  {
    username: "rahul_editz",           // The user who posted this reel
    isLiked: false,                    // Whether YOU have liked this reel (false = not liked yet)
    likeCount: 823,                    // Total number of likes on this reel
    commentCount: 42,                  // Total number of comments
    isFollowed: true,                  // Whether YOU are following this user
    video: "./media/video1.mp4",       // Path to the video file
    userProfile: "https://images.pexels.com/photos/415829/pexels-photo-415829.jpeg",
    shareCount: 19,                    // How many times this was shared
    ismuted:true,
    caption: "Late night edit session 🔥✨"  // The text 
    // caption
  },
  {
    username: "travelwithanu",
    isLiked: true,
    likeCount: 1500,
    commentCount: 88,
    isFollowed: false,
    video: "./media/video2.mp4",
    userProfile: "https://images.pexels.com/photos/675920/pexels-photo-675920.jpeg?cs=srgb&dl=pexels-minan1398-675920.jpg&fm=jpg",
    shareCount: 57,
    ismuted:true,
    caption: "Sunset from the highest cliff 🌅"
  },
  {
    username: "codewithshiv",
    isLiked: true,
    likeCount: 310,
    commentCount: 14,
    isFollowed: true,
    video: "./media/video3.mp4",
    userProfile: "https://images.pexels.com/photos/614810/pexels-photo-614810.jpeg",
    shareCount: 6,
    ismuted:true,
    caption: "JS tips you wish you knew earlier ⚡"
  },
  {
    username: "fitness_ayush",
    isLiked: false,
    likeCount: 2450,
    commentCount: 120,
    isFollowed: false,
    video: "./media/video4.mp4",
    userProfile: "./media/fitness.jpg",
    shareCount: 75,
    ismuted:true,
    caption: "Back day🔥 No excuses."
  },
  {
    username: "foodie_priya",
    isLiked: true,
    likeCount: 985,
    commentCount: 33,
    isFollowed: true,
    video: "./media/video5.mp4",
    userProfile: "https://images.pexels.com/photos/733872/pexels-photo-733872.jpeg",
    shareCount: 28,
    ismuted:true,
    caption: "Trying this new Korean dish 😋"
  },
  {
    username: "thetechreviewer",
    isLiked: false,
    likeCount: 540,
    commentCount: 25,
    isFollowed: false,
    video: "./media/video6.mp4",
    userProfile: "https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg",
    shareCount: 12,
    ismuted:true,
    caption: "iPhone vs Android 🇮🇳 Which one you pick?"
  },
  {
    username: "artist_kriti",
    isLiked: false,
    likeCount: 1270,
    commentCount: 61,
    isFollowed: true,
    video: "./media/video7.mp4",
    userProfile: "./media/artist.jpg",
    shareCount: 44,
    ismuted:true,
    caption: "Speed painting in 1 hour! 🎨"
  },
  {
    username: "gaming_rohan",
    isLiked: true,
    likeCount: 2120,
    commentCount: 98,
    isFollowed: false,
    video: "./media/video8.mp4",
    userProfile: "./media/gamers.jpg",
    shareCount: 81,
    ismuted:true,
    caption: "New GTA VI leak reaction 😂🎮"
  },
  {
    username: "vlogwithsam",
    isLiked: false,
    likeCount: 640,
    commentCount: 22,
    isFollowed: false,
    video: "./media/video9.mp4",
    userProfile: "https://images.pexels.com/photos/91227/pexels-photo-91227.jpeg",
    shareCount: 18,
    ismuted:true,
    caption: "Morning vlog from Manali 🌄"
  },
  {
    username: "fashion_sneha",
    isLiked: true,
    likeCount: 1750,
    commentCount: 76,
    isFollowed: true,
    video: "./media/video10.mp4",
    userProfile: "https://images.pexels.com/photos/415829/pexels-photo-415829.jpeg",
    shareCount: 63,
    ismuted:true,
    caption: "Street fashion lookbook 💃✨"
  }
];
var allReels = document.querySelector('.all-reels')


function addData() {
  var sum = ''
  reels.forEach(function (elem, idx) {
    sum = sum + `<div class="reel">
          <video autoplay loop ${elem.ismuted ? 'muted' : ''} src="${elem.video}"></video>
          <div class="mute" id=${idx}>
          ${elem.ismuted?'<i class="ri-volume-mute-fill"></i>':'<i class="ri-volume-up-line"></i>'}
      
    </div>
          <div class="bottom">
            <div class="user">
              <img
                src="${elem.userProfile}"
                alt="">
              <hismuted:true,4>${elem.
        username}</h4>
              <button id=${idx} class='follow'>${elem.isFollowed ? 'Unfollow' : 'Follow'}</button>
            </div>
            <h3>${elem.caption}</h3>
          </div>
          <div class="right">
            <div id=${idx} class="like">
              <h4 class="like-icon icon">${elem.isLiked ? '<i class="love ri-heart-3-fill"></i>' : '<i class="ri-heart-3-line"></i>'}</h4>
              <h6>${elem.likeCount}</h6>
            </div>
            <div class="comment">
              <h4 class="comment-icon icon"><i class="ri-chat-3-line"></i></h4>
              <h6>${elem.commentCount}</h6>
            </div>
            <div class="share">
              <h4 class="share-icon icon"><i class="ri-share-forward-line"></i></h4>
              <h6>${elem.shareCount}</h6>
            </div>
            <div class="menu">
              <h4 class="menu-icon icon"><i class="ri-more-2-fill"></i></h4>
            </div>
          </div>
        </div>`
  })

  allReels.innerHTML = sum
}

addData()


allReels.addEventListener('click', function (dets) {

  if (dets.target.className == 'like') {
    if (!reels[dets.target.id].isLiked) {
      reels[dets.target.id].likeCount++
      reels[dets.target.id].isLiked = true
    } else {
      reels[dets.target.id].likeCount--
      reels[dets.target.id].isLiked = false
    }

    addData()
  }
  if (dets.target.className == 'follow') {
    if (!reels[dets.target.id].isFollowed) {
      reels[dets.target.id].isFollowed = true
    } else {
      reels[dets.target.id].isFollowed = false
    }

    addData()
  }

 if (dets.target.className == 'mute') {
    if (!reels[dets.target.id].ismuted) {
      reels[dets.target.id].ismuted = true
    } else {
      reels[dets.target.id].ismuted = false
    }
    addData()
  }

})
