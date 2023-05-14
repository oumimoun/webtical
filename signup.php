<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Webtical Signup</title>
    <link rel="stylesheet" type="text/css" href="./style/signup.css">
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form class="sp" action="signup.php" method="post">
                    <div class="logo">
                        <img src="./img/LOGO.png">
                    </div>
                    <h1>Sign up</h1>
                    <div class="form-group">
                        <label for="name">Full name</label>
                        <input type="text" id="name" name="fullname" class="form-control" placeholder="Full name" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" minlength="8" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of birth</label>
                        <input type="date" id="dob" name="dob" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="bio">Bio</label>
                        <textarea id="bio" name="bio" class="form-control" rows="3" maxlength="160"></textarea>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" id="terms" name="terms" class="form-check-input" required>
                        <label class="form-check-label" for="terms">
                            I agree to the <a href="#">terms and conditions</a>.
                        </label>
                    </div>
                    <button type="submit" name="ok" class="btn btn-primary"> Sign up</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS script link -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php
    if (isset($_POST['ok'])) {
        if (isset($_POST['fullname'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['dob'], $_POST['bio'])) {
            $_SESSION['loggedIn'] = true;
            // Get form data
            $fullname = $_POST['fullname'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $dob = $_POST['dob'];
            $bio = $_POST['bio'];

            require("config/connexion.php");

            $selUser = $db->prepare('SELECT * FROM utilisateur WHERE email = :email OR username = :username');
            $selUser->bindParam(':email', $email);
            $selUser->bindParam(':username', $username);
            $selUser->execute();

            $countUser = $selUser->rowCount();

            if ($countUser > 0) {
                echo 'your user name or password is already exist';
            } else {
                $_SESSION['loggedIn'] = true;
                $insert = "INSERT INTO utilisateur VALUES ('$username', '$fullname', '$email','$password','$dob', '$bio', NULL, NULL)";
                $db->exec($insert);
                $_SESSION['loggedIn'] = true;
                $_SESSION['username'] = $username;
                echo "";
                header('Location: home.php');
            }
        }
    }
    ?>
</body>

</html>