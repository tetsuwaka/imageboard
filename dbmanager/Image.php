<?php

require_once '../core/DbManager.php';

class imageDB extends DbManager {

    public function getThread($num = 0) {
        $sql = "select * from thread order by date desc limit 5 offset :num";
        return $this->fetchAll($sql, array(':num' => $num));
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

    public function setThread($image, $name) {
        if (empty($name)) {
            $sql = "insert into thread (imageurl) values (:imageurl)";
            $this->execute($sql, array(':imageurl' => $image));
        } else {
            $sql = "insert into thread (imageurl, name) values (:imageurl, :name)";
            $this->execute($sql, array(':imageurl' => $image, ':name' => $name));
        }
    }
    
    public function getThreadNum() {
        $sql = "select id from thread by id desc";
        $numResult = $this->fetch($sql, array(), PDO::FETCH_NUM);
        return $numResult[0];
    }
}