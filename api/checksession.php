<?php
session_start();
header("Content-Type: application/json");

if (!empty($_SESSION)) {
    echo json_encode(['success' => true, 'session' => $_SESSION]);
} else {
    echo json_encode(['success' => false, 'message' => 'No session found']);
}
?>
