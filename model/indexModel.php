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
        $imagelist = $this->dbmanager->getThread();
        for ($i = 0; $i < count($imagelist); $i++) {
            $imagelist[$i]['comments'] = $this->dbmanager->getCommentsById($imagelist[$i]['id']);
        }
        return $imagelist;
    }

    public function getParams() {
        $imagelist = $this->getImageList();
        return array('imagelist' => $imagelist);
    }
}
