<?php 
include '../includes/session.php';
include '../includes/db.php';
include '../includes/auth_student.php';


$currentUserID = $_SESSION['user_id'];

$result = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT firstName, lastName 
    FROM users WHERE userID = $currentUserID
    "));

?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
</head>
<body>
    <h2>Welcome to Student Dashboard</h2>
    <p>Hello, <?= $result['firstName'] . ' ' . $result['lastName'] ?>!</p>
    <ul>
        <li><a href="enrollment.php">Enroll in Course</a></li>
        <li><a href="submit_feedback.php">Submit Feedback</a></li>
        <li><a href="view_feedbacks.php">View My Feedbacks</a></li>
        <li><a href="../auth/logout.php">Logout</a></li>
    </ul>
</body>
</html>
