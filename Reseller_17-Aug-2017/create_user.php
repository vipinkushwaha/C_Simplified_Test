<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
if(!isset($_SESSION['use'])) // If session is not set then redirect to Login Page
{
	header("Location:index.php");  
}
$customer_id = $_SESSION['use'];
//echo "<center>Welcome $f.</center>";
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

    <title>Create User</title>
    <link rel="icon" type="image/png" href="image/icon.png" />

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-homepage.css" rel="stylesheet">
	<!--date picker -->
	<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
	<!--date picker -->

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
//******************CheckBox Validation*******************************
	
//******************CheckBox Validation*******************************
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

function refresh()
{
	window.open("create_user.php","_self");
}

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
					}
                }
            }); 
        }
    });
});
//**************Expiry Validation Logic********************
function pwdconfirm()
{
	
	if(document.getElementById("pwd1").value!=document.getElementById("pwd2").value)
	{
		document.getElementById("pwd2").focus();
		alert("Passwords do no match.");
	}
	return document.getElementById("pwd1").value==document.getElementById("pwd2").value;
	return false;
}
function pwdlength()
{
	n = document.getElementById("pwd1").value;
	n_a = document.getElementById("pwd1");
	var ab = document.getElementById("pwdlabel");
	if(n.length < 6)
	{
		n_a.focus();
		ab.innerHTML ='Weak';
		document.getElementById("pwdlabel").style.color = "red";
		
	}
	if(n.length == 6)
	{
		ab.innerHTML = 'Medium';
		document.getElementById("pwdlabel").style.color = "#F0CF18";
	}
	if(n.length > 6)
	{
		ab.innerHTML = 'Strong';
		document.getElementById("pwdlabel").style.color = "green";
	}
}
function mobilevalidation()
{
	n = document.getElementById("mobile_number").value;
	n_b = document.getElementById("mobile_number");
	if(n.length < 10)
	{
		alert("Mobile Number must be of 10 digits.");
		n_b.focus();
	}
}
//**************City & state Logic********************
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
//**************City & state Logic********************
//**************User id check********************
$(document).ready(function(){
    $('#add_user_id').change(function(){
        var userid = $(this).val();
		//alert(userid);
		//return false;
        if(userid){
            $.ajax({
                type:'POST',
                url:'user_id_check.php',
                data:'user_id='+userid,
                success:function(html)
				{
                    $('#user_label').html(html);
                }
            }); 
        }
    });
});
//**************User id check********************
</script>
</head>

