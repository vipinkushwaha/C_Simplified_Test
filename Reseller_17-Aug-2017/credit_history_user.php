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

    <title>Credit History User</title>
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
	<!--date picker -->
	<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
	<!--date picker -->

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
				
			

			
			
			<form method="post">
			
            <div class="col-md-9">
			<h3>Search User</h3>
			<div class="col-md-4">
			<div class="form-group">
				<label>User Id</label>
				<input type="text" id="userid" name="userid" style="overflow-x:hidden;overflow-y:scroll" class="form-control" list="datalist_user2" placeholder="Type User Id here" autocomplete="off">
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
			</div>
			<div class="col-md-4">
			<div class="form-group">
			<label>Search By Date</label>
            <input type="text" id="date_picker" name="created_approved1" placeholder="From Date" class="form-control datepicker">
			</div>
			</div>
			<div class="col-md-3">
			<div class="form-group">
			<label>&nbsp;</label>
            <input type="text" id="date_picker1" name="created_approved2" placeholder="To Date" class="form-control datepicker">
			</div>
			</div>
			</div>
			<?php
			error_reporting(0);
				$user_id = $_POST['userid'];
				$created_approved1 = $_POST['created_approved1'];
				$created_approved2 = $_POST['created_approved2'];
				$date_from = date("Y-m-d 00:00:00", strtotime($created_approved1));
				$date_to = date("Y-m-d 23:59:59", strtotime($created_approved2));
				if(isset($_POST['search_btn']))
				{
					if(!empty($user_id) && empty($created_approved1 && $created_approved2))
					{
						$query_d = "select * from credits_history where userid='$user_id' order by id DESC";
						$query = mysqli_query($conn, $query_d);
						
					}
					else if(!empty($user_id && $created_approved1 && $created_approved2))
					{
						$query_d = "select * from credits_history where userid='$user_id' and created_date>='$date_from' and created_date<='$date_to' order by id DESC";
						$query = mysqli_query($conn, $query_d);
					}
					else
					{
						echo "<center style='color:red'>Empty User Id.</center>";
						$query_d = "";
						$query = 0;
						
					}
				}
				if(!isset($_POST['search_btn']))
				{
					$query_d = "";
					$query = 0;
				}
			?>
            <div style="text-align:center" class="col-md-8">
			<div class="form-group">
				<button id="Search_btn" name="search_btn" style="width:20%" type="submit" class="btn btn-primary"><span class="text-lg">SEARCH</span></button>
			</div>
			</div>
			<div class="col-md-8">
				<h3>Users Credits History</h3>
			</div>
            <div class="col-md-3">
			</div>
			<div class="col-md-9">
			
				<div class="table-header">
				<table width="98.5%" class="table table-bordered table-hover">
				<thead>
				<tr>
				<th width="17%">User Id</th>
				<th width="14%">Credits Added</th>
				<th width="15%">Credits Debited</th>
				<th width="16%">Credits Revoked</th>
				<th width="16%">Credits Available</th>
				<th width="27%">Created On</th>
				</tr>
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
							echo "<tr><td width='17.4%'>".$res['userid']."</td><td width='14.4%'>".$res['credits_recharged']."</td><td width='15.4%'>".$res['credits_debited']."</td><td width='16.3%'>".$res['credits_revoked']."</td><td width='16.4%'>".$res['credits_available']."</td><td>".$res['created_date']."</td></tr>";
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
				<button type="submit" value="DOWNLOAD CSV" name="download_User_credits_history_csv" style="background:none;border:none;height:40px;width:40px"><img style="width:35px;height:35px" src="image/excel-logo.png"/></button>
				<span class="help-block" style="text-align:center;font-size:10px">Click To Download CSV.</span>
			</div>
			</form>
			</div>
<!--************************CSV DOwnload*******************************-->
			</div>
		</div>
		<div class="col-md-3"></div>

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
		$( "#date_picker" ).datepicker();
		//$( "#date_picker" ).datepicker("show");   
		$( "#date_picker1" ).datepicker();
		//$( "#date_picker1" ).datepicker("show");
		});
	</script>
	<!--date picker -->


</body>

</html>