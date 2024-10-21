<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="adminregister.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>    
    <style>
        .show-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .input-box {
            position: relative; /* Added for positioning of icons */
        }
    </style>
</head>

<body>
    
    <div class="admin">
        <form action="" method="post">

        <?php
            include("php/config.php");
            if (isset($_POST['submit'])) {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $username = $_POST['username'];
                $cnumber = $_POST['cnumber'];
                $password = $_POST['password'];
                $cpassword = $_POST['cpassword'];

                $result = mysqli_query($con, "SELECT * FROM `admin_form` WHERE name='$name'") or die("Select Error");
                $row = mysqli_fetch_assoc($result);
                
                if (is_array($row) && !empty($row)) {
                    echo "<div class='message'> 
                            <center><p>Name already exists!</p></center>
                        </div> <br>";
                    echo "<input type='button' class='btn' value='Go Back' onclick=\"window.location.href='adminregister.php'\">";
                } else {
                    if ($password != $cpassword) {
                        echo "<div class='message'> 
                                <p>Passwords do not match. Please try again.</p>
                            </div> <br>";
                        echo "<input type='button' class='btn' value='Go Back' onclick=\"window.location.href='adminregister.php'\">";
                    } else {
                        $verify_query = mysqli_query($con, "SELECT * FROM `admin_form` WHERE email='$email'");

                        if (mysqli_num_rows($verify_query) != 0) {
                            echo "<div class='message'> 
                                    <p>This email is used, Try another one.</p>
                                </div> <br>";
                            echo "<input type='button' class='btn' value='Go Back' onclick=\"window.location.href='adminregister.php'\">";  
                        } else {
                            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $headers = @get_headers('http://www.' . $email);
                                if ($headers !== false) {
                                    mysqli_query($con, "INSERT INTO admin_form(name, username, email, contactnumber, password) VALUES('$name', '$username', '$email', '$cnumber', '$password')");
                                    echo "<div class='message'> 
                                            <p>Registration Successfully!</p>
                                        </div> <br>";
                                    echo "<input type='button' class='btn' value='Go Back to Login' onclick=\"window.location.href='adminlogin.php'\">";
                                } else {
                                    echo "<div class='message'> 
                                            <p>Email address does not exist. Please try again.</p>
                                        </div> <br>";
                                    echo "<input type='button' class='btn' value='Go Back' onclick=\"window.location.href='adminregister.php'\">";
                                }
                            } else {
                                echo "<div class='message'> 
                                        <p>Invalid email address. Please try again.</p>
                                    </div> <br>";
                                echo "<input type='button' class='btn' value='Go Back' onclick=\"window.location.href='adminregister.php'\">";
                            }
                        }   
                    }
                }
            } else {
        ?>

            <h1>Admin Register</h1>

            <div class="input-box">
                <input type="text" name="name" placeholder="Name" required>
                <i class='bx bx-user'></i>
            </div>

            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <i class='bx bx-user'></i>
            </div>

            <div class="input-box">
                <input type="text" name="email" placeholder="Email" required>
                <i class='bx bxl-gmail'></i>
            </div>

            <div class="input-box">
                <input type="text" name="cnumber" placeholder="Contact Number" required>
                <i class='bx bxs-contact'></i >
            </div>
            
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required id="password" minlength="8">                   
                <i class="bx bx-show-alt show-password" id="show-password"></i>
            </div>

            <div class="input-box">
                <input type="password" name="cpassword" placeholder="Confirm Password" required id="cpassword">
                <i class="bx bx-show-alt show-password" id="show-cpassword"></i>
            </div>

            <input type="submit" name="submit" value="Register" class="btn"></input>

        </form>

        <div class="login-link">
            <p>Already have an account? <a href="adminlogin.php">Login</a></p>
        </div>
        <?php } ?>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const cpasswordInput = document.getElementById('cpassword');
        const showPasswordIcon = document.getElementById('show-password');
        const showCpasswordIcon = document.getElementById('show-cpassword');

        // Toggle password visibility for the main password field
        showPasswordIcon.addEventListener('click', () => {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                showPasswordIcon.classList.replace('bx-show-alt', 'bx-hide');
            } else {
                passwordInput.type = 'password';
                showPasswordIcon.classList.replace('bx-hide', 'bx-show-alt');
            }
        });

        // Toggle password visibility for the confirm password field
        showCpasswordIcon.addEventListener('click', () => {
            if (cpasswordInput.type === 'password') {
                cpasswordInput.type = 'text';
                showCpasswordIcon.classList.replace('bx-show-alt', 'bx-hide');
            } else {
                cpasswordInput.type = 'password';
                showCpasswordIcon.classList.replace('bx-hide', 'bx-show-alt');
            }
        });
    </script>
</body>
</html>