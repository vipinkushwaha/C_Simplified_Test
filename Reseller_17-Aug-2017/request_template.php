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

    <title>Template Approval</title>
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
     
  <!--Modal Want-->
 <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!--MODAL Want-->
  
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
//***********************Select All chackbox Logic****************
function selectall(source)
{
  checkboxes = document.getElementsByName('chk_box[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
//***********************Select All chackbox Logic****************

//********************Refresh Page request_template**********************
function refresh()
{
	window.open("request_template.php","_self");
}
//********************Refresh Page request_template**********************

//********************Delete Modal Template*************************************
$(document).ready(function(){
	//$("#date").datepicker();
 	
    $("#delete_template_btn").click(function(){
        var templateid = $("#hid_var").val();
		
		//var cust_id = $("#customerid").val();
			$.ajax({
                type:"POST",
                url:"delete_template_modal.php",
                data:"template_id="+templateid,
                success:function(e)
				{
                    alert(e);
					$("#hid_var").val("");
					//$(location).attr('href',request_template.php);
                }
            }); 
    });
});
//********************Delete Modal Template*************************************
//********************Delete All Selected Template*************************************
$(document).ready(function(){
	//$("#date").datepicker();
 	
    $("#delete_all").click(function(){
		var checkedNum = $('input[name="chk_box[]"]:checked').length;
		if(!checkedNum)
		{
			alert("Please Select one or more CheckBox in table.");
		}
		if(checkedNum > 0)
		{
			//$('input[name="chk_box[]"]:checked').each(function() {
			var templateid = [];
			$('input[name="chk_box[]"]:checked').map(function() {
			templateid = $(this).val();
			$.ajax({
					type:"POST",
					url:"delete_all_template.php",
					data:"template_id="+templateid,
					success:function(e)
					{
						//alert(e);
						refresh();
					}
				});
			});
			
			alert("Successfully Deleted");
		}
	});
});
//********************Delete All Selected Template******************************
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


//********************Update Modal template*************************************
$(document).ready(function(){
	//$("#date").datepicker();
 	
    $("#update_template_btn").click(function(){
        var template = $("#template_modal").val();
		var templateid = $("#hid_var").val();
		
		//var cust_id = $("#customerid").val();
			if(template==0)
			{
			alert("Empty Template.");
			return false;
			}
            $.ajax({
                type:"POST",
                url:"save_template.php",
                data:"template_modal="+template+"&template_id="+templateid,
                success:function(e)
				{
                    //alert(e);
					$("#success_mesage").html(e);
					$("#hid_var").val("");
					//setTimeout($('#Modal_Edit').modal('hide'), 7000);
					$('#Modal_Edit').show(0).delay(800).hide(0);
					setTimeout(function () { window.location.href = window.location.pathname;}, 800);

					//window.setTimeout("#Modal_Edit", 3000);
					
                }
				
            }); 
    });
});
//********************Update Modal template*************************************

//**********************Dynamic Variable LOGIC for New Temoplate Approval Modal**************************
$(document).ready(function(){
$("#append").prop("disabled",true);
$("#templatetype").change(function(){
	if($("#templatetype").val() == 'static')
	{
		//alert("Well Done.");
		$("#append").prop("disabled",true);
	}
	if($("#templatetype").val() == 'dynamic')
	{
		//alert("Well Done.");
		$("#append").prop("disabled",false);
	}
	else
	{
		$("#append").prop("disabled",true);
	}
	 
 });

});


$(document).ready(function(){
$("#append").click(function(){
	$('#template').val($('#template').val() + "{var}");
	$('#template').focus();
});
});
//**********************Dynamic Variable LOGIC for New Temoplate Approval Modal**************************

//**********************Dynamic Variable LOGIC for Update Temoplate Approval Modal**************************
$(document).ready(function(){
$("#append_update").prop("disabled",true);
$("#template_type_update").change(function(){
	//alert($("#template_type_update").val());
	//return false;
	if($("#template_type_update").val() == 'static2')
	{
		//alert("Well Done.");
		$("#append_update").prop("disabled",true);
	}
	if($("#template_type_update").val() == 'dynamic2')
	{
		//alert("Well Done.");
		$("#append_update").prop("disabled",false);
	}
	else
	{
		$("#append_update").prop("disabled",true);
	}
	 
 });

});


$(document).ready(function(){
$("#append_update").click(function(){
	$('#template_modal').val($('#template_modal').val() + "{var}");
	$('#template_modal').focus();
});
});
//**********************Dynamic Variable LOGIC for Update Temoplate Approval Modal**************************

//**************New Template Modal approval********************

$(document).ready(function(){
	//$("#date").datepicker();
 	
    $("#template_btn").click(function(){
        var user_id = $("#userid").val();
		var cust_id = $("#customerid").val();
        var sender_id = $("#senderid").val();
        var template_app = $("#template").val();
		
			if(user_id=="")
			{
			alert("Empty User ID");
			return false;
			}
			if(sender_id=="")
			{
			alert("Empty Sender ID");
			return false;
			}
			if(template_app==0)
			{
			alert("Empty Template");
			return false;
			}
            $.ajax({
                type:"POST",
                url:"newtemplateapproval.php",
                data:"userid="+user_id+"&custid="+cust_id+"&senderid="+sender_id+"&template="+template_app,
                success:function(e)
				{
                    alert(e);
					$("#userid").val("");
					$("#senderid").val("");
					$("#template").val("");
					if(e=="Sender Id is not approved yet.")
					{
						$("#senderid").html('<option value="">Select User Id First.</option>');
					}
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

//**************New Template approval********************

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

//*****************Sender Id search by user id Logic for template approval page********************

$(document).ready(function(){
	$('#userid').change(function(){
        var user_id = $(this).val();
        if(user_id){
            $.ajax({
                type:'POST',
                url:'senderid_change.php',
                data:'userid='+user_id,
                success:function(html)
				{
                    $('#senderid').html(html);
                }
            }); 
        }
		else
		{
            $('#senderid').html('<option value="">Select User Id First.</option>'); 
        }
    });
});

//*****************Sender Id search by user id Logic for search********************
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
                <?php
				//********************************Form Count Total entries, template, active, inactive etc **********************************
				
				$query1 = mysqli_query($conn, "select * from templatemst where customerid='$customer_id'");
				$total = mysqli_num_rows($query1);
				$query4 = mysqli_query($conn, "select * from templatemst where is_incl_template='0' AND customerid='$customer_id'");
				$pending = @mysqli_num_rows($query4);
				$query5 = mysqli_query($conn, "select * from templatemst where is_incl_template='1' AND customerid='$customer_id'");
				$approved = @mysqli_num_rows($query5);
				$query6 = mysqli_query($conn, "select * from templatemst where is_incl_template='2' AND customerid='$customer_id'");
				$not_approved = @mysqli_num_rows($query6);
				
				?>
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
					<a href="request_template.php" class="list-group-item active"><i class="fa fa-file-image-o" aria-hidden="true"></i>  &emsp;Template Approval</a>
					<a href="javascript:;" data-toggle="collapse" data-target="#demo1" class="list-group-item"><i class="fa fa-money" aria-hidden="true"></i>  &emsp;Credits Management <i class="fa fa-fw fa-caret-down"></i></a>
                        <p id="demo1" class="collapse">
                                <a class="list-group-item" href="credit_management_reseller.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> My Credit History&emsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-history" aria-hidden="true"></i></a>
                                <a class="list-group-item" href="credit_assignment_user.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> Credit Assignment&emsp;&nbsp; <i class="fa fa-plus" aria-hidden="true"></i></a>
                                <a class="list-group-item" href="credit_history_user.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> User Credit History&emsp; <i class="fa fa-history" aria-hidden="true"></i></a>
                            
                        </p>
                </div>
            </div>
			<!--sender ID Request-->
			
			
	<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    <!--<form method="post">-->
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header bg-primary" style='border-radius:5px 5px 0px 0px;'>
          <input type="submit" onclick="refresh();" class="close" value="&times;" style="color:#000;" data-dismiss="modal">
          <h4 class="modal-title">Request Template Approval</h4>
        </div>
        <div class="modal-body">
<div class="col-md-12">
<div class="form-group">
<label>Customer Id</label>
<input id="customerid" name="customerid" disabled="disabled" value="<?php echo $customer_id;?>" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
</div>
<div class="form-group">
    <label>User Id</label>
    <select type="text" id="userid" name="userid" style="overflow-x:hidden;overflow-y:scroll" class="form-control" placeholder="Type User Id here" autocomplete="off">
	<option value="">Select User Id.</option>
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
				echo "<option value='".$resa['user_id']."'>".$resa['user_id']."</option>";
			}
		}
	?>
	</select>
</div>
</div>
<div class="col-md-7">
<div class="form-group">
    <label>Sender Id<span style="color:red">*</span></label>
    <select id="senderid" name="senderid" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
	<option disabled>Select User Id First.</option>
	</select>
</div>
</div>
<div class="col-md-5">
<div class="form-group">
    <label>Template Type<span style="color:red">*</span></label>
    <select id="templatetype" name="templatetype" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
	<option selected value="static">Static Template</option>
	<option value="dynamic">Dynamic Template</option>
	</select>
</div>
</div>
<div class="col-md-8">
<div class="form-group">
    <label>Template<span style="color:red">*</span></label>
    <textarea name="template" id="template" class="form-control" rows="6" style="resize:none"></textarea>
</div>
</div>
<div class="col-md-4">
<label>&nbsp;</label>
<div style="margin-top:30px" class="form-group">
<button id="append" name="append_submit" style="width:100%;height:50px;" onclick="append_text();" type="submit" class="btn btn-primary"><span class="text-lg">ADD VARIABLE</span></button>
<span class="help-block" style="text-align:center">Add Dynamic Variables.</span>
</div>
</div>

        </div>
        <div class="modal-footer">
		<div style="text-align:center" class="col-lg-12">
		<div class="form-group">
		<button id="template_btn" name="btn_submit" style="width:40%" type="submit" class="btn btn-primary"><span class="text-lg">R E Q U E S T</span></button>
		</div>
		</div>
        </div>
      </div>
      <!--</form>-->
    </div>
  </div>
			
			<!--***********************sender ID Request***********************************-->
			
			<!--********************Search By User Id, SenderId, Status etc*******************-->
<!-- 			<div style="text-align:center;margin-top:20px" class="col-md-7">&nbsp;</div>
			<div style="text-align:right;margin-top:-10px" class="col-md-2">
			    <form method="post"><button id="logout" name="logout" style="width:100px;color:#white;border-color:#337AB7;border-width:5px;border-radius:5px 5px 5px 5px;" type="submit" class="btn btn-default">Logout</button></form>
				<?php
				// error_reporting(0);
				// $logout = $_POST['logout'];
				// if(isset($logout))
				// {
				// 	header("Location:index.php");
				// }
				?>
			</div> -->
	<div class="col-lg-9">
    <div class="container" style="border:5px solid #f5f5f5; width:70%;border-radius:20px 20px 20px 20px;">
        <table>
            <tr>
                <td>&emsp;<img style="width:60px;height:60px" src="image/total_template.png"></td>
                <td>&emsp;&emsp;&emsp;&emsp;</td>
                <td>&emsp;<img style="width:60px;height:60px" src="image/approved.png"></td>
                <td>&emsp;&emsp;&emsp;&emsp;</td>
                <td>&emsp;<img style="width:60px;height:60px" src="image/not_approved.png"></td>
                <td>&emsp;&emsp;&emsp;&emsp;</td>
                <td><img style="width:60px;height:60px" src="image/pending.png"></td>
            </tr>
            <tr>
                <th>Total Template: <?php echo $total;?></th>
                <th>&emsp;&emsp;&emsp;&emsp;</th>
                <th>Approved: <?php echo $approved; ?></th>
                <th>&emsp;&emsp;&emsp;&emsp;</th>
                <th>Not Approved: <?php echo $not_approved; ?></th>
                <th>&emsp;&emsp;&emsp;&emsp;</th>
                <th>Pending: <?php echo $pending; ?></th>
            </tr>
        </table>
    </div>
</div>

<form method="post">
<div class="col-md-9">
<h1>Search Templates</h1>
</div>
<div style="text-align:center" class="col-md-9">
&nbsp;
</div>
            <div class="col-md-3">
			<div class="form-group">
            <label>User Id</label>
            <input type="text" id="user_id" style="overflow:scroll;width:100%" name="user_id" class="form-control" list="datalist_user1" placeholder="Type User Id here" autocomplete="off">
			<datalist id="datalist_user1">
			<?php
			$query = mysqli_query($conn, "select * from templatemst where customerid='$customer_id' order by template_id DESC");
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
					$get_user[] = $resa['userid'];
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
            <label>Created On/Approved On</label>
            <select id="created_approved" style="overflow:scroll;" name="cre_app" class="form-control">
			<option value="" selected="true" disabled="disabled">Select</option>
            <option value="created_on">Created On</option>
			<option value="approved_on">Approved On</option>
			</select>
			</div>
			</div>
			<div class="col-md-3">
			<div class="form-group">
            <label>Senderid</label>
            <select id="sender_id" style="overflow:scroll;width:100%" name="sender_id" class="form-control">
			<option selected disabled value="">Select sender Id.</option>
			<?php
				$query = mysqli_query($conn, "select * from templatemst where customerid='$customer_id' order by template_id DESC");
				$get_user = array();
				while($resa = mysqli_fetch_array($query))
				{
					$get_user[] = $resa['senderid'];
				}
				$uniques_user = array_unique($get_user);
				foreach($uniques_user as $unique_user)
				{
					echo "<option value='".$unique_user."'>".$unique_user."</option>";
				}
			?>
			</select>
            </div>
			<div class="form-group">
			<label>Search By Date</label>
            <input type="text" id="date_picker" name="created_approved1" placeholder="From Date" class="form-control datepicker">
			<input type="text" id="date_text" placeholder="Select Created On/Approved On First." class="form-control datepicker" disabled>
			</div>
			</div>
			<div class="col-md-3">
			<div class="form-group">
            <label>Status</label>
            <select id="status" style="overflow:scroll;" name="status" class="form-control">
			<option value="" selected="true" disabled="disabled">Select</option>
            <option value="pending">Pending</option>
			<option value="approved">Approved</option>
			<option value="not_approved">Not Approved</option>
			</select>
            </div>
			<div class="form-group">
			<label>&nbsp;</label>
            <input type="text" id="date_picker1" name="created_approved2" placeholder="To Date" class="form-control datepicker">
			</div>
			</div>
			<div style="text-align:center" class="col-md-9">
			<?php
			$message = "";
			error_reporting(0);
			$user_id = $_POST['user_id'];
			$sender_id = $_POST['sender_id'];
			$template = $_POST['template'];
			$status = $_POST['status'];
			$created_approved1 = $_POST['created_approved1'];
			$created_approved2 = $_POST['created_approved2'];
			$cre_app = $_POST['cre_app'];
			//**********************Logic For Search**************
				if(!isset($_POST['search_btn']))
				{
					if(empty($user_id))
					{
						$query_d = "select * from templatemst where customerid='$customer_id' order by template_id desc limit 80";
						$query = mysqli_query($conn, $query_d);
					}
				}
				if(isset($_POST['search_btn']))
				{
					if(empty($user_id && $sender_id && $status && $created_approved1 && $created_approved2 && $cre_app))
					{
						$query_d = "select * from templatemst where customerid='$customer_id' order by template_id desc limit 80";
						$query = mysqli_query($conn, $query_d);
					}
					//echo "$user_id";
					if(!empty($user_id) && empty($sender_id && $status && $created_approved1 && $created_approved2 && $cre_app))
					{
						//echo "$user_id";
						$query_d = "select * from templatemst where customerid='$customer_id' && userid='$user_id' order by template_id desc limit 80";
						$query = mysqli_query($conn, $query_d);
						
					}
					if(!empty($sender_id) && empty($user_id && $status && $created_approved1 && $created_approved2 && $cre_app))
					{
						//echo "$user_id";
						$query_d = "select * from templatemst where customerid='$customer_id' && senderid='$sender_id'";
						$query = mysqli_query($conn, $query_d);
						
					}
					if(!empty($status) && empty($user_id && $sender_id && $created_approved1 && $created_approved2 && $cre_app))
					{
						//echo "$status";
						if($status == "pending")
						{
							$query_d = "select * from templatemst where customerid='$customer_id' && is_incl_template='0' order by template_id desc limit 80";
							$query = mysqli_query($conn, $query_d);
						}
						if($status == "approved")
						{
							$query_d = "select * from templatemst where customerid='$customer_id' && is_incl_template='1' order by template_id desc limit 80";
							$query = mysqli_query($conn, $query_d);
						}
						if($status == "not_approved")
						{
							$query_d = "select * from templatemst where customerid='$customer_id' && is_incl_template='2' order by template_id desc limit 80";
							$query = mysqli_query($conn, $query_d);
						}
					}
					if(!empty($created_approved1) && !empty($created_approved2) && empty($cre_app) && empty($user_id && $sender_id  && $status))
					{
						echo "<center style='color:red'>Select type of date (Created On Or Approved On).</center>";
					}
					$date_from = date("Y-m-d 00:00:00", strtotime($created_approved1));
					$date_to = date("Y-m-d 23:59:59", strtotime($created_approved2));
					if(!empty($created_approved1) && !empty($created_approved2) && !empty($cre_app) && empty($user_id && $sender_id  && $status))
					{
						if($cre_app == "created_on")
						{
							//echo "$created_approved1";
							//echo "$created_approved2";
							$query_d = "select * from templatemst where customerid='$customer_id' and created_date>='$date_from' and created_date<='$date_to' order by template_id desc";
							$query = mysqli_query($conn, $query_d);
						}
						if($cre_app == "approved_on")
						{
							$query_d = "select * from templatemst where customerid='$customer_id' and approved_on>='$date_from' and approved_on<='$date_to' order by template_id desc";
							$query = mysqli_query($conn, $query_d);
						}
					}
					if(!empty($sender_id) && !empty($created_approved1) && !empty($created_approved2) && !empty($cre_app) && empty($user_id)  && empty($status))
					{
						if($cre_app == "created_on")
						{
							//echo "$created_approved1";
							//echo "$created_approved2";
							$query_d = "select * from templatemst where customerid='$customer_id' and senderid='$sender_id' and created_date>='$date_from' and created_date<='$date_to' order by template_id desc";
							$query = mysqli_query($conn, $query_d);
						}
						if($cre_app == "approved_on")
						{
							$query_d = "select * from templatemst where customerid='$customer_id' and senderid='$sender_id' and approved_on>='$date_from' and approved_on<='$date_to' order by template_id desc";
							$query = mysqli_query($conn, $query_d);
						}
					}
					if(!empty($user_id) && !empty($status) && empty($sender_id  && $created_approved))
					{
						//echo "$user_id or $status";
						if($status == "pending")
						{
							//echo "vipin1";
							//echo "$customer_id";
							//echo "$user_id";
							$query_d = "select * from templatemst where customerid='$customer_id' and userid='$user_id' and is_incl_template='0' order by template_id desc limit 80";
							$query = mysqli_query($conn, $query_d);
						}
						if($status == "approved")
						{
							//echo "vipin2";
							$query_d = "select * from templatemst where customerid='$customer_id' and userid='$user_id' and is_incl_template='1' order by template_id desc limit 80";
							$query = mysqli_query($conn, $query_d);
						}
						if($status == "not_approved")
						{
							//echo "vipin2";
							$query_d = "select * from templatemst where customerid='$customer_id' and userid='$user_id' and is_incl_template='2' order by template_id desc limit 80";
							$query = mysqli_query($conn, $query_d);
						}
					}
					if(!empty($sender_id) && !empty($status) && empty($user_id  && $created_approved))
					{
						//echo "$user_id or $status";
						if($status == "pending")
						{
							//echo "vipin1";
							//echo "$customer_id";
							//echo "$user_id";
							$query_d = "select * from templatemst where customerid='$customer_id' and senderid='$sender_id' and is_incl_template='0' order by template_id desc limit 80";
							$query = mysqli_query($conn, $query_d);
						}
						if($status == "approved")
						{
							//echo "vipin2";
							$query_d = "select * from templatemst where customerid='$customer_id' and senderid='$sender_id' and is_incl_template='1' order by template_id desc limit 80";
							$query = mysqli_query($conn, $query_d);
						}
						if($status == "not_approved")
						{
							//echo "vipin2";
							$query_d = "select * from templatemst where customerid='$customer_id' and senderid='$sender_id' and is_incl_template='2' order by template_id desc limit 80";
							$query = mysqli_query($conn, $query_d);
						}
					}
					if(!empty($user_id) && !empty($created_approved1) && !empty($created_approved2) && !empty($cre_app) && empty($sender_id  && $status))
					{
						if($cre_app == "created_on")
						{
							$query_d = "select * from templatemst where customerid='$customer_id' and userid='$user_id' and created_date>='$date_from' and created_date<='$date_to' order by template_id desc";
							$query = mysqli_query($conn, $query_d);
						}
						if($cre_app == "approved_on")
						{
							$query_d = "select * from templatemst where customerid='$customer_id' and userid='$user_id' and approved_on>='$date_from' and approved_on<='$date_to' order by template_id desc";
							$query = mysqli_query($conn, $query_d);
						}
					}
					if(!empty($user_id) && !empty($sender_id) && empty($created_approved1) && empty($created_approved2) && empty($cre_app) && empty($status))
					{
							$query_d = "select * from templatemst where customerid='$customer_id' and senderid='$sender_id' and userid='$user_id' order by template_id desc";
							$query = mysqli_query($conn, $query_d);
					}
					if(!empty($status) && !empty($created_approved1) && !empty($created_approved2) && !empty($cre_app) && empty($sender_id  && $user_id))
					{
						if($cre_app == "created_on")
						{
							if($status == "approved")
							{
								$query_d = "select * from templatemst where customerid='$customer_id' and is_incl_template='1' and created_date>='$date_from' and created_date<='$date_to' order by template_id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status == "pending")
							{
								$query_d = "select * from templatemst where customerid='$customer_id' and is_incl_template='0' and created_date>='$date_from' and created_date<='$date_to' order by template_id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status == "not_approved")
							{
								$query_d = "select * from templatemst where customerid='$customer_id' and is_incl_template='2' and created_date>='$date_from' and created_date<='$date_to' order by template_id desc";
								$query = mysqli_query($conn, $query_d);
							}
						}
						if($cre_app == "approved_on")
						{
							if($status == "approved")
							{
								$query_d = "select * from templatemst where customerid='$customer_id' and is_incl_template='1' and approved_on>='$date_from' and approved_on<='$date_to' order by template_id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status == "pending")
							{
								$query_d = "select * from templatemst where customerid='$customer_id' and is_incl_template='0' and approved_on>='$date_from' and approved_on<='$date_to' order by template_id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status == "not_approved")
							{
								$query_d = "select * from templatemst where customerid='$customer_id' and is_incl_template='2' and approved_on>='$date_from' and approved_on<='$date_to' order by template_id desc";
								$query = mysqli_query($conn, $query_d);
							}
						}
					}
					if(!empty($user_id) && !empty($status) && !empty($created_approved1) && !empty($created_approved2) && !empty($cre_app) && empty($sender_id))
					{
						//echo "sms_uaa";
						if($cre_app == "created_on")
						{
							//echo "sms_uaa";
							if($status == "approved")
							{
								//echo "select * from templatemst where customerid='$customer_id' and user_id='$user_id' and is_incl_template='1' and created_date>='$date_from' and created_date<='$date_to' order by template_id desc";
								$query_d = "select * from templatemst where customerid='$customer_id' and userid='$user_id' and is_incl_template='1' and created_date>='$date_from' and created_date<='$date_to' order by template_id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status == "pending")
							{
								$query_d = "select * from templatemst where customerid='$customer_id' and userid='$user_id' and is_incl_template='0' and created_date>='$date_from' and created_date<='$date_to' order by template_id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status == "not_approved")
							{
								$query_d = "select * from templatemst where customerid='$customer_id' and userid='$user_id' and is_incl_template='2' and created_date>='$date_from' and created_date<='$date_to' order by template_id desc";
								$query = mysqli_query($conn, $query_d);
							}
						}
						if($cre_app == "approved_on")
						{
							if($status == "approved")
							{
								$query_d = "select * from templatemst where customerid='$customer_id' and userid='$user_id' and is_incl_template='1' and approved_on>='$date_from' and approved_on<='$date_to' order by template_id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status == "pending")
							{
								$query_d = "select * from templatemst where customerid='$customer_id' and userid='$user_id' and is_incl_template='0' and approved_on>='$date_from' and approved_on<='$date_to' order by template_id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status == "not_approved")
							{
								$query_d = "select * from templatemst where customerid='$customer_id' and userid='$user_id' and is_incl_template='2' and approved_on>='$date_from' and approved_on<='$date_to' order by template_id desc";
								$query = mysqli_query($conn, $query_d);
							}
						}
					}
					if(!empty($user_id) && !empty($status) && !empty($sender_id)  && empty($created_approved))
					{
						//echo "$user_id or $status";
						if($status == "pending")
						{
							$query_d = "select * from templatemst where customerid='$customer_id' and userid='$user_id' and senderid='$sender_id' and is_incl_template='0' order by template_id desc limit 80";
							$query = mysqli_query($conn, $query_d);
						}
						if($status == "approved")
						{
							//echo "vipin2";
							$query_d = "select * from templatemst where customerid='$customer_id' and userid='$user_id' and senderid='$sender_id' and is_incl_template='1' order by template_id desc limit 80";
							$query = mysqli_query($conn, $query_d);
						}
						if($status == "not_approved")
						{
							//echo "vipin2";
							$query_d = "select * from templatemst where customerid='$customer_id' and userid='$user_id' and senderid='$sender_id' and is_incl_template='2' order by template_id desc limit 80";
						}
					}

					if(!empty($user_id) && !empty($status) && !empty($created_approved1) && !empty($created_approved2) && !empty($cre_app) && !empty($sender_id))
					{
						//echo "sms_uaa";
						if($cre_app == "created_on")
						{
							//echo "sms_uaa";
							if($status == "approved")
							{
								//echo "select * from templatemst where customerid='$customer_id' and user_id='$user_id' and is_incl_template='1' and created_date>='$date_from' and created_date<='$date_to' order by template_id desc";
								$query_d = "select * from templatemst where customerid='$customer_id' and userid='$user_id' and is_incl_template='1' and senderid='$sender_id' and created_date>='$date_from' and created_date<='$date_to' order by template_id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status == "pending")
							{
								$query_d = "select * from templatemst where customerid='$customer_id' and userid='$user_id' and is_incl_template='0' and senderid='$sender_id' and created_date>='$date_from' and created_date<='$date_to' order by template_id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status == "not_approved")
							{
								$query_d = "select * from templatemst where customerid='$customer_id' and userid='$user_id' and is_incl_template='2' and senderid='$sender_id' and created_date>='$date_from' and created_date<='$date_to' order by template_id desc";
								$query = mysqli_query($conn, $query_d);
							}
						}
						if($cre_app == "approved_on")
						{
							if($status == "approved")
							{
								$query_d = "select * from templatemst where customerid='$customer_id' and userid='$user_id' and is_incl_template='1' and senderid='$sender_id' and approved_on>='$date_from' and approved_on<='$date_to' order by template_id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status == "pending")
							{
								$query_d = "select * from templatemst where customerid='$customer_id' and userid='$user_id' and is_incl_template='0' and senderid='$sender_id' and approved_on>='$date_from' and approved_on<='$date_to' order by template_id desc";
								$query = mysqli_query($conn, $query_d);
							}
							if($status == "not_approved")
							{
								$query_d = "select * from templatemst where customerid='$customer_id' and userid='$user_id' and is_incl_template='2' and senderid='$sender_id' and approved_on>='$date_from' and approved_on<='$date_to' order by template_id desc";
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
			</form>
			<!--Search By User Id, SenderId, Status etc-->
			<!--<form method="post">-->
            <div class="col-md-12">
				<div class="col-md-6"><h3>Template Status Table</h3></div><div style="text-align:right" class="col-md-6"><label><button class="btn btn-well"  style='border-radius:8px 0px 0px 8px;'><span class="glyphicon glyphicon-plus"></span></button><button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal" style='border-radius:0px 8px 8px 0px;'>Request Template Approval</button></label><label class='radio-inline'><button class="btn btn-well"  style='border-radius:8px 0px 0px 8px;'><span class="glyphicon glyphicon-minus"></span></button><input type="button" style="border-radius:0px 8px 8px 0px" id="delete_all" name="delete_all" value="Delete Selected" class="btn btn-primary btn-md"></label></div>
				<!--</form>-->
			<!--<div class="col-md-12" style="overflow-y:scroll;overflow-x:auto;max-height:380pt">-->
			<?php
				/*if($_POST['delete_all']=="Delete Selected")
				{
					$chk_id = $_POST['chk_box'];
					//echo "$chk_id";
					if(empty($chk_id))
					{
						echo "<center style='color:red'>Please Check Templates to Delete.</center>";
					}
					if(!empty($chk_id))
					{
						foreach($chk_id as $chk_id_res)
						{
							//echo "$chk_id_res";
							$query = mysqli_query($conn, "delete from templatemst where template_id='".$chk_id_res."'");
						}
						if($query)
						{
							echo "<center style='color:green'>Template Deleted Successfully.</center>";
						}
					}
					//$query = mysqli_query($conn, "select * from templatemst where customerid='$customer_id' order by template_id desc limit 80");
				}*/
				?>
				
				<div class="table-header">
				<table width="98.5%" class="table table-bordered table-hover">
				<thead>
				<tr>
				<th width="2.9%"><input type='checkbox' onClick="selectall(this)"></th>
				<th width="8%">User Id</th>
				<th width="7.5%">Sender Id</th>
				<th width="15.9%">Template</th>
				<th width="8%">Status</th>
				<th width="14.3%">Created On</th>
				<th width="14.4%">Approved On</th>
				<th width="14.3%">Updated On</th>
				<th>Edit/Delete Template</th>
				</tr>
				</thead>
				</table>
				</div>
				
				<div class="table-body" style="width:100%">
				<table width="100%" class="table table-bordered table-hover">
				<tbody style="width:100%">
				<?php
				$status = "";
					if(mysqli_num_rows($query) > 0)
					{
						while($res = mysqli_fetch_array($query))
						{
							if($res['is_incl_template'] == 0)
							{
								$status = "Pending";
							}
							if($res['is_incl_template'] == 1)
							{
								$status = "Approved";
							}
							if($res['is_incl_template'] == 2)
							{
								$status = "Not Approved";
							}
							$originalDate1 = $res['created_date'];
							if($originalDate1=="0000-00-00 00:00:00")
							{
								$created_date = "";
							}
							else
							{
								$created_date = date("d-m-Y H:i:s", strtotime($originalDate1));
							}
							 $originalDate2 = $res['approved_on'];
							if($originalDate2=="0000-00-00 00:00:00")
							{
								$approved_date = "";
							}
							else
							{
								$approved_date = date("d-m-Y H:i:s", strtotime($originalDate2));
							}
							$originalDate3 = $res['updated_on'];
							if($originalDate3=="0000-00-00 00:00:00")
							{
								$updated_date = "";
							}
							else
							{
								$updated_date = date("d-m-Y H:i:s", strtotime($originalDate3));
							}
							$id = $res['template_id'];
							//echo "$id";
								echo "<tr><td width='3%'><input id='chk_box[]' class='chk_box[]' type='checkbox' name='chk_box[]' value='".$id."'></td><td width='8.15%'>".$res['userid']."</td><td width='7.5%'>".$res['senderid']."</td><td width='16.3%' id='template_row'>".$res['template']."</td><td width='8.1%'>".$status."</td><td width='14.6%'>".$created_date."</td><td width='14.7%'>".$approved_date."</td><td width='14.5%'>".$updated_date."</td><td><label><form method='get'><button id='update' value='".$id."' name='update' type='submit' style='width:60px' class='btn btn-primary btn-sm'>Edit</button></form></label> <label style='margin-left:-20px' class='radio-inline'><form method='get'><button id='delete' value='".$id."' name='delete' type='submit' class='btn btn-primary btn-sm'>Delete</button></form></label></td></tr>";
						}
					}
					else
					{
						echo "<tr><td width='100%' colspan='9'><center style='color:red;text-align:center;'>No Records Found</center></td></tr>";
					}
				?>
				</tbody>
				</table>
				<!--</form>-->
				
				
<?php
if(isset($_GET['update']))
{
	//echo "vipin2";
	$temp_id = $_GET['update'];
	$query = mysqli_query($conn, "select * from templatemst where template_id='$temp_id'");
	$res = mysqli_fetch_array($query);
	$template_record = $res['template'];
	echo "<input type='hidden' id='hid_var' name='hid_var' value='$temp_id'>";
	echo '<script type="text/javascript">    
    $(window).load(function(){
        $("#Modal_Edit").modal("show");
    });


</script>
<!-- Modal Edit Template -->
  <div class="modal fade" id="Modal_Edit" role="dialog" data-keyboard="false">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header bg-primary" style="border-radius:5px 5px 0px 0px;">
      <!--    <button type="button" id="dis" class="close" data-dismiss="modal">&times;</button>-->
          <input href="request_template.php" onclick="refresh();" type="submit" class="close" value="&times;" data-dismiss="modal">
          <h3 class="modal-title">Edit Template</h3>
        </div>
        <div class="modal-body">
         
         <form class="form-horizontal" method="post" action="">
 <div class="form-group">
 <div class="col-md-8">
    <label>Template Type<span style="color:red">*</span></label>
    <select id="template_type_update" name="template_type_update" style="overflow-x:hidden;overflow-y:scroll" class="form-control">
	<option selected value="static2">Static Template</option>
	<option value="dynamic2">Dynamic Template</option>
	</select>
</div>
</div>

 <div class="col-md-8">
 <div class="form-group">
<label>Template</label> <p class="text-primary" id="success_mesage" style="text-align:center;"></p>
			<textarea name="template_modal" id="template_modal" class="form-control" rows="6" style="resize:none">'.$template_record.'</textarea>
 </div>
 </div>
<label>&nbsp;</label>
<div class="col-md-4">
<div style="margin-left:15px;margin-top:40px" class="form-group">
<button id="append_update" name="append_update" style="width:100%;height:50px;" type="button" class="btn btn-primary"><span class="text-lg">ADD VARIABLE</span></button>
<span class="help-block" style="text-align:center">Add Dynamic Variables.</span>
</div>
</div>
 <div style="margin-left:55px;" class="form-group">
 <div class="col-md-6">
		<a type="submit" class="btn btn-primary btn-block" id="update_template_btn" name="update_template_btn"><span class="text-lg">UPDATE</span></a>
		</div>
 </div>

 </form> 
        </div>
        
      </div>
      
    </div>
  </div>
  <!-- Modal Edit Template -->
  ';
  }
  
  
if(isset($_GET['delete']))
{
	$temp_id = $_GET['delete'];
	echo "<input type='hidden' id='hid_var' name='hid_var' value='$temp_id'>";
	
echo '<script type="text/javascript">    
    $(window).load(function(){
        $("#Modal_Delete").modal("show");
    });


</script>
  <!-- Modal Delete Template -->
  <div class="modal fade" id="Modal_Delete" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header bg-primary" style="border-radius:5px 5px 0px 0px;">
      <!--    <button type="button" id="dis" class="close" data-dismiss="modal">&times;</button>-->
          <input type="button" onclick="refresh();" class="close" type="submit" value="&times;" data-dismiss="modal">
          <h4 class="modal-title">Delete Template</h4>
        </div>
        <div class="modal-body" style="text-align:center">
		<h4>Are you sure you want to delete this template</h4>
         <div class="col-md-2"></div>
         <form class="form-horizontal" method="post" action="">
 <div class="form-group">
 <div class="col-md-8">
<button id="delete_template_btn" onclick="refresh();" name="delete_btn" style="width:20%" type="button" class="btn btn-primary"><span class="text-lg">Yes</span></button>
			<button style="width:20%;margin-left:20px" type="submit" onclick="refresh();" class="btn btn-primary" data-dismiss="modal"><span class="text-lg">No</span></button>
 </div>
 </div><div class="col-md-4"></div>
 
 </form> 
        </div>
        
      </div>
      
    </div>
  </div>
  <!-- Modal Delete Template -->
  ';
  }
  ?>
				
			</div>
			</div>
			
<!--************************CSV DOwnload*******************************-->
<div class="col-md-1">
			<form method="post" action="csv_download.php">
			<input type="hidden" name="csv_query" value="<?php echo $query_d; ?>">
			<div style="text-align:center" class="form-group">
				<button type="submit" value="DOWNLOAD CSV" name="download_template_csv" style="background:none;border:none;height:40px;width:40px"><img style="width:35px;height:35px" src="image/excel-logo.png"/></button>
				<span class="help-block" style="text-align:center;font-size:10px">Click logo To Download CSV.</span>
			</div>
			</form>
			</div>
<!--************************CSV DOwnload*******************************-->			

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
    <!--<script src="js/jquery.js"></script>-->

    <!-- Bootstrap Core JavaScript -->

<!--date picker -->
   <!--**-->
   <!--<script src="js/bootstrap.min.js"></script>-->
	
 <!--**<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>-->
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
