<?php
session_start();
session_destroy();
header("Location: cms_login.php");
exit;