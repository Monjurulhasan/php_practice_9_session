<?php
setcookie('username','Monjur', time()+300, '/cookie/my');
echo $_COOKIE['username'];