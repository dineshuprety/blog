<?php 

ob_start();
/* Using ob_start allows you to keep the content in a server-side buffer until you are ready to display it.
 This is commonly used to so that pages can send headers 'after' they've 'sent' some content already (ie, deciding to redirect half way through rendering a page).*/
 session_start();

?>
<?php require_once('../include/db.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administration</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>