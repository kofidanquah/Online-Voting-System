<?php
require "../config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $electionCode = $_POST["electionCode"];

    $date = date("Y-m-d H:i:s");

    try {
        $sql = "UPDATE electiontrigger SET STATUS = '2', END_DATE = :date WHERE ELECTION_CODE = :electionCode";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':electionCode', $electionCode);
        $stmt->execute();

        if ($stmt) {
            // Output the success message
            $successMessage = "<script>alert('Election Ended.')</script>";

            // Redirect to the admin page with the success message as a parameter
            header("Location: admin.page.php?message=" . urlencode($successMessage));
            die();
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
} else {
    echo "failed to end election";
    die();
}
