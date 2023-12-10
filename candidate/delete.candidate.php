<?php
require "../config.php";


if (isset($_GET["deleteid"])) {
    $candCode = $_GET["deleteid"];
    $electionYear = $_GET["electionYear"];
    
    // var_dump($electionYear);
    // var_dump($candCode);die;

    try {
        $query = "DELETE FROM candidates WHERE CAND_CODE=:candCode";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':candCode', $candCode);
        $stmt->execute();

        $_SESSION['successMessage'] ="Voter deleted successfully";
        header("Location:../admin/admin.page.php?electionYear=".$electionYear);
        die();
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
} else {
    echo "failed to delete record.";
    die();
}

//close the connection
$conn = null;
