<?php
include "../config.php";
if (isset($_SESSION["electionYear"]));
$electionYear = $_SESSION["electionYear"];
$search = $_GET["search"];

// var_dump($gender);die;


//count total number of voters
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


//count total number of voters who have voted
try {
    $sql = "SELECT COUNT(VOTER_ID) AS total_voted FROM voters WHERE STATUS='1' AND ELECTION_YEAR = '$electionYear'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();


    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $totalvoted = $result['total_voted'];
    } else {
        echo "No records found";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


if (isset($_SESSION["successMessage"])) {
    echo "<script>alert('" . $_SESSION["successMessage"] . "')</script>";
    unset($_SESSION["successMessage"]);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-color: rgb(241, 241, 241);
        }

        img {
            height: 100px;
            width: 100px;
        }

        button {
            padding: 6px 10px;
            margin: 2px 0;
            display: inline-block;
            border: 1px solid black;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: #4CAF50;

        }

        a {
            color: black;
        }

        .col-md-8 {
            text-decoration: none;
        }

        table {
            border: 2px solid black;
            padding: 20px;
            margin: auto;
            width: 60%;
            background-color: white;
        }

        hr {
            border: 1px solid black;
        }

        h3 {
            text-align: center;
        }

        input {
            width: 35%;
            padding: 8px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .voted {
            height: 120px;
            margin-top: 10px;
            width: 65%;
            text-align: center;
            color: black;
            padding: 20px;
            font-size: 20px;
        }

        .total {
            height: 120px;
            margin-top: 10px;
            width: 65%;
            text-align: center;
            color: black;
            padding: 20px;
            font-size: 20px;
        }

        form {
            margin-left: 30%;
        }
    </style>
    <title>voters list</title>
</head>

<body>
    <div class="row container-fluid">
        <div class="container-fluid col-md-4 my-5">
            <button class="btn btn-dark text-light px-3" onclick="goBack()">
                <i class="fa fa-arrow-left"></i> Back</button>

            <a href="voters.list.php"><button class="btn btn-dark px-4">
                    <i class="fa fa-refresh"></i> Reset</button></a>
        </div>
        <div class="col-md-4 container-fluid ">
            <button class="btn btn-info total">Total number of Registered Voters:<br>
                <?php echo $totalvoters ?>
            </button>
        </div>


        <div class="col-md-4 container-fluid">
            <button class="btn btn-secondary voted">Voted :<br>
                <?php echo $totalvoted ?>
            </button>
        </div>
    </div>

    <div class="container-fluid search">
        <form method="get" action="<?php echo $_SERVER["PHP_SELF"] ?>">
            <input type="search" name="search" placeholder="Search" autocomplete="off" required>
            <button type="submit" class="btn btn-success">Search</button>
        </form>
    </div>
    <hr>
    <div class="container-fluid my-5">
    </div>
    <div class="row container-fluid">
        <div class=" px-5">
        </div>

        <div class="container-fluid">

            <table class="table table-hover container-fluid">
                <h3>Voters Register</h3>
                <thead>
                    <tr>
                        <th>IMAGE</th>
                        <th>NAME</th>
                        <th>GENDER</th>
                        <th>VOTER'S ID</th>
                        <th>STATUS</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($search)) {
                        $query = "SELECT * FROM voters WHERE FIRST_NAME LIKE :search OR LAST_NAME LIKE :search OR GENDER  LIKE :search OR VOTER_ID LIKE :search";
                        $stmt = $conn->prepare($query);
                        $stmt->bindParam(":search", $search);
                        $stmt->execute();

                        if ($stmt->rowCount() > 0) {

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $fullName = $row['FIRST_NAME'] . ' ' . $row['LAST_NAME'];
                                $gender = $row['GENDER'];
                                $image = $row['VOTER_IMAGE'];
                                $voterId = $row['VOTER_ID'];
                                $status = $row['STATUS'];
                    ?>
                                <tr>
                                    <td> <img src="../uploads/<?php echo $image ?>"></td>
                                    <td><?php echo $fullName ?></td>
                                    <td><?php echo $gender ?></td>
                                    <td><?php echo $voterId ?></td>
                                    <td><?php switch ($status) {
                                            case '1':
                                                echo 'Voted';
                                                break;

                                            default:
                                                echo 'Not Voted';
                                                break;
                                        } ?></td>
                                    <td>
                                        <button type=button class="btn btn-danger remove" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $voterId ?>">
                                            <i class="fa fa-trash"></i> Delete</button>
                                        <input type="hidden" name="voterId">
                                        <a href="../voter/updatevoter.view.php?id=<?php echo $voterId ?>"><button type=submit class="btn btn-primary update" value="<?php echo $voterId; ?>">
                                                <i class="fa fa-pencil-square-o"></i> Edit</button></a>
                                    </td>
                                </tr>
                                <!-- confirm delete modal -->
                                <div class="modal" id="deleteModal<?php echo $voterId ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <!-- modal header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirm Delete</h4>
                                                <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>

                                            </div>

                                            <!-- modal body -->
                                            <div class="modal-body">
                                                <a href="../voter/delete.voter.php?deleteid=<?php echo $voterId ?>"><button class="btn btn-danger">Delete</button></a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }

                        ?>
                        <?php
                    } else {


                        try {
                            $sql = "SELECT * FROM voters WHERE ELECTION_YEAR = '$electionYear' ORDER BY FIRST_NAME ASC";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();

                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $fullName = $row['FIRST_NAME'] . ' ' . $row['LAST_NAME'];
                                    $gender = $row['GENDER'];
                                    $image = $row['VOTER_IMAGE'];
                                    $voterId = $row['VOTER_ID'];
                                    $status = $row['STATUS'];
                        ?>
                                    <tr>
                                        <td> <img src="../uploads/<?php echo $image ?>"></td>
                                        <td><?php echo $fullName ?></td>
                                        <td><?php echo $gender ?></td>
                                        <td><?php echo $voterId ?></td>
                                        <td><?php switch ($status) {
                                                case '1':
                                                    echo 'Voted';
                                                    break;
                                                default:
                                                    echo 'Not Voted';
                                                    break;
                                            } ?></td>
                                        <td>
                                            <button type=button class="btn btn-danger remove" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $voterId ?>">
                                                <i class="fa fa-trash"></i> Delete</button>
                                            <input type="hidden" name="voterId">
                                            <a href="../voter/updatevoter.view.php?id=<?php echo $voterId ?>"><button type=submit class="btn btn-primary update" value="<?php echo $voterId; ?>">
                                                    <i class="fa fa-pencil-square-o"></i> Edit</button></a>
                                        </td>
                                    </tr>
                                    <!-- confirm delete modal -->
                                    <tr>
                                        <td>
                                            <div class="modal" id="deleteModal<?php echo $voterId ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <!-- modal header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Confirm Delete</h4>
                                                            <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>

                                                        </div>

                                                        <!-- modal body -->
                                                        <div class="modal-body">
                                                            <a href="../voter/delete.voter.php?deleteid=<?php echo $voterId ?>"><button class="btn btn-danger">Delete</button></a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </td>

                                    </tr>


                    <?php
                                }
                            } else {
                                echo "No Records found.";
                            }
                        } catch (PDOException $e) {
                            echo "Connection failed: " . $e->getMessage();
                        }
                    }
                    ?>
                </tbody>

            </table>

        </div>

    </div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>