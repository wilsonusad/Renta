<?php
session_start();

$username = "";
$email = "";
$password_1 = "";
$password_2 = "";
$errors = array();

$db = mysqli_connect('localhost', 'root', '', 'registeration');

if (isset($_POST['reg_user'])){
    
    
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
    
    if (empty($username)) { array_push($errors, "username is required"); }
    if (empty($email)) { array_push($errors, "email is required"); }
    if (empty($password_1)) { array_push($errors, "password is required"); }
    if ($password_1 != $password_2){
        array_push($errors, "The passwords do not match"); }
    
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1"; $result = mysqli_query($db, $user_check_query);$user = mysqli_fetch_assoc($result);
    
    if ($user) {
        
        if ($user['username'] === $username){
            array_push($errors, "username already exists");}
        if ($user['email'] === $username){
            array_push($errors, "email already exists"); 
        }
    }
    if (count($errors) == 0){
        $password = md5($password_1);
        
        $query = "INSERT INTO users (username, email, password) VALUES('$username', '$email', '$password')";
        mysqli_query($db, $query);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in"; header('location: index.php');
    }
    
}
//LOGIN USER
if (isset($_POST['login_user'])){
     $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
     if (empty($username)) { array_push($errors, "username is required"); }
    if (empty($password)) { array_push($errors, "password is required"); }
    if (count($errors) == 0){
        $password = md5($password);
        
        $query = "SELECT * FROM users WHERE username='$username' AND password= '$password'";
            
        $results= mysqli_query($db, $query);
        
        if (mysqli_num_rows($results) == 1){
        
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in"; header('location: index.php');
            
    }else{
            array_push($errors, "Wrong username/password combintion");
        }
    }
}
?>