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

    <title>My Profile</title>
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
			
            <!-- Collect the nav links, forms, and other content for toggling -->
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

			<!--*****************************Logout*****************************-->
			<!--*****************************Logout*****************************-->

				<!--<ul class="nav navbar-nav">
                    <li>
                        <a href="#">About</a>
                    </li>
                    <li>
                        <a href="#">Services</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                </ul>-->
            
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
                    <a href="my_profile.php" class="list-group-item active"><i class="fa fa-user" aria-hidden="true"></i>  &emsp;My Profile</a>
                    <a href="create_user.php" class="list-group-item"><i class="fa fa-pencil" aria-hidden="true"></i>  &emsp;Create User</a>
                    <a href="update_user.php" class="list-group-item"><i class="fa fa-eraser" aria-hidden="true"></i>  &emsp;Update user</a>
					<a href="request_sender_id.php" class="list-group-item"><i class="fa fa-indent" aria-hidden="true"></i>  &emsp;Request Sender Id</a>
					<a href="request_template.php" class="list-group-item"><i class="fa fa-file-image-o" aria-hidden="true"></i> &emsp;Template Approval</a>
					<a href="javascript:;" data-toggle="collapse" data-target="#demo1" class="list-group-item"><i class="fa fa-money" aria-hidden="true"></i>&emsp; Credits Management <i class="fa fa-fw fa-caret-down"></i></a>
                        <p id="demo1" class="collapse">
                                 <a class="list-group-item" href="credit_management_reseller.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> My Credit History&emsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-history" aria-hidden="true"></i></a>
                                <a class="list-group-item" href="credit_assignment_user.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> Credit Assignment&emsp;&nbsp; <i class="fa fa-plus" aria-hidden="true"></i></a>
                                <a class="list-group-item" href="credit_history_user.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> User Credit History&emsp; <i class="fa fa-history" aria-hidden="true"></i></a>
                            
                        </p>
                </div>
            </div>
			
			<div class="col-md-7">

                <h2>Account Information</h2>
                        <div class="table-responsive" style="width:100%;overflow-x:auto;">
                            <table class="table table-bordered table-hover">
                                <tbody>
								<?php
								$query = mysqli_query($conn,"select * from cust_master where cust_id='$customer_id'");
								$res = mysqli_fetch_array($query);
								$priority = "";
								$originalDate1 = $res['creation_date'];
									if($originalDate1=="0000-00-00 00:00:00")
									{
										$created_date = "";
									}
									else
									{
										$created_date = date("d-m-Y", strtotime($originalDate1));
									}
									$originalDate2 = $res['updated_on'];
									if($originalDate2=="")
									{
										$updated_date = "";
									}
									else
									{
										$updated_date = date("d-m-Y", strtotime($originalDate2));
									}
									$originalDate3 = $res['expired_on'];
									if($originalDate3 == "0000-00-00 00:00:00")
									{
										$expired_date = "";
									}
									else
									{
										$expired_date = date("d-m-Y", strtotime($originalDate3));
									}
								
								
								if($query)
								{
									if($res['enable_priority'] == 1)
									{
										$priority = "High(Max)";
									}
									else if($res['enable_priority'] == 2)
									{
										$priority = "High(Min)";
									}
									else if($res['enable_priority'] == 3)
									{
										$priority = "Mid(Max)";
									}
									else if($res['enable_priority'] == 4)
									{
										$priority = "Mid(Min)";
									}
									else if($res['enable_priority'] == 5)
									{
										$priority = "Low(Max)";
									}
									else
									{
										$priority = "Low(Min)";
									}
								}
								$routing = "";
								if($query)
								{
									if($res['enable_routing'] == 0)
									{
										$routing = "Disable";
									}
									else
									{
										$routing = "Enable";
									}
									if($res['create_sender'] == 0)
									{
										$create_sender = "Disable";
									}
									else
									{
										$create_sender = "Enable";
									}

								}
								?>
								<tr>
								<td><b>Customer Id</b></td>
								<td><?php echo $res['cust_id'];?></td>
								</tr>
								<tr>
								<td><b>Description</b></td>
								<td><?php echo $res['description'];?></td>
								</tr>
								<tr>
								<td><b>Customer Name</b></td>
								<td><?php echo $res['cust_name'];?></td>
								</tr>
								<tr>
								<td><b>Address</b></td>
								<td><?php echo $res['contact_address'];?></td>
								</tr>
								<tr>
								<td><b>state</b></td>
								<td><?php echo $res['state'];?></td>
								</tr>
								<tr>
								<td><b>City</b></td>
								<td><?php echo $res['city'];?></td>
								</tr>
								<tr>
								<td><b>Licenses</b></td>
								<td><?php echo $res['licenses'];?></td>
								</tr>
								<tr>
								<td><b>Credits Available</b></td>
								<td><?php echo $res['credits_assigned'];?></td>
								</tr>
								<tr>
								<td><b>Expired On</b></td>
								<td><?php echo $expired_date;?></td>
								</tr>
								<tr>
								<td><b>Email</b></td>
								<td><?php echo $res['email'];?></td>
								</tr>
								<tr>
								<td><b>Provider Id</b></td>
								<td><?php echo $res['provider_id'];?></td>
								</tr>
								<tr>
								<td><b>Copy Right</b></td>
								<td><?php echo $res['copy_right'];?></td>
								</tr>
								<tr>
								<td><b>Create Sender</b></td>
								<td><?php echo $create_sender;?></td>
								</tr>
								<tr>
								<td><b>Priority</b></td>
								<td><?php echo $priority;?></td>
								</tr>
								<td><b>Routing</b></td>
								<td><?php echo $routing;?></td>
								</tr>
								<tr>
								<td><b>Created On</b></td>
								<td><?php echo $created_date;?></td>
								</tr>
								<td><b>Updated On</b></td>
								<td><?php echo $updated_date;?></td>
								</tr>
								<tr>
								<td><b>Sales Account Manager</b></td>
								<td><?php echo $res['sales_acc_mngr'];?></td>
								</tr>
								</tbody>
							</table>
							</div>
						</div>

            
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

</body>

</html>
