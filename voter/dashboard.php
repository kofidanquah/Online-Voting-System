<?php
require "../config.php";
if (isset($_SESSION["voterId"])) {
    $voterId = $_SESSION["voterId"];
    $firstname = $_SESSION["firstname"];
    $lastname = $_SESSION["lastname"];
    $status = $_SESSION["voteStatus"];
    $gender = $_SESSION["gender"];
    $image = $_SESSION["image"];
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

    <style>
        body {
            background-color: rgb(255, 210, 98);
            background-repeat: no-repeat;
            background-size: cover;
            width: auto;
        }

        h5 {
            font-family: Arial, Helvetica, sans-serif;
        }

        img {
            height: 120px;
            width: 120px;
            border: 2px solid black;
        }

        h2 {
            font-family: cursive;
            color: white;
        }

        header {
            background-color: rgb(54, 56, 63);
            height: 60px;
            width: 110%;
        }

        h4 {
            text-align: center;
            justify-content: center;
            font-family: cursive;
        }

        .col-md-5 {
            background-color: rgb(241, 241, 241);
            height: 400px;
            box-shadow: -10px 10px 10px;
            border: 2px solid black;
            padding: 20px;
            margin: auto;
            width: 60%;
            border-radius: 10px;
        }

        .vote {
            height: 60px;
            width: 50%;
        }

        h3 {
            font-size: 30px;
            font-family: "Helvetica";
        }

        p {
            font-size: 22px;
        }

        .button:hover {
            color: gray;
        }

        input {
            width: 70%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>

    <title>dashboard</title>

</head>


<body>
    <header class="header text-dark text-center px-3">
        <h2>VOTING SYSTEM</h2>
    </header>
    <h3><i>WELCOME, <?php echo $firstname . " " . $lastname; ?></i></h3>

    <div class="row">
        <div class="col-md-4 container my-5">
            <a href="login.view.php"><button class="btn btn-dark text-light px-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z" />
                        <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z" />
                    </svg>
                    Log out</button></a>

            <a href="../logout.php"><button class="btn btn-dark text-light px-3"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                        <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z" />
                    </svg>
                    Home
                </button></a>

        </div>

        <div class="col-md-4">
        </div>

        <div class="col-md-4 my-5 container-fluid">
            <?php
            if ($data['VOTE_COUNT'] < 3) { ?>
                <a><button class="btn btn-success text-light px-3  vote" data-bs-toggle="modal" data-bs-target="#electionCode"> Vote now</button></a>
                <!-- confirm election modal -->
                <tr>
                    <td>
                        <div class="modal fade" id="electionCode">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <!-- modal header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Start Voting</h4>
                                        <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- modal body -->
                                    <div class="modal-body">
                                        <form method="post" action="confirmcode.php">
                                            <input type="text" name="electionCode" placeholder="Enter Election Code" autocomplete="off" required><br>
                                            <a href="startelection.php"><button class="btn btn-success">Vote</button></a>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </td>

                </tr>
            <?php }else{
                echo "You have voted";
            }
            ?>
            <br><br>
            <?php
            if ($data['VOTE_COUNT'] >= 3) { ?>
                <a href="../admin/results.php"><button class="btn btn-success text-light px-3  vote">Published Results</button></a>
            <?php }
            ?>
        </div>
    </div>

    <h4 class="container-fluid text-dark">Dashboard</h4>
    <hr><br>

    <div class="col-md-5">
        <!--voter-->
        <h5>MY PROFILE</h5>
        <?php echo '<img src="../uploads/' . $image . '" >' ?>
        <br><br>

        <div class="row">
            <div class="col-sm-6">
                <p>
                    NAME: <?php echo $firstname . " " . $lastname; ?>
                    <br><br>
                    VOTER ID: <?php echo $voterId; ?>
                    <br><br>
                </p>
            </div>

            <div class="col-sm-6">
                <p>
                    STATUS: <?php
                            if ($data['VOTE_COUNT'] >= 3) {
                                echo "Voted";
                            } else {
                                echo "Not Voted";
                            }
                            ?>
                    <br><br>
                    GENDER: <?php echo $gender; ?>
                </p>
            </div>

        </div>
    </div>
    </body>

</html>