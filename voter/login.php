<?php
require "../config.php";

$voterId = $password = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (empty($_POST["voterId"]) || empty($_POST["password"])) {
        $_SESSION["status"] = true;
        $_SESSION["message"] = "Mandatory fields are required";
        header("location:login.php");
        die();
    } else {
        $voterId = test_input($_POST["voterId"]);
        $password = $_POST["password"];

        $stmt = $conn->prepare("SELECT * FROM voters WHERE VOTER_ID =:voterId AND PASSWORD =:password LIMIT 1");

        $stmt->bindParam(":voterId", $voterId);
        $stmt->bindParam(":password", $password);

        $status = $stmt->execute();
        
        if ($status) { 
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);

                $_SESSION["firstname"] =$data['FIRST_NAME'];
                $_SESSION["lastname"] =$data['LAST_NAME'];
                $_SESSION["voteStatus"] =$data['STATUS'];
                $_SESSION['gender'] =$data['GENDER'];
                $_SESSION['image'] =$data['VOTER_IMAGE'];
                $_SESSION['electionYear'] =$data['ELECTION_YEAR'];
                $_SESSION["voterId"] =$voterId;
                $_SESSION["status"] = false;
                // $_SESSION["message"] = "Login sucessful";
                header("location:dashboard.php");
                die();
            } else {
                $_SESSION["status"] = true;
                $_SESSION["message"] = "Login failed";
                header("location:login.view.php");
                die();
            }
        } else {
            $_SESSION["status"] = true;
            $_SESSION["message"] = $stmt->errorInfo();
            header("location:login.view.php");
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
