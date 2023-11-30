<?php
require "../config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $electionYear = $_POST["electionYear"];

    $sql = "SELECT * FROM electiontrigger  WHERE ELECTION_YEAR =:electionYear AND STATUS = '1' LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':electionYear', $electionYear);
    $stmt->execute();

    $status = $stmt->execute();

    if ($status) {
        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            $_SESSION["electionYear"] =$data['ELECTION_YEAR'];
            header("location:votingpage.php");
            die();
        } else {
            echo "<script>alert('Election has not started')</script>";
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