<?php
// Start the session to access session variables
session_start();

// Unset all session variables
// This clears all data stored in the $_SESSION array
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session itself
session_destroy();

// Optional: Also clear the "last_username" cookie if you're using it only for welcome back message for logged in users
// If you want it to persist for truly "returning" users (even if not logged in), then skip this.
// For this task, it makes sense to clear it on logout if you want a clean slate.
if (isset($_COOKIE['last_username'])) {
    setcookie('last_username', '', time() - 3600, "/"); // Set expiration to past
}

// Redirect the user to the homepage or login page
header('Location: index.php'); // Or 'login.php' if you prefer them to go back to the login screen
exit(); // Always exit after a header redirect
?>