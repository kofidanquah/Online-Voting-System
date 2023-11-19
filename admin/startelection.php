<?php
require "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $electionCode = $_POST["electionCode"];

$date = date("Y-m-d H:i:s");

try {
    $query = "INSERT INTO electiontrigger (START_DATE, ELECTION_CODE) VALUES (:date, :electionCode)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':electionCode', $electionCode);
    $stmt->execute();

    header("Location:admin.page.php");
    die();

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
}else{
    echo "Enter election code";
    die();
}