<?php
function config($option){
    $options = explode('.',$option);
    $res = file_get_contents(BASE_PATH . '/config/' . $options[0] . '.php');
    var_dump($res);
}
