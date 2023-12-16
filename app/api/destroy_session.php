<?php

    include 'config.php';

    $sql = "UPDATE session_now SET session = NULL WHERE id = '1' ";
    $result = $conn->query($sql);

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        // throw new Exception("Error: " . $sql . "<br>" . $conn->error);
        return false;
    }

?>