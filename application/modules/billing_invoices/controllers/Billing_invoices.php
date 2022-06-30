<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Billing_invoices extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation', 'session', 'upload'));
        $this->load->module('users');
        $this->load->model('Billing_invoices_model');
    }

    public function index()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

        $data['external_page'] = 0;
        $data['active_page'] = "billing_invoices";
        $data['active_url'] = "billing_invoices";
        $data['page_view'] = 'billing_invoices/billing_invoices_v';

        $q_billing_invoices = $this->Billing_invoices_model->fetch_billing_invoices();
        $data['billing_invoices'] = $q_billing_invoices->result();

        $this->load->view('page', $data);
    }

    public function complete_billing_invoice()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

        $id = $this->input->post('id');
        $updated_at = date('Y-m-d H:i:s');
        $updated_by = $this->session->userdata('user_id');

        $result = $this->Billing_invoices_model->complete_billing_invoice($id, $updated_at, $updated_by);

        echo $result;
    }

    public function paid_billing_invoice()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

        $id = $this->input->post('id');
        $updated_at = date('Y-m-d H:i:s');
        $updated_by = $this->session->userdata('user_id');

        $result = $this->Billing_invoices_model->paid_billing_invoice($id, $updated_at, $updated_by);

        echo $result;
    }

    public function cancel_billing_invoice()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

        $id = $this->input->post('id');
        $updated_at = date('Y-m-d H:i:s');
        $updated_by = $this->session->userdata('user_id');

        $result = $this->Billing_invoices_model->cancel_billing_invoice($id, $updated_at, $updated_by);

        echo $result;
    }
}
