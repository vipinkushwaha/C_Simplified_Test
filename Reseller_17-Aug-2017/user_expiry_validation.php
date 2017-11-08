<?php
error_reporting(0);
$conn = mysqli_connect("localhost","root","","vipin");
$cust_id = $_POST['cust_id'];
//$date_from = date("Y-m-d 00:00:00", strtotime($created_approved1));
					
$expiry_date_user = date("ymdhis", strtotime($_POST['expiry_user']));
$query = mysqli_query($conn, "select * from cust_master where cust_id='$cust_id'");
$res = mysqli_fetch_array($query);
$expiry_res = date("d/m/Y", strtotime($res['expired_on']));

$expiry = date("ymdhis", strtotime($res['expired_on']));
//echo "POST EXPIRY DATE: ".$expiry_date_user."<br>";
//echo "FETCH EXPIRY DATE: ".$expiry;
//echo "$expiry";
if($expiry_date_user > $expiry)
{
	echo "Must be less than $expiry_res.";
}

?>