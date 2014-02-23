<?php
include('config.php');
include 'functions.php';

$make_pages=make_pages();  //configure pagination of mysql query
?>

<!doctype html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Gallery 6.0</title>
	<link href="lightbox/css/lightbox.css" rel="stylesheet" />
	<link type="text/css" rel="stylesheet" href="css/mystyle.css" />
	<script src="lightbox/js/jquery-1.10.2.min.js"></script>
	<script src="lightbox/js/lightbox-2.6.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="jquery-data-load-while-scroll/js/jquery-ias.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
        	// Infinite Ajax Scroll configuration
            jQuery.ias({
                container : '#gallery', // main container where data goes to append
                item: '.item', // single items
                pagination: '.nav', // page navigation
                next: '.nav a', // next page selector
                loader: '<img src="jquery-data-load-while-scroll/css/ajax-loader.gif"/>', // loading gif
                triggerPageThreshold: 3 // show load more if scroll more than this
            });
        });
    </script>
</head>
<body>
<div class="wrap">
	<header>
		
		<h1>Main Gallery</h1>

 
		<ul>
	<a href="upload.form.php" id="backlink"><li>Upload</li></a>
<li>filter by photographer
	<ul>
<?php

$photographers= get_photographers();      //function to check db for photographers
$counts=array_count_values($photographers);
$photographers=array_unique($photographers);
foreach ($photographers as $key => $value) {
			         // add links for spasific photographer
	?> <a href="index.php?photographer=<?php echo $value;?>">
		<h5><li>show only <?php echo $value;?>'s pics <?php echo "(" . $counts[$value] . ")";?></li></h5></a>
		<?php 
				 ?>
<?php }?> </ul> 
	</li><?php
if(isset($_GET['photographer'])){
	?> <a href="index.php"><li>Back to main gallery</li></a>
<?php }

	?>
	<a href="loginsession/admin.php" id="admin_link"><li>Im the admin BIATCH</li></a>
</ul>
</header>
<?php		
if (isset($_GET['photographer'])) {        // if a spacific photographer link pressed - 
	$photographer=$_GET['photographer'];
	                                       //show images from chosen photographer
	?>
	<div id="gallery">                     
	<?php $imgsfrompht=imgsfrompht(); ?>
</div>
	<?php
}else{                                     // defult case - show all images
?>
<div id="gallery">
	<?php $get_pages=get_pages(); ?>
</div>

<?php }
mysql_close();
?>
</div><!--.wrap-->
</body>
</html>