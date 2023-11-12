<?php
require "config.php";

if (isset($_GET["deleteid"])) {
    $candCode = $_GET["deleteid"];

try {

    $sql = "DELETE FROM candidates WHERE CAND_CODE=:candCode";
    $stmt = $db->prepare($sql);
    // use exec() because no results are returned
    echo "Record deleted successfully";
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
}
$conn = null;
?>

