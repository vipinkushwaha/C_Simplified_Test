<?php
$conn = mysqli_connect("localhost","root","","vipin");
$id = $_POST['template_id'];
//echo "$id";

$query = mysqli_query($conn, "DELETE FROM templatemst where template_id='".$id."'");
if($query)
{
	echo "Template Deleted Successfully";
}
?>