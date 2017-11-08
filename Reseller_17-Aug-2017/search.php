<?php
$status_acc = $_POST['select_sta_acc'];
//echo "$status_acc";

if($status_acc == 'Status')
{
	echo '<option value="" selected="true" disabled="disabled">Select Status</option>';
	echo '<option value="active">Active</option>';
	echo '<option value="inactive">Inactive</option>';
}
if($status_acc == 'Account_Type')
{
	echo '<option value="1" selected="true" disabled="disabled">Select Account Type</option>';
	echo '<option value="promotional">Promotional</option>';
	echo '<option value="transcrub">Transcrub</option>';
	echo '<option value="transactional">Transactional</option>';
	
}
?>