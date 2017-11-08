<?php
error_reporting(0);
$conn = mysqli_connect("localhost","root","","vipin");
$user_id = $_POST['userid_revoke'];
$creditsrevoke = $_POST['revoke_amount'];
$cust_id = $_POST['custid'];

date_default_timezone_set('Asia/Kolkata');
$created_date = date("y-m-d h:i:s");

$query = mysqli_query($conn, "select * from user_master where user_id='$user_id'");
$res = mysqli_fetch_array($query);
$previous_available_bal = $res['credits_avialable'];
if($previous_available_bal < $creditsrevoke)
{
	echo "<span style='color:red'>You can't revoke amount greater than User Credits Available.</span>";
}
if($previous_available_bal >= $creditsrevoke)
{
	$previous_balance = $res['credits_assigned'];
	$new_credit_amount = $previous_balance - $creditsrevoke;
	$new_credit_available = $previous_available_bal - $creditsrevoke;
	$query2 = mysqli_query($conn, "update user_master set credits_assigned='".$new_credit_amount."',credits_avialable='".$new_credit_available."' where user_id='".$user_id."'");
	if($query2)
	{
		//echo "vipin1";
		$query3 = mysqli_query($conn, "insert into credits_history (userid,credits_revoked,credits_available,created_date) values ('".$user_id."','".$creditsrevoke."','".$new_credit_available."','".$created_date."')");
		if($query3)
		{
			//echo "vipin2";
			$query4 = mysqli_query($conn, "select * from cust_master where cust_id='$cust_id'");
			$res = mysqli_fetch_array($query4);
			$customer_balance = $res['credits_assigned'];
			$cust_new_bal = $customer_balance + $creditsrevoke;
			$query5 = mysqli_query($conn, "update cust_master set credits_assigned='$cust_new_bal' where cust_id='$cust_id'");
			if($query5)
			{
				$query4 = mysqli_query($conn, "insert into customer_credits_history (customerid,credits_revoked,created_date) values ('".$cust_id."','".$creditsrevoke."','".$created_date."')");
				if($query4)
				{
					echo "<span style='color:green'>Credits Revoked Successfully.</span>";
				}
			}
		}
	}
}
?>