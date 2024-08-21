
<?php
header('Content-Typee: application/json');

    $response = array("method" => $_SERVER ['REQUEST_METHOD']);
    echo json_encode($response);
?>