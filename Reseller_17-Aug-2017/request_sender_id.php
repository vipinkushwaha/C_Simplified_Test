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

    <title>Sender Id Approval</title>
    <link rel="icon" type="image/png" href="image/icon.png" />

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-homepage.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!--date picker -->
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<!--date picker -->
<style>
#logout {
    background-color: white; 
    color: black; 
    border: 4px solid #337ab7;
}

#logout:hover {
    background-color: #337ab7;
    color: white;
}
.table-header {
    float:left;
    width: 100%;
}
.table-body {
	margin-top:-21px;
	
    float:left;
	height: auto;
    max-height: 450px;
    width: inherit;
    overflow-y: scroll;
}
</style>
   

<script>
//************************validate_senderid*******************
function validate_senderid()
{
	n = document.getElementById("senderid").value;
	if(n.length < 6)
	{
		alert("Sender can't be less 6 digits.");
		n.focus();
	}
}
//************************validate_senderid*******************

//********************On Change Created On And Approved On******************************

$(document).ready(function(){
	$('#date_picker').hide();
	$('#date_picker1').hide();
	$('#date_text').show();
	
$("#created_approved").change(function(){
	var search = $('#created_approved').val();
	if(search == "created_on")
	{
		$('#date_text').hide();
		$('#date_picker').show();
		$('#date_picker1').show();
	}
	else if(search == "approved_on")
	{
		$('#date_text').hide();
		$('#date_picker').show();
		$('#date_picker1').show();
	}
	else
	{
		$('#date_picker').hide();
		$('#date_picker1').hide();
		$('#date_text').show();
	}
});
});
//********************On Change Created On And Approved On******************************

//**************New Sender id approval********************
$(document).ready(function(){
	//$("#date").datepicker();
	
    $("#senderid_btn").click(function(){
        var user_id = $("#userid").val();
		var cust_id = $("#customerid").val();
        var sender_id = $("#senderid").val();
        var account_type = $("#accounttype").val();
			if(user_id=="")
			{
			alert("Empty User ID");
			return false;
			}
			if(account_type==null)
			{
			alert("Empty  Account Type");
			return false;
			}
			
			if(sender_id=="")
			{
			alert("Empty Sender ID");
			return false;
			}
            $.ajax({
                type:"POST",
                url:"newsenderidapproval.php",
                data:"userid="+user_id+"&custid="+cust_id+"&senderid="+sender_id+"&accounttype="+account_type,
                success:function(e)
				{
                    alert(e);
					$("#userid").val("");
					$("#senderid").val("");
					$("#accounttype").val("");
					$('#myModal').show(0).delay(800).hide(0);
					setTimeout(function () { window.location.href = window.location.pathname;}, 800);

                }
            }); 
        //else
		//{
        //    $('#city').html('<option value="">Select state first</option>'); 
        //}
    });
});
//**************New Sender id approval********************
//*****************Search status and Acc Type Logic***************************
$(document).ready(function(){
    $('#status_account').change(function(){
        var select_status = $('#status_account').val();
            $.ajax({
                type:'POST',
                url:'search.php',
                data:'select_sta_acc='+select_status,
                success:function(html)
				{
					//alert(e);
					
                    $('#status_account2').html(html);
                }
            }); 
    });
});

//*****************Compare two dates Logic***************************

$(document).ready(function(){
    $('#date_picker1').change(function(){
		var date1 = $('#date_picker').val();
		var date2 = $('#date_picker1').val();
		//var xa = new Date(date1).gettime();
		//alert(date1.toString());
	   if(date1.toString() > date2.toString())
		{
             alert("To Date must be greater than From date.");
			 $('#date_picker1').val("");
			 return false;
		}
    });
});
//*****************Compare two dates Logic***************************
</script>
</head>

<body>
 
