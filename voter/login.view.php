<?php
require "../config.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
        background-image: url("../images/background\ image.jfif");
        background-repeat: no-repeat;
        background-size: cover;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 90vh;
    }
    
    form {
        background-repeat: no-repeat;
        background-size: cover;
        background-color: rgba(255, 255, 255, 0.5);
        width: 240px;
        padding: 20px;
        margin: auto;
        border-radius: 20px;
        height: 50vh;
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
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    a:hover {color: gray;
        cursor: pointer;
    }
    #submit:hover{
        background-color: #4CAF50;
        cursor: pointer;
    }
    .error{
        color: red !important;
    }
    .success{
        color: green !important;
    }

</style>
    <title>Log in</title>
</head>
<body>
<p class="error">

    <form method="post" action="login.php">
        <h2>Log in</h2>
        voter's id<br><input type="text" name="voterId" autocomplete="off" autofocus maxlength="7" required><br>
        password<br><input type="password" name="password" autocomplete="off" maxlength="4" required><br><br>
        <input type="hidden" name="firstName" value="<?php echo $votingStatus; ?>">
        <input type="submit" value="Log in" id="submit"><br>
        <a>Forgotten password?</a>


        <?php
        if (isset($_SESSION['status']) && isset($_SESSION['message']) ) {
            if ($_SESSION['status']) { ?>
                <p class="error"><?php echo $_SESSION['message'] ?></p>
                <?php } else { ?>
                    <p class="success"><?php echo $_SESSION['message'] ?></p>
            <?php }
            unset($_SESSION['status'], $_SESSION ['message']);
                }
            
            ?>

    </form>



</body>
</html>

