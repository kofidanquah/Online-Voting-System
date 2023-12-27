<?php
include "../config.php";

// login details
if (isset($_SESSION["username"])) {
    $name = $_SESSION["username"];
} else {
    header("Location:admin.login.php");
    die();
}
//dispalying all active year
$query2 = "SELECT * FROM activeyear ORDER BY YEAR ASC";
$stmt2 = $conn->prepare($query2);
$stmt2->execute();
$activeYear = $stmt2->fetchAll(PDO::FETCH_ASSOC);


//creating or inserting a new year
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newYear = $_POST['newYear'];


    //check if Year already exists,
    $sql = "SELECT * FROM activeyear WHERE YEAR = '$newYear'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data['YEAR'] == true) {
        $_SESSION['successMessage'] = "Year Already Exists";
        header("Location:admin.page.php?electionYear=" . $electionYear);
        die();
    } else {

        //if not insert new year    
        try {
            $sql = "INSERT INTO activeyear (YEAR) VALUES (:newYear)";
            $stmt1 = $conn->prepare($sql);
            $stmt1->bindParam(":newYear", $newYear);
            $stmt1->execute();

            $query = "INSERT INTO electiontrigger (ELECTION_YEAR) VALUES (:newYear)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':newYear', $newYear);
            $stmt->execute();

            header("Location:admin.page.php?electionYear=" . $electionYear);
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    }
}


