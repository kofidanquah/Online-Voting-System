<?php
require "../config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $electionYear = $_POST["electionYear"];

    $date = date("Y-m-d H:i:s");
// var_dump($electionYear);die
    try {
        $sql = "UPDATE electiontrigger SET STATUS = '1', START_DATE = :date WHERE ELECTION_YEAR = :electionYear";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':electionYear', $electionYear);
        $stmt->execute();

        if ($stmt) {
            // Output the success message
            $_SESSION['successMessage'] = "Election Started successfully";
            $_SESSION['electionYear'] = $electionYear;
            // Redirect to the admin page with the electionYear
            header("Location: admin.page.php?electionYear=" . $electionYear);
            die();
        } 
            } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
    
} else {
    echo "Set Election First";
    header("Location: admin.page.php?electionYear=" . $electionYear);
    die();
}
?>