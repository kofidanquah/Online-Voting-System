<?php
require "../config.php";

if (isset($_SESSION)) {
    $voterId = $_SESSION["voterId"];
    $firstname = $_SESSION["firstname"];
    $lastname = $_SESSION["lastname"];
    $gender = $_SESSION["gender"];
    $image = $_SESSION["image"];

} else {
    header("Location:updatevoter.view.php");
    die();
}
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
            border: 2px solid rgb(221, 160, 129);
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

    <title>update voter</title>
</head>

<body>
    <form method="post" action="update.voter.php" enctype="multipart/form-data">
        <h4>Update Profile</h4>
        firstname
        <input type="text" name="firstname" value= "<?php echo $firstname; ?>" autocomplete="off"><br>
        lastname
        <input type="text" name="lastname" value= "<?php echo $lastname; ?>" autocomplete="off"><br>
        <label for="gender" class="form-label">
            <select name="gender" class="form-select"  required>
                <option selected disabled>Gender</option>
                <option>Male</option>
                <option>Female</option>
            </select>
        </label>
        <input type="file" name="image" value= "../uploads/<?php echo $image; ?>"><br>
        <input type="hidden" name="voterId" value="<?php echo $voterId; ?>">
        <input type="submit" name="submit" value="update" id=submit>

    </form>
</body>
</html>