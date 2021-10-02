<?php

require '_protected.php';

$name = "";
if (isset($_SESSION['name'])) {
    $name = $_SESSION['name'];	
} else {
    $name = "-";
}

?>

<div class="container">
  <nav class="nav">
    <a class="nav-link" href="admin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a class="nav-link disabled" href="#"><i class="fas fa-server"></i> <?php echo $name; ?></a>
    <a class="nav-link" href="console.php"><i class="fas fa-terminal"></i> Console</a>
    <a class="nav-link" href="files.php"><i class="fas fa-archive"></i> Files</a>
    <a class="nav-link" href="settings.php"><i class="fas fa-cogs"></i> Settings</a>
    <a class="nav-link" href="backup.php"><i class="fas fa-box"></i> Backup</a>
    <a class="nav-link" href="register.php"><i class="fas fa-users"></i> Users</a>
    <a class="nav-link" href="_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </nav>
</div>