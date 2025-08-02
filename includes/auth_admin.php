<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "ACCESS DENIED ! THIS PAGE IS ONLY FOR ADMINS";
    exit;
}
?>