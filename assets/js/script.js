var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;
var timer;
var result = "";


function notifyUser() {
	$(".notifyUser").fadeIn(500);

	setTimeout(fade_out, 3000);

	function fade_out() {
  		$(".notifyUser").fadeOut().empty();
	}
}

$(document).click(function(click){
	var target = $(click.target);

	if(!target.hasClass("item") && !target.hasClass("optionButton")) {
		hideOptionMenu();
	}

});

$(window).scroll(function(){
	hideOptionMenu();
});

$(document).on("change", "select.playlist", function() {

	var select = $(this);
	var playlistId = select.val()
	var songId = select.prev(".songId").val();

	$.post("includes/handlers/ajax/addtoplaylist.php", { playlistId: playlistId, songId: songId })
	.done(function(error) {

		if(error != "") {
			alert(error);
			return;
		}

		notifyUser();
		hideOptionMenu();
		select.val("");
	});

});


function playFirstSong() {
	setTrack(tempPlaylist[0], tempPlaylist, true);
}
 

function createPlaylist() {

	var popup = prompt("Please enter the name of your playlist.");
	console.log(popup);

	if(popup != null && popup != "") {

		$.post("includes/handlers/ajax/createPlaylist.php", { name: popup, username: userLoggedIn })
		.done(function(error) {

			if(error != "") {
				alert(error);
				return;
			}
			openPage("yourMusic.php");

		}); 
	}
	else {
		alert("Playlist name can't be blank.");
	}
} 

function deletePlaylist(playlistId) {
	var decision = confirm("Are you sure you want to delete this playlist.");

	if(decision) {
		$.post("includes/handlers/ajax/deletePlaylist.php", { playlistId: playlistId })
		.done(function(error) {

			if(error != "") {
				alert(error);
				return;
			}
			openPage("yourMusic.php");

		}); 
	}
}

function removeFromPlaylist(button, playlistId) {
	var songId = $(button).prevAll(".songId").val();

	$.post("includes/handlers/ajax/removeFromPlaylist.php", { playlistId: playlistId, songId: songId })
	.done(function(error) {

		if(error != "") {
			alert(error);
			return;
		}
		openPage("playlist.php?id="+playlistId);

	}); 
}

function openPage(url) {

	clearTimeout(timer);
	
	if(url.indexOf("?") == -1) {
		url = url + "?";
		
	}
	
	var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
	$("#mainContent").load(encodedUrl);
	$("body").scrollTop(0);
	history.pushState(null, null, url);
	
}


function showOptionMenu(button) {
	var songId = $(button).prevAll(".songId").val();
	var menu = $(".optionMenu");
	var menuWidth = menu.width();
	menu.find(".songId").val(songId);

	var scrollTop = $(window).scrollTop();
	var elementOffset = $(button).offset().top;

	var top = elementOffset - scrollTop;
	var left = $(button).position().left;

	menu.css({ "top": top+5 + "px", "left": left + "px", "display": "inline" });
}

function hideOptionMenu() {
	var menu = $(".optionMenu");

	if(menu.css("display") != "none") {
		menu.css("display", "none");
	}

}

function formatTime(sec) {
	var time = Math.round(sec);
	var min = Math.floor(time/60);
	var sec = time-(min*60);
	var extraZero = (sec < 10) ? "0" : "";

	return min + ":" + extraZero + sec; 
}

function updateTimeProgressBar(audio) {
	$(".progressTime.current").text(formatTime(audio.currentTime));

	var progress = audio.currentTime / audio.duration * 100;
	$(".playBackBar .progress").css("width", progress+"%");
}

function updateVolumeProgressBar(audio) {
	var volume = audio.volume * 100;

	if(audio.muted){
		$(".volumeBar .progress").css("width", "0%");	
	}
	else {
		$(".volumeBar .progress").css("width", volume+"%");
	}
}

function logout() {
	$.post("includes/handlers/ajax/logout.php", function() {
		location.reload();
	});
}

function Audio() {

	this.currentlyPlaying;
	this.audio = document.createElement('audio');

	this.audio.addEventListener('canplay', function() {
		var duration = formatTime(this.duration)
		$(".progressTime.remaining").text(duration);
	});

	this.audio.addEventListener('timeupdate', function() {
		if(this.duration) {
			updateTimeProgressBar(this);
		}
	});

	this.audio.addEventListener('volumechange', function() {
		updateVolumeProgressBar(this);
	});

	this.audio.addEventListener('ended', function() {
		if(repeat) {
			repeatPlay();
		}
		else {
			nextSong();
		}
	});	

	this.setTrack = function(track) {
		this.currentlyPlaying = track;
		this.audio.src = track.path;
	}

	this.play = function() {
		this.audio.play().catch(function(){});
	}

	this.pause = function() {
		this.audio.pause();
	}

	this.duration = function() {
		return this.audio.duration;
	}	

	this.currentTime = function() {
		return this.audio.currentTime;
	}

	this.setTime = function(sec) {
		this.audio.currentTime = sec;
	}

}