<?php

require_once '../core/DbManager.php';

class imageDB extends DbManager {
    
    public function getThread() {
        $sql = "select * from bbs order by date desc";
        return $this->fetchAll($sql);
    }

}