<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shipping_details extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation', 'session', 'upload'));
		$this->load->module('users');
		$this->load->model('Shipping_details_model');
		$this->load->library('phpmailer_library');
	}

	public function index()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		}

		$data['external_page'] = 0;
		$data['active_page'] = "shipping_details";
		$data['active_url'] = "shipping_details";
		$data['page_view'] = 'shipping_details/shipping_details_v';

		$q_all_shipping = $this->Shipping_details_model->fetch_all_shipping();
		$data['all_shipping'] = $q_all_shipping->result();

		$this->load->view('page', $data);
	}

	public function pending()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		}

		$data['external_page'] = 0;
		$data['active_page'] = "shipping_details";
		$data['active_url'] = "shipping_details/pending";
		$data['page_view'] = 'shipping_details/shipping_details_v';

		$q_all_shipping = $this->Shipping_details_model->fetch_shipping_pending();
		$data['all_shipping'] = $q_all_shipping->result();

		$this->load->view('page', $data);
	}

	public function accepted()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		}

		$data['external_page'] = 0;
		$data['active_page'] = "shipping_details";
		$data['active_url'] = "shipping_details/accepted";
		$data['page_view'] = 'shipping_details/shipping_details_v';

		$q_all_shipping = $this->Shipping_details_model->fetch_shipping_accepted();
		$data['all_shipping'] = $q_all_shipping->result();

		$this->load->view('page', $data);
	}

	public function revisions()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		}

		$data['external_page'] = 0;
		$data['active_page'] = "shipping_details";
		$data['active_url'] = "shipping_details/revisions";
		$data['page_view'] = 'shipping_details/shipping_details_v';

		$q_all_shipping = $this->Shipping_details_model->fetch_shipping_revisions();
		$data['all_shipping'] = $q_all_shipping->result();

		$this->load->view('page', $data);
	}

	public function updated()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		}

		$data['external_page'] = 0;
		$data['active_page'] = "shipping_details";
		$data['active_url'] = "shipping_details/updated";
		$data['page_view'] = 'shipping_details/shipping_details_v';

		$q_all_shipping = $this->Shipping_details_model->fetch_shipping_updated();
		$data['all_shipping'] = $q_all_shipping->result();

		$this->load->view('page', $data);
	}

	public function completed()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		}

		$data['external_page'] = 0;
		$data['active_page'] = "shipping_details";
		$data['active_url'] = "shipping_details/completed";
		$data['page_view'] = 'shipping_details/shipping_details_v';

		$q_all_shipping = $this->Shipping_details_model->fetch_shipping_completed();
		$data['all_shipping'] = $q_all_shipping->result();

		$this->load->view('page', $data);
	}

	public function accept_shipping()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		}

		$subject = 'IOR Shipping Details Status';
		$template = 'emails/notification_accepted.php';

		$shipping_id = $this->input->post('id');

		$updated_at = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('user_id');

		$q_shipping_id = $this->Shipping_details_model->fetch_shipping_by_id($shipping_id);
		$shipping = $q_shipping_id->row();

		$contact_person = $shipping->contact_person;

		$result = $this->Shipping_details_model->accept_shipping($shipping_id, $updated_at, $updated_by);

		if ($result == 1) {
			$this->send_mail($shipping->email, $template, '', $subject, $contact_person);
			echo $result;
		}
	}

	public function edit_shipping()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		}

		$this->users->clear_apost();

		$data['external_page'] = 0;
		$data['active_page'] = "shipping_details";
		$data['page_view'] = 'shipping_details/edit_shipping';

		$get_id = $this->uri->segment(3);

		$q_shipping_details = $this->Shipping_details_model->fetch_shipping_by_id($get_id);
		$data['shipping_details_data'] = $q_shipping_details->row();

		$q_hscodes = $this->Shipping_details_model->fetch_hscode($data['shipping_details_data']->user_id);
		$data['hscodes'] = $q_hscodes->result();

		if (isset($_POST['submit'])) {

			if (!empty($_FILES['shipping_invoice']['name']) && empty($_FILES['amazon_seller']['name'])) {

				$current_timestamp = now();
				$upload_path_file = 'uploads/shipping_invoice/' . $data['shipping_details_data']->user_id;
				$upload_filename = pathinfo($_FILES['shipping_invoice']['name'], PATHINFO_FILENAME);

				if (!file_exists($upload_path_file)) {
					mkdir($upload_path_file, 0777, true);
				}

				$config['upload_path'] = $upload_path_file;
				$config['allowed_types'] = 'pdf|jpg|jpeg|png';
				$config['max_size'] = 5000000;
				$config['file_name'] = str_replace(array('\'', ' '), "_", $upload_filename . '_' . $current_timestamp);

				$this->upload->initialize($config);

				if (!$this->upload->do_upload('shipping_invoice')) {

					$data['errors'] = 2;
					$data['error_msgs'] = $this->upload->display_errors();

					$q_shipping_details = $this->Shipping_details_model->fetch_shipping_by_id($get_id);
					$data['shipping_details_data'] = $q_shipping_details->row();

					$q_hscodes = $this->Shipping_details_model->fetch_hscode($data['shipping_details_data']->user_id);
					$data['hscodes'] = $q_hscodes->result();

					$this->load->view('page', $data);
				} else {

					$this->form_validation->set_rules('hscode_ship[]', 'HS Code', 'trim|required');
					$this->form_validation->set_rules('total_value_of_shipment', 'Total Value of Shipment', 'trim|required');

					if ($this->form_validation->run() == FALSE) {

						$q_shipping_details = $this->Shipping_details_model->fetch_shipping_by_id($get_id);
						$data['shipping_details_data'] = $q_shipping_details->row();

						$q_hscodes = $this->Shipping_details_model->fetch_hscode($data['shipping_details_data']->user_id);
						$data['hscodes'] = $q_hscodes->result();

						$this->load->view('page', $data);
					} else {

						$q_shipping_details_before = $this->Shipping_details_model->fetch_shipping_by_id($get_id);
						$shipping_details_before = $q_shipping_details_before->row();

						$hscode_ship = implode(", ", $this->input->post('hscode_ship'));
						$total_value = $this->input->post('total_value_of_shipment');
						$total_value_formatted = str_replace(',', '', $total_value);
						$is_paid = $this->input->post('is_paid');

						$updated_at = date('Y-m-d H:i:s');
						$updated_by = $this->session->userdata('user_id');

						$result = $this->Shipping_details_model->update_shipping_with_shipping_invoice($get_id, $hscode_ship, $total_value_formatted, $config['file_name'] . $this->upload->data('file_ext'), $is_paid, $updated_at, $updated_by);

						if ($result == 1) {
							$data['errors'] = 0;

							$q_shipping_details = $this->Shipping_details_model->fetch_shipping_by_id($get_id);
							$data['shipping_details_data'] = $q_shipping_details->row();

							$q_hscodes = $this->Shipping_details_model->fetch_hscode($data['shipping_details_data']->user_id);
							$data['hscodes'] = $q_hscodes->result();

							if ($is_paid == 1 && $shipping_details_before->is_paid == 0) {

								$this->Shipping_details_model->accept_shipping_if_paid($get_id);

								$subject = 'Covue IOR Shipping Status';
								$template = 'emails/success_ior_shipping.php';
								$q_fetch_user = $this->Shipping_details_model->fetch_user_by_shipping_id($get_id);
								$fetch_user = $q_fetch_user->row();
								$contact_person = $fetch_user->contact_person;
								$this->send_mail($fetch_user->email, $template, '', $subject, $contact_person);
							}

							$this->load->view('page', $data);
						} else {
							$data['errors'] = 1;

							$q_shipping_details = $this->Shipping_details_model->fetch_shipping_by_id($get_id);
							$data['shipping_details_data'] = $q_shipping_details->row();

							$q_hscodes = $this->Shipping_details_model->fetch_hscode($data['shipping_details_data']->user_id);
							$data['hscodes'] = $q_hscodes->result();

							$this->load->view('page', $data);
						}
					}
				}
			} elseif (empty($_FILES['shipping_invoice']['name']) && !empty($_FILES['amazon_seller']['name'])) {

				$current_timestamp = now();
				$upload_path_file = 'uploads/amazon_seller/' . $data['shipping_details_data']->user_id;
				$upload_filename = pathinfo($_FILES['amazon_seller']['name'], PATHINFO_FILENAME);

				if (!file_exists($upload_path_file)) {
					mkdir($upload_path_file, 0777, true);
				}

				$config['upload_path'] = $upload_path_file;
				$config['allowed_types'] = 'pdf|jpg|jpeg|png';
				$config['max_size'] = 5000000;
				$config['file_name'] = str_replace(array('\'', ' '), "_", $upload_filename . '_' . $current_timestamp);

				$this->upload->initialize($config);

				if (!$this->upload->do_upload('amazon_seller')) {

					$data['errors'] = 2;
					$data['error_msgs'] = $this->upload->display_errors();

					$q_shipping_details = $this->Shipping_details_model->fetch_shipping_by_id($get_id);
					$data['shipping_details_data'] = $q_shipping_details->row();

					$q_hscodes = $this->Shipping_details_model->fetch_hscode($data['shipping_details_data']->user_id);
					$data['hscodes'] = $q_hscodes->result();

					$this->load->view('page', $data);
				} else {

					$this->form_validation->set_rules('hscode_ship[]', 'HS Code', 'trim|required');
					$this->form_validation->set_rules('total_value_of_shipment', 'Total Value of Shipment', 'trim|required');

					if ($this->form_validation->run() == FALSE) {

						$q_shipping_details = $this->Shipping_details_model->fetch_shipping_by_id($get_id);
						$data['shipping_details_data'] = $q_shipping_details->row();

						$q_hscodes = $this->Shipping_details_model->fetch_hscode($data['shipping_details_data']->user_id);
						$data['hscodes'] = $q_hscodes->result();

						$this->load->view('page', $data);
					} else {

						$q_shipping_details_before = $this->Shipping_details_model->fetch_shipping_by_id($get_id);
						$shipping_details_before = $q_shipping_details_before->row();

						$hscode_ship = implode(", ", $this->input->post('hscode_ship'));
						$total_value = $this->input->post('total_value_of_shipment');
						$total_value_formatted = str_replace(',', '', $total_value);
						$is_paid = $this->input->post('is_paid');

						$updated_at = date('Y-m-d H:i:s');
						$updated_by = $this->session->userdata('user_id');

						$result = $this->Shipping_details_model->update_shipping_with_amazon_seller($get_id, $hscode_ship, $total_value_formatted, $config['file_name'] . $this->upload->data('file_ext'), $is_paid, $updated_at, $updated_by);

						if ($result == 1) {
							$data['errors'] = 0;

							$q_shipping_details = $this->Shipping_details_model->fetch_shipping_by_id($get_id);
							$data['shipping_details_data'] = $q_shipping_details->row();

							$q_hscodes = $this->Shipping_details_model->fetch_hscode($data['shipping_details_data']->user_id);
							$data['hscodes'] = $q_hscodes->result();

							if ($is_paid == 1 && $shipping_details_before->is_paid == 0) {

								$this->Shipping_details_model->accept_shipping_if_paid($get_id);

								$subject = 'Covue IOR Shipping Status';
								$template = 'emails/success_ior_shipping.php';
								$q_fetch_user = $this->Shipping_details_model->fetch_user_by_shipping_id($get_id);
								$fetch_user = $q_fetch_user->row();
								$contact_person = $fetch_user->contact_person;
								$this->send_mail($fetch_user->email, $template, '', $subject, $contact_person);
							}

							$this->load->view('page', $data);
						} else {
							$data['errors'] = 1;

							$q_shipping_details = $this->Shipping_details_model->fetch_shipping_by_id($get_id);
							$data['shipping_details_data'] = $q_shipping_details->row();

							$q_hscodes = $this->Shipping_details_model->fetch_hscode($data['shipping_details_data']->user_id);
							$data['hscodes'] = $q_hscodes->result();

							$this->load->view('page', $data);
						}
					}
				}
			} elseif (!empty($_FILES['shipping_invoice']['name']) && !empty($_FILES['amazon_seller']['name'])) {

				$current_timestamp = now();
				$upload_path_file = 'uploads/shipping_invoice/' . $data['shipping_details_data']->user_id;
				$upload_filename = pathinfo($_FILES['shipping_invoice']['name'], PATHINFO_FILENAME);

				if (!file_exists($upload_path_file)) {
					mkdir($upload_path_file, 0777, true);
				}

				$config1['upload_path'] = $upload_path_file;
				$config1['allowed_types'] = 'pdf|jpg|jpeg|png';
				$config1['max_size'] = 5000000;
				$config1['file_name'] = str_replace(array('\'', ' '), "_", $upload_filename . '_a' . $current_timestamp);

				$this->upload->initialize($config1);

				if (!$this->upload->do_upload('shipping_invoice')) {

					$data['errors'] = 2;
					$data['error_msgs'] = $this->upload->display_errors();

					$q_shipping_details = $this->Shipping_details_model->fetch_shipping_by_id($get_id);
					$data['shipping_details_data'] = $q_shipping_details->row();

					$q_hscodes = $this->Shipping_details_model->fetch_hscode($data['shipping_details_data']->user_id);
					$data['hscodes'] = $q_hscodes->result();

					$this->load->view('page', $data);
				} else {

					$shipping_invoice_filename = $config1['file_name'] . $this->upload->data('file_ext');

					$current_timestamp = now();
					$upload_path_file = 'uploads/amazon_seller/' . $data['shipping_details_data']->user_id;
					$upload_filename = pathinfo($_FILES['amazon_seller']['name'], PATHINFO_FILENAME);

					if (!file_exists($upload_path_file)) {
						mkdir($upload_path_file, 0777, true);
					}

					$config2['upload_path'] = $upload_path_file;
					$config2['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config2['max_size'] = 5000000;
					$config2['file_name'] = str_replace(array('\'', ' '), "_", $upload_filename . '_b' . $current_timestamp);

					$this->upload->initialize($config2);

					if (!$this->upload->do_upload('amazon_seller')) {

						$data['errors'] = 2;
						$data['error_msgs'] = $this->upload->display_errors();

						$q_shipping_details = $this->Shipping_details_model->fetch_shipping_by_id($get_id);
						$data['shipping_details_data'] = $q_shipping_details->row();

						$q_hscodes = $this->Shipping_details_model->fetch_hscode($data['shipping_details_data']->user_id);
						$data['hscodes'] = $q_hscodes->result();

						$this->load->view('page', $data);
					} else {

						$amazon_seller_filename = $config2['file_name'] . $this->upload->data('file_ext');

						$this->form_validation->set_rules('hscode_ship[]', 'HS Code', 'trim|required');
						$this->form_validation->set_rules('total_value_of_shipment', 'Total Value of Shipment', 'trim|required');

						if ($this->form_validation->run() == FALSE) {

							$q_shipping_details = $this->Shipping_details_model->fetch_shipping_by_id($get_id);
							$data['shipping_details_data'] = $q_shipping_details->row();

							$q_hscodes = $this->Shipping_details_model->fetch_hscode($data['shipping_details_data']->user_id);
							$data['hscodes'] = $q_hscodes->result();

							$this->load->view('page', $data);
						} else {

							$q_shipping_details_before = $this->Shipping_details_model->fetch_shipping_by_id($get_id);
							$shipping_details_before = $q_shipping_details_before->row();

							$hscode_ship = implode(", ", $this->input->post('hscode_ship'));
							$total_value = $this->input->post('total_value_of_shipment');
							$total_value_formatted = str_replace(',', '', $total_value);
							$is_paid = $this->input->post('is_paid');

							$updated_at = date('Y-m-d H:i:s');
							$updated_by = $this->session->userdata('user_id');

							$result = $this->Shipping_details_model->update_shipping_both_uploads($get_id, $hscode_ship, $total_value_formatted, $shipping_invoice_filename, $amazon_seller_filename, $is_paid, $updated_at, $updated_by);

							if ($result == 1) {
								$data['errors'] = 0;

								$q_shipping_details = $this->Shipping_details_model->fetch_shipping_by_id($get_id);
								$data['shipping_details_data'] = $q_shipping_details->row();

								$q_hscodes = $this->Shipping_details_model->fetch_hscode($data['shipping_details_data']->user_id);
								$data['hscodes'] = $q_hscodes->result();

								if ($is_paid == 1 && $shipping_details_before->is_paid == 0) {

									$this->Shipping_details_model->accept_shipping_if_paid($get_id);

									$subject = 'Covue IOR Shipping Status';
									$template = 'emails/success_ior_shipping.php';
									$q_fetch_user = $this->Shipping_details_model->fetch_user_by_shipping_id($get_id);
									$fetch_user = $q_fetch_user->row();
									$contact_person = $fetch_user->contact_person;
									$this->send_mail($fetch_user->email, $template, '', $subject, $contact_person);
								}

								$this->load->view('page', $data);
							} else {
								$data['errors'] = 1;

								$q_shipping_details = $this->Shipping_details_model->fetch_shipping_by_id($get_id);
								$data['shipping_details_data'] = $q_shipping_details->row();

								$q_hscodes = $this->Shipping_details_model->fetch_hscode($data['shipping_details_data']->user_id);
								$data['hscodes'] = $q_hscodes->result();

								$this->load->view('page', $data);
							}
						}
					}
				}
			} else {

				$this->form_validation->set_rules('hscode_ship[]', 'HS Code', 'trim|required');
				$this->form_validation->set_rules('total_value_of_shipment', 'Total Value of Shipment', 'trim|required');

				if ($this->form_validation->run() == FALSE) {

					$q_shipping_details = $this->Shipping_details_model->fetch_shipping_by_id($get_id);
					$data['shipping_details_data'] = $q_shipping_details->row();

					$q_hscodes = $this->Shipping_details_model->fetch_hscode($data['shipping_details_data']->user_id);

					$this->load->view('page', $data);
				} else {

					$q_shipping_details_before = $this->Shipping_details_model->fetch_shipping_by_id($get_id);
					$shipping_details_before = $q_shipping_details_before->row();

					$hscode_ship = implode(", ", $this->input->post('hscode_ship'));
					$total_value = $this->input->post('total_value_of_shipment');
					$total_value_formatted = str_replace(',', '', $total_value);
					$is_paid = $this->input->post('is_paid');

					$updated_at = date('Y-m-d H:i:s');
					$updated_by = $this->session->userdata('user_id');

					$result = $this->Shipping_details_model->update_shipping_no_uploads($get_id, $hscode_ship, $total_value_formatted, $is_paid, $updated_at, $updated_by);

					if ($result == 1) {
						$data['errors'] = 0;

						$q_shipping_details = $this->Shipping_details_model->fetch_shipping_by_id($get_id);
						$data['shipping_details_data'] = $q_shipping_details->row();

						$q_hscodes = $this->Shipping_details_model->fetch_hscode($data['shipping_details_data']->user_id);

						if ($is_paid == 1 && $shipping_details_before->is_paid == 0) {

							$this->Shipping_details_model->accept_shipping_if_paid($get_id);

							$subject = 'Covue IOR Shipping Status';
							$template = 'emails/success_ior_shipping.php';
							$q_fetch_user = $this->Shipping_details_model->fetch_user_by_shipping_id($get_id);
							$fetch_user = $q_fetch_user->row();
							$contact_person = $fetch_user->contact_person;
							$this->send_mail($fetch_user->email, $template, '', $subject, $contact_person);
						}

						$this->load->view('page', $data);
					} else {
						$data['errors'] = 1;

						$q_shipping_details = $this->Shipping_details_model->fetch_shipping_by_id($get_id);
						$data['shipping_details_data'] = $q_shipping_details->row();

						$q_hscodes = $this->Shipping_details_model->fetch_hscode($data['shipping_details_data']->user_id);

						$this->load->view('page', $data);
					}
				}
			}
		} else {
			$this->load->view('page', $data);
		}
	}

	public function revision_shipping()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		}

		$this->users->clear_apost();

		$subject = 'IOR Shipping Details Status';
		$template = 'emails/notification_revision.php';

		$shipping_id = $this->input->post('id');
		$revisions_msg = $this->input->post('revisions_msg');

		$updated_at = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('user_id');

		$q_shipping_id = $this->Shipping_details_model->fetch_shipping_by_id($shipping_id);
		$shipping = $q_shipping_id->row();

		$contact_person = $shipping->contact_person;

		$result = $this->Shipping_details_model->revision_shipping($shipping_id, $revisions_msg, $updated_at, $updated_by);

		if ($result == 1) {
			$this->send_mail($shipping->email, $template, $revisions_msg, $subject, $contact_person);
			echo $result;
		}
	}

	public function do_upload()
	{

		$current_timestamp = now();
		$upload_path_file = 'uploads/custom_report';

		if (!file_exists($upload_path_file)) {
			mkdir($upload_path_file, 0777, true);
		}

		$config['upload_path'] = $upload_path_file;
		$config['allowed_types'] = 'pdf|jpg|jpeg|png';
		$config['max_size'] = 5000000;
		$config['file_name'] = 'custom_report_' . $current_timestamp;

		$this->upload->initialize($config);

		$result = 0;

		if (!$this->upload->do_upload('custom_report')) {
			$result = 0;
		} else {
			$custom_report_filename = $config['file_name'] . $this->upload->data('file_ext');
			echo $custom_report_filename;
		}
	}

	public function completed_shipping()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		}

		$subject = 'IOR Shipping Details Status';
		$template = 'emails/notification_completed.php';

		$custom_report_filename = $this->input->post('custom_report_filename');
		$shipping_id = $this->input->post('custom_report_id');

		$updated_at = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('user_id');

		$q_shipping_id = $this->Shipping_details_model->fetch_shipping_by_id($shipping_id);
		$shipping = $q_shipping_id->row();

		$contact_person = $shipping->contact_person;

		$result = $this->Shipping_details_model->completed_shipping($shipping_id, $custom_report_filename, $updated_at, $updated_by);

		if ($result == 1) {
			$this->send_mail($shipping->email, $template, '', $subject, $contact_person);
			echo $result;
		}
	}

	public function delete_shipping()
	{
		if (!$this->users->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		}

		$shipping_id = $this->input->post('id');

		$updated_at = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('user_id');

		$q_shipping_id = $this->Shipping_details_model->fetch_shipping_by_id($shipping_id);
		$shipping = $q_shipping_id->row();

		$result = $this->Shipping_details_model->delete_shipping($shipping_id, $updated_at, $updated_by);

		if ($result == 1) {
			echo $result;
		}
	}

	public function send_mail($to_email, $template, $custom, $subject, $contact_person)
	{
		$mail = $this->phpmailer_library->load();
		// $mail->SMTPDebug = 1;
		$mail->isSMTP();
		$mail->Host     = 'sg2plcpnl0015.prod.sin2.secureserver.net';
		$mail->SMTPAuth = true;
		$mail->Username = '_mainaccount@covue.com';
		$mail->Password = 'llt5MzH!';
		$mail->SMTPSecure = 'ssl'; // tls
		$mail->Port     = 465; // 587
		$mail->setFrom('admin@covueior.com', 'COVUE IOR Japan');
		$mail->addAddress($to_email);
		$mail->addBCC('mikecoros05@gmail.com');
		$mail->Subject = $subject;
		$mail->isHTML(true);

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
}
