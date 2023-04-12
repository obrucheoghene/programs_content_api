<?php
include_once('./cors.header.php');
require_once('./dbconnect.php');


if (isset($_GET["programTypeId"])) {
    $programTypeId = $_GET["programTypeId"];
    $sql = "SELECT * FROM contentTypes WHERE programTypeId=?";
    $stmt =  $conn->prepare($sql);
    $stmt->execute([$programTypeId]);
    $results = $stmt->fetchAll();
} else {
    $sql = "SELECT * FROM contentTypes";
    $stmt =  $conn->prepare($sql);
    $stmt->execute([]);
    $results = $stmt->fetchAll();
}

http_response_code(200);
echo json_encode($results);
exit();
