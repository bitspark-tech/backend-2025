<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/auth_student.php';


$userID = $_SESSION['user_id'] ?? null;

if (!$userID || $_SESSION['role'] !== 'student') {
    header("Location: ../auth/login.php");
    exit;
}

// Fetch student data
$student = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT * FROM students WHERE userID = $userID
"));

// If profile is already completed, skip this step
if ($student && $student['dob'] && $student['pob'] && $student['phone'] && $student['address']) {
    header("Location: dashboard.php");
    exit;
}

// Handle update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dob = $_POST["dob"];
    $pob = $_POST["pob"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    mysqli_query($conn, "
        UPDATE students 
        SET dob = '$dob', pob = '$pob', phone = '$phone', address = '$address'
        WHERE userID = $userID
    ");

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Complete Your Profile</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Complete Your Student Profile</h2>
    <form method="POST" action="">
        <label>Date of Birth:</label><br>
        <input type="date" name="dob" required><br><br>

        <label>Place of Birth:</label><br>
        <input type="text" name="pob" required><br><br>

        <label>Phone Number:</label><br>
        <input type="text" name="phone" required><br><br>

        <label>Address:</label><br>
        <input type="text" name="address" required><br><br>

        <input type="submit" value="Save Profile">
    </form>
</body>
</html>
