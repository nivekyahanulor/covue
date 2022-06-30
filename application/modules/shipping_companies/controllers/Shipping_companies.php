<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shipping_companies extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation', 'session', 'upload'));
        $this->load->module('users');
        $this->load->model('Shipping_companies_model');
    }

    public function index()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

        $data['external_page'] = 0;
        $data['active_page'] = "shipping_companies";
        $data['active_url'] = "shipping_companies";
        $data['page_view'] = 'shipping_companies/shipping_companies_v';

        $q_all_shipping_companies = $this->Shipping_companies_model->fetch_all_shipping_companies();
        $data['shipping_companies'] = $q_all_shipping_companies->result();

        $this->load->view('page', $data);
    }

    public function edit_shipping_company()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

        $this->users->clear_apost();

        $data['external_page'] = 0;
        $data['active_page'] = "shipping_companies";
        $data['active_url'] = "shipping_companies";
        $data['page_view'] = 'shipping_companies/edit_shipping_company';

        $get_id = $this->uri->segment(3);

        $q_shipping_company = $this->Shipping_companies_model->fetch_shipping_company($get_id);
        $data['shipping_company_details'] = $q_shipping_company->row();

        $q_fetch_countries = $this->Shipping_companies_model->fetch_countries();
        $data['countries'] = $q_fetch_countries->result();

        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('shipping_company_name', 'Shipping Company Name', 'trim|required');
            $this->form_validation->set_rules('shipping_company_email', 'Email Address', 'trim|required');
            $this->form_validation->set_rules('shipping_company_username', 'User Name', 'trim|required');
            $this->form_validation->set_rules('shipping_company_password', 'Password', 'trim|required');
            $this->form_validation->set_rules('contact_person', 'Contact Name', 'trim|required');
            $this->form_validation->set_rules('country', 'Country', 'trim|required');
            $this->form_validation->set_rules('shipping_company_partner', 'Partner', 'trim|required');

            if ($this->form_validation->run() == FALSE) {

                $q_shipping_company = $this->Shipping_companies_model->fetch_shipping_company($get_id);
                $data['shipping_company_details'] = $q_shipping_company->row();

                $this->load->view('page', $data);
            } else {
                $shipping_company_name = stripslashes($this->input->post('shipping_company_name'));
                $shipping_company_email = stripslashes($this->input->post('shipping_company_email'));
                $shipping_company_username = stripslashes($this->input->post('shipping_company_username'));
                $shipping_company_password = stripslashes($this->input->post('shipping_company_password'));
                $shipping_company_partner = stripslashes($this->input->post('shipping_company_partner'));
                $shipping_contact_person = stripslashes($this->input->post('contact_person'));
                $shipping_country = stripslashes($this->input->post('country'));
                $updated_at = date('Y-m-d H:i:s');
                $updated_by = $this->session->userdata('user_id');

                $result = $this->Shipping_companies_model->update_shipping_company($get_id, $shipping_company_name, $shipping_company_email, $shipping_company_username, $shipping_company_password, $shipping_company_partner, $shipping_contact_person, $shipping_country, $updated_at, $updated_by);

                if ($result == 1) {
                    $data['errors'] = 0;
                    $q_shipping_company = $this->Shipping_companies_model->fetch_shipping_company($get_id);
                    $data['shipping_company_details'] = $q_shipping_company->row();

                    $this->load->view('page', $data);
                } else {
                    $data['errors'] = 1;
                    $q_shipping_company = $this->Shipping_companies_model->fetch_shipping_company($get_id);
                    $data['shipping_company_details'] = $q_shipping_company->row();

                    $this->load->view('page', $data);
                }
            }
        } else {
            $this->load->view('page', $data);
        }
    }

    public function delete_shipping_company()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

        $id = $this->input->post('id');
        $updated_at = date('Y-m-d H:i:s');
        $updated_by = $this->session->userdata('user_id');

        $result = $this->Shipping_companies_model->delete_shipping_company($id, $updated_at, $updated_by);

        if ($result == 1) {
            echo $result;
        }
    }
}
