<?php
require "../config.php";
if (isset($_SESSION["electionYear"]));
$electionYear = $_SESSION["electionYear"];

$resultSql = "SELECT CAND_CODE, COUNT(ID) AS TOTAL_VOTES FROM election GROUP BY CAND_CODE";
$resultStmt = $conn->prepare($resultSql);
$resultStmt->execute();

$electionResult = $resultStmt->fetchAll(PDO::FETCH_ASSOC);

$url1=$_SERVER['REQUEST_URI'];
header("Refresh: 5; URL=$url1");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <style>
        img {
            height: 100px;
            width: 100px;
        }


        table {
            border: 4px solid green;
        }

        hr {
            border: 1px solid black;
        }

        h1 {
            text-align: center;
        }

        h3 {
            text-align: center;
            font-size: large;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }
        header {
            background-color: rgb(21, 115, 71);
            height: 60px;
            width: 100%;
        }

    </style>

    <title>Results</title>
</head>

<body>
<header class="header text-light text-center px-3 sticky-top">
        <h2>RESULTS</h2>
    </header>
    
    <div class="container-fluid my-5">
        <button class="btn btn-dark text-light px-3" onclick="goBack()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
            </svg>
            Back</button>

            <button class="btn btn-primary px-3" onclick="window.print()">Print</button>

        <h1>ELECTION <?php echo $electionYear ?> </h1>
        <hr>
<div class="container-fluid">

<!-- President -->
    <table class="table table-hover">
        <h3>PRESIDENT</h3>
        <thead>
            <tr>
                <th>Image</th>
                <th>Candidate Name</th>
                <th>Number of votes</th>
            </tr>
        </thead>
        <tbody>
            <?php

            try {
                $sql = "SELECT * FROM candidates  WHERE POSITION ='President' AND ELECTION_YEAR = '$electionYear'";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $fullName = $row['FIRST_NAME'] . ' ' . $row['LAST_NAME'];
                    $image = $row['CAND_IMAGE'];
                    $candCode = $row['CAND_CODE'];

                    $votes = 0;
                    foreach ($electionResult as $k => $v) {
                        if ($v['CAND_CODE'] == $candCode) {
                            $votes = $v['TOTAL_VOTES'];
                            break;
                        }
                    }

            ?>

                    <tr>
                        <td> <img src="../uploads/<?php echo $image ?>"></td>
                        <td><?php echo $fullName ?></td>
                        <td><?php echo $votes ?></td>
                    </tr>
            <?php }
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }

            ?>
        </tbody>
    </table>

    <br><br>

    <!-- Vice President -->
    <table class="table table-hover">
        <h3>VICE PRESIDENT</h3>
        <thead>
            <tr>
                <th>Image</th>
                <th>Candidate Name</th>
                <th>Number of votes</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $sql = "SELECT * FROM candidates WHERE POSITION ='Vice President' AND ELECTION_YEAR = '$electionYear'";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $fullName = $row['FIRST_NAME'] . ' ' . $row['LAST_NAME'];
                    $image = $row['CAND_IMAGE'];
                    $candCode = $row['CAND_CODE'];

                    $votes = 0;
                    foreach ($electionResult as $k => $v) {
                        if ($v['CAND_CODE'] == $candCode) {
                            $votes = $v['TOTAL_VOTES'];
                            break;
                        }
                    }
            ?>

                    <tr>
                        <td> <img src="../uploads/<?php echo $image ?>"></td>
                        <td><?php echo $fullName ?></td>
                        <td><?php echo $votes ?></td>
                    </tr>
            <?php }
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }


            ?>
        </tbody>
    </table>
    <br><br>

    <!-- Secretary -->
    <table class="table table-hover">
        <h3>SECRETARY</h3>
        <thead>
            <tr>
                <th>Image</th>
                <th>Candidate Name</th>
                <th>Number of votes</th>
            </tr>
        </thead>
        <tbody>
            <?php

            try {
                $sql = "SELECT * FROM candidates WHERE POSITION ='Secretary' AND ELECTION_YEAR = '$electionYear'";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $fullName = $row['FIRST_NAME'] . ' ' . $row['LAST_NAME'];
                    $image = $row['CAND_IMAGE'];

                    $candCode = $row['CAND_CODE'];

                    $votes = 0;
                    foreach ($electionResult as $k => $v) {
                        if ($v['CAND_CODE'] == $candCode) {
                            $votes = $v['TOTAL_VOTES'];
                            break;
                        }
                    }
            ?>

                    <tr>
                        <td> <img src="../uploads/<?php echo $image ?>"></td>
                        <td><?php echo $fullName ?></td>
                        <td><?php echo $votes ?></td>
                    </tr>
            <?php }
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }


            ?>
        </tbody>
    </table>
</div>
    </div>

</body>
        <script>
            function goBack() {
                window.history.back();
            }
        </script>

</html>