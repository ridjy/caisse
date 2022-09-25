<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fileupload extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'user_model' => 'Users'
			,'global_model' => 'Global'
			,'utils_model' => 'Utils'
		)) ;
	}

	/**
	 * Receive profile image uploaded
	 */
	public function receiveprofile()
	{
		$config['upload_path']          = './uploads/';
	    $config['allowed_types']        = 'gif|jpg|png';
	    $config['max_size']             = 100;
	    $config['max_width']            = 1024;
	    $config['max_height']           = 768;

	    $t = $this->load->library('upload', $config);

		echo "<pre>";
		print_r($t);
		echo "</pre>";
		die() ;

	 //   	$User = new Genius_Model_User();
		// $user_id = $User->getId();

	 //   	$return = array();
		// $ret["status"] = 0;
		// $res["error"] = "";

		// if ($this->getRequest()->isPost()) {

		// 	$adapter = new Zend_File_Transfer_Adapter_Http();
		// 	$adapter->addValidator('Extension', false, 'jpg,jpeg,png,gif');
		// 	$files = $adapter->getFileInfo();
		// 	$fileinfo = $files['files_0_'] ;

		// 	$filename = $fileinfo['name'] ;
		// 	$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		// 	$filesize = $fileinfo['size'];

		// 	$receive_to = $this->getRequest()->getParam('to');
		// 	$form_unique_key = $this->getRequest()->getParam('form_unique_key');
		// 	$type = $this->getRequest()->getParam('type');

		// 	if ($type == 'logo_entreprise' || $type == 'couverture') {
		// 		$resource_id = $this->getRequest()->getParam('resource_id');
  //               $target_filename = uniqid().'-source.' . $extension;
		// 		$tmp_filename_full = UPLOAD_PATH . '/images/'.$receive_to."/". $target_filename;

		// 		// set to rename uploaded file upon receiving to upload/images/profile folder
		// 		$adapter->setDestination(UPLOAD_PATH . '/images/'.$receive_to.'/');
		// 		$adapter->addFilter('rename', $tmp_filename_full);
				
		// 		// receive the files into the upload/images/profile directory, must have
		// 		$uploaded = $adapter->receive($filename);

		// 		$d = array(
		// 		    'id_user' => $user_id
		// 		    ,'filename' => $target_filename
		// 		    ,'title' => $filename
		// 		    ,'caption' => NULL
		// 		    ,'alt' => NULL
		// 		    ,'description' => NULL
		// 		);

		// 		$mediaId = Genius_Model_Media::addMedia($d);

		// 		$Image = new Genius_Class_Image();
		// 		$Image->contain($tmp_filename_full, 'thumbnail', 60, 60);
		// 		$Image->contain($tmp_filename_full, 'mini', 150, 150);
		// 		$Image->contain($tmp_filename_full, 'small', 320, 320);
		// 		$Image->contain($tmp_filename_full, 'medium', 480, 480);
		// 		$Image->contain($tmp_filename_full, 'large', 640, 640);
		// 		// $Image->thumbnail($tmp_filename_full, '370x370', 370, 370);
		// 		// $Image->thumbnail($tmp_filename_full, 'h350', 350);

		// 		$data = array(
		// 		    'module' => ($type == 'logo_entreprise') ? 'entreprise' : 'jobs'
		// 		    ,'id_item' => $resource_id
		// 		    ,'type' => "cover" 
		// 		    ,'id_media' => $mediaId
		// 		);
		// 		Genius_Model_Media::addCover($data);

		// 		$ret["resource_name"] = $target_filename ;
  //           	$ret["resource_url"]  = UPLOAD_URL."images/".$receive_to."/".$target_filename;
		// 	}
		// 	else{
		// 		$randomstring = Genius_Plugin_Common::getRandomString();

		// 		// generate tmp filename
		// 		$tmp_filename = $receive_to.'_' . $user_id . '_' . $form_unique_key . '_' . $randomstring . '-source.' . $extension;
		// 		$tmp_filename_full = UPLOAD_PATH . '/images/'.$receive_to.'/' . $tmp_filename;

		// 		// set to rename uploaded file upon receiving to upload/images/profile folder
		// 		$adapter->setDestination(UPLOAD_PATH . '/images/'.$receive_to.'/');
		// 		$adapter->addFilter('rename', $tmp_filename_full);
				
		// 		// receive the files into the upload/images/profile directory, must have
		// 		$uploaded = $adapter->receive($filename);

	 //            // create thumbnail
	 //            $Image = new Genius_Class_Image();							
	 //            $Image->thumbnail($tmp_filename_full, 'thumbnail', 128, 128);	

	 //            $thumbnail_name = str_replace('-source', '-thumbnail', $tmp_filename); 

	 //            Genius_Model_Global::update(TABLE_PREFIX."users", array("profile_picture"=>$thumbnail_name), " id='$user_id' ");

	 //            $ret["resource_name"] = $thumbnail_name ;
  //           	$ret["resource_url"]  = UPLOAD_URL."images/".$receive_to."/".$thumbnail_name;
		// 	}

  //           $ret["status"] = 1;
  //           $ret["error"] = "";
            
		// }			   	

	 // 	echo Zend_Json::encode($ret);  	
	}

}
