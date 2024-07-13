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

        try {
            $stmt = $conn->prepare("SELECT * FROM voters WHERE VOTER_ID =:voterId AND PASSWORD =:password LIMIT 1");

            $stmt->bindParam(":voterId", $voterId);
            $stmt->bindParam(":password", $password);

            $status = $stmt->execute();

            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($data){
                    $_SESSION["firstname"] = $data['FIRST_NAME'];
                    $_SESSION["lastname"] = $data['LAST_NAME'];
                    $_SESSION["voteStatus"] = $data['STATUS'];
                    $_SESSION['gender'] = $data['GENDER'];
                    $_SESSION['image'] = $data['VOTER_IMAGE'];
                    $_SESSION['electionYear'] = $data['ELECTION_YEAR'];
                    $_SESSION["voterId"] = $voterId;
                    header("location:dashboard.php");
                    die();
                } else {
                    

            }
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
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
