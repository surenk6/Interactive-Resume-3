<?php

//connects to sql

define('DB_NAME', 'interactive_resume_3');
define('DB_USER', 'surenk6');
define('DB_PASSWORD', 'Kjkszpj12');
define('DB_HOST', 'localhost');
define('MY_EMAIL', 'surenakar@gmail.com');

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$connection) {
  die('cannot connect to host' . mysqli_connect_error);
}

$db_selected = mysqli_select_db($connection, DB_NAME);
if (!$db_selected) {
  die('cannot use database' . DB_NAME . ': ' . mysqli_connect_error);
}

/* sends form data to sql */

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
     if (!mysqli_query($connection,$sql)) {
       die('cannot save data' . mysqli_connect_error);
     } else {
        $success = "<p id='success'> Success!! </p>";
  /*sends an email to me*/
        $email_sql = "SELECT name, email, subject, message FROM web_messages
                      WHERE id = (SELECT max(id) FROM web_messages)";
        $result = mysqli_query($connection, $email_sql);
        $obj =  mysqli_fetch_object($result);

        $email_name = $obj->name;
        $email_from = $obj->email;
        $email_subject = $obj->subject;
        $email_message = $obj->message;
        $timestamp = date("DATE_RFC2822", time());

        $sent_email_subject = "Message From $email_name - $email_subject ";
        $sent_email_headers = "From: $email_from";

        $mailing = mail(MY_EMAIL, $sent_email_subject, $email_message, $sent_email_headers);
        $email_log = fopen("email_log.txt", "a");
        if (!$mailing){
          fwrite($email_log, "Error sending a message from $email_from at $timestamp \r\n");
        }
     }
}

mysqli_close($connection);
?>
