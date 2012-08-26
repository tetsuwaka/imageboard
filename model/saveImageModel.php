<?php

require_once '../core/Model.php';

require_once '../dbmanager/Image.php';

class saveImageModel extends Model {

    protected $dbmanager;

    public function __construct() {
        $this->dbmanager = new imageDB();
        $this->dbmanager->connect(array(
            'dsn' => 'mysql:dbname=imageboard;host=127.0.0.1',
            'user' => 'user',
            'password' => 'pass'
        ));
    }

    public function save($image, $name) {
        $threadnum = $this->dbmanager->getThreadNum() + 1;

        $image = str_replace('data:image/png;base64,', '', $image);
        $fileName = 'img/' . $threadnum . '.png';
        $fp = fopen($fileName, w);
        fwrite($fp,base64_decode($image));
        fp.close();

        $this->dbmanager->setThread($fileName, $name);
    }
}