<?php
require "../config.php";
$username = $password = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (empty($_POST["username"]) || empty($_POST["password"])) {
        $_SESSION["status"] = true;
        $_SESSION["message"] = "Mandatory fields are required";
        header("location:admin.login.php");
        die();
    } else {
        $username = test_input($_POST["username"]);
        $password = $_POST["password"];

        $stmt = $conn->prepare("SELECT * FROM admin WHERE USERNAME =:username AND PASSWORD =:password LIMIT 1");
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password);
        $status = $stmt->execute();

        if ($status) {
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                // var_dump($data); exit;
                $_SESSION["username"] = $username;
                $_SESSION["status"] = false;
                $_SESSION["message"] = "Login sucessful";
                header("location:admin.page.php");
                die();
            } else {
                $_SESSION["status"] = true;
                $_SESSION["message"] = "Login failed";
                header("location:admin.login.php");
                die();
            }
        } else {
            $_SESSION["status"] = true;
            $_SESSION["message"] = "incorrect password";
            header("location:admin.login.php");
            die();
        }
    }
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-image: url("../images/plain\ wallpaper.jpg");
            background-size: cover;
            align-items: center;
            justify-content: center;
        }

        form {
            border-radius: 20px;
            padding: 12px 20px;
            margin: 8px 0;
            margin: auto;
        }

        h2 {
            font-size: 30px;
            margin-bottom: 20px;
            font-family: "Poppins", sans-serif;
            margin-left: 90px;
        }

        input {
            width: 100%;
            max-width: 350px;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-align: center;
            justify-content: center;
        }

        @media(min-width: 1024px) {
            form {
                margin-left: 500px;

            }
        }
    </style>
    <title>Admin Log in</title>
</head>

<body>
<?php 

if(isset($_SESSION["message"])){
    echo "<script>wrongPassword()</script>"; 
    unset($_SESSION["message"]); 
}
?>


    <div class="container-fluid">

        <div class="">
            <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <h2>Admin Login</h2>
                Username<br>
                <input type="text" name="username" autocomplete="off" required><br>
                Password<br>
                <input type="password" name="password" autocomplete="off" required><br><br>
                <input class="btn btn-success" type="submit" value="Log in" id="submit"></input>
                <!-- <button onclick=wrongPassword()>click here</button> -->
                <br>
            </form>
        </div>
    </div>

    <script>
        function wrongPassword() {
            Swal.fire({
                title: "Incorrect Username or Password!",
                timer: 5000,
                timerProgressBar: true,
            })
            ;
        }
    </script>
</body>

</html>