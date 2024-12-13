<?php

//update_last_activity.php

include('database_connection.php');

session_start();

$query = "
UPDATE oc_t_login_details 
SET last_activity = now() 
WHERE login_details_id = '".$_SESSION["login_details_id"]."'
";

$statement = $connect->prepare($query);

$statement->execute();

?>

