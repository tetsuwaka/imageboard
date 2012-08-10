<?php

require_once '../core/Model.php';

class indexModel extends Model {
    function getParams() {
        return array('hoge' => 'hogehoge');
    }
}