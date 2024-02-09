<?php 

session_start();
if (isset($_SESSION["user"])) {
   header("Location: deshboard.php");
}
$title = "Registration";
include 'includes/header.php';
include 'includes/navbar.php';

?>
    <div class="mainArea">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 mt-5">
                    <div class=" shadow-sm p-3 mb-5 bg-body-tertiary rounded">
                        <?php 

                            if(isset($_POST['register'])){
                                $name = $_POST['name'];
                                $phone = $_POST['phone'];
                                $email = $_POST['email'];
                                $password = $_POST['password'];
                                $verify_token = md5(rand());
                                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                                $errors = array();
                                if(empty($name) || empty($phone) || empty($email) || empty($password)){
                                    array_push($errors, "Empty Fields");
                                }
                                if(count($errors) > 0){
                                    foreach($errors as $error){
                                        echo "<div class='alert alert-danger'>${error}</div>";
                                    }
                                }
                                else{
                                    require_once 'dbcon.php';
                                    $stmt = mysqli_stmt_init($conn);
                                    $check_email_query = "SELECT email FROM users WHERE email = '$email' LIMIT 1";
                                    $check_email_query_run = mysqli_query($conn, $check_email_query);
                                
                                    if(mysqli_num_rows($check_email_query_run) > 0){
                                        echo "<div class='alert alert-danger'>Email Already Exists</div>";
                                    }
                                    else{
                                        $query = "INSERT INTO users (name, phone, email, password, verify_token ) VALUES (?, ?, ?, ?, ?)";
                                        
                                        $query_run = mysqli_stmt_prepare($stmt, $query);
                                        if($query_run){
                                            mysqli_stmt_bind_param($stmt, "sssss", $name, $phone, $email, $hashed_password, $verify_token);
                                            mysqli_stmt_execute($stmt);
                                            echo "<div class='alert alert-success'>Registration Successful. Check your email for verification link</div>";
                                        }
                                        else{
                                            die("Query fails");
                                        }
                                    }
                                }
                            }
                        ?>
                        <form method="POST" action="registration.php">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="name" >
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" id="phone" >
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" id="email" >
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password">
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" name="confirmPassword" class="form-control" id="confirmPassword">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Check me out</label>
                            </div>
                            <button type="submit" name="register" class="btn btn-primary">Registration</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include 'includes/footer.php';?>