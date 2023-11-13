<?php
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $position = $_POST["position"];
        $file = $_FILES["candimage"];
        $candCode = $_POST["candCode"];

        if ($file) {
        $filename = $file["name"];
        $tmp_name = $file["tmp_name"];
        $folder = "../uploads/";

        // Move the uploaded image to the "uploads" folder
        if (move_uploaded_file($tmp_name, $folder . $filename)) {

            // Insert image information into the database
            try {

        $query = "UPDATE candidates SET CAND_IMAGE=:filename, POSITION=:position, FIRST_NAME=:firstname, LAST_NAME=:lastname WHERE CAND_CODE = :candCode";
                $stmt = $conn->prepare($query);
        $stmt->bindParam(':filename', $filename);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':candCode', $candCode);
    
                $stmt->execute();
                echo "candidate updated successfully." . '<br>';
                die();
            } catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
            }
        } else {
            echo " upload failed.";
            die();
        }
    }
}

// Close the database connection
$conn = null;
?>


