<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if(!isset($_SESSION['use'])) // If session is not set then redirect to Login Page
{
	header("Location:index.php");  
}
$customer_id = $_SESSION['use'];
if(isset($_POST['logout']))//LogOut button
	{
		session_destroy();
		header("Location:index.php");
	}
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Update User</title>
    <link rel="icon" type="image/png" href="image/icon.png" />

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-homepage.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!--date picker -->
	<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
	<!--date picker -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style type="text/css">
#logout {
    background-color: white; 
    color: black; 
    border: 4px solid #337ab7;
}

#logout:hover {
    background-color: #337ab7;
    color: white;
}
</style>
<script>
//**************Mobile No is integer Validation Logic********************
function mob_validate(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode( key );
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}
//**************Mobile No is integer Validation Logic********************

$(document).ready(function(){
    $('#expired_on').change(function(){
	var expiry = $('#expired_on').val();
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!

	var yyyy = today.getFullYear();
	if(dd<10){
		dd='0'+dd;
	} 
	if(mm<10){
		mm='0'+mm;
	} 
	var today = mm+'/'+dd+'/'+yyyy;
	if(expiry < today)
	{
		alert("Expiry can't be less than present date.");
		$('#expired_on').val("");
		$('#expired_on').focus();
	}else{ $("#buffered").focus(); }
	
	});
});
//**************Expiry Validation Logic********************
$(document).ready(function(){
    $('#expired_on').change(function(){
        var expiryuser = $(this).val();
		var customer_id = $("#customerid").val();
        if(expiryuser){
            $.ajax({
                type:'POST',
                url:'user_expiry_validation.php',
                data:'expiry_user='+expiryuser+'&cust_id='+customer_id,
                success:function(html)
				{
					
                    $('#expiry_label').html(html);
					if(html!="")
					{
						$('#expired_on').val("");
						$('#expired_on').focus();
					}
                }
            }); 
        }
    });
});
//**************Expiry Validation Logic********************
function refresh()
{
	window.open("manage_user.php","_self");
}
//**************Mobile Number Validation Logic********************
function mobilevalidation()
{
	n = document.getElementById("mobile_number").value;
	n_b = document.getElementById("mobile_number");
	if(n.length < 10 && n.length >=1)
	{
		alert("Mobile Number must be of 10 digits.");
		n_b.focus();
	}
}
/*$(document).ready(function(){
    $('#mobile_number').change(function(){
		
	n = document.getElementById("mobile_number").value;
	n_b = document.getElementById("mobile_number");
	
});
});*/
//**************Mobile Number Validation Logic********************
//**************City & state Logic********************
//$(document).ready(function(){
  //  $("#mobile_number").numeric();
//});
$(document).ready(function(){
    $('#state').change(function(){
        var statename = $(this).val();
        if(statename){
            $.ajax({
                type:'POST',
                url:'citystate.php',
                data:'state_name='+statename,
                success:function(html)
				{
                    $('#city').html(html);
                }
            }); 
        }
		else
		{
            $('#city').html('<option value="">Select state first</option>'); 
        }
    });
});
</script>
</head>

