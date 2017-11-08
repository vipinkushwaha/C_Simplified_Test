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

    <title>Credit Assignment User</title>
    <link rel="icon" type="image/png" href="image/icon.png" />


    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-homepage.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- Ajax Library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!-- Ajax Library -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
//**************Textbox is integer Validation Logic********************
function text_validate(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode( key );
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}
//**************Textbox is integer Validation Logic********************

//************************Revoke Credits logic ***********************
$(document).ready(function(){
$("#revoke_btn").one("click", function() {
	//$('#revoke_btn').attr('disabled', true);
	//alert("vipin");
	//return false;
	var user_id_revoke = $("#userid_revoke").val();
	var revoke_amount = $("#amount_revoke").val();
	var cust_id = $("#hid_var2").val();
	if(user_id_revoke=="")
	{
		alert("Empty User ID.");
		window.location.href = window.location.pathname;
		//$('#revoke_btn').attr('disabled', false);
		return false;
	}
	if(revoke_amount==0)
	{
		alert("Empty Amount to be Revoke.");
		window.location.href = window.location.pathname;
		return false;
	}
	$.ajax({
		type:"POST",
		url:"revoke_credit_user.php",
		data:"userid_revoke="+user_id_revoke+"&custid="+cust_id+"&revoke_amount="+revoke_amount,
		success:function(e)
		{
			$("#revoke_done").html(e);
			$("#userid_revoke").val("");
			$("#amount_revoke").val("");
			$('#revoke_modal').show(0).delay(800).hide(0);
			setTimeout(function () { window.location.href = window.location.pathname;}, 800);

		}
		}); 
	});
});
// <!--************************Revoke Credits logic ***********************-->
// <!--************************Insert Credits logic ***********************-->

//


$(document).ready(function(){
$("#credit_btn").one("click", function() {
	//$('#credit_btn').attr('disabled', true);
	//alert("vipin");
	//return false;
	var user_id_credit = $("#userid_credit").val();
	var credit_amount = $("#amount_credit").val();
	var cust_id = $("#hid_var").val();
	if(user_id_credit=="")
	{
		alert("Empty User ID.");
		window.location.href = window.location.pathname;
		return false;
	}
	if(credit_amount==0)
	{
		alert("Empty Amount to be Credit.");
		window.location.href = window.location.pathname;
		return false;
	}
	$.ajax({
		type:"POST",
		url:"insert_credit_user.php",
		data:"userid_credit="+user_id_credit+"&custid="+cust_id+"&credit_amount="+credit_amount,
		success:function(e)
		{
			alert(e);
			$("#userid_credit").val("");
			$("#amount_credit").val("");
			$('#credit_modal').show(0).delay(200).hide(0);
			setTimeout(function () { window.location.href = window.location.pathname;}, 200);

		}
		}); 
	});
	 
});
// <!--************************Insert Credits logic ***********************-->

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
                    <a href="create_user.php" class="list-group-item"><i class="fa fa-pencil" aria-hidden="true"></i>  &emsp;Create User</a>
                    <a href="update_user.php" class="list-group-item"><i class="fa fa-eraser" aria-hidden="true"></i>  &emsp;Update user</a>
					<a href="request_sender_id.php" class="list-group-item"><i class="fa fa-indent" aria-hidden="true"></i>  &emsp;Request Sender Id</a>
					<a href="request_template.php" class="list-group-item"><i class="fa fa-file-image-o" aria-hidden="true"></i>  &emsp;Template Approval</a>
					<a href="javascript:;" data-toggle="collapse" data-target="#demo1" class="list-group-item active"><i class="fa fa-money" aria-hidden="true"></i>  &emsp;Credits Management <i class="fa fa-fw fa-caret-down"></i></a>
                        <p id="demo1" class="collapse">
                                <a class="list-group-item" href="credit_management_reseller.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> My Credit History&emsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-history" aria-hidden="true"></i></a>
                                <a class="list-group-item" href="credit_assignment_user.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> Credit Assignment&emsp;&nbsp; <i class="fa fa-plus" aria-hidden="true"></i></a>
                                <a class="list-group-item" href="credit_history_user.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> User Credit History&emsp; <i class="fa fa-history" aria-hidden="true"></i></a>
                            
                        </p>
                </div>
            </div>
			<!--Form Start-->
			<?php
			//error_reporting(0);
			$query = mysqli_query($conn, "select * from cust_master where cust_id='$customer_id'");
			$res1 = mysqli_fetch_array($query);
			$aval_bal = $res1['credits_assigned'];
			$query2 = mysqli_query($conn, "select * from user_master where cust_id='$customer_id'");
			$count = mysqli_num_rows($query2);
			$query3 = mysqli_query($conn, "select * from user_master where cust_id='$customer_id'");
			$bal_used = array();
			while($row = mysqli_fetch_array($query3))
			{
			   $bal_used[] = $row['credits_assigned'];
			}
			$balance_used = array_sum($bal_used);
			?>
			<div style="text-align:center;margin-top:20px;" class="col-md-7"><center style="margin-top:-15px;color:#337AB7;"><b>Total Recharge: <?php echo $balance_used + $aval_bal;?> | Used Amount: <?php echo "$balance_used";?> | My Available Balance: <?php echo "$aval_bal";?> | Total Users: <?php echo "$count";?></b></center></div>
			
			
            <div class="col-md-9">&nbsp;</div>
			
