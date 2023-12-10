<?php
require "../config.php";

if (isset($_SESSION["voterId"])) {
    $voterId = $_SESSION["voterId"];
    $firstname = $_SESSION["firstname"];
    $lastname = $_SESSION["lastname"];
    $status = $_SESSION["voteStatus"];
    $gender = $_SESSION["gender"];
    $image = $_SESSION["image"];
    $electionYear = $_SESSION["electionYear"];
} else {
    header("Location:login.view.php");
    die();
}

$sql = "SELECT * FROM electiontrigger WHERE ELECTION_YEAR = '$electionYear'";
$stmt1 = $conn->prepare($sql);
$result = $stmt1->execute();
$trigger = $stmt1->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT COUNT(ID) AS VOTE_COUNT FROM election WHERE VOTER_ID =:voterId");
$stmt->bindParam(":voterId", $voterId);
$status = $stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_SESSION["Message"])) {
    echo "<script>alert('" . $_SESSION["Message"] . "')</script>";
    unset($_SESSION["Message"]);
}

    $url1=$_SERVER['REQUEST_URI'];
    header("Refresh: 5; URL=$url1");
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

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

        .btn-success {
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
        a{
            text-decoration: none;
            color: white;
        }

    </style>

    <title>dashboard</title>

</head>

<body>
    <header class="header text-dark text-center px-3 container-fluid">
        <h2>VOTING SYSTEM</h2>
    </header>
    <h3>
        <p id="demo"></p> &nbsp; <?php echo $firstname . " " . $lastname; ?>
    </h3>

    <div class="row container-fluid">
        <div class="col-md-4 container my-5">
            <button class="btn btn-dark text-light px-3" onclick="confirmLogout()">
            <i class="fa fa-sign-out"></i>
                    Log out</button>

            <a href="../index.php"><button class="btn btn-dark text-light px-3">
            <i class="fa fa-home"></i>
                    Home
                </button></a>
        </div>

        <div class="col-md-4">
        </div>

        <div class="col-md-4 my-5" id="voteDiv">
            <?php
            if ($trigger['STATUS'] == 0) {
                echo "<h3>Election not Started</h3>";
            } elseif ($trigger['STATUS'] == 2) {
                echo "<h3>Election Ended</h3>";
            ?>
                <a href="../admin/results.php"><button class="btn btn-success text-light px-3">Results</button></a>
                <?php
            } else {
                if ($data['VOTE_COUNT'] < 3) { ?>
                    <a href="votingpage.php"><button class="btn btn-success text-light px-3"> Vote now</button></a>
            <?php } else {
                    echo "<h3>You have voted</h3>";
                }
            }

            ?>
        </div>
    </div>

    <h4 class="container-fluid text-dark">Dashboard</h4>
    <hr><br>

    <div class="col-md-5">
        <!--voter-->
        <h5>PROFILE</h5>
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
    <?php
    // Retrieve the message from the session
    $message = isset($_SESSION['successMessage']) ? $_SESSION['successMessage'] : '';

    // Display the message
    if (!empty($message)) {
        echo '<p>' . $message . '</p>';

        // Clear the session variable to prevent displaying the message on subsequent reloads
        unset($_SESSION['successMessage']);
    }
    ?>
</body>

<script>
    function confirmLogout() {
    Swal.fire({
        position: "top-start",
        title: "Are you sure you want to logout?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "<a href='logout.php'>Logout</a>"
    })
        }


    const time = new Date().getHours();
    let greeting;
    if (time < 10) {
        greeting = "Good morning";
    } else if (time < 20) {
        greeting = "Good day";
    } else {
        greeting = "Good evening";
    }
    document.getElementById("demo").innerHTML = greeting;


    // $(document).ready(function() {
    //     setInterval(function() {
    //         $.ajax({
    //             type: 'POST',
    //             url: '../admin/startelection.php',
    //             data: {},
    //             success: function(e) {
    //             },
    //         });
    //         $('#voteDiv').contentWindow.location.reload(true);   
    //     }, 1000);
    // });
</script>

</html>