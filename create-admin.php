<?php
// Create admin user
require 'function/koneksi.php';

$username = 'admin';
$password = password_hash('admin123', PASSWORD_DEFAULT);
$name = 'Administrator';
$noHp = '08123456789';

// Check if admin already exists
$check = query("SELECT * FROM admin WHERE username = '$username'");

if (empty($check)) {
    $insert = query("
        INSERT INTO admin (username, name, password, noHp)
        VALUES ('$username', '$name', '$password', '$noHp')
    ");
    
    if ($insert) {
        echo "✅ Admin user created successfully!<br>";
        echo "Username: admin<br>";
        echo "Password: admin123<br>";
    } else {
        echo "❌ Failed to create admin user.";
    }
} else {
    echo "✅ Admin user already exists!<br>";
    echo "Username: admin<br>";
    echo "Password: admin123<br>";
}

echo "<br><br><a href='auth/login.php'>Go to Login Page</a>";
?>
