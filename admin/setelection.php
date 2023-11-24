<?php
require "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $electionCode = $_POST["electionCode"];

try {
    $query = "INSERT INTO electiontrigger (ELECTION_CODE) VALUES (:electionCode)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':electionCode', $electionCode);
    $stmt->execute();

    if ($stmt) {
        // Output the success message
        $_SESSION["<script>alert('Election Set Successfully.')</script>"] = $successMessage;

        // Redirect to the admin page with the success message as a parameter
        header("Location: admin.page.php");
        die();
    }

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
}else{
    echo "Enter election code";
    die();
}