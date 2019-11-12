<?php 

	include("includes/includedFiles.php");
	
	if(isset($_GET['id'])) {
		$albumId = $_GET['id'];
	}
	else {
		header("Location: index.php");
	}

	$album = new Album($con, $albumId);
	$artist = $album->getArtist();
	$artistId = $artist->getId();

?>

	<div class="notifyUser">Track was added to your playlist.</div>
	<div class="entityInfo">

		<div class="leftSection">
			<img src="<?php echo $album->getArtworkPath(); ?>">
		</div>

		<div class="rightSection">
			<h2><?php echo $album->getTitle(); ?></h2>
			<p onclick="openPage('artist.php?id=<?php echo $artistId ?>')" class="artistLink">By <?php echo "<span style='" . "font-size: 16px;'>" 
				. $artist->getName() . "</span>"; ?></p>

			<?php 

				if($album->getSongsNum()<=1) {
					echo "<p style='" . "font-weight: bold; font-size: 14px; letter-spacing: 1px;'>" 
							. $album->getSongsNum() . " SONG</p>"; 
				}
				else {
					echo "<p style='" . "font-weight: bold; font-size: 14px; letter-spacing: 1px;'>" 
							. $album->getSongsNum() . " SONGS</p>";	
				}
			?>
			<div class="headerButtons">
				<button class="button" onclick="playFirstSong()" title="play album">PLAY</button>
			</div>
		</div>

	</div>

	<div class="trackListContainer">
		<ul class="trackList">
			
			<?php

				$songIdArray = $album->getSongIds();

				foreach ($songIdArray as $songId) {
					
					$albumSong = new Song($con, $songId);
					$albumArtist = $albumSong->getArtist();

					echo "<li class='trackListRow'>
							<div class='trackCount'>
								<img class='playSong' src='assets/images/icon/play-white.png' alt='play' title='PLAY' onclick='setTrack(\"". $albumSong->getId() ."\", tempPlaylist, true)'>
								<img class='bullet' src='assets/images/icon/bullet.png'>
							</div>

							<div class='trackInfo'>
								<span class='trackName'>" . $albumSong->getTitle() . "</span>
								<span class='artistName'>" . $albumArtist->getName() . " " . $albumSong->getFeature() . "</span> 
							</div>

							<div class='trackOption'>
							<input type = 'hidden' class='songId' value='" . $albumSong->getId() . "'>
								<img class='optionButton' src='assets/images/icon/more.png' onclick='showOptionMenu(this)'>
							</div>

							<div class='trackDuration'>
								<span class='duration'>" . $albumSong->getDuration() . "</span>
							</div>
						</li>";

				}

			?>

			<script>

				var tempSongIds = '<?php echo json_encode($songIdArray); ?>'; 
				tempPlaylist = JSON.parse(tempSongIds);

				$("body").css({"background": "linear-gradient(to right, #2C5364, #203A43, #0F2027)"});
				document.title = "<?php echo $album->getTitle(); ?>";
				
			</script> 

		</ul>
	</div>

	<nav class="optionMenu">
		<input type="hidden" class="songId">
		<?php echo Playlist::getPlaylistDropdown($con, $userLoggedIn->getUsername()); ?>
	</nav>
