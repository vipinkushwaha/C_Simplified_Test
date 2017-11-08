<?php
error_reporting(0);
$conn = mysqli_connect("localhost","root","","vipin");
//****************************Download CSV Customer History*****************************
if(isset($_POST['download_customer_history_csv']))
{	
	
	$query = $_POST['csv_query'];
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=Customer_History.csv');
	$output = fopen("php://output", "w");
	fputcsv($output, array('Customer Id', 'Credits Recharged', 'Credits Revoked', 'Created Date'));
	$result = mysqli_query($conn, $query);
	$field = array();
	while($row = mysqli_fetch_assoc($result))
	{
		$field = array("Customer Id"=>$row['customerid'],"Credits Recharged"=>$row['credits_recharged'],"Credits Revoked"=>$row['credits_revoked'],"Created On"=>$row['created_date']);
		fputcsv($output,$field);
	}
	
	fclose($output);
}
//****************************Download CSV Customer History*****************************
//****************************Download CSV Daily Traffic*****************************
if(isset($_POST['Daily_Traffic_csv']))
{	
	
	$query = $_POST['csv_query'];
	//echo $query;
	$count = mysqli_num_rows(mysqli_query($conn, $query));
	//echo "Count Record:".$count;
	date_default_timezone_set('Asia/Kolkata');
    $cr_date = date("dMYHis");
	if($count == 0)
	{
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename='.$cr_date.'_Daily_Traffic_.csv');
		$output = fopen("php://output", "w");
		fputcsv($output, array('No Record Found.'));
		fclose($output);
	}
	else
	{
		$customer_id = $_POST['hid_customer_id'];
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=Daily_Traffic_'.$cr_date.'.csv');
		$output = fopen("php://output", "w");
		fputcsv($output, array('User Id', 'Message From', 'In Queue', 'Delivered', 'Failed', 'Total Count', 'Expiry Date', 'Expired In'));
		$result = mysqli_query($conn, $query);
		$field = array();
		while($row = mysqli_fetch_assoc($result))
		{
			$user = $row['user_id'];
		    $msgfrom = $row['msgfrom'];
		    $cre_date = $row['created_on'];
		    $count_pen = $row['PEN'];
		    $count_del = $row['DL'];
		    $count_fai = $row['FL'];
		    $count_total = $row['testa'];

		    //****************Expiry**************
            $days_to_expire = mysqli_query($conn, "SELECT expired_on,DATEDIFF(expired_on, CURDATE()) AS days_left FROM user_master WHERE user_id='$user'");
            $res_rem_days = mysqli_fetch_assoc($days_to_expire);
            //****************Expiry**************
            $expiry = date("d-m-Y H:i:s", strtotime($res_rem_days['expired_on']));
            $days_rem = $res_rem_days['days_left']; 
		    if(substr($days_rem,0,1) == "-")
		    {
		    	$field = array("User Id"=>$user,"Message From"=>$msgfrom,"In Queue"=>$count_pen,"Delivered"=>$count_del,"Failed"=>$count_fai,"Total Messages"=>$count_total,"Expiry Date"=>$expiry,"Expired In"=>Expired);
				fputcsv($output,$field);
		    }
		    else
		    {
		    	$field = array("User Id"=>$user,"Message From"=>$msgfrom,"In Queue"=>$count_pen,"Delivered"=>$count_del,"Failed"=>$count_fai,"Total Messages"=>$count_total,"Expiry Date"=>$expiry,"Expired In"=>$days_rem." Days");
				fputcsv($output,$field);
		    }
		}
		//echo "Count Query Num".$count."Query".$query;
	}
	
	fclose($output);
}
//****************************Download CSV Daily Traffic*****************************
//****************************Download CSV Sender Id*****************************

