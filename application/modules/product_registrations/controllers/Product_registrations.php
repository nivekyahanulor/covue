<?php
defined('BASEPATH') or exit('No direct script access allowed');
// require_once APPPATH . "libraries/zoho_sdk/vendor/autoload.php";
require_once(APPPATH.'modules/zoho_sdk/controllers/Zoho_sdk.php'); 
// use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
// use zcrmsdk\oauth\ZohoOAuth;
// use zcrmsdk\crm\crud\ZCRMRecord;

class Product_registrations extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'date'));
		$this->load->library(array('form_validation', 'session', 'upload', 'phpmailer_library'));
		$this->load->module('users');
		$this->load->model('Product_registration_model');
	}

	public function index()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		} else {
			$data['external_page'] = 0;
			$data['active_page'] = "product_registrations";
			$data['active_url'] = "product_registrations";
			$data['page_view'] = 'product_registrations/product_registration_v';

			$data['user_id'] = $this->session->userdata('user_id');
			$data['admin'] = $this->session->userdata('admin');

			$q_user_details = $this->Product_registration_model->fetch_user_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			$q_product_registrations = $this->Product_registration_model->fetch_product_registrations();
			$data['product_registrations'] = $q_product_registrations->result();

			$q_product_categories = $this->Product_registration_model->fetch_product_categories();
			$data['product_categories'] = $q_product_categories->result();

			$this->load->view('page', $data);
		}
	}

	public function approved()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		} else {
			$data['external_page'] = 0;
			$data['active_page'] = "product_registrations";
			$data['active_url'] = "product_registrations/approved";
			$data['page_view'] = 'product_registrations/product_registration_v';

			$data['user_id'] = $this->session->userdata('user_id');
			$data['admin'] = $this->session->userdata('admin');

			$q_user_details = $this->Product_registration_model->fetch_user_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			$q_product_registrations = $this->Product_registration_model->fetch_product_registrations_custom(1);
			$data['product_registrations'] = $q_product_registrations->result();

			$q_product_categories = $this->Product_registration_model->fetch_product_categories();
			$data['product_categories'] = $q_product_categories->result();

			$this->load->view('page', $data);
		}
	}

	public function declined()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		} else {
			$data['external_page'] = 0;
			$data['active_page'] = "product_registrations";
			$data['active_url'] = "product_registrations/declined";
			$data['page_view'] = 'product_registrations/product_registration_v';

			$data['user_id'] = $this->session->userdata('user_id');
			$data['admin'] = $this->session->userdata('admin');

			$q_user_details = $this->Product_registration_model->fetch_user_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			$q_product_registrations = $this->Product_registration_model->fetch_product_registrations_custom(2);
			$data['product_registrations'] = $q_product_registrations->result();

			$q_product_categories = $this->Product_registration_model->fetch_product_categories();
			$data['product_categories'] = $q_product_categories->result();

			$this->load->view('page', $data);
		}
	}

	public function revisions()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		} else {
			$data['external_page'] = 0;
			$data['active_page'] = "product_registrations";
			$data['active_url'] = "product_registrations/revisions";
			$data['page_view'] = 'product_registrations/product_registration_v';

			$data['user_id'] = $this->session->userdata('user_id');
			$data['admin'] = $this->session->userdata('admin');

			$q_user_details = $this->Product_registration_model->fetch_user_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			$q_product_registrations = $this->Product_registration_model->fetch_product_registrations_custom(3);
			$data['product_registrations'] = $q_product_registrations->result();

			$q_product_categories = $this->Product_registration_model->fetch_product_categories();
			$data['product_categories'] = $q_product_categories->result();

			$this->load->view('page', $data);
		}
	}

	public function pending()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		} else {
			$data['external_page'] = 0;
			$data['active_page'] = "product_registrations";
			$data['active_url'] = "product_registrations/pending";
			$data['page_view'] = 'product_registrations/product_registration_v';

			$data['user_id'] = $this->session->userdata('user_id');
			$data['admin'] = $this->session->userdata('admin');

			$q_user_details = $this->Product_registration_model->fetch_user_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			$q_product_registrations = $this->Product_registration_model->fetch_product_registrations_custom(4);
			$data['product_registrations'] = $q_product_registrations->result();

			$q_product_categories = $this->Product_registration_model->fetch_product_categories();
			$data['product_categories'] = $q_product_categories->result();

			$this->load->view('page', $data);
		}
	}

	public function updated()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		} else {
			$data['external_page'] = 0;
			$data['active_page'] = "product_registrations";
			$data['active_url'] = "product_registrations/updated";
			$data['page_view'] = 'product_registrations/product_registration_v';

			$data['user_id'] = $this->session->userdata('user_id');
			$data['admin'] = $this->session->userdata('admin');

			$q_user_details = $this->Product_registration_model->fetch_user_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			$q_product_registrations = $this->Product_registration_model->fetch_product_registrations_custom(5);
			$data['product_registrations'] = $q_product_registrations->result();

			$q_product_categories = $this->Product_registration_model->fetch_product_categories();
			$data['product_categories'] = $q_product_categories->result();

			$this->load->view('page', $data);
		}
	}

	public function edit_product()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		} else {

			$this->users->clear_apost();

			$data['external_page'] = 0;
			$data['active_page'] = "product_registrations";
			$data['page_view'] = 'product_registrations/edit_product';

			$id = $this->uri->segment(3);

			$q_product_data = $this->Product_registration_model->fetch_product_registration($id);
			$data['product_data'] = $q_product_data->row();

			if (isset($_POST['submit'])) {

				if (empty($_FILES['product_img']['name']) && empty($_FILES['product_label']['name'])) {

					$this->form_validation->set_rules('sku', 'HS Code', 'trim|required');
					$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');

					if($data['product_data']->is_mailing_product == 1){
						$this->form_validation->set_rules('product_type', 'Product Name', 'trim|required');
						$this->form_validation->set_rules('dimensions_by_piece', 'Dimensions by Piece', 'trim|required');
						$this->form_validation->set_rules('weight_by_piece', 'Weight by Piece', 'trim|required');
					}

					if ($this->form_validation->run() == FALSE) {

						$q_product_data = $this->Product_registration_model->fetch_product_registration($id);
						$data['product_data'] = $q_product_data->row();

						$this->load->view('page', $data);
					} else {

						$sku = stripslashes($this->input->post('sku'));
						$product_name = stripslashes($this->input->post('product_name'));
						$product_type = stripslashes($this->input->post('product_type'));
						$dimensions_by_piece = stripslashes($this->input->post('dimensions_by_piece'));
						$weight_by_piece = stripslashes($this->input->post('weight_by_piece'));
						$updated_at = date('Y-m-d H:i:s');
						$updated_by = $this->session->userdata('user_id');

						$result = $this->Product_registration_model->update_products($id, $sku, $product_name, $product_type, $dimensions_by_piece, $weight_by_piece, $updated_at, $updated_by);

						if ($result == 1) {
							$data['errors'] = 0;
							$q_product_data = $this->Product_registration_model->fetch_product_registration($id);
							$data['product_data'] = $q_product_data->row();
							$this->load->view('page', $data);
						} else {
							$data['errors'] = 1;
							$q_product_data = $this->Product_registration_model->fetch_product_registration($id);
							$data['product_data'] = $q_product_data->row();
							$this->load->view('page', $data);
						}
					}
				}

				if (!empty($_FILES['product_img']['name']) && empty($_FILES['product_label']['name'])) {

					$current_timestamp = now();
					$upload_path_file = 'uploads/product_qualification/' . $data['product_data']->user_id;

					if (!file_exists($upload_path_file)) {
						mkdir($upload_path_file, 0777, true);
					}

					$config['upload_path'] = $upload_path_file;
					$config['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config['max_size'] = 5000000;
					$config['file_name'] = 'product_qualification_' . $id . '_' . $current_timestamp;

					$this->upload->initialize($config);

					if (!$this->upload->do_upload('product_img')) {

						$data['errors'] = 2;
						$data['error_msgs'] = $this->upload->display_errors();

						$q_product_data = $this->Product_registration_model->fetch_product_registration($id);
						$data['product_data'] = $q_product_data->row();

						$this->load->view('page', $data);
					} else {

						$this->form_validation->set_rules('sku', 'HS Code', 'trim|required');
						$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
						if($data['product_data']->is_mailing_product == 1){
							$this->form_validation->set_rules('product_type', 'Product Name', 'trim|required');
							$this->form_validation->set_rules('dimensions_by_piece', 'Dimensions by Piece', 'trim|required');
							$this->form_validation->set_rules('weight_by_piece', 'Weight by Piece', 'trim|required');
						}

						if ($this->form_validation->run() == FALSE) {

							$q_product_data = $this->Product_registration_model->fetch_product_registration($id);
							$data['product_data'] = $q_product_data->row();

							$this->load->view('page', $data);
						} else {

							$sku = stripslashes($this->input->post('sku'));
							$product_name = stripslashes($this->input->post('product_name'));
							$product_type = stripslashes($this->input->post('product_type'));
							$dimensions_by_piece = stripslashes($this->input->post('dimensions_by_piece'));
							$weight_by_piece = stripslashes($this->input->post('weight_by_piece'));
							$updated_at = date('Y-m-d H:i:s');
							$updated_by = $this->session->userdata('user_id');

							$result = $this->Product_registration_model->update_products_img($id, $sku, $product_name, $config['file_name'] . $this->upload->data('file_ext'), $product_type, $dimensions_by_piece, $weight_by_piece, $updated_at, $updated_by);

							if ($result == 1) {
								$data['errors'] = 0;
								$q_product_data = $this->Product_registration_model->fetch_product_registration($id);
								$data['product_data'] = $q_product_data->row();
								$this->load->view('page', $data);
							} else {
								$data['errors'] = 1;
								$q_product_data = $this->Product_registration_model->fetch_product_registration($id);
								$data['product_data'] = $q_product_data->row();
								$this->load->view('page', $data);
							}
						}
					}
				}

				if (empty($_FILES['product_img']['name']) && !empty($_FILES['product_label']['name'])) {

					$current_timestamp = now();
					$upload_path_file = 'uploads/product_labels/' . $data['product_data']->user_id;

					if (!file_exists($upload_path_file)) {
						mkdir($upload_path_file, 0777, true);
					}

					$config['upload_path'] = $upload_path_file;
					$config['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config['max_size'] = 5000000;
					$config['file_name'] = 'product_label_' . $id . '_' . $current_timestamp;

					$this->upload->initialize($config);

					if (!$this->upload->do_upload('product_label')) {

						$data['errors'] = 2;
						$data['error_msgs'] = $this->upload->display_errors();

						$q_product_data = $this->Product_registration_model->fetch_product_registration($id);
						$data['product_data'] = $q_product_data->row();

						$this->load->view('page', $data);
					} else {

						$this->form_validation->set_rules('sku', 'HS Code', 'trim|required');
						$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');

						if ($this->form_validation->run() == FALSE) {

							$q_product_data = $this->Product_registration_model->fetch_product_registration($id);
							$data['product_data'] = $q_product_data->row();

							$this->load->view('page', $data);
						} else {

							$sku = stripslashes($this->input->post('sku'));
							$product_name = stripslashes($this->input->post('product_name'));

							$updated_at = date('Y-m-d H:i:s');
							$updated_by = $this->session->userdata('user_id');

							$result = $this->Product_registration_model->update_products_label($id, $sku, $product_name, $config['file_name'] . $this->upload->data('file_ext'), $updated_at, $updated_by);

							if ($result == 1) {
								$data['errors'] = 0;
								$q_product_data = $this->Product_registration_model->fetch_product_registration($id);
								$data['product_data'] = $q_product_data->row();
								$this->load->view('page', $data);
							} else {
								$data['errors'] = 1;
								$q_product_data = $this->Product_registration_model->fetch_product_registration($id);
								$data['product_data'] = $q_product_data->row();
								$this->load->view('page', $data);
							}
						}
					}
				}

				if (!empty($_FILES['product_img']['name']) && !empty($_FILES['product_label']['name'])) {

					$current_timestamp = now();
					$upload_path_file1 = 'uploads/product_qualification/' . $data['product_data']->user_id;

					if (!file_exists($upload_path_file1)) {
						mkdir($upload_path_file1, 0777, true);
					}

					$config1['upload_path'] = $upload_path_file1;
					$config1['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config1['max_size'] = 5000000;
					$config1['file_name'] = 'product_qualification_' . $id . '_' . $current_timestamp;

					$this->upload->initialize($config1);

					if (!$this->upload->do_upload('product_img')) {

						$data['errors'] = 2;
						$data['error_msgs'] = $this->upload->display_errors();

						$q_product_data = $this->Product_registration_model->fetch_product_registration($id);
						$data['product_data'] = $q_product_data->row();

						$this->load->view('page', $data);
					} else {
						$product_img_filename = $config1['file_name'] . $this->upload->data('file_ext');
					}

					$upload_path_file2 = 'uploads/product_labels/' . $data['product_data']->user_id;

					if (!file_exists($upload_path_file2)) {
						mkdir($upload_path_file2, 0777, true);
					}

					$config2['upload_path'] = $upload_path_file2;
					$config2['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config2['max_size'] = 5000000;
					$config2['file_name'] = 'product_label_' . $id . '_' . $current_timestamp;

					$this->upload->initialize($config2);

					if (!$this->upload->do_upload('product_label')) {

						$data['errors'] = 2;
						$data['error_msgs'] = $this->upload->display_errors();

						$q_product_data = $this->Product_registration_model->fetch_product_registration($id);
						$data['product_data'] = $q_product_data->row();

						$this->load->view('page', $data);
					} else {
						$product_label_filename = $config2['file_name'] . $this->upload->data('file_ext');
					}

					$this->form_validation->set_rules('sku', 'HS Code', 'trim|required');
					$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');

					if ($this->form_validation->run() == FALSE) {

						$q_product_data = $this->Product_registration_model->fetch_product_registration($id);
						$data['product_data'] = $q_product_data->row();

						$this->load->view('page', $data);
					} else {
						$sku = stripslashes($this->input->post('sku'));
						$product_name = stripslashes($this->input->post('product_name'));

						$updated_at = date('Y-m-d H:i:s');
						$updated_by = $this->session->userdata('user_id');

						$result = $this->Product_registration_model->update_products_img_and_label($id, $sku, $product_name, $product_img_filename, $product_label_filename, $updated_at, $updated_by);

						if ($result == 1) {
							$data['errors'] = 0;
							$q_product_data = $this->Product_registration_model->fetch_product_registration($id);
							$data['product_data'] = $q_product_data->row();
							$this->load->view('page', $data);
						} else {
							$data['errors'] = 1;
							$q_product_data = $this->Product_registration_model->fetch_product_registration($id);
							$data['product_data'] = $q_product_data->row();
							$this->load->view('page', $data);
						}
					}
				}
			} else {
				$this->load->view('page', $data);
			}
		}
	}

	public function product_approve()
	{
		// echo "hello";die;
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		}

		$subject = 'Product Registration Status';
		$template = 'emails/notification_approved.php';
		$id = $this->input->post('id');
		$updated_at = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('user_id');
		$q_product_data = $this->Product_registration_model->fetch_product_registration($id);
		$product_data = $q_product_data->row();
		$result = $this->Product_registration_model->product_approve($id, $updated_at, $updated_by);
		if ($result == 1) {	
		$outh =  new Zoho_sdk();
		$tokens = $outh->get_auth_token();
			   	//Zoho Crm Code Sdk 
		$product_arr['product_id'] = $product_data->product_registration_id;
		$product_arr['user_id'] = $product_data->user_id;
		$product_arr['product_code'] = $product_data->sku;
		$product_arr['product_name'] = $product_data->product_name;
		$product_arr['active'] = $product_data->active;
		 $resp = $outh->create_product_in_zoho_crm($product_arr,$tokens['refreshToken'],$tokens['userIdentifier']);
		 $this->send_mail($product_data->email, $template, $product_data->id, '', $subject, $product_data->contact_person);
		 echo $result;
		 $data_arr['resp'] = $resp;
		$data_arr['result'] = $result;
		echo json_encode($data_arr);

		}

	}




	public function product_approve_regapp()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		}

		$id = $this->input->post('id');

		$updated_at = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('user_id');

		$q_product_data = $this->Product_registration_model->fetch_product_registration($id);
		$product_data = $q_product_data->row();

		$result = $this->Product_registration_model->product_approve($id, $updated_at, $updated_by);

		if ($result == 1) {
			echo $result;
		}
	}

	public function product_approve_mailing_product()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		}

		$subject = 'Product Registration Status';
		$template = 'emails/notification_approved.php';

		$id = $this->input->post('id');
		$mailing_product_price = $this->input->post('mailing_product_price');

		$updated_at = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('user_id');

		$q_product_data = $this->Product_registration_model->fetch_product_registration($id);
		$product_data = $q_product_data->row();

		$this->Product_registration_model->add_mailing_price($id, $mailing_product_price, $updated_at, $updated_by);

		$result = $this->Product_registration_model->product_approve($id, $updated_at, $updated_by);

		if ($result == 1) {
			$this->send_mail($product_data->email, $template, $product_data->id, '', $subject, $product_data->contact_person);
			echo $result;
		}
	}

	public function product_decline()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		}

		$subject = 'Product Registration Status';
		$template = 'emails/notification_declined.php';

		$id = $this->input->post('id');
		$declined_msg = $this->input->post('declined_msg');


		$updated_at = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('user_id');

		$q_product_data = $this->Product_registration_model->fetch_product_registration($id);
		$product_data = $q_product_data->row();

		$result = $this->Product_registration_model->product_decline($id, $declined_msg, $updated_at, $updated_by);

		if ($result == 1) {
			$this->send_mail($product_data->email, $template, $product_data->id, $declined_msg, $subject, $product_data->contact_person);
			echo $result;
		}
	}

	public function product_revisions()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		}

		$this->users->clear_apost();

		$subject = 'Product Registration Status';
		$template = 'emails/notification_revision.php';

		$id = $this->input->post('id');
		$revisions_msg = $this->input->post('revisions_msg');

		$updated_at = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('user_id');

		$q_product_data = $this->Product_registration_model->fetch_product_registration($id);
		$product_data = $q_product_data->row();

		$result = $this->Product_registration_model->product_revisions($id, $revisions_msg, $updated_at, $updated_by);

		if ($result == 1) {
			$this->send_mail($product_data->email, $template, $product_data->id, $revisions_msg, $subject, $product_data->contact_person);
			echo $result;
		}
	}

	public function product_delete()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		}

		$id = $this->input->post('id');

		$updated_at = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('user_id');

		$result = $this->Product_registration_model->product_delete($id, $updated_at, $updated_by);

		if ($result == 1) {
			echo $result;
		}
	}

	public function product_labels()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		} else {
			$data['external_page'] = 0;
			$data['active_page'] = "product_registrations/product_labels";
			$data['active_url'] = "product_registrations/product_labels";
			$data['page_view'] = 'product_registrations/product_labels_v';

			$data['user_id'] = $this->session->userdata('user_id');

			$q_user_details = $this->Product_registration_model->fetch_user_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			$q_product_labels = $this->Product_registration_model->fetch_product_labels();
			$data['product_labels'] = $q_product_labels->result();

			

			$this->load->view('page', $data);
		}
	}

	public function edit_product_label()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		} else {

			$this->users->clear_apost();

			$data['external_page'] = 0;
			$data['active_page'] = "product_registrations/product_labels";
			$data['active_url'] = "product_registrations/product_labels";
			$data['page_view'] = 'product_registrations/edit_product_label';

			$id = $this->uri->segment(3);

			$q_product_label_details = $this->Product_registration_model->fetch_product_label($id);
			$data['product_label_details'] = $q_product_label_details->row();

			$q_fetch_product_registration = $this->Product_registration_model->fetch_product_registration($data['product_label_details']->product_registration_id);
			$data['product_registration'] = $q_fetch_product_registration->row();

			$q_fetch_country = $this->Product_registration_model->fetch_country($data['product_label_details']->country);
			$data['country'] = $q_fetch_country->row();

			$data['product_label_revision_msg'] = $this->Product_registration_model->fetch_latest_revision_message($id);

			if (isset($_POST['submit'])) {

				$product_name = $this->input->post('product_name');

				$product_info = $this->input->post('product_info');
				$product_handling = $this->input->post('product_handling');

				$company_name = $this->input->post('company_name');
				$company_address = $this->input->post('company_address');
				$contact_number = $this->input->post('contact_number');

				$country_of_origin = $this->input->post('country_of_origin');
				$expiration_date = $this->input->post('expiration_date');

				// Creating the new document...
				$phpWord = new \PhpOffice\PhpWord\PhpWord();

				$sectionStyle = array(
					'orientation' => 'landscape'
				);

				// Adding an empty Section to the document...
				$section = $phpWord->addSection($sectionStyle);


				$section->addText(
					$product_name,
					array('name' => 'Tahoma', 'size' => 27, 'bold' => true)
				);

				$section->addText(
					'',
					array('name' => 'Tahoma', 'size' => 14)
				);

				$section->addText(
					'Product Information:',
					array('name' => 'Tahoma', 'size' => 14, 'bold' => true)
				);

				$section->addText(
					$product_info,
					array('name' => 'Tahoma', 'size' => 12)
				);

				$section->addText(
					'',
					array('name' => 'Tahoma', 'size' => 12)
				);

				$section->addText(
					'User Instructions:',
					array('name' => 'Tahoma', 'size' => 14, 'bold' => true)
				);

				$section->addText(
					$product_handling,
					array('name' => 'Tahoma', 'size' => 12)
				);

				$section->addText(
					'',
					array('name' => 'Tahoma', 'size' => 12)
				);

				$section->addText(
					'Seller',
					array('name' => 'Tahoma', 'size' => 14, 'bold' => true)
				);

				$section->addText(
					$company_name,
					array('name' => 'Tahoma', 'size' => 12)
				);

				$section->addText(
					$company_address,
					array('name' => 'Tahoma', 'size' => 12)
				);

				$section->addText(
					$contact_number,
					array('name' => 'Tahoma', 'size' => 12)
				);

				$section->addText(
					'',
					array('name' => 'Tahoma', 'size' => 12)
				);

				$section->addText(
					'輸入業者 (Importer)',
					array('name' => 'Tahoma', 'size' => 14, 'bold' => true)
				);

				$section->addText(
					'COVUE JAPAN K.K. (株式会社)',
					array('name' => 'Tahoma', 'size' => 14, 'bold' => true)
				);

				$section->addText(
					'〒541-0052',
					array('name' => 'Tahoma', 'size' => 12)
				);

				$section->addText(
					'1-6-19 Azuchimachi Chuo-ku, Osaka, 541-0052 Japan',
					array('name' => 'Tahoma', 'size' => 12)
				);

				$section->addText(
					'',
					array('name' => 'Tahoma', 'size' => 12)
				);

				$section->addText(
					'Logiport Amagasaki 403, 20 Ougimachi Amagasaki, Hyogo, 660-0096, Japan',
					array('name' => 'Tahoma', 'size' => 12)
				);

				$section->addText(
					'',
					array('name' => 'Tahoma', 'size' => 12)
				);

				$section->addText(
					'https://www.covue.com',
					array('name' => 'Tahoma', 'size' => 12)
				);

				$section->addText(
					'',
					array('name' => 'Tahoma', 'size' => 12)
				);

				$section->addText(
					'Made In: ' . $country_of_origin,
					array('name' => 'Tahoma', 'size' => 12)
				);

				$section->addText(
					'Expiration Date: ' . $expiration_date,
					array('name' => 'Tahoma', 'size' => 12)
				);

				// Saving the document as OOXML file...
				$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007', $download = true);
				header("Content-Disposition: attachment; filename=Product label for Product ID - " . $data['product_label_details']->product_registration_id . ".docx");
				$objWriter->save('php://output');
			} else {
				$this->load->view('page', $data);
			}
		}
	}

	public function do_upload_product_label()
	{

		$product_registration_id = $this->input->post('product_registration_id');

		$q_fetch_product_registration = $this->Product_registration_model->fetch_product_registration($product_registration_id);
		$product_registration_data = $q_fetch_product_registration->row();

		$current_timestamp = now();
		$upload_path_file = 'uploads/product_labels/' . $product_registration_data->user_id;

		if (!file_exists($upload_path_file)) {
			mkdir($upload_path_file, 0777, true);
		}

		$config['upload_path'] = $upload_path_file;
		$config['allowed_types'] = 'pdf|jpg|jpeg|png|doc|docx';
		$config['max_size'] = 5000000;
		$config['file_name'] = 'product_label_' . $current_timestamp;

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('product_label')) {
			echo 0;
		} else {
			$product_label_filename = $config['file_name'] . $this->upload->data('file_ext');
			echo $product_label_filename;
		}
	}

	public function upload_product_label()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		}

		$product_label_filename = $this->input->post('product_label');
		$product_label_id = $this->input->post('product_label_id');

		$updated_by = $this->session->userdata('user_id');
		$updated_at = date('Y-m-d H:i:s');

		$result = $this->Product_registration_model->update_product_label_generated($product_label_id, $product_label_filename, $updated_by, $updated_at);

		echo $result;
	}

	public function product_label_approve()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		}

		$subject = 'Product Label is now Available';
		$template = 'emails/product_label_approved.php';

		$id = $this->input->post('id');

		$updated_by = $this->session->userdata('user_id');
		$updated_at = date('Y-m-d H:i:s');

		$q_product_label = $this->Product_registration_model->fetch_product_label($id);
		$product_label = $q_product_label->row();

		$contact_person = $product_label->contact_person;

		$result = array();

		$result[] = $this->Product_registration_model->update_product_label_approve($id, $updated_by, $updated_at);
		$result[] = $this->Product_registration_model->update_product_registration_label($product_label->product_registration_id, $product_label->product_label_filename, $updated_by, $updated_at);

		if (in_array(0, $result)) {
			echo 0;
		} else {
			$this->send_mail($product_label->email, $template, $product_label->product_label_id, '', $subject, $contact_person);
			echo 1;
		}
	}

	public function product_label_on_process()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		}

		$id = $this->input->post('id');

		$updated_by = $this->session->userdata('user_id');
		$updated_at = date('Y-m-d H:i:s');

		$result = $this->Product_registration_model->update_product_label_on_process($id, $updated_by, $updated_at);

		echo $result;
	}

	public function product_label_revision()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		}

		$this->users->clear_apost();

		$subject = 'Product Label Needs Revisions';
		$template = 'emails/notification_revision.php';

		$id = $this->input->post('id');
		$message = $this->input->post('message');

		$created_by = $this->session->userdata('user_id');
		$created_at = date('Y-m-d H:i:s');

		$q_product_label = $this->Product_registration_model->fetch_product_label($id);
		$product_label = $q_product_label->row();

		$contact_person = $product_label->contact_person;

		$result = array();

		$result[] = $this->Product_registration_model->update_product_label_revision($id, $created_by, $created_at);
		$result[] = $this->Product_registration_model->create_revision_message($id, $message, $created_by, $created_at);

		if (in_array(0, $result)) {
			echo 0;
		} else {
			$this->send_mail($product_label->email, $template, $product_label->product_label_id, $message, $subject, $contact_person);
			echo 1;
		}
	}

	public function update_product_category()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		}

		$id = $this->input->post('product_registration_id');
		$product_category_id = $this->input->post('product_category_id');
		$user_id = $this->input->post('user_id');

		$updated_at = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('user_id');

		$q_user_details = $this->Product_registration_model->fetch_user_by_id($user_id);
		$data['user_details'] = $q_user_details->row();

		if ($product_category_id == 1 || $product_category_id == 8 || $product_category_id == 11) {
			$result = $this->Product_registration_model->update_product_category($id, $product_category_id, $updated_at, $updated_by);
		} else {
			$result = $this->Product_registration_model->update_product_category_regulated($id, $product_category_id, $updated_at, $updated_by);
		}

		if ($result == 1) {
			if ($product_category_id != 1 && $product_category_id != 8 && $product_category_id != 11) {
				$subject = 'Product Registration Status';
				$template = 'emails/product_category_reg_notif.php';
				$this->send_mail($data['user_details']->email, $template, $id, '', $subject, $data['user_details']->contact_person);
			}

			if ($product_category_id == 8) {
				$subject = 'Product Registration Status';
				$template = 'emails/japan_radio_notif.php';
				$this->send_mail($data['user_details']->email, $template, $id, '', $subject, $data['user_details']->contact_person);
			}

			if ($product_category_id == 11) {
				$subject = 'Product Registration Status';
				$template = 'emails/baby_products_notif.php';
				$this->send_mail($data['user_details']->email, $template, $id, '', $subject, $data['user_details']->contact_person);
			}

			echo $result;
		}
	}

	public function send_mail($to_email, $template, $id, $custom, $subject, $contact_person)
	{
		$mail = $this->phpmailer_library->load();
		// $mail->SMTPDebug = 1;
		$mail->isSMTP();
		$mail->Host     = 'mail.covueior.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'admin@covueior.com';
		$mail->Password = 'Y.=Sa3hZxq+>@6';
		// $mail->SMTPSecure = 'ssl'; // tls
		$mail->Port     = 26; // 587
		$mail->setFrom('admin@covueior.com', 'COVUE IOR Japan');
		$mail->addAddress($to_email);
		$mail->addBCC('mikecoros05@gmail.com');
		$mail->Subject = $subject;
		$mail->isHTML(true);

		$data['product_qualification_id'] = $id;
		$data['custom'] = $custom;
		$data['contact_person'] = $contact_person;
		$mailContent = $this->load->view($template, $data, true);

		$mail->Body = $mailContent;

		if ($mail->send()) {
			$message = 'success';
		} else {
			$message = 'failed';
		}

		return $message;
	}

	public function mailing_products(){
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		} else {
			$data['external_page'] = 0;
			$data['active_page'] = "product_registrations";
			$data['active_url'] = "product_registrations/mailing_products";
			$data['page_view'] = 'product_registrations/product_registration_v';
			$data['user_id'] = $this->session->userdata('user_id');
			$q_user_details = $this->Product_registration_model->fetch_user_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			
			$data['admin'] = $this->session->userdata('admin');

			$q_product_registrations = $this->Product_registration_model->fetch_product_registrations_mailing_products();
			$data['product_registrations'] = $q_product_registrations->result();

			$q_product_categories = $this->Product_registration_model->fetch_product_categories();
			$data['product_categories'] = $q_product_categories->result();

			$this->load->view('page', $data);
		}
	}
}
