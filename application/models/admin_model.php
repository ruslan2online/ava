<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Admin_model extends CI_Model {

	public function __construct() {
		parent::__construct();		
        $this->load->library('ava');
	}

    public function getTblPrefix(){
        return $this->ava->getTblPrefix();
    }
    public function getData($module=false,$id=false){
        if(!$module) return false;
        if(!$id){ //echo "net id";
            $q=$this->db->query("SELECT 
            * 
            FROM ".$this->ava->getTblPrefix().$module);
            return $q->result_array();
        }
        else{ 
            $q=$this->db->query("SELECT 
            * 
            FROM ".$this->ava->getTblPrefix().$module."
            WHERE id = ".(int)$id);
            return $q->row_array();
        }
        
    }
    public function getMaxSortIndexByParent($module=false,$parent=false){ //вытаскиваем максимальный индекс сортировки
        if(!$module) return false;
        $q=$this->db->query("SELECT 
        MAX(ord) as max_ord
        FROM ".$this->ava->getTblPrefix().$module."
        WHERE parent='".$parent."'
        ");
        $r=$q->row_array();
        $this->ava->show($r);
        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/upload/test.txt',print_r($r,true));  
        //log_message('info',print_r($r,true));      
        return $r['max_ord'];
    }
    public function getNextSortIndexByParent($module=false,$parent=false){ // возсращает следующий индекс сортировки
        $index=$this->getMaxSortIndexByParent($module,$parent);
        // $range=10000; //на сколько отличаются индексы сортировки
        // if($index<$range)return $range;
        // $index=intval($index/$range);
        // return (++$index)*$range;
        return ++$index;
    }
    public function getTreeData($module=false,$parent=false){
        if(!$module) return false;
        if(!$parent)$parent=0;
        $q=$this->db->query("SELECT 
        * 
        FROM ".$this->ava->getTblPrefix().$module."
        WHERE parent=".$parent."
        ORDER BY ord");
        $res_array=array();
        foreach($q->result_array() as $v){                        
            $children=$this->getTreeData($module,$v['id']);
            $res_array[]=array(
                'title'=>$v['name'],
                'key'=>$v['id'],
                'check_active'=>$v['check_active'],
                'children'=>$children
            );
        }
        return $res_array;       
        
    }
    public function createData($module=false,$post){
        if(!$module) return false;
        if(!isset($post['name'])) return false;
        if(!isset($post['parent']))$post['parent']=0;

        $post['ord']=$this->getNextSortIndexByParent($module,$post['parent']);

        
        $post=$this->ava->prepareCheck($post,$module);
        $this->db->set('time_created', 'NOW()', FALSE);
        $this->db->insert($this->ava->getTblPrefix().$module,$post);
        
        return true;
    }    
    public function quickEditData($module=false,$post){
        if(!$module) return false;
        if(!isset($post['id'])) return false;
        
        $this->db->where('id',$post['id']);
         $this->db->set('time_updated', 'NOW()', FALSE);
        $this->db->update($this->ava->getTblPrefix().$module,array('name'=>$post['name']));
        return true;
    }
    public function delData($module=false,$id=false){
        if(!$module) return false;
        if(!$id) return false;

        $this->db->delete($this->ava->getTblPrefix().$module,array('id'=>$id));
        
        return true;
    }
    public function activateData($module=false,$id=false){
        if(!$module) return false;
        if(!$id) return false;

        $this->db->where('id', $id);
        $this->db->update($this->ava->getTblPrefix().$module,array('check_active'=>'1'));
        
        return true;
    }
    public function deactivateData($module=false,$id=false){
        if(!$module) return false;
        if(!$id) return false;

        $this->db->where('id', $id);
        $this->db->update($this->ava->getTblPrefix().$module,array('check_active'=>'0'));
        
        return true;
    }
    public function resortData($module=false,$post){       
        if(!$module||!isset($post['parent'])||!isset($post['list'])) return false;
        //$this->ava->show($post);
       
            foreach($post['list'] as $k=>$v){
                $this->db->where('id', $v);
                $this->db->update($this->ava->getTblPrefix().$module,array('ord'=>($k+1)));
            } 
            $this->db->where('id', $post['el']);
            $this->db->update($this->ava->getTblPrefix().$module,array(
                'parent'=>$post['parent']
               )
            );           
       

        

        // $this->db->where('id', $id);
        // $this->db->update($this->ava->getTblPrefix().$module,array('check_active'=>'0'));
        
        return true;
    }
    public function updateData($module=false,$id=false,$post){
        if(!$module || !$id) return false;
        if(!isset($post['name'])) return false;
        $post=$this->ava->prepareCheck($post,$module);
        $this->db->where('id', $id);
        $this->db->set('time_updated', 'NOW()', FALSE);
        $this->db->update($this->ava->getTblPrefix().$module,$post);
        
        return true;
    }

    public function resizeImg($size,$path,$img){
        $orient=$size{0}; //либо w - режем по ширине, либо h- по высоте 
        $pixels=substr($size, 1); //на какое кол-во пикселей

        $conf=array(
            'image_library'=>'gd2', // выбираем библиотеку
            'maintain_ratio'=>TRUE, // сохранять пропорции
            'source_image'=>$path.$img,
            'create_thumb'=>FALSE,            
            'new_image'=>$path.$size.'x'.$img
        ); 

        if($orient=='w') {
            $conf['width']= $pixels;
            $conf['height']= $pixels;
            $conf['master_dim']='width';
        }
        else {
            $conf['height']= $pixels;
            $conf['width']= $pixels;
            $conf['master_dim']='height';
        }     
        
        $this->image_lib->clear();
        $this->image_lib->initialize($conf);           
        $this->image_lib->resize();

    }

    public function addImg($file_info){
        $row=array(
            'name'=>$file_info['file_name'],
            'size'=>$file_info['file_size']
        );
        
        $this->db->insert($this->ava->getTblPrefix().'files',$row);
        return  $this->db->insert_id();
    }
    public function getImg($id){
        $q=$this->db->query("SELECT 
        * 
        FROM ".$this->ava->getTblPrefix()."files
        WHERE id = ".(int)$id);
        return $q->row_array();
    }

}