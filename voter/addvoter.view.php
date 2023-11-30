<?php
require "../config.php";
if (isset($_SESSION["electionYear"]));
$electionYear = $_SESSION["electionYear"];

if (isset($_SESSION["successMessage"])) {
    echo "<script>alert('" . $_SESSION["successMessage"] . "')</script>";
    unset($_SESSION["successMessage"]);
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

    <title>add voter</title>
</head>

<body>
    <div class="container my-5">
        <button class="btn btn-dark text-light px-3" onclick="goBack()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
            </svg>
            Cancel</button>
    </div>

    <form method="post" action="addvoter.php" enctype="multipart/form-data">
        <h4>Add New Voter</h4>
        <input type="text" name="firstname" required placeholder="Enter your first name" autocomplete="off"><br>
        <input type="text" name="lastname" placeholder="Enter your last name" autocomplete="off"><br>
        <label for="gender" class="form-label">
            <select name="gender" class="form-select" required>
                <option selected disabled>Gender</option>
                <option>Male</option>
                <option>Female</option>
            </select>
        </label>
        <input type="hidden" name="electionYear"  value="<?php echo $electionYear ?>" autocomplete="off"><br>
        <input type="email" name="email" placeholder="Enter Voter email" autocomplete="off"><br>

        <input type="file" name="image" required placeholder="image"><br>
        <input type="submit" value="submit" id=submit>


    </form>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>