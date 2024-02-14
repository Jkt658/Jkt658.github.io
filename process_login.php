<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include 'koneksi.php';

    // Retrieve username and password from POST data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement using prepared statements to prevent SQL injection
    $query = "SELECT id, username, password FROM admin WHERE username=?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    // Check if user exists in the database
    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $id, $db_username, $hashed_password);
        mysqli_stmt_fetch($stmt);

        // Verify password using password_verify
        if (password_verify($password, $hashed_password)) {
            // Login successful, set session variables
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $db_username;
            mysqli_stmt_close($stmt);
            mysqli_close($koneksi);
            header("Location: dashboard.php"); // Redirect to dashboard
            exit();
        } else {
            // Invalid password
            $error_message = "Username or password is incorrect.";
        }
    } else {
        // User not found
        $error_message = "Username or password is incorrect.";
    }

    // Close statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($koneksi);
}

?>
