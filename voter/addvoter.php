<?php
include "../config.php";
include "../library.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

$subject = "Voting System";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $gender = $_POST["gender"];
    $electionYear = $_POST["electionYear"];
    $file = $_FILES["image"];
    $email = $_POST["email"];

    //check if email already exists
    $sql = "SELECT * FROM voters WHERE VOTER_EMAIL = '$email'";
    $stmt1 = $conn->prepare($sql);
    $stmt1->execute();
    $data = $stmt1->fetch(PDO::FETCH_ASSOC);

    if ($data['VOTER_EMAIL'] == true) {
        $_SESSION['successMessage'] = "Email Already Exists!";
        header("Location:addvoter.view.php?electionYear=" . $electionYear);
        die();
    } else {

        if ($file) {
            $filename = $file["name"];
            $tmp_name = $file["tmp_name"];
            $folder = "../uploads/";

            // Move the uploaded image to the "uploads" folder
            if (move_uploaded_file($tmp_name, $folder . $filename)) {
                // Insert image information into the database
                try {
                    $voterId = generateVoterId();
                    $voterPassword = generateVoterPassword();

                    $query = "INSERT INTO voters (VOTER_IMAGE, GENDER, FIRST_NAME, LAST_NAME, VOTER_ID, PASSWORD, ELECTION_YEAR, VOTER_EMAIL) 
                    VALUES (:filename, :gender,  :firstname, :lastname, :voterId, :voterPassword, :electionYear, :email)";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':filename', $filename);
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':lastname', $lastname);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':electionYear', $electionYear);
                    $stmt->bindParam(':voterId', $voterId);
                    $stmt->bindParam(':voterPassword', $voterPassword);
                    $stmt->bindParam(':email', $email);

                    $stmt->execute();

                    
                    //send email to registered voter
                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Username   = 'votingsystem05@gmail.com';                     //SMTP username
                        $mail->Password   = 'lvae tkvo eysi emga';                               //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                        //Recipients
                        $mail->setFrom($email, $subject);
                        $mail->addAddress($email);     //Add a recipient


                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = $subject;
                        $mail->Body    = "Hi " . $firstname . " " . $lastname . ", You have been registered to Vote successfully, <br> Your Voter's ID is " . $voterId . " and your Password is " . $voterPassword . ". <br> Do not Share this Code with others. <a href='" . $_SERVER['HTTP_HOST'] . "/Test '>Click Here to vote</a>";

                                $mail->send();
                                echo 'Message has been sent';
                            } catch (Exception $e) {
                                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                            }

                            if ($stmt) {
                                $_SESSION['successMessage'] = "Voter Added Successfully.";
                                header("Location:../admin/admin.page.php?electionYear=" . $electionYear);
                            }
                        } catch (PDOException $e) {
                            echo "Database error: " . $e->getMessage();
                        }
                    } else {
                        echo " upload failed.";
                        die();
                    }
                }
            }
        }

        // Close the database connection
        $conn = null;
