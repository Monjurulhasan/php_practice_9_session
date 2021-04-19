<?php
session_name('ourapp');
session_start([
    'cookie_domain'=>'.localhost:9090',
    'cookie_path'=>'/'
]);
$_SESSION['data2'] = 'hello earth';
echo $_SESSION['data2'];