<body>
<?php
$conn = mysqli_connect("localhost","root","","vipin");
			$query10 = mysqli_query($conn, "select * from user_master where cust_id='$customer_id'");
			$totalusers = mysqli_num_rows($query10);
			$query12 = mysqli_query($conn, "select * from user_master where cust_id='$customer_id' and user_status='1'");
			$activeusers = mysqli_num_rows($query12);
			$query13 = mysqli_query($conn, "select * from user_master where cust_id='$customer_id' and user_status='0'");
			$inactiveusers = mysqli_num_rows($query13);
			$query14 = mysqli_query($conn, "select * from user_master where cust_id='$customer_id' and user_mode='1'");
			$prepaid = mysqli_num_rows($query14);
			$query15 = mysqli_query($conn, "select * from user_master where cust_id='$customer_id' and user_mode='2'");
			$postpaid = mysqli_num_rows($query15);
			?>
			<!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Reseller Panel <sub style="font-size:12px">(&beta;eta)</sub></a>
            </div>
			
			<div class="collapse navbar-collapse" style="text-align:right;margin-top:15px;font-size:20px" id="bs-example-navbar-collapse-1">
            <?php 
                    $query_cust = mysqli_query($conn, "select cust_name from cust_master where cust_id='$customer_id'");
                    $res_cust = mysqli_fetch_array($query_cust);
                 ?>
            <div class="col-md-9">
            <span style="color:white">Welcome: <i class="fa fa-user"></i> <?php $name_cust = $res_cust['cust_name'];if(empty($name_cust)){echo $customer_id;}else{echo $res_cust['cust_name'];}?></span>
			</div>
			<div class="col-md-1" style="margin-top:-8px;margin-bottom:8px">
                <form method="post"><button id="logout" name="logout" style="width:100px;color:#white;border-color:#337AB7;border-width:5px;border-radius:5px 5px 5px 5px;" type="submit" class="btn btn-default">Logout</button></form>
                <?php
                error_reporting(0);
                $logout = $_POST['logout'];
                if(isset($logout))
                {
                    header("Location:index.php");
                }
                ?>
            </div>
            </div>

			<!-- Collect the nav links, forms, and other content for toggling -->
            <!--<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">About</a>
                    </li>
                    <li>
                        <a href="#">Services</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                </ul>
            </div>-->
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-md-3">
                <h1 style="color:#337AB7"><b>Reseller</b></h1>
                <div class="list-group">
                    <!--<a href="index.php" class="list-group-item">Home</a>-->
					<a href="dashboard.php" class="list-group-item"><i class="fa fa-dashboard" aria-hidden="true"></i>  &emsp;Dashboard</a>
                    <a href="my_profile.php" class="list-group-item"><i class="fa fa-user" aria-hidden="true"></i>  &emsp;My Profile</a>
                    <a href="create_user.php" class="list-group-item"><i class="fa fa-pencil" aria-hidden="true"></i>  &emsp;Create User</a>
                    <a href="update_user.php" class="list-group-item active"><i class="fa fa-eraser" aria-hidden="true"></i>  &emsp;Update user</a>
					<a href="request_sender_id.php" class="list-group-item"><i class="fa fa-indent" aria-hidden="true"></i>  &emsp;Request Sender Id</a>
					<a href="request_template.php" class="list-group-item"><i class="fa fa-file-image-o" aria-hidden="true"></i>  &emsp;Template Approval</a>
					<a href="javascript:;" data-toggle="collapse" data-target="#demo1" class="list-group-item"><i class="fa fa-money" aria-hidden="true"></i>  &emsp;Credits Management <i class="fa fa-fw fa-caret-down"></i></a>
                        <p id="demo1" class="collapse">
                                <a class="list-group-item" href="credit_management_reseller.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> My Credit History&emsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-history" aria-hidden="true"></i></a>
                                <a class="list-group-item" href="credit_assignment_user.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> Credit Assignment&emsp;&nbsp; <i class="fa fa-plus" aria-hidden="true"></i></a>
                                <a class="list-group-item" href="credit_history_user.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> User Credit History&emsp; <i class="fa fa-history" aria-hidden="true"></i></a>
                            
                        </p>
                </div>
            </div>
			
<div style="text-align:center;margin-top:20px" class="col-md-7"><center style="margin-top:-15px;margin-bottom:35px;color:#337AB7"><b>Total Users: <?php echo "$totalusers";?> | Active Users: <?php echo "$activeusers";?> | Inactive Users: <?php echo "$inactiveusers";?> | Prepaid: <?php echo "$prepaid";?> | Postpaid: <?php echo "$postpaid";?></b></center></div>

