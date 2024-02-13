<?php 
require "../config.php";

if($_SERVER["REQUEST_METHOD"] =="POST"){
    $electionYear = $_POST["electionYear"];

    try {
        $sql = "UPDATE electiontrigger SET STATUS = '0' WHERE ELECTION_YEAR = :electionYear";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':electionYear', $electionYear);
        $stmt->execute();

        $query = "UPDATE voters SET STATUS = '0' WHERE ELECTION_YEAR = :electionYear";
        $stmt1 = $conn->prepare($query);
        $stmt1->bindParam(':electionYear', $electionYear);
        $stmt1->execute();

        $query2 = "DELETE FROM election WHERE ELECTION_YEAR = :electionYear";
        $stmt2 = $conn->prepare($query2);
        $stmt2->bindParam(':electionYear', $electionYear);
        $stmt2->execute();

        header("Location: admin.page.php?electionYear=" . $electionYear);
        die();

    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }

}


