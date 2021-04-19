<?php
session_start();
$_SESSION['data'] = 'Hello world';
echo $_SESSION['data'];