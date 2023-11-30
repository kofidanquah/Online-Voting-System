<?php
include "../config.php";

$start = isset($_GET["start"]) ? date('Y-m-d', strtotime($_GET["start"])) : "";
$end = isset($_GET["end"]) ? date('Y-m-d', strtotime($_GET["end"])) : "";
$electionYear = $_GET["electionYear"];
if (!empty($start)  && !empty($end)) {

    $sql = "SELECT CAND_CODE, COUNT(ID) AS TOTAL_VOTES FROM election WHERE ELECTION_YEAR=:electionYear AND ELECTION_DATE BETWEEN :start AND :end   GROUP BY CAND_CODE";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":start", $start);
    $stmt->bindParam(":end", $end);
    $stmt->bindParam(":electionYear", $electionYear);


    $stmt->execute();

    $electionResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // echo "<pre>";
    // print_r($electionResult); 
    // exit;
}

$query2 = "SELECT * FROM activeyear ORDER BY YEAR ASC";
$stmt2 = $conn->prepare($query2);
$stmt2->execute();
$activeYear = $stmt2->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
    </script>

    <style>
        body {
            width: auto;
        }

        img {
            height: 100px;
            width: 100px;
        }

        .date {
            width: 60%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            align-items: center;
            justify-content: center;
        }

        input {
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            align-items: center;
            justify-content: center;

        }

        table {
            width: max-content;
        }

        td,
        th {
            border: 1px solid black;
            text-align: center;
        }

        header {
            background-color: rgb(21, 115, 71);
            height: 60px;
            width: 100%;
        }

        h4 {
            font-size: 40px;
        }

        h3 {
            text-align: center;
        }
        label {
            width: 18%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn-success {
            margin-left: 70%;
        }
    </style>
    <title>Report</title>
</head>

<body>
    <header class="header text-dark text-center px-3 sticky-top">
        <h4>REPORT</h4>
    </header>
    <br>
    <div class="px-5">
        <button class="btn btn-dark px-4" onclick="goBack()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
                </svg>
                Back</button>

        <a href="report.php"><button class="btn btn-dark px-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                    <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
                </svg>
                Reset</button>
        </a>
    </div>
    <br><br>

    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="get">
        <div class="row container-fluid">
            <div class="col-md-6 px-5">
                Start Date<br>
                <input type="date" name="start" class="date" required>
            </div>

            <div class="col-md-6">
                End Date<br>
                <input type="date" name="end" class="date" required>
            </div>
        </div>
        <br>
        <div>
            <label for="electionYear" class="form-label">
                <select name="electionYear" class="px-5 form-select" required>
                    <option selected disabled>Year</option>
                    <?php
                                        foreach ($activeYear as $row) {
                                            echo "<option>{$row['YEAR']}</option>";
                                        } ?>

                </select>
            </label><br>

            <!-- <input class="px-5" name="electionYear" type="text" placeholder="Election Year" required> -->
            <button class="btn btn-success submit">Generate</button>
        </div>
        <br>

    </form>
    <hr>
    <br>
    <div class="px-5">
        <button class="btn btn-primary px-3" onclick="window.print()">Print</button>
    </div>
    <h3>ELECTION <?php echo $electionYear ?></h3>
    <br><br>
    <div class="container">
        <table class="table table-striped table">
            <thead>
                <tr>
                    <th>IMAGE</th>
                    <th>NAME</th>
                    <th>POSITION</th>
                    <th>VOTES</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if (!empty($start)) {
                    try {
                        $sql = "SELECT * FROM candidates WHERE ELECTION_YEAR= $electionYear";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $candidates = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        //collect data for javascript
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

                ?>
                            <tr>
                                <td> <img src="../uploads/<?php echo $image ?>"></td>
                                <td><?php echo $fullName ?></td>
                                <td><?php echo $position ?></td>
                                <td><?php echo $votes ?></td>
                            </tr>
                <?php }
                    } catch (PDOException $e) {
                        echo "Connection failed: " . $e->getMessage();
                    }
                } else {
                    echo "Records not Available, Set Date Range to display report";
                }

                // Convert PHP array to JSON for JavaScript
                $chartDataJSON = json_encode($chartData);
                ?>
                <canvas id="myChart" style="width:100%;max-width:700px"></canvas>

            </tbody>
        </table>
    </div>

</body>
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
                        max: 10
                    }
                }],
            }
        }
    });

        function goBack() {
            window.history.back();
        }

</script>

</html>