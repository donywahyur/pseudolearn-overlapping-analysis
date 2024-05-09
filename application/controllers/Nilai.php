<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nilai extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if (!$this->ion_auth->logged_in()){
			redirect('auth');
		}
		$this->user = $this->ion_auth->user()->row();
	}

	public function index()
	{
		$data = [
			'user' => $this->user,
			'judul'	=> 'Clustering',
			'subjudul'=> 'Nilai Mahasiswa',
		];

		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('_templates/dashboard/_footer.php');
	}
}