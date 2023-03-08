<?php

include('conn.php');

if(isset($_POST["chat_message_id"]))
{
	$query = mysqli_query($conn,"UPDATE chat_message SET status = '2' WHERE chat_message_id = '".$_POST['chat_message_id']."'");
}

?>