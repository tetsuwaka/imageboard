<?php

require_once '../core/DbManager.php';

class imageDB extends DbManager {

    public function getThread($num = 0) {
        $sql = "select * from thread order by date desc limit 5 offset {$num}";
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

    public function setThread($image, $title, $name) {
        if (empty($name)) {
            $sql = "insert into thread (imageurl, title) values (:imageurl, :title)";
            $this->execute($sql, array(':imageurl' => $image, ':title' => $title));
        } else {
            $sql = "insert into thread (imageurl, title, name) values (:imageurl, :title, :name)";
            $this->execute($sql, array(':imageurl' => $image, ':title' => $title, ':name' => $name));
        }
    }
    
    public function getThreadNum() {
        $sql = "select id from thread order by id desc";
        $numResult = $this->fetch($sql, array(), PDO::FETCH_NUM);
        return $numResult[0];
    }
}