<?php $conn = mysqli_connect("localhost","root","","vipin");?>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <!--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>-->
                
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
			<!--<center style="margin-top:30px;color:#EEEEEE"></center>-->
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
                    <a href="update_user.php" class="list-group-item"><i class="fa fa-eraser" aria-hidden="true"></i>  &emsp;Update user</a>
					<a href="request_sender_id.php" class="list-group-item active"><i class="fa fa-indent" aria-hidden="true"></i>  &emsp;Request Sender Id</a>
					<a href="request_template.php" class="list-group-item"><i class="fa fa-file-image-o" aria-hidden="true"></i>  &emsp;Template Approval</a>
					<a href="javascript:;" data-toggle="collapse" data-target="#demo1" class="list-group-item"><i class="fa fa-money" aria-hidden="true"></i>  &emsp;Credits Management <i class="fa fa-fw fa-caret-down"></i></a>
                        <p id="demo1" class="collapse">
                                <a class="list-group-item" href="credit_management_reseller.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> My Credit History&emsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-history" aria-hidden="true"></i></a>
                                <a class="list-group-item" href="credit_assignment_user.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> Credit Assignment&emsp;&nbsp; <i class="fa fa-plus" aria-hidden="true"></i></a>
                                <a class="list-group-item" href="credit_history_user.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> User Credit History&emsp; <i class="fa fa-history" aria-hidden="true"></i></a>
                            
                        </p>
                </div>
            </div>
			<!--sender ID Request-->
			
<!-- Start Modal from Here -->

				<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    <!--<form method="post">-->
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header bg-primary" style='border-radius:5px 5px 0px 0px;'>
          <input type="submit" class="close" value="&times;" data-dismiss="modal">
          <h4 class="modal-title">Request New SenderId</h4>
        </div>
        <div class="modal-body">
		<div class="form-group">
    <label>User Id</label>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<!--<a name="sms_uaa" style="cursor:pointer;" onclick="#"><i class="fa fa-refresh" aria-hidden="true"></i></a>&emsp;<a style="cursor:pointer;" onclick="#">check availability</a>-->
    <input id="userid" name="userid" style="overflow-x:hidden;overflow-y:scroll" class="form-control" list="datalist_user" placeholder="Type User Id here" autocomplete="off">
	<datalist id="datalist_user">
	<?php
		
		$query = mysqli_query($conn, "select * from user_master where cust_id='$customer_id' and user_status='1' order by u_id DESC");
		$count_user = mysqli_num_rows($query);
		if($count_user == 0)
		{
			echo "<option>No Record Found.</option>";
		}
		else
		{
			while($resa = mysqli_fetch_array($query))
			{
				echo "<option value='".$resa['user_id']."'>";
			}
		}
	?>
	</datalist>
	</div>
          <div class="form-group">
<label>Customer Id</label>
<input id="customerid" name="customerid" disabled="disabled" value="<?php echo $customer_id;?>" type="text" class="form-control">
</div>
<div class="form-group">
<label>Account Type<span style="color:red">*</span></label>
<select id="accounttype" name="accounttype" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
<option value="" selected disabled="disabled">Select Account Type</option>
<option value="1">Promotional</option>
<option value="2">Transcrub</option>
<option value="3">Transactional</option>
</select>
</div>
<div class="form-group">
    <label>Sender Id<span style="color:red">*</span></label>
    <input id="senderid" name="senderid" value="" onchange="validate_senderid();" maxlength="6" class="form-control" placeholder="Enter Sender Id here">
</div>

        </div>
        <div class="modal-footer">
		
		<div style="text-align:center" class="col-lg-12">
		<div class="form-group">
		<button id="senderid_btn" name="btn_submit" style="width:40%" type="submit" class="btn btn-primary"><span class="text-lg">R E Q U E S T</span></button>
		</div>
		</div>

         
        </div>
      </div>
      <!--</form>-->
    </div>
  </div>
