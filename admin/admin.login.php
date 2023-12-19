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
                $_SESSION["username"] =$username;
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
            $_SESSION["message"] = $stmt->errorInfo();
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

    <style>
        body {
        background-repeat: no-repeat;
        background-size: cover;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 90vh;
    }
    
    form {
        background-repeat: no-repeat;
        background-size: cover;
        background-color: rgba(255, 255, 255, 0.5);
        width: 240px;
        padding: 20px;
        margin: auto;
        border-radius: 20px;
        height: 50vh;
        border:2px solid black;
        box-shadow: 10px 10px 10px;
    }
    
    h2 {
        text-align: center;
        font-size: 30px;
        margin-bottom: 20px;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }
    
    input {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    
    input[type=submit] {
        width: 100%;
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    #submit:hover{
        background-color: #4CAF50;
        cursor: pointer;
    }
    .error{
        color: red !important;
    }
    .success{
        color: green !important;
    }

</style>
    <title>Admin Log in</title>
</head>
<body>
<p class="error">

    <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
        <h2>Admin Log in</h2>
        username<br><input type="text" name="username" autocomplete="off" autofocus required><br>
        password<br><input type="password" name="password" autocomplete="off" required><br><br>
        <input type="submit" value="Log in" id="submit"><br>



    </form>



</body>
</html>

