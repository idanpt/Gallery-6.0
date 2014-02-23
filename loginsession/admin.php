<?php
include '../config.php';
// Report all errors except E_NOTICE   
error_reporting(E_ALL ^ E_NOTICE);
session_start();
if($_SESSION['username']){
	echo "<h2>Welcome, " . $_SESSION['username'] . "!</h2>";?>
		
	<h3>What do you want to do?</h3>
	<a href="admin.php?action=delete">Delete something</a><br>
	<a href="admin.php?action=organize">Organize data/users</a><br>
	<a href="admin.php?action=statistics">Get statistics</a><br>
	<a href="../index.php">Go to gallery</a><br>
	<a href="logout.php">Log out</a>
	<?php
	if($_GET['action']=="delete"){
		   //The delete page:
		echo "<h2>Click an image to delete it</h2>";
		$sql = "SELECT * FROM $tbl_name ORDER BY mid DESC";
		$qur=mysql_query($sql);
		
		 while ($row = mysql_fetch_array($qur)){ 
			$row_path="../".$row['path'];
		?>
				<div id="admin_imgs" style="display: inline-block">
					<a href="admin.php?action=delete&img=<?php echo $row['path'];?>" title="<?php echo $row['caption'];?>">
						<img src="<?php echo $row_path?>" height="220px" width="220px"/>
					</a>
				</div>
			<?php if($_GET['img']==$row['path']){
						//delete the img from db
						$selected_img=$row['path'];
						$delete_qur="DELETE FROM $tbl_name WHERE path = '$selected_img' ";
						$result=mysql_query($delete_qur)or die(mysql_error());
						if($result){
							$img_delete=$row['path'];
							echo "$img_delete";
							$delete_file=unlink('../' . $img_delete);
							if ($delete_file) {
								echo "File deleted";
								echo "<script>alert('The image " . $img_delete . "was deleted from database and folder')
							window.location.href='admin.php?action=delete'</script>";
							}
							//$selected_img=basename($selected_img);
						}
					}
		}
	}
	if($_GET['action']=="statistics"){
		//get_statistic page:
		echo "Number of users:";
		echo "Number of images";
		echo "images per photographer";
	}
	
	
	
	
	
	
	
	
}else{
	echo "You must be logged in!<br>";
	
	include 'login.php';
}

?>