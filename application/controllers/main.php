<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');		
		$this->load->model('admin_model');
	
	}
	public function index()
	{
		$data=false;
		$this->mysmarty->assign("data", $data);
		$this->mysmarty->display("index.tpl");
	}
}
?>