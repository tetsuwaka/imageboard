<?php

require_once '../core/Model.php';

/**
 *
 * @author tetsuwaka
 */
class DbManager extends Model {

    protected $connection;

    public function connect($params) {
        $params = array_merge(array(
            'dsn'      => null,
            'user'     => '',
            'password' => '',
            'options'  => array(),
        ), $params);

        $con = new PDO(
            $params['dsn'],
            $params['user'],
            $params['password'],
            $params['options']
        );

        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->connection = $con;
    }

    public function getConnection() {
        return $this->connection;
    }

    public function execute($sql, $params = array()) {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetch($sql, $params = array(), $option = PDO::FETCH_ASSOC) {
        return $this->execute($sql, $params)->fetch($option);
    }

    public function fetchAll($sql, $params = array(), $option = PDO::FETCH_ASSOC) {
        return $this->execute($sql, $params)->fetchAll($option);
    }
}

