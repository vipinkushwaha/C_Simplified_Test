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

    <title>Dashboard</title>
    <link rel="icon" type="image/png" href="image/icon.png" />
    <!-- ********************Pie Chart******************* -->
    <script src="js/anychart-bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.anychart.com/css/7.14.3/anychart-ui.min.css" />
    <!-- ********************Pie Chart******************* -->
    <!--date picker -->
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
    <!--date picker -->

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

	<!--*****************************************-->
	
	<!--*****************************************-->
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
.datalist_user2
{
    overflow: scroll;
    max-height: 100px;
}
</style>
	
	
</head>

<body>
<?php $conn = mysqli_connect("localhost","root","","vipin") or die($conn->connect_error);
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
                    <a href="dashboard.php" class="list-group-item active"><i class="fa fa-dashboard" aria-hidden="true"></i>  &emsp;Dashboard</a>
                    <a href="my_profile.php" class="list-group-item"><i class="fa fa-user" aria-hidden="true"></i>  &emsp;My Profile</a>
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
			
			<div class="col-md-9">

        <?php
        //$query_count = mysqli_query($conn, "select created_on from sms_log where date(created_on)= (curdate())");
        $query = mysqli_query($conn, "select count(*) as testa,sum(CASE WHEN dlr_status='DELIVRD' THEN sms_splits ELSE 0 END ) as DL, sum(CASE WHEN (dlr_status='EXPIRED') THEN (sms_splits) WHEN (dlr_status='N/A') THEN (sms_splits) WHEN (dlr_status='UNDELIV') THEN (sms_splits) WHEN (dlr_status='REJECTD') THEN (sms_splits) WHEN (dlr_status='EXP-ABS-SUB') THEN (sms_splits) WHEN (dlr_status='EXP-MEM-EXCD') THEN (sms_splits) WHEN (dlr_status='EXP-NW-TMOUT') THEN (sms_splits) WHEN (dlr_status='FAILED') THEN (sms_splits) ELSE 0 END) as FL, sum(CASE WHEN dlr_status='' THEN sms_splits ELSE 0 END) as PEN, sum(sms_splits) as SPL from sms_log where cust_id='$customer_id' and date(created_on)= (curdate())");
        $res_today = mysqli_fetch_array($query);
        if($res_today['testa'] == 0)
        {
        echo "<div class='col-lg-8'>
            <div class='row' style='margin:0px auto;'>
            <div id='container' style='width:700px;height:400px;'></div>
            
            <script type='text/javascript'>
                anychart.onDocumentReady(function () {

                    var data = [{name: 'In Queue', value: 0, fill:'#337ab7'},
                        {name: 'Delivered', value: 0, fill:'#5cb85c'},
                        {name: 'Failed', value: 0, fill:'#d9534f'},
                        {name: 'No Data Found', value: 1, fill:'#272822'},];
                    chart = anychart.pie3d(data);
                    chart.title('No Traffic for Today')
                            .radius('60%');
                    chart.container('container');
                    chart.draw();
                });
            </script>
            </div>
            </div>
            <div class='col-lg-4'>
            <table border='1' cellpadding='0' cellspacing='2' style='border-color:#E6E6FA;border-radius:50px'>
            <tr>
            <td style='background:#337ab7;' width='30%'>&nbsp;</td><td>&emsp;<b>0</b>&emsp;</td>
            </tr>
            <tr>
            <td style='background:#5cb85c;' width='30%'>&nbsp;</td><td>&emsp;<b>0</b>&emsp;</td>
            </tr>
            <tr>
            <td style='background:#d9534f;' width='30%'>&nbsp;</td><td>&emsp;<b>0</b>&emsp;</td>
            </tr>
            <tr>
            <td style='background:#800080;' width='30%'>&nbsp;</td><td>&emsp;<b>0</b>&emsp;</td>
            </tr>
            </table>
            </div>";
}
else
{
    
    $count_pending = $res_today['PEN'];
    $count_delivered = $res_today['DL'];
    $count_failed = $res_today['FL'];
    $count_total = $res_today['SPL'];
    echo "<div class='col-lg-8'>
        <div class='row' style='margin:0px auto;'>
        <div id='container' style='width:700px;height:400px;'></div>
        
<script type='text/javascript'>
anychart.onDocumentReady(function () {

    var data = [{name: 'In Queue', value: $count_pending, fill:'#337ab7'},
        {name: 'Delivered', value: $count_delivered, fill:'#5cb85c'},
        {name: 'Failed', value: $count_failed, fill:'#d9534f'},
        {name: 'Total', fill:'#800080'},];
    chart = anychart.pie3d(data);
    chart.title('Today\'s Traffic')
            .radius('60%');
    chart.container('container');
    chart.draw();
});
        </script>
</div>
</div>
<div class='col-lg-4'>
<table border='1' cellpadding='0' cellspacing='2' style='border-color:#E6E6FA;border-radius:50px'>
<tr>
<td style='background:#337ab7;' width='30%'>&nbsp;</td><td>&emsp;<b>$count_pending</b>&emsp;</td>
</tr>
<tr>
<td style='background:#5cb85c;' width='30%'>&nbsp;</td><td>&emsp;<b>$count_delivered</b>&emsp;</td>
</tr>
<tr>
<td style='background:#d9534f;' width='30%'>&nbsp;</td><td>&emsp;<b>$count_failed</b>&emsp;</td>
</tr>
<tr>
<td style='background:#800080;' width='30%'>&nbsp;</td><td>&emsp;<b>$count_total</b>&emsp;</td>
</tr>

</table>
</div>";
}
?>

