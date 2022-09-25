<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medias extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'medias_model' => 'Medias'
			,'user_model' => 'Users'
		)) ;

	 	$this->load->library('imageinter');

	 	if (!$this->Users->getData()) {
			redirect(BASE_URL."/login");
		}
		else{
			$role = $this->Users->getData()['role'] ;

			if($role != 'admin'){
				redirect(BASE_URL."/caisse");
			}
		}
	}

	public function add()
	{
		$this->layout->set('title', "Ajout d'un nouveau média");
		$this->layout->set('headLink', '');
		$this->layout->set('headScript', array(THEMES_URL."js/scripts/medias/index.js"));
		$this->layout->load('default', 'contents' , 'medias/add');
	}

	public function multipleupload()
	{
		$upload_path = UPLOAD_PATH . 'images/medias/';

        if (!empty($_FILES)) {
            setlocale(LC_CTYPE, "fr_FR.utf8");
            $temp_file = $_FILES['file']['tmp_name'];

            if (!is_dir($upload_path)) {
                if (!mkdir($upload_path)) {
                    echo "Erreur: Veuillez créer manuellement le dossier " . $upload_path;
                    exit(0);
                }
            }

            $path_parts = pathinfo($upload_path . $_FILES['file']['name']);
            $target_filename = uniqid() . "-source." . $path_parts['extension'];
            $target_file = str_replace('//', '/', $upload_path) . $target_filename;

            if (move_uploaded_file($temp_file, $target_file)) {
				$d = array(
					'id_user' => $this->User->getData()['id']
					,'filename' => $target_filename
					,'title' => $path_parts['filename']
					,'caption' => NULL
					,'alt' => NULL
					,'description' => NULL
				);

				$t = $this->Medias->addMedia($d);
                
                // create thumbnail
                $this->imageinter->contain($target_file, 'thumbnail', 60, 60);
				$this->imageinter->contain($target_file, 'mini', 150, 150);
				$this->imageinter->contain($target_file, 'small', 320, 320);
				$this->imageinter->contain($target_file, 'medium', 480, 480);
				$this->imageinter->contain($target_file, 'large', 640, 640);
				// $Image->thumbnail($target_file, '370x370', 370, 370);
				// $Image->thumbnail($target_file, 'h350', 350);
				
                $return = array('status' => 'ok');
                echo json_encode($return);
            } else {
                $return = array('status' => 'error');
                echo json_encode($return);
                exit(0);
            }
        }

	}
}
