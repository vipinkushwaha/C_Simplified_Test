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

    <title>My Credit History</title>
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
	
	
	<!--	.table-fixed thead
	{
	  width: 100%;
	}
	.table-fixed tbody
	{
	  height: 350px;
	  overflow-y: auto;
	  width: 100%;
	  display: block;
	}
	.table-fixed thead, .table-fixed tbody
	{
	  display: block;
	}
	
	</style>-->
	

	
	<script>





//*****************Search Reseller***************************
/*$(document).ready(function(){
	$('#search_btn').click(function(){
	var date_from = $('#date_picker').val();
	var date_to = $('#date_picker1').val();
	var cust_id = $('#hid_var').val();
	
	$.ajax({
                type:"POST",
                url:"search_reseller_history_ajax.php",
                data:"from_date="+date_from+"&to_date="+date_to+"&userid="+user_id,
                success:function(html)
				{
                    //alert(e);
					$("#body_text").html(html);
					//$(location).attr('href',request_template.php);
                }
            }); 
	});
});*/

//*****************Search Reseller***************************
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
<?php $conn = mysqli_connect("localhost","root","","vipin");

	$query_d = "";
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
			<div class="col-md-9">
			<form method="post">
            <div class="col-md-12">
			<input type="hidden" name="hid_var" id="hid_var" value="<?php echo $customer_id;?>">
			<h3>Search By Created On:</h3>
			<div class="col-md-6">
			<div class="form-group">
			<label>Search By Date</label>
            <input type="text" id="date_picker" name="created_approved1" placeholder="From Date" class="form-control datepicker">
			</div>
			</div>
			<div class="col-md-6">
			<div class="form-group">
			<label>&nbsp;</label>
            <input type="text" id="date_picker1" name="created_approved2" placeholder="To Date" class="form-control datepicker">
			</div>
			</div>
			</div>
			
			
           

            <div style="text-align:center" class="col-md-12">
			<!-- <div style="text-align:center" class="col-md-4"> -->
			<div class="col-md-6"></div>
			<div class="col-md-6">
			<div class="form-group">
				<button id="Search_btn" name="search_btn" style="width:60%" type="submit" class="btn btn-primary"><span class="text-lg">SEARCH</span></button>
			</div>
			</div>
			<!-- </div> -->
			<!-- <div style="text-align:center" class="col-md-4"> -->
			<!-- <div class="form-group">
				<button id="download_csv" name="download_csv" style="width:60%" type="submit" class="btn btn-primary"><span class="text-lg">Download CSV</span></button>
			</div> -->
			
			
			
			<?php
			error_reporting(0);
				$created_approved1 = $_POST['created_approved1'];
				$created_approved2 = $_POST['created_approved2'];
				$date_from = date("Y-m-d 00:00:00", strtotime($created_approved1));
				$date_to = date("Y-m-d 23:59:59", strtotime($created_approved2));
				if(isset($_POST['search_btn']))
				{
					//echo "$created_approved1";
					//echo "$created_approved2";
					//echo "select * from customer_credits_history where customerid='$user_id' and created_date>='$date_from' and created_date<='$date_to'";
					//echo "$date_to";
					if($created_approved1 != "" && $created_approved2 != "")
					{
						//$output = fopen("php://output", "w"); 
						//fputcsv($output, array('Customer Id', 'Credits Recharged', 'Credits Revoked', 'Created Date')); 
						$query_d = "select * from customer_credits_history where customerid='$customer_id' and created_date>='$date_from' and created_date<='$date_to' order by id desc";
						$query = mysqli_query($conn, $query_d);
					}
					if(!empty($created_approved1) && empty($created_approved2))
					{
						//$output = fopen("php://output", "w"); 
						//fputcsv($output, array('Customer Id', 'Credits Recharged', 'Credits Revoked', 'Created Date'));
						$query_d = "select * from customer_credits_history where customerid='$customer_id' and created_date='$date_from' order by id desc";
						$query = mysqli_query($conn, $query_d);
					}
					if(empty($created_approved1) && empty($created_approved2))
					{
						echo "<center style='color:red'>Please select date.</center>";
					}
				}
				if(!isset($_POST['search_btn']))
				{
					//$output = fopen("php://output", "w"); 
					//fputcsv($output, array('Customer Id', 'Credits Recharged', 'Credits Revoked', 'Created Date'));
					$query_d = "select * from customer_credits_history where customerid='$customer_id' order by id desc";
					$query = mysqli_query($conn, $query_d);
				}
				
