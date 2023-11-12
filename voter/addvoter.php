<?php
include "../config.php";
include "../library.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $gender = $_POST["gender"];
    $file = $_FILES["image"];
    $voterCode= $_POST["voterCode"];
    $voterPassword= $_POST["voterPassword"];

    if ($file) {
        $filename = $file["name"];
        $tmp_name = $file["tmp_name"];
        $folder = "../uploads/";

        // Move the uploaded image to the "uploads" folder
        if (move_uploaded_file($tmp_name, $folder . $filename)) {
            // Insert image information into the database
            try {
                $voterCode=generateVoterCode();
                $voterPassword=generateVoterPassword();

                $query = "INSERT INTO voters (VOTER_IMAGE, GENDER, FIRST_NAME, LAST_NAME, VOTER_ID, PASSWORD) VALUES (:filename, :gender,  :firstname, :lastname, :voterCode, :voterPassword)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':filename', $filename);
                $stmt->bindParam(':firstname', $firstname);
                $stmt->bindParam(':lastname', $lastname);
                $stmt->bindParam(':gender', $gender);
                $stmt->bindParam(':voterCode', $voterCode);
                $stmt->bindParam(':voterPassword', $voterPassword);
                $stmt->execute();
                echo "New voter added successfully." . '<br>';
                echo '<a href="../admin/admin.page.php"><button class="btn btn-dark text-light px-3">admin</button></a>';
                echo '<a href="addvoter.view.php"><button class="btn btn-dark text-light px-3">Back</button></a>';

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