<?php
require "../config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $electionYear = $_POST["electionYear"];

    $date = date("Y-m-d H:i:s");

    //check if election has already been started
    $query = "SELECT * FROM electiontrigger WHERE ELECTION_YEAR = '$electionYear'";
    $stmt1 = $conn->prepare($query);
    $stmt1->execute();
    $data = $stmt1->fetch(PDO::FETCH_ASSOC);

    if ($data['STATUS'] == '1') {
        $_SESSION['successMessage'] = "Election has already Started!";
        header("Location:../admin/admin.page.php?electionYear=" . $electionYear);
    }elseif($data['STATUS'] == '2') {
        $_SESSION['successMessage'] = "Election Ended Already!";
        header("Location:../admin/admin.page.php?electionYear=" . $electionYear);
    }else{
    try {
        $sql = "UPDATE electiontrigger SET STATUS = '1', START_DATE = :date WHERE ELECTION_YEAR = :electionYear";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':electionYear', $electionYear);
        $stmt->execute();

        if ($stmt) {
            // Output the success message
            $_SESSION['successMessage'] = "Election Started successfully";

            // Redirect to the admin page with the electionYear
            header("Location: admin.page.php?electionYear=" . $electionYear);
            die();
        } 
            } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
    }
} else {
    echo "Set Election First";
    header("Location: admin.page.php?electionYear=" . $electionYear);
    die();
}
?>