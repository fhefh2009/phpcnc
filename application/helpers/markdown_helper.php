<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


require_once dirname(__FILE__) . '/../third_party/PHP_Markdown_Lib_1.2.7/Michelf/Markdown.php';
use \Michelf\Markdown;

function markdown($markdown_text){
    $html = Markdown::defaultTransform($markdown_text);
    return $html;
}


