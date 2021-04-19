<?php 
session_start();
require_once('inc/functions.php');
$info = '';
$task = $_GET['task'] ?? 'report';
$error = $_GET['error'] ?? '0';
$_SESSION['loggedin'] = $_SESSION['loggedin'] ?? false;
$_SESSION['role'] = $_SESSION['role'] ?? false;

if('edit' == $task){
    if(!hasPrivilege()){
        header('Location: index.php?report');
    }
}

// Data delete 
if('delete' == $task){
    if(!isAdmin()){
        header('Location: index.php?report');
        return;
    }
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
    if($id>0){
        deleteStudent($id);
        header('Location: index.php?report');
    }
}
// Data seeding 
if('seed' == $task){
    if(!isAdmin()){
        header('Location: index.php?report');
        return;
    }
    seed();
    $info = "Seeding is completed";
}
$fname = '';
$lname = '';
$roll = '';
if(isset($_POST['submit'])){
     $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
     $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
     $roll = filter_input(INPUT_POST, 'roll', FILTER_SANITIZE_STRING);
     $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
     if($id){
        //  update the existing student 
        if($fname !='' && $lname !='' && $roll !=''){
            $result = updateStudent($id, $fname, $lname, $roll);
            header('location: index.php?task=report');
            if($result){
                header('location: index.php?task=report');
            }else{
                // header('location : index.php?task=report&error=1');
                $error = 1;
            }
        }
     }else{
        //  Add a new student 
        if($fname !='' && $lname !='' && $roll !=''){
            $result = addStudent ($fname, $lname, $roll);
            if($result){
                header('Location: crud/index.php');
            }else{
                // header('location : index.php?task=report&error=1');
                $error = 1;
            }
        }
     }   
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
    <title>CRUD Operation</title>
    <style>
        body{
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="column column-60 column-offset-20">
                <h2>Project 2 - CRUD Operation</h2>
                <p>A simple project to perform crud operations using plain files and php</p>
                <?php include_once('inc/templates/nav.php'); ?>
                <hr>
                <?php 
                if($info!=''){
                    echo "<p>{$info}</P>";
                }
                ?>
            </div> <!-- end .column -->
        </div> <!-- end .row -->
            
        <?php if('1' == $error): ?>
            <div class="row">
            <div class="column column-60 column-offset-20">
               <blockquote>
                    Duplicate Roll Number
               </blockquote>
            </div> <!-- end .column -->
        </div> <!-- end .row -->
        <?php endif; ?>

        <?php if('report' == $task): ?>
            <div class="row">
            <div class="column column-60 column-offset-20">
                <?php generateReport(); ?>
            </div> <!-- end .column -->
        </div> <!-- end .row -->
        <?php endif; ?>

        <!-- add data  -->
        <?php if('add' == $task): ?>
            <div class="row">
            <div class="column column-60 column-offset-20">
                <form action="index.php?task=add" method="POST">
                    <label for="fname">First Name</label>
                    <input type="text" name="fname" id="fname" value="<?php echo $fname; ?>">
                    <label for="lname">Last Name</label>
                    <input type="text" name="lname" id="lname" value="<?php echo $lname; ?>">
                    <label for="roll">Roll</label>
                    <input type="number" name="roll" id="roll" value="<?php echo $roll; ?>">
                    <button type="submit" class="button-primary" value="save" name="submit">Save</button>
                </form>
            </div> <!-- end .column -->
        </div> <!-- end .row -->
        <?php endif; ?>

        <!-- edit data  -->
        <?php if('edit' == $task): 
                $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
                $student = getStudent($id);
                if($student):
            ?>
            <div class="row">
            <div class="column column-60 column-offset-20">
                <form method="POST">
                    <input type="hidden" value="<?php echo $id?>" name="id">
                    <label for="fname">First Name</label>
                    <input type="text" name="fname" id="fname" value="<?php echo $student['fname']; ?>">
                    <label for="lname">Last Name</label>
                    <input type="text" name="lname" id="lname" value="<?php echo $student['lname']; ?>">
                    <label for="roll">Roll</label>
                    <input type="number" name="roll" id="roll" value="<?php echo $student['roll']; ?>">
                    <button type="submit" class="button-primary" value="save" name="submit">Update</button>
                </form>
            </div> <!-- end .column -->
        </div> <!-- end .row -->
        <?php 
            endif;
            endif;
        ?>
    </div> <!-- end .container -->
    <script src="assets/js/script.js"></script>
</body>
</html>