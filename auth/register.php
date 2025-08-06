<?php
include '../includes/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first = trim($_POST["firstName"]);
    $last = trim($_POST["lastName"]);
    $email = trim($_POST["email"]);
    $gender = $_POST["gender"];
    $pass = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Check if email exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        echo "Email already in use!";
    } else {
        mysqli_query($conn, "INSERT INTO users (firstName, lastName, email, role, pass, gender) 
                             VALUES ('$first', '$last', '$email', 'student', '$pass', '$gender')");

        $userID = mysqli_insert_id($conn);
        $matriculeNo = strtoupper("BITS-" . rand(1000, 9999));

        mysqli_query($conn, "INSERT INTO students (userID, matriculeNo) 
                             VALUES ($userID, '$matriculeNo')");

        $_SESSION['user_id'] = $userID;
        $_SESSION['role'] = 'student';
        header("Location: ../auth/login.php");
    }
}
?>

<!-- HTML: Registration form -->
<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Register as a Student</h2>

    <form method="POST" action="">
        First Name: <input type="text" name="firstName" required><br><br>
        Last Name: <input type="text" name="lastName" required><br><br>
        Email: <input type="email" name="email" required><br><br>

        Password: <input type="password" name="password" id="password" required><br><br>
        Confirm Password: 
        <input type="password" name="confirm_password" id="confirm_password" required>
        <span id="match_status" style="margin-left: 10px; font-weight: bold;"></span><br><br>

        Gender:
        <select name="gender" required>
            <option value="">-- Select --</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select><br><br>

        <input type="submit" value="Register">
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const password = document.getElementById('password');
        const confirm = document.getElementById('confirm_password');
        const status = document.getElementById('match_status');

        function checkMatch() {
            if (!confirm.value) {
                status.textContent = "";
                return;
            }

            if (password.value === confirm.value) {
                status.textContent = "✅ Match";
                status.style.color = "green";
            } else {
                status.textContent = "❌ No Match";
                status.style.color = "red";
            }
        }

        password.addEventListener('input', checkMatch);
        confirm.addEventListener('input', checkMatch);
    });
    </script>
</body>
</html>
