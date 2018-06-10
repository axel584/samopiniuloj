<?
session_start();
setcookie("sam_id","");
session_unset();
header('location:index.php');
?>
