<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="adminlogin.css" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>    
        <style>
            .show-password {
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
            }
        </style>
    </head>

    <body>
        
        <div class="admin">

         <?php

            include("php/config.php");

            if(isset($_POST['submit'])){
                $email = mysqli_real_escape_string($con,$_POST['email']);
                $password = mysqli_real_escape_string($con,$_POST['password']);

                $result = mysqli_query($con,"SELECT * FROM `admin_form` WHERE email='$email' AND password='$password'") or die("Select Error");
                $row = mysqli_fetch_assoc($result);

                if(is_array($row) && !empty($row)){
                    $_SESSION['valid'] = $row['email'];
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['id'] = $row['id'];

                    header("location: dashboard.php "); 
                    exit;
                }else{
                    echo "<div class= 'message'> 
                            <p>Wrong Email or Password!</p>
                        </div> <br>";
                    echo "<a href= 'adminlogin.php'><button class='btn'>Go Back</button>";  
                }
            }else{
            ?> 
              
            <form action="" method="POST" autocomplete="on">
                <h1>Admin Login</h1>
                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" required id="email" value="<?php if(isset($_COOKIE['email'])){ echo $_COOKIE['email']; } ?>">
                    <i class='bx bxl-gmail'></i>                </div>
                
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required id="password" value="<?php if(isset($_COOKIE['password'])){ echo $_COOKIE['password']; } ?>">
                    <i class="bx bx-show-alt show-password" id="show-password"></i>
                </div>
            

        <div class="remember-forgot">
            <label><input type="checkbox" id="remember-me" <?php if(isset($_COOKIE['email']) && isset($_COOKIE['password'])){ echo 'checked'; } ?>>Remember me</label>
            <a href="forgotpass.php">Forgot Password?</a>
        </div>


        <input type="submit" name="submit" value="Login" class="btn"></input>

        <div class="register-link">
            <p>Don't have an account? <a href="adminregister.php">Register</a></p>
        </div>

        </form>

        <?php } ?> 
        <script>
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const rememberMeCheckbox = document.getElementById('remember-me');
            const showPasswordIcon = document.getElementById('show-password');

            showPasswordIcon.addEventListener('click', () => {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    showPasswordIcon.classList.replace('bx-show-alt', 'bx-hide');
                } else {
                    passwordInput.type = 'password';
                    showPasswordIcon.classList.replace('bx-hide', 'bx-show-alt');
                }
            });

            rememberMeCheckbox.addEventListener('change', () => {
                if (rememberMeCheckbox.checked) {
                    localStorage.setItem('email', emailInput.value);
                    localStorage.setItem('password', passwordInput.value);
                } else {
                    localStorage.removeItem('email');
                    localStorage.removeItem('password');
                }
            });

            window.onload = () => {
                const storedEmail = localStorage.getItem('email');
                const storedPassword = localStorage.getItem('password');

                if (storedEmail && storedPassword) {
                    emailInput.value = storedEmail;
                    passwordInput.value = storedPassword;
                    rememberMeCheckbox.checked = true;
                }
            };
        </script>
    </div>

    </body >
</html>