<body>
<?php $conn = mysqli_connect("localhost","root","","vipin");?>
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
                    <a href="create_user.php" class="list-group-item active"><i class="fa fa-pencil" aria-hidden="true"></i>  &emsp;Create User</a>
                    <a href="update_user.php" class="list-group-item"><i class="fa fa-eraser" aria-hidden="true"></i>  &emsp;Update user</a>
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
<div class="col-md-9">
<form id="div1" method="post">
<div class="col-lg-12">
<?php
error_reporting(0);
if(isset($_POST['btn_submit']));
{
	$user_id = $_POST['userid'];
	$pwd = $_POST['pwd'];
	$user_status = $_POST['userstatus'];
	$address = $_POST['address'];
	$state = $_POST['state'];
	$city = $_POST['city'];
	$country_code = $_POST['countrycode'];
	$mobile = $_POST['mobile'];
	$credits = $_POST['credits'];
	$email = $_POST['email'];
	$expired_date = $_POST['expired_on'];
	$expired_on = date("Y-m-d 23:59:59", strtotime($expired_date));
	//$message_priority = $_POST['messagepriority'];
	$firm_name = $_POST['firmname'];
	//$user_type = $_POST['usertype'];
	$buffered = $_POST['buffered'];
	$http_api = $_POST['httpapi'];
	$xml_api = $_POST['xmlapi'];
	$smpp = $_POST['smpp'];
	$panel = $_POST['panel'];
	//$campaign_user = $_POST['campaignuser'];
	$mis = $_POST['mis'];
	$user_mode = $_POST['usermode'];
	$mess = "";

	if(!empty($user_id))
	{
		if ($_POST['chk_box'] != 'agree')
		{
			$mess = "<center style='color:red'>Tick Check box to agree Terms & Conditions.</center>";
		}
		if ($_POST['chk_box'] == 'agree')
		{
			$query_cust = mysqli_query($conn, "select * from cust_master where cust_id='".$customer_id."'");
			$res_cust = mysqli_fetch_array($query_cust);
			$cust_lic = $res_cust['licenses'];
			$query_user = mysqli_query($conn, "select * from user_master where cust_id='".$customer_id."'");
			$count_user = mysqli_num_rows($query_user);
			//$mess = $cust_lic;
			//$mess = $count_user;
			if($count_user < $cust_lic)
			{
				
				$query_check = mysqli_query($conn, "select * from user_master where user_id='".$user_id."'");
				if(mysqli_num_rows($query_check)!=0)
				{
					$mess = "<center style='color:red'>User ID already exists.</center>";
			
				}
				else if(mysqli_num_rows($query_check)==0)
				{
					date_default_timezone_set('Asia/Kolkata');
					$created_date = date("Y-m-d H:i:s");
					$present_date = date("ymd", strtotime($created_date));
					$expiry = date("ymd", strtotime($expired_on));
					if($expiry > $present_date)
					{
						//$message = $expiry;
						$query4 = mysqli_query($conn, "select * from cust_master where cust_id='$customer_id'");
						$res = mysqli_fetch_array($query4);
						$customer_balance = $res['credits_assigned'];
						if($credits > $customer_balance)
						{
							$mess = "<center style='color:red'>Insufficient Credits in your Account.</center>";
						}
						if($credits <= $customer_balance)
						{
							//$message = "vipin1";
							$cust_new_bal = $customer_balance - $credits;
							$query5 = mysqli_query($conn, "update cust_master set credits_assigned='$cust_new_bal' where cust_id='$customer_id'");
							if($query5)
							{
								//$message = "vipin2";
								
									//$message = "vipin3";
									
									$query1 = mysqli_query($conn, "insert into user_master (user_id,user_password,cust_id,user_status,credits_assigned,credits_avialable,contact_address,state,city,country_code,contact_number,email,firm_name,expired_on,buffered,httpapi_enabled,xmlapi_enabled,smpp_enabled,panel_enabled,mis_enabled,user_mode) values ('".$user_id."','".$pwd."','".$customer_id."','".$user_status."','".$credits."','".$credits."','".$address."','".$state."','".$city."','".$country_code."','".$mobile."','".$email."','".$firm_name."','".$expired_on."','".$buffered."','".$http_api."','".$xml_api."','".$smpp."','".$panel."','".$mis."','".$user_mode."')");
									if($query1)
									{
										//$message = "vipin4";
										//date_default_timezone_set('Asia/Kolkata');
										//$created_date = date("y-m-d h:i:s");
										$query4 = mysqli_query($conn, "insert into customer_credits_history (customerid,credits_recharged,created_date) values ('".$customer_id."','-".$credits."','".$created_date."')");
										if($query4)
										{
											$query3 = mysqli_query($conn, "insert into credits_history (userid,credits_recharged,credits_available,created_date) values ('".$user_id."','".$credits."','".$credits."','".$created_date."')");
											if($query3)
											{
												$mess = "<center style='color:green'>Data Inserted Successfully.</center>";
												echo '<script>    
															$(document).ready(function(){
																$("#add_user_id").val("");
																$("#pwd1").val("");
																$("#pwd2").val("");
																$("#userstatus").val("");
																$("#credits").val("");
																$("#address").val("");
																$("#state").val("");
																$("#city").val("");
																$("#countrycode").val("");
																$("#mobile_number").val("");
																$("#email").val("");
																$("#firmname").val("");
																$("#expired_on").val("");
																$("#user_mode").val("");
																
																
															});


														</script>';
											}
										}
									}
								
							}
						}
					}
					else
					{
						$mess = "<center style='color:red'>Expiry date Can't be less than Present date.</center>";
					}
				}
			}
			else
			{
				$mess = "<center style='color:red'>You reached your license limit $cust_lic.</center>";
			}
		}
	}
}
echo "$mess";
//echo "$message";
?>
<h1>Create Users</h1>
<div class="row">
<div class="col-lg-4">
<div class="form-group">
    <label>User Id<span style="color:red">*</span></label>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span id="user_label" style="text-align:right;"></span>
    <input id="add_user_id" name="userid" class="form-control" value="<?php echo "$user_id";?>" placeholder="Enter User Id here" autofocus required>
</div>
<div class="form-group">
    <label>Password<span style="color:red">*</span></label>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<span id="pwdlabel"></span>
    <input name="pwd" onchange="pwdlength()" id="pwd1" value="<?php echo "$pwd";?>" type="password" class="form-control" placeholder="Enter Password here" required>
</div>
<div class="form-group">
    <label>Confirm Password<span style="color:red">*</span></label>
    <input type="password" id="pwd2" onchange="pwdconfirm()" value="<?php echo "$pwd";?>" class="form-control" placeholder="Confirm Password" required>
