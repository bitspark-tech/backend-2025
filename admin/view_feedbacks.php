<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/auth_admin.php';

// Get all feedbacks with student + course + response info
$feedbacks = mysqli_query($conn, "
    SELECT f.fid, f.message AS feedback, f.rating, f.feedbackDate,
           c.name AS courseName,
           s.matriculeNo,
           u.firstName, u.lastName,
           r.message AS response, r.restDate
    FROM feedbacks f
    JOIN students s ON f.stID = s.stID
    JOIN users u ON s.userID = u.userID
    JOIN courses c ON f.courseID = c.courseID
    LEFT JOIN responses r ON f.fid = r.fid
    ORDER BY f.feedbackDate DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Feedbacks</title>
</head>
<body>
    <h2>All Submitted Feedbacks</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>Student</th>
            <th>Matricule</th>
            <th>Course</th>
            <th>Rating</th>
            <th>Feedback</th>
            <th>Submitted</th>
            <th>Response</th>
            <th>Responded</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($feedbacks)) { ?>
        <tr>
            <td><?= $row['firstName'] . ' ' . $row['lastName'] ?></td>
            <td><?= $row['matriculeNo'] ?></td>
            <td><?= $row['courseName'] ?></td>
            <td><?= $row['rating'] ?>/5</td>
            <td><?= $row['feedback'] ?></td>
            <td><?= $row['feedbackDate'] ?></td>
            <td><?= $row['response'] ?? '---' ?></td>
            <td><?= $row['restDate'] ?? '---' ?></td>
            <td>
                <?php if (!$row['response']) { ?>
                    <a href="respond_feedback.php?fid=<?= $row['fid'] ?>">Respond</a>
                <?php } else { echo '✔'; } ?>
            </td>
        </tr>
        <?php } ?>
    </table>

    <br><a href="dashboard.php">← Back to Admin Dashboard</a>
</body>
</html>
