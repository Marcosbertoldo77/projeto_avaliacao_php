<?php

// Usage: php scripts/create_seed_user.php "Name" "email@example.com" "password"

require_once __DIR__ . '/../app/core/Database.php';

if ($argc < 4) {
    echo "Usage: php scripts/create_seed_user.php \"Name\" \"email@example.com\" \"password\"\n";
    exit(1);
}

$name = $argv[1];
$email = $argv[2];
$password = $argv[3];

try {
    $db = (new Database())->connect();

    // Check if user already exists
    $stmt = $db->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
    $stmt->execute(['email' => $email]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        echo "A user with email {$email} already exists with id: " . $existing['id'] . PHP_EOL;
        exit(0);
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $insert = $db->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
    $insert->execute([
        'name' => $name,
        'email' => $email,
        'password' => $hash
    ]);

    $id = (int)$db->lastInsertId();
    echo "Inserted user id: {$id} with email: {$email}\n";
    echo "Password hash used: {$hash}\n";
    echo "You can now login with the provided credentials.\n";

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . PHP_EOL;
    exit(2);
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
    exit(3);
}
