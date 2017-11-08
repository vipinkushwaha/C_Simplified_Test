<!--<select name="city" style="overflow-x:hidden;overflow-y:scroll" class="form-control">-->
<?php
$conn = mysqli_connect("localhost","root","","vipin");
$query = mysqli_query($conn,"select * from cities where state_name='".$_POST['state_name']."'");
echo '<option value="">Select City Name</option>';
$count = mysqli_num_rows($query);
if($count > 0)
{
	
	while($res = mysqli_fetch_assoc($query))
	{
		echo '<option value="'.$res['city_name'].'">'.$res['city_name'].'</option>';
	}
}
else
{
	echo '<option value="">No City Available.</option>';
}
?>