if(isset($_POST['download_sender_id_csv']))
{	
	
	$query = $_POST['csv_query'];
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=Sender_Id_Approval.csv');
	$output = fopen("php://output", "w");
	fputcsv($output, array('User Id', 'Sender Id', 'Status', 'Account Type','Created On','Approved On'));
	$result = mysqli_query($conn, $query);
	$field = array();
	while($row = mysqli_fetch_assoc($result))
	{
		$field = array("User Id"=>$row['user_id'],"Sender Id"=>$row['sender_id'],"Status"=>$row['is_approved'],"Account Type"=>$row['account_type'],"Created On"=>$row['created_on'],"Approved On"=>$row['approved_on']);
		if($field['Status']==0)
		{
			$field['Status']="INACTIVE";
		}
		if($field['Status']==1)
		{
			$field['Status']="ACTIVE";
		}
		if($field['Account Type']==1)
		{
			$field['Account Type']="Promotional";
		}
		if($field['Account Type']==2)
		{
			$field['Account Type']="Transcrub";
		}
		if($field['Account Type']==3)
		{
			$field['Account Type']="Transactional";
		}
		fputcsv($output,$field);
	}
	
	fclose($output);
}
//****************************Download CSV Sender Id*****************************
//****************************Download CSV Template*****************************
if(isset($_POST['download_template_csv']))
{	
	
	$query = $_POST['csv_query'];
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=Template_Approval.csv');
	$output = fopen("php://output", "w");
	fputcsv($output, array('User Id', 'Sender Id','Template' , 'Status', 'Created On','Approved On', 'Updated On'));
	$result = mysqli_query($conn, $query);
	$field = array();
	while($row = mysqli_fetch_assoc($result))
	{
		$field = array("User Id"=>$row['userid'],"Sender Id"=>$row['senderid'],"Template"=>$row['template'],"Status"=>$row['is_incl_template'],"Created On"=>$row['created_date'],"Approved On"=>$row['approved_on'],"Updated On"=>$row['updated_on']);
		if($field['Status']==0)
		{
			$field['Status']="Pending";
		}
		if($field['Status']==1)
		{
			$field['Status']="Approved";
		}
		if($field['Status']==2)
		{
			$field['Status']="Not Approved";
		}
		fputcsv($output,$field);
	}
	
	fclose($output);
}

//****************************Download CSV Template*****************************
//****************************Download CSV Credits Assignment*****************************
if(isset($_POST['download_User_credits_detail_csv']))
{	
	
	$query = $_POST['csv_query'];
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=Users_Available_Credits.csv');
	$output = fopen("php://output", "w");
	fputcsv($output, array('User Id', 'Credits Assigned', 'Credits Used', 'Credits Available', 'Expiry Date'));
	$result = mysqli_query($conn, $query);
	$field = array();
	while($row = mysqli_fetch_assoc($result))
	{
		$field = array("User Id"=>$row['user_id'],"Credits Recharged"=>$row['credits_assigned'],"Credits Used"=>$row['credits_used'],"Credits Available"=>$row['credits_avialable'],"Expired On"=>$row['expired_on']);
		fputcsv($output,$field);
	}
	
	fclose($output);
}

//****************************Download CSV Credits Assignment*****************************
//****************************Download CSV User History*****************************
if(isset($_POST['download_User_credits_history_csv']))
{	
	
	$query = $_POST['csv_query'];
	if($query == "")
	{
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=User_Credits_History.csv');
		$output = fopen("php://output", "w");
		fputcsv($output, array('Select a User.'));
		fclose($output);
	}
	else
	{
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=User_Credits_History.csv');
		$output = fopen("php://output", "w");
		fputcsv($output, array('User Id', 'Credits Added', 'Credits Debited', 'Credits Revoked', 'Credits Available', 'Created On'));
		$result = mysqli_query($conn, $query);
		$field = array();
		while($row = mysqli_fetch_assoc($result))
		{
			$field = array("User Id"=>$row['userid'],"Credits Recharged"=>$row['credits_recharged'],"Credits Debited"=>$row['credits_debited'],"Credits Revoked"=>$row['credits_revoked'],"Credits Available"=>$row['credits_available'],"Created On"=>$row['created_date']);
			fputcsv($output,$field);
		}
		
		fclose($output);
	}
}

//****************************Download CSV User History*****************************

?>