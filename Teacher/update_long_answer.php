<?php
include "../db/dbConnection.php";
$getID = $_GET['id'];
$sql = "UPDATE `questions` SET `is_right`='right' WHERE questions.question_id = '$getID'";
$query = mysqli_query($conn,$sql);
if($query){
    header("location:./show_long_answers.php");
}else{
    echo "can't update";
}

?>