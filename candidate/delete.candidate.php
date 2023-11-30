<?php
require "config.php";

if (isset($_GET["deleteid"])) {
    $candCode = $_GET["deleteid"];

    try {

        $query = "DELETE FROM candidates WHERE CAND_CODE=:candCode";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':candCode', $candCode);
        $stmt->execute();
        echo "<script>
        setTimeout(function() {
            window.location.href = 'admin/admin.page.php';
        }, 1000);

        </script>";
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