<!--************************** Insert Credits Modal Start**************************-->
<div class="modal fade" id="credit_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header bg-primary" style='border-radius:5px 5px 0px 0px;'>
          <input type="button" value="&times;" class="close" data-dismiss="modal">
          <h4 class="modal-title">Insert Credits to User</h4>
        </div>
        <div style="text-align:center" class="modal-body">
		<div class="col-md-2"><input type="hidden" id="hid_var" value="<?php echo "$customer_id";?>"></div>
		<div class="col-md-8">
          <div style="text-align:left" class="form-group">
			
			<label>User Id</label>
			<input type="text" id="userid_credit" name="userid_credit" style="overflow-x:hidden;overflow-y:scroll" class="form-control" list="datalist_user1" placeholder="Type User Id here" autocomplete="off">
			<datalist id="datalist_user1">
			<?php
				
				$query_user = mysqli_query($conn, "select * from user_master where cust_id='$customer_id' and user_status='1' order by u_id DESC");
				while($resa = mysqli_fetch_array($query_user))
				{
					echo "<option value='".$resa['user_id']."'>".$resa['user_id']."</option>";
				}
			?>
			</datalist>
			<span class="help-block" style="text-align:center">Note: If any user id missing please check their status.</span>
			</div>
			<div style="text-align:left" class="form-group">
			<label>Amount to be Credit</label>
			<input id="amount_credit" name="amount_credit" onkeypress='text_validate(event)' placeholder="Insert amount to Credit" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
			</div>
			</div>
			<div class="col-md-2"></div>
			<div class="form-group">
 
	<a id="credit_btn" name="credit_btn" style="width:20%" type="button" class="btn btn-primary"><span class="text-lg">Submit</span></a>
			<button style="width:20%;margin-left:20px" type="submit" onclick="refresh();" class="btn btn-primary" data-dismiss="modal"><span class="text-lg">Cancel</span></button>
 </div>
        </div>
        <!--<div class="modal-footer">
         
        </div>-->
      </div>
      
    </div>
  </div>
  <!--************************** Insert Credits Modal END**************************-->
  <!--************************** Revoke Credits Modal Start**************************-->
  
  <div class="modal fade" id="revoke_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header bg-primary" style='border-radius:5px 5px 0px 0px;'>
          <input type="button" value="&times;" class="close" data-dismiss="modal">
          <h4 class="modal-title">Revoke Credits from User</h4>
        </div>
        <div style="text-align:center" class="modal-body">
		<div class="col-md-2"><input type="hidden" id="hid_var2" value="<?php echo "$customer_id";?>"></div>
		<div class="col-md-8">
          <div style="text-align:left" class="form-group">
			
			<label>User Id</label>
			<input type="text" id="userid_revoke" name="userid_revoke" style="overflow-x:hidden;overflow-y:scroll" class="form-control" list="datalist_user2" placeholder="Type User Id here" autocomplete="off">
			<datalist id="datalist_user2">
			<?php
				
				$query = mysqli_query($conn, "select * from user_master where cust_id='$customer_id' order by u_id DESC");
				while($resa = mysqli_fetch_array($query))
				{
					echo "<option value='".$resa['user_id']."'>".$resa['user_id']."</option>";
				}
					
			?>
			</datalist>
			</div>
			<div style="text-align:left" class="form-group">
			<label>Amount to Revoke</label>
			<input id="amount_revoke" name="amount_revoke" placeholder="Insert amount to Revoke" style="overflow-x:hidden;overflow-y:scroll" class="form-control" onkeypress='text_validate(event)'>
			</div>
			</div>
			<div class="col-md-2"></div>
			<div class="col-md-12"><span id="revoke_done"></span></div>
			
			<div class="form-group">
 
<button id="revoke_btn" name="revoke_btn" style="width:20%" type="button" class="btn btn-primary"><span class="text-lg">Submit</span></button>
			<button style="width:20%;margin-left:20px" type="submit" onclick="refresh();" class="btn btn-primary" data-dismiss="modal"><span class="text-lg">Cancel</span></button>
 </div>
        </div>

        <!--<div class="modal-footer">
         
        </div>-->
      </div>
      
    </div>
  </div>
