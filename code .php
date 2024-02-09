<?php
session_start();
include 'dbcon.php';


if(isset($_POST['register'])){
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $verify_token = md5(rand());
    $errors = array();
    if(empty($name) || empty($phone) || empty($email) || empty($password)){
        array_push($arrays, "Empty Fields");
    }
    if(count($arrays) > 0){
        foreach($arrays as $error){
            echo "<span class='error'> $error </span><br>";
        }
    }
    
    // Email Exists or not 
    $check_email_query = "SELECT email FROM users WHERE email = '$email' LIMIT 1";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    if(mysqli_num_rows($check_email_query_run) > 0){
        $_SESSION['status'] = "Email Already Exists";
        header('Location: registration.php');
        exit(0);
    }
    else{

        $query = "INSERT INTO users (name, phone, email, password, verify_token ) VALUES ('$name', '$phone', '$email', '$password', '$verify_token')";
        $query_run = mysqli_query($con, $query);

        if($query_run){
            sendemail($name, $email, $verify_token);
            $_SESSION['status'] = "Registration Successful. Check your email for verification link";
            header('Location: registration.php');
            exit(0);
        }
        else{
            $_SESSION['status'] = "Registration Failed";
            header('Location: registration.php');
            exit(0);
        }
    }
}

?>