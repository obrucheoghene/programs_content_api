<?php
include_once('./cors.header.php');
require_once('./dbconnect.php');


if (!isset($_GET['programId']) && !isset($_GET['userId']) && !isset($_GET['contentId'])) {
    http_response_code(400);
    echo json_encode(['status' => false, 'msg' => "Bad request"]);
    exit();
}

if (isset($_GET['contentId'])) {
    $contentId = $_GET['contentId'];

    $sql = "SELECT a.id, b.name contentType, 
    a.topic, a.synopsisText, a.subConference, 
    a.updatedAt FROM contents a INNER JOIN 
    contentTypes b WHERE a.id =? AND 
    a.contentTypeId = b.id order by a.id DESC";

    $stmt =  $conn->prepare($sql);
    $stmt->execute([$contentId]);
    $result = $stmt->fetch();
} else {
    $userId = $_GET['userId'];
    $programId = $_GET['programId'];

    $sql = "SELECT a.id, b.name contentType,
    a.topic, a.synopsisText, a.subConference,
    a.updatedAt FROM contents a INNER JOIN 
    contentTypes b WHERE contributorId=? 
    AND programId=? AND a.contentTypeId = b.id 
    order by a.id DESC";

    $stmt =  $conn->prepare($sql);
    $stmt->execute([$userId, $programId]);
    $result = $stmt->fetchAll();
}



http_response_code(200);
echo json_encode($result);

exit();
