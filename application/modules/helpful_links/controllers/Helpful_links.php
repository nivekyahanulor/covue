<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Helpful_links extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation', 'session', 'upload'));
        $this->load->module('users');
    }

    public function index()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

        $data['external_page'] = 0;
        $data['active_page'] = "helpful_links";
        $data['active_url'] = "helpful_links";
        $data['page_view'] = 'helpful_links/helpful_links_v';

        $this->load->view('page', $data);
    }

    public function ior_manual_guide()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

        $data['external_page'] = 0;
        $data['active_page'] = "helpful_links";
        $data['active_url'] = "helpful_links";
        $data['page_view'] = 'helpful_links/ior_manual_guide';

        $this->load->view('page', $data);
    }

    public function shipping_invoice_docs()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

        $data['external_page'] = 0;
        $data['active_page'] = "helpful_links";
        $data['active_url'] = "helpful_links";
        $data['page_view'] = 'helpful_links/shipping_invoice_docs';

        $this->load->view('page', $data);
    }

    public function product_labelling_compliance()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

        $data['external_page'] = 0;
        $data['active_page'] = "helpful_links";
        $data['active_url'] = "helpful_links";
        $data['page_view'] = 'helpful_links/product_labelling_compliance';

        $this->load->view('page', $data);
    }
}
