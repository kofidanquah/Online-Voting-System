<?php
include "config.php";

if (isset($_SESSION)) {
    $voterId = $_SESSION["voterId"];
    $electionYear = $_SESSION["electionYear"];
} else {
    header("Location:dashboard.php");
    die();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vote1 = $_POST["vote1"];
    $vote2 = $_POST["vote2"];
    $vote3 = $_POST["vote3"];

    $today = date("Y-m-d");
        try {
        $queryc = "INSERT INTO election (CAND_CODE, VOTER_ID, ELECTION_DATE, ELECTION_YEAR) 
        VALUES (:candCode, :voterId, :today, :electionYear)";

        $stmt1 = $conn->prepare($queryc);
        $stmt1->bindParam(':candCode', $vote1);
        $stmt1->bindParam(':voterId', $voterId);
        $stmt1->bindParam(':today', $today);
        $stmt1->bindParam(':electionYear', $electionYear);
        $stmt1->execute();

        $stmt2 = $conn->prepare($queryc);
        $stmt2->bindParam(':candCode', $vote2);
        $stmt2->bindParam(':voterId', $voterId);
        $stmt2->bindParam(':today', $today);
        $stmt2->bindParam(':electionYear', $electionYear);
        $stmt2->execute();

        $stmt3 = $conn->prepare($queryc);
        $stmt3->bindParam(':candCode', $vote3);
        $stmt3->bindParam(':voterId', $voterId);
        $stmt3->bindParam(':today', $today);
        $stmt3->bindParam(':electionYear', $electionYear);
        $stmt3->execute();


        $queryv = "UPDATE voters SET STATUS = '1' WHERE VOTER_ID = :voterId";
        $stmtv = $conn->prepare($queryv);
        $stmtv->bindParam(':voterId', $voterId);
        $stmtv->execute();

        if ($stmt1) {
            // Store the success message in a session
            $_SESSION["Message"] = 'Voting Successful';

            // Redirect to the admin page
            header("Location: voter/dashboard.php");
            die();
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
} else {
    echo "vote upload failed.";
    die();
}
// Close the database connection
$conn = null;
?>