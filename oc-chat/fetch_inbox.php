<?php

//fetch_inbox.php

include('database_connection.php');

session_start();

echo fetch_inbox($_POST['user_id'], $connect);

?>