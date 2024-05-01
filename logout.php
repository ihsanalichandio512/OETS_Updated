<?php
include "./db/dbConnection.php";

session_start();
$getuser_id = $_SESSION['user_id'];
$sql = "DELETE FROM active_sessions WHERE user_id='$getuser_id'";
$result = mysqli_query($conn, $sql);


session_unset();

session_destroy();


header("location:index.php");
?>