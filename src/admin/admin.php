<?php
// Ensure Admin is Logged In
session_start();
if ($_SESSION['is_admin'] == false) {
    header("Location: ../index.php");
    exit;
}


$file = '../LOG.txt';

// Read users from LOG.txt
function readUsersFromFile($file) {
    $users = [];
    if (file_exists($file)) {
        $lines = file($file, FILE_IGNORE_NEW_LINES);
        
        foreach ($lines as $line) {
            $userData = explode("\t", $line);
            if (count($userData) === 3) {
                $users[] = [
                    'email' => $userData[0],
                    'username' => $userData[1],
                    'password' => $userData[2]
                ];
            }
        }
    }
    return $users;
}

// Rewrite LOG.txt after deletion
function saveUsersToFile($file, $users) {
    $fileContent = '';
    foreach ($users as $user) {
        $fileContent .= implode("\t", $user) . "\n";
    }
    file_put_contents($file, $fileContent);
}

// Handle deletion request
if (isset($_GET['delete'])) {
    $deleteIndex = (int)$_GET['delete'];
    $users = readUsersFromFile($file);
    
    if (isset($users[$deleteIndex])) {
        array_splice($users, $deleteIndex, 1);
        saveUsersToFile($file, $users);
    }
}
// Load users for display
$users = readUsersFromFile($file);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 8px 12px;
            text-align: left;
        }
        .button {
            padding: 8px 12px;
            background-color: red;
            color: white;
            border: none;
        }
    </style>
</head>
<body>

    <h1>User Management</h1>
    <table>
        <thead>
            <tr>
                <th>Email</th>
                <th>Username</th>
                <th>Password</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Display users -->
            <?php if (count($users) > 0): ?>
                <?php foreach ($users as $index => $user): ?>
                    <tr>
                        <!-- User data -->
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['password']; ?></td>
                        <!-- Delete button, makes Get request -->
                        <td><a href="?delete=<?php echo $index; ?>"><button class="button">Delete</button></a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
