<?php
require "../config.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body{
            /* background-image: url(../images/vote.background.jpg);
            background-repeat: no-repeat;
            background-size: cover; */
        }
        form {
            background-size: cover;
            background-color: rgba(255, 255, 255, 0.5);
            width: 240px;
            padding: 20px;
            margin: auto;
            border-radius: 10px;
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

    <title>add voter</title>
</head>

<body>


    <form method="post" action="addvoter.php" enctype="multipart/form-data">
        <h4>Add New Voter</h4>
        <input type="text" name="firstname" placeholder="Enter your first name" autocomplete="off"><br>
        <input type="text" name="lastname" placeholder="Enter your last name" autocomplete="off"><br>
        <label for="gender" class="form-label">
            <select name="gender" class="form-select" required>
                <option selected disabled>Gender</option>
                <option>Male</option>
                <option>Female</option>
            </select>
        </label>
        <input type="file" name="image" placeholder="image"><br>
        <input type="submit" name="submit" value="submit" id=submit>


    </form>
</body>

</html>