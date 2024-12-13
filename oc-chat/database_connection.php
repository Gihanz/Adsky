<?php

//database_connection.php

$connect = new PDO("mysql:host=localhost;dbname=osclass;charset=utf8mb4", "root", "");

date_default_timezone_set('Asia/Kolkata');

function fetch_user_last_activity($user_id, $connect)
{
	$query = "
	SELECT * FROM oc_t_login_details 
	WHERE user_id = '$user_id' 
	ORDER BY last_activity DESC 
	LIMIT 1
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['last_activity'];
	}
}

function fetch_inbox($user_id, $connect){

	$query = "
	SELECT distinct pk_i_id, s_name FROM oc_t_user user JOIN oc_t_chat_message chatMessage ON user.pk_i_id=chatMessage.from_user_id WHERE chatMessage.to_user_id= '".$user_id."' 
	";

	$statement = $connect->prepare($query);

	$statement->execute();

	$result = $statement->fetchAll();

	$output = '
	<table class="table table-bordered table-striped">
		<tr>
			<th width="70%">Username</td>
			<th width="20%">Status</td>
			<th width="10%">Action</td>
		</tr>
	';

	foreach($result as $row)
	{
		$status = '';
		$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
		$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
		$user_last_activity = fetch_user_last_activity($row['pk_i_id'], $connect);
		if($user_last_activity > $current_timestamp)
		{
			$status = '<span class="badge chat-badge-success">Online</span>';
		}
		else
		{
			$status = '<span class="badge chat-badge-danger">Offline</span>';
		}
		$output .= '
		<tr>
			<td>'.$row['s_name'].' '.count_unseen_message($row['pk_i_id'], $user_id, $connect).' '.fetch_is_type_status($row['pk_i_id'], $connect).'</td>
			<td>'.$status.'</td>
			<td><button type="button" class="chat-btn inbox_start_chat" data-touserid="'.$row['pk_i_id'].'" data-tousername="'.$row['s_name'].'">Chat</button></td>
		</tr>
		';
	}

	$output .= '</table>';
	echo $output;
	
}

function fetch_user_chat_history($from_user_id, $to_user_id, $connect)
{
	$query = "
	SELECT * FROM oc_t_chat_message 
	WHERE (from_user_id = '".$from_user_id."' 
	AND to_user_id = '".$to_user_id."') 
	OR (from_user_id = '".$to_user_id."' 
	AND to_user_id = '".$from_user_id."') 
	ORDER BY timestamp DESC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '<ul class="list-unstyled">';
	foreach($result as $row)
	{
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
				$user_name = '<button type="button" style="background-color: #ea4335; border-radius: 5px; color: white;" class="remove_chat" id="'.$row['chat_message_id'].'">x</button>&nbsp;<b class="text-success">You</b>';
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
			$user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $connect).'</b>';
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
	$query = "
	UPDATE oc_t_chat_message 
	SET status = '0' 
	WHERE from_user_id = '".$to_user_id."' 
	AND to_user_id = '".$from_user_id."' 
	AND status = '1'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $output;
}

function get_user_name($user_id, $connect)
{
	$query = "SELECT s_name FROM oc_t_user WHERE pk_i_id = '$user_id'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['s_name'];
	}
}

function count_unseen_message($from_user_id, $to_user_id, $connect)
{
	$query = "
	SELECT * FROM oc_t_chat_message 
	WHERE from_user_id = '$from_user_id' 
	AND to_user_id = '$to_user_id' 
	AND status = '1'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = $statement->rowCount();
	$output = '';
	if($count > 0)
	{
		$output = '<span class="badge badge-success">'.$count.'</span>';
	}
	return $output;
}

function fetch_inbox_unseen_message($user_id, $connect)
{
	$query = "
	SELECT * FROM oc_t_chat_message 
	WHERE to_user_id = '$user_id' 
	AND status = '1'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = $statement->rowCount();
	if($count == 0)
	{
		$count = '';
	}
	return $count;
}

function fetch_is_type_status($user_id, $connect)
{
	$query = "
	SELECT is_type FROM oc_t_login_details 
	WHERE user_id = '".$user_id."' 
	ORDER BY last_activity DESC 
	LIMIT 1
	";	
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		if($row["is_type"] == 'yes')
		{
			$output = ' - <small><em><span class="text-muted">Typing...</span></em></small>';
		}
	}
	return $output;
}

?>