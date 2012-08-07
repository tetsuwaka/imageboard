<?php

/**
 *
 * @author tetsuwaka
 */
abstract class Controller extends Model {
    protected $session;
    
    public function __construct() {
    }
    
    // 実装時に指定する
    abstract protected function getRoutes();

}


