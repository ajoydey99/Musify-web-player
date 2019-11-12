<?php
	
	include("includes/includedFiles.php");
?>

	<div class="playlistContainer">

		<div class="gridViewContainer">
			
			<h2>PLAYLISTS</h2>
			<div class="buttonItems">
				<button class="button" onclick="createPlaylist()">NEW PLAYLISTS</button>
			</div>


		<?php 

			$username = $userLoggedIn->getUsername();
			$playlistQuery = mysqli_query($con, "SELECT * FROM playlists WHERE owner='$username'");

			if(mysqli_num_rows($playlistQuery) == 0) {
				echo "<div class='firstPlaylist'>
						<img src='assets/images/icon/addplaylist.png'>
						<h2 class='noResult'>Create your first playlist<h2>
					</div>";
			}


			while ($row=mysqli_fetch_array($playlistQuery)) {

				$playlist = new Playlist($con, $row);

				echo "<div class='gridViewItem' role='link' onclick='openPage(\"playlist.php?id=" . $playlist->getId() . "\")' style='margin-top: 30px'>

							<div class='playlistImage'>
								<img src='assets/images/icon/playlist.jpg' style='opacity: 0.8'>
							</div>
							
							<div class='gridViewInfo'>"
								. $playlist->getName() .
							"</div>

					</div>"; 

			}

		?>





		</div>
	</div>

<script>
	
	$("body").css({"background": "linear-gradient(to right, #29323c, #485563)"});
	document.title = "Your Music - Playlists";

</script>