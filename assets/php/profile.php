<?php
require_once("mongo_connect.php");
require_once("db_connect.php");

$email = $_POST['email'] ?? '';
$action = $_POST['action'] ?? '';

if ($action === 'get') {
    $user = $profilesCollection->findOne(['email' => $email]);
    if ($user) {
        echo json_encode([
            'status' => 'success',
            'profile' => [
                'name' => $user['name'] ?? '',
                'email' => $user['email'] ?? '',
                'age' => $user['age'] ?? '',
                'dob' => $user['dob'] ?? '',
                'contact' => $user['contact'] ?? ''
            ]
        ]);
    } else {
        
        $stmt = $pdo->prepare("SELECT name FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $mysqlUser = $stmt->fetch();
        echo json_encode([
            'status' => 'success',
            'profile' => [
                'name' => $mysqlUser['name'],
                'email' => $email,
                'age' => '',
                'dob' => '',
                'contact' => ''
            ]
        ]);
    }
} elseif ($action === 'update') {
    $profilesCollection->updateOne(
        ['email' => $email],
        ['$set' => [
            'age' => $_POST['age'] ?? '',
            'dob' => $_POST['dob'] ?? '',
            'contact' => $_POST['contact'] ?? ''
        ]],
        ['upsert' => true]
    );
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'invalid_action']);
}