<?php 
require "../config.php";

$resultSql = "SELECT `CAND_CODE`, COUNT(`ID`) AS `TOTAL_VOTES` FROM `election` GROUP BY `CAND_CODE`";
    $resultStmt = $conn->prepare($resultSql);
    $resultStmt->execute();

    $electionResult = $resultStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
img {
    height: 100px;
    width: 100px;
}


table{
    border: 4px solid green;
    width: 65%;
    margin-left: 15%;
}
hr{
    border: 1px solid black;
}
h1{
    text-align: center;
}
h3{
    text-align: center;
    font-size: large;
    font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
}

</style>

    <title>Results</title>
</head>
<body>

<h1>RESULTS</h1><hr>

<table class="table table-hover">
    <h3>PRESIDENT</h3>
    <thead>
        <tr>           
            <th>Image</th>
            <th>Candidate Name</th>
            <th>Number of votes</th>
        </tr>
    </thead>
    <tbody>
        <?php   
    
    try {
        $sql = "SELECT * FROM candidates  WHERE POSITION ='President'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $fullName=$row['FIRST_NAME'] .' '. $row['LAST_NAME'];
            $image=$row['CAND_IMAGE'];            
            $candCode=$row['CAND_CODE'];

            $votes= 0;
            foreach ($electionResult as $k => $v) {
                if ($v['CAND_CODE'] == $candCode) {
                    $votes = $v['TOTAL_VOTES'];
                    break;
            }
        }
            
            ?>

            <tr>
            <th> <img src="../uploads/<?php echo $image ?>"></th>
            <th><?php echo $fullName ?></th>
            <th><?php echo $votes ?></th>
            </th>
            </tr>
        <?php }
    
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
        
?>
            </tbody>
        </table>

        <br><br>

        <table class="table table-hover">
            <h3>VICE PRESIDENT</h3>
    <thead>
        <tr>           
            <th>Image</th>
            <th>Candidate Name</th>
            <th>Number of votes</th>
        </tr>
    </thead>
    <tbody>
        <?php   
    try {
        $sql = "SELECT * FROM candidates WHERE POSITION ='Vice President'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $fullName=$row['FIRST_NAME'] .' '. $row['LAST_NAME'];
            $image=$row['CAND_IMAGE'];
            $candCode=$row['CAND_CODE'];
            
            $votes= 0;
            foreach ($electionResult as $k => $v) {
                if ($v['CAND_CODE'] == $candCode) {
                    $votes = $v['TOTAL_VOTES'];
                    break;
            }
        }
            ?>

            <tr>
            <th> <img src="../uploads/<?php echo $image ?>"></th>
            <th><?php echo $fullName ?></th>
            <th><?php echo $votes ?></th>
            </th>
            </tr>
        <?php }
    
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
        
        
?>
            </tbody>
        </table>
<br><br>
<table class="table table-hover">
    <h3>SECRETARY</h3>
    <thead>
        <tr>           
            <th>Image</th>
            <th>Candidate Name</th>
            <th>Number of votes</th>
        </tr>
    </thead>
    <tbody>
        <?php   
    
    try {
        $sql = "SELECT * FROM candidates WHERE POSITION ='Secretary'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $fullName=$row['FIRST_NAME'] .' '. $row['LAST_NAME'];
            $image=$row['CAND_IMAGE'];
            
            $candCode=$row['CAND_CODE'];

            $votes= 0;
            foreach ($electionResult as $k => $v) {
                if ($v['CAND_CODE'] == $candCode) {
                    $votes = $v['TOTAL_VOTES'];
                    break;
            }
        }
            
            ?>

            <tr>
            <th> <img src="../uploads/<?php echo $image ?>"></th>
            <th><?php echo $fullName ?></th>
            <th><?php echo $votes ?></th>
            </th>
            </tr>
        <?php }
    
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
        
        
?>
            </tbody>
        </table>




</body>
</html>
