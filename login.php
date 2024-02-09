<?php 

session_start();
if (isset($_SESSION["user"])) {
   header("Location: deshboard.php");
}
$title = "Login";
include 'includes/header.php';
include 'includes/navbar.php';



?>
    <div class="mainArea">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 mt-5">
                    <div class=" shadow-sm p-3 mb-5 bg-body-tertiary rounded">
                        <?php
                           if (isset($_POST["login"])) {
                            $email = $_POST["email"];
                            $password = $_POST["password"];
                            
                             require_once "dbcon.php";
                             $sql = "SELECT * FROM users WHERE email = '$email'";

                             $result = mysqli_query($conn, $sql);
                             $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                             if ($user) {
                                 if (password_verify($password, $user["password"])) {
                                     session_start();
                                     $_SESSION["user"] = "yes";
                                     header("Location: deshboard.php");
                                     die();
                                 }else{
                                     echo "<div class='alert alert-danger'>Password does not match</div>";
                                 }
                             }else{
                                 echo "<div class='alert alert-danger'>Email does not match</div>";
                             }
                         }
                        ?>
                        <form method="POST" action="login.php">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" id="email" >
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password">
                            </div>
                            <button type="submit" name="login" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include 'includes/footer.php';?>