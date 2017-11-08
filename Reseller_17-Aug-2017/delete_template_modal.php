<?php
$conn = mysqli_connect("localhost","root","","vipin");
$id = $_POST['template_id'];
//echo "$updateddate";
//echo "$id";
//echo "$template_data";
$query = mysqli_query($conn, "DELETE FROM templatemst where template_id='".$id."'");
?>