<?php
session_start();
$username=$_POST['username'];
$password=$_POST['password'];

if($username&&$password){
	$connect=mysql_connect("localhost", "root", "") or die ('couldnt connect');
	mysql_select_db('phpimage')or die ("couldnt find db");
	
	$query= mysql_query("SELECT * FROM users WHERE username='$username'")or die (mysql_error());
	
	$numrows=mysql_num_rows($query) or die (mysql_error());
	
	if(!$numrows==0){
		//code to login
		while ($row=mysql_fetch_assoc($query)){
			$dbusername=$row['username'];
			$dbpassword=$row['password'];
		}
		//check to see if they match
		
		if($username==$dbusername&&md5($password)==$dbpassword){
			echo "You're in! <a href='admin.php'>click here</a> to enter the members page";
			$_SESSION['username']=$dbusername;
		}else{
			"incorret password";
		}
		
	}else{
		die('that user doesnt exsist!');
	}
	
}else{
	die("please enter a username and a password");
}




?>