<?php
include "config.php";
if (isset($_SESSION)) {
    $voterId = $_SESSION["voterId"];
} else {
    header("Location:dashboard.php");
    die();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vote1 = $_POST["vote1"];
    $vote2 = $_POST["vote2"];
    $vote3 = $_POST["vote3"];


    try {
        $queryc = "INSERT INTO election (CAND_CODE, VOTER_ID) VALUES (:candCode, :voterId)";

        $stmt1 = $conn->prepare($queryc);
        $stmt1->bindParam(':candCode', $vote1);
        $stmt1->bindParam(':voterId', $voterId);
        $stmt1->execute();

        $stmt2 = $conn->prepare($queryc);
        $stmt2->bindParam(':candCode', $vote2);
        $stmt2->bindParam(':voterId', $voterId);
        $stmt2->execute();

        $stmt3 = $conn->prepare($queryc);
        $stmt3->bindParam(':candCode', $vote3);
        $stmt3->bindParam(':voterId', $voterId);
        $stmt3->execute();



        $queryv = "UPDATE voters SET STATUS = '1' WHERE VOTER_ID = :voterId";
        $stmtv = $conn->prepare($queryv);
        $stmtv->bindParam(':voterId', $voterId);
        $stmtv->execute();

        echo "voting successful." . '<br>';
        header("Location:voter/dashboard.php");
        die();
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
} else {
    echo " upload failed.";
    die();
}
// Close the database connection
$conn = null;
?>