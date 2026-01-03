<?php
session_start();
session_destroy();
session_abort();
$errMsg='لطفا ابتدا وارد شوید';
    header("Location:login.php?errMsg=$errMsg");
?>