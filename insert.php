<?php
include "config.php";

$username = $password = $cpassword = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST["username"])) {
        $username = test_input($_POST["username"]);
    }

    if (!empty($_POST["password"])) {
        $password = $_POST["password"];
    }

    if (empty($username) || empty($password)) {
        echo "Required fields";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];

        //check if passwords match
        if ($password != $cpassword) {
            $_SESSION["status"] = true;
            $_SESSION["message"] = "Password does not match";

            header("location:sign_up.php");
            die();
        }

        if ($hasError) {
            echo $errorString;
            exit;
        }
        //checking database for already existing username
        $query = $conn->prepare("SELECT * FROM users WHERE USERNAME =:username");
        $query->bindParam (":username",$username);

        $query->execute();

            if($query->rowCount() > 0) {
            $_SESSION["status"] = true;
            $_SESSION["message"] = "username already exists";
            header("location:sign_up.php");
            die();
        }else{
            //Insert statement
        $stmt = $conn->prepare("INSERT INTO users (USERNAME, PASSWORD) VALUES (:username, :password)");

        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password);


        $status = $stmt->execute();
        if ($status) {
            $_SESSION["name"] = $_POST["name"];
            $_SESSION["status"] = false;
            $_SESSION["message"] = "Sign up successful";
            header("location:sign_up.php");
            die();
        } else {
            $_SESSION["status"] = true;
            $_SESSION["message"] = $stmt->errorInfo();
            header("location:sign_up.php");
            die();
        }

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
