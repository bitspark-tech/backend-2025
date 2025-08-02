<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/auth_admin.php';

$fid = $_GET['fid'] ?? null;

if (!$fid) {
    die("Feedback ID missing.");
}

// Handle submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $msg = $_POST['message'];
    mysqli_query($conn, "INSERT INTO responses (fid, message) VALUES ($fid, '$msg')");
    header("Location: view_feedbacks.php");
    exit;
}

// Fetch feedback
$feedback = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT f.message AS feedback, f.rating, f.feedbackDate,
           u.firstName, u.lastName, c.name AS courseName
    FROM feedbacks f
    JOIN students s ON f.stID = s.stID
    JOIN users u ON s.userID = u.userID
    JOIN courses c ON f.courseID = c.courseID
    WHERE f.fid = $fid
"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Respond to Feedback</title>
</head>
<body>
    <h2>Respond to Feedback</h2>

    <p><strong>Student:</strong> <?= $feedback['firstName'] . ' ' . $feedback['lastName'] ?></p>
    <p><strong>Course:</strong> <?= $feedback['courseName'] ?></p>
    <p><strong>Rating:</strong> <?= $feedback['rating'] ?>/5</p>
    <p><strong>Feedback:</strong> <?= $feedback['feedback'] ?></p>
    <p><strong>Submitted On:</strong> <?= $feedback['feedbackDate'] ?></p>

    <hr>

    <form method="POST" action="">
        <label>Admin Response:</label><br>
        <textarea name="message" rows="4" cols="50" required></textarea><br><br>
        <input type="submit" value="Submit Response">
    </form>

    <br><a href="view_feedbacks.php">← Back to All Feedbacks</a>
</body>
</html>
