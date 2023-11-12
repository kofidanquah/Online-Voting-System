<?php
require "../config.php";

if (isset($_SESSION)) {
    $voterId = $_SESSION["voterId"];
} else {
    header("Location:login.view.php");
    die();
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

        h2{
            font-family:cursive;
        }
        header{
            background-color: rgb(0, 185, 36);
            height:60px ;
        }
        h4{
            text-align: center;
            justify-content: center;
        }
        input[type='radio']{
            accent-color: green;
        width: 25px;
        height: 25px;
        }

        .vote{
    border: 1px solid black;
    padding: 20px;
    margin: auto;
    width:65%;
    background-color: white;
        }
        .submit{
            align-items: center;
            justify-content: center;
            width: 240px;
            margin: auto;
            padding: 10px;

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
        <a href="../logout.php"><button class="btn btn-dark text-light px-3">Log out</button></a>
        <a href="dashboard.php"><button class="btn btn-dark text-light px-3">Return to dashboard</button></a>

        <?php echo $voterId ?>
    </div>

    <h4 class="container-fluid text-dark">Election</h4>
    <hr>

<div class="vote">
<h4>PRESIDENT</h4><br>
            <i class="text-success">Select your preferred Candidate</i><hr>
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
</div><hr>

<form method="post" action="../updatevote.php">
<?php
// President

$sql="SELECT * FROM candidates WHERE POSITION='President'";
$stmt = $conn->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if($result){                
foreach($result as $row) {
    $fullName= $row['FIRST_NAME'] .' '. $row['LAST_NAME'];
    $position=$row['POSITION'];
    $image=$row['CAND_IMAGE'];
    $candCode=$row['CAND_CODE'];
    ?>

    <div class="row">
    <div class="col-md-4">
    <img src="../uploads/<?php echo $image ?> "alt="img" ><br><br>

    </div>

    <div class="col-md-4">
    <!-- info -->
    <?php echo $fullName . '<br>' . $candCode ?>

    </div>



    <div class="col-md-4">
    <input type="radio" id="submit" name="vote1" value="<?php echo $candCode ?>" style="height:100px; width=100px;"  required><br>
    <input type=hidden name="candCode1" value="<?php echo $candCode ?>">
    </div>
    <br>
    <br>
    </div>
    <hr>
<?php
}
}else{
echo "No Records Available";
}
?>

</div>
<br>

<div class="vote">
<h4>VICE PRESIDENT</h4><br>
            <i class="text-success">Select your preferred Candidate</i><hr>
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
</div><hr>

<?php
// Vice President

$sql="SELECT * FROM candidates WHERE POSITION='Vice President'";
$stmt = $conn->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if($result){                
foreach($result as $row) {
    $fullName= $row['FIRST_NAME'] .' '. $row['LAST_NAME'];
    $position=$row['POSITION'];
    $image=$row['CAND_IMAGE'];
    $candCode=$row['CAND_CODE'];
    ?>

    <div class="row">
    <div class="col-md-4">
    <img src="../uploads/<?php echo $image ?> "alt="img" ><br><br>

    </div>

    <div class="col-md-4">
    <!-- info -->
    <?php echo $fullName . '<br>' . $candCode ?>

    </div>



    <div class="col-md-4">
    <input type="radio" id="submit" name="vote2" value="<?php echo $candCode ?>" style="height:100px; width=100px;"  required><br>
    <input type=hidden name="candCode2" value="<?php echo $candCode ?>">
    </div>
    <br>
    <br>
    </div>
    <hr>
<?php
}
}else{
echo "No Records Available";
}
?>

</div>
<br>

<div class="vote">
<h4>SECRETARY</h4><br>
            <i class="text-success">Select your preferred Candidate</i><hr>
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
</div><hr>

<?php
// Secretary

$sql="SELECT * FROM candidates WHERE POSITION='Secretary'";
$stmt = $conn->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if($result){                
foreach($result as $row) {
    $fullName= $row['FIRST_NAME'] .' '. $row['LAST_NAME'];
    $position=$row['POSITION'];
    $image=$row['CAND_IMAGE'];
    $candCode=$row['CAND_CODE'];
    ?>

    <div class="row">
    <div class="col-md-4">
    <img src="../uploads/<?php echo $image ?> "alt="img" ><br><br>

    </div>

    <div class="col-md-4">
    <!-- info -->
    <?php echo $fullName . '<br>' . $candCode ?>

    </div>



    <div class="col-md-4">
    <input type="radio" id="submit" name="vote3" value="<?php echo $candCode ?>" style="height:100px; width=100px;"  required><br>
    <input type=hidden name="candCode3" value="<?php echo $candCode ?>">
    </div>
    <br>
    <br>
    </div>
    <hr>
<?php
}
}else{
echo "No Records Available";
}
?>

</div>








<br>
<a href="../update.secretary.php" ><button class="submit btn btn-success text-light px-3 btn-center">Submit Ballot</button></a>
</form>

</body>
</html>