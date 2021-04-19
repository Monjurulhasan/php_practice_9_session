<?php 
session_start([
    'cookie_lifetime'=>300, // 5 min read
]);
$error = false;
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
// $username = $_POST['username'];
// $password = $_POST['password'];
// echo $username;
// echo $password;
$fp = fopen("./data/user.txt", "r");
if($username && $password){
    $_SESSION['loggedin'] = false;
    $_SESSION['user'] = false;
    $_SESSION['role'] = false;
    // echo $_SESSION['loggedin'];
    while($data = fgetcsv($fp)){
        if($data[0] == $username && $data[1] == sha1($password)){
            $_SESSION['loggedin'] = true;
            $_SESSION['user'] = $username;
            $_SESSION['role'] = $data[2];
            header('location:index.php'); 
        }
    }
    if(!$_SESSION['loggedin']){
        $error = true;
    }
}
if(isset(($_GET['logout']))){
    $_SESSION['loggedin'] = false;
    $_SESSION['user'] = false;
    $_SESSION['role'] = false;
    session_destroy();
    header('location: index.php'); 
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
    <title>Form Example</title>
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
                <h2>Simple Auth Example</h2>
            </div> <!-- end .column -->
        </div> <!-- end .row -->
        <div class="row">
            <div class="column column-60 column-offset-20">
                <?php 
                    // echo md5("admin");
                    if(true == $_SESSION['loggedin']){
                        echo "Hello admin, Welcome!";
                    }else{
                        echo "Hello Stranger, Login below";
                    }
                ?>
            </div> <!-- end .column -->
        </div> <!-- end .row -->
        <div class="row">
            <div class="column column-60 column-offset-20">
                <?php 
                    if(false == $_SESSION['loggedin']):
                ?>
                <form method="post">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password">
                    <button type="submit" class="button-primary" name="submit">Log In</button>
                </form>
                <?php 
                    else:
                ?>
                <form action="" method="post">
                    <input type="hidden" name="logout" value="1">
                    <button type="submit" class="button-primary" name="submit">Logout</button>
                </form>
                <?php 
                    endif;
                ?>
            </div> <!-- end .column -->
        </div> <!-- end .row -->
    </div> <!-- end .container -->
</body>
</html>