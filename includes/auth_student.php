<?php

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    echo "ACCESS DENIED ! THIS PAGE IS ONLY FOR STUDENTS";
    exit;
}
?>
