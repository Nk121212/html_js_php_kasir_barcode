<?php
    // Get the current URL
$currentURL = "http" . (isset($_SERVER['HTTPS']) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// Output the current URL
// echo "Current URL: " . $currentURL
header("Location: $currentURL/app");

// Make sure that code below the header function is not executed
exit();

?>