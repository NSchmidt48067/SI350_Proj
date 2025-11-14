<?php

    $email  = trim($_POST['email']);
    $username = "";
    $pass   = $_POST['password'];
    $login  = false;

    if (file_exists('LOG.txt')) {
        $lines = file('LOG.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

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


    if (!$login) {
        echo "<script>alert('Username and/or password did not match.'); window.history.back();</script>";
        exit;
    }
    session_start();
    $_SESSION['email'] = $email;
    $_SESSION['username'] = $fileUsername;
    $_SESSION['loggedin'] = true;
    header("Location: .");
    # Add if statement for admin privelages

    setcookie("username", $fileUsername, time() + (86400 * 30), "/");
?>