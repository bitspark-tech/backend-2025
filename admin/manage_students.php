<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/auth_admin.php';

// CREATE student + user
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add'])) {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];
    $pob = $_POST["pob"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $pass = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $matriculeNo = strtoupper("BITS-" . rand(1000, 9999));

    mysqli_query($conn, "INSERT INTO users (firstName, lastName, email, role, pass, gender)
                         VALUES ('$firstName', '$lastName', '$email', 'student', '$pass', '$gender')");

    $userID = mysqli_insert_id($conn);

    mysqli_query($conn, "INSERT INTO students (userID, matriculeNo, dob, pob, phone, address)
                         VALUES ($userID, '$matriculeNo', '$dob', '$pob', '$phone', '$address')");
}

// DELETE student (and their user)
if (isset($_GET['delete'])) {
    $userID = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM users WHERE userID = $userID");
    header("Location: manage_students.php");
}

// JOIN users + students
$students = mysqli_query($conn, "
    SELECT u.userID, u.firstName, u.lastName, u.email, u.gender, s.stID, s.matriculeNo, s.dob, s.pob, s.phone, s.address
    FROM users u
    JOIN students s ON u.userID = s.userID
");
?>

<!-- HTML: student form and student table -->
 <!DOCTYPE html>
<html>
<head>
    <title>Admin - Manage Students</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Add New Student</h2>
    <form method="POST" action="">
        <input type="hidden" name="add" value="1">

        <label>First Name:</label><br>
        <input type="text" name="firstName" required><br><br>

        <label>Last Name:</label><br>
        <input type="text" name="lastName" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Gender:</label><br>
        <select name="gender" required>
            <option value="">-- Select --</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select><br><br>

        <label>Date of Birth:</label><br>
        <input type="date" name="dob" required><br><br>

        <label>Place of Birth:</label><br>
        <input type="text" name="pob" required><br><br>

        <label>Phone:</label><br>
        <input type="text" name="phone" required><br><br>

        <label>Address:</label><br>
        <input type="text" name="address" required><br><br>

        <input type="submit" value="Add Student">
    </form>

    <h2>All Students</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>Matricule</th>
            <th>Name</th>
            <th>Email</th>
            <th>DOB</th>
            <th>POB</th>
            <th>Gender</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($students)) { ?>
        <tr>
            <td><?= $row['matriculeNo'] ?></td>
            <td><?= $row['firstName'] . ' ' . $row['lastName'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['dob'] ?></td>
            <td><?= $row['pob'] ?></td>
            <td><?= $row['gender'] ?></td>
            <td><?= $row['phone'] ?></td>
            <td><?= $row['address'] ?></td>
            <td><a href="?delete=<?= $row['userID'] ?>" onclick="return confirm('Delete this student?')">Delete</a></td>
        </tr>
        <?php } ?>
    </table>

    <br><a href="dashboard.php">← Back to Admin Dashboard</a>
</body>
</html>
