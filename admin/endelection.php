<?php
require "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $electionYear = $_POST["electionYear"];

    $date = date("Y-m-d H:i:s");

    $query = "SELECT * FROM electiontrigger WHERE ELECTION_YEAR = '$electionYear'";
    $stmt1 = $conn->prepare($query);
    $stmt1->execute();
    $data = $stmt1->fetch(PDO::FETCH_ASSOC);

    if ($data['STATUS'] == '0') {
        $_SESSION['successMessage'] = "Election has not Started!";
        header("Location:../admin/admin.page.php?electionYear=" . $electionYear);
    } elseif ($data['STATUS'] == '2') {
        $_SESSION['successMessage'] = "Election Already Ended!";
        header("Location:../admin/admin.page.php?electionYear=" . $electionYear);
    } else {
        try {
            $sql = "UPDATE electiontrigger SET STATUS = '2', END_DATE = :date WHERE ELECTION_YEAR = :electionYear";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':electionYear', $electionYear);
            $stmt->execute();

            if ($stmt) {
                //Store the success message in a session
                $_SESSION['successMessage'] = "Election Ended";
                header("Location: admin.page.php?electionYear=" . $electionYear);
                die();
            }
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    }
} else {
    echo "failed to end election";
    die();
}
