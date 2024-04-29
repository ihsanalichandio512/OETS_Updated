<?php
// include "../db/dbConnection.php";

// if($_POST['type']== ""){

//     $sql = "SELECT * FROM exams";
//     $query = mysqli_query($conn,$sql) or die("Query Unsuccessful");
    
//     $str ="";
//     while($row = mysqli_fetch_assoc($query)){
//         $str .="<option value=''{$row['exam_id']}>{$row['exam_type']}</option>";
//     }
// }elseif($_POST['type'] == "examType"){

//     $sql = "SELECT * FROM semesters WHERE semesters.semester_id = {$_POST['id']} ";
//     // $sql = "SELECT * FROM semesters WHERE exam_type = {$_POST['id']}";
//     // $sql = "SELECT exams.*,semesters.semester_name FROM exams INNER JOIN semesters ON exams.semester_id = semesters.semester_id WHERE exam_type = {$_POST['id']}";

//     $query = mysqli_query($conn,$sql) or die("Query Unsuccessful");
//     $str ="";
//     while($row = mysqli_fetch_assoc($query)){
//         $str .= "<option value='{$row['semester_id']}'>{$row['semester_name']}</option>";

//     }
// }

// echo $str;
?>