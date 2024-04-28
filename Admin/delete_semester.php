<?php 
include "../db/dbConnection.php";

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
function deleteUser($userId) {
    include "../db/dbConnection.php";
     $sql = "DELETE FROM semesters WHERE semester_id = '$userId' ";
     $done = mysqli_query($conn,$sql);
     
     if ($done) {
         return true;
     } else {
         return false;
     }
 }

if (isset($_GET['id'])) {
    // Assuming you have a function to delete the user
    $userId = $_GET['id'];
    if (deleteUser($userId)) {
        echo "User deleted successfully.";
        header("location:add-semester.php");
    } else {
        echo "Error deleting user.";
        header("location:add-semester.php");
    }
    
}