<div class="col-md-9">
<form method="post" >
<?php
error_reporting(0);
$userid = $_POST['userid'];
$customerid = $_POST['cust_id'];
$userstatus = $_POST['userstatus'];
$creditsassigned = $_POST['creditsassigned'];
$address = $_POST['address'];
$state = $_POST['state'];
$city = $_POST['city'];
$countrycode = $_POST['countrycode'];
$mobile = $_POST['mobile'];
$email = $_POST['email'];
//$smsprovider = $_POST['smsprovider'];
//$messagepriority = $_POST['messagepriority'];
$firmname = $_POST['firmname'];
$expired_date = $_POST['expired_on'];
$expired_on = date("Y-m-d 23:59:59", strtotime($expired_date));
$usertype = $_POST['usertype'];
$buffered = $_POST['buffered'];
$httpapi = $_POST['httpapi'];
$xmlapi = $_POST['xmlapi'];
$smpp = $_POST['smpp'];
$panel = $_POST['panel'];
//$campaignuser = $_POST['campaignuser'];
$mis = $_POST['mis'];
$usermode = $_POST['usermode'];
$mess = "";
//*********************Logic for Customer update***********************
if($_POST['btn_submit'] == "Update Account Details")
{
	if(empty($userid))
	{
		$mess = "<center style='color:red'>User Id can't be empty.</center>";
	}
	else
	{
		$query_check = mysqli_query($conn, "select * from user_master where user_id='$userid'");
		$res_check = mysqli_fetch_array($query_check);
		if($userstatus == $res_check['user_status'] && $address == $res_check['contact_address'] && $state == $res_check['state'] && $city == $res_check['city'] && $countrycode == $res_check['country_code'] && $mobile == $res_check['contact_number'] && $email == $res_check['email'] && $firmname == $res_check['firm_name'] && $expired_on == $res_check['expired_on'] && $buffered == $res_check['buffered'] && $httpapi == $res_check['httpapi_enabled'] && $xmlapi == $res_check['xmlapi_enabled'] && $smpp == $res_check['smpp_enabled'] && $panel == $res_check['panel_enabled'] && $mis == $res_check['mis_enabled'] && $usermode == $res_check['user_mode'])
		{
			$mess = "<center style='color:red'>No Field Updated.</center>";
		}
		//$mess = "sms_uaa";
		else
		{
			//$message = "sms_uaa";
			if($userstatus != $res['user_status'])
			{
				if($userstatus == "0")
				{
					//echo "update user_master set user_status='0' where user_id='$userid'";
					$query3 = mysqli_query($conn, "update user_master set user_status='0' where user_id='$userid'");
					if($query3)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
						//$conn = NULL;
						//mysqli_close($conn);
					}
				}
				if($userstatus == "1")
				{
					//echo "update user_master set user_status='1' where user_id='$userid'";
					$query3 = mysqli_query($conn, "update user_master set user_status='1' where user_id='$userid'");
					if($query3)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
						//$conn = NULL;
						//mysqli_close($conn);
					}
				}
			}
			if($address != $res['contact_address'])
			{
				if(!empty($address))
				{
					$query5 = mysqli_query($conn, "update user_master set contact_address='".$address."' where user_id='$userid'");
					if($query5)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
						//$conn = NULL;
						//mysqli_close($conn);
					}
				}
			}
			if($state != $res['state'])
			{
				if(!empty($state))
				{
					$query6 = mysqli_query($conn, "update user_master set state='".$state."' where user_id='$userid'");
					if($query6)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
						//$conn = NULL;
						//mysqli_close($conn);
					}
				}
			}
			if($city != $res['city'])
			{
				if(!empty($city))
				{
					$query7 = mysqli_query($conn, "update user_master set city='".$city."' where user_id='$userid'");
					if($query7)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
						//$conn = NULL;
						//mysqli_close($conn);
					}
				}
			}
			if($countrycode != $res['country_code'])
			{
				if(!empty($countrycode))
				{
					$query8 = mysqli_query($conn, "update user_master set country_code='".$countrycode."' where user_id='$userid'");
					if($query8)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
						//$conn = NULL;
						//mysqli_close($conn);
					}
				}
			}
			if($mobile != $res['contact_number'])
			{
				if(!empty($mobile))
				{
					$query9 = mysqli_query($conn, "update user_master set contact_number='".$mobile."' where user_id='$userid'");
					if($query9)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
						//$conn = NULL;
						//mysqli_close($conn);
					}
				}
				if(empty($mobile))
				{
					$query9 = mysqli_query($conn, "update user_master set contact_number='' where user_id='$userid'");
					if($query9)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
						//$conn = NULL;
						//mysqli_close($conn);
					}
				}
			}
			if($email != $res['email'])
			{
				if(!empty($email))
				{
					$query10 = mysqli_query($conn, "update user_master set email='".$email."' where user_id='$userid'");
					if($query10)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
						//$conn = NULL;
						//mysqli_close($conn);
					}
				}
			}
			if($firmname != $res['firm_name'])
			{
				if(!empty($firmname))
				{
					$query13 = mysqli_query($conn, "update user_master set firm_name='".$firmname."' where user_id='$userid'");
					if($query13)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
						//$conn = NULL;
						//mysqli_close($conn);
					}
				}
			}
			if($expired_on != $res['expired_on'])
			{
				if(!empty($expired_on))
				{
					$expiry_date = date("Y-m-d H:i:s", strtotime($expired_on));
					$query13 = mysqli_query($conn, "update user_master set expired_on='".$expiry_date."' where user_id='$userid'");
					if($query13)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
					}
				}
			}
					//echo "update user_master set buffered='".$buffered_1."' where user_id='$userid'";
			if($buffered != $res['buffered'])
			{			
				if($buffered == "0")
				{
					//echo "update user_master set buffered='".$buffered_1."' where user_id='$userid'";
					$query15 = mysqli_query($conn, "update user_master set buffered='0' where user_id='$userid'");
					if($query15)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
						//$conn = NULL;
						//mysqli_close($conn);
					}
				}
				if($buffered == "1")
				{
					//echo "update user_master set buffered='".$buffered_1."' where user_id='$userid'";
					$query15 = mysqli_query($conn, "update user_master set buffered='1' where user_id='$userid'");
					if($query15)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
						//$conn = NULL;
						//mysqli_close($conn);
					}
				}
			}
					//echo "update user_master set httpapi_enanbled='0' where user_id='$userid'";
			if($httpapi != $res['httpapi_enabled'])
			{
				if($httpapi == "0")
				{
					//echo "update user_master set httpapi_enanbled='0' where user_id='$userid'";
					$query16 = mysqli_query($conn, "update user_master set httpapi_enabled='0' where user_id='$userid'");
					if($query16)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
						//$conn = NULL;
						//mysqli_close($conn);
					}
				}
				if($httpapi == "1")
				{
					$query16 = mysqli_query($conn, "update user_master set httpapi_enabled='1' where user_id='$userid'");
					if($query16)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
						//$conn = NULL;
						//mysqli_close($conn);
					}
				}
			}
			if($xmlapi != $res['xmlapi_enabled'])
			{
				if($xmlapi == "0")
				{
					$query17 = mysqli_query($conn, "update user_master set xmlapi_enabled='0' where user_id='$userid'");
					if($query17)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
						//$conn = NULL;
						//mysqli_close($conn);
					}
				}
				if($xmlapi == "1")
				{
					$query17 = mysqli_query($conn, "update user_master set xmlapi_enabled='1' where user_id='$userid'");
					if($query17)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
						//$conn = NULL;
						//mysqli_close($conn);
					}
				}
			}
			if($smpp != $res['smpp_enabled'])
			{
				if($smpp == "0")
				{
					$query18 = mysqli_query($conn, "update user_master set smpp_enabled='0' where user_id='$userid'");
					if($query18)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
						//$conn = NULL;
						//mysqli_close($conn);
					}
				}
				if($smpp == "1")
				{
					$query18 = mysqli_query($conn, "update user_master set smpp_enabled='1' where user_id='$userid'");
					if($query18)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
						//$conn = NULL;
						//mysqli_close($conn);
					}
				}
			}
			if($panel != $res['panel_enabled'])
			{
				if($panel == "0")
				{
					$query19 = mysqli_query($conn, "update user_master set panel_enabled='0' where user_id='$userid'");
					if($query19)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
						//$conn = NULL;
						//mysqli_close($conn);
					}
				}
				if($panel == "1")
				{
					$query19 = mysqli_query($conn, "update user_master set panel_enabled='1' where user_id='$userid'");
					if($query19)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
						//$conn = NULL;
						//mysqli_close($conn);
					}
				}
			}
			if($mis != $res['mis_enabled'])
			{
				if($mis == "0")
				{
					$query21 = mysqli_query($conn, "update user_master set mis_enabled='0' where user_id='$userid'");
					if($query21)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
						//$conn = NULL;
						//mysqli_close($conn);
					}
				}
				if($mis == "1")
				{
					$query21 = mysqli_query($conn, "update user_master set mis_enabled='1' where user_id='$userid'");
					if($query21)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
						//$conn = NULL;
						//mysqli_close($conn);
					}
				}
			}
			if($usermode != $res['user_mode'])
			{
				if(!empty($usermode))
				{
					$query22 = mysqli_query($conn, "update user_master set user_mode='".$usermode."' where user_id='$userid'");
					if($query22)
					{
						$mess = "<center style='color:green'>Updated Successfully.</center>";
						//$conn = NULL;
						//mysqli_close($conn);
					}
				}
			}
		}
	}
}
//**********************Logic for fetching fields in input********************
if(!empty($userid))
{
	$query = mysqli_query($conn, "select * from user_master where user_id='$userid'");
	$res = mysqli_fetch_array($query);
	$userid = $res['user_id'];
	$userstatus = $res['user_status'];
	$creditsassigned = $res['credits_assigned'];
	$address = $res['contact_address'];
	$city = $res['city'];
	$state = $res['state'];
	$countrycode = $res['country_code'];
	$mobile = $res['contact_number'];
	$email = $res['email'];
	$expired = $res['expired_on'];
	if($expired == "0000-00-00 00:00:00")
	{
		$expired_on = "";
	}
	else
	{
		$expired_on = date("d-m-Y H:i:s", strtotime($expired));
	}
	//$smsprovider = $res['sms_provider_id'];
	//$messagepriority = $res['message_priority'];
	$firmname = $res['firm_name'];
	$useretype = $res['user_type'];
	$buffered = $res['buffered'];
	$httpapi = $res['httpapi_enabled'];
	$xmlapi = $res['xmlapi_enabled'];
	$smpp = $res['smpp_enabled'];
	$panel = $res['panel_enabled'];
	//$campaignuser = $res['campaign_user'];
	$mis = $res['mis_enabled'];
	$usermode = $res['user_mode'];
}
//$message = $expired_on;
//**********************Logic for fetching fields in input********************
?>

