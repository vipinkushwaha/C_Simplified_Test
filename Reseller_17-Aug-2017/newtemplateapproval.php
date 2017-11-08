<?php
$conn = mysqli_connect("localhost","root","","vipin");
error_reporting(0);
$user_id = $_POST['userid'];
$cust_id = $_POST['custid'];
$sender_id = $_POST['senderid'];
$template_app = $_POST['template'];
date_default_timezone_set('Asia/Kolkata');
$createddate = date("Y-m-d H:i:s");
if(!empty($user_id))
{
	$query3 = mysqli_query($conn, "select * from user_master where user_id='$user_id' && user_status='1'");
	$count3 = mysqli_num_rows($query3);
	if($count3 == 1)
	{
		//echo "select * from templatemst where userid='$user_id' and senderid='$sender_id' and template='$template_app'";
		$query = mysqli_query($conn, "select * from templatemst where userid='$user_id' and senderid='$sender_id' and template='$template_app'");
		$temp_count = mysqli_num_rows($query);
		//echo $temp_count;
		if($temp_count == '0')
		{
			$query2 = mysqli_query($conn, "insert into templatemst (userid,customerid,template,senderid,created_date) values ('$user_id','$cust_id','$template_app','$sender_id','$createddate')");
			if($query2)
			{
				echo "Data Inserted Successfully.";
			}
		}
		else
		{
			echo "Duplicate Template";
		}
		
	}
	else
	{
		echo "User Id is Inactive.";
	}
}

?>