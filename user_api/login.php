<?php
include_once('./cors.header.php');
require_once('./dbconnect.php');

$json = json_decode(file_get_contents('php://input'));



$email = trim($json->email);
$password = trim($json->password);


if (
    !$email ||
    !$password

) {
    echo json_encode(['status' => false, 'msg' => "Complete every field"]);
    exit();
}

$sql = "SELECT * FROM contributors WHERE email = ?";

$stmt =  $conn->prepare($sql);
$stmt->execute([
    $email,
]);

$result = $stmt->fetch();

if (!$result) {
    http_response_code(401);
    echo json_encode(['status' => false, 'msg' => "Incorrect email or password"]);
    exit();
}

$result = (object)$result;


if (!password_verify($password, $result->password)) {
    http_response_code(401);
    echo json_encode(['status' => false, 'msg' => "Incorrect email or password"]);
    exit();
}


http_response_code(200);
echo json_encode([
    'status' => true,
    'user' => [
        "id" => $result->id,
        "name" => $result->name,
        "email" => $result->email,
        "zone" => $result->zone,
        "isAdmin" => $result->isAdmin
    ]
]);
exit();