<h1>Update User Fields</h1>
	<div class="row">
		<div class="col-md-12 col-lg-12">
		<?php echo "$mess"; ?>

		</div>
<div class="col-lg-4">

<div class="form-group">
    <label>User Id</label>
    <select name="userid" onchange="this.form.submit();" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
<?php
	if(!empty($userid))
	{
		echo "<option selected value='".$userid."'>".$userid."</option>";
		$query1 = mysqli_query($conn, "select * from user_master where cust_id='$customer_id' order by u_id DESC");
		$get_user = array();
		while($resa = mysqli_fetch_array($query1))
		{
			$get_user[] = $resa['user_id'];
		}
		$uniques_user = array_unique($get_user);
		foreach($uniques_user as $unique_user)
		{
			echo "<option value='".$unique_user."'>".$unique_user."</option>";
		}
	}
	else
	{
		echo "<option value='' selected='true' disabled='disabled'>Select User Id</option>";
		error_reporting(0);
		$query1 = mysqli_query($conn, "select * from user_master where cust_id='$customer_id' order by u_id DESC");
		$get_user = array();
		while($resa = mysqli_fetch_array($query1))
		{
			$get_user[] = $resa['user_id'];
		}
		$uniques_user = array_unique($get_user);
		foreach($uniques_user as $unique_user)
		{
			echo "<option value='".$unique_user."'>".$unique_user."</option>";
		}
	}
