<?php

require_once '../core/Model.php';

/**
 *
 * @author tetsuwaka
 */
class View extends Model{

    public function escape($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    public function render($path, $variables) {
        extract($variables);

        ob_start();
        ob_implicit_flush(0);

        require $path;

        $content = ob_get_clean();

        return $content;
    }

}