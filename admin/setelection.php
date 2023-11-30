<?php
require "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $electionYear = $_POST["electionYear"];

try {
    $query = "INSERT INTO electiontrigger (ELECTION_YEAR) VALUES (:electionYear)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':electionYear', $electionYear);
    $stmt->execute();

    if ($stmt) {
        // Output the success message
        $_SESSION["successMessage"] = 'Election Set Successfully.';

        // Redirect to the admin page with the success message as a parameter
        header("Location: admin.page.php?electionYear=".$electionYear);
        die();
    }

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
}else{
    echo "Enter election code";
    die();
}