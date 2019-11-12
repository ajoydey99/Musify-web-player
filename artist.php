<?php 

	include("includes/includedFiles.php");

	if(isset($_GET['id'])) {
		$artistId = $_GET['id'];
	}
	else {
		header("Location: index.php");
	}

	$artist = new Artist($con, $artistId);

?>

	<div class="notifyUser">Track was added to your playlist.</div>
	<div class="poster" style="background: url('<?php echo $artist->getPics(); ?>') no-repeat; 
		background-size: cover;">	
		
		<div class="entityInfo" style="margin-top: 40px;">

			<div class="centerSection">
				<div class="artistInfo">
					
					<h1 class="artistName"><?php echo $artist->getName(); ?></h1>
					<div class="headerButtons">
						<button class="button" onclick="playFirstSong()">PLAY</button>
					</div>

				</div>
			</div>

		</div>
	</div>


	<div class="trackListContainer borderBottom">
		<h2>Popular</h2>
		<ul class="trackList">
			
			<?php

				$songIdArray = $artist->getSongIds();

				$i = 1;
				foreach ($songIdArray as $songId) {

					if($i > 5) {
						break;
					}
					
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

						$i++;

				}

			?>

			<script>

				var tempSongIds = '<?php echo json_encode($songIdArray); ?>'; 
				tempPlaylist = JSON.parse(tempSongIds);
				
			</script> 

		</ul>
	</div>

	

	<div class="gridViewContainer">
		<h2>Albums</h2>
		<?php 

			$albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE artist='$artistId'");

			while ($row=mysqli_fetch_array($albumQuery)) {

				echo "<div class='gridViewItem'>

						<span role='link' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'> 
							<img src='" . $row['artworkPath'] . "'>
							
							<div class='gridViewInfo'>"
								. $row['title'] .
							"</div>

						</span>		  

					</div>"; 

			}

		?>

	</div>

	<nav class="optionMenu">
		<input type="hidden" class="songId">
		<?php echo Playlist::getPlaylistDropdown($con, $userLoggedIn->getUsername()); ?>
	</nav>

<script>
	
	$("body").css({"background": "linear-gradient(to right, #605C3C, #3C3B3F)"});
	document.title = "<?php echo $artist->getName(); ?>";
	
</script>