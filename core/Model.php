<?php

/**
 *
 * @author tetsuwaka
 */
class Model {
    
    protected $_controller;
    
    public function __construct($con = null) {
        $this->_controller = $con;
    }
}

