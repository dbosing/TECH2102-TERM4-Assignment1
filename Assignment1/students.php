<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");


include 'connection.php';

$method = $_SERVER['REQUEST_METHOD'];
if ($method == "GET") {
    if (isset($_GET['id'])) {
        get_student($_GET['id']);
    } else {
        get_students();
    }
} elseif ($method == "POST") {
    insert_student();
} else {
    echo json_encode(["message" => "Invalid request method"]);
}

function get_students()
{
    global $conn;
    $sql = "SELECT * FROM student";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $students = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $students[] = $row;
        }
        echo json_encode($students);
    } else {
        echo json_encode(["message" => "No students found"]);
    }
}

function get_student($id)
{
    global $conn;
    $sql = "SELECT * FROM students WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        echo json_encode(["message" => "Student not found"]);
    }
}

function insert_student()
{
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data["student_name"]) && isset($data["student_number"]) && isset($data["student_age"])) {
        $sql = "INSERT INTO student (student_name, student_number, student_age) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $data["student_name"], $data["student_number"], $data["student_age"]);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["message" => "Student inserted successfully"]);
        } else {
            echo json_encode(["message" => "Failed to insert student"]);
        }
    } else {
        echo json_encode(["message" => "Invalid input"]);
    }
}


?>
