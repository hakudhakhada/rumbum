<?php

include('conn.php');

session_start();

$query = mysqli_query($conn,"SELECT * FROM login WHERE user_id != '".$_SESSION['user_id']."'");

$output = '
<table class="table table-bordered table-striped">
	<tr>
		<th>Sr No</td>
		<th>Username</td>
		<th>Action</td>
	</tr>
';

$i=1;
while ($row = mysqli_fetch_assoc($query))
{
	
	$output .= '
	<tr>
		<td>'.$i.'</td>
		<td>'.$row['username'].' '.count_unseen_message($row['user_id'], $_SESSION['user_id'], $conn).'</td>
		
		<td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['username'].'">Start Chat</button></td>
	</tr>
	';
	$i++;
}

$output .= '</table>';

echo $output;

?>