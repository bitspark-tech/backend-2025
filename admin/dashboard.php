<?php 
include '../includes/session.php';
include '../includes/db.php';
include '../includes/auth_admin.php';

$currentUserID = $_SESSION['user_id'];

$result = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT firstName, lastName 
    FROM users WHERE userID = $currentUserID
    "));

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Welcome to Admin Dashboard</h2>
    <p>Hello, <?= $result['firstName'] . ' ' . $result['lastName'] ?>!</p>

    <ul>
        <li><a href="manage_students.php">Manage Students</a></li>
        <li><a href="manage_courses.php">Manage Courses</a></li>
        <li><a href="view_feedbacks.php">View Feedbacks</a></li>
        <li><a href="../auth/logout.php">Logout</a></li>
    </ul>
</body>
</html>
