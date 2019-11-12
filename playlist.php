<?php 

	include("includes/includedFiles.php");
	
	if(isset($_GET['id'])) {
		$playlistId = $_GET['id'];
	}
	else {
		header("Location: index.php");
	}

	$playlist = new Playlist($con, $playlistId);
	$owner = new User($con, $playlist->getOwner());

?>
	
	<div class="notifyUser">Track was added to your playlist.</div>
	<div class="entityInfo">

		<div class="leftSection">
			<img src="assets/images/icon/playlist.jpg">
		</div>

		<div class="rightSection">
			<h2><?php echo $playlist->getName(); ?></h2>
			<p>By <?php echo "<span style='" . "font-size: 16px;'>" 
				. $playlist->getOwner() . "</span>"; ?></p>

			<?php 

				if($playlist->getSongsNum()<=1) {
					echo "<p style='" . "font-weight: bold; font-size: 14px; letter-spacing: 1px;'>" 
							. $playlist->getSongsNum() . " SONG</p>"; 
				}
				else {
					echo "<p style='" . "font-weight: bold; font-size: 14px; letter-spacing: 1px;'>" 
							. $playlist->getSongsNum() . " SONGS</p>";	
				}
			?>
			<div class="headerButtons">
				<button class="button" onclick="playFirstSong()" title="play">PLAY</button>
				<img src="assets/images/icon/delete.png"  class="delete" title="Delete playlist" 
					onclick="deletePlaylist('<?php echo $playlistId; ?>')">
			</div>
		</div>

	</div>

	<div class="trackListContainer">
		<ul class="trackList">
			
			<?php

				$songIdArray = $playlist->getSongIds();

				foreach ($songIdArray as $songId) {
					
					$playlistSong = new Song($con, $songId);
					$songArtist = $playlistSong->getArtist();

					echo "<li class='trackListRow'>
							<div class='trackCount'>
								<img class='playSong' src='assets/images/icon/play-white.png' alt='play' title='PLAY' onclick='setTrack(\"". $playlistSong->getId() ."\", tempPlaylist, true)'>
								<img class='bullet' src='assets/images/icon/bullet.png'>
							</div>

							<div class='trackInfo'>
								<span class='trackName'>" . $playlistSong->getTitle() . "</span>
								<span class='artistName'>" . $songArtist->getName() . " " . $playlistSong->getFeature() . "</span> 
							</div>

							<div class='trackOption'>
							<input type = 'hidden' class='songId' value='" . $playlistSong->getId() . "'>
								<img class='optionButton' src='assets/images/icon/more.png' onclick='showOptionMenu(this)'>
							</div>

							<div class='trackDuration'>
								<span class='duration'>" . $playlistSong->getDuration() . "</span>
							</div>
						</li>";

				}

			?>

			<script>

				var tempSongIds = '<?php echo json_encode($songIdArray); ?>'; 
				tempPlaylist = JSON.parse(tempSongIds);

				$("body").css({"background": "linear-gradient(to right, #2C5364, #203A43, #0F2027)"});
				document.title = "<?php echo $playlist->getName(); ?>";
				
			</script> 

		</ul>
	</div>

	<nav class="optionMenu">
		<input type="hidden" class="songId">
		<?php echo Playlist::getPlaylistDropdown($con, $userLoggedIn->getUsername()); ?>
		<div class="item" onclick="removeFromPlaylist(this, '<?php echo $playlistId; ?>')">Remove from this Playlist</div>
	</nav>

