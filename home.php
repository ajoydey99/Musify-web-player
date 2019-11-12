<?php 
	include("includes/includedFiles.php");
?>
					
<h1 class="pageHeading">You Might Also Like</h1>

<div class="gridViewContainer">
	
	<?php 

		$albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY rand() LIMIT 10");

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

<script>
	
	$("body").css({"background": "linear-gradient(to right, #243b55, #141e30)"}); 
	document.title = "Home";
	
</script>