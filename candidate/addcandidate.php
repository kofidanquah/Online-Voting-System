<?php
include "../config.php";
include "../library.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $position = $_POST["position"];
    $electionYear = $_POST["electionYear"];
    $email = $_POST["email"];
    $file = $_FILES["candimage"];
    $candCode = generateCandCode();

    if ($file) {
        $filename = $file["name"];
        $tmp_name = $file["tmp_name"];
        $folder = "../uploads/";


        // Move the uploaded image to the "uploads" folder
        if (move_uploaded_file($tmp_name, $folder . $filename)) {
            // Insert image information into the database
            try {
                $candCode = generateCandCode();

                $query = "INSERT INTO candidates (CAND_IMAGE, POSITION, FIRST_NAME, LAST_NAME, CAND_CODE, ELECTION_YEAR, CAND_EMAIL) 
                VALUES (:filename, :position,  :firstname, :lastname, :candCode, :electionYear, :email)";

                $stmt = $conn->prepare($query);
                $stmt->bindParam(':filename', $filename);
                $stmt->bindParam(':firstname', $firstname);
                $stmt->bindParam(':lastname', $lastname);
                $stmt->bindParam(':position', $position);
                $stmt->bindParam(':candCode', $candCode);
                $stmt->bindParam(':electionYear', $electionYear);
                $stmt->bindParam(':email', $email);

                $stmt->execute();

                if($stmt){
                    $_SESSION['successMessage'] = "Candidate Added Successfully";
            header("Location:../admin/admin.page.php?electionYear=" . $electionYear);
                die();
                }
            } catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
            }
        } else {
            header("Location:admin/admin.page.php");
            die;
        }
    }
}


// Close the database connection
$conn = null;
