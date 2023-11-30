<?php
require "../config.php";

$id = $_GET['id'];
$sql = "SELECT * FROM voters WHERE VOTER_ID = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

$firstname = $result['FIRST_NAME'];
$lastname = $result['LAST_NAME'];
$position = $result['GENDER'];
$voterId = $result['VOTER_ID'];
$image = $result['VOTER_IMAGE'];
$electionYear = $result['ELECTION_YEAR'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        form {
            background-size: cover;
            background-color: rgba(255, 255, 255, 0.5);
            width: 320px;
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

    <title>update voter</title>
</head>

<body>
    <div class="container my-5">
        <a href="../admin/voters.list.php"><button class="btn btn-dark text-light px-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                </svg>
                Cancel</button></a>
    </div>


    <form method="post" action="update.voter.php" enctype="multipart/form-data">
        <h4>Update Profile</h4>

        Firstname
        <input type="text" name="firstname" value="<?php echo $firstname; ?>" autocomplete="off"><br>
        Lastname
        <input type="text" name="lastname" value="<?php echo $lastname; ?>" autocomplete="off"><br>
        Gender
        <label for="gender" class="form-label">
            <select name="gender" class="form-select" required>
                <option selected disabled>Gender</option>
                <option <?php echo $position == "Male" ? "selected" : ""; ?>>Male</option>
                <option <?php echo $position == "Female" ? "selected" : ""; ?>>Female</option>
            </select>
        </label>
        <input type="hidden" name="electionYear" value="<?php echo $electionYear; ?>">

        <input type="hidden" src="../uploads/<?php echo $image; ?>" width="100px" />
        <input type="file" name="image"><br>
        <input type="hidden" name="voterId" value="<?php echo $voterId; ?>">
        <input type="submit" name="submit" value="update" id=submit>

    </form>
</body>

</html>