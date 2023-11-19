<?php
require "../config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $electionCode = $_POST["electionCode"];

        $sql = "SELECT * FROM electiontrigger  WHERE ELECTION_CODE =:electionCode AND STATUS = '0' LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':electionCode', $electionCode);
        $stmt->execute();

        $status = $stmt->execute();
        
        if ($status) { 
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);

                header("location:votingpage.php");
                die();
            } else {
                echo "Election has not started";
                header("location:dashboard.php");
                die();
            }
        }
        } else {
            $_SESSION["status"] = true;
            $_SESSION["message"] = $stmt->errorInfo();
            header("location:dashboard.php");
            die();
        }
    
?>