<?php

require_once '../core/DbManager.php';

class imageDB extends DbManager {

    public function getThread() {
        $sql = "select * from thread order by date desc";
        return $this->fetchAll($sql);
    }

    public function getCommentsById($threadid) {
        $sql = 'SELECT * from comments where thread = :threadid';
        return $this->fetchAll($sql, array(':threadid' => $threadid));
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

    public function getThreadNum() {
        $sql = "select count(*) from thread";
        $numResult = $this->fetch($sql, array(), PDO::FETCH_NUM);
        return $numResult[0];
    }
}