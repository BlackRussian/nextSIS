<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'third_party/PhpWord/Autoloader.php';
\PhpOffice\PhpWord\Autoloader::register();

class Word { 
    
    public $engine = null;

    public function __construct() { 
        $this->engine = new \PhpOffice\PhpWord\PhpWord();
    } 
}