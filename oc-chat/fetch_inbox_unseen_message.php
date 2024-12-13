<?php

//fetch_inbox_unseen_message.php

include('database_connection.php');

session_start();

echo fetch_inbox_unseen_message($_POST['user_id'], $connect);

?>