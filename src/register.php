<?php
    // Check if user already exists
    if (file_exists('LOG.txt')) {
        $lines = file("LOG.txt");
        foreach ($lines as $line) {
            $temp = explode("\t", $line);
            foreach ($temp as $val) {
                if ($_POST['email'] == trim($val)) {
                    echo "<script>alert('That email already has an account.'); window.history.back();</script>";
                    exit;
                }
            }
        }
    }

    $lowercase = "/[a-z]/";
    $uppercase = "/[A-Z]/";
    $digits = "/[0-9]/";
    $password = $_POST['password'];

    // Check password strength
    if (!preg_match($uppercase, $password)) {
        echo "<script>alert('Password requires Uppercase'); window.history.back();</script>";
        exit;
    }
    else if (!preg_match($lowercase, $password)) {
        echo "<script>alert('Password requires Lowercase'); window.history.back();</script>";
        exit;
    }
    else if (!preg_match($digits, $password)) {
        echo "<script>alert('Password requires Numbers'); window.history.back();</script>";
        exit;
    }

    // Store email and password
    $f = fopen("LOG.txt", 'a');
    $email = str_replace(array("\n", "\r", "\r\n"), '', trim($_POST['email']));
    $username = str_replace(array("\n", "\r", "\r\n"), '', trim($_POST['username']));
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    fwrite($f, $email);
    fwrite($f, "\t");
    fwrite($f, $username);
    fwrite($f, "\t");
    fwrite($f, $password);
    fwrite($f, "\n");
    fflush($f);
    fclose($f);

    header("Location: ./login.html");
?>