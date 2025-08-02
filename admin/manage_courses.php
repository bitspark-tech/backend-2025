<?php
include '../includes/db.php';
include '../includes/session.php'; // ensures admin is logged in
include '../includes/auth_admin.php'; // checks if user is admin

// CREATE Course
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $instructor = $_POST['instructor'];

    mysqli_query($conn, "INSERT INTO courses (name, description, instructor)
                         VALUES ('$name', '$description', '$instructor')");
}

// DELETE Course
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM courses WHERE courseID = $id");
    header("Location: manage_courses.php");
}

// READ all courses
$courses = mysqli_query($conn, "SELECT * FROM courses");
?>

<!-- HTML: form to add course and display table of all courses -->
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Manage Courses</title>
</head>
<body>
    <h2>Add New Course</h2>
    <form method="POST" action="">
        <input type="hidden" name="add" value="1">

        <label>Course Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Description:</label><br>
        <textarea name="description" rows="3" cols="40" required></textarea><br><br>

        <label>Instructor Name:</label><br>
        <input type="text" name="instructor" required><br><br>

        <input type="submit" value="Add Course">
    </form>

    <h2>All Courses</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>Course Name</th>
            <th>Description</th>
            <th>Instructor</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($courses)) { ?>
        <tr>
            <td><?= $row['name'] ?></td>
            <td><?= $row['description'] ?></td>
            <td><?= $row['instructor'] ?></td>
            <td><a href="?delete=<?= $row['courseID'] ?>" onclick="return confirm('Delete this course?')">Delete</a></td>
        </tr>
        <?php } ?>
    </table>

    <br><a href="dashboard.php">← Back to Admin Dashboard</a>
</body>
</html>