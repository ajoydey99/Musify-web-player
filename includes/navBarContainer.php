<div id="navBarContainer">
	<nav class="navBar">

		<span role="link" onclick="openPage('index.php')" class="logoName">
			<img src="assets/images/icon/logo.png" class="logo" alt="musify-logo">
			<span id="appName">Musify</span>
		</span>	

		<div class="group">

			<div class="navItem" onclick="openPage('home.php')">
				<span role="link" class="navItemLink">Home
					<img src="assets/images/icon/home.png" class="home" alt="home">
				</span>
			</div>

			<div class="navItem mySearch" onclick="openPage('search.php')">
				<span role="link" class="navItemLink">Search
					<img src="assets/images/icon/search.png" class="search" alt="search">
				</span>
			</div>	

			<div class="navItem" onclick="openPage('yourMusic.php')">
				<span role="link" class="navItemLink">Your music
					<img src="assets/images/icon/library.png" class="library" alt="library">
				</span>
			</div>

		</div>

		<div class="group">	
			<div class="navItem profile" onclick="openPage('profile.php')">
				<span role="link" class="navItemLink"><?php echo $userLoggedIn->getFirstAndLastName(); ?>
					<img src="assets/images/icon/profile_pic.png" class="profile-pic" alt="profile">
				</span>
			</div>
		</div>
		

	</nav>
</div>