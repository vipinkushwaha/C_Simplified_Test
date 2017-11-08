<?php
error_reporting(0);
$conn = mysqli_connect("localhost","root","","vipin");
$user = $_POST['user_id'];
//echo $user;
$query = mysqli_query($conn, "select * from user_master where user_id='$user'");
$count = mysqli_num_rows($query);
//echo $count;
if($count == 0)
{
	echo "&emsp;&emsp;&emsp;<span style='color:green'>Available</span>";
}
else
{
	echo "&emsp;<span style='color:red'>Already Exist</span>";
}
?>
