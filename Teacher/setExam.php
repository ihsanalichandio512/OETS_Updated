<?php
include "../db/dbConnection.php";
include "../includes/head.php";
$getID = $_GET['id'];

$check = "SELECT exam_id,exam_status from exams where exam_status = 'active' AND exam_id = '$getID'";
$my = mysqli_query($conn, $check);

if (mysqli_num_rows($my) > 0) {
?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <button type="button" class="close btn" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Exam Already Active.</strong>
    </div>
    <script>
        $(".alert").alert();
    </script>
<?php
}else{
    // $update = "UPDATE exams SET `exam_status`='active' WHERE = $getID";
    $update = "UPDATE exams SET `exam_status`='active' WHERE exam_id = $getID";
    $ex = mysqli_query($conn,$update);
    if($ex){
        ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <button type="button" class="close btn" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Exam Activated Successfully.</strong>
    </div>
    <script>
        $(".alert").alert();
        </script>
    <?php
    header("location:./start_exam.php");
}else{
    ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <button type="button" class="close btn" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Exam Can't added.</strong>
    </div>
    <script>
        $(".alert").alert();
        </script>
    <?php
}
}


?>