?>
			<!-- </div> -->
            </div>
			<div class="col-md-12">
                
				<div class="col-md-12"><h3>Credits History</h3></div>
			<!--<div class="col-md-12" style="overflow-y:scroll;overflow-x:auto;max-height:380pt">-->
			
				<!--<table class="table table-bordered table-hover table-fixed">-->
				<div class="table-header">
				<table width="98.5%" class="table table-bordered table-hover">
				<thead>
				<tr>
				<th width='8.4%'>Id</th>
				<th width="31.3%">Credit <span style='color:#969798'>(cr)</span> / Debit <span style='color:#969798'>(dr)</span></th>
				<th width="28.8%">Credit Revoked</th>
				<th>Created Date</th>
				</tr>
				</thead>
				</table>
				</div>
				<div class="table-body" style="width:100%">
				<table width="100%" class="table table-bordered table-hover">
				<tbody style="width:100%" id="body_text">
				<?php
				//error_reporting(0);
				
				$check_string = strval($res['credits_recharged']);
				//echo substr("-vipin kushwaha",0,1);
				//if($res['credits_recharged'] == )
				$id = 1;
			
					if(mysqli_num_rows($query) > 0)
					{
						while($res = mysqli_fetch_assoc($query))
						{
							$created_date = date("d-m-Y H:i:s", strtotime($res['created_date']));
							//echo ;
							
							/*$file = fopen("csv/History.csv","w") or die("CANNOT READ FILE");
								fputcsv($file, array('Customer Id', 'Credits Recharged', 'Credits Revoked', 'Created Date'));
								fputcsv($file,$res);*/
							if(substr($res['credits_recharged'],0,1) == "-" && $res['credits_revoked'] == 0)
							{
								echo "<tr><td width='8.6%'>".$id++."</td><td width='31.7%'>".substr($res['credits_recharged'],1)." <span style='color:#969798'>dr</span></td><td width='29.5%'>".$res['credits_revoked']."</td><td width='30.2%'>".$created_date."</td></tr>";
								
								
							}
							else if($res['credits_recharged'] == 0 && substr($res['credits_revoked'],0,1) == "-")
							{
								echo "<tr><td width='8.6%'>".$id++."</td><td width='31.7%'>".$res['credits_recharged']."</td><td width='29.5%'>".substr($res['credits_revoked'],1)." <span style='color:#969798'>(By Admin)</span></td><td width='30.2%'>".$created_date."</td></tr>";
								$file = fopen("csv/History.csv","w") or die("CANNOT READ FILE");
								fputcsv($file, array('Customer Id', 'Credits Recharged', 'Credits Revoked', 'Created Date'));
								fputcsv($file,$res);
							}
							else if($res['credits_recharged'] != 0 && $res['credits_revoked'] == 0)
							{
								echo "<tr><td width='8.6%'>".$id++."</td><td width='31.7%'>".$res['credits_recharged']." <span style='color:#969798'>cr</span></td><td width='29.5%'>".$res['credits_revoked']."</td><td width='30.2%'>".$created_date."</td></tr>";
								$file = fopen("csv/History.csv","w") or die("CANNOT READ FILE");
								fputcsv($file, array('Customer Id', 'Credits Recharged', 'Credits Revoked', 'Created Date'));
								fputcsv($file,$res);
							}
							//$mes = substr("-vipin kushwaha",0,1);
							else
							{
								echo "<tr><td width='8.6%'>".$id++."</td><td width='31.7%'>".$res['credits_recharged']."</td><td width='29.5%'>".$res['credits_revoked']." <span style='color:#969798'>(By Reseller)</span></td><td width='30.2%'>".$created_date."</td></tr>";
								$file = fopen("csv/History.csv","w") or die("CANNOT READ FILE");
								fputcsv($file, array('Customer Id', 'Credits Recharged', 'Credits Revoked', 'Created Date'));
								fputcsv($file,$res);
							}
						}
					}
					else
					{
						echo "<tr><td width='100%' colspan='6'><center style='color:red;'>No Records Found</center></td></tr>";
					}
				?>
				</tbody>
				</table>
			</div>

			

            </div>
			</form>
			
			<!--************************CSV DOwnload*******************************-->			
			<div class="col-md-1">
			<form method="post" action="csv_download.php">
			<input type="hidden" name="csv_query" value="<?php echo $query_d; ?>">
			<div style="text-align:center" class="form-group">
				<button type="submit" value="DOWNLOAD CSV" name="download_customer_history_csv" style="background:none;border:none;height:40px;width:40px"><img style="width:35px;height:35px" src="image/excel-logo.png"/></button>
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
