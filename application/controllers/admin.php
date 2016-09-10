<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	public $data;
	public $initialization;
	function __construct()
	{
		parent::__construct();			
		$this->initialization['upload']=array(
			'upload_path'=>$_SERVER['DOCUMENT_ROOT'].'/upload/',
			'web_upload_path'=>'/upload/',
			'allowed_types'=>'gif|jpg|png',
			'max_size'=>'10000',
			'encrypt_name'=>TRUE
		);
		$this->load->library('ion_auth');		
		$this->load->library('upload');
		$this->load->helper('url');		
		$this->load->model('admin_model');


		// Load MongoDB library instead of native db driver if required
		// $this->config->item('use_mongodb', 'ion_auth') ?
		// $this->load->library('mongo_db') :

		//$this->load->database();

		//$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		//$this->load->helper('language');
		$this->data['conf']=$this->ava->getMainConfig();		
	}
	
	public function index() {
		redirect('/admin/module/config', 'refresh');
	}

	//log the user in
	function login() {
		$this->load->library('form_validation');
		//validate form input
		$this->form_validation->set_rules('identity', 'identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true)
		{
			//echo "sdf";
			//check to see if the user is logging in
			//check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('/admin/module/config', 'refresh');
			}
			else
			{
				//if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('/admin/login/', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			//echo "no";
			//the user is not logging in so display the login page
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['identity'] = array('name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
			);
            //$this->_render_page('auth/login', $this->data);
            $this->mysmarty->assign("data", $this->data);
			$this->mysmarty->display('admin/login.tpl');
		}
	}
	public function register() {
		if(!$this->ion_auth->logged_in()) {redirect('/admin/login', 'refresh');die;}
		$username=$this->uri->segment(3);
		$password=$this->uri->segment(4);
		$this->ion_auth->register($username,$password,false);
		print_r($this->ion_auth->messages());
	}
	public function logout() {
		$this->ion_auth->logout();
		redirect('/admin/login', 'refresh');
	}

	function init() {
		//if(!$this->ion_auth->logged_in()) {redirect('/admin/login', 'refresh');die;}		
		$this->ava->Init();
	}

	public function module() {
		if(!$this->ion_auth->logged_in()) {redirect('/admin/login', 'refresh');die;}		
		$this->data['module']=$this->uri->segment(3);
		$this->mysmarty->assign("data", $this->data);
		$this->mysmarty->display("admin/index.tpl");
	}
	public function test(){
		$this->mysmarty->display("admin/include_testupload.tpl");
	}	

	public function api_upload() {
		if(!$this->ion_auth->logged_in()) die;
		$action=$this->uri->segment(3);			
		$this->upload->initialize($this->initialization['upload']);	
		$this->load->library('image_lib');
		$response=false;	
		switch($action) {
			case "upload": //загрузка одной картинки
				$module=$this->uri->segment(4);
				$field=$this->uri->segment(5);
				$id=$this->uri->segment(6);				
				if($this->upload->do_upload('userfiles')){
					$file_info=$this->upload->data();					

					//всегда ресайзим до 100px				
					$this->admin_model->resizeImg('h50',$this->initialization['upload']['upload_path'],$file_info['file_name']);
					
					//ресайзим согласно конфигу
					if($this->data['conf']['modules'][$module]['fields'][$field]['resize']){
						foreach($this->data['conf']['modules'][$module]['fields'][$field]['resize'] as $v){							
							$this->admin_model->resizeImg($v,$this->initialization['upload']['upload_path'],$file_info['file_name']);
						}
					}
					//да, пока всегда создаем новую картинку! ))					
					$id= $this->admin_model->addImg($file_info);
					$response['files'][0]=array(
							"name"=>$file_info['file_name'],
						    "size"=>$file_info['file_size'],
						    "thumb"=> $this->initialization['upload']['web_upload_path'].'h50x'.$file_info['file_name'],
						    "url"=> $this->initialization['upload']['web_upload_path'].$file_info['file_name'],
						    "value"=>$id							    				   
						);
				}
				else{
					$response['error']=implode(', ',$this->upload->display_errors());						
				}
			break;
			case "get_img":				
				$img_info=$this->admin_model->getImg($this->uri->segment(4));
				if(count($img_info)){
					$response['files'][0]=array(
							"name"=>$img_info['name'],
						    "size"=>$img_info['size'],
						    "thumb"=> $this->initialization['upload']['web_upload_path'].'h50x'.$img_info['name'],
						    "url"=> $this->initialization['upload']['web_upload_path'].$img_info['name']					   					    				   
							);
				}
				else{
					$response['error']='no image';
				}
			break;
		}
		if(!isset($response['files'][0])) $response['error']='no res';	
		echo json_encode($response);
	}

	public function api() {
		if(!$this->ion_auth->logged_in()) die;
		$action=$this->uri->segment(3);
		$module=$this->uri->segment(4);
		$id=$this->uri->segment(5);
		$response=false;
		//sleep(1);
		switch($action) {
			case "get":
				if($id){ 
					$response['data']=$this->admin_model->getData($module,$id);
				}
				else {
					$response['data']=$this->admin_model->getData($module);
				}
			break;
			case "gettree":
				$response=$this->admin_model->getTreeData($module);
			break;
			case "activate":
				$this->admin_model->activateData($module,$id);
			break;
			case "deactivate":
				$this->admin_model->deactivateData($module,$id);
			break;
			case "resort":
				$this->admin_model->resortData($module,$this->input->post()); 
			case "create":				
				$this->admin_model->createData($module,$this->input->post());
			break;
			case "del":
				$this->admin_model->delData($module,$id);
			break;
			case "quickedit":
				$this->admin_model->quickEditData($module,$this->input->post());
			break;
			case "update":
				if($id) {
					if($this->admin_model->updateData($module,$id,$this->input->post())) {
						$response['msg']='Запись успешно обновлена';
					}
					else {
						$response['error']='Ошибка обновления';
					}					
				}
				else {
					$response['error']='Не указан id';
				}
			break;
			case "get_main_conf":
				$response['data']=$this->ava->getMainConfig();
			break;			
			default:
				$response['data']=$this->admin_model->getData($module);
			break;
		}
		echo json_encode($response);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */