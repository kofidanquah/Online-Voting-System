<?php

include "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $candCode = $_POST["candCode"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $position = $_POST["position"];
    $file = $_FILES["candImage"];
    $electionYear = $_POST['electionYear'];
    $filename = $file["name"];
    $tmp_name = $file["tmp_name"];
    $folder = "../uploads/";

    if (empty($file['name'])) {

        // Insert image information into the database
        try {

            $query = "UPDATE candidates SET  POSITION=:position, FIRST_NAME=:firstname, LAST_NAME=:lastname, ELECTION_YEAR=:electionYear  WHERE CAND_CODE=:candCode";
            $stmt = $conn->prepare($query);

            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':position', $position);
            $stmt->bindParam(':candCode', $candCode);
            $stmt->bindParam(':electionYear', $electionYear);

            $stmt->execute();
            echo "Profile updated successfully." . '<br>';
            header("Location:../admin/admin.page.php?electionYear=".$electionYear);
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

            $query = "UPDATE candidates SET  CAND_IMAGE=:filename, POSITION=:position, FIRST_NAME=:firstname, LAST_NAME=:lastname, ELECTION_YEAR=:electionYear  WHERE CAND_CODE=:candCode";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':filename', $filename);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':position', $position);
            $stmt->bindParam(':candCode', $candCode);
            $stmt->bindParam(':electionYear', $electionYear);

            $stmt->execute();
            echo "Candidate updated successfully." . '<br>';
            header("Location:../admin/admin.page.php?electionYear=".$electionYear);
            die();
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
            echo "Update failed";
        }
    }
}

// Close the database connection
$conn = null;

