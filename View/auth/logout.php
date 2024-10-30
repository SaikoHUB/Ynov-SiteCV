<?php
session_start();
session_destroy();
header("Location: /../View/auth/login.php");
exit;
?>