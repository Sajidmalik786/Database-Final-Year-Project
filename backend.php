<?php
require 'db_config.php';

$table = $_POST['table'] ?? null;
$action = $_POST['action'] ?? null;

if (!$table || !$action) {
    echo json_encode(['error' => 'Invalid request']);
    exit;
}

try {
    switch ($action) {
        case 'insert':
            insertRecord($conn, $table, $_POST);
            break;
        case 'update':
            updateRecord($conn, $table, $_POST);
            break;
        case 'delete':
            deleteRecord($conn, $table, $_POST['id']);
            break;
        case 'fetch':
            fetchRecords($conn, $table);
            break;
        case 'fetchSingle':
            fetchSingleRecord($conn, $table, $_POST['id']);
            break;
        default:
            echo json_encode(['error' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

function insertRecord($conn, $table, $data)
{
    $fields = array_keys($data);
    $placeholders = array_map(fn($field) => ":$field", $fields);
    $sql = "INSERT INTO $table (" . implode(',', $fields) . ") VALUES (" . implode(',', $placeholders) . ")";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
    echo json_encode(['success' => 'Record inserted successfully']);
}

function updateRecord($conn, $table, $data)
{
    $id = $data['id'];
    unset($data['id'], $data['action'], $data['table']);
    $fields = array_keys($data);
    $setClause = implode(',', array_map(fn($field) => "$field = :$field", $fields));
    $sql = "UPDATE $table SET $setClause WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $data['id'] = $id;
    $stmt->execute($data);
    echo json_encode(['success' => 'Record updated successfully']);
}

function deleteRecord($conn, $table, $id)
{
    $sql = "DELETE FROM $table WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    echo json_encode(['success' => 'Record deleted successfully']);
}

function fetchRecords($conn, $table)
{
    $sql = "SELECT * FROM $table";
    $stmt = $conn->query($sql);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function fetchSingleRecord($conn, $table, $id)
{
    $sql = "SELECT * FROM $table WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
}
