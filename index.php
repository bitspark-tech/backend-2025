<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .landing {
            text-align: center;
            padding: 60px 20px;
        }

        .landing h1 {
            font-size: 32px;
            color: #007bff;
        }

        .landing p {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
        }

        .landing .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .landing .btn:hover {
            background-color: #0056b3;
        }

        footer {
            margin-top: 60px;
            text-align: center;
            color: #888;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container landing">
    <h1>Welcome to the Student Management System</h1>
    <p>Manage students, courses, enrollments and feedback — all in one place.</p>

    <a href="auth/login.php" class="btn">Login</a>
    <a href="auth/register.php" class="btn">Register</a>

    <footer>
        <p>Built by interns - <?php echo date("Y"); ?></p>
    </footer>
</div>

</body>
</html>
