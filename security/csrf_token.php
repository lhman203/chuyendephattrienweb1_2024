<?php
    // Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Generate a CSRF token if not already present
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate a random 32-character token
}

// Function to get the CSRF token
function getCsrfToken() {
    return $_SESSION['csrf_token'];
}
?>