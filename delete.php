<?php
require "config.php";

if (isset($_GET["deleteid"])) {
    $candCode = $_GET["deleteid"];

try {

$query = "DELETE FROM candidates WHERE CAND_CODE=:candCode";
$stmt = $conn->prepare($query);
$stmt->bindParam(':candCode', $candCode);

    $stmt->execute();

    echo "Record deleted successfully." . '<br>';
    header("Location:admin/admin.page.php");
    die();
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
} else {
echo "failed to delete record.";
die();
}



$conn = null;
?>

