<?php
require "config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <style>
        body {
        background-image: url("images/images (2).jfif");
        background-repeat: no-repeat;
        background-size: cover;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }
    
    form {
        background-image: url("images/images (2).jfif");
        background-repeat: no-repeat;
        background-size: cover;
        background-color: rgba(255, 255, 255, 0.5);
        width: 240px;
        padding: 20px;
        margin: auto;
        border-radius: 20px;
        height: 90vh;
    }
    
    h2 {
        text-align: center;
        font-size: 30px;
        margin-bottom: 20px;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
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
        background-color: rgb(0,0,0);
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .error{
        color: red !important;
    }
    .success{
        color: green !important;
    }
</style>
</head>
<body>
    <p class="error">
    </p>
    <form method="post" action="insert.php">
        <h2>Sign Up</h2>
        <br>
        <input type="text" name="name" placeholder="Fullname" autocomplete="off" ><br>
        <br>
        <input type="email" name="email" placeholder="Email" autocomplete="off"><br>
        <!-- <br><input type="tel" name="phone" placeholder="Phone"> -->
        <hr><br>
        <input type="text" name="username" placeholder="Username" autocomplete="off" required><br>
        <br><input type="password" name="password" placeholder="Password" autocomplete="off" required ><br>
        <br><input type="password" name="cpassword" placeholder="Confirm Password"  autocomplete="off" required><br><br>

        <!-- <p>By clicking on <b>Sign up</b>, you hereby accept all <a href="#">Terms and Conditions<a>and Policies.</a></a></p> -->

        <input type="submit" value="Sign up"><br>
            <?php
        if (isset($_SESSION['status']) && isset($_SESSION['message']) ) {
            if ($_SESSION['status']) { ?>
                <p class="error"><?php echo $_SESSION['message'] ?></p>
                <?php } else { ?>
                    <p class="success"><?php echo $_SESSION['message'] ?></p>
            <?php }
            unset($_SESSION['status'], $_SESSION['message']);
        }
            ?>
                <!-- <p>Already have an account? </p>
                <a href="login.php">Log in</a> -->


    </form>
    

</body>
</html>

