<?php
define('DB_NAME', 'interactive-resume-3');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');

$connection = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);

if (!$connection) {
  die('cannot connect to host' . mysql_error());
}

$db_selected = mysql_select_db(DB_NAME, $connection);

if (!$db_selected) {
  die('cannot use database' . DB_NAME . ': ' . mysql_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$sql = "INSERT INTO web_messages (name, email, subject, message)
        VALUES ('$name', '$email', '$subject', '$message')";

if (!mysql_query($sql)) {
  die('cannot save data' . mysql_error());
}

echo 'success!!';

mysql_close();

?>
