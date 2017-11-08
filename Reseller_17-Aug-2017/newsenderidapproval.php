<?php
$conn = mysqli_connect("localhost","root","","vipin");
$user_id = $_POST['userid'];
$cust_id = $_POST['custid'];
$sender_id = $_POST['senderid'];
$account_type = $_POST['accounttype'];
date_default_timezone_set('Asia/Kolkata');
$createddate = date("Y-m-d H:i:s");
if(!empty($user_id) && !empty($sender_id) && !empty($account_type))
{
	$query3 = mysqli_query($conn, "select * from user_master where user_id='$user_id' and user_status='1'");
	$count3 = mysqli_num_rows($query3);
	if($count3 == 1)
	{
		$query = mysqli_query($conn, "select * from sender_id where user_id='$user_id' AND sender_id='$sender_id'");
		$count = mysqli_num_rows($query);
		if($count == 0)
		{
			$query2 = mysqli_query($conn, "insert into sender_id (user_id,cust_id,sender_id,account_type,created_on) values ('$user_id','$cust_id','$sender_id','$account_type','$createddate')");
			if($query2)
			{
				echo "Data Inserted Successfully.";
			}
		}
		elseif($count > 0)
		{
			echo "Sender Id Already Exist.";
		}
	}
	else
	{
		echo "User Id is Inactive.";
	}
}

?>