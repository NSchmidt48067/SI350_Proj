<?php

    $email  = trim($_POST['email']);
    $pass   = $_POST['password'];
    $login  = false;

    if (file_exists('LOG.txt')) {
        $lines = file('LOG.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // split into two parts max (username and hash)
            $parts = explode("\t", $line, 2);
            if (count($parts) < 2) continue;

            $fileEmail = trim($parts[0]);
            $fileHash  = trim($parts[1]);

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
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['loggedin'] = true
    echo $_SESSION['email'];
    session_unset();
    //header("Location: https://midn.cs.usna.edu/~m265646/SI350/Lab07/requestReport.php");
?>