</div>
<div class="form-group">
<label>Customer Id</label>
<input name="customerid" id="customerid" disabled="disabled" value="<?php echo $customer_id;?>" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
</div>
<div class="form-group">
<label>User Status<span style="color:red">*</span></label>
<select id="userstatus" name="userstatus" style="overflow-x:hidden;overflow-y:scroll" class="form-control" required>
<option value="" selected disabled="disabled">Select User Status</option>
<option value="1">Active</option>
<option value="0">Inactive</option>
</select>
</div>
<div class="form-group">
<label>Credits<span style="color:red">*</span></label>
<input id="credits" name="credits" placeholder="Enter Credits" value="<?php echo $credits;?>" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
</div>
<div class="form-group">
    <label>Address<span style="color:red">*</span></label>
    <input id="address" name="address" value="<?php echo "$address";?>" class="form-control" placeholder="Enter Address here">
</div>
</div>
<div class="col-lg-4">
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
<div class="form-group">
    <label>Mobile Number<span style="color:red">*</span></label><br/>
    <label><input id="countrycode" name="countrycode" style="width:50px" maxlength="4" class="form-control" value="<?php echo "$country_code";?>" placeholder="+91"></label><label class="radio-inline"><input maxlength="10" style="width:180px" name="mobile" value="<?php echo "$mobile";?>" onchange="mobilevalidation()" id="mobile_number" class="form-control" placeholder="Enter mobile Number" onkeypress='mob_validate(event)' required></label>
</div>
<div class="form-group">
    <label>Email<span style="color:red">*</span></label>
    <input id="email" name="email" type="email" value="<?php echo "$email";?>" class="form-control" placeholder="Enter Email here" required>
</div>
<div class="form-group">
    <label>Firm Name<span style="color:red">*</span></label>
    <input id="firmname" name="firmname" type="text" class="form-control" value="<?php echo $firm_name;?>" placeholder="Enter Firm Name here" required>
</div>
<div class="form-group">
    <label>Expired On<span style="color:red">*</span>  (YYYY-MM-DD)</label>
    <input name="expired_on" id="expired_on" type="text" class="form-control datepicker" value="<?php echo $expired_on;?>" placeholder="Select Expiry Date" required>
	<span id="expiry_label" style="text-align:right;color:red"></span>
</div>
<div class="form-group">
<label>Buffered</label>
<select id="buffered" name="buffered" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
<option value="" selected="true" disabled="disabled">Select Buffer</option>
<option value="0">Drop</option>
<option value="1">Buffered</option>
</select>
</div>
</div>
<div class="col-lg-4">
<div class="form-group">
<label>HTTP API</label>
<select name="httpapi" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
<option value="" selected="true" disabled="disabled">Select HTTP API status</option>
<option value="1">Enable</option>
<option value="0">Disable</option>
</select>
</div>
<div class="form-group">
<label>XML API</label>
<select name="xmlapi" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
<option value="" selected="true" disabled="disabled">Select XML API status</option>
<option value="1">Enable</option>
<option value="0">Disable</option>
</select>
</div>
<div class="form-group">
<label>SMPP</label>
<select name="smpp" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
<option value="" selected="true" disabled="disabled">Select SMPP status</option>
<option value="1">Enable</option>
<option value="0">Disable</option>
</select>
</div>
<div class="form-group">
<label>Panel</label>
<select name="panel" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
<option value="" selected="true" disabled="disabled">Select Panel status</option>
<option value="1">Enable</option>
<option value="0">Disable</option>
</select>
</div>
<div class="form-group">
<label>MIS</label>
<select name="mis" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
<option value="" selected="true" disabled="disabled">Select MIS status</option>
<option value="1">Enable</option>
<option value="0">Disable</option>
</select>
</div>
<div class="form-group">
<label>User Mode<span style="color:red">*</span></label>
<select id="user_mode" name="usermode" style="overflow-x:hidden;overflow-y:scroll" class="form-control" required>
<option <?php if($user_mode == "") echo 'selected';?> value="" selected="true" disabled="disabled">Select User Mode</option>
<option <?php if($user_mode == 1) echo 'selected';?> value="1">Prepaid</option>
<option <?php if($user_mode == 2) echo 'selected';?> value="2">Postpaid</option>
</select>
</div>
<div style="text-align:center" class="form-group">
<label class="checkbox-inline"><input name="chk_box" value="agree" type="checkbox">I agree to terms & conditions.</label>
</div>
<div style="text-align:center" class="form-group">
<input id="btn_submit" name="btn_submit" style="width:80%" onmouseover="123()" type="submit" label="Create Account" class="btn btn-primary">
</div>
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
	$("#expired_on").datepicker({ dateFormat: 'yy-mm-dd' });
	$( "#expired_on" ).datepicker("option", "minDate", new Date() );
	
	
	$('#expired_on').change(function(){
	//$( "#date_picker" ).datepicker("show");   
	$("#buffered").focus();
	});
	//$( "#date_picker1" ).datepicker("show");
	});
	
	
</script>
<!--date picker -->
</body>

</html>
