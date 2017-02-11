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

$name = null;
$email = null;
$subject = null;
$message = null;
$success = null;

if (isset($_POST['name'])) {
  $name = $_POST['name'];
}
if (isset($_POST['email'])) {
  $email = $_POST['email'];
}
if (isset($_POST['subject'])) {
  $subject = $_POST['subject'];
}
if (isset($_POST['message'])) {
  $message = $_POST['message'];
}

if ($name != null && $email != null &&
 $subject != null && $message != null) {
   $sql = "INSERT INTO web_messages (name, email, subject, message)
           VALUES ('$name', '$email', '$subject', '$message')";
  $success = "<p id='success'> Success!! </p>";
   if (!mysql_query($sql)) {
     die('cannot save data' . mysql_error());
   } else {
     $success = "<p id='success'> Success!! </p>";
   }
}

mysql_close();

?>
