<?php
require "../config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $electionCode = $_POST["electionCode"];

    $date = date("Y-m-d H:i:s");

    try {
        $sql = "UPDATE electiontrigger SET STATUS = '1', END_DATE = :date WHERE ELECTION_CODE =:electionCode";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':electionCode', $electionCode);
        $stmt->execute();

        echo "voting ended successfully.";
        header("Location:admin.page.php");
        die();
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}else{
    echo "failed to end election";
    die();
}
