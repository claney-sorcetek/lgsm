<?php
session_start();

require '_protected.php';

$name = $_GET['name'];
if (isset($name)) {
    $_SESSION['name'] = $name;
    header("Location: console.php");
} else {
    header("Location: admin.php");
}