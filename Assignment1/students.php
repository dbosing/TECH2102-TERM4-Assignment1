<?php
include 'connection.php';


function get_students() {
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM student");
    $students = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($students);
}

function add_student() {
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true);

    $name = mysqli_real_escape_string($conn, $data['student_name']);
    $number = mysqli_real_escape_string($conn, $data['student_number']);
    $age = mysqli_real_escape_string($conn, $data['student_age']);

    $sql = "INSERT INTO student (student_name, student_number, student_age) VALUES ('$name', '$number', $age)";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["status" => "success", "message" => "Student added"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}

function update_student($id, $name, $number, $age)
{
    global $conn;
    $sql = "UPDATE student SET student_name=?, student_number=?, student_age=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssii", $name, $number, $age, $id);

    if (mysqli_stmt_execute($stmt)) {
        return "Student updated successfully.";
    } else {
        return "Error updating student: " . mysqli_error($conn);
    }
}

function delete_student($id)
{
    global $conn;
    $sql = "DELETE FROM student WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        return "Student deleted successfully.";
    } else {
        return "Error deleting student: " . mysqli_error($conn);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["action"])) {
        if ($_POST["action"] == "update") {
            echo update_student($_POST["id"], $_POST["name"], $_POST["number"], $_POST["age"]);
        } elseif ($_POST["action"] == "delete") {
            echo delete_student($_POST["id"]);
        }
    }
}
?>
