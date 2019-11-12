<?php

	$songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");
	$resultArray = array();

	while($row = mysqli_fetch_array($songQuery)) {
		array_push($resultArray, $row['id']);
	}

	$jsonArray = json_encode($resultArray);

?>

<script>
	
	$(document).ready(function() {
		var newPlaylist = <?php echo $jsonArray;  ?>;
		audioElement = new Audio();
		setTrack(newPlaylist[0], newPlaylist, false);
		updateVolumeProgressBar(audioElement.audio);


		$("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {
			e.preventDefault();
		});

		$(".playBackBar .progressBar").mousedown(function() {
			mouseDown = true;
		});

		$(".playBackBar .progressBar").mousemove(function(e) {
			
			if(mouseDown) {
				timeFromOffSet(e, this);
			}

		});

		$(".playBackBar .progressBar").mouseup(function(e) {
			timeFromOffSet(e, this);
		});

		$(".volumeBar .progressBar").mousedown(function() {
			mouseDown = true;
		});

		$(".volumeBar .progressBar").mousemove(function(e) {
			
			if(mouseDown) {
				var percentage = e.offsetX / $(this).width(); 

				if(percentage >=0 && percentage <=1) {
					audioElement.audio.volume = percentage;
				}
			} 

		});

		$(".volumeBar .progressBar").mouseup(function(e) {
			var percentage = e.offsetX / $(this).width(); 

			if(percentage >=0 && percentage <=1) {
				audioElement.audio.volume = percentage;
			}
		});

		$(document).mouseup(function() {
			mouseDown = false;
		});

	});

	function timeFromOffSet(mouse, progressBar) {

		var percentage = mouse.offsetX / $(progressBar).width() * 100;
		var seconds = audioElement.duration() * (percentage / 100); 
		audioElement.setTime(seconds);

	}

	function setTrack(trackId, newPlaylist, play) {

		if(newPlaylist != currentPlaylist) {
			currentPlaylist = newPlaylist;
			shufflePlaylist = currentPlaylist.slice();
			shuffleArray(shufflePlaylist);
		}
		
		if(shuffle) {
			currentIndex = shufflePlaylist.indexOf(trackId);
		}
		else {
			currentIndex = newPlaylist.indexOf(trackId);
		}


		$.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function(data) { 

			var track = JSON.parse(data); 
			audioElement.setTrack(track);
			$(".trackInfo .trackName span").text(track.title);


			$.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(data) {  

				var artist = JSON.parse(data);
				
				if(track.feature == null) {

					$(".trackInfo .artistName span").text(artist.name);
					$(".trackInfo .artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id + "')");
				}
				else {
					$(".content .trackInfo .artistName span").text(artist.name + " " + track.feature);
					$(".content .trackInfo .artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id + 
						"')");
				}

			});

			$.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function(data) {  

				var album = JSON.parse(data); 
				$(".albumLink img").attr("src", album.artworkPath);
				$(".albumLink img").attr("onclick", "openPage('album.php?id=" + album.id + "')");

			});

			if(play) {
				playSong();
			}

		});
	}

	function playSong() {

		if(audioElement.currentTime() === 0) {
			$.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
		}

		$(".controlButton.play").hide();
		$(".controlButton.pause").show();
		audioElement.play();
	}

	function pauseSong() {
		$(".controlButton.pause").hide();
		$(".controlButton.play").show();
		audioElement.pause();
	}

	function nextSong() {

		repeat = false;
		$(".controlButton.repeat img").attr({ src: "assets/images/icon/repeat.png" });

		playSong();

		if(currentIndex === currentPlaylist.length - 1) {
			currentIndex = 0;
		}
		else {
			currentIndex++;
		}

		var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
		setTrack(trackToPlay, currentPlaylist, true);
	}

	function previousSong() {

		if(audioElement.currentTime() >= 3 || currentIndex == 0) {
			audioElement.setTime(0);
		}
		else {
			currentIndex--;
			setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
		}

	}

	function repeatPlay() {
		if(repeat) {
			audioElement.setTime(0);
			playSong();
			return;
		}
	}

	function repeatSong() {

		repeat = !repeat;

		var imageName = repeat ? "repeat-active.png" : "repeat.png"
		var repeatTitle = repeat ? "Disable repeat" : "Enable repeat"
		$(".controlButton.repeat img").attr({ src: "assets/images/icon/"+imageName, title: repeatTitle });

	}

	function muteSong() {

		audioElement.audio.muted = !audioElement.audio.muted;

		var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
		$(".controlButton.volume img").attr({ src: "assets/images/icon/" + imageName});
	}

	function shuffleSong() {

		shuffle = !shuffle;

		var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
		var repeatTitle = shuffle ? "Disable shuffle" : "Enable shuffle"
		$(".controlButton.shuffle img").attr({ src: "assets/images/icon/" + imageName, title: repeatTitle });


		if(shuffle) {

			shuffleArray(shufflePlaylist)
			currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);

		}
		else {
			currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
		}

	}

	function shuffleArray(array) {
	    for (var i = array.length - 1; i > 0; i--) {
	        var j = Math.floor(Math.random() * (i + 1));
	        var temp = array[i];
	        array[i] = array[j];
	        array[j] = temp;
	    }
	}

</script>



<div id="nowPlayingBarContainer">
	<div id="nowPlayingBar">
		
		<div id="nowPlayingLeft">
			<div class="content">
				<span class="albumLink">
					<img src="" role="link" class="albumArtwork">
				</span>

				<div class="trackInfo">
					<span class="trackName">
						<span role="link"></span>
					</span>

					<span class="artistName">
						<span role="link"></span>
					</span>
				</div>

			</div>
		</div>
	
		<div id="nowPlayingCenter">
			<div class="content playerControls">
				<div class="buttons">
					
					<button class="controlButton shuffle" title="Enable shuffle" onclick="shuffleSong()">
						<img src="assets/images/icon/shuffle.png" alt="shuffle">
					</button>

					<button class="controlButton previous" title="Previous" onclick="previousSong()">
						<img src="assets/images/icon/previous.png" alt="previous">
					</button>
					
					<button class="controlButton play" title="Play">
						<img src="assets/images/icon/play.png" alt="play" onclick="playSong()">
					</button>

					<button class="controlButton pause" title="Pause" style="display: none" onclick="pauseSong()">
						<img src="assets/images/icon/pause.png" alt="pause">
					</button>

					<button class="controlButton next" title="Next" onclick="nextSong()">
						<img src="assets/images/icon/next.png" alt="next">
					</button>

					<button class="controlButton repeat" title="Enable repeat" onclick="repeatSong()">
						<img src="assets/images/icon/repeat.png" alt="repeat">
					</button>

				</div>		

				<div class="playBackBar">
					
					<span class="progressTime current">0.00</span>
					<div class="progressBar">
						<div class="progressBarBg">
							<div class="progress"></div>
						</div>
					</div>
					<span class="progressTime remaining">0.00</span>
				</div>

			</div>		
		</div>

		<div id="nowPlayingRight">
			<div class="volumeBar">
				
				<button class="controlButton volume" title="Volume" onclick="muteSong()">
					<img src="assets/images/icon/volume.png" alt="volume">
				</button>
				<div class="progressBar">
					<div class="progressBarBg">
						<div class="progress"></div>
					</div>
				</div>

			</div>
		</div>

	</div>
</div>