</div>


 <!-- Form Start -->

                <form method="post">
                <div class="row" style="margin-top:450px" id="maindiv">
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                        <div class="col-lg-4">
                        <div class="form-group">
                        <label>User Id</label>
                        <input id="userid" name="userid" class="form-control" list="datalist_user" placeholder="Type User Id here" autocomplete="off">
                        <div style="max-height:100px">
                        <datalist id="datalist_user" class="datalist_user2" style="overflow-y:scroll;max-height:10px">
                        <?php
                             $query = mysqli_query($conn, "select user_id from sms_log where cust_id='$customer_id' order by sms_log_id DESC");
                             //$query_d = "select * from sms_log where cust_id='$customer_id' order by sms_log_id DESC";
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
                        ?>
                        </datalist>
                    </div>
                        </div>
                        </div>
                        <div class="col-lg-4">
                        <div class="form-group">
                        <label>Created On (MM/DD/YYYY)</label>
                        <input id="created_on" name="created_on" class="form-control" type="text">
                        </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="col-lg-12">&nbsp;</label>
                                <button id="Search_btn" name="search_btn" style="width:60%" type="submit" class="btn btn-primary"><span class="text-lg">SEARCH</span></button>
                            </div>
                        </div>
                        </div>
                        <?php
                                    //@$body_data = array();
                                    //echo $body_data;
                            @$user_id = $_POST['userid'];
                            @$created_date = $_POST['created_on'];
                            if(isset($_POST['search_btn']))
                            {
                                if(empty($user_id) && empty($created_date))
                                {
                                    $id = 1;
                                    $query = mysqli_query($conn, "select user_id,msgfrom,count(*) as testa,sum(CASE WHEN dlr_status='DELIVRD' THEN sms_splits ELSE 0 END ) as DL, sum(CASE WHEN (dlr_status='EXPIRED') THEN (sms_splits) WHEN (dlr_status='N/A') THEN (sms_splits) WHEN (dlr_status='UNDELIV') THEN (sms_splits) WHEN (dlr_status='REJECTD') THEN (sms_splits) WHEN (dlr_status='EXP-ABS-SUB') THEN (sms_splits) WHEN (dlr_status='EXP-MEM-EXCD') THEN (sms_splits) WHEN (dlr_status='EXP-NW-TMOUT') THEN (sms_splits) WHEN (dlr_status='FAILED') THEN (sms_splits) ELSE 0 END) as FL, sum(CASE WHEN dlr_status='' THEN sms_splits ELSE 0 END) as PEN, sum(sms_splits) as SPL from sms_log where cust_id='$customer_id' and date(created_on)= (curdate()) group by user_id,msgfrom");
                                    $query_d = "select user_id,msgfrom,count(*) as testa,sum(CASE WHEN dlr_status='DELIVRD' THEN sms_splits ELSE 0 END ) as DL, sum(CASE WHEN (dlr_status='EXPIRED') THEN (sms_splits) WHEN (dlr_status='N/A') THEN (sms_splits) WHEN (dlr_status='UNDELIV') THEN (sms_splits) WHEN (dlr_status='REJECTD') THEN (sms_splits) WHEN (dlr_status='EXP-ABS-SUB') THEN (sms_splits) WHEN (dlr_status='EXP-MEM-EXCD') THEN (sms_splits) WHEN (dlr_status='EXP-NW-TMOUT') THEN (sms_splits) WHEN (dlr_status='FAILED') THEN (sms_splits) ELSE 0 END) as FL, sum(CASE WHEN dlr_status='' THEN sms_splits ELSE 0 END) as PEN, sum(sms_splits) as SPL from sms_log where cust_id='$customer_id' and date(created_on)= (curdate()) group by user_id,msgfrom";
                                    date_default_timezone_set('Asia/Kolkata');
                                    $created_date = date("d-M-Y");
                                }
                                if(!empty($user_id) && empty($created_date))
                                {
                                    $id = 1;
                                    $query = mysqli_query($conn, "select user_id,msgfrom,count(*) as testa,sum(CASE WHEN dlr_status='DELIVRD' THEN sms_splits ELSE 0 END ) as DL, sum(CASE WHEN (dlr_status='EXPIRED') THEN (sms_splits) WHEN (dlr_status='N/A') THEN (sms_splits) WHEN (dlr_status='UNDELIV') THEN (sms_splits) WHEN (dlr_status='REJECTD') THEN (sms_splits) WHEN (dlr_status='EXP-ABS-SUB') THEN (sms_splits) WHEN (dlr_status='EXP-MEM-EXCD') THEN (sms_splits) WHEN (dlr_status='EXP-NW-TMOUT') THEN (sms_splits) WHEN (dlr_status='FAILED') THEN (sms_splits) ELSE 0 END) as FL, sum(CASE WHEN dlr_status='' THEN sms_splits ELSE 0 END) as PEN, sum(sms_splits) as SPL from sms_log where user_id='".$user_id."' and cust_id='$customer_id' and date(created_on)= (curdate()) group by user_id,msgfrom");
                                    $query_d = "select user_id,msgfrom,count(*) as testa,sum(CASE WHEN dlr_status='DELIVRD' THEN sms_splits ELSE 0 END ) as DL, sum(CASE WHEN (dlr_status='EXPIRED') THEN (sms_splits) WHEN (dlr_status='N/A') THEN (sms_splits) WHEN (dlr_status='UNDELIV') THEN (sms_splits) WHEN (dlr_status='REJECTD') THEN (sms_splits) WHEN (dlr_status='EXP-ABS-SUB') THEN (sms_splits) WHEN (dlr_status='EXP-MEM-EXCD') THEN (sms_splits) WHEN (dlr_status='EXP-NW-TMOUT') THEN (sms_splits) WHEN (dlr_status='FAILED') THEN (sms_splits) ELSE 0 END) as FL, sum(CASE WHEN dlr_status='' THEN sms_splits ELSE 0 END) as PEN, sum(sms_splits) as SPL from sms_log where user_id='".$user_id."' and cust_id='$customer_id' and date(created_on)= (curdate()) group by user_id,msgfrom";
                                    date_default_timezone_set('Asia/Kolkata');
                                    $created_date = date("d-M-Y");
                                }
                                if(!empty($created_date) && empty($user_id))
                                {
                                    $id = 1;
                                    $created_date = date("Y-m-d", strtotime($created_date));
                                    $query = mysqli_query($conn, "select user_id,msgfrom,count(*) as testa,sum(CASE WHEN dlr_status='DELIVRD' THEN sms_splits ELSE 0 END ) as DL, sum(CASE WHEN (dlr_status='EXPIRED') THEN (sms_splits) WHEN (dlr_status='N/A') THEN (sms_splits) WHEN (dlr_status='UNDELIV') THEN (sms_splits) WHEN (dlr_status='REJECTD') THEN (sms_splits) WHEN (dlr_status='EXP-ABS-SUB') THEN (sms_splits) WHEN (dlr_status='EXP-MEM-EXCD') THEN (sms_splits) WHEN (dlr_status='EXP-NW-TMOUT') THEN (sms_splits) WHEN (dlr_status='FAILED') THEN (sms_splits) ELSE 0 END) as FL, sum(CASE WHEN dlr_status='' THEN sms_splits ELSE 0 END) as PEN, sum(sms_splits) as SPL from sms_log where cust_id='$customer_id' and date(created_on)=('".$created_date."') group by user_id,msgfrom");  
                                    $query_d = "select user_id,msgfrom,count(*) as testa,sum(CASE WHEN dlr_status='DELIVRD' THEN sms_splits ELSE 0 END ) as DL, sum(CASE WHEN (dlr_status='EXPIRED') THEN (sms_splits) WHEN (dlr_status='N/A') THEN (sms_splits) WHEN (dlr_status='UNDELIV') THEN (sms_splits) WHEN (dlr_status='REJECTD') THEN (sms_splits) WHEN (dlr_status='EXP-ABS-SUB') THEN (sms_splits) WHEN (dlr_status='EXP-MEM-EXCD') THEN (sms_splits) WHEN (dlr_status='EXP-NW-TMOUT') THEN (sms_splits) WHEN (dlr_status='FAILED') THEN (sms_splits) ELSE 0 END) as FL, sum(CASE WHEN dlr_status='' THEN sms_splits ELSE 0 END) as PEN, sum(sms_splits) as SPL from sms_log where cust_id='$customer_id' and date(created_on)=('".$created_date."') group by user_id,msgfrom";  
                                    $created_date = date("d-M-Y", strtotime($created_date));
                                }
                                if(!empty($user_id) && !empty($created_date))
                                {
                                    $id = 1;
                                    $created_date = date("Y-m-d", strtotime($created_date));
                                    $query = mysqli_query($conn, "select user_id,msgfrom,count(*) as testa,sum(CASE WHEN dlr_status='DELIVRD' THEN sms_splits ELSE 0 END ) as DL, sum(CASE WHEN (dlr_status='EXPIRED') THEN (sms_splits) WHEN (dlr_status='N/A') THEN (sms_splits) WHEN (dlr_status='UNDELIV') THEN (sms_splits) WHEN (dlr_status='REJECTD') THEN (sms_splits) WHEN (dlr_status='EXP-ABS-SUB') THEN (sms_splits) WHEN (dlr_status='EXP-MEM-EXCD') THEN (sms_splits) WHEN (dlr_status='EXP-NW-TMOUT') THEN (sms_splits) WHEN (dlr_status='FAILED') THEN (sms_splits) ELSE 0 END) as FL, sum(CASE WHEN dlr_status='' THEN sms_splits ELSE 0 END) as PEN, sum(sms_splits) as SPL from sms_log where cust_id='$customer_id' and user_id='".$user_id."' and date(created_on)=('".$created_date."') group by user_id,msgfrom");
                                    $query_d = "select user_id,msgfrom,count(*) as testa,sum(CASE WHEN dlr_status='DELIVRD' THEN sms_splits ELSE 0 END ) as DL, sum(CASE WHEN (dlr_status='EXPIRED') THEN (sms_splits) WHEN (dlr_status='N/A') THEN (sms_splits) WHEN (dlr_status='UNDELIV') THEN (sms_splits) WHEN (dlr_status='REJECTD') THEN (sms_splits) WHEN (dlr_status='EXP-ABS-SUB') THEN (sms_splits) WHEN (dlr_status='EXP-MEM-EXCD') THEN (sms_splits) WHEN (dlr_status='EXP-NW-TMOUT') THEN (sms_splits) WHEN (dlr_status='FAILED') THEN (sms_splits) ELSE 0 END) as FL, sum(CASE WHEN dlr_status='' THEN sms_splits ELSE 0 END) as PEN, sum(sms_splits) as SPL from sms_log where cust_id='$customer_id' and user_id='".$user_id."' and date(created_on)=('".$created_date."') group by user_id,msgfrom";
                                    $created_date = date("d-M-Y", strtotime($created_date));
                                }
                                $result_array = array();
                                $count = mysqli_num_rows($query);
                                    if($count == 0)
                                    {
                                        $result_array[] = "<td colspan='4' style='color:red;text-align:center'>No Record Found</td>";
                                    }
                                    else
                                    {
                                        while($res = mysqli_fetch_array($query))
                                        {
                                            $user = $res['user_id'];
                                            $msgfrom = $res['msgfrom'];
                                            $cre_date = $res['created_on'];

                                           
                                            //******************************
                                            $days_to_expire = mysqli_query($conn, "SELECT expired_on,credits_assigned,credits_avialable,DATEDIFF(expired_on, CURDATE()) AS days_left FROM user_master WHERE user_id='".$res['user_id']."'");
                                            $res_rem_days = mysqli_fetch_assoc($days_to_expire);
                                            //******************************
                                            //$query_expiry = mysqli_query($conn, "select expired_on from user_master where user_id='".$res['user_id']."'");
                                            //$res_expiry = mysqli_fetch_array($query_expiry);
                                            $expiry = date("d-m-Y H:i:s", strtotime($res_rem_days['expired_on']));
                                            
                                            $days_rem = $res_rem_days['days_left'];    
                                            if(substr($days_rem,0,1) == "-")
                                            {
                                                $result_array[] = "<tr><td width='4.1%'>".$id++."</td><td width='20.4%'>".$user."</td><td width='12.3%'>".$msgfrom."</td><td width='8.2%'>".$res['PEN']."</td><td width='8.1%'>".$res['DL']."</td><td width='8.1%'>".$res['FL']."</td><td width='10.2%'>".$res['SPL']."</td><td>".$res_rem_days['credits_assigned']."</td><td>".$res_rem_days['credits_avialable']."</td><td width='20.3%'>".$expiry."</td><td><span style='color:red'>Expired</span></td></tr>";
                                                
                                                //header('Location: script.php#bottomOfPage');
                                            }
                                            else
                                            {
                                                $result_array[] = "<tr><td width='4.1%'>".$id++."</td><td width='20.4%'>".$user."</td><td width='12.3%'>".$msgfrom."</td><td width='8.2%'>".$res['PEN']."</td><td width='8.1%'>".$res['DL']."</td><td width='8.1%'>".$res['FL']."</td><td width='10.2%'>".$res['SPL']."</td><td>".$res_rem_days['credits_assigned']."</td><td>".$res_rem_days['credits_avialable']."</td><td width='20.3%'>".$expiry."</td><td>".$days_rem." <span style='color:green'>Days</span></td></tr>";
                                                
                                                //header('Location: script.php#bottomOfPage');
                                            }


                                        }
                                        
                                        
                                    }
                            }
                            else
                            {
                                $id = 1;
                                $query = mysqli_query($conn, "select user_id,msgfrom,count(*) as testa,sum(CASE WHEN dlr_status='DELIVRD' THEN sms_splits ELSE 0 END ) as DL, sum(CASE WHEN (dlr_status='EXPIRED') THEN (sms_splits) WHEN (dlr_status='N/A') THEN (sms_splits) WHEN (dlr_status='UNDELIV') THEN (sms_splits) WHEN (dlr_status='REJECTD') THEN (sms_splits) WHEN (dlr_status='EXP-ABS-SUB') THEN (sms_splits) WHEN (dlr_status='EXP-MEM-EXCD') THEN (sms_splits) WHEN (dlr_status='EXP-NW-TMOUT') THEN (sms_splits) WHEN (dlr_status='FAILED') THEN (sms_splits) ELSE 0 END) as FL, sum(CASE WHEN dlr_status='' THEN sms_splits ELSE 0 END) as PEN, sum(sms_splits) as SPL from sms_log where cust_id='$customer_id' and date(created_on)= (curdate()) group by user_id,msgfrom");
                                $query_d = "select user_id,msgfrom,count(*) as testa,sum(CASE WHEN dlr_status='DELIVRD' THEN sms_splits ELSE 0 END ) as DL, sum(CASE WHEN (dlr_status='EXPIRED') THEN (sms_splits) WHEN (dlr_status='N/A') THEN (sms_splits) WHEN (dlr_status='UNDELIV') THEN (sms_splits) WHEN (dlr_status='REJECTD') THEN (sms_splits) WHEN (dlr_status='EXP-ABS-SUB') THEN (sms_splits) WHEN (dlr_status='EXP-MEM-EXCD') THEN (sms_splits) WHEN (dlr_status='EXP-NW-TMOUT') THEN (sms_splits) WHEN (dlr_status='FAILED') THEN (sms_splits) ELSE 0 END) as FL, sum(CASE WHEN dlr_status='' THEN sms_splits ELSE 0 END) as PEN, sum(sms_splits) as SPL from sms_log where cust_id='$customer_id' and date(created_on)= (curdate()) group by user_id,msgfrom";
                                

                                //$query = mysqli_query($conn, "select user_id,msgfrom,count(*) as testa from sms_log where date(created_on)= (curdate()) group by user_id,msgfrom");
                                
                                 date_default_timezone_set('Asia/Kolkata');
                                 $created_date = date("d-M-Y");
                                 $count = mysqli_num_rows($query);
                                    if($count == 0)
                                    {
                                        $result_array[] = "<td colspan='4' style='color:red;text-align:center'>No Record Found</td>";
                                    }
                                    else
                                    {   
                                        while($res = mysqli_fetch_array($query))
                                        {
                                            $user = $res['user_id'];
                                            $msgfrom = $res['msgfrom'];
                                            $cre_date = $res['created_on'];
                                            //****************Expiry**************
                                            $days_to_expire = mysqli_query($conn, "SELECT expired_on,credits_assigned,credits_avialable,DATEDIFF(expired_on, CURDATE()) AS days_left FROM user_master WHERE user_id='".$res['user_id']."'");
                                            $res_rem_days = mysqli_fetch_assoc($days_to_expire);
                                            //****************Expiry**************
                                            //$query_expiry = mysqli_query($conn, "select * from user_master where cust_id='$customer_id' and user_id='".$res['user_id']."'");
                                            //$res_expiry = mysqli_fetch_array($query_expiry);
                                            $expiry = date("d-m-Y H:i:s", strtotime($res_rem_days['expired_on']));
                                            
                                            $days_rem = $res_rem_days['days_left'];

                                            if(substr($days_rem,0,1) == "-")
                                            {
                                                $result_array[] = "<tr><td width='4.1%'>".$id++."</td><td width='20.4%'>".$user."</td><td width='12.3%'>".$msgfrom."</td><td width='8.2%'>".$res['PEN']."</td><td width='8.1%'>".$res['DL']."</td><td width='8.1%'>".$res['FL']."</td><td width='10.2%'>".$res['SPL']."</td><td>".$res_rem_days['credits_assigned']."</td><td>".$res_rem_days['credits_avialable']."</td><td width='20.3%'>".$expiry."</td><td><span style='color:red'>Expired</span></td></tr>";
                                                
                                                //header('Location: script.php#bottomOfPage');
                                            }
                                            else
                                            {
                                                $result_array[] = "<tr><td width='4.1%'>".$id++."</td><td width='20.4%'>".$user."</td><td width='12.3%'>".$msgfrom."</td><td width='8.2%'>".$res['PEN']."</td><td width='8.1%'>".$res['DL']."</td><td width='8.1%'>".$res['FL']."</td><td width='10.2%'>".$res['SPL']."</td><td>".$res_rem_days['credits_assigned']."</td><td>".$res_rem_days['credits_avialable']."</td><td width='20.3%'>".$expiry."</td><td>".$days_rem." <span style='color:green'>Days</span></td></tr>";
                                                
                                                //header('Location: script.php#bottomOfPage');
                                            }


                                        }
                                        
                                    }
                            }
                                    
                        ?>
                        <div class="col-lg-12">
                        <h2>Daily Traffic Report Users (<?php  echo $created_date;?>)</h2>
                        <div class="table-header">
                            <table width="98.5%" class="table table-bordered table-hover">
                            <div class="col-md-12">
                            <thead>
                                    <tr>
                                        <th width="4%">Id</th>
                                        <th width="20%">User Id</th>
                                        <th width="12%">Message From</th>
                                        <th width="8%">In Queue</th>
                                        <th width="8%">Delivered</th>
                                        <th width="8%">Failed</th>
                                        <th width="10%">Total Count</th>
                                        <th width="20%">Expiry Date</th>
                                        <th width="10%">Expired In</th>
                                    </tr>
                                </thead>
                                </table>
                                </div>
                                <div class="table-body" style="width:100%">
                                <table width="100%" class="table table-bordered table-hover">
                                <tbody style="width:100%">
                                    <?php 
                                    foreach ($result_array as $result_arrays) {
                                        echo $result_arrays;
                                    }
                                    if(isset($_POST['search_btn']))
                                    {
                                            echo '<script>
                                                    window.scrollBy(0, 500);
                                                    </script>';
                                    }
                                     ?>
                                    
                                </tbody>
                            </table>
                            </div>
                            </div>

                    </div>
                </div>
            </form>
            <!-- End Form -->
