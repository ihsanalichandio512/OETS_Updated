<?php 
include "../db/dbConnection.php";

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    // Assuming you have a function to delete the user
    $userId = $_GET['id'];
    if (deleteUser($userId)) {
        echo "User deleted successfully.";
        header("location:add_teacher.php");
    } else {
        echo "Error deleting user.";
        header("location:add_teacher.php");
    }
} else {
    echo "User ID not provided.";
    header("location:add_teacher.php");

}

// Function to delete the user from the database
function deleteUser($userId) {
   include "../db/dbConnection.php";
    $sql = "DELETE FROM teachers WHERE teacher_id = '$userId' ";
    $done = mysqli_query($conn,$sql);
    
    if ($done) {
        return true;
    } else {
        return false;
    }
}


mysqli_close($conn);
?>