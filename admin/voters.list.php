<?php
include "../config.php";
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
    background-color:rgb(241, 241, 241);
    }
img {
    height: 100px;
    width: 100px;
}

input{
    background-color: #4CAF50;
    width: 18%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid black;
    border-radius: 4px;
    box-sizing: border-box;
}
input[type=submit] {
    text-decoration: none;
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

.col-md-8 {
text-decoration: none;
}

table{
    border: 2px solid black;
    padding: 20px;
    margin: auto;
    width:85%;
    background-color: white;
}
hr{
    border: 1px solid black;
}
h3{
    text-align: center;
}

</style>
    <title>voters list</title>
</head>
<body>
<div class="container my-5">
    <a href="admin.page.php"><button class="btn btn-dark text-light px-3">Back</button></a>
    
</div>
<hr>
<div class="container my-5">
</div>
<div class="row">
    <div class=" px-5">
    </div>

    <div class="">

<table class="">
    <h3>Voters Register</h3>
    <thead>
        <tr>           
            <th>Image</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Voter's ID</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <form method="post" action="update.voter.php">
        <?php   
    
    try {
        $sql = "SELECT * FROM voters ORDER BY FIRST_NAME ASC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $fullName=$row['FIRST_NAME'] .' '. $row['LAST_NAME'];
            $gender=$row['GENDER'];
            $image=$row['VOTER_IMAGE'];
            $voterId=$row['VOTER_ID'];
            $status=$row['STATUS'];
            ?>

            <tr>
            <td> <img src="../uploads/<?php echo $image ?>"></td>
            <td><?php echo $fullName ?></td>
            <td><?php echo $gender ?></td>
            <td><?php echo $voterId ?></td>
            <td><?php echo $status ?></td>
            <td>
            <button type=button class=" remove" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $voterId ?>">Remove</button>
                <input type="hidden" name="voterId" >
            <button type=submit class=update value="<?php echo $voterId; ?>"><a href="../voter/updatevoter.view.php?id=<?php echo $voterId?>">Edit</a></button>
            </td>
            </tr>

            <tr>
<td>
    <div class="modal" id="deleteModal<?php echo $voterId ?>">
    <div class="modal-dialog">
        <div class="modal-content">
        <!-- modal header -->
        <div class="modal-header">
    <h4 class="modal-title">Confirm Delete</h4>

</div>

        <!-- modal body -->
    <div class="modal-body">
        <button class="btn btn-danger"><a href="../delete.voter.php?deleteid=<?php echo $voterId ?>">Delete</a></button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
    </div>

    </div>
    </div>
    </div>    

</td>

</tr>

            
        <?php 
        }
    
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
        
?>
</form>
            </tbody>
        </table>
        
    
<p>NB: If status is 0, voter has not voted.
    if 1, then voter has voted.
</p>
    </div>

</div>

</body>
</html>