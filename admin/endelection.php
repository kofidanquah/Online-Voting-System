<?php
require "../config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $electionYear = $_POST["electionYear"];
    
    $date = date("Y-m-d H:i:s");
    try {
        $sql = "UPDATE electiontrigger SET STATUS = '2', END_DATE = :date WHERE ELECTION_YEAR = :electionYear";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':electionYear', $electionYear);
        $stmt->execute();

        if ($stmt) {
            header("Location: admin.page.php?electionYear=" . $electionYear);
            die();
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
} else {
    echo "failed to end election";
    die();
}
