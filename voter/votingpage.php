<?php
require "../config.php";

if (isset($_SESSION["voterId"])) {
    $voterId = $_SESSION["voterId"];
    $electionYear = $_SESSION["electionYear"];
} else {
    header("Location:login.view.php");
    die();
}

$stmt = $conn->prepare("SELECT COUNT(ID) AS VOTE_COUNT FROM election WHERE VOTER_ID =:voterId");
$stmt->bindParam(":voterId", $voterId);
$status = $stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

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
            /* background-color:rgb(71, 172, 156); */
            background-repeat: no-repeat;
            background-size: cover;
        }

        h5 {
            font-family: Arial, Helvetica, sans-serif;
        }

        img {
            height: 100px;
            width: 100px;
            margin: 10px;
            align-items: center;
        }

        h2 {
            font-family: cursive;
        }

        header {
            background-color: rgb(0, 185, 36);
            height: 60px;
        }

        h4 {
            text-align: center;
            justify-content: center;
        }

        input[type='radio'] {
            accent-color: green;
            width: 25px;
            height: 25px;
        }

        .vote {
            border: 1px solid black;
            padding: 20px;
            margin: auto;
            width: 65%;
            background-color: white;
        }

        .submit {
            align-items: center;
            justify-content: center;
            width: 240px;
            margin: auto;
            padding: 10px;
            margin-left: 45%;

        }
    </style>

    </style>
    <title>votepage</title>

</head>


<body>
    <header class="header text-dark text-center px-3">
        <h2>VOTING SYSTEM</h2>
    </header>

    <div class="container my-5">
        <a href="dashboard.php"><button class="btn btn-dark text-light px-3">Return to dashboard</button></a>

        <a href="votingpage.php"><button class="btn btn-dark px-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                    <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
                </svg>
                Reset</button>
        </a>

    </div>

    <h4 class="container-fluid text-dark">Election <?php echo $electionYear ?>
    </h4>
    <hr>
    <?php
    if ($data['VOTE_COUNT'] >= 3) {
        echo "You have Voted";
        header("Location:dashboard.php");
    } else {
    ?>
        <form id="myForm" method="post" action="../updatevote.php">

            <div class="vote">
                <h4>PRESIDENT</h4><br>
                <i class="text-success">Select your preferred Candidate</i>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <h5>Image</h5>
                    </div>
                    <div class="col-md-4">
                        <h5>Name</h5>
                    </div>
                    <div class="col-md-4">
                        <h5>Actions</h5>
                    </div>
                </div>
                <hr>

                <?php
                // President

                $sql = "SELECT * FROM candidates WHERE POSITION='President' AND ELECTION_YEAR= '$electionYear' ";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($result) {
                    foreach ($result as $row) {
                        $fullName = $row['FIRST_NAME'] . ' ' . $row['LAST_NAME'];
                        $position = $row['POSITION'];
                        $image = $row['CAND_IMAGE'];
                        $candCode = $row['CAND_CODE'];
                ?>

                        <div class="row">
                            <div class="col-md-4">
                                <img src="../uploads/<?php echo $image ?> " alt="img"><br><br>

                            </div>

                            <div class="col-md-4">
                                <!-- info -->
                                <?php echo $fullName . '<br>' . $candCode ?>

                            </div>


                            <div class="col-md-4">
                                <input type="radio" id="submit" name="vote1" value="<?php echo $candCode ?>" required><br>
                            </div>
                            <br>
                            <br>
                        </div>
                        <hr>
                <?php
                    }
                } else {
                    echo "No Records Available";
                }
                ?>

            </div>
            <br>

            <div class="vote">
                <h4>VICE PRESIDENT</h4><br>
                <i class="text-success">Select your preferred Candidate</i>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <h5>Image</h5>
                    </div>
                    <div class="col-md-4">
                        <h5>Name</h5>
                    </div>
                    <div class="col-md-4">
                        <h5>Actions</h5>
                    </div>
                </div>
                <hr>

                <?php
                // Vice President

                $sql = "SELECT * FROM candidates WHERE POSITION='Vice President' AND ELECTION_YEAR= '$electionYear' ";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($result) {
                    foreach ($result as $row) {
                        $fullName = $row['FIRST_NAME'] . ' ' . $row['LAST_NAME'];
                        $position = $row['POSITION'];
                        $image = $row['CAND_IMAGE'];
                        $candCode = $row['CAND_CODE'];
                ?>

                        <div class="row">
                            <div class="col-md-4">
                                <img src="../uploads/<?php echo $image ?> " alt="img"><br><br>

                            </div>

                            <div class="col-md-4">
                                <!-- info -->
                                <?php echo $fullName . '<br>' . $candCode ?>

                            </div>



                            <div class="col-md-4">
                                <input type="radio" id="submit" name="vote2" value="<?php echo $candCode ?>" style="height:100px; width=100px;" required><br>
                                <input type=hidden name="candCode2" value="<?php echo $candCode ?>">
                            </div>
                            <br>
                            <br>
                        </div>
                        <hr>
                <?php
                    }
                } else {
                    echo "No Records Available";
                }
                ?>

            </div>
            <br>

            <div class="vote">
                <h4>SECRETARY</h4><br>
                <i class="text-success">Select your preferred Candidate</i>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <h5>Image</h5>
                    </div>
                    <div class="col-md-4">
                        <h5>Name</h5>
                    </div>
                    <div class="col-md-4">
                        <h5>Actions</h5>
                    </div>
                </div>
                <hr>

                <?php
                // Secretary

                $sql = "SELECT * FROM candidates WHERE POSITION='Secretary'  AND ELECTION_YEAR= '$electionYear'";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($result) {
                    foreach ($result as $row) {
                        $fullName = $row['FIRST_NAME'] . ' ' . $row['LAST_NAME'];
                        $position = $row['POSITION'];
                        $image = $row['CAND_IMAGE'];
                        $candCode = $row['CAND_CODE'];
                ?>

                        <div class="row">
                            <div class="col-md-4">
                                <img src="../uploads/<?php echo $image ?> " alt="img"><br><br>

                            </div>

                            <div class="col-md-4">
                                <!-- info -->
                                <?php echo $fullName . '<br>' . $candCode ?>

                            </div>



                            <div class="col-md-4">
                                <input type="radio" id="submit" name="vote3" value="<?php echo $candCode ?>" style="height:100px; width=100px;" required><br>
                                <input type=hidden name="candCode3" value="<?php echo $candCode ?>">
                            </div>
                            <br>
                            <br>
                        </div>
                        <hr>
                <?php
                    }
                } else {
                    echo "No Records Available";
                }
                ?>

            </div>
            <br>
            <a><button class="btn btn-success text-light px-3 btn-center submit" onclick="return showConfirmation()">Submit Ballot</button></a>
        </form>
    <?php } ?>


</body>
<script>
    function showConfirmation() {
        if (confirm("Submit Vote?")) {
            // If the user clicks "OK", submit the form
            document.getElementById("myForm").submit();
        } else {
            // If the user clicks "Cancel", do nothing
        }
        return false;

    }

    function confirmVote() {
        Swal.fire({
        position: "top",
        title: "Do you want to End the Election?",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "End",
        preConfirm: function() {
            document.getElementById('myForm').submit();
        }
    });
}

</script>

</html>