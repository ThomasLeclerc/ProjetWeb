<?php
require_once 'include/engine.php';

session_unset();
session_destroy();

REDIRECT('login.php');
?>
