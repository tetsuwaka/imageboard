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

    protected function getImageList($num) {
        if (empty($num)) {
            $imagelist = $this->dbmanager->getThread();
        } else {
            $imagelist = $this->dbmanager->getThread($num * 5);
        }
        for ($i = 0; $i < count($imagelist); $i++) {
            $imagelist[$i]['comments'] = $this->dbmanager->getCommentsById($imagelist[$i]['id']);
        }
        return $imagelist;
    }

    public function getParams($num) {
        $imagelist = $this->getImageList($num);
        return array('imagelist' => $imagelist);
    }
}
