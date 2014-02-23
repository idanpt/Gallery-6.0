<html>
	
	<head>
	<link type="text/css" rel="stylesheet" href="css/upload_page_style.css" />
	</head>
	<body>
		
		<div id="upload_form">
			<form enctype="multipart/form-data" action="" method="POST">
				<table width="400px">
				<tr>
			    	<td>Choose an image to upload (or drag one over here):</td>
					<td><input name="uploadedfile" type="file" multiple="multiple" accept="image/*" /></td>
				</tr>
				<tr>
				<td>Caption it:</td>
				<td><input type="text" name="caption" /></td></tr>
				<tr><td>Photographer:<select name="pht_name">  
				 	<option value="Yossi">Yossi</option>
				 	<option value="Idan">Idan</option>
				 	<option value="Inna">Inna</option>
				 	<option value="other">Other--></option>
					</select></td>
					<td><input type="text" placeholder="Other" name="other_pht" /></td></tr><p>
				<tr><td><input type="submit" value="Upload File" name="submit" /></td></tr>
				</table>
			</form>
		</div>
		<a href="loginsession/login.php">Admin acsses</a>
		<?php 

		
if(isset($_POST['submit'])){
//move tmp file to /uploads folder and validate duplicity and file type
include('config.php');            //db info
include 'functions.php';
//defining vars 
$target_path = "uploads/";            
$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 
$name=basename($_FILES['uploadedfile']['name']);
$pht_name=$_POST['pht_name'];
if ($pht_name=="other") {
	$pht_name=$_POST['other_pht'];
}
$caption=$_POST['caption'];

function val_image($t_name){          // function to validate the file type
	$t_name=($_FILES['uploadedfile']['tmp_name']);	
	$img_size=getimagesize($t_name);
	$valid_types= array('image/gif', 'image/jpeg', 'image/png', 'image/bmp');
	if (!$img_size) {
		return 0;
		}else{

	if(in_array($img_size['mime'], $valid_types)){
		return 1;
	}else{
		return 0;
		}
			}
}
	
if (val_image($name)==0) {
	echo "<script>
	alert('This file is not an image');
	</script>";
}else{
// exsisting validation
if (!file_exists($target_path)) {
		//if it doesnt exist - move the file to /uploads folder
	$move_uploaded_file=move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);

	$delete_from_db = delete_missing_images(); //check the database for missing file paths and deletes them
	
	if($move_uploaded_file) {
		$qur="insert into image (mid, cid, name, path, photographer, caption) 
		values ('', '','$name','uploads/$name','$pht_name', '$caption') ";
		$res=mysql_query($qur,$link);
    echo "<script>
    alert('The file $name has been uploaded');
    window.location.href='index.php';
    </script>";
	
	}else{ echo "<script>
    alert('There was an error uploading the file, please try again!');
    </script>";
		}
}else{ echo "<script>
    alert('the file already exists in the gallery');
    </script>";
		}
	}
}
?>
	
	</body>
</html>