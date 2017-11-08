<?php
error_reporting(0);
$conn = mysqli_connect("localhost","root","","vipin");
$user_id = $_POST['userid_credit'];
$creditsassigned = $_POST['credit_amount'];
$cust_id = $_POST['custid'];
//echo "$cust_id";
//echo "select * from cust_master where cust_id='$cust_id'";
$query4 = mysqli_query($conn, "select * from cust_master where cust_id='$cust_id'");
$res = mysqli_fetch_array($query4);
$customer_balance = $res['credits_assigned'];
//echo "$customer_balance";
if($creditsassigned > $customer_balance)
{
	echo "Insufficient Credits in your Account.";
}
if($creditsassigned <= $customer_balance)
{
	$cust_new_bal = $customer_balance - $creditsassigned;
	$query5 = mysqli_query($conn, "update cust_master set credits_assigned='$cust_new_bal' where cust_id='$cust_id'");
	if($query5)
	{
		
		$query = mysqli_query($conn, "select * from user_master where user_id='$user_id'");
		if($query)
		{
			
			$res = mysqli_fetch_array($query);
			$previous_credit_bal = $res['credits_assigned'];
			$new_credit_amount = $creditsassigned + $previous_credit_bal;
			$previous_available_bal = $res['credits_avialable'];
			$new_credit_available = $previous_available_bal + $creditsassigned;
			$query2 = mysqli_query($conn, "update user_master set credits_assigned='".$new_credit_amount."',credits_avialable='".$new_credit_available."' where user_id='".$user_id."'");
			if($query2)
			{
				
				date_default_timezone_set('Asia/Kolkata');
				$created_date = date("Y-m-d H:i:s");
				//echo "insert into credits_history (userid,credits_recharged,credits_available,created_date) values ('".$user_id."','".$creditsassigned."','".$new_credit_available."','".$created_date."')";
				$query3 = mysqli_query($conn, "insert into credits_history (userid,credits_recharged,credits_available,created_date) values ('".$user_id."','".$creditsassigned."','".$new_credit_available."','".$created_date."')");
				if($query3)
				{
					$query4 = mysqli_query($conn, "insert into customer_credits_history (customerid,credits_recharged,created_date) values ('".$cust_id."','-".$creditsassigned."','".$created_date."')");
					if($query4)
					{
						echo "Credits Assigned Successfully.";						
					}

				}
			}
		}
	}
}
?>