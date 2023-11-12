<?php
require "../config.php";
if (isset($_SESSION)) {
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
            /* background-image:url(../images/methode_times.jpg); */
            background-color: rgb(255, 234, 172);
            background-repeat: no-repeat;
            background-size: cover;
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
        }

        header {
            background-color: rgb(0, 185, 36);
            height: 60px;
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
        }

        h3{
            font-size: 30px;
            font-family: "Helvetica";
        }
    </style>

    <title>dashboard</title>

</head>


<body>
    <header class="header text-dark text-center px-3">
        <h2>VOTING SYSTEM</h2>
    </header>
    <h3><i>WELCOME, <?php echo $firstname . " " . $lastname; ?></i></h3>


    <div class="container my-5">
        <a href="../logout.php"><button class="btn btn-dark text-light px-3">Home</button></a>
        <a href="login.view.php"><button class="btn btn-dark text-light px-3">Log out</button></a>
    </div>

    <h4 class="container-fluid text-dark">Dashboard</h4>
    <hr>

    <div class="row my-5 container-fluid">
        <div class="col-md-7">

            <?php
            if ($data['VOTE_COUNT'] < 3) { ?>
                <a href="votingpage.php"><button class="btn btn-dark text-light px-3 bg-success"> Vote now</button></a>
            <?php }
            ?>
            <br><br>
            <?php
            if ($data['VOTE_COUNT'] >= 3) { ?>
            <a href="../admin/results.php"><button class="btn btn-dark text-light px-3 bg-success">Published Results</button></a>
            <?php }
            ?>

            <br><br>
            <a href="updatevoter.view.php"><button class="btn btn-dark text-light px-3 bg-success">Edit Profile</button></a>

        </div>




        <div class="col-md-5">
            <!--voter-->
            <h5>VOTER </h5>
            <?php echo '<img src="../uploads/' . $image . '" >' ?>
            <br><br>
            <b>
            NAME: <?php echo $firstname . " " . $lastname; ?>
            <br><br>
            VOTER ID: <?php echo $voterId; ?>
            <br><br>
            STATUS: <?php
                    if ($data['VOTE_COUNT'] >= 3) {
                        echo "Voted";
                    }else{
                        echo "Not Voted";
                    }
                    ?>
            <br><br>
            GENDER: <?php echo $gender; ?>
            </b>


        </div>

    </div>


</body>

</html>