//selecting candidates tied to the active year
$electionYear = "";
if (isset($_GET["electionYear"])) {
    $electionYear = $_GET["electionYear"];

    $query = "SELECT * FROM candidates WHERE ELECTION_YEAR = :electionYear";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(":electionYear", $electionYear);
    $stmt->execute();

    $activeelectionYear = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// total number of voters
try {
    $sql = "SELECT COUNT(VOTER_ID) AS total_voters FROM voters WHERE ELECTION_YEAR = '$electionYear'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $totalvoters = $result['total_voters'];
    } else {
        echo "No records found";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// total number of candidates
try {
    $sql = "SELECT COUNT(CAND_CODE) AS total_candidates FROM candidates WHERE ELECTION_YEAR = '$electionYear'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $totalcandidates = $result['total_candidates'];
    } else {
        echo "No records found";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


$query = "SELECT * FROM electiontrigger WHERE ELECTION_YEAR = '$electionYear'";
$stmt1 = $conn->prepare($query);
$stmt1->execute();
$data = $stmt1->fetch(PDO::FETCH_ASSOC);
$status = $data['STATUS'];


$resultSql = "SELECT CAND_CODE, COUNT(ID) AS TOTAL_VOTES FROM election GROUP BY CAND_CODE";
$resultStmt = $conn->prepare($resultSql);
$resultStmt->execute();
$electionResult = $resultStmt->fetchAll(PDO::FETCH_ASSOC);

$_SESSION["electionYear"] = $electionYear;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://fontawesome.com/v4/icon/user">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js">
        </script> -->

    <style>
        body {
            background-repeat: no-repeat;
            background-size: cover;
        }

        img {
            height: 100px;
            width: 100px;
        }


        button {
            padding: 12px 14px;
            margin: 2px 0;
            display: inline-block;
            border: 1px solid black;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: rgb(21, 115, 71);
        }

        table {
            border: 4px solid green;
        }

        hr {
            border: 1px solid black;
        }

        input,
        label {
            width: 70%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .col-md-3 {
            background-color: rgb(241, 241, 241);
            height: 400px;
            box-shadow: 5px -5px 5px;
            border-radius: 10px;
        }

        .voters {
            background-color: rgb(46, 57, 191);
            height: 120px;
            margin-top: 10px;
            border: 1px solid black;
            text-align: center;
            color: white;
            padding: 20px;
            font-size: 16px;
            border-radius: 0px;
        }

        .candidates {
            background-color: rgb(247, 110, 65);
            height: 120px;
            margin-top: 10px;
            border: 1px solid black;
            text-align: center;
            color: white;
            padding: 20px;
            font-size: 16px;
            border-radius: 0px;
            width: 100%;
        }

        .col-lg-3 {
            padding: 20px;
            margin: auto;
        }

        .logout {
            margin-left: 60%;
        }

        a {
            text-decoration: none;
            color: white;
        }
    </style>
    <title>Admin</title>
</head>

<body>
    <header class="header">
        <?php include("../include/header.php"); ?>
    </header>

    <div class="row container-fluid">
        <div class=" col-lg-3 container my-5">
            <h4>YEAR: <?php echo $electionYear ?></h4> <br>

        </div>

        <div class="col-lg-3">
            <button class="btn btn-primary voters">Total number of Registered Voters:<br>
                <?php
                echo $totalvoters;
                ?>
            </button><br>
            <br>
            <a href="report.php"><button class="btn btn-dark text-light px-3">Report</button></a>
            <button class="btn btn-dark text-light px-3" data-bs-toggle="modal" data-bs-target="#activeYear">Active Year</button>
            <!-- active year modal -->
            <div class="modal fade" id="activeYear">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- modal header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Select Active Year</h4>
                            <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <?php
                        ?>

                        <!-- modal body -->
                        <div class="modal-body">
                            <form method="get" action="<?php echo $_SERVER["PHP_SELF"] ?>">
                                <label for="electionYear" class="form-label">
                                    <select name="electionYear" class="form-select" required>
                                        <option selected disabled>Year</option>
                                        <?php
                                        foreach ($activeYear as $row) {
                                            echo "<option>{$row['YEAR']}</option>";
                                        } ?>
                                    </select>
                                </label><br>
                                <button class="btn btn-success">Done</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addYear">+ Add Year</button>
            <!-- add year modal -->
            <div class="modal fade" id="addYear">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- modal header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Add Year</h4>
                            <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- modal body -->
                        <div class="modal-body">
                            <form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>">
                                <input type="number" name="newYear" min="2023" autocomplete=off value="2023" required>
                                <button class="btn btn-success">Save</button>
                            </form>
                            <!-- <button class="btn btn-success" onclick="confirmLogout()">sweet alert</button> -->
                        </div>

                    </div>
                </div>
            </div>

        </div>


        <div class="col-lg-3">
            <button class="btn btn-warning candidates">Total number of Candidates:<br>
                <?php
                echo $totalcandidates;
                ?>
            </button><br><br>


            <?php
            if (!empty($electionYear) && ($status == '0' || $status == '2')) { ?>
                <button class="btn btn-primary" onclick="startElection()" id="startElection">Start Election</button>
            <?php } elseif (!empty($electionYear) && ($status == '1')) { ?>
                <button class="btn btn-info"><i class="fa fa-spinner"></i> Election In Progress</button>
                <button class="btn btn-danger" onclick="endElection()" id="endElection">End Election</button>
            <?php
            } else { ?>
                <button class="btn btn-primary" disabled>Start Election</button>
                <button class="btn btn-danger" disabled>End Election</button>
            <?php } ?>

        </div>
        <div class="col-lg-3">
            <button class="btn btn-dark text-light logout" onclick="confirmLogout()">
                <i class="fa fa-sign-out"></i>
                logout</button>
        </div>

    </div>
    <hr>


    <div class="row container-fluid">
        <div class="col-lg-12 col-md-9 container-fluid">
            <?php
            //display election results in bar chart when election is ongoing
            if (!empty($electionYear) && ($status == '1')) {
                $sql = "SELECT * FROM candidates WHERE ELECTION_YEAR= $electionYear";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $candidates = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $chartData = [];
                foreach ($candidates as $row) {
                    $fullName = $row['FIRST_NAME'] . ' ' . $row['LAST_NAME'];
                    $image = $row['CAND_IMAGE'];
                    $candCode = $row['CAND_CODE'];
                    $position = $row['POSITION'];
                    $votes = 0;
                    foreach ($electionResult as $k => $v) {
                        if ($v['CAND_CODE'] == $candCode) {
                            $votes = $v['TOTAL_VOTES'];
                            break;
                        }
                    }

                    // Store data for JavaScript
                    $chartData[] = [
                        'fullName' => $fullName,
                        'votes' => $votes,
                    ];
                }
                $chartDataJSON = json_encode($chartData);
            ?>
                <canvas id="myChart" style="width:100%;max-width:700px"></canvas>
            <?php
            } else {
            ?>

                <?php
                            //display candidates in table form when election has ended or not started
                if (!empty($electionYear)) { ?>

                    <a href="../candidate/addcandidate.view.php"><button type="submit" class="btn btn-success">
                            +<i class="fa fa-user"></i> Add Candidate</button></a>
                    <a href="../voter/addvoter.view.php"><button type="submit" class="btn btn-success">
                            +<i class="fa fa-user"></i>
                            Add Voter</button></a>
                    <a href="voters.list.php"><button type="submit" class="btn btn-success">
                            <i class="fa fa-list"></i>
                            List of Voters</button></a>
                    <a href="results.php"><button type="submit" class="btn btn-success">Results</button></a>
                <?php } else {
                } ?>
                <br><br>
                <table class="table table-hover container-fluid">

                    <?php

                    ?>
                    <h5>Candidates</h5>
                    <thead>
                        <tr>
                            <th>IMAGE</th>
                            <th>NAME</th>
                            <th>POSITION</th>
                            <th>CANDIDATE CODE</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM candidates WHERE ELECTION_YEAR = $electionYear ORDER BY POSITION ASC";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $candidates = $stmt->fetchAll();

                        if (!empty($electionYear)) {
                            try {
                                foreach ($candidates as $row) {
                                    $fullName = $row['FIRST_NAME'] . ' ' . $row['LAST_NAME'];
                                    $position = $row['POSITION'];
                                    $image = $row['CAND_IMAGE'];
                                    $candCode = $row['CAND_CODE'];
                                    $electionYear = $row['ELECTION_YEAR'];
                        ?>

                                    <tr>

                                        <td> <img src="../uploads/<?php echo $image ?>"></td>
                                        <td><?php echo $fullName; ?></td>
                                        <td><?php echo $position; ?></td>
                                        <td><?php echo $candCode; ?></td>

                                        <?php
                                        ?>
                                        <td>
                                            <button type=button class="btn btn-danger remove" onclick="confirmDelete('<?php echo $candCode ?>','<?php echo $electionYear ?>')">
                                                <i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                            <input type="hidden" name="candCode">
                                            <a href="../candidate/update.candidate.view.php?id=<?php echo $candCode ?>"><button type=submit class="btn btn-primary update" value="<?php echo $candCode; ?>">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                    Edit</button></a>
                                        </td>
                                    </tr>
                    <?php

                                }
                            } catch (PDOException $e) {
                                echo "Connection failed: " . $e->getMessage();
                            }
                        }
                    }
                    ?>
        </div>
        </tbody>
        </table>
    </div>

    </div>

</body>
<script>
        function confirmDelete(candCode, electionYear) {
        Swal.fire({
            title: "Do you want to Delete this Candidate?",
            html: "Note: This action can not be reversed" +
                "<form id='confirmDelete' action='../candidate/delete.candidate.php' method='GET'>" +
                "<input type='hidden' name='electionYear' value='" + electionYear + "'>" +
                "<input type='hidden' name='deleteid' value='" + candCode + "'>" +
                "</form>",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Delete",
            preConfirm: function() {
                document.getElementById('confirmDelete').submit();
            }
        });
    }

    function confirmLogout() {
        Swal.fire({
            title: "Are you sure you want to logout?",
            icon: "warning",
            html: "<form id='adminlogout' action='admin.logout.php' method='POST'>" +
                "</form>",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Logout",
            preConfirm: function() {
                document.getElementById('adminlogout').submit();
            }

        })
    }

    function startElection() {
        Swal.fire({
            title: "Do you want to Start the Election?",
            html: "<form id='startElectionForm' action='startelection.php' method='POST'>" +
                "<input type='hidden' name='electionYear' value='<?php echo $electionYear ?>'>" +
                "</form>",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Start",
            preConfirm: function() {
                document.getElementById('startElectionForm').submit();
            }
        });
    }

    function endElection() {
        Swal.fire({
            title: "Do you want to End the Election?",
            html: "<form id='endElectionForm' action='endelection.php' method='POST'>" +
                "<input type='hidden' name='electionYear' value='<?php echo $electionYear ?>'>" +
                "</form>",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "End",
            preConfirm: function() {
                document.getElementById('endElectionForm').submit();
            }
        });
    }
</script>

<script>
    const chartData = <?php echo $chartDataJSON; ?>;
    const xValues = chartData.map(data => data.fullName);
    const yValues = chartData.map(data => data.votes);
    const barColors = ["green", "blue", "orange", "brown", "yellow", "red", "violet", "black", "gray"];

    new Chart("myChart", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    ticks: {
                        min: 0,
                        max: 10,
                    }
                }],
            }
        }
    });
</script>

</html>