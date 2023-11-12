<?php 
require "../config.php";

$id = $_GET['id'];
$sql = "SELECT * FROM candidates WHERE CAND_CODE = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

$firstname=$result['FIRST_NAME'];
$lastname=$result['LAST_NAME'];
$position=$result['POSITION'];
$candCode=$result['CAND_CODE'];
$image=$result['CAND_IMAGE'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        form {
            background-size: cover;
            background-color: rgba(255, 255, 255, 0.5);
            width: 240px;
            padding: 20px;
            margin: auto;
            border-radius: 20px;
            height: max-content;
            border: 2px solid green;
        }

        input {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type=submit] {
            width: 100%;
            background-color: rgb(0, 0, 0);
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        #submit:hover {
            background-color: gray;
        }

        h4 {
            text-align: center;
        }

        select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;

        }
    </style>

    <title>update candidate</title>
</head>
<body>
<form method="post" action="update.candidate.php" enctype="multipart/form-data">
        <h4>Update Candidate</h4>
        firstname
        <input type="text" name="firstname" value="<?php echo $firstname; ?>" autocomplete="off"><br>
        lastname
        <input type="text" name="lastname" value="<?php echo $lastname; ?>" autocomplete="off"><br>
        <input type="hidden" name="candCode" value="<?php echo $candCode; ?>">

        position
        <label for="position" class="form-label">
            <select name="position" id="position" class="form-select" required>
                <option>President</option>
                <option>Vice President</option>
                <option>Secretary</option>
                <option>Manager</option>
            </select>
        </label>


        <input type="file" name="candimage" placeholder="image"><br>

        <input type="submit" name="submit" value="Update" id=submit>


    </form>

</body>
</html>