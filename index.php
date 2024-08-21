<?php
header('Content-Typee: application/json');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $response = array("method" => "POST");
    echo json_encode($response);
    return;
}
$response = array("method" => "GET", "data" => $_Get, "headers" => getalheaders());

echo json_encode($response);
?>
