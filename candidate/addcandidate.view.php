<?php
require "../config.php";
if (isset($_SESSION["electionYear"]));
$electionYear = $_SESSION["electionYear"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-image: url(../images/image.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            height: max-content;
        }

        form {
            background-size: cover;
            background-color: white;
            width: 320px;
            padding: 20px;
            margin: auto;
            border-radius: 20px;
            height: max-content;
            border: 2px solid black;
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

        label {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;

        }
    </style>

    <title>add candidate</title>
</head>

<body>
    <div class="container my-5">
        <button class="btn btn-dark text-light px-3" onclick="goBack()">
<i class="fa fa-close"></i>                Cancel</button>
    </div>


    <form method="post" action="addcandidate.php" enctype="multipart/form-data">
        <h4>Add Candidate</h4>
        <input type="text" name="firstname" required placeholder="Enter your first name" autocomplete="off"><br>
        <input type="text" name="lastname" placeholder="Enter your last name" autocomplete="off"><br>

        <label for="position" class="form-label">
            <select name="position" id="position" class="form-select" required>
                <option>President</option>
                <option>Vice President</option>
                <option>Secretary</option>
            </select>
        </label>

        <input type="hidden" name="electionYear" placeholder="Enter Election Code" value="<?php echo $electionYear ?>" autocomplete="off"><br>
        <input type="email" name="email" placeholder="Enter Candidate Email" autocomplete="off"><br>

        <input required type="file" name="candimage" placeholder="image"><br>

        <input type="submit" name="submit" value="submit" id=submit>




    </form>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>