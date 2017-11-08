<?php
$conn = mysqli_connect("localhost","root","","vipin");
$user_id = $_POST['userid'];
$query = mysqli_query($conn, "select * from sender_id where user_id='$user_id' order by id DESC");
if(mysqli_num_rows($query)>0)
{
	echo '<option value="">Select Sender Id.</option>';
	while($resa = mysqli_fetch_array($query))
	{
		echo "<option value='".$resa['sender_id']."'>".$resa['sender_id']."</option>";
	}
}
else
{
	echo '<option value="">Sender Id Not Created.</option>.';
}
?>