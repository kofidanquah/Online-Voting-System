<?php
include "../config.php";
$searchVoter = isset($_GET["searchVoter"]);

if (!empty($searchVoter)) {
    $searchVoter = $_POST["searchVoter"];

    $sql = "SELECT * FROM voters WHERE FIRST_NAME = :searchVoter";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":searchVoter", $searchVoter);
    $stmt->execute();

    $searchResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            background-color: rgb(241, 241, 241);
        }

        img {
            height: 100px;
            width: 100px;
        }

        button {
            padding: 6px 10px;
            margin: 2px 0;
            display: inline-block;
            border: 1px solid black;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: #4CAF50;

        }

        a {
            color: black;
        }

        .col-md-8 {
            text-decoration: none;
        }

        table {
            border: 2px solid black;
            padding: 20px;
            margin: auto;
            width: 60%;
            background-color: white;
        }

        hr {
            border: 1px solid black;
        }

        h3 {
            text-align: center;
        }

        input {
            width: 35%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>
    <title>voters list</title>
</head>

<body>
    <div class="container-fluid my-5">
        <a href="admin.page.php"><button class="btn btn-dark text-light px-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
                </svg>
                Back</button></a>

                <a href="voters.list.php"><button class="btn btn-dark px-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                    <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
                </svg>
                Reset</button>
        </a>

    </div>
    <div class="container-fluid search">
        <form method="get" action="<?php echo $_SERVER["PHP_SELF"] ?>">
            <input type="search" name="searchVoter" placeholder="Search Voter" required>
            <button type="submit" class="btn btn-success">Search</button>
        </form>
    </div>
    <hr>
    <div class="container-fluid my-5">
    </div>
    <div class="row container-fluid">
        <div class=" px-5">
        </div>

        <div class="container-fluid">

            <table class="table table-hover container-fluid">
                <h3>Voters Register</h3>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Voter's ID</th>
                        <th>Status</th>
                        <th>Election Code</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    if (empty($searchVoter)) {
                        try {
                            $sql = "SELECT * FROM voters ORDER BY FIRST_NAME ASC";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $fullName = $row['FIRST_NAME'] . ' ' . $row['LAST_NAME'];
                                $gender = $row['GENDER'];
                                $image = $row['VOTER_IMAGE'];
                                $voterId = $row['VOTER_ID'];
                                $status = $row['STATUS'];
                                $electionCode = $row['ELECTION_CODE'];
                                                ?>
                                <tr>
                                    <td> <img src="../uploads/<?php echo $image ?>"></td>
                                    <td><?php echo $fullName ?></td>
                                    <td><?php echo $gender ?></td>
                                    <td><?php echo $voterId ?></td>
                                    <td><?php switch ($status) {
                                            case '1':
                                                echo 'Voted';
                                                break;

                                            default:
                                                echo 'Not Voted';
                                                break;
                                        } ?></td>
                                        <td><?php echo $electionCode ?></td>
                                    <td>
                                        <button type=button class="btn btn-danger remove" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $voterId ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                            </svg> Delete</button>
                                        <input type="hidden" name="voterId">
                                        <a href="../voter/updatevoter.view.php?id=<?php echo $voterId ?>"><button type=submit class="btn btn-primary update" value="<?php echo $voterId; ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                </svg>
                                                Edit</button></a>
                                    </td>
                                </tr>
                                <!-- confirm delete modal -->
                                <tr>
                                    <td>
                                        <div class="modal" id="deleteModal<?php echo $voterId ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <!-- modal header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Confirm Delete</h4>
                                                        <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>

                                                    </div>

                                                    <!-- modal body -->
                                                    <div class="modal-body">
                                                        <a href="../delete.voter.php?deleteid=<?php echo $voterId ?>"><button class="btn btn-danger">Delete</button></a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </td>

                                </tr>


                            <?php
                            }
                        } catch (PDOException $e) {
                            echo "Connection failed: " . $e->getMessage();
                        }

                    } else {
                        if ($searchResult) {
                            $sql = "SELECT * FROM voters";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();

                            foreach ($stmt as $row) {
                                $fullName = $row['FIRST_NAME'] . ' ' . $row['LAST_NAME'];
                                $image = $row['CAND_IMAGE'];
                                $candCode = $row['CAND_CODE'];
                                $position = $row['POSITION'];
                                
                            ?>
                                <tr>
                                    <td> <img src="../uploads/<?php echo $image ?>"></td>
                                    <td><?php echo $fullName ?></td>
                                    <td><?php echo $gender ?></td>
                                    <td><?php echo $voterId ?></td>
                                    <td><?php switch ($status) {
                                            case '1':
                                                echo 'Voted';
                                                break;

                                            default:
                                                echo 'Not Voted';
                                                break;
                                        } ?>
                                    </td>
                                    <td>
                                        <button type=button class="btn btn-danger remove" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $voterId ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                            </svg> Delete</button>
                                        <input type="hidden" name="voterId">
                                        <a href="../voter/updatevoter.view.php?id=<?php echo $voterId ?>"><button type=submit class="btn btn-primary update" value="<?php echo $voterId; ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                </svg>
                                                Edit</button></a>
                                    </td>
                                </tr>
                                <!-- confirm delete modal -->
                                <tr>
                                    <td>
                                        <div class="modal" id="deleteModal<?php echo $voterId ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <!-- modal header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Confirm Delete</h4>
                                                        <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>

                                                    </div>

                                                    <!-- modal body -->
                                                    <div class="modal-body">
                                                        <a href="../delete.voter.php?deleteid=<?php echo $voterId ?>"><button class="btn btn-danger">Delete</button></a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </td>

                                </tr>
                    <?php }
                        }
                    }

                    ?>
                </tbody>

            </table>

        </div>

    </div>

</body>

</html>