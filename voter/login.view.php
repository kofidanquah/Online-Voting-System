<?php
require "../config.php";
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
            background-image: url("../images/background\ image.jfif");
            background-repeat: no-repeat;
            background-size: cover;
            align-items: center;
            justify-content: center;
            /* height: 90vh; */
        }

        form {
            /* margin-left: 300px; */

            /* padding: 20px;
            margin: auto; */
            border-radius: 20px;
            height: 60vh; 
            /* box-shadow: 10px 10px 10px; */

        }

        h2 {
            font-size: 30px;
            margin-bottom: 20px;
            font-family: "Poppins", sans-serif;
            margin-left: 90px;
        }

        input {
            width: 50%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-align: center;
            justify-content: center;
            /* box-sizing: border-box; */
        }


    </style>
    <title>Log in</title>
</head>

<body>
    <div class="container my-5">
        <a href="../index.php"><button class="btn btn-dark text-light px-3">
                <i class="fa fa-home"></i> Home</button></a>
    </div>


    <div class="row container-fluid">

        <div class="col-md-4">
        </div>

        <div class="col-md-8 col-sm-12">
            <form method="post" action="login.php">
                <h2>Log in</h2>
                Voter's ID<br>
                <input type="text" name="voterId" autocomplete="off" autofocus maxlength="7" required><br>
                Password<br>
                <input type="password" name="password" autocomplete="off" maxlength="4" required><br><br>
                <input type="hidden" name="firstName" value="<?php echo $votingStatus; ?>">
                <input class="btn btn-success" type="submit" value="Log in" id="submit"></input>
                    <br>
                <!-- <a>Forgotten password?</a> -->
            </form>
        </div>
    </div>



</body>

</html>