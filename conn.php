<?php

$conn = mysqli_connect("localhost","root","","pratical");
// if(!$conn){
// 	echo "Not";
// }
// else{
// 	echo "Connet";
// }

date_default_timezone_set('Asia/Kolkata');


function fetch_user_chat_history($from_user_id, $to_user_id, $conn)
{
	
	$query = mysqli_query($conn,"SELECT * FROM chat_message WHERE (from_user_id = '".$from_user_id."' AND to_user_id = '".$to_user_id."') OR (from_user_id = '".$to_user_id."' AND to_user_id = '".$from_user_id."') ORDER BY timestamp ASC");
	$output = '<ul class="list-unstyled">';
	while ($row = mysqli_fetch_assoc($query)) {

		$user_name = '';
		$dynamic_background = '';
		$chat_message = '';
		if($row["from_user_id"] == $from_user_id)
		{
			if($row["status"] == '2')
			{
				$chat_message = '<em>This message has been removed</em>';
				$user_name = '<b class="text-success">You</b>';
			}
			else
			{
				$chat_message = $row['chat_message'];
				$user_name = '<button type="button" class="btn btn-danger btn-xs remove_chat" id="'.$row['chat_message_id'].'">x</button>&nbsp;<b class="text-success">You</b>';
			}
			

			$dynamic_background = 'background-color:#ffe6e6;';
		}
		else
		{
			if($row["status"] == '2')
			{
				$chat_message = '<em>This message has been removed</em>';
			}
			else
			{
				$chat_message = $row["chat_message"];
			}
			$user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $conn).'</b>';
			$dynamic_background = 'background-color:#ffffe6;';
		}
		$output .= '
		<li style="border-bottom:1px dotted #ccc;padding-top:8px; padding-left:8px; padding-right:8px;'.$dynamic_background.'">
			<p>'.$user_name.' - '.$chat_message.'
				<div align="right">
					- <small><em>'.$row['timestamp'].'</em></small>
				</div>
			</p>
		</li>
		';
	}
	$output .= '</ul>';
	$query = mysqli_query($conn,"UPDATE chat_message SET status = '0' WHERE from_user_id = '".$to_user_id."' AND to_user_id = '".$from_user_id."' AND status = '1'");
	return $output;
}

function get_user_name($user_id, $conn)
{
	$query = mysqli_query($conn,"SELECT username FROM login WHERE user_id = '".$user_id."'");
	while ($row = mysqli_fetch_assoc($query)) 
	{
		return $row['username'];
	}
}

function count_unseen_message($from_user_id, $to_user_id, $conn)
{
	$query = mysqli_query($conn,"SELECT * FROM chat_message WHERE from_user_id = '".$from_user_id."' AND to_user_id = '".$to_user_id."' AND status = '1'");
	$count = mysqli_num_rows($query);

 	$output = '';
	if($count > 0)
	{
		$output = '<span class="label label-success">'.$count.'</span>';
	}
	return $output;
}

?>