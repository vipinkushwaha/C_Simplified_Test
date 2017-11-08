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
						$query = mysqli_query($conn, "select * from customer_credits_history where customerid='$customer_id' and created_date>='$date_from' and created_date<='$date_to'");
					}
					if(!empty($created_approved1) && empty($created_approved2))
					{
						$query = mysqli_query($conn, "select * from customer_credits_history where customerid='$customer_id' and created_date='$date_from'");
					}
					if(empty($created_approved1) && empty($created_approved2))
					{
						echo "<center style='color:red'>Please select date.</center>";
					}
				}
				if(!isset($_POST['search_btn']))
				{
					$query = mysqli_query($conn, "select * from customer_credits_history where customerid='$customer_id'");
				}
?>

<?php
				error_reporting(0);
				
				$check_string = strval($res['credits_recharged']);
				//echo substr("-vipin kushwaha",0,1);
				//if($res['credits_recharged'] == )
				$id = 1;
					if(mysqli_num_rows($query) > 0)
					{
						while($res = mysqli_fetch_array($query))
						{
							$created_date = date("d-m-Y / h:m:s", strtotime($res['created_date']));
							//echo ;
							if(substr($res['credits_recharged'],0,1) == "-")
							{
								echo "<tr><td>".$id++."</td><td>".substr($res['credits_recharged'],1)." <span style='color:#969798'>dr</span></td><td>".$created_date."</td></tr>";
							}
							//$mes = substr("-vipin kushwaha",0,1);
							else
							{
								echo "<tr><td>".$id++."</td><td>".$res['credits_recharged']." <span style='color:#969798'>cr</span></td><td>".$created_date."</td></tr>";
							}
						}
					}
					else
					{
						echo "<tr><td colspan='6'><center style='color:red;'>No Records Found</center></td></tr>";
					}
				?>