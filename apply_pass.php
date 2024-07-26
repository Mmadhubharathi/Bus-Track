<?php
require 'config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    die('You must be logged in to apply for a bus pass.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pass_type = $_POST['pass_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $user_id = $_SESSION['user_id'];
    $pass_number = strtoupper(bin2hex(random_bytes(6))); // Generate a random pass number

    $sql = "INSERT INTO passes (user_id, pass_number, pass_type, start_date, end_date) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$user_id, $pass_number, $pass_type, $start_date, $end_date])) {
        echo 'Bus pass applied successfully. Pass Number: ' . $pass_number;
    } else {
        echo 'Error: Could not apply for bus pass.';
    }
}
?>

<form method="POST">
    Pass Type:
    <select name="pass_type" required>
        <option value="monthly">Monthly</option>
        <option value="quarterly">Quarterly</option>
        <option value="annual">Annual</option>
    </select><br>
    Start Date: <input type="date" name="start_date" required><br>
    End Date: <input type="date" name="end_date" required><br>
    <input type="submit" value="Apply">
</form>
