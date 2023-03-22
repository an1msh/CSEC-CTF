<?php
session_start();
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (ctype_alnum($username)) {
        $sql = "SELECT id FROM users WHERE username = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $username);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 0) {
                    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
                    if ($stmt = $mysqli->prepare($sql)) {
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        $stmt->bind_param("ss", $username, $hashed_password);
                        if ($stmt->execute()) {
                            mkdir("../uploads/" . $username);
                            echo "success";
                        } else {
                            echo "Something went wrong. Please try again later.";
                        }
                    }
                } else {
                    echo "Username already taken. Please choose a different one.";
                }
            }
            $stmt->close();
        }
    } else {
        echo "Only alphabets and numerical characters are allowed for the username.";
    }
    $mysqli->close();
}
?>