<!--************************** Revoke Credits Modal END**************************-->

			<div class="col-md-4">
			<div style="text-align:right" class="form-group">
			<button style="width:60%" type="submit" class="btn btn-primary" data-toggle="modal" data-target="#credit_modal"><span class="text-lg">Add Credits</span></button>
			</div>
			</div>
			<div class="col-md-4">
			<div style="text-align:left" class="form-group">
			<button style="width:60%" type="submit" class="btn btn-primary" data-toggle="modal" data-target="#revoke_modal"><span class="text-lg">Revoke Credits</span></button>
			</div>
			</div>
			<div class="col-md-3">
				<h3>User Credits Detail</h3>
			</div>
			<form method="post">
            <div class="col-md-3">
			<div class="form-group">
				<label>User Id</label>
				<input type="text" id="userid" name="userid" style="overflow-x:hidden;overflow-y:scroll" class="form-control" list="datalist_user3" placeholder="Type User Id here" autocomplete="off">
			<datalist id="datalist_user3">
				<?php
					
					$query = mysqli_query($conn, "select * from user_master where cust_id='$customer_id' order by u_id DESC");
					$count_user = mysqli_num_rows($query);
					if($count_user == 0)
					{
						echo "<option>No Record Found.</option>";
					}
					else
					{
						while($resa = mysqli_fetch_array($query))
						{
							echo "<option value='".$resa['user_id']."'>".$resa['user_id']."</option>";
						}
					}						
				?>
				</datalist>
			</div>
			</div>
			<div class="col-md-2" style="text-align:left">
			<div class="form-group">
			
			
			<?php
			if(isset($_POST['user_search']))
			{
				$user_id = $_POST['userid'];
				if(!empty($_POST['userid']))
				{
					echo "<label class='col-md-12'>&nbsp;</label>";
					$query_d  = "select * from user_master where cust_id='$customer_id' and user_id='$user_id' order by u_id desc";
					$query  = mysqli_query($conn, $query_d);
				}
				if(empty($_POST['userid']))
				{
					echo "<span style='color:red'>Select a User.</span>";
					$query_d = "select * from user_master where cust_id='$customer_id' order by u_id desc";
					$query = mysqli_query($conn, $query_d);
				}
			}
			else
			{
				echo "<label class='col-md-12'>&nbsp;</label>";
				$query_d = "select * from user_master where cust_id='$customer_id' order by u_id desc";
				$query = mysqli_query($conn, $query_d);
			}
				

			?>
			<button id="user_search" name="user_search" style="width:80%" type="submit" class="btn btn-primary"><span class="text-lg">S e a r c h</span></button>
			</div>
			</div>
			
			
            <div class="col-md-9">
			
				<div class="table-header">
				<table width="98.5%" class="table table-bordered table-hover">
				<thead>
				<tr>
				<th width='20%'>User Id</th>
				<th width='11%'>Status</th>
				<th width='17%'>Credits Assigned</th>
				<th width='15%'>Credits Used</th>
				<th width='17%'>Credits Available</th>
				<th width='20%'>Expiry Date</th>
				</tr>
				</thead>
				</table>
				</div>
				<div class="table-body" style="width:100%">
				<table width="100%" class="table table-bordered table-hover">
				<tbody style="width:100%">
				<?php
				error_reporting(0);
					if(mysqli_num_rows($query) > 0)
					{
						while($res = mysqli_fetch_array($query))
						{
							$original_date = $res['expired_on'];
							if($original_date == "0000-00-00 00:00:00")
							{
								$expiry = "";
							}
							else
							{
								$expiry = date("d-m-Y H:i:s",strtotime($original_date));
							}
							if($res['user_status'] == 0)
							{
								$user_status = "Inactive";
							}
							if($res['user_status'] == 1)
							{
								$user_status = "Active";
							}
							echo "<tr><td width='20.6%'>".$res['user_id']."</td><td width='11.4%'>".$user_status."</td><td width='17.4%'>".$res['credits_assigned']."</td><td width='15.3%'>".$res['credits_used']."</td><td width='17.3%'>".$res['credits_avialable']."</td><td>".$expiry."</td></tr>";
						}
					}
					else
					{
						echo "<tr><td width='100%' colspan='6'><center style='color:red;text-align:center;'>No Records Found</center></td></tr>";
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
				<button type="submit" value="DOWNLOAD CSV" name="download_User_credits_detail_csv" style="background:none;border:none;height:40px;width:40px"><img style="width:35px;height:35px" src="image/excel-logo.png"/></button>
				<span class="help-block" style="text-align:center;font-size:10px">Click To Download CSV.</span>
			</div>
			</form>
			</div>
<!--************************CSV DOwnload*******************************-->	
			</div>
			<!--Form End-->

						

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

</body>

</html>
