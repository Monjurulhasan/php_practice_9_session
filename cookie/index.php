<?php
// setcookie('data','Hello World', time()+300);
// setrawcookie('data2', rawurlencode('hello world'), time()+300);
// setcookie('array', array(1, 'Monjur'), time()+300);
setcookie('array', serialize(array('id'=>1, 'name'=>'Monjur')), time()+300);
// setcookie('array', array('id'=>1, 'name'=>'Monjur'), time()+300);
setcookie("array[id]", 1, time()+300);
setcookie("array[name]", 'Monjur', time()+300);
// echo $_COOKIE['data'];

foreach (unserialize($_COOKIE['array']) as $key => $value) {
    echo $key." = ". $value. "<br>";
}
?>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>
<script>
    alert(Cookies.get('data2'));
</script>