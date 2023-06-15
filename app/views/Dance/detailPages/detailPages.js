var audio = new Audio("/../images/Dance/audio/copyright_free.mp3");
var isPlaying = false;
var isMuted = false;

function playPause() {
  if (isPlaying) {
    audio.pause();
    isPlaying = false;
  } else {
    audio.play();
    isPlaying = true;
  }
}

function muteUnmute() {
  if (isMuted) {
    audio.muted = false;
    isMuted = false;
  } else {
    audio.muted = true;
    isMuted = true;
  }
}

function redirectToTimeTable() {
  window.location.href = "http://localhost/MainDance/danceTimeTables";
}
