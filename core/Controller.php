<?php

require_once '../core/View.php';

/**
 *
 * @author tetsuwaka
 */
abstract class Controller extends Model {
    protected $session;
    protected $_view;

    public function __construct() {
        session_start();
        session_regenerate_id(true);
        $this->_view = new View();
    }

    public function isPost() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return true;
        }
        return false;
    }

    public function getGet($name, $default = null) {
        if (isset($_GET[$name])) {
            return $_GET[$name];
        }
        return $default;
    }

    public function getPost($name, $default = null) {
        if (isset($_POST[$name])) {
            return $_POST[$name];
        }
        return $default;
    }

    public function getHost() {
        if (!empty($_SERVER['HTTP_HOST'])) {
            return $_SERVER['HTTP_HOST'];
        }
        return $_SERVER['SERVER_NAME'];
    }

    function mkTicket() {
        return sha1(uniqid() . mt_rand());
    }
    
    function setSession($name, $value = null) {
        $_SESSION[$name] = $value;
    }
    
    function getSession($name) {
        if (isset($_SESSION[$name])) {
            return $name;
        } else {
            return null;
        }
    }
    
    function isAccept() {
        if (!isset($_POST['ticket'], $_SESSION['ticket'])) {
            return false;
        }
        if ($_POST['ticket'] === $_SESSION['ticket']) {
            return true;
        } else {
            return false;
        }
    }
    
    abstract public function control(); 
    
}


