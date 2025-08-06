<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/auth_admin.php';

$student = null;
$courses = [];
$message = '';

if (isset($_GET['matricule'])) {
    $matricule = trim($_GET['matricule']);

    $studentQuery = "SELECT students.stID, users.firstName, users.lastName 
                     FROM students 
                     JOIN users ON students.userID = users.userID 
                     WHERE students.matriculeNo = '$matricule'";
    $studentResult = mysqli_query($conn, $studentQuery);

    if (!$studentResult) {
        die("Student Query Error: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($studentResult) > 0) {
        $student = mysqli_fetch_assoc($studentResult);
        $stID = $student['stID'];

        $coursesQuery = "SELECT c.name, c.description, e.enrollmentDate 
                         FROM enrollments e 
                         JOIN courses c ON e.courseID = c.courseID 
                         WHERE e.stID = $stID";
        $coursesResult = mysqli_query($conn, $coursesQuery);

        if (!$coursesResult) {
            die("Courses Query Error: " . mysqli_error($conn));
        }

        while ($row = mysqli_fetch_assoc($coursesResult)) {
            $courses[] = $row;
        }

        if (empty($courses)) {
            $message = "This student has not enrolled in any courses.";
        }
    } else {
        $message = "No student found with that matricule number.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Course Enrollments</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container">
    <h2>Search Student Course Enrollments</h2>

    <form method="GET" action="">
        <label>Enter Matricule Number:</label>
        <input type="text" name="matricule" required>
        <button type="submit">Search</button>
    </form>

    <?php if ($student): ?>
        <h3>Courses enrolled by <?= htmlspecialchars($student['firstName'] . ' ' . $student['lastName']); ?>:</h3>

        <?php if (!empty($courses)): ?>
            <table>
                <tr>
                    <th>Course Name</th>
                    <th>Description</th>
                    <th>Enrolled On</th>
                </tr>
                <?php foreach ($courses as $course): ?>
                    <tr>
                        <td><?= htmlspecialchars($course['name']); ?></td>
                        <td><?= htmlspecialchars($course['description']); ?></td>
                        <td><?= ($course['enrollmentDate']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p class="alert"><?= $message; ?></p>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (!$student && !empty($message)): ?>
        <p class="alert"><?= $message; ?></p>
    <?php endif; ?>
</div>
</body>
</html>
