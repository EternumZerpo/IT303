<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cathehe";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        $response = getData($conn);
        echo json_encode($response);
        break;

    case 'POST':
        $response = createData($conn, $data);
        echo json_encode($response);
        break;

    case 'PUT':
        $response = updateData($conn, $data);
        echo json_encode($response);
        break;

    case 'DELETE':
        $response = deleteData($conn, $data);
        echo json_encode($response);
        break;

    default:
        echo json_encode(['message' => 'Method not supported']);
        break;
}

$conn->close();

function getData($conn) {
    $sql = "SELECT * FROM pet_info_tbl";
    $result = $conn->query($sql);

    $data = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

function createData($conn, $data) {
    $stmt = $conn->prepare("INSERT INTO pet_info_tbl (name, breed, age) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $data['name'], $data['breed'], $data['age']);

    if ($stmt->execute()) {
        return ['message' => 'Data created successfully'];
    } else {
        return ['message' => 'Error: ' . $stmt->error];
    }
}

function updateData($conn, $data) {
    $stmt = $conn->prepare("UPDATE pet_info_tbl SET name = ?, breed = ?, age = ? WHERE id = ?");
    $stmt->bind_param("ssii", $data['name'], $data['breed'], $data['age'], $data['id']);

    if ($stmt->execute()) {
        return ['message' => 'Data updated successfully'];
    } else {
        return ['message' => 'Error: ' . $stmt->error];
    }
}

function deleteData($conn, $data) {
    $stmt = $conn->prepare("DELETE FROM pet_info_tbl WHERE id = ?");
    $stmt->bind_param("i", $data['id']);

    if ($stmt->execute()) {
        return ['message' => 'Data deleted successfully'];
    } else {
        return ['message' => 'Error: ' . $stmt->error];
    }
}
?>