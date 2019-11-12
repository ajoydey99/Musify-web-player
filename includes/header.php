<?php

	include("includes/config.php");
	include("includes/classes/User.php");
	include("includes/classes/Artist.php");	
	include("includes/classes/Album.php");
	include("includes/classes/Song.php");
	include("includes/classes/Playlist.php");
	//session_destroy();

	if(isset($_SESSION['userLoggedIn'])) {
		$userLoggedIn = new User($con, $_SESSION['userLoggedIn']);
		$username = $userLoggedIn->getUsername();
		echo "<script> userLoggedIn = '$username'; </script>";
	}
	else {
		header("Location: register.php");
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Musify</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Bree+Serif&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Acme&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Luckiest+Guy&display=swap" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/script.js"></script>
</head>
<body>
	
	<div id="mainContainer">

		<div id="topContainer">
			
			<?php include("includes/navBarContainer.php"); ?>

			<div id="mainViewContainer">
				<div id="mainContent">