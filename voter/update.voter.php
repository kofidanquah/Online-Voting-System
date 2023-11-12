<?php
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voterId = $_POST["voterId"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $gender = $_POST["gender"];
    $file = $_FILES["image"];

    if ($file) {
        $filename = $file["name"];
        $tmp_name = $file["tmp_name"];
        $folder = "../uploads/";

        // Move the uploaded image to the "uploads" folder
        if (move_uploaded_file($tmp_name, $folder . $filename)) {

            // Insert image information into the database
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
                header("Location:login.view.php");
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