?>
</select>
</div>
<div class="form-group">
<label>Customer Id</label>
<input name="customerid" id="customerid" disabled="disabled" value="<?php echo $customer_id;?>" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
</div>
<div class="form-group">
<label>User Status</label>
<select name="userstatus" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
<option <?php if($userstatus == 1 ) echo 'selected'; ?> value="1">Active</option>
<option <?php if($userstatus == 0 ) echo 'selected'; ?> value="0">Inactive</option>
</select>
</div>
<div class="form-group">
    <label>Credits Assigned</label>
    <input name="creditsassigned" disabled value="<?php echo "$creditsassigned";?>" maxlength="10" class="form-control" placeholder="Enter Credits here">
</div>
<div class="form-group">
    <label>Address</label>
    <input name="address" value="<?php echo "$address";?>" class="form-control" placeholder="Enter Address here">
</div>
<div class="form-group">
<label>State</label>
<select id="state" name="state" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
<?php
if(!empty($state))
{
	echo "<option selected value='".$state."'>".$state."</option>";
	$query = mysqli_query($conn, "select * from states");
	while($res = mysqli_fetch_array($query))
	{
		echo "<option value='".$res['state_name']."'>".$res['state_name']."</option>";
	}
}
else
{
echo "<option value='' selected='true' disabled='disabled'>Select State</option>";
	$query = mysqli_query($conn, "select * from states");
	while($res = mysqli_fetch_array($query))
	{
		echo "<option value='".$res['state_name']."'>".$res['state_name']."</option>";
	}
}
?>
</select>
</div>
<div class="form-group">
<label>City</label>
    <select name="city" id="city" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
	<?php
	if(!empty($city))
	{
		echo "<option value='".$city."'>".$city."</option>";
		echo "<option value=''>Select state first</option>";
	}
	else
	{
		echo '<option value="">Select state first</option>';
	}
	?>
	</select>
