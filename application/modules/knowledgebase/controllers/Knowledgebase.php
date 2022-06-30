<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Knowledgebase extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation', 'session', 'upload'));
        $this->load->module('users');
        $this->load->model('Knowledgebase_model');
    }

    public function clear_apost()
    {
        foreach ($_POST as $key => $value) {
            $_POST[$key] = str_replace("'", "&apos;", $value);
        }
    }

    public function index()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
            redirect('/users/admin');
        }

        $data['external_page'] = 0;
        $data['active_page'] = "knowledgebase";
        $data['active_url'] = "knowledgebase";
        $data['page_view'] = 'knowledgebase/knowledgebase_v';

        $q_knowledgebase = $this->Knowledgebase_model->fetch_knowledgebase_products();
        $data['knowledgebases'] = $q_knowledgebase->result();

        $this->load->view('page', $data);
    }

    public function add_product()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
            redirect('/users/admin');
        }

        $this->clear_apost();

        $data['external_page'] = 0;
        $data['active_page'] = "knowledgebase";
        $data['active_url'] = "knowledgebase";
        $data['page_view'] = 'knowledgebase/add_product';

        $q_product_categories = $this->Knowledgebase_model->fetch_product_categories();
        $data['product_categories'] = $q_product_categories->result();

        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('product', 'Product', 'trim|required');
            $this->form_validation->set_rules('product_url', 'Product URL', 'trim|required');
            $this->form_validation->set_rules('product_category', 'Product Cateogry', 'trim|required');
            $this->form_validation->set_rules('laws_req_docs', 'Laws, required documents, etc.', 'trim|required');
            $this->form_validation->set_rules('contact_info', 'Contact Info', 'trim|required');
            $this->form_validation->set_rules('comments', 'Comments', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('page', $data);
            } else {
                $product = stripslashes($this->input->post('product'));
                $product_url = stripslashes($this->input->post('product_url'));
                $product_category = stripslashes($this->input->post('product_category'));
                $laws_req_docs = stripslashes($this->input->post('laws_req_docs'));
                $contact_info = stripslashes($this->input->post('contact_info'));
                $comments = stripslashes($this->input->post('comments'));
                $created_by = $this->session->userdata('user_id');
                $created_at = date('Y-m-d H:i:s');

                $result = $this->Knowledgebase_model->insert_knowledgebase_product($product, $product_url, $product_category, $laws_req_docs, $contact_info, $comments, $created_by, $created_at);

                if ($result == 1) {
                    $this->session->set_flashdata('success', 'Successfully added new knowledgebase product!');
                    $data['page_view'] = 'knowledgebase/knowledgebase_v';

                    $q_knowledgebase = $this->Knowledgebase_model->fetch_knowledgebase_products();
                    $data['knowledgebases'] = $q_knowledgebase->result();

                    $this->load->view('page', $data);
                } else {
                    $data['errors'] = 1;
                    $this->load->view('page', $data);
                }
            }
        } else {
            $this->load->view('page', $data);
        }
    }

    public function edit_product()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
            redirect('/users/admin');
        }

        $this->clear_apost();

        $data['external_page'] = 0;
        $data['active_page'] = "knowledgebase";
        $data['active_url'] = "knowledgebase";
        $data['page_view'] = 'knowledgebase/edit_product';

        $id = $this->uri->segment(3);

        $q_fetch_knowledgebase_product = $this->Knowledgebase_model->fetch_knowledgebase_product($id);
        $data['knowledgebase_product'] = $q_fetch_knowledgebase_product->row();

        $q_product_categories = $this->Knowledgebase_model->fetch_product_categories();
        $data['product_categories'] = $q_product_categories->result();

        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('product', 'Product', 'trim|required');
            $this->form_validation->set_rules('product_url', 'Product URL', 'trim|required');
            $this->form_validation->set_rules('product_category', 'Product Cateogry', 'trim|required');
            $this->form_validation->set_rules('laws_req_docs', 'Laws, required documents, etc.', 'trim|required');
            $this->form_validation->set_rules('contact_info', 'Contact Info', 'trim|required');
            $this->form_validation->set_rules('comments', 'Comments', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('page', $data);
            } else {
                $product = stripslashes($this->input->post('product'));
                $product_url = stripslashes($this->input->post('product_url'));
                $product_category = stripslashes($this->input->post('product_category'));
                $laws_req_docs = stripslashes($this->input->post('laws_req_docs'));
                $contact_info = stripslashes($this->input->post('contact_info'));
                $comments = stripslashes($this->input->post('comments'));
                $updated_by = $this->session->userdata('user_id');
                $updated_at = date('Y-m-d H:i:s');

                $result = $this->Knowledgebase_model->update_knowledgebase_product($id, $product, $product_url, $product_category, $laws_req_docs, $contact_info, $comments, $updated_by, $updated_at);

                if ($result == 1) {
                    $this->session->set_flashdata('success', 'Successfully updated knowledgebase product!');
                    $data['page_view'] = 'knowledgebase/knowledgebase_v';

                    $q_knowledgebase = $this->Knowledgebase_model->fetch_knowledgebase_products();
                    $data['knowledgebases'] = $q_knowledgebase->result();

                    $this->load->view('page', $data);
                } else {
                    $data['errors'] = 1;
                    $this->load->view('page', $data);
                }
            }
        } else {
            $this->load->view('page', $data);
        }
    }

    public function delete_product()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
    		redirect('/users/admin');
        }

        $id = $this->input->post('id');
        $updated_by = $this->session->userdata('user_id');
        $updated_at = date('Y-m-d H:i:s');
        
        $result = $this->Knowledgebase_model->delete_knowledgebase_product($id, $updated_by, $updated_at);

        echo $result;
    }
}
