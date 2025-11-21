<?php
    // Process login form submission
    $email  = trim($_POST['email']);
    $username = "";
    $pass   = $_POST['password'];
    $login  = false;

    if (file_exists('LOG.txt')) {
        $lines = file('LOG.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // Find User by email
        foreach ($lines as $line) {
            // split into 3 parts max (email and username and hash)
            $parts = explode("\t", $line, 3);
            if (count($parts) < 3) continue;

            $fileEmail = trim($parts[0]);
            $fileUsername = trim($parts[1]);
            $fileHash  = trim($parts[2]);

            // match email
            if ($email === $fileEmail) {
                // verify password against the hash on the same line
                if (password_verify($pass, $fileHash)) {
                    $login = true;
                }
                break;
            }
        }
    }

    // If login fails, redirect back to login page with error
    if (!$login) {
        echo "<script>alert('Username and/or password did not match.'); window.history.back();</script>";
        exit;
    }
    // If login succeeds, start session and set session variables
    session_start();
    $_SESSION['email'] = $email;
    $_SESSION['username'] = $fileUsername;
    $_SESSION['loggedin'] = true;
    $_SESSION['is_admin'] = ($email === 'm265646@usna.edu') || ($email === 'm260102@usna.edu') || ($email === 'm265112@usna.edu');
    header("Location: .");
    # Add if statement for admin privelages

    setcookie("username", $fileUsername, time() + (86400 * 30), "/");
?>