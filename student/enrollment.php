<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/auth_student.php';

$userID = $_SESSION['user_id'];

// Get student ID
$getStudent = mysqli_query($conn, "SELECT stID FROM students WHERE userID = $userID");
$student = mysqli_fetch_assoc($getStudent);
$stID = $student['stID'];

// Enroll in course
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['courseID']) && isset($_POST['action']) && $_POST['action'] === 'enroll') {
        $courseID = $_POST['courseID'];

        // Prevent duplicate
        $check = mysqli_query($conn, "SELECT * FROM enrollments WHERE stID = $stID AND courseID = $courseID");
        if (mysqli_num_rows($check) == 0) {
            mysqli_query($conn, "INSERT INTO enrollments (stID, courseID) VALUES ($stID, $courseID)");
        }

    } elseif (isset($_POST['dropCourseID']) && $_POST['action'] === 'drop') {
        $courseID = $_POST['dropCourseID'];
        mysqli_query($conn, "DELETE FROM enrollments WHERE stID = $stID AND courseID = $courseID");
    }
}

// Get all courses the student is NOT enrolled in
$availableCourses = mysqli_query($conn, "
    SELECT * FROM courses 
    WHERE courseID NOT IN (
        SELECT courseID FROM enrollments WHERE stID = $stID
    )
");

// Get enrolled courses
$enrolledCourses = mysqli_query($conn, "
    SELECT c.courseID, c.name, c.instructor
    FROM courses c
    JOIN enrollments e ON c.courseID = e.courseID
    WHERE e.stID = $stID
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enroll in Course</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Enroll in a Course</h2>
    <form method="POST" action="">
        <label>Select Course:</label><br>
        <select name="courseID" required>
            <option value="">-- Select Course --</option>
            <?php while ($row = mysqli_fetch_assoc($availableCourses)) { ?>
                <option value="<?= $row['courseID'] ?>"><?= $row['name'] ?> (<?= $row['instructor'] ?>)</option>
            <?php } ?>
        </select><br><br>
        <input type="hidden" name="action" value="enroll">
        <input type="submit" value="Enroll">
    </form>

    <h2>My Enrolled Courses</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>Course Name</th>
            <th>Instructor</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($enrolledCourses)) { ?>
        <tr>
            <td><?= $row['name'] ?></td>
            <td><?= $row['instructor'] ?></td>
            <td>
                <form method="POST" action="" onsubmit="return confirm('Are you sure you want to drop this course?');">
                    <input type="hidden" name="dropCourseID" value="<?= $row['courseID'] ?>">
                    <input type="hidden" name="action" value="drop">
                    <input type="submit" value="Drop">
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

    <br><a href="dashboard.php">← Back to Student Dashboard</a>
</body>
</html>