<!-- End Modal Here -->
			
			<!--***********************sender ID Request***********************************-->
			<?php
				$query1 = mysqli_query($conn, "select * from sender_id where cust_id='$customer_id'");
				$total = mysqli_num_rows($query1);
				$query2 = mysqli_query($conn, "select * from sender_id where is_approved='1' AND cust_id='$customer_id'");
				$active = mysqli_num_rows($query2);
				$query3 = mysqli_query($conn, "select * from sender_id where is_approved='0' AND cust_id='$customer_id'");
				$inactive = mysqli_num_rows($query3);
				$query4 = mysqli_query($conn, "select * from sender_id where account_type='1' AND cust_id='$customer_id'");
				$promotional = mysqli_num_rows($query4);
				$query5 = mysqli_query($conn, "select * from sender_id where account_type='2' AND cust_id='$customer_id'");
				$transcrub = mysqli_num_rows($query5);
				$query6 = mysqli_query($conn, "select * from sender_id where account_type='3' AND cust_id='$customer_id'");
				$transactional = mysqli_num_rows($query6);
				
				?>
			<!--********************Search By User Id, SenderId, Status etc*******************-->
			
			<div class="col-lg-9">
                        <div class="container" style="border:5px solid #f5f5f5; width:100%;border-radius:20px 20px 20px 20px;">
                            <table>
                                <tr>
                                    <td>&emsp;<img style="width:60px;height:60px" src="image/total.png"></td>
                                    <td>&emsp;&emsp;&emsp;&emsp;&nbsp;</td>
                                    <td>&emsp;<img style="width:60px;height:60px" src="image/active.png"></td>
                                    <td>&emsp;&emsp;&emsp;&emsp;&nbsp;</td>
                                    <td>&emsp;<img style="width:60px;height:60px" src="image/inactive.png"></td>
                                    <td>&emsp;&emsp;&emsp;&emsp;&nbsp;</td>
                                    <td>&emsp;<img style="width:60px;height:60px" src="image/promotional.png"></td>
                                    <td>&emsp;&emsp;&emsp;&emsp;&nbsp;</td>
                                    <td>&emsp;<img style="width:60px;height:60px" src="image/transcrub.png"></td>
                                    <td>&emsp;&emsp;&emsp;&emsp;&nbsp;</td>
                                    <td>&emsp;<img style="width:60px;height:60px" src="image/transactional.png"></td>
                                </tr>
                                <tr>
                                    <th>Total: <?php echo $total; ?></th>
                                    <th>&emsp;&emsp;&emsp;&emsp;</th>
                                    <th>Active: <?php echo $active; ?></th>
                                    <th>&emsp;&emsp;&emsp;&emsp;</th>
                                    <th>Inactive: <?php echo $inactive; ?></th>
                                    <th>&emsp;&emsp;&emsp;&emsp;</th>
                                    <th>Promotional: <?php echo $transactional; ?></th>
                                    <th>&emsp;&emsp;&emsp;&emsp;</th>
                                    <th>Transcrub: <?php echo $transcrub; ?></th>
                                    <th>&emsp;&emsp;&emsp;&emsp;</th>
                                    <th>Transactional: <?php echo $transactional; ?></th>
                                </tr>
                            </table>
                        </div>
                    </div>
			<div class="col-md-7">&nbsp;</div>
			<form method="post">
            <div class="col-md-9">
			<div class="col-md-4">
			<div class="form-group">
            <label>User Id</label>
            <input type="text" style="overflow:scroll;width:100%" name="user_id" class="form-control" list="datalist_user2" placeholder="Type User Id here" autocomplete="off">
			<datalist id="datalist_user2">
			<?php
				$query = mysqli_query($conn, "select * from sender_id where cust_id='$customer_id' order by id DESC");
				$count_user = mysqli_num_rows($query);
				if($count_user == 0)
				{
					echo "<option>No Record Found.</option>";
				}
				else
				{
					$get_user = array();
					while($resa = mysqli_fetch_array($query))
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
			</datalist>
            </div>
			<div class="form-group">
            <label>Senderid</label>
            <input type="text" maxlength="6" style="width:100%" placeholder="Insert SenderId" name="sender_id" class="form-control">
            </div>
			</div>
			<div class="col-md-4" style="border-left:1px solid #efefef;">
			<div class="form-group">
            <label>Status/Account Type</label>
            <select id="status_account" name="status_account" class="form-control">
			<option value="" selected="true" disabled="disabled">Select</option>
            <option value="Status">Status</option>
			<option value="Account_Type">Account Type</option>
			</select>
            </div>
			<div class="form-group">
            <label class="col-md-12">&nbsp;</label>
            <select id="status_account2" name="sta_acc" class="form-control">
			<option value="">Select Status/Account Type First</option>
			</select>
			</div>
			
			</div>
			<div class="col-md-4" style="border-left:1px solid #efefef;">
			<div class="form-group">
            <label>Created On/Approved On</label>
            <select id="created_approved" name="cre_app" class="form-control">
			<option value="" selected="true" disabled="disabled">Select</option>
            <option value="created_on">Created On</option>
			<option value="approved_on">Approved On</option>
			</select>
			</div>
			<div class="form-group">
			<label>Search By Date</label>
			<input type="text" id="date_text" placeholder="Select Created On/Approved On First." disabled class="form-control datepicker">
            <input type="text" id="date_picker" name="created_approved1" placeholder="From Date" class="form-control datepicker">
            <label class="col-md-12">&nbsp;</label>
            <input type="text" id="date_picker1" name="created_approved2" placeholder="To Date" class="form-control datepicker">
			</div>
			
			</div>
			<div style="text-align:center" class="col-md-9">
			<?php
			$message = "";
			error_reporting(0);
			$user_id = $_POST['user_id'];
			$sender_id = $_POST['sender_id'];
			$status_account = $_POST['sta_acc'];
			$created_approved1 = $_POST['created_approved1'];
			$created_approved2 = $_POST['created_approved2'];
			$cre_app = $_POST['cre_app'];
			//**********************Logic For Search**************
				if(!isset($_POST['search_btn']))
				{
					if(empty($user_id))
					{
						$query_d = "select * from sender_id where cust_id='$customer_id' order by id desc limit 80";
						$query = mysqli_query($conn, $query_d);
					}
				}
				if(isset($_POST['search_btn']))
				{
					if(empty($user_id && $sender_id && $status_account && $created_approved1 && $created_approved2 && $cre_app))
					{
						$query_d = "select * from sender_id where cust_id='$customer_id' order by id desc limit 80";
						$query = mysqli_query($conn, $query_d);
					}
					//echo "$user_id";
					if(!empty($user_id) && empty($sender_id && $status_account && $created_approved1 && $created_approved2 && $cre_app))
					{
						//echo "$user_id";
						$query_d = "select * from sender_id where cust_id='$customer_id' && user_id='$user_id' order by id desc limit 80";
						$query = mysqli_query($conn, $query_d);
						
					}
					if(!empty($sender_id) && empty($user_id && $status_account && $created_approved1 && $created_approved2 && $cre_app))
					{
						//echo "$user_id";
						$query_d = "select * from sender_id where cust_id='$customer_id' && sender_id='$sender_id'";
						$query = mysqli_query($conn, $query_d);
						
					}
					if(!empty($status_account) && empty($user_id && $sender_id && $created_approved1 && $created_approved2 && $cre_app))
					{
						//echo "$status_account";
						if($status_account == "active")
						{
							$query_d = "select * from sender_id where cust_id='$customer_id' && is_approved='1' order by id desc limit 80";
							$query = mysqli_query($conn, $query_d);
						}
						if($status_account == "inactive")
						{
							$query_d = "select * from sender_id where cust_id='$customer_id' && is_approved='0' order by id desc limit 80";
							$query = mysqli_query($conn, $query_d);
						}
						if($status_account == "promotional")
						{
							$query_d = "select * from sender_id where cust_id='$customer_id' && account_type='1' order by id desc limit 80";
							$query = mysqli_query($conn, $query_d);
						}
						if($status_account == "transcrub")
						{
							$query_d = "select * from sender_id where cust_id='$customer_id' && account_type='2' order by id desc limit 80";
							$query = mysqli_query($conn, $query_d);
						}
						if($status_account == "transactional")
						{
							$query_d = "select * from sender_id where cust_id='$customer_id' && account_type='3' order by id desc limit 80";
							$query = mysqli_query($conn, $query_d);
						}
						
					}
					if(!empty($user_id && $status_account) && empty($sender_id  && $created_approved))
					{
						//echo "$user_id or $status_account";
						if($status_account == "active")
						{
							$query_d = "select * from sender_id where cust_id='$customer_id' and user_id='$user_id' and is_approved='1' order by id desc limit 80";
							$query = mysqli_query($conn, $query_d);
						}
						if($status_account == "inactive")
						{
							$query_d = "select * from sender_id where cust_id='$customer_id' and user_id='$user_id' and is_approved='0' order by id desc limit 80";
							$query = mysqli_query($conn, $query_d);
						}
						if($status_account == "promotional")
						{
							$query_d = "select * from sender_id where cust_id='$customer_id' and user_id='$user_id' and account_type='1' order by id desc limit 80";
							$query = mysqli_query($conn, $query_d);
						}
						if($status_account == "transcrub")
						{
							$query_d = "select * from sender_id where cust_id='$customer_id' and user_id='$user_id' and account_type='2' order by id desc limit 80";
							$query = mysqli_query($conn, $query_d);
						}
						if($status_account == "transactional")
						{
							$query_d = "select * from sender_id where cust_id='$customer_id' and user_id='$user_id' and account_type='3' order by id desc limit 80";
							$query = mysqli_query($conn, $query_d);
						}
						
					}
					if(!empty($created_approved1) && !empty($created_approved2) && empty($cre_app) && empty($user_id && $sender_id  && $status_account))
					{
						echo "<center style='color:red'>Select type of date (Created On Or Approved On).</center>";
					}
					$date_from = date("Y-m-d 00:00:00", strtotime($created_approved1));
					$date_to = date("Y-m-d 23:59:59", strtotime($created_approved2));
					if(!empty($created_approved1 && $created_approved2) && !empty($cre_app) && empty($user_id && $sender_id  && $status_account))
					{
						if($cre_app == "created_on")
						{
							//echo "$created_approved1";
							//echo "$created_approved2";
							$query_d = "select * from sender_id where cust_id='$customer_id' and created_on>='$date_from' and created_on<='$date_to' order by id desc";
							$query = mysqli_query($conn, $query_d);
						}
						if($cre_app == "approved_on")
						{
							$query_d = "select * from sender_id where cust_id='$customer_id' and approved_on>='$date_from' and approved_on<='$date_to' order by id desc";
							$query = mysqli_query($conn, $query_d);
						}
					}
					if(!empty($user_id && $created_approved1 && $created_approved2 && $cre_app) && empty($sender_id  && $status_account))
					{
						if($cre_app == "created_on")
						{
							$query_d = "select * from sender_id where cust_id='$customer_id' and user_id='$user_id' and created_on>='$date_from' and created_on<='$date_to' order by id desc";
							$query = mysqli_query($conn, $query_d);
						}
						if($cre_app == "approved_on")
						{
							$query_d = "select * from sender_id where cust_id='$customer_id' and user_id='$user_id' and approved_on>='$date_from' and approved_on<='$date_to' order by id desc";
							$query = mysqli_query($conn, $query_d);
						}
					}
					
					if(!empty($status_account) && !empty($created_approved1) && !empty($created_approved2) && !empty($cre_app) && empty($sender_id  && $user_id))
					{
						if($cre_app == "created_on")
						{
							if($status_account == "active")
							{
								$query_d = "select * from sender_id where cust_id='$customer_id' and is_approved='1' and created_on>='$date_from' and created_on<='$date_to' order by id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status_account == "inactive")
							{
								$query_d = "select * from sender_id where cust_id='$customer_id' and is_approved='0' and created_on>='$date_from' and created_on<='$date_to' order by id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status_account == "promotional")
							{
								$query_d = "select * from sender_id where cust_id='$customer_id' and account_type='1' and created_on>='$date_from' and created_on<='$date_to' order by id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status_account == "transcrub")
							{
								$query_d = "select * from sender_id where cust_id='$customer_id' and account_type='2' and created_on>='$date_from' and created_on<='$date_to' order by id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status_account == "transactional")
							{
								$query_d = "select * from sender_id where cust_id='$customer_id' and account_type='3' and created_on>='$date_from' and created_on<='$date_to' order by id desc";
								$query = mysqli_query($conn, $query_d);
							}
						}
						if($cre_app == "approved_on")
						{
							if($status_account == "active")
							{
								$query_d = "select * from sender_id where cust_id='$customer_id' and is_approved='1' and approved_on>='$date_from' and approved_on<='$date_to' order by id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status_account == "inactive")
							{
								$query_d = "select * from sender_id where cust_id='$customer_id' and is_approved='0' and approved_on>='$date_from' and approved_on<='$date_to' order by id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status_account == "promotional")
							{
								$query_d = "select * from sender_id where cust_id='$customer_id' and account_type='1' and approved_on>='$date_from' and approved_on<='$date_to' order by id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status_account == "transcrub")
							{
								$query_d = "select * from sender_id where cust_id='$customer_id' and account_type='2' and approved_on>='$date_from' and approved_on<='$date_to' order by id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status_account == "transactional")
							{
								$query_d = "select * from sender_id where cust_id='$customer_id' and account_type='3' and approved_on>='$date_from' and approved_on<='$date_to' order by id desc";
								$query = mysqli_query($conn, $query_d);
							}
						}
					}
					if(!empty($user_id) && !empty($status_account) && !empty($created_approved1) && !empty($created_approved2) && !empty($cre_app) && empty($sender_id))
					{
						//echo "sms_uaa";
						if($cre_app == "created_on")
						{
							//echo "sms_uaa";
							if($status_account == "active")
							{
								//echo "select * from sender_id where cust_id='$customer_id' and user_id='$user_id' and is_approved='1' and created_on>='$date_from' and created_on<='$date_to' order by id desc";
								$query_d = "select * from sender_id where cust_id='$customer_id' and user_id='$user_id' and is_approved='1' and created_on>='$date_from' and created_on<='$date_to' order by id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status_account == "inactive")
							{
								$query_d = "select * from sender_id where cust_id='$customer_id' and user_id='$user_id' and is_approved='0' and created_on>='$date_from' and created_on<='$date_to' order by id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status_account == "promotional")
							{
								//echo "select * from sender_id where cust_id='$customer_id' and user_id='$user_id' and account_type='1' and created_on>='$date_from' and created_on<='$date_to' order by id desc";
								$query_d = "select * from sender_id where cust_id='$customer_id' and user_id='$user_id' and account_type='1' and created_on>='$date_from' and created_on<='$date_to' order by id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status_account == "transcrub")
							{
								$query_d = "select * from sender_id where cust_id='$customer_id' and user_id='$user_id' and account_type='2' and created_on>='$date_from' and created_on<='$date_to' order by id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status_account == "transactional")
							{
								$query_d = "select * from sender_id where cust_id='$customer_id' and user_id='$user_id' and account_type='3' and created_on>='$date_from' and created_on<='$date_to' order by id desc";
								$query = mysqli_query($conn, $query_d);
							}
						}
						if($cre_app == "approved_on")
						{
							if($status_account == "active")
							{
								$query_d = "select * from sender_id where cust_id='$customer_id' and user_id='$user_id' and is_approved='1' and approved_on>='$date_from' and approved_on<='$date_to' order by id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status_account == "inactive")
							{
								$query_d = "select * from sender_id where cust_id='$customer_id' and user_id='$user_id' and is_approved='0' and approved_on>='$date_from' and approved_on<='$date_to' order by id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status_account == "promotional")
							{
								$query_d = "select * from sender_id where cust_id='$customer_id' and user_id='$user_id' and account_type='1' and approved_on>='$date_from' and approved_on<='$date_to' order by id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status_account == "transcrub")
							{
								$query_d = "select * from sender_id where cust_id='$customer_id' and user_id='$user_id' and account_type='2' and approved_on>='$date_from' and approved_on<='$date_to' order by id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status_account == "transactional")
							{
								$query_d = "select * from sender_id where cust_id='$customer_id' and user_id='$user_id' and account_type='3' and approved_on>='$date_from' and approved_on<='$date_to' order by id desc";
								$query = mysqli_query($conn, $query_d);
							}
						}
					}
					//**********************Logic For Search**************
					//++++++++++++++++++++++++
					
				}
				
				?>
			<div class="form-group">
				<button id="Search_btn" name="search_btn" style="width:20%" type="submit" class="btn btn-primary"><span class="text-lg">SEARCH</span></button>
			</div>
			
			</div>
			<!--Search By User Id, SenderId, Status etc-->
           
            <div class="col-md-12">
				<div class="col-md-8"><h3>Sender Id Table</h3></div><div class="col-md-4"><button class="btn btn-well"  style='border-radius:8px 0px 0px 8px'><span class="glyphicon glyphicon-plus"></span></button><button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal" style='border-radius:0px 8px 8px 0px;'> Request SenderId</button></div>
			<!--<div class="col-md-12" style="overflow-y:scroll;overflow-x:auto;max-height:380pt">-->
			
				<div class="table-header">
				<table width="98.5%" class="table table-bordered table-hover">
				<div class="col-md-12">
				<thead>
				<th width="17%">User Id</th>
				<th width="15%">SenderId</th>
				<th width="12%">Status</th>
				<th width="15%">Account Type</th>
				<th width="19%">Created On</th>
				<th width="22%">Approved On</th>
				</thead>
				</table>
				</div>
				<div class="table-body" style="width:100%">
				<table width="100%" class="table table-bordered table-hover">
				<tbody style="width:100%">
				<?php
					if(mysqli_num_rows($query) > 0)
					{
						while($res = mysqli_fetch_array($query))
						{
							if($res['is_approved'] == 0)
							{
								$status = "Inactive";
							}
							if($res['is_approved'] == 1)
							{
								$status = "Active";
							}
							if($res['account_type'] == 1)
							{
								$acc_type = "Promotional";
							}
							if($res['account_type'] == 2)
							{
								$acc_type = "Transcrub";
							}
							if($res['account_type'] == 3)
							{
								$acc_type = "Transactional";
							}
							$originalDate1 = $res['created_on'];
							$created_date = date("d-m-Y H:i:s", strtotime($originalDate1));
							$originalDate2 = $res['approved_on'];
							if($originalDate2=="0000-00-00 00:00:00")
							{
								$approved_date = "";
							}
							else
							{
								$approved_date = date("d-m-Y H:i:s", strtotime($originalDate2));
							}
								echo "<tr><td width='17.3%'>".$res['user_id']."</td><td width='15.4%'>".$res['sender_id']."</td><td width='12.3%'>".$status."</td><td width='15.3%'>".$acc_type."</td><td width='19.4%'>".$created_date."</td><td width='20.3%'>".$approved_date."</td></tr>";
						}
					}
					else
					{
						echo "<tr><td colspan='6'><center style='color:red;text-align:center;'>No Records Found</center></td></tr>";
					}
						
				?>
				</tbody>
				</table>
			</form>
		</div>	
			<!--************************CSV DOwnload*******************************-->			
<div class="col-md-1">
			<form method="post" action="csv_download.php">
			<input type="hidden" name="csv_query" value="<?php echo $query_d; ?>">
			<div style="text-align:center" class="form-group">
				<button type="submit" value="DOWNLOAD CSV" name="download_sender_id_csv" style="background:none;border:none;height:40px;width:40px"><img style="width:35px;height:35px" src="image/excel-logo.png"/></button>
				<span class="help-block" style="text-align:center;font-size:10px">Click To Download CSV.</span>
			</div>
			</form>
			</div>
<!--************************CSV DOwnload*******************************-->
			</div>
			
			
			</div>
        </div>
		
<div class="col-md-3"></div>

		
		<!--</div>-->

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
    <!--<script src="js/jquery.js"></script>-->

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	
 <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
         $(function() {
            $( "#date_picker" ).datepicker();
            //$( "#date_picker" ).datepicker("show");   
			$( "#date_picker1" ).datepicker();
            //$( "#date_picker1" ).datepicker("show");
         });
      </script>
<!--date picker -->

	
</body>

</html>
