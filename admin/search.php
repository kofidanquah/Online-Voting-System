<?php
require "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$search = $_POST["go"];

    try {

        $sql = "SELECT * FROM voters WHERE FIRST_NAME = :search";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(":search", $search);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $gender = $row["GENDER"];
                $voterId = $row["VOTER_ID"];
                echo $gender;
                echo $voterId;
                header("Location:voters.list.php");
                die;
            }
        } else {
            echo "No Record Found";
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
?>