</div>
</div>
<div class="col-lg-4">
<div class="form-group">
    <label>Mobile Number</label><br/>
    <label><input name="countrycode" style="width:50px" maxlength="4" value="<?php echo "$countrycode";?>" class="form-control" placeholder="+91"></label>
	<label class="radio-inline"><input maxlength="10" style="width:180px" name="mobile" value="<?php echo "$mobile";?>" onchange="mobilevalidation()" id="mobile_number" class="form-control" placeholder="Enter mobile Number" onkeypress='mob_validate(event)'></label>
</div>
<div class="form-group">
    <label>Email</label>
    <input name="email" type="email" value="<?php echo "$email";?>" class="form-control" placeholder="Enter Email here">
</div>
<div class="form-group">
    <label>Firm Name</label>
    <input name="firmname" type="text" value="<?php echo "$firmname";?>" class="form-control" placeholder="Enter Firm Name here">
</div>
<div class="form-group">
    <label>Expired On (DD/MM/YYYY)</label>
    <input name="expired_on" id="expired_on" type="text" class="form-control datepicker" value="<?php echo "$expired_on";?>" placeholder="Select Expiry Date">
	<span id="expiry_label" style="text-align:right;color:red"></span>
</div>
<div class="form-group">
<label>User Type</label>
<select id="user_type" name="usertype" style="overflow-x:hidden;overflow-y:scroll" class="form-control" disabled>
<option <?php if($usertype == 0 ) echo 'selected'; ?> disabled="disabled" value="0">Promotional</option>
<option <?php if($usertype == 1 ) echo 'selected'; ?> disabled="disabled" value="1">Transactional</option>
<option <?php if($usertype == 2 ) echo 'selected'; ?> disabled="disabled" value="2">Transcrub</option>
</select>
</div>
<div class="form-group">
<label>Buffered</label>
<select id="buffered" name="buffered" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
<option <?php if($buffered == 0 ) echo 'selected'; ?> value="0">Drop</option>
<option <?php if($buffered == 1 ) echo 'selected'; ?> value="1">Buffered</option>
</select>
</div>
</div>
<div class="col-lg-4">
<div class="form-group">
<label>HTTP API</label>
<select name="httpapi" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
<option <?php if($httpapi == 1 ) echo 'selected'; ?> value="1">Enable</option>
<option <?php if($httpapi == 0 ) echo 'selected'; ?> value="0">Disable</option>
</select>
</div>
<div class="form-group">
<label>XML API</label>
<select name="xmlapi" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
<option <?php if($xmlapi == 1 ) echo 'selected'; ?> value="1">Enable</option>
<option <?php if($xmlapi == 0 ) echo 'selected'; ?> value="0">Disable</option>
</select>
</div>
<div class="form-group">
<label>SMPP</label>
<select name="smpp" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
<option <?php if($smpp == 1 ) echo 'selected'; ?> value="1">Enable</option>
<option <?php if($smpp == 0 ) echo 'selected'; ?> value="0">Disable</option>
</select>
</div>
<div class="form-group">
<label>Panel</label>
<select name="panel" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
<option <?php if($panel == 1 ) echo 'selected'; ?> value="1">Enable</option>
<option <?php if($panel == 0 ) echo 'selected'; ?> value="0">Disable</option>
</select>
</div>
<div class="form-group">
<label>MIS</label>
<select name="mis" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
<option <?php if($mis == 1 ) echo 'selected'; ?> value="1">Enable</option>
<option <?php if($mis == 0 ) echo 'selected'; ?> value="0">Disable</option>
</select>
</div>
<div class="form-group">
<label>User Mode</label>
<select name="usermode" id="usermode" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
<option <?php if($usermode == 1 ) echo 'selected'; ?> value="1">Prepaid</option>
<option <?php if($usermode == 2 ) echo 'selected'; ?> value="2">Postpaid</option>
</select>
</div>
</div>
<div style="text-align:center" class="col-lg-12">
<?php //echo "$mess";?>
<div class="form-group">
<input name="btn_submit" value="Update Account Details" style="width:30%" type="submit" class="btn btn-primary">
</div>
</div>
</div>
</form>

            

        </div>
        </div>

    </div>
    <!-- /.container -->

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
				<!--Insert Footer Here-->
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
<!--date picker -->

      <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
	$(function() {
	$("#expired_on").datepicker();
	
	//$('#expired_on').change(function(){
	//$( "#date_picker" ).datepicker("show");   
	// $("#buffered").focus();
	//});
	//$( "#date_picker1" ).datepicker("show");
	});
</script>
<!--date picker -->

</body>

</html>
