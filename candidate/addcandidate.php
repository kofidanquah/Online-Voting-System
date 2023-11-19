<?php
include "../config.php";
include "../library.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $position = $_POST["position"];
    $electionCode = $_POST["electionCode"];
    $file = $_FILES["candimage"];
    $candCode = generateCandCode();

    if ($file) {
        $filename = $file["name"];
        $tmp_name = $file["tmp_name"];
        $folder = "../uploads/";


        // Move the uploaded image to the "uploads" folder
        if (move_uploaded_file($tmp_name, $folder . $filename))
        {
            // Insert image information into the database
            try {
                $candCode=generateCandCode();

                $query = "INSERT INTO candidates (CAND_IMAGE, POSITION, FIRST_NAME, LAST_NAME, CAND_CODE, ELECTION_CODE) VALUES (:filename, :position,  :firstname, :lastname, :candCode, :electionCode)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':filename', $filename);
                $stmt->bindParam(':firstname', $firstname);
                $stmt->bindParam(':lastname', $lastname);
                $stmt->bindParam(':position', $position);
                $stmt->bindParam(':candCode', $candCode);
                $stmt->bindParam(':electionCode', $electionCode);

                $stmt->execute();
                
                echo "New candidate added successfully." . '<br>';
                echo '<a href="../candidate/addcandidate.view.php"><button class="btn btn-dark text-light px-3">Back</button></a>';

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