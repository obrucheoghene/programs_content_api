<?php
include_once('./cors.header.php');
require_once('./dbconnect.php');


if (isset($_GET["programId"])) {
    $programId = $_GET["programId"];
    $sql = "SELECT * FROM programs WHERE id=?";
    $stmt =  $conn->prepare($sql);
    $stmt->execute([$programId]);
    $results = $stmt->fetch();
} else {
    $sql = "SELECT * FROM programs order by id DESC";
    $stmt =  $conn->prepare($sql);
    $stmt->execute([]);
    $results = $stmt->fetchAll();
}


http_response_code(200);
echo json_encode($results);

exit();