<!--************************CSV DOwnload*******************************-->         
<div class="col-md-1">
            <form method="post" action="csv_download.php">
            <input type="hidden" name="csv_query" value="<?php echo $query_d; ?>">
            <input type="hidden" name="hid_customer_id" value="<?php echo $customer_id; ?>">
            <div style="text-align:center" class="form-group">
                <button type="submit" value="DOWNLOAD CSV" name="Daily_Traffic_csv" style="background:none;border:none;height:40px;width:40px"><img style="width:35px;height:35px" src="image/excel-logo.png"/></button>
                <span class="help-block" style="text-align:center;font-size:10px">Click To Download CSV.</span>
            </div>
            </form>
            </div>
<!--************************CSV DOwnload*******************************-->

                
			

            
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
        $( "#created_on" ).datepicker();
        //$( "#date_picker" ).datepicker("show");   
        //$( "#date_picker1" ).datepicker();
        //$( "#date_picker1" ).datepicker("show");
        });
    </script>
    <!--date picker -->

</body>

</html>

<?php //(select user_id,msgfrom,created_on,count(*) as testa from sms_log where user_id='vipinuser2' and cust_id='vipin' and date(created_on)=(curdate()) group by user_id,msgfrom) UNION (select dlr_status,count(*) from sms_log where user_id='vipinuser2' and cust_id='vipin' and dlr_status='' and date(created_on) =(curdate()) GROUP BY dlr_status) ?>