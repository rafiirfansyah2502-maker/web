<?php
session_start();
session_destroy(); // hapus session
header("Location: login.php");
exit;
?>