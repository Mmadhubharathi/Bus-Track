<?php
require 'config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    die('You must be logged in to record pass usage.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pass_number = $_POST['pass_number'];

    // Get pass ID from pass number
    $sql = "SELECT id FROM passes WHERE pass_number = ? AND status = 'active' AND end_date >= CURDATE()";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$pass_number]);

    $pass = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($pass) {
        $pass_id = $pass['id'];
        $sql = "INSERT INTO usage (pass_id) VALUES (?)";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$pass_id])) {
            echo 'Pass usage recorded successfully.';
        } else {
            echo 'Error: Could not record pass usage.';
        }
    } else {
        echo 'Invalid or expired pass number.';
    }
}
?>

<form method="POST">
    Pass Number: <input type="text" name="pass_number" required><br>
    <input type="submit" value="Record Usage">
</form>
