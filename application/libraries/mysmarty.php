<?php
require_once "smarty/Smarty.class.php";
class Mysmarty extends Smarty {

function __construct() {
parent::__construct();
$this->template_dir = "application/tpl/";
$this->compile_dir  = "application/tpl_c/";
}
}
?>