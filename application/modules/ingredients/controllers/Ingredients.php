<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ingredients extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->module('users');
        $this->load->model('Ingredients_model');
    }

    public function list()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

        $data['external_page'] = 0;
        $data['active_page'] = "ingredients";
        $data['active_url'] = "ingredients";
        $data['page_view'] = 'ingredients/ingredients_list';

        $q_ingredients = $this->Ingredients_model->fetch_ingredients();
        $data['ingredients'] = $q_ingredients->result();

        $this->load->view('page', $data);
    }
}
