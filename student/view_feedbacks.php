<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/auth_student.php';


$userID = $_SESSION['user_id'];
$student = mysqli_fetch_assoc(mysqli_query($conn, "SELECT stID FROM students WHERE userID = $userID"));
$stID = $student['stID'];

$feedbacks = mysqli_query($conn, "
    SELECT f.fid, f.message, f.rating, f.feedbackDate, c.name AS courseName, r.message AS response, r.restDate
    FROM feedbacks f
    JOIN courses c ON f.courseID = c.courseID
    LEFT JOIN responses r ON f.fid = r.fid
    WHERE f.stID = $stID
    ORDER BY f.feedbackDate DESC
");
?>

<!-- HTML table: course name, rating, message, response (if any), dates -->
<!DOCTYPE html>
<html>
<head>
    <title>My Feedback</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>My Submitted Feedback</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>Course</th>
            <th>Rating</th>
            <th>Feedback</th>
            <th>Submitted On</th>
            <th>Admin Response</th>
            <th>Responded On</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($feedbacks)) { ?>
        <tr>
            <td><?= $row['courseName'] ?></td>
            <td><?= $row['rating'] ?>/5</td>
            <td><?= $row['message'] ?></td>
            <td><?= $row['feedbackDate'] ?></td>
            <td><?= $row['response'] ?? '---' ?></td>
            <td><?= $row['restDate'] ?? '---' ?></td>
        </tr>
        <?php } ?>
    </table>

    <br><a href="dashboard.php">← Back to Student Dashboard</a>
</body>
</html>