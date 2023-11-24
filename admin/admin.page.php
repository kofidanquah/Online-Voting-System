<?php
include "../config.php";

// Retrieve the message from the URL
$message = isset($_GET['message']) ? urldecode($_GET['message']) : '';
// Display the message
if (!empty($message)) {
    echo '<p>' . $message . '</p>';
}
unset($_GET['message']);


// login details
if (isset($_SESSION["username"])) {
    $name = $_SESSION["username"];
} else {
    header("Location:admin.login.php");
    die();
}


$sql = "SELECT * FROM electiontrigger";
$stmt = $conn->prepare($sql);
$result = $stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($data) {
    $start = $data['START_DATE'];
    $end = $data['END_DATE'];
    $status = $data['STATUS'];
}

try {
    $sql = "SELECT COUNT(VOTER_ID) AS total_voters FROM voters";
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

try {
    $sql = "SELECT COUNT(CAND_CODE) AS total_candidates FROM candidates";
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
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            border: 2px solid black;
            text-align: center;
            color: white;
            padding: 20px;
            font-size: 16px;
            border-radius: 10px;
        }

        .candidates {
            background-color: rgb(247, 110, 65);
            height: 120px;
            margin-top: 10px;
            border: 2px solid black;
            text-align: center;
            color: white;
            padding: 20px;
            font-size: 16px;
            border-radius: 10px;
        }

        .col-lg-3 {
            padding: 20px;
            margin: auto;
        }

        .logout {
            margin-left: 60%;
        }
    </style>
    <title>Admin</title>
</head>

<body>
    <div class="row container-fluid">
        <div class=" col-lg-3 container my-5">

        </div>

        <div class="col-lg-3">
            <p class="voters">Total number of Registered Voters:<br>
                <?php
                echo $totalvoters;
                ?>
            </p>
            <br>
            <a href="../index.php"><button class="btn btn-dark text-light ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                        <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z" />
                    </svg>
                    Home</button></a>
            <a href="report.php"><button class="btn btn-dark text-light px-3">Report</button></a>
            <a><button class="btn btn-dark text-light px-3" data-bs-toggle="modal" data-bs-target="#activeYear">Active Year</button></a>
            <!-- active year modal -->
            <tr>
                <td>
                    <div class="modal fade" id="activeYear">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- modal header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Select Active Year</h4>
                                    <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- modal body -->
                                <div class="modal-body">
                                    <form method="post" action="">
                                        <label for="year" class="form-label">
                                            <select name="year" class="form-select" required>
                                                <option selected disabled>Year</option>
                                                <option>2020</option>
                                                <option>2021</option>
                                                <option>2022</option>
                                                <option>2023</option>
                                            </select>
                                        </label><br>
                                        <a href=""><button class="btn btn-success">Next</button></a>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                </td>

            </tr>
        </div>


        <div class="col-lg-3">
            <p class="candidates">Total number of Candidates:<br>
                <?php echo $totalcandidates; ?>
            </p>
            <br>



            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#startModal">Start Election</button>
            <!-- start election modal -->
            <tr>
                <td>
                    <div class="modal fade" id="startModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- modal header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Start Election</h4>
                                    <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- modal body -->
                                <div class="modal-body">
                                    <form method="post" action="startelection.php">
                                        <input type="text" name="electionCode" placeholder="Enter Election Code" autocomplete="off" required><br>
                                        <a><button class="btn btn-success">Start</button></a>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                </td>

            </tr>

            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#endModal">End Election</button>
            <!-- end election modal -->
            <tr>
                <td>
                    <div class="modal fade" id="endModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- modal header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">End Election</h4>
                                    <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- modal body -->
                                <div class="modal-body">
                                    <form method="post" action="endelection.php">
                                        <input type="text" name="electionCode" placeholder="Enter Election Code" autocomplete="off" required><br>
                                        <button type="submit" class="btn btn-danger">End</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                </td>

            </tr>
        </div>

        <div class="col-lg-3">
            <a href="admin.login.php"><button class="btn btn-dark text-light logout">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z" />
                        <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z" />
                    </svg>
                    logout</button></a>

        </div>


    </div>
    <hr>

    <div class="row container-fluid">
        <div class="col-md-3 px-5">
            <!-- admin -->
            <h4><b>Administrator</b></h4>
            <hr>

            <img src="../images/person.webp" alt="admin image"><br>
            <b>
                Name: <?php echo $name; ?>
            </b>
            <br><br>
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#setModal">Set Election</button>
            <!-- set election modal -->
            <tr>
                <td>
                    <div class="modal fade" id="setModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- modal header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Set Election</h4>
                                    <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- modal body -->
                                <div class="modal-body">
                                    <form method="post" action="setelection.php">
                                        <input type="text" name="electionCode" placeholder="Enter Election Code" autocomplete="off" required><br>
                                        <a><button class="btn btn-success">Set</button></a>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                </td>

            </tr>

        </div>

        <div class="col-md-9">
            <a href="../candidate/addcandidate.view.php"><button type="submit" class="btn btn-success">+ Add Candidate</button></a>
            <a href="../voter/addvoter.view.php"><button type="submit" class="btn btn-success">+ Add Voter</button></a>
            <a href="voters.list.php"><button type="submit" class="btn btn-success">List of Voters</button></a>
            <a href="results.php"><button type="submit" class="btn btn-success">Results</button></a>

            <br><br>

            <table class="table table-hover container-fluid">
                <h5>Candidates</h5>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Candidate Code</th>
                        <th>Election Code</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    try {
                        $sql = "SELECT * FROM candidates ORDER BY POSITION ASC";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();

                        if ($stmt->rowCount() > 0) {

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $fullName = $row['FIRST_NAME'] . ' ' . $row['LAST_NAME'];
                                $position = $row['POSITION'];
                                $image = $row['CAND_IMAGE'];
                                $candCode = $row['CAND_CODE'];
                                $electionCode = $row['ELECTION_CODE'];

                    ?>
                                <tr>
                                    <td> <img src="../uploads/<?php echo $image ?>"></td>
                                    <td><?php echo $fullName; ?></td>
                                    <td><?php echo $position; ?></td>
                                    <td><?php echo $candCode; ?></td>
                                    <td><?php echo $electionCode; ?></td>

                                    <td>

                                        <button type=button class="btn btn-danger remove" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $candCode ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                            </svg> Delete</button>
                                        <input type="hidden" name="candCode">
                                        <a href="../candidate/update.candidate.view.php?id=<?php echo $candCode ?>"><button type=submit class="btn btn-primary update" value="<?php echo $candCode; ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                </svg>
                                                Edit</button></a>
                                    </td>
                                </tr>
                                <!-- confirm delete modal -->
                                <tr>
                                    <td>
                                        <div class="modal fade" id="deleteModal<?php echo $candCode ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <!-- modal header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Confirm Delete</h4>
                                                        <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- modal body -->
                                                    <div class="modal-body">
                                                        <a href="../delete.candidate.php?deleteid=<?php echo $candCode; ?>"><button class="btn btn-danger" onclick="confirmDelete()">Delete</button></a>



                                                    </div>
                                                </div>
                                            </div>

                                    </td>

                                </tr>
                    <?php }
                        } else {

                            echo "<h3>No records Available</h3>";
                        }
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
    function confirmDelete() {

        Swal.fire({
            position: "top",
            icon: "success",
            title: "Record deleted successfully",
            showConfirmButton: true,
            timer: 30000
        })
    }

</script>


</html>