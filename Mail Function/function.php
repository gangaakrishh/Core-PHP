<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "form";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_no = $_POST['phone_no'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    $sql = "INSERT INTO `contact_form`(`first_name`, `last_name`, `email`, `phone_no`, `subject`, `message`) 
            VALUES ('$first_name','$last_name',' $email','$phone_no','$subject','$message ')";

    if ($conn->query($sql) === TRUE) {
        
        $to_email = "gangamg002@gmail.com";
        $subject = "Contact Form";
        $body = "<html>
            <body>
              <div style='font-family: Arial, sans-serif;'>
                <h3 style='color: #333;'>Enclaim | Contact Form Enquiry</h3>
                <p style='font-weight: 400; color: #666;'>First name: <span style='font-weight: bold;'>$first_name</span></p>
                <p style='font-weight: 400; color: #666;'>Last name: <span style='font-weight: bold;'>$last_name</span></p>
                <p style='font-weight: 400; color: #666;'>Email: <span style='font-weight: bold;'>$email</span></p>
                <p style='font-weight: 400; color: #666;'>Phone number: <span style='font-weight: bold;'>$phone_no</span></p>
                <p style='font-weight: 400; color: #666;'>Subject: <span style='font-weight: bold;'>$subject</span></p>
                <p style='font-weight: 400; color: #666;'>Message: <span style='font-weight: bold;'>$message</span></p>
              </div>
            </body>
            </html>";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: gangamg002@gmail.com' . "\r\n";
        if (mail($to_email, $subject, $body, $headers)) {
            $_SESSION['alert_message'] = "Thank you for reaching out to us!";
            $_SESSION['message2'] = "We'll be in touch shortly to address your inquiry.";
            header("Location: #");
            exit;
        } else {
            header("Location: #");
            exit; 
        }       
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error; 
        header("Location: #");
        exit;
    }
}

$conn->close();
?>
