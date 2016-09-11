<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Ava {

	public $tbl_prefix='ava_';
	public $CI;
	public $main_config;

	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->config->load('admin');
		$this->main_config['modules'] = $this->CI->config->item('ava::modules');	
	}

	public function Init() {
 
        $this->printBlock("Создание таблиц:");
        $this->createTables();
        
        $this->printBlock("Добавление новых полей в таблицы:");
        $this->updateTables();
        
        $this->printBlock("Создание системных таблиц авторизации, если отсутствуют");
        $this->createAuthTables(); //создаем таблицы для auth_ion
    }

    public function getRows($module,$params=array()){ //вытаскиваем выборку по даданным условия
        /*   
        $params['with_images'] - загружать с картинками
        */
        if(!$module) return false;
        
        $q=$this->CI->db->query("
            SELECT 
            * 
            FROM ".$this->tbl_prefix.$module."
            ORDER BY `ord`
            ");
        $res=$q->result_array();
        if(isset($params['with_images']) && $params['with_images']){           
            if(count($res)){
                foreach($res as $k=>$v){//пробегаем по всем записям выборки
                    foreach($v as $k2=>$v2){//пробегаем по всем полям каждой записи
                        if(isset($this->main_config['modules'][$module]['fields'][$k2]['type']) && $this->main_config['modules'][$module]['fields'][$k2]['type']=='img'){
                            $res[$k][$k2]=$this->getImg($v2);
                        }
                    }
                }
            }
        }
        return $res;
    }

    public function getRow(){
        return 1;
    }

    public function getConfigs($module){
        $res=$this->getRows($module);
        $configs=array();
        if(!count($res)) return false;
        foreach($res as $k=>$v){
            $configs[$v['ident']]=$v['value'];
        }
        return $configs;
    }

    public function getImg($id){
        if(!$id) return false;
        $q=$this->CI->db->query("
            SELECT 
            * 
            FROM ava_files
            WHERE id = ".(int)$id);
        return $q->row_array();
    }

    public function e($var){ //функция вывода на экран дебаговой инфы
        echo "<pre>";
        print_r($var);
        echo "</pre>";
    }

    private function createTables() {       
    	foreach($this->main_config['modules'] as $k=>$v) {
    		$strCreateQuery="
                CREATE TABLE IF NOT EXISTS `".$this->tbl_prefix.$k."` (
				  `id` int(11) unsigned NOT NULL auto_increment,
				  `parent` int(11) unsigned NOT NULL default '0',
				  `ord` int(11) unsigned NOT NULL default '0',
				  `check_active` tinyint(1) unsigned NOT NULL default '1',
				  `check_end` tinyint(1) unsigned NOT NULL default '0',
                  `meta_t`  varchar(255) NOT NULL default '',
                  `meta_d`  TEXT NOT NULL default '',
                  `meta_k`  varchar(255) NOT NULL default '',
                  `time_created`  DATETIME,
                  `time_updated`  DATETIME,
				  `name` varchar(255) NOT NULL default '',";

			foreach($v['fields'] as $f_name=>$f) {
				$strCreateQuery.="`".$f_name."` ".$this->convert2sqlFieldType($f)." ,";	
			}

			$strCreateQuery.="PRIMARY KEY  (`id`),
				  KEY `parent` (`parent`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;";	  
    		
    		//echo "<br>".$strCreateQuery;
    		$this->CI->db->query($strCreateQuery);
            $this->printElm($strCreateQuery);	
    	}
        //создаем таблицу для картинок
        $strCreateQuery="CREATE TABLE IF NOT EXISTS `".$this->tbl_prefix."files` (
            `id` int(11) unsigned NOT NULL auto_increment,
            `uid` int(11) unsigned NOT NULL default '0',
            `ord` int(11) unsigned NOT NULL default '0',                 
            `name` varchar(255) NOT NULL default '',
            `title` varchar(255) NOT NULL default '',
            `size` varchar(255) NOT NULL default '',
            PRIMARY KEY  (`id`),
                  KEY `parent` (`uid`)
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
            ";
        $this->CI->db->query($strCreateQuery);
        $this->printElm($strCreateQuery);    
    }

    //добавляет в таблицы новые поля, если они появятся в конфиге. Старые пока не удаляются
    private function updateTables() { 
      echo "<b>Добавление колонок в таблицы.</b>";
        //$system_tables_array=array('id','parent','ord','check_active','check_end','name');
    	foreach($this->main_config['modules'] as $k=>$v) {
            $arrAlterQuery=array(); //массив sql полей на добавление
            //вытаскиваем список существующиз полей этого модуля в БД
            $q=$this->CI->db->query("SHOW FIELDS FROM `".$this->tbl_prefix.$k."`");
            foreach($q->result_array() as $v2) {
                $fields[]=$v2['Field'];
            }
            $f_name_buffer='';
            $this->printElm($v['fields'],"v[\'fields\']");
            $this->printElm($fields,"fields");
            foreach($v['fields'] as $f_name=>$f) {
                //предыдущее поле.наобходимо для правильного заполнения ALTER TABLE
                if($f_name_buffer=='')$f_name_buffer='name';
                //если поле из конфига отстствует в БД надо его добавить
                if(!in_array($f_name,$fields)) {
                    $arrAlterQuery[]='ADD COLUMN `'.$f_name.'` '.$this->convert2sqlFieldType($f).' AFTER `'.$f_name_buffer.'`';
                }
                $f_name_buffer=$f_name;
            }
            //если поля над обавление имеются - формируем sql
            if(count($arrAlterQuery)) {
                $strAlterQuery="ALTER TABLE `".$this->tbl_prefix.$k."` ".implode(', ',$arrAlterQuery);
                //echo "<br>".$strAlterQuery;
                $this->CI->db->query($strAlterQuery); 

                $this->printElm("Добавлено ".count($arrAlterQuery)." колонок в таблицу " .$this->tbl_prefix.$k); 
                $this->printElm($strAlterQuery);
            }
            else{
                 $this->printElm("Изменений не найдено!");
            }
        }
        
    }

    private function createAuthTables(){
        $strCreateQuery="CREATE TABLE  IF NOT EXISTS `ava_sys_groups` (
                          `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
                          `name` varchar(20) NOT NULL,
                          `description` varchar(100) NOT NULL,
                          PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->CI->db->query($strCreateQuery);
        $strCreateQuery="CREATE TABLE IF NOT EXISTS `ava_sys_users` (
                          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                          `ip_address` varchar(15) NOT NULL,
                          `username` varchar(100) NOT NULL,
                          `password` varchar(255) NOT NULL,
                          `salt` varchar(255) DEFAULT NULL,
                          `email` varchar(100) DEFAULT NULL,
                          `activation_code` varchar(40) DEFAULT NULL,
                          `forgotten_password_code` varchar(40) DEFAULT NULL,
                          `forgotten_password_time` int(11) unsigned DEFAULT NULL,
                          `remember_code` varchar(40) DEFAULT NULL,
                          `created_on` int(11) unsigned NOT NULL,
                          `last_login` int(11) unsigned DEFAULT NULL,
                          `active` tinyint(1) unsigned DEFAULT NULL,
                          `first_name` varchar(50) DEFAULT NULL,
                          `last_name` varchar(50) DEFAULT NULL,
                          `company` varchar(100) DEFAULT NULL,
                          `phone` varchar(20) DEFAULT NULL,
                          PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                        ";
        $this->CI->db->query($strCreateQuery); 
        $strCreateQuery="CREATE TABLE  IF NOT EXISTS  `ava_sys_users_groups` (
                          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                          `user_id` int(11) unsigned NOT NULL,
                          `group_id` mediumint(8) unsigned NOT NULL,
                          PRIMARY KEY (`id`),
                          KEY `fk_users_groups_users1_idx` (`user_id`),
                          KEY `fk_users_groups_groups1_idx` (`group_id`),
                          CONSTRAINT `uc_users_groups` UNIQUE (`user_id`, `group_id`),
                          CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `ava_sys_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
                          CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `ava_sys_groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->CI->db->query($strCreateQuery); 
        $strCreateQuery="CREATE TABLE  IF NOT EXISTS  `ava_sys_login_attempts` (
                          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                          `ip_address` varchar(15) NOT NULL,
                          `login` varchar(100) NOT NULL,
                          `time` int(11) unsigned DEFAULT NULL,
                          PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->CI->db->query($strCreateQuery); 
        if(!$this->CI->db->count_all('ava_sys_groups')){           
            $this->CI->db->query("INSERT INTO `ava_sys_groups` (`id`, `name`, `description`) VALUES
                                     (1,'admin','Administrator'),
                                     (2,'members','General User');");
        }
        if(!$this->CI->db->count_all('ava_sys_users')){           
            $this->CI->db->query("INSERT INTO `ava_sys_users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
                                    ('1','127.0.0.1','administrator','".'$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36'."','','admin@admin.com','',NULL,'1268889823','1268889823','1', 'Admin','istrator','ADMIN','0');
                                    ");
        } 
        if(!$this->CI->db->count_all('ava_sys_users_groups')){           
            $this->CI->db->query("INSERT INTO `ava_sys_users_groups` (`id`, `user_id`, `group_id`) VALUES
                 (1,1,1),
                 (2,1,2);");
        }               
    }

    private function convert2sqlFieldType($field) {
    	if(!isset($field["type"])) {
    		$field["type"]='text';
    	}
    	switch($field["type"]) {
    		case "text":
    		    return "varchar(".(isset($field['length'])?(int)$field['length']:"255").") NOT NULL default ''";                
    		case "textarea":
    		    return "text NOT NULL default ''"; 
        case "wysiwyg":
            return "text NOT NULL default ''";                  
    		case "img":
    		    return "varchar(255) NOT NULL default ''";
            case "check":
                return "INT NOT NULL default '0'";
    		default: 
    		    return "varchar(255) NOT NULL default ''";
    	}
    } 

    public function getMainConfig() {
        return $this->main_config;
    }

    public function getTblPrefix() {
        return $this->tbl_prefix;
    }

    public function prepareCheck($data,$module=false) {
        if(!is_array($data) || !count($data) || !$module) return false;
        foreach($data as $k=>$v) {
            if(isset($this->main_config['modules'][$module]['fields'][$k]['type']) && $this->main_config['modules'][$module]['fields'][$k]['type']=='check') {
                $data[$k]=($v=='on')?1:0;
            }
        }
        return $data;
    }

    public function show($obj){
        if(is_array($obj))$obj=print_r($obj,true);
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/show.txt',$obj);
    }
    private function printBlock($s){
        echo "<h2>".$s."</h2>";
    }
    private function printElm($s,$h=false){
        if(is_array($s)){
            if($h) echo "<b>[".$h." /]</b>";
            echo "<pre>";
            print_r($s);
            echo "</pre>";
            if($h) echo "<b>[/".$h."]</b>";
        }
        else
            echo "<p>".$s."</p>";
    }    
}
