<?php
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voterId = $_POST["voterId"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $gender = $_POST["gender"];
    $file = $_FILES["image"];
    $filename = $file["name"];
    $tmp_name = $file["tmp_name"];
    $folder = "../uploads/";


    if (empty($file['name'])) {

        // Insert image information into the database
        try {

            $query = "UPDATE voters SET  GENDER=:gender, FIRST_NAME=:firstname, LAST_NAME=:lastname  WHERE VOTER_ID=:voterId";
            $stmt = $conn->prepare($query);

            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam('voterId', $voterId);

            $stmt->execute();
            echo "Voter updated successfully." . '<br>';
            header("Location:../admin/voters.list.php");
            die();
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
            echo "Update failed";
        }
        // } else {
        //     echo " upload failed.";
        //     die();
        // }
    } else {

        try {

            $query = "UPDATE voters SET  VOTER_IMAGE=:filename, GENDER=:gender, FIRST_NAME=:firstname, LAST_NAME=:lastname  WHERE VOTER_ID=:voterId";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':filename', $filename);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam('voterId', $voterId);

            $stmt->execute();
            echo "Profile updated successfully." . '<br>';
            header("Location:../admin/voters.list.php");
            die();
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
            echo "Update failed";
        }
    }
}

// Close the database connection
$conn = null;
