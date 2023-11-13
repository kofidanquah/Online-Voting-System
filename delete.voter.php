<?php
require "config.php";

if (isset($_GET["deleteid"])) {
    $voter_Id = $_GET["deleteid"];

try {

$query = "DELETE FROM voters WHERE VOTER_ID=:voter_Id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':voter_Id', $voter_Id);
$stmt->execute();

    echo "Record deleted successfully." . '<br>';
    header("Location:admin/voters.list.php");
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

