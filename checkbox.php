<?php
require "config.php";

if (isset($_SESSION)) {
    $vortersid = $_SESSION["name"];
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
        table{
            width: 100%;
        }
        input[type="radio"]{
            size: 1000px;
        }
</style>

    </style>
    <title>check</title>

</head>


<body>
<header class="header text-dark text-center px-3">
<h2>VOTING SYSTEM</h2>
</header>

    <div class="container my-5">
        <a href="login.php"><button class="btn btn-dark text-light px-3">Back</button></a>
        <a href="../logout.php"><button class="btn btn-dark text-light px-3">Log out</button></a>
        <a href=""><button class="btn btn-dark text-light px-3 bg-success">Published Results</button></a>
    </div>

    <h4 class="container-fluid text-dark">Election</h4>
    <hr>


    <h5>CANDIDATES</h5>
    <table>
    <thead>
        <tr>           
            <th>Image</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        
    </thead>
    <tbody>

    <?php
    
    // president
    echo '<h4>President</h4><hr><br>';  
    $sql="SELECT * FROM candidates WHERE POSITION='President'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if($result){                
        foreach($result as $row) {
            $fullName= $row['FIRST_NAME'] . $row['LAST_NAME'];
            $image=$row['CAND_IMAGE'];
            $candCode=$row['CAND_CODE'];
            echo'<tr>
            <th> <img src="uploads/' . $image .' "</th>
            <th>'. $fullName .'</th>
            <th><input type="radio" id="" name="vote" value="' . $candCode . ' "  required><br>
            </th>
            </tr>';
        
        }
        }else{
        echo "No Records Available";
    }
?>
            <a href="voter/vice.president.php" ><button class="btn btn-success text-light px-3 btn-center" >Submit Ballot</button></a>

    </tbody>
    </table>



</div>
</body>

</html>