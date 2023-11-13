<?php
include "../config.php";
if (isset($_SESSION)) {
    $name = $_SESSION["username"];
} else {
    header("Location:admin.page.php");
    die();
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
<style>
body{
    background-image:url();
    background-repeat:no-repeat;
    background-size: cover;
}

img {
    height: 100px;
    width: 100px;
}

button:hover{
    background-color:gray ;
}

button{
    padding: 6px 10px;
    margin: 2px 0;
    display: inline-block;
    border: 1px solid black;
    border-radius: 4px;
    box-sizing: border-box;
    background-color: #4CAF50;
}

a{
    color: black;
}
.update{
    background-color:royalblue;
}
.remove{
    background-color:red;
}

.col-md-9 a{
text-decoration: none;
}

table{
    border: 4px solid green;
}
hr{
    border: 1px solid black;
}
.col-md-3{
background-color: rgb(241, 241, 241);
height: 400px;
box-shadow: 5px -5px 5px;
border-radius: 10px;
}

.voters{
background-color: rgb(46, 57, 191);
height: 120px;
margin-top: 10px;
border:2px solid black;
text-align: center;
color: white;
padding: 20px;
font-size: 16px;
border-radius: 10px;
}

.candidates{
background-color: rgb(247, 110, 65);
height: 120px;
margin-top: 10px;
border:2px solid black;
text-align: center;
color: white;
padding: 20px;
font-size: 16px;
border-radius: 10px;
}

</style>
    <title>Admin</title>
</head>
<body>
<div class="row">
<div class=" col-lg-3 container my-5">
    <a href="admin.login.php"><button class="btn btn-dark text-light px-3">Back</button></a>
    <a href="../index.php" ><button class="btn btn-dark text-light px-3">Home</button></a>    
</div>

<div class="col-lg-3">
    <p class="voters">Total number of Registered Voters:<br>
    <?php 
    echo $totalvoters;
        ?>
</p>

</div>

<div class="col-lg-3">
<p class="candidates">Total number of Candidates:<br>
<?php echo $totalcandidates; ?>
</p>
</div>

<div class="col-lg-3">
<p></p>
</div>



</div>

<hr>
<div class="container my-5">
    <h2 class="container-fluid text-dark">Voting System</h2>
</div>
<div class="row">
    <div class="col-md-3 px-5">
    <!-- admin -->
    <h4><b>Administrator</b></h4>
    <hr>

    <img src="../images/person.webp" alt="admin image" ><br>
    <b>
    Name: <?php echo $name; ?>
    </b>
    <br><br>

    </div>

    <div class="col-md-9">
        <button type="submit"><a href="../candidate/addcandidate.view.php" class="btn-success">+ Add Candidate</a></button>
        <button type="submit"><a href="../voter/addvoter.view.php">+ Add Voter</a></button>
        <button type="submit" ><a href="listofvoters.php">List of Voters</a></button>
        <button type="submit" ><a href="results.php">Results</a></button>

        <br><br>

<table class="table table-hover container-fluid">
    <h5>Candidates</h5>
    <thead>
        <tr>           
            <th>Image</th>
            <th>Name</th>
            <th>Position</th>
            <th>Candidate Code</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php   
    
    try {
        $sql = "SELECT * FROM candidates ORDER BY POSITION ASC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $fullName=$row['FIRST_NAME'] .' '. $row['LAST_NAME'];
            $position=$row['POSITION'];
            $image=$row['CAND_IMAGE'];
            $candCode=$row['CAND_CODE'];
            ?>

            <tr>
            <th> <img src="../uploads/<?php echo $image ?>"></th>
            <th><?php echo $fullName;?></th>
            <th><?php echo $position;?></th>
            <th><?php echo $candCode;?></th>
            <th>
                
                <button type=button class=" remove" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $candCode ?>">Remove</button>
                <input type="hidden" name="candCode" >
            <button type=submit class=update value="<?php echo $candCode; ?>"><a href="../candidate/update.candidate.view.php?id=<?php echo $candCode?>">Edit</a></button>
        </th>
            </tr>

            <tr>
<td>
    <div class="modal" id="deleteModal<?php echo $candCode ?>">
    <div class="modal-dialog">
        <div class="modal-content">
        <!-- modal header -->
        <div class="modal-header">
    <h4 class="modal-title">Confirm Delete</h4>
    <!-- <button type="button" class="btn btn-close" data-bs-dismiss="modal">Close</button> -->
        </div>

        <!-- modal body -->
    <div class="modal-body">
        <button class="btn btn-danger"><a href="../delete.php?deleteid=<?php echo $candCode ?>">Delete</a></button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
    </div>

    </div>
    </div>
    </div>    

</td>

</tr>


        <?php }
    
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    ?>
        
            </tbody>
        </table>
    

    </div>

</div>

</body>
</html>
