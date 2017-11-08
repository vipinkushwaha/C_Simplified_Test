<!DOCTYPE html>
<html >
<head>
<meta charset="UTF-8">
<title>Reseller Login Form</title>
<link rel="icon" type="image/png" href="image/icon.png" />

<link rel="stylesheet" href="css/style.css">
</head>
<body>
  <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
<form method="post">
  <h4>Reseller Login <sub style="font-size:12px">(&beta;eta)</sub></h4>
  <input class="name" name="cust_id" type="text" placeholder="Enter Username"/>
  <input class="pw" name="pwd" type="password" placeholder="Enter Password"/>
  <!--<li><a href="#">Forgot your password?</a></li>-->
   <?php
	error_reporting(0);
	session_start();
	if(isset($_SESSION['use']))   // Checking whether the session is already there or not if 
								  // true then header redirect it to the home page directly 
	{
		header("Location:index.php"); 
	}
	$conn = mysqli_connect("localhost","root","","vipin");
	$custid = $_POST['cust_id'];
	$pwd = $_POST['pwd'];
	if(isset($_POST['btn_submit']))
	{
		$query = mysqli_query($conn, "select * from cust_master where cust_id='$custid'");
		$res = mysqli_fetch_array($query);
		date_default_timezone_set('Asia/Kolkata');
		$date_today = date("ymd");
		$expiry_cust = date("ymd", strtotime($res['expired_on']));
		//$message = $expiry_cust;
		//$message = $expiry_cust;
		if($date_today <= $expiry_cust)
		{
			$query2 = mysqli_query($conn, "select * from cust_master where cust_id='$custid' and cust_password='$pwd'");
			$count = mysqli_num_rows($query2);
			if($count == 1)
			{
				$_SESSION['use'] = $custid;
				header("Location:dashboard.php");
			}
			else
			{
				$message="<center style='color:red;'>INCORRECT USERID OR PASSWORD.</center>";
			}
		}
		else
		{
			$message = "<center style='color:red;'>Your Account had been Expired contact Admin.</center>";
			$query3 = mysqli_query($conn, "update user_master set user_status='0' where cust_id='$custid'");
		}
	}
	echo "$message";
  ?>
  <input class="button" name="btn_submit" type="submit" value="Log in"/>
</form>
</body>
</html>
