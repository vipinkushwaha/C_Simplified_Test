<?php
$conn = mysqli_connect("localhost","root","","vipin");
date_default_timezone_set('Asia/Kolkata');
$updateddate = date("y-m-d h:i:s");
$template_data = $_POST['template_modal'];
$id = $_POST['template_id'];
//echo "$updateddate";

//echo "$id";
//echo "$template_data";
$query = mysqli_query($conn, "select * from templatemst where template_id='".$id."' and template='".$template_data."'");
$num = mysqli_num_rows($query);
if($num == 0)
{
	$query2 = mysqli_query($conn, "update templatemst set template='".$template_data."',updated_on='".$updateddate."',is_incl_template='0' where template_id='".$id."'");
	if($query2)
	{
		echo "Template Updated Successfully.";
	}
}
else
{
	echo "No Change has been Made.";
}
?>