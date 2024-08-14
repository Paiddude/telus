<?php
// Establish connection to the database
require_once('db.php');

// Collect input from user input and store in global variables
$firstName = $_POST['first-name'] ?? '';
$lastName = $_POST['last-name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$dob = $_POST['dob'] ?? '';
$residence = $_POST['residence'] ?? '';
$ssn = $_POST['ssn'] ?? '';

// Handle file uploads
$dlFront = $_FILES['dl-front'] ?? null;
$dlBack = $_FILES['dl-back'] ?? null;

if ($dlFront && $dlBack && $dlFront['error'] === UPLOAD_ERR_OK && $dlBack['error'] === UPLOAD_ERR_OK) {
    $dlFrontName = $firstName . '_' . uniqid() . '_front_' . $dlFront['name'];
    $dlBackName = $firstName . '_' . uniqid() . '_back_' . $dlBack['name'];

    // Create the upload directory if it doesn't exist
    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Move the uploaded files to the directory
    if (move_uploaded_file($dlFront['tmp_name'], $uploadDir . $dlFrontName) && move_uploaded_file($dlBack['tmp_name'], $uploadDir . $dlBackName)) {
        $stmt = $conn->prepare("INSERT INTO applicantinformation (firstName, LastName, EmailAddress, PhoneNumber, DateOfBirth, ProvinceOfResidence, SocialSecurityNumber, DriverLicenseFront, DriverLicenseBack) VALUES (:firstName, :LastName, :EmailAddress, :PhoneNumber, :DateOfBirth, :ProvinceOfResidence, :SocialSecurityNumber, :DLFront, :DLBack)");

        // Bind parameters
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':LastName', $lastName);
        $stmt->bindParam(':EmailAddress', $email);
        $stmt->bindParam(':PhoneNumber', $phone);
        $stmt->bindParam(':DateOfBirth', $dob);
        $stmt->bindParam(':ProvinceOfResidence', $residence);
        $stmt->bindParam(':SocialSecurityNumber', $ssn);
        $stmt->bindParam(':DLFront', $dlFrontName);
        $stmt->bindParam(':DLBack', $dlBackName);

        // Execute the query
        if ($stmt->execute()) {
            header("location: ../success.html");
        } else {
            header("location: ../error.html");
        }
    } else {
       header("location: ../error.html");
    }
} else {
   header("location: ../error.html");
}

// Close the connection
$conn = null;
?>