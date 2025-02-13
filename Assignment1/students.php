<?php
include 'connection.php';

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
