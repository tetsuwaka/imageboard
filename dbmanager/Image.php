<?php

require_once '../core/DbManager.php';

class imageDB extends DbManager {

    public function getThread() {
        $sql = "select * from bbs order by date desc";
        return $this->fetchAll($sql);
    }

    public function setComment($comment, $threadid, $name) {
        if (empty($name)) {
            $sql = "insert into comments (comment, thread) values (:comment, :threadid)";
            $this->execute($sql, array(':comment' => $comment, ':threadid' => $threadid));
        } else {
            $sql = "insert into comments (comment, thread, name) values (:comment, :threadid, :name)";
            $this->execute($sql, array(':comment' => $comment, ':threadid' => $threadid, ':name' => $name));
        }
    }
}