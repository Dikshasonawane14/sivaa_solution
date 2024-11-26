<?php
include('connect.php');
session_start();
// session_destroy();

if (isset($_SESSION['ActiveUserId'])) {
    header('location: dashboard.php');
    exit();
}

if (isset($_POST['submit'])) {
    $user1 = $_POST['user1'];
    $pass1 = $_POST['pass1'];

    $sql = "SELECT * FROM `admin` WHERE username = '$user1' AND password ='$pass1'";
    $data = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($data);

    if ($row) {
        $_SESSION['ActiveUserId'] = $row['username'];
?>
        <script type="text/javascript">
            alert("Login successful");
            window.location.href = "dashboard.php";
        </script>
<?php
    } else {
?>
        <script type="text/javascript">
            alert("Login failed");
        </script>
<?php
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #4e73df;
        }
        .form-group label {
            font-weight: bold;
            color: #333;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #ccc;
            padding: 12px;
        }
        .btn-primary {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
        }
        .alert {
            text-align: center;
            font-size: 16px;
        }
        @media (max-width: 576px) {
            .login-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="" method="POST">
            <div class="form-group mb-3">
                <label for="user1">Username</label>
                <input type="text" name="user1" id="user1" class="form-control" placeholder="Enter Your Username" required>
            </div>
            <div class="form-group mb-3">
                <label for="pass1">Password</label>
                <input type="password" name="pass1" id="pass1" class="form-control" placeholder="Enter Your Password" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Login</button>
            <!-- <a href="register.php" class="d-block mt-3 text-center">Back to Register</a> -->
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
