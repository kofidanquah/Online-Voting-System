<?php
require "../config.php";

try {
    $electionYear = $_SESSION['electionYear'];
    $voterId = $_SESSION["voterId"];

    $stmt = $conn->prepare("SELECT COUNT(ID) AS VOTE_COUNT FROM election WHERE VOTER_ID =:voterId");
    $stmt->bindParam(":voterId", $voterId);
    $status = $stmt->execute();
    $status = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($status);die;

    $query = "SELECT * FROM electiontrigger WHERE ELECTION_YEAR = :electionYear LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':electionYear', $electionYear);
    $stmt->execute();

    $response = [];
    if ($stmt->rowCount() > 0) {
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $response['status'] = $data['STATUS'];
        $response['votecount'] = $status['VOTE_COUNT'];
    } else {
        $response['status'] = '-1';
        $response['votecount'] = '-1';
    }
} catch (\Throwable $th) {
    die($th->getMessage());
}

echo json_encode($response);
exit;
