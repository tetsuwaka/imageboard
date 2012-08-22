<?php

require_once '../core/Model.php';

require_once '../dbmanager/Image.php';

class indexModel extends Model {

    protected $dbmanager;

    public function __construct() {
        $this->dbmanager = new imageDB();
        $this->dbmanager->connect(array(
            'dsn' => 'mysql:dbname=imageboard;host=127.0.0.1',
            'user' => 'user',
            'password' => 'pass'
        ));
    }

    protected function getImageList() {
        $sql = 'SELECT * from thread';
        $imagelist = $this->dbmanager->fetchAll($sql);
        for ($i = 0; $i < count($imagelist); $i++) {
            $sql = 'SELECT * from comments where thread = :threadid';
            $imagelist[$i]['comments'] = $this->dbmanager->fetchAll($sql, array(':threadid' => $imagelist[$i]['id']));
        }
        return $imagelist;
    }

    public function getParams() {
        $imagelist = $this->getImageList();
        return array('imagelist' => $imagelist);
    }
}
