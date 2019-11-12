<?php
	
	include("includes/includedFiles.php");

?>


<div class="profileInfo">
	<div class="entityInfo">

		<div class="centerSection">
			<div class="userInfo">
				
				<div class="profileImage" style="background: url('assets/images/profile-pics/head_emerald.png') center; 
				background-size: cover;"></div>
				<h1><?php echo $userLoggedIn->getFirstAndLastName(); ?></h1>

			</div>

			<div class="buttonItems">
				<button class="button" onclick="openPage('showDetails.php')">VIEW ACCOUNT</button>
				<button class="button" onclick="openPage('yourMusic.php')">YOUR PLAYLISTS</button>
				<button class="button" onclick="logout()">LOG OUT</button>	
			</div>

		</div>


	</div>
</div>

<script>
	
	$("body").css({"background": "#181818"}); 
	document.title = "<?php echo $userLoggedIn->getFirstAndLastName(); ?>" + " - Profile";
	
</script>
