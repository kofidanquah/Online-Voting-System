<?php
include "../config.php";
if (isset($_SESSION["username"])) {
    $name = $_SESSION["username"];
} else {
    header("Location:admin.login.php");
    die();
}

if (isset($_SESSION["electionYear"])){
    $selectedYear = $_SESSION["electionYear"];
}

$electionYear = "electionYear";

$sql = "SELECT CAND_CODE, COUNT(ID) AS TOTAL_VOTES FROM election WHERE ELECTION_YEAR=:electionYear GROUP BY CAND_CODE";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":electionYear", $electionYear);
$stmt->execute();
$electionResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

// echo "<pre>";
// print_r($electionResult); 
// exit;


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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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

    </style>
    <title>Report</title>
</head>

<body>
    <header class="header text-dark text-center px-3 sticky-top">
        <h4>REPORT</h4>
    </header>
    
    <br>
    <div class="px-5">
        <a href="admin.page.php?electionYear=<?php echo $selectedYear ?>">
        <button class="btn btn-dark px-4" >
            <i class="fa fa-arrow-left"></i>
            Back</button></a>

        <a href="report.php"><button class="btn btn-dark px-4">
        <i class="fa fa-refresh"></i>
                Reset</button>
        </a>
    </div>
    <br><br>

    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="get">
        <label for="electionYear" class="form-label">
            <select name="electionYear" class="px-5 form-select" required>
                <option selected disabled>Year</option>
                <?php
                foreach ($activeYear as $row) {
                    echo "<option>{$row['YEAR']}</option>";
                } ?>

            </select>
        </label>
        <button class="btn btn-success submit">Generate</button>
        </div>
        <br>

    </form>
    <hr>
    <br>
    <div class="px-5">
        <?php
        if (!empty($electionYear)) {
        ?>
            <button class="btn btn-primary px-3" onclick="window.print()">Print</button>
        <?php } else {
        } ?>
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
                if (!empty($electionYear)) {
                    try {
                        $sql = "SELECT * FROM candidates WHERE ELECTION_YEAR= '$electionYear'";
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

</script>

</html>