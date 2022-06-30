<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->module('users');
	}

	public function index()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		} else {
			$data['active_page'] = "dashboard";
			$data['external_page'] = 0;
			$data['page_view'] = 'dashboard/dashboard';
			$this->load->view('page', $data);
		}
	}
}
