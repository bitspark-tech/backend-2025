<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/auth_admin.php';

$student = null;
$feedbacks = [];
$message = '';

if (isset($_GET['matricule'])) {
    $matricule = trim($_GET['matricule']);

    $studentQuery = "SELECT students.stID, users.firstName, users.lastName 
                     FROM students 
                     JOIN users ON students.userID = users.userID 
                     WHERE students.matriculeNo = '$matricule'";
    $studentResult = mysqli_query($conn, $studentQuery);

    if (mysqli_num_rows($studentResult) > 0) {
        $student = mysqli_fetch_assoc($studentResult);
        $stID = $student['stID'];

        $feedbackQuery = "
                SELECT f.fid, f.message, f.rating, f.feedbackDate,
                    c.name AS courseName,
                    s.matriculeNo,
                    r.message AS response, r.restDate
                FROM feedbacks f
                JOIN students s ON f.stID = s.stID
                JOIN users u ON s.userID = u.userID
                JOIN courses c ON f.courseID = c.courseID
                LEFT JOIN responses r ON f.fid = r.fid
                ORDER BY f.feedbackDate DESC
        ";
        $feedbackResult = mysqli_query($conn, $feedbackQuery);

        while ($row = mysqli_fetch_assoc($feedbackResult)) {
            $feedbacks[] = $row;
        }

        if (empty($feedbacks)) {
            $message = "No feedback found for this student.";
        }
    } else {
        $message = "No student found with that matricule number.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Feedbacks</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container">
    <h2>Search Student Feedbacks</h2>

    <form method="GET" action="">
        <label>Enter Matricule Number:</label>
        <input type="text" name="matricule" required>
        <button type="submit">Search</button>
    </form>

    <?php if ($student): ?>
        <h3>Feedback from <?= $student['firstName'] . ' ' . $student['lastName']; ?>:</h3>
        <?php if (!empty($feedbacks)): ?>
            <table>
                <tr>
                    <th>Course</th>
                    <th>Message</th>
                    <th>Rating</th>
                    <th>Feedback Date</th>
                    <th>Response</th>
                    <th>Response Date</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($feedbacks as $f): ?>
                    <tr>
                        <td><?= $f['courseName']; ?></td>
                        <td><?= $f['message']; ?></td>
                        <td><?= $f['rating']; ?></td>
                        <td><?= $f['feedbackDate']; ?></td>
                        <td><?= $f['response'] ?? '---'; ?></td>
                        <td><?= $f['restDate'] ?? '---'; ?></td>
                        <td>
                            <?php if (!$f['response']): ?>
                                <a href="respond_feedbacks.php?fid=<?= $f['fid']; ?>">Respond</a>
                            <?php else: ?>
                                ✔
                            <?php endif; ?>

                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p class="alert"><?= $message; ?></p>
        <?php endif; ?>
    <?php elseif ($message): ?>
        <p class="alert"><?= $message; ?></p>
    <?php endif; ?>
</div>
</body>
</html>
