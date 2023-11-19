<?php
include "../config.php";

$start = isset($_GET["start"]) ? date('Y-m-d', strtotime($_GET["start"])) : "";
$end = isset($_GET["end"]) ? date('Y-m-d', strtotime($_GET["end"])) : "";
if (!empty($start) && !empty($end)) {

    $sql = "SELECT * FROM election WHERE ELECTION_DATE BETWEEN :start AND :end";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":start", $start);
    $stmt->bindParam(":end", $end);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // echo "<pre>";
    // print_r($result);
    // exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            width: auto;
        }
        img {
            height: 100px;
            width: 100px;
        }

        input {
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
            text-align: center;
            justify-content: center;
            font-size: 40px;
        }

        .btn-success {
            margin-left: 70%;
        }
    </style>
    <title>Report</title>
</head>

<body>
    <header class="header text-dark text-center px-3">
        <h4>REPORT</h4>
    </header>
    <br>
    <div class="px-5">
        <a href="admin.page.php"><button class="btn btn-dark px-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
                </svg>
                Back</button></a>
    </div>
    <br><br>

    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="get">
        <div class="row">
            <div class="col-md-6 px-5">
                Start Date<br>
                <input type="date" name="start">
            </div>

            <div class="col-md-6">
                End Date<br>
                <input type="date" name="end">
            </div>
        </div>
        <br>
        <a href=""><button class="btn btn-success">Generate</button></a>
        <br>

    </form>
    <hr><br>
    <br>

    <div class="container">
        <table class="table table-striped table">
            <thead>
                <tr>
                    <th>IMAGE</th>
                    <th>NAME</th>
                    <th>POSITION</th>
                    <th>CANDIDATE CODE</th>
                    <th>VOTES</th>
                </tr>
            </thead>

            <tbody>
                <?php
    
        $sql = "SELECT * FROM candidates";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $fullName=$row['FIRST_NAME'] .' '. $row['LAST_NAME'];
            $image=$row['CAND_IMAGE'];            
            $candCode=$row['CAND_CODE'];
            $position=$row['POSITION'];

            foreach ($result as $k => $v) {
                if ($v['CAND_CODE'] == $candCode) {
                    $votes = $v['ELECTION_DATE'];
                    break;
            }  
        } 
    }
            ?>

            <tr>
            <th> <img src="../uploads/<?php echo $image ?>"></th>
            <th><?php echo $fullName ?></th>
            <th><?php echo $position ?></th>
            <th><?php echo $candCode ?></th>
            <th><?php echo $votes ?></th>
            </th>
            </tr>
        <?php 
    
?>
            </tbody>
        </table>
    </div>

</body>

</html>