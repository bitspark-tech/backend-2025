<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/auth_student.php';


$userID = $_SESSION['user_id'];
$stQuery = mysqli_query($conn, "SELECT stID FROM students WHERE userID = $userID");
$student = mysqli_fetch_assoc($stQuery);
$stID = $student['stID'];

// Submit feedback
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseID = $_POST['courseID'];
    $message = $_POST['message'];
    $rating = $_POST['rating'];

    mysqli_query($conn, "INSERT INTO feedbacks (message, rating, stID, courseID) 
                         VALUES ('$message', $rating, $stID, $courseID)");
}

// Fetch only enrolled courses
$courses = mysqli_query($conn, "
    SELECT c.courseID, c.name 
    FROM courses c
    JOIN enrollments e ON c.courseID = e.courseID
    WHERE e.stID = $stID
");
?>

<!-- HTML: Form with dropdown of enrolled courses, message textarea, rating input -->
<!DOCTYPE html>
<html>
<head>
    <title>Submit Feedback</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Submit Feedback</h2>
    <form method="POST" action="">
        <label>Select Course:</label><br>
        <select name="courseID" required>
            <option value="">-- Select Course --</option>
            <?php while ($row = mysqli_fetch_assoc($courses)) { ?>
                <option value="<?= $row['courseID'] ?>"><?= $row['name'] ?></option>
            <?php } ?>
        </select><br><br>

        <label>Message:</label><br>
        <textarea name="message" rows="4" cols="50" required></textarea><br><br>

        <label>Rating (1-5):</label><br>
        <input type="number" name="rating" min="1" max="5" required><br><br>

        <input type="submit" value="Submit Feedback">
    </form>

    <br><a href="dashboard.php">← Back to Student Dashboard</a>
</body>
</html>