<?php
	
	include("includes/includedFiles.php");

	if(isset($_GET['term'])) {
		$term = urldecode($_GET['term']);
	}
	else {
		$term = "";
	}	

?>

	<div class="searchContainer">
		
		<input type="text" class="searchInput" value="<?php echo $term; ?>" placeholder="Start typing...">

	</div>


	<div class="searchInfo">
		<h2>Search Musify</h2>
		<span>Find your favorite songs, artists or albums.</span>
	</div>

<script>

	//$(".searchInput").focus();

	var noSongFound = false;
	var noArtistFound = false;
	var noAlbumFound = false;
		

	$("body").css({"background": "linear-gradient(to right, #414345, #232526)"});
	document.title = "Search";

	$(function() {

		$(".searchInput").keyup(function() {
			clearTimeout(timer);

			var val = $(".searchInput").val();

			timer = setTimeout(function() {	
				result = val;
				openPage("search.php?term="+val);
			}, 2000);

			if(val.length > 0) {
				$(".searchInfo").hide();
			}

		})

	})

	
</script>

<?php 

	if($term=="") {
		exit();
	}
	
?>

	<div class="trackListContainer borderBottom">
		<h2>Top results</h2>
		<ul class="trackList">
			
			<?php

				$songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '$term%' LIMIT 10");

				if(mysqli_num_rows($songsQuery) == 0) {
					echo "<script>
							$('.trackListContainer').hide();
							noSongFound = true;
						</script>";
				}

				$songIdArray = array();

				$i = 1;
				while($row = mysqli_fetch_array($songsQuery)) {

					if($i > 15) {
						break;
					}
					
					array_push($songIdArray, $row['id']);

					$albumSong = new Song($con, $row['id']);
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



	<div class="artistsContainer borderBottom">
		
		<h2>Artists</h2>

		<?php

			$artistQuery = mysqli_query($con, "SELECT id FROM artists WHERE name LIKE '$term%' LIMIT 10");


			if(mysqli_num_rows($artistQuery) == 0) {
				echo "<script>
						$('.artistsContainer').hide();
						noArtistFound = true;
					</script>";
			}

			while($row = mysqli_fetch_array($artistQuery)) {

				$artistFound = new Artist($con, $row['id']);

				echo "<div class='searchResultRow' role='link' 
							onclick='openPage(\"artist.php?id=" .$artistFound->getId() . "\")'>
						
						<img src='" . $artistFound->getPics() . "'>
						<div class='artistName'>
							<span>"

								. $artistFound->getName() .

							"</span>
						
						</div>

					</div>";

			}

		?>

	</div>

	<div class="gridViewContainer">
		<h2>Albums</h2>
		<?php 

			$albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE title LIKE '$term%' LIMIT 10");

			if(mysqli_num_rows($albumQuery) == 0) {
				echo "<script>
						$('.gridViewContainer').hide();
						noAlbumFound = true;
					</script>";
			}


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
	
	if(noSongFound && noArtistFound && noAlbumFound) {
		$(".searchInfo h2").text("No results found for \"" + result + "\"");
		$(".searchInfo span").text("Please make sure your words are spelled correctly or use less or different keywords.");
	}
	else {
		$(".searchInfo").hide();
	}
	
</script>