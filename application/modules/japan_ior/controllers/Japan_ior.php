<?php
date_default_timezone_set("Asia/Tokyo");

require_once APPPATH . "libraries/tcpdf/tcpdf.php";
require_once APPPATH . "libraries/tcpdf/tcpdf_terms.php";
require_once APPPATH . "libraries/tcpdf/PDFMerger.php";
require_once APPPATH . "libraries/stripe/vendor/autoload.php";

use PDFMerger\PDFMerger;
use setasign\Fpdi\Fpdi;

class Japan_ior extends MX_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'date', 'download'));
		$this->load->library(array('form_validation', 'session', 'upload', 'phpmailer_library', 'paypal_lib', 'image_lib', 'user_agent'));
		$this->load->model('Japan_ior_model');
	}

	public function clear_apost()
	{
		foreach ($_POST as $key => $value) {
			$_POST[$key] = str_replace("'", "&apos;", $value);
		}
	}

	public function clear_amp()
	{
		foreach ($_POST as $key => $value) {
			$_POST[$key] = str_replace("&", "and", $value);
		}
	}

	public function logged_in_external()
	{
		if ($this->session->userdata('admin') != '1' && $this->session->userdata('logged_in') == '1') {
			return true;
		} else {
			$this->session->set_userdata('admin', 0);
			$this->session->set_userdata('contact_person', "");
			$this->session->set_userdata('user_id', 0);
			$this->session->set_userdata('logged_in', '0');
			return false;
		}
	}

	function download($id)
	{
		$q_product_details = $this->Japan_ior_model->fetch_product_registration($id);
		$product_details = $q_product_details->row();

		$file = 'uploads/product_labels/' . $product_details->user_id . '/' . $product_details->product_label . '';
		force_download($file, NULL);
	}

	public function dashboard()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$data['user_id'] = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$data['active_page'] = 'japan-ior/dashboard';
		$data['external_page'] = 2;

		$q_product_registration = $this->Japan_ior_model->fetch_product_registrations_dashboard_limited($data['user_id']);
		$data['product_registrations'] = $q_product_registration->result();

		$data['has_approved_products'] = $this->Japan_ior_model->count_approved_product_registrations($data['user_id']);

		$q_shipping_invoices = $this->Japan_ior_model->fetch_shipping_invoices_by_user_id_limited($data['user_id']);
		$data['shipping_invoices'] = $q_shipping_invoices->result();

		$q_fetch_paid_regulated = $this->Japan_ior_model->fetch_paid_regulated_limited($data['user_id']);
		$data['paid_regulated_applications'] = $q_fetch_paid_regulated->result();

		$data['billing_invoices_unpaid_count'] = $this->Japan_ior_model->fetch_billing_invoices_unpaid($data['user_id']);

		$q_billing_invoices = $this->Japan_ior_model->fetch_billing_invoices_limited($data['user_id']);
		$data['billing_invoices'] = $q_billing_invoices->result();

		$data['billing_invoices_unpaid_count'] = $this->Japan_ior_model->fetch_billing_invoices_unpaid($data['user_id']);

		if ($data['user_details']->ior_registered == 0 || $data['user_details']->pli == 0) {
			$this->session->set_flashdata('new_launch', 'New Launch!');
		}

		$this->session->set_flashdata('modal_holidays', 'Holiday Notice');

		$data['page_view'] = 'japan_ior/index/dashboard';
		$this->load->view('page', $data);
	}

	public function lab_test_results()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$data['external_page'] = 2;
		$data['active_page'] = "regulated_applications";
		$data['active_url'] = "regulated_applications";
		$data['page_view'] = 'japan_ior/regulated_applications/lab_test_results';

		$data['regulated_application_id'] = $this->uri->segment(3);

		$q_fetch_labtest = $this->Japan_ior_model->fetch_labtest($data['regulated_application_id']);

		$data['labtests'] = $q_fetch_labtest->result();
		$this->load->view('page', $data);
	}

	public function download_lab_test($file, $regulated_application_id)
	{
		$this->load->helper('download');
		$name = $file;
		$data = file_get_contents('./uploads/regulated_applications/' . $regulated_application_id . '/lab_testing/' . $file);
		force_download($name, $data);
		redirect('japan-ior/regulated-applications/lab-test-results/' . $this->uri->segment(3), 'refresh');
	}

	public function edit_profile()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {

			$get_id = $this->uri->segment(3);

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($get_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			} else {
				if ($this->uri->segment(3) != $this->session->userdata('user_id')) {
					redirect('/japan-ior/dashboard');
				}
			}
		}

		$this->clear_apost();

		$data['external_page'] = 2;
		$data['active_page'] = 'user_profile';

		$q_fetch_countries = $this->Japan_ior_model->fetch_countries();
		$data['countries'] = $q_fetch_countries->result();

		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('company_address', 'Company Address', 'trim|required');
			$this->form_validation->set_rules('city', 'City', 'trim|required');
			$this->form_validation->set_rules('country', 'Country', 'trim|required|integer');
			$this->form_validation->set_rules('zip_code', 'Zip Code', 'trim|required');
			$this->form_validation->set_rules('contact_person', 'Primary Contact Person', 'trim|required');
			$this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|required');
			$this->form_validation->set_rules('online_seller', 'Online Seller', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$q_user_details = $this->Japan_ior_model->fetch_users_by_id($get_id);
				$data['user_details'] = $q_user_details->row();

				$q_fetch_countries = $this->Japan_ior_model->fetch_countries();
				$data['countries'] = $q_fetch_countries->result();

				$data['page_view'] = 'japan_ior/index/edit_profile';
				$this->load->view('page', $data);
			} else {
				$username = stripslashes($this->input->post('username'));
				$password = stripslashes($this->input->post('password'));
				$company_address = stripslashes($this->input->post('company_address'));
				$city = stripslashes($this->input->post('city'));
				$country = stripslashes($this->input->post('country'));
				$zip_code = stripslashes($this->input->post('zip_code'));
				$contact_person = stripslashes($this->input->post('contact_person'));
				$contact_number = stripslashes($this->input->post('contact_number'));
				$online_seller = $this->input->post('online_seller');
				$updated_by = $this->session->userdata('user_id');
				$updated_at = date('Y-m-d H:i:s');

				$result = $this->Japan_ior_model->update_user($get_id, $username, $password, $company_address, $city, $country, $zip_code, $contact_person, $contact_number, $online_seller, $updated_by, $updated_at);

				if ($result == 1) {
					$this->session->set_flashdata('success', 'Successfully updated your profile.');
					redirect('japan-ior/edit-profile/' . $get_id, 'refresh');
				} else {
					$data['errors'] = 1;

					$q_user_details = $this->Japan_ior_model->fetch_users_by_id($get_id);
					$data['user_details'] = $q_user_details->row();

					$q_fetch_countries = $this->Japan_ior_model->fetch_countries();
					$data['countries'] = $q_fetch_countries->result();

					$data['page_view'] = 'japan_ior/index/edit_profile';
					$this->load->view('page', $data);
				}
			}
		} else {
			$data['page_view'] = 'japan_ior/index/edit_profile';
			$this->load->view('page', $data);
		}
	}

	public function my_files()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {

			$get_id = $this->uri->segment(3);

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($get_id);
			$data['user_details'] = $q_user_details->row();

			$q_user_files = $this->Japan_ior_model->fetch_users_file($get_id);
			$data['user_files'] = $q_user_files->result();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			} else {
				if ($this->uri->segment(3) != $this->session->userdata('user_id')) {
					redirect('/japan-ior/dashboard');
				}
			}
		}

		$this->clear_apost();

		$data['external_page'] = 2;
		$data['active_page'] = 'user_profile';

		if (isset($_POST['upload-file'])) {
			$result = $this->Japan_ior_model->upload_file($_POST, $get_id);
			if ($result == 1) {
				$this->session->set_flashdata('success', 'Upload upload Success!');
				redirect('japan-ior/my-files/' . $get_id, 'refresh');
			}
		} else {
			$data['page_view'] = 'japan_ior/index/user_files';
			$this->load->view('page', $data);
		}
	}


	public function logout()
	{
		$this->session->set_userdata('admin', 0);
		$this->session->set_userdata('contact_person', "");
		$this->session->set_userdata('user_id', 0);
		$this->session->set_userdata('logged_in', '0');
		redirect('/home/login');
	}

	public function products_list()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$data['user_id'] = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'product_registrations';
		$data['active_url'] = "japan-ior/products-list";
		$data['page_view'] = 'japan_ior/product_registrations/products_list';

		$q_product_registration = $this->Japan_ior_model->fetch_product_registrations_dashboard($data['user_id']);
		$data['product_registrations'] = $q_product_registration->result();

		$data['has_approved_products'] = $this->Japan_ior_model->count_approved_product_registrations($data['user_id']);

		$this->load->view('page', $data);
	}

	public function product_registration()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$this->clear_apost();

		$data['external_page'] = 2;
		$data['active_page'] = 'product_registrations';
		$data['active_url'] = "japan-ior/product-registration";

		if ($user_id > 106 || $user_id == 7 || $user_id == 65 || $user_id == 67 || $user_id == 68 || $user_id == 74 || $user_id == 77 || $user_id == 78 || $user_id == 80 || $user_id == 81 || $user_id == 82 || $user_id == 85 || $user_id == 90 || $user_id == 91 || $user_id == 93 || $user_id == 95 || $user_id == 96 || $user_id == 98 || $user_id == 99 || $user_id == 100 || $user_id == 103 || $data['user_details']->ior_registered == 0) {
			redirect('/japan-ior/dashboard');
		} else {
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$this->form_validation->set_rules('sku1', 'HS Code', 'trim|required');
				$this->form_validation->set_rules('product_name1', 'Product Name', 'trim|required');

				if (empty($_FILES['product_img1']['name'])) {
					$this->form_validation->set_rules('product_img1', 'Product Image', 'required');
				}

				if ($this->form_validation->run() == FALSE) {
					$data['page_view'] = 'japan_ior/product_registrations/product_registration';
					$this->load->view('page', $data);
				} else {
					$current_timestamp = now();
					$result = array();

					$product_count = 0;

					for ($i = 1; $i <= 3; $i++) {
						if (!empty($this->input->post('sku' . $i . ''))) {
							$product_count++;
						}
					}

					for ($i = 1; $i <= $product_count; $i++) {
						${"sku" . $i} = stripslashes($this->input->post('sku' . $i . ''));
						${"product_name" . $i} = stripslashes($this->input->post('product_name' . $i . ''));

						if (!empty($_FILES['product_img' . $i . '']['name'])) {
							$upload_path_file = 'uploads/product_qualification/' . $user_id;

							if (!file_exists($upload_path_file)) {
								mkdir($upload_path_file, 0777, true);
							}

							$config1['upload_path'] = $upload_path_file;
							$config1['allowed_types'] = 'pdf|jpg|jpeg|png';
							$config1['max_size'] = 5000000;
							$config1['file_name'] = 'product_qualification_0' . $i . '_' . $current_timestamp;

							$this->upload->initialize($config1);

							if (!$this->upload->do_upload('product_img' . $i . '')) {
								$data['error_msgs'] = $this->upload->display_errors();
								$data['errors'] = 2;
								$data['page_view'] = 'japan_ior/product_registrations/product_registration';
								$this->load->view('page', $data);
							} else {
								$created_at = date('Y-m-d H:i:s');
								$product_img_filename = $config1['file_name'] . $this->upload->data('file_ext');
								$product_type = 0;
								$dimensions_by_piece = '';
								$weight_by_piece = '';
								$is_mailing_product = 0;
								${"result" . $i} = $this->Japan_ior_model->insert_product_registration($user_id, ${"sku" . $i}, ${"product_name" . $i}, $product_img_filename, '', $product_type, $dimensions_by_piece, $weight_by_piece, $is_mailing_product, $user_id, $created_at);

								if (${"result" . $i} == 1) {
									array_push($result, ${"result" . $i});
								}
							}
						}
					}

					$results = implode(',', $result);

					if (strpos($results, '1') !== false) {
						$this->session->set_flashdata('success', 'Congratulations, successfully sent products for verification!');
						redirect('japan-ior/products-list', 'refresh');
					} else {
						$data['errors'] = 1;
						$data['page_view'] = 'japan_ior/product_registrations/product_registration';
						$this->load->view('page', $data);
					}
				}
			} else {
				$this->session->set_flashdata('modal_product_name_info', 'Product Name Info');
				$data['page_view'] = 'japan_ior/product_registrations/product_registration';
				$this->load->view('page', $data);
			}
		}
	}

	public function product_registrations()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$this->clear_apost();

		$data['external_page'] = 2;
		$data['active_page'] = 'product_registrations';
		$data['active_url'] = "japan-ior/product-registrations";

		if ($data['user_details']->ior_registered == 0) {
			redirect('/japan-ior/dashboard');;
		} else {
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$this->form_validation->set_rules('sku1', 'HS Code', 'trim|required');
				$this->form_validation->set_rules('product_name1', 'Product Name', 'trim|required');

				if (empty($_FILES['product_img1']['name'])) {
					$this->form_validation->set_rules('product_img1', 'Product Image', 'required');
				}
				if ($data['user_details']->user_role_id != 3) {
					if (empty($_FILES['product_label1']['name'])) {
						$this->form_validation->set_rules('product_label1', 'Product Label', 'required');
					}
				} else {
					$this->form_validation->set_rules('dimensions_by_piece1', 'Dimension by Piece', 'trim|required');
					$this->form_validation->set_rules('weight_by_piece1', 'Weight by Piece', 'trim|required');
					$this->form_validation->set_rules('product_type1', 'Product Type', 'trim|required');
				}


				if ($this->form_validation->run() == FALSE) {
					$data['page_view'] = 'japan_ior/product_registrations/product_registrations';
					$this->load->view('page', $data);
				} else {
					$current_timestamp = now();
					$result = array();

					$product_count = 0;

					for ($i = 1; $i <= 3; $i++) {
						if (!empty($this->input->post('sku' . $i . ''))) {
							$product_count++;
						}
					}

					for ($i = 1; $i <= $product_count; $i++) {
						${"sku" . $i} = stripslashes($this->input->post('sku' . $i . ''));
						${"product_name" . $i} = stripslashes($this->input->post('product_name' . $i . ''));



						if (!empty($_FILES['product_img' . $i . '']['name'])) {
							$upload_path_file = 'uploads/product_qualification/' . $user_id;

							if (!file_exists($upload_path_file)) {
								mkdir($upload_path_file, 0777, true);
							}

							$config1['upload_path'] = $upload_path_file;
							$config1['allowed_types'] = 'pdf|jpg|jpeg|png';
							$config1['max_size'] = 5000000;
							$config1['file_name'] = 'product_qualification_0' . $i . '_' . $current_timestamp;

							$this->upload->initialize($config1);

							if (!$this->upload->do_upload('product_img' . $i . '')) {
								$data['error_msgs'] = $this->upload->display_errors();
								$data['errors'] = 2;
								$data['page_view'] = 'japan_ior/product_registrations/product_registrations';
								$this->load->view('page', $data);
							} else {
								$product_img_filename = $config1['file_name'] . $this->upload->data('file_ext');
								if ($data['user_details']->user_role_id != 3) {

									if (!empty($_FILES['product_label' . $i . '']['name'])) {

										$upload_path_file = 'uploads/product_labels/' . $user_id;

										if (!file_exists($upload_path_file)) {
											mkdir($upload_path_file, 0777, true);
										}

										$config2['upload_path'] = $upload_path_file;
										$config2['allowed_types'] = 'pdf|jpg|jpeg|png';
										$config2['max_size'] = 5000000;
										$config2['file_name'] = 'product_label_0' . $i . '_' . $current_timestamp;

										$this->upload->initialize($config2);

										if (!$this->upload->do_upload('product_label' . $i . '')) {
											$data['error_msgs'] = $this->upload->display_errors();
											$data['errors'] = 2;
											$data['page_view'] = 'japan_ior/product_registrations/product_registrations';
											$this->load->view('page', $data);
										} else {
											$created_at = date('Y-m-d H:i:s');
											$product_label_filename = $config2['file_name'] . $this->upload->data('file_ext');
											$product_type = 0;
											$dimensions_by_piece = '';
											$weight_by_piece = '';
											$is_mailing_product = 0;
											${"result" . $i} = $this->Japan_ior_model->insert_product_registration($user_id, ${"sku" . $i}, ${"product_name" . $i}, $product_img_filename, $product_label_filename, $product_type, $dimensions_by_piece, $weight_by_piece, $is_mailing_product, $user_id, $created_at);

											if (${"result" . $i} == 1) {
												array_push($result, ${"result" . $i});
											}
										}
									}
								} else {
									${"dimensions_by_piece" . $i} = stripslashes($this->input->post('dimensions_by_piece' . $i . ''));
									${"weight_by_piece" . $i} = stripslashes($this->input->post('weight_by_piece' . $i . ''));
									${"product_type" . $i} = stripslashes($this->input->post('product_type' . $i . ''));
									$created_at = date('Y-m-d H:i:s');
									$product_label_filename = '';
									$dimensions_by_piece = ${"dimensions_by_piece" . $i};
									$weight_by_piece = ${"weight_by_piece" . $i};
									$product_type = ${"product_type" . $i};
									$is_mailing_product = 1;
									${"result" . $i} = $this->Japan_ior_model->insert_product_registration($user_id, ${"sku" . $i}, ${"product_name" . $i}, $product_img_filename, $product_label_filename, $product_type, $dimensions_by_piece, $weight_by_piece, $is_mailing_product, $user_id, $created_at);

									if (${"result" . $i} == 1) {
										array_push($result, ${"result" . $i});
									}
								}
							}
						}
					}

					$results = implode(',', $result);

					if (strpos($results, '1') !== false) {
						$this->session->set_flashdata('success', 'Congratulations, successfully sent products for verification!');
						redirect('japan-ior/products-list', 'refresh');
					} else {
						$data['errors'] = 1;
						$data['page_view'] = 'japan_ior/product_registrations/product_registrations';
						$this->load->view('page', $data);
					}
				}
			} else {
				$this->session->set_flashdata('modal_product_name_info', 'Product Name Info');
				$data['page_view'] = 'japan_ior/product_registrations/product_registrations';
				$this->load->view('page', $data);
			}
		}
	}

	public function edit_product()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$data['user_id'] = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$this->clear_apost();

		$data['external_page'] = 2;
		$data['active_page'] = "product_registrations";
		$data['page_view'] = 'japan_ior/product_registrations/edit_product';

		$id = $this->uri->segment(3);

		$q_product_data = $this->Japan_ior_model->fetch_product_registration($id);
		$data['product_data'] = $q_product_data->row();

		if (isset($_POST['submit'])) {
			if (empty($_FILES['product_img']['name']) && empty($_FILES['product_label']['name'])) {
				$this->form_validation->set_rules('sku', 'HS Code', 'trim|required');
				$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');

				if ($data['user_details']->user_role_id == 3) {
					$this->form_validation->set_rules('product_type', 'Product Name', 'trim|required');
					$this->form_validation->set_rules('dimensions_by_piece', 'Dimensions by Piece', 'trim|required');
					$this->form_validation->set_rules('weight_by_piece', 'Weight by Piece', 'trim|required');
				}

				if ($this->form_validation->run() == FALSE) {
					$q_product_data = $this->Japan_ior_model->fetch_product_registration($id);
					$data['product_data'] = $q_product_data->row();
					$this->load->view('page', $data);
				} else {
					$sku = stripslashes($this->input->post('sku'));
					$product_name = stripslashes($this->input->post('product_name'));
					$product_type = stripslashes($this->input->post('product_type'));
					$dimensions_by_piece = stripslashes($this->input->post('dimensions_by_piece'));
					$weight_by_piece = stripslashes($this->input->post('weight_by_piece'));
					$updated_by = $this->session->userdata('user_id');
					$updated_at = date('Y-m-d H:i:s');

					$result = $this->Japan_ior_model->update_products($id, $sku, $product_name, $product_type, $dimensions_by_piece, $weight_by_piece, $updated_by, $updated_at);

					if ($result == 1) {
						$this->session->set_flashdata('success', 'Congratulations, successfully updated your product details!');
						redirect('/japan-ior/edit-product/' . $id, 'refresh');
					} else {
						$data['errors'] = 1;
						$q_product_data = $this->Japan_ior_model->fetch_product_registration($id);
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

					$q_product_data = $this->Japan_ior_model->fetch_product_registration($id);
					$data['product_data'] = $q_product_data->row();

					$this->load->view('page', $data);
				} else {
					$this->form_validation->set_rules('sku', 'HS Code', 'trim|required');
					$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');

					if ($this->form_validation->run() == FALSE) {
						$q_product_data = $this->Japan_ior_model->fetch_product_registration($id);
						$data['product_data'] = $q_product_data->row();
						$this->load->view('page', $data);
					} else {
						$sku = stripslashes($this->input->post('sku'));
						$product_name = stripslashes($this->input->post('product_name'));
						$product_type = stripslashes($this->input->post('product_type'));
						$dimensions_by_piece = stripslashes($this->input->post('dimensions_by_piece'));
						$weight_by_piece = stripslashes($this->input->post('weight_by_piece'));
						$updated_by = $this->session->userdata('user_id');
						$updated_at = date('Y-m-d H:i:s');

						$result = $this->Japan_ior_model->update_products_img($id, $sku, $product_name, $product_type, $dimensions_by_piece, $weight_by_piece, $config['file_name'] . $this->upload->data('file_ext'), $updated_by, $updated_at);

						if ($result == 1) {
							$this->session->set_flashdata('success', 'Successfully updated your product details!');
							redirect('/japan-ior/edit-product/' . $id, 'refresh');
						} else {
							$data['errors'] = 1;
							$q_product_data = $this->Japan_ior_model->fetch_product_registration($id);
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

					$q_product_data = $this->Japan_ior_model->fetch_product_registration($id);
					$data['product_data'] = $q_product_data->row();

					$this->load->view('page', $data);
				} else {
					$this->form_validation->set_rules('sku', 'HS Code', 'trim|required');
					$this->form_validation->set_rules('product_name', 'Product', 'trim|required');

					if ($this->form_validation->run() == FALSE) {
						$q_product_data = $this->Japan_ior_model->fetch_product_registration($id);
						$data['product_data'] = $q_product_data->row();
						$this->load->view('page', $data);
					} else {
						$sku = stripslashes($this->input->post('sku'));
						$product_name = stripslashes($this->input->post('product_name'));
						$updated_by = $this->session->userdata('user_id');
						$updated_at = date('Y-m-d H:i:s');

						$result = $this->Japan_ior_model->update_products_label($id, $sku, $product_name, $config['file_name'] . $this->upload->data('file_ext'), $updated_by, $updated_at);

						if ($result == 1) {
							$this->session->set_flashdata('success', 'Successfully updated your product details!');
							redirect('/japan-ior/edit-product/' . $id, 'refresh');
						} else {
							$data['errors'] = 1;
							$q_product_data = $this->Japan_ior_model->fetch_product_registration($id);
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

					$q_product_data = $this->Japan_ior_model->fetch_product_registration($id);
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

					$q_product_data = $this->Japan_ior_model->fetch_product_registration($id);
					$data['product_data'] = $q_product_data->row();

					$this->load->view('page', $data);
				} else {
					$product_label_filename = $config2['file_name'] . $this->upload->data('file_ext');
				}

				$this->form_validation->set_rules('sku', 'HS Code', 'trim|required');
				$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');

				if ($this->form_validation->run() == FALSE) {
					$q_product_data = $this->Japan_ior_model->fetch_product_registration($id);
					$data['product_data'] = $q_product_data->row();
					$this->load->view('page', $data);
				} else {
					$sku = stripslashes($this->input->post('sku'));
					$product_name = stripslashes($this->input->post('product_name'));
					$updated_by = $this->session->userdata('user_id');
					$updated_at = date('Y-m-d H:i:s');

					$result = $this->Japan_ior_model->update_products_img_and_label($id, $sku, $product_name, $product_img_filename, $product_label_filename, $updated_by, $updated_at);

					if ($result == 1) {
						$this->session->set_flashdata('success', 'Successfully updated your product details!');
						redirect('/japan-ior/edit-product/' . $id, 'refresh');
					} else {
						$data['errors'] = 1;
						$q_product_data = $this->Japan_ior_model->fetch_product_registration($id);
						$data['product_data'] = $q_product_data->row();
						$this->load->view('page', $data);
					}
				}
			}
		} else {
			$this->session->set_flashdata('modal_product_name_info', 'Product Name Info');
			$this->load->view('page', $data);
		}
	}

	public function upload_product_certificate()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$data['user_id'] = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$data['external_page'] = 2;
		$data['active_page'] = "product_registrations";
		$data['page_view'] = 'japan_ior/product_registrations/upload_product_certificate';

		$id = $this->uri->segment(3);

		$q_product_data = $this->Japan_ior_model->fetch_product_registration($id);
		$data['product_data'] = $q_product_data->row();

		if (isset($_POST['submit'])) {
			if (!empty($_FILES['product_certificate']['name'])) {
				$current_timestamp = now();
				$upload_path_file = 'uploads/product_certificates/' . $data['product_data']->user_id;

				if (!file_exists($upload_path_file)) {
					mkdir($upload_path_file, 0777, true);
				}

				$config['upload_path'] = $upload_path_file;
				$config['allowed_types'] = 'pdf|jpg|jpeg|png';
				$config['max_size'] = 5000000;
				$config['file_name'] = 'product_certificate_' . $id . '_' . $current_timestamp;

				$this->upload->initialize($config);

				if (!$this->upload->do_upload('product_certificate')) {
					$data['errors'] = 2;
					$data['error_msgs'] = $this->upload->display_errors();
					$this->load->view('page', $data);
				} else {
					$updated_by = $this->session->userdata('user_id');
					$updated_at = date('Y-m-d H:i:s');

					$result = $this->Japan_ior_model->update_product_certificate($id, $config['file_name'] . $this->upload->data('file_ext'), $updated_by, $updated_at);

					if ($result == 1) {
						$this->session->set_flashdata('success', 'Successfully updated your product details!');
						redirect('/japan-ior/products-list/', 'refresh');
					} else {
						$data['errors'] = 1;
						$this->load->view('page', $data);
					}
				}
			} else {
				$this->form_validation->set_rules('product_certificate', 'Product Certificate', 'required');

				if ($this->form_validation->run() == FALSE) {
					$data['page_view'] = 'japan_ior/product_registrations/upload_product_certificate';
					$this->load->view('page', $data);
				}
			}
		} else {
			$this->load->view('page', $data);
		}
	}

	public function product_label_terms()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'product_registrations';

		// Get System Settings data from the database
		$q_system_settings = $this->Japan_ior_model->fetch_system_settings();
		$data['system_settings'] = $q_system_settings->row();

		if (isset($_POST['submit'])) {
			$q_product_label_price = $this->Japan_ior_model->getProductbyID(16);
			$data['product_label_price'] = $q_product_label_price->row();

			$data['page_view'] = 'japan_ior/product_registrations/product_label_fee';
			$this->load->view('page', $data);
		} else {
			$data['page_view'] = 'japan_ior/product_registrations/product_label_terms';
			$this->load->view('page', $data);
		}
	}

	public function product_label_checkout()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			// Get current user ID from the session
			$userID = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($userID);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$id = 16;
		$returnURL = base_url() . 'japan-ior/product-label-success';
		$cancelURL = base_url() . 'japan-ior/payment-cancelled';
		$notifyURL = base_url() . 'japan_ior/ipn';

		// Get product data from the database
		$q_product = $this->Japan_ior_model->getProductbyID($id);
		$product = $q_product->row_array();

		// Get System Settings data from the database
		$q_system_settings = $this->Japan_ior_model->fetch_system_settings();
		$system_settings = $q_system_settings->row();
		\Stripe\Stripe::setApiKey($system_settings->stripe_secret_key);

		header('Content-Type: application/json');
		$checkout_session = \Stripe\Checkout\Session::create([
			'payment_method_types' => ['card'],
			'line_items' => [[
				'price_data' => [
					'currency' => 'usd',
					'unit_amount' => $product['price'] * 100,
					'product_data' => [
						'name' =>   $product['name'],
						'images' => ["https://www.covueior.com/assets/img/covue_main_logo.png"],
					],
				],
				'quantity' => 1,
			]],
			'mode' => 'payment',
			'success_url' => $returnURL,
			'cancel_url' => $cancelURL,
			'client_reference_id' => $userID . '|' . $id . '|'
		]);
		echo json_encode(['id' => $checkout_session->id]);
	}

	public function product_label_success()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$data['user_id'] = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'product_registrations';

		$data['page_view'] = 'japan_ior/product_registrations/product_label_success';
		$this->load->view('page', $data);
	}

	public function product_labels()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$data['user_id'] = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'product_registrations';
		$data['active_url'] = "japan-ior/product-labels";
		$data['page_view'] = 'japan_ior/product_registrations/product_labels';

		$q_product_labels = $this->Japan_ior_model->fetch_product_labels($data['user_id']);
		$data['product_labels'] = $q_product_labels->result();

		$this->load->view('page', $data);
	}

	public function view_product_labels()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$data['user_id'] = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'regulated_applications';
		$data['page_view'] = 'japan_ior/regulated_applications/view_product_labels';

		$data['regulated_application_id'] = $this->uri->segment(3);

		$q_fetch_reg_application = $this->Japan_ior_model->fetch_reg_application($data['regulated_application_id']);
		$data['reg_application'] = $q_fetch_reg_application->row();

		$q_fetch_reg_products = $this->Japan_ior_model->fetch_approved_regulated_products($data['regulated_application_id']);
		$data['reg_products'] = $q_fetch_reg_products->result();

		$current_timestamp = now();
		$upload_path_file = 'uploads/product_labels/' . $data['reg_application']->created_by;

		$this->load->view('page', $data);
	}

	public function create_product_label()
	{
		$this->clear_apost();

		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'product_registrations';

		$data['paid_product_label'] = $data['user_details']->paid_product_label;

		$this->session->set_flashdata('modal_label_info', 'Product Label Info');

		if ($data['paid_product_label'] == 0) {
			$data['page_view'] = 'japan_ior/product_registrations/create_product_label';
			$this->load->view('page', $data);
		} else {
			if (isset($_POST['submit'])) {
				$this->form_validation->set_rules('sku', 'HS Code', 'trim|required');
				$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
				if (empty($_FILES['product_img']['name'])) {
					$this->form_validation->set_rules('product_img', 'Product Image', 'required');
				}
				$this->form_validation->set_rules('product_info', 'Product Use & Information', 'trim');
				$this->form_validation->set_rules('product_handling', 'Product Handling | Preparation', 'trim');
				$this->form_validation->set_rules('country_of_origin', 'Made In (Country of Origin)', 'trim|required');

				if ($this->form_validation->run() == FALSE) {
					$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
					$data['user_details'] = $q_user_details->row();

					$q_fetch_countries = $this->Japan_ior_model->fetch_countries();
					$data['countries'] = $q_fetch_countries->result();

					$data['page_view'] = 'japan_ior/product_registrations/create_product_label';
					$this->load->view('page', $data);
				} else {
					if (!empty($_FILES['product_img']['name'])) {
						$current_timestamp = now();
						$upload_path_file = 'uploads/product_qualification/' . $user_id;

						if (!file_exists($upload_path_file)) {
							mkdir($upload_path_file, 0777, true);
						}

						$config['upload_path'] = $upload_path_file;
						$config['allowed_types'] = 'pdf|jpg|jpeg|png';
						$config['max_size'] = 5000000;
						$config['file_name'] = 'product_qualification_' . $current_timestamp;

						$this->upload->initialize($config);

						if (!$this->upload->do_upload('product_img')) {
							$data['error_msgs'] = $this->upload->display_errors();
							$data['errors'] = 2;
							$data['page_view'] = 'japan_ior/product_registrations/create_product_label';
							$this->load->view('page', $data);
						} else {
							$created_at = date('Y-m-d H:i:s');

							$sku = stripslashes($this->input->post('sku'));
							$product_name = stripslashes($this->input->post('product_name'));
							$product_img = $config['file_name'] . $this->upload->data('file_ext');

							$product_registration_id = $this->Japan_ior_model->insert_product_registration_for_label($user_id, $sku, $product_name, $product_img, $user_id, $created_at);

							$website = stripslashes($this->input->post('website'));
							$product_info = stripslashes($this->input->post('product_info'));
							$product_handling = stripslashes($this->input->post('product_handling'));
							$country_of_origin = stripslashes($this->input->post('country_of_origin'));
							$expiration_date = stripslashes($this->input->post('expiration_date'));

							$result = array();

							$result[] = $this->Japan_ior_model->insert_product_label_details($user_id, $product_registration_id, $website, $product_info, $product_handling, $country_of_origin, $expiration_date, $user_id, $created_at);
							$result[] = $this->Japan_ior_model->update_user_product_label($user_id);

							if (in_array(0, $result)) {
								$data['errors'] = 1;
								$data['page_view'] = 'japan_ior/product_registrations/create_product_label';
								$this->load->view('page', $data);
							} else {
								$this->session->set_flashdata('success', 'Congratulations, successfully submitted product label details!');
								redirect('japan-ior/products-list');
							}
						}
					}
				}
			} else {
				$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
				$data['user_details'] = $q_user_details->row();

				$q_fetch_countries = $this->Japan_ior_model->fetch_countries();
				$data['countries'] = $q_fetch_countries->result();

				$data['page_view'] = 'japan_ior/product_registrations/create_product_label';
				$this->load->view('page', $data);
			}
		}
	}

	public function edit_product_label()
	{
		$this->clear_apost();

		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$id = $this->uri->segment(3);

		$data['external_page'] = 2;
		$data['active_page'] = "product_registrations";

		$data['product_label_revision_msg'] = $this->Japan_ior_model->fetch_latest_revision_message($id);

		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('product_info', 'Product Use & Information', 'trim');
			$this->form_validation->set_rules('product_handling', 'Product Handling | Preparation', 'trim');
			$this->form_validation->set_rules('country_of_origin', 'Made In (Country of Origin)', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$q_product_label_details = $this->Japan_ior_model->fetch_product_label_details($id);
				$data['product_label_data'] = $q_product_label_details->row();

				$q_fetch_countries = $this->Japan_ior_model->fetch_countries();
				$data['countries'] = $q_fetch_countries->result();

				$data['page_view'] = 'japan_ior/product_registrations/edit_product_label';
				$this->load->view('page', $data);
			} else {
				$website = stripslashes($this->input->post('website'));
				$product_info = stripslashes($this->input->post('product_info'));
				$product_handling = stripslashes($this->input->post('product_handling'));
				$country_of_origin = stripslashes($this->input->post('country_of_origin'));
				$expiration_date = stripslashes($this->input->post('expiration_date'));
				$updated_at = date('Y-m-d H:i:s');

				$result = $this->Japan_ior_model->update_product_label_details($id, $website, $product_info, $product_handling, $country_of_origin, $expiration_date, $user_id, $updated_at);

				if ($result == 0) {
					$q_product_label_details = $this->Japan_ior_model->fetch_product_label_details($id);
					$data['product_label_data'] = $q_product_label_details->row();

					$q_fetch_countries = $this->Japan_ior_model->fetch_countries();
					$data['countries'] = $q_fetch_countries->result();

					$data['errors'] = 1;
					$data['page_view'] = 'japan_ior/product_registrations/edit_product_label';
					$this->load->view('page', $data);
				} else {
					$this->session->set_flashdata('success', 'Successfully updated Product Label details!');
					redirect('japan-ior/products-list');
				}
			}
		} else {
			$q_product_label_details = $this->Japan_ior_model->fetch_product_label_details($id);
			$data['product_label_data'] = $q_product_label_details->row();

			$q_fetch_countries = $this->Japan_ior_model->fetch_countries();
			$data['countries'] = $q_fetch_countries->result();

			$data['page_view'] = 'japan_ior/product_registrations/edit_product_label';
			$this->load->view('page', $data);
		}
	}

	public function shipping_invoices()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$uri = $this->uri->segment(2);

		if ($uri == 'shipping-invoices') {
			$sampling = 0;
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'shipping_invoices';

		$q_shipping_invoices = $this->Japan_ior_model->fetch_shipping_invoices_by_user_id($user_id, $sampling);
		$data['shipping_invoices'] = $q_shipping_invoices->result();

		$this->session->set_flashdata('modal_ddp', 'Incoterms DDP');

		$data['page_view'] = 'japan_ior/shipping_invoices/shipping_invoices';
		$this->load->view('page', $data);
	}

	public function shipping_invoices_product_sampling()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$uri =  $this->uri->segment(2);

		if ($uri == 'shipping-invoices-product-sampling') {
			$sampling = 1;
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'shipping_invoices';

		$q_shipping_invoices = $this->Japan_ior_model->fetch_shipping_invoices_by_user_id($user_id, $sampling);
		$data['shipping_invoices'] = $q_shipping_invoices->result();

		$this->session->set_flashdata('modal_ddp', 'Incoterms DDP');

		$data['page_view'] = 'japan_ior/shipping_invoices/shipping_invoices_product_sampling';
		$this->load->view('page', $data);
	}

	public function fetch_product_data()
	{
		$product_registration_id = $this->input->post('id');

		$q_fetch_prod_q_data = $this->Japan_ior_model->fetch_product_data($product_registration_id);
		$fetch_prod_q_data = $q_fetch_prod_q_data->row();

		echo json_encode($fetch_prod_q_data);
	}

	public function fetch_all_regulated_category_data()
	{
		$category = $_POST['category'];
		$regulated_application = $_POST['regulated_application'];
		$id = $_POST['id'];

		$fetch_result = $this->Japan_ior_model->fetch_all_regulated_category_data($category, $regulated_application, $id);

		$result = $fetch_result->result();

		echo json_encode($result);
	}

	public function fetch_logistic_product_details()
	{
		$sid = $_POST['ids'];
		$shipping_code = $_POST['shipping_code'];

		$fetch_result = $this->Japan_ior_model->fetch_logistic_product_details($sid, $shipping_code);

		$result = $fetch_result->result();

		echo json_encode($result);
	}


	public function registered_products()
	{
		$category = $_GET['category'];
		$user_id  = $this->session->userdata('user_id');

		$q_fetch_registered_products = $this->Japan_ior_model->fetch_registered_products($user_id, $category);
		$fetch_registered_products = $q_fetch_registered_products->result();

		echo json_encode($fetch_registered_products);
	}

	public function registered_products_sampling()
	{
		$category = $_GET['category'];
		$user_id  = $this->session->userdata('user_id');

		$q_fetch_registered_products = $this->Japan_ior_model->fetch_registered_products_sampling($user_id, $category);
		$fetch_registered_products = $q_fetch_registered_products->result();

		echo json_encode($fetch_registered_products);
	}

	public function fetch_shipping_company()
	{
		$id = $this->input->post('id');

		$q_fetch_shipping_company = $this->Japan_ior_model->fetch_shipping_company_by_id($id);
		$fetch_shipping_company = $q_fetch_shipping_company->row();

		echo $fetch_shipping_company->shipping_company_name;
	}

	public function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}

	public function add_shipping_invoice()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$get_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($get_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'shipping_invoices';
		$data['shipping_session'] = $this->randomPassword();

		if ($data['user_details']->ior_registered == 0 || $data['user_details']->pli == 0) {
			redirect('/japan-ior/dashboard');;
		} else {
			$q_fetch_shipping_companies = $this->Japan_ior_model->fetch_shipping_companies();
			$data['shipping_companies'] = $q_fetch_shipping_companies->result();

			$q_fetch_countries = $this->Japan_ior_model->fetch_countries();
			$data['countries'] = $q_fetch_countries->result();

			$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification($data['user_details']->user_id);
			$data['prod_q'] = $q_fetch_prod_q->result();

			$this->session->set_flashdata('modal_create_notice', 'Create Notice:');

			$data['page_view'] = 'japan_ior/shipping_invoices/add_shipping_invoice';
			$this->load->view('page', $data);
		}
	}

	public function add_product_sampling()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$get_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($get_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'shipping_invoices';

		if ($data['user_details']->ior_registered == 0 || $data['user_details']->pli == 0) {
			redirect('/japan-ior/dashboard');;
		} else {
			$q_fetch_shipping_companies = $this->Japan_ior_model->fetch_shipping_companies();
			$data['shipping_companies'] = $q_fetch_shipping_companies->result();

			$q_fetch_countries = $this->Japan_ior_model->fetch_countries();
			$data['countries'] = $q_fetch_countries->result();

			$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification_v($data['user_details']->user_id);
			$data['prod_q'] = $q_fetch_prod_q->result();

			// $this->session->set_flashdata('modal_create_notice', 'Create Notice:');

			$data['page_view'] = 'japan_ior/shipping_invoices/add_product_sampling';
			$this->load->view('page', $data);
		}
	}

	public function edit_shipping_invoice()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'shipping_invoices';

		$shipping_invoice_id = $this->uri->segment(3);

		if ($data['user_details']->ior_registered == 0 || $data['user_details']->pli == 0) {
			redirect('/japan-ior/dashboard');;
		} else {

			$q_fetch_shipping_companies = $this->Japan_ior_model->fetch_shipping_companies();
			$data['shipping_companies'] = $q_fetch_shipping_companies->result();

			$q_fetch_countries = $this->Japan_ior_model->fetch_countries();
			$data['countries'] = $q_fetch_countries->result();

			$q_shipping_invoice = $this->Japan_ior_model->fetch_shipping_invoice_by_id($shipping_invoice_id);
			$data['shipping_invoice'] = $q_shipping_invoice->row();

			$q_shipping_invoice_products = $this->Japan_ior_model->fetch_shipping_invoice_products_by_id($shipping_invoice_id);
			$data['shipping_invoice_products'] = $q_shipping_invoice_products->result();


			$category = $data['shipping_invoice_products'][0]->product_category_id;
			$product_sampling = $data['shipping_invoice']->product_sampling;

			if ($product_sampling == 1) {
				if ($category == 4 || $category == 13) {
					$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification_v($data['user_details']->user_id, $category);
				} else if ($category == 1 || $category == 11  || $category == 8) {
					$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification_v($data['user_details']->user_id, $category);
				} else if ($category == 12 || $category == 3) {
					$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification_v($data['user_details']->user_id, $category);
				} else {
					$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification_v($data['user_details']->user_id, $category = '');
				}
			} else {
				if ($category == 4 || $category == 13) {
					$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification($data['user_details']->user_id, $category);
				} else if ($category == 1 || $category == 11  || $category == 8 || $category == 9) {
					$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification($data['user_details']->user_id, $category);
				} else if ($category == 12 || $category == 3) {
					$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification($data['user_details']->user_id, $category);
				} else {
					$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification($data['user_details']->user_id, $category = '');
				}
			}

			$data['prod_q'] = $q_fetch_prod_q->result();
			$data['revision_message'] = $this->Japan_ior_model->fetch_latest_revision_message($shipping_invoice_id);

			$data['page_view'] = 'japan_ior/shipping_invoices/edit_shipping_invoice';
			$this->load->view('page', $data);
		}
	}

	public function quick_update_contact()
	{
		$this->clear_apost();

		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$user_id = stripslashes($this->input->post('user_id'));
		$contact_person = stripslashes($this->input->post('contact_person'));
		$contact_number = stripslashes($this->input->post('contact_number'));
		$email = $this->input->post('email');
		$updated_at = date('Y-m-d H:i:s');

		$result = $this->Japan_ior_model->quick_update_contact($user_id, $contact_person, $contact_number, $email, $updated_at, $user_id);

		if ($result == 1) {
			echo $result;
		} else {
			return false;
		}
	}

	public function insert_shipping_company()
	{
		$this->clear_apost();

		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$shipping_company = stripslashes($this->input->post('shipping_company'));
		$shipping_company_num_rows = $this->Japan_ior_model->check_shipping_company($shipping_company);

		if ($shipping_company_num_rows != 1) {
			$created_by = $user_id;
			$created_at = date('Y-m-d H:i:s');

			$result = $this->Japan_ior_model->insert_shipping_company($shipping_company, $created_by, $created_at);
		} else {
			$result = 0;
		}

		if ($result != 1) {
			echo $result;
		} else {
			echo $result;
		}
	}

	public function create_shipping_invoice()
	{
		$this->clear_apost();

		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		if (isset($_POST['submit'])) {

			if (isset($_SESSION['modal_create_notice'])) {
				unset($_SESSION['modal_create_notice']);
			}

			$fba = stripslashes($this->input->post('fba'));
			$prodcat = stripslashes($this->input->post('product_category'));
			$category_type = stripslashes($this->input->post('category_type'));
			$category_name = stripslashes($this->input->post('category_name'));
			$category = stripslashes($this->input->post('category_0'));
			$product_sampling = stripslashes($this->input->post('product_sampling'));
			$company_name = stripslashes($this->input->post('company_name'));
			$shipping_company_link = stripslashes($this->input->post('shipping_company_link'));

			/** Port Of Arrival */
			$street_address = stripslashes($this->input->post('street_address'));
			$address_line_2 = stripslashes($this->input->post('address_line_2'));
			$city = stripslashes($this->input->post('city'));
			$state = stripslashes($this->input->post('state'));
			$postal = stripslashes($this->input->post('postal'));
			$country_1 = stripslashes($this->input->post('country_1'));
			$logistic_form = stripslashes($this->input->post('logistic_form'));
			$shipping_session = stripslashes($this->input->post('shipping_session'));

			if ($shipping_company_link == 1 && $product_sampling != 1) {
				$this->form_validation->set_rules('shipping_company', 'Shipping Company', 'trim|required');
			}

			if ($this->input->post('same_address') != 1) {
				$this->form_validation->set_rules('supplier_name', 'Supplier Name', 'trim|required');
				$this->form_validation->set_rules('supplier_address', 'Supplier Address', 'trim|required');
				$this->form_validation->set_rules('supplier_phone_no', 'Supplier Phone Number', 'trim|required');
			}

			$this->form_validation->set_rules('destination_recipient_name', 'Destination Recipent Name', 'trim|required');
			$this->form_validation->set_rules('destination_company_name', 'Destination Company Name', 'trim|required');
			$this->form_validation->set_rules('destination_address', 'Destination Address', 'trim|required');
			$this->form_validation->set_rules('destination_phone_no', 'Destination Phone Number', 'trim|required');
			$this->form_validation->set_rules('country_of_origin', 'Country of Origin', 'trim|required');
			$this->form_validation->set_rules('product[]', 'Product Name', 'trim|required');

			if ($fba == 1) {
				if (empty($_FILES['fosr']['name'])) {
					$this->form_validation->set_rules('fosr', 'FOSR', 'required');
				}
				if (empty($_FILES['simulator']['name'])) {
					$this->form_validation->set_rules('simulator', 'Simulator', 'required');
				}
			} else {
				if ($product_sampling != 1) {
					if (empty($_FILES['fosr']['name'])) {
						$this->form_validation->set_rules('fosr', 'FOSR', 'required');
					}
				}
			}


			if ($this->form_validation->run() == FALSE) {
				$data['external_page'] = 2;
				$data['active_page'] = 'shipping_invoices';

				$get_id = $this->session->userdata('user_id');

				$q_user_details = $this->Japan_ior_model->fetch_user_by_id($get_id);
				$data['user_details'] = $q_user_details->row();

				$q_fetch_shipping_companies = $this->Japan_ior_model->fetch_shipping_companies();
				$data['shipping_companies'] = $q_fetch_shipping_companies->result();

				$q_fetch_countries = $this->Japan_ior_model->fetch_countries();
				$data['countries'] = $q_fetch_countries->result();
				if ($product_sampling == 1) {
					if ($category == 4 || $category == 13) {
						$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification_v($data['user_details']->user_id, $category);
					} else if ($category == 1 || $category == 11  || $category == 8) {
						$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification_v($data['user_details']->user_id, $category);
					} else if ($category == 12 || $category == 3) {
						$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification_v($data['user_details']->user_id, $category);
					} else {
						$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification_v($data['user_details']->user_id, $category = '');
					}
				} else {
					if ($category == 4 || $category == 13) {
						$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification($data['user_details']->user_id, $category);
					} else if ($category == 1 || $category == 11  || $category == 8) {
						$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification($data['user_details']->user_id, $category);
					} else if ($category == 12 || $category == 3) {
						$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification($data['user_details']->user_id, $category);
					} else {
						$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification($data['user_details']->user_id, $category = '');
					}
				}

				$data['prod_q'] = $q_fetch_prod_q->result();
				if ($product_sampling == 1) {
					$data['page_view'] = 'japan_ior/shipping_invoices/add_product_sampling';
				} else {
					$data['page_view'] = 'japan_ior/shipping_invoices/add_shipping_invoice';
				}
				$this->load->view('page', $data);
			} else {
				$fba = stripslashes($this->input->post('fba'));
				$prodcat = stripslashes($this->input->post('product_category'));

				if ($shipping_company_link == 1) {
					$shipping_company = stripslashes($this->input->post('shipping_company'));
				} else {
					$shipping_company = 0;
				}

				$supplier_name = stripslashes($this->input->post('supplier_name'));
				$supplier_address = stripslashes($this->input->post('supplier_address'));
				$supplier_phone_no = stripslashes($this->input->post('supplier_phone_no'));
				$same_address = (!empty($this->input->post('same_address')) ? $this->input->post('same_address') : '0');

				$destination_recipient_name = stripslashes($this->input->post('destination_recipient_name'));
				$destination_company_name = stripslashes($this->input->post('destination_company_name'));
				$destination_address = stripslashes($this->input->post('destination_address'));
				$destination_phone_no = stripslashes($this->input->post('destination_phone_no'));

				$country_of_origin = stripslashes($this->input->post('country_of_origin'));

				$total_unit_value = (!empty($this->input->post('total_unit_value')) ? stripslashes($this->input->post('total_unit_value')) : '0.00');
				$fba_fees = (!empty($this->input->post('fba_fees')) ? stripslashes($this->input->post('fba_fees')) : '0.00');
				$total_value_of_shipment = (!empty($this->input->post('total_value_of_shipment')) ? stripslashes($this->input->post('total_value_of_shipment')) : '0.00');

				$created_at = date('Y-m-d H:i:s');

				if ($fba == 1) {

					if (!empty($_FILES['fosr']['name']) && !empty($_FILES['simulator']['name'])) {

						$current_timestamp = now();
						$upload_path_file = 'uploads/shipping_invoice_pdf/' . $user_id;

						if (!file_exists($upload_path_file)) {
							mkdir($upload_path_file, 0777, true);
						}

						/** FOSR */
						$config['upload_path'] = $upload_path_file;
						$config['allowed_types'] = 'pdf';
						$config['max_size'] = 50000;
						$config['file_name'] = 'fosr_' . $current_timestamp;

						$this->upload->initialize($config);

						/** SIMULATOR */
						$temp = explode(".", $_FILES["simulator"]["name"]);
						$simulator = 'simulator_' . $current_timestamp . '.' . end($temp);
						move_uploaded_file($_FILES["simulator"]["tmp_name"],  './uploads/shipping_invoice_pdf/' . $user_id . '/' . $simulator);

						if (!$this->upload->do_upload('fosr') && empty($_FILES['simulator']['name'])) {

							$data['errors'] = 1;
							$data['error_msgs'] = $this->upload->display_errors();

							$data['external_page'] = 2;
							$data['active_page'] = 'shipping_invoices';

							$get_id = $this->session->userdata('user_id');

							$q_user_details = $this->Japan_ior_model->fetch_user_by_id($get_id);
							$data['user_details'] = $q_user_details->row();

							$q_fetch_shipping_companies = $this->Japan_ior_model->fetch_shipping_companies();
							$data['shipping_companies'] = $q_fetch_shipping_companies->result();

							$q_fetch_countries = $this->Japan_ior_model->fetch_countries();
							$data['countries'] = $q_fetch_countries->result();

							if ($product_sampling == 1) {
								$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification_v($data['user_details']->user_id);
							} else {
								$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification($data['user_details']->user_id);
							}

							$data['prod_q'] = $q_fetch_prod_q->result();

							if ($product_sampling == 1) {
								$data['page_view'] = 'japan_ior/shipping_invoices/add_product_sampling';
							} else {
								$data['page_view'] = 'japan_ior/shipping_invoices/add_shipping_invoice';
							}
							$this->load->view('page', $data);
						} else {

							$fosr_filename = $config['file_name'] . $this->upload->data('file_ext');
							$simulator_filename = $simulator;

							$product_count = count($this->input->post('product'));

							if ($product_sampling == 1) {
								$paid = 1;
							} else {
								$paid = 0;
							}

							$shipping_invoice_id = $this->Japan_ior_model->insert_shipping_invoice($user_id, '', $shipping_company, '', $supplier_name, $supplier_address, $supplier_phone_no, $same_address, $destination_recipient_name, $destination_company_name, $destination_address, $destination_phone_no, $country_of_origin, $total_unit_value, $fba_fees, $total_value_of_shipment, $fosr_filename, $simulator_filename, 3, 1, $user_id, $fba, $prodcat, $category_type, $product_sampling, $paid, $created_at,$shipping_session);
							
							$this->Japan_ior_model->insert_logistic_form($user_id,$shipping_invoice_id,$shipping_session, $street_address,$address_line_2,$city,$state,$postal,$country_1,$created_at);
							
							$result = array();

							for ($i = 0; $i < $product_count; $i++) {

								$product_registration_id = $this->input->post('product[' . $i . ']');
								$asin = stripslashes($this->input->post('asin[' . $i . ']'));
								$online_selling_price = (!empty($this->input->post('price[' . $i . ']')) ? $this->input->post('price[' . $i . ']') : '0.00');
								$fba_listing_fee = (!empty($this->input->post('fba_listing_fee[' . $i . ']')) ? $this->input->post('fba_listing_fee[' . $i . ']') : '0.00');
								$fba_shipping_fee = (!empty($this->input->post('fba_shipping_fee[' . $i . ']')) ? $this->input->post('fba_shipping_fee[' . $i . ']') : '0.00');
								$quantity = $this->input->post('qty[' . $i . ']');
								$unit_value =  (!empty($this->input->post('unit_value[' . $i . ']')) ? str_replace(',', '', $this->input->post('unit_value[' . $i . ']')) : '0.00');
								$unit_value_total_amount =  (!empty($this->input->post('unit_value_total_amount[' . $i . ']')) ? str_replace(',', '', $this->input->post('unit_value_total_amount[' . $i . ']')) : '0.00');
								$total_amount =  (!empty($this->input->post('total_amount[' . $i . ']')) ? str_replace(',', '', $this->input->post('total_amount[' . $i . ']')) : '0.00');

								if ($product_sampling == 1) {
									$result[] = $this->Japan_ior_model->insert_shipping_invoice_products_sampling($shipping_invoice_id, $product_registration_id, $asin, $online_selling_price, $fba_listing_fee, $fba_shipping_fee, $quantity, $unit_value, $unit_value_total_amount, $total_amount, 1, $created_at);
								} else {
									$result[] = $this->Japan_ior_model->insert_shipping_invoice_products($shipping_invoice_id, $product_registration_id, $asin, $online_selling_price, $fba_listing_fee, $fba_shipping_fee, $quantity, $unit_value, $unit_value_total_amount, $total_amount, 1, $created_at);
								}
							}

							if (in_array(1, $result)) {
								$this->send_email_notification(1,  $company_name, $shipping_invoice_id);
								redirect('japan-ior/edit-shipping-invoice/' . $shipping_invoice_id, 'refresh');
							} else {
								$data['errors'] = 1;
								if ($product_sampling == 1) {
									$data['page_view'] = 'japan_ior/shipping_invoices/add_product_sampling';
								} else {
									$data['page_view'] = 'japan_ior/shipping_invoices/add_shipping_invoice';
								}
								$this->load->view('page', $data);
							}
						}
					} else {
						$data['errors'] = 1;
						if ($product_sampling == 1) {
							$data['page_view'] = 'japan_ior/shipping_invoices/add_product_sampling';
						} else {
							$data['page_view'] = 'japan_ior/shipping_invoices/add_shipping_invoice';
						}
						$this->load->view('page', $data);
					}
				} else {

					if ($product_sampling == 1) {
						$product_count = count($this->input->post('product'));

						if ($product_sampling == 1) {
							$paid = 1;
						} else {
							$paid = 0;
						}

						$shipping_invoice_id = $this->Japan_ior_model->insert_shipping_invoice($user_id, '', $shipping_company, '', $supplier_name, $supplier_address, $supplier_phone_no, $same_address, $destination_recipient_name, $destination_company_name, $destination_address, $destination_phone_no, $country_of_origin, $total_unit_value, $fba_fees, $total_value_of_shipment, '', $simulator_filename = '', 3, 1, $user_id, $fba, $prodcat, $category_type, $product_sampling, $paid, $created_at,$shipping_session);
						
						
						$result = array();

						for ($i = 0; $i < $product_count; $i++) {

							$product_registration_id = $this->input->post('product[' . $i . ']');
							$asin = stripslashes($this->input->post('asin[' . $i . ']'));
							$online_selling_price = (!empty($this->input->post('price[' . $i . ']')) ? $this->input->post('price[' . $i . ']') : '0.00');
							$fba_listing_fee = (!empty($this->input->post('fba_listing_fee[' . $i . ']')) ? $this->input->post('fba_listing_fee[' . $i . ']') : '0.00');
							$fba_shipping_fee = (!empty($this->input->post('fba_shipping_fee[' . $i . ']')) ? $this->input->post('fba_shipping_fee[' . $i . ']') : '0.00');
							$quantity = $this->input->post('qty[' . $i . ']');
							$unit_value =  (!empty($this->input->post('unit_value[' . $i . ']')) ? str_replace(',', '', $this->input->post('unit_value[' . $i . ']')) : '0.00');
							$unit_value_total_amount =  (!empty($this->input->post('unit_value_total_amount[' . $i . ']')) ? str_replace(',', '', $this->input->post('unit_value_total_amount[' . $i . ']')) : '0.00');
							$total_amount =  (!empty($this->input->post('total_amount[' . $i . ']')) ? str_replace(',', '', $this->input->post('total_amount[' . $i . ']')) : '0.00');

							if ($product_sampling == 1) {
								$result[] = $this->Japan_ior_model->insert_shipping_invoice_products_sampling($shipping_invoice_id, $product_registration_id, $asin, $online_selling_price, $fba_listing_fee, $fba_shipping_fee, $quantity, $unit_value, $unit_value_total_amount, $total_amount, 1, $created_at);
							} else {
								$result[] = $this->Japan_ior_model->insert_shipping_invoice_products($shipping_invoice_id, $product_registration_id, $asin, $online_selling_price, $fba_listing_fee, $fba_shipping_fee, $quantity, $unit_value, $unit_value_total_amount, $total_amount, 1, $created_at);
							}
						}

						if (in_array(1, $result)) {
							$this->send_email_notification(1,  $company_name, $shipping_invoice_id);
							redirect('japan-ior/edit-shipping-invoice/' . $shipping_invoice_id, 'refresh');
						} else {
							$data['errors'] = 1;
							if ($product_sampling == 1) {
								$data['page_view'] = 'japan_ior/shipping_invoices/add_product_sampling';
							} else {
								$data['page_view'] = 'japan_ior/shipping_invoices/add_shipping_invoice';
							}
							$this->load->view('page', $data);
						}
					} else {
						if (!empty($_FILES['fosr']['name'])) {

							$current_timestamp = now();
							$upload_path_file = 'uploads/shipping_invoice_pdf/' . $user_id;

							if (!file_exists($upload_path_file)) {
								mkdir($upload_path_file, 0777, true);
							}

							$config['upload_path'] = $upload_path_file;
							$config['allowed_types'] = 'pdf';
							$config['max_size'] = 50000;
							$config['file_name'] = 'fosr_' . $current_timestamp;

							$this->upload->initialize($config);

							if (!$this->upload->do_upload('fosr')) {

								$data['errors'] = 1;
								$data['error_msgs'] = $this->upload->display_errors();

								$data['external_page'] = 2;
								$data['active_page'] = 'shipping_invoices';

								$get_id = $this->session->userdata('user_id');

								$q_user_details = $this->Japan_ior_model->fetch_user_by_id($get_id);
								$data['user_details'] = $q_user_details->row();

								$q_fetch_shipping_companies = $this->Japan_ior_model->fetch_shipping_companies();
								$data['shipping_companies'] = $q_fetch_shipping_companies->result();

								$q_fetch_countries = $this->Japan_ior_model->fetch_countries();
								$data['countries'] = $q_fetch_countries->result();

								if ($product_sampling == 1) {
									$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification_v($data['user_details']->user_id);
								} else {
									$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification($data['user_details']->user_id);
								}

								$data['prod_q'] = $q_fetch_prod_q->result();

								if ($product_sampling == 1) {
									$data['page_view'] = 'japan_ior/shipping_invoices/add_product_sampling';
								} else {
									$data['page_view'] = 'japan_ior/shipping_invoices/add_shipping_invoice';
								}
								$this->load->view('page', $data);
							} else {
								$fosr_filename = $config['file_name'] . $this->upload->data('file_ext');

								$product_count = count($this->input->post('product'));

								if ($product_sampling == 1) {
									$paid = 1;
								} else {
									$paid = 0;
								}

								$shipping_invoice_id = $this->Japan_ior_model->insert_shipping_invoice($user_id, '', $shipping_company, '', $supplier_name, $supplier_address, $supplier_phone_no, $same_address, $destination_recipient_name, $destination_company_name, $destination_address, $destination_phone_no, $country_of_origin, $total_unit_value, $fba_fees, $total_value_of_shipment, $fosr_filename, $simulator_filename = '', 3, 1, $user_id, $fba, $prodcat, $category_type, $product_sampling, $paid, $created_at,$shipping_session);
								$this->Japan_ior_model->insert_logistic_form($user_id,$shipping_invoice_id,$shipping_session, $street_address,$address_line_2,$city,$state,$postal,$country_1,$created_at);

								$result = array();

								for ($i = 0; $i < $product_count; $i++) {

									$product_registration_id = $this->input->post('product[' . $i . ']');
									$asin = stripslashes($this->input->post('asin[' . $i . ']'));
									$online_selling_price = (!empty($this->input->post('price[' . $i . ']')) ? $this->input->post('price[' . $i . ']') : '0.00');
									$fba_listing_fee = (!empty($this->input->post('fba_listing_fee[' . $i . ']')) ? $this->input->post('fba_listing_fee[' . $i . ']') : '0.00');
									$fba_shipping_fee = (!empty($this->input->post('fba_shipping_fee[' . $i . ']')) ? $this->input->post('fba_shipping_fee[' . $i . ']') : '0.00');
									$quantity = $this->input->post('qty[' . $i . ']');
									$unit_value =  (!empty($this->input->post('unit_value[' . $i . ']')) ? str_replace(',', '', $this->input->post('unit_value[' . $i . ']')) : '0.00');
									$unit_value_total_amount =  (!empty($this->input->post('unit_value_total_amount[' . $i . ']')) ? str_replace(',', '', $this->input->post('unit_value_total_amount[' . $i . ']')) : '0.00');
									$total_amount =  (!empty($this->input->post('total_amount[' . $i . ']')) ? str_replace(',', '', $this->input->post('total_amount[' . $i . ']')) : '0.00');

									if ($product_sampling == 1) {
										$result[] = $this->Japan_ior_model->insert_shipping_invoice_products_sampling($shipping_invoice_id, $product_registration_id, $asin, $online_selling_price, $fba_listing_fee, $fba_shipping_fee, $quantity, $unit_value, $unit_value_total_amount, $total_amount, 1, $created_at);
									} else {
										$result[] = $this->Japan_ior_model->insert_shipping_invoice_products($shipping_invoice_id, $product_registration_id, $asin, $online_selling_price, $fba_listing_fee, $fba_shipping_fee, $quantity, $unit_value, $unit_value_total_amount, $total_amount, 1, $created_at);
									}
								}

								if (in_array(1, $result)) {
									$this->send_email_notification(1,  $company_name, $shipping_invoice_id);
									redirect('japan-ior/edit-shipping-invoice/' . $shipping_invoice_id, 'refresh');
								} else {
									$data['errors'] = 1;
									if ($product_sampling == 1) {
										$data['page_view'] = 'japan_ior/shipping_invoices/add_product_sampling';
									} else {
										$data['page_view'] = 'japan_ior/shipping_invoices/add_shipping_invoice';
									}
									$this->load->view('page', $data);
								}
							}
						} else {
							$data['errors'] = 1;
							if ($product_sampling == 1) {
								$data['page_view'] = 'japan_ior/shipping_invoices/add_product_sampling';
							} else {
								$data['page_view'] = 'japan_ior/shipping_invoices/add_shipping_invoice';
							}
							$this->load->view('page', $data);
						}
					}
				}
			}
		}
	}

	public function process_shipping_invoice()
	{
		$this->clear_apost();

		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$shipping_invoice_id = $this->input->post('shipping_invoice_id');
		$fba_location = $this->input->post('fba_location');
		$category = stripslashes($this->input->post('category_0'));
		$product_sampling = $this->input->post('product_sampling');
		$company_name = $this->input->post('company_name');
		$shipping_company_link = $this->input->post('shipping_company_link');

		if (isset($_POST['submit']) || isset($_POST['preview'])) {
			if ($shipping_company_link == 1 && $product_sampling != 1) {
				$this->form_validation->set_rules('shipping_company', 'Shipping Company', 'trim|required');
			}
			if ($this->input->post('same_address') != 1) {
				$this->form_validation->set_rules('supplier_name', 'Supplier Name', 'trim|required');
				$this->form_validation->set_rules('supplier_address', 'Supplier Address', 'trim|required');
				$this->form_validation->set_rules('supplier_phone_no', 'Supplier Phone Number', 'trim|required');
			}
			$this->form_validation->set_rules('destination_recipient_name', 'Destination Recipent Name', 'trim|required');
			$this->form_validation->set_rules('destination_company_name', 'Destination Company Name', 'trim|required');
			$this->form_validation->set_rules('destination_address', 'Destination Address', 'trim|required');
			$this->form_validation->set_rules('destination_phone_no', 'Destination Phone Number', 'trim|required');

			$this->form_validation->set_rules('country_of_origin', 'Country of Origin', 'trim|required');
			$this->form_validation->set_rules('product[]', 'Product Name', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data['external_page'] = 2;
				$data['active_page'] = 'shipping_invoices';

				$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
				$data['user_details'] = $q_user_details->row();

				$q_fetch_shipping_companies = $this->Japan_ior_model->fetch_shipping_companies();
				$data['shipping_companies'] = $q_fetch_shipping_companies->result();

				$q_fetch_countries = $this->Japan_ior_model->fetch_countries();
				$data['countries'] = $q_fetch_countries->result();

				if ($product_sampling == 1) {
					if ($category == 4 || $category == 13) {
						$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification_v($data['user_details']->user_id, $category);
					} else if ($category == 1 || $category == 11  || $category == 8) {
						$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification_v($data['user_details']->user_id, $category);
					} else if ($category == 12 || $category == 3) {
						$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification_v($data['user_details']->user_id, $category);
					} else {
						$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification_v($data['user_details']->user_id, $category = '');
					}
				} else {
					if ($category == 4 || $category == 13) {
						$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification($data['user_details']->user_id, $category);
					} else if ($category == 1 || $category == 11  || $category == 8) {
						$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification($data['user_details']->user_id, $category);
					} else if ($category == 12 || $category == 3) {
						$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification($data['user_details']->user_id, $category);
					} else {
						$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification($data['user_details']->user_id, $category = '');
					}
				}

				$data['prod_q'] = $q_fetch_prod_q->result();

				$q_shipping_invoice = $this->Japan_ior_model->fetch_shipping_invoice_by_id($shipping_invoice_id);
				$data['shipping_invoice'] = $q_shipping_invoice->row();

				$q_shipping_invoice_products = $this->Japan_ior_model->fetch_shipping_invoice_products_by_id($shipping_invoice_id);
				$data['shipping_invoice_products'] = $q_shipping_invoice_products->result();

				$data['revision_message'] = $this->Japan_ior_model->fetch_latest_revision_message($shipping_invoice_id);

				$data['page_view'] = 'japan_ior/shipping_invoices/edit_shipping_invoice';
				$this->load->view('page', $data);
			} else {
				$shipping_company = stripslashes($this->input->post('shipping_company'));
				$supplier_name = stripslashes($this->input->post('supplier_name'));
				$supplier_address = stripslashes($this->input->post('supplier_address'));
				$supplier_phone_no = stripslashes($this->input->post('supplier_phone_no'));
				$same_address = (!empty($this->input->post('same_address')) ? $this->input->post('same_address') : '0');
				$destination_recipient_name = stripslashes($this->input->post('destination_recipient_name'));
				$destination_company_name = stripslashes($this->input->post('destination_company_name'));
				$destination_address = stripslashes($this->input->post('destination_address'));
				$destination_phone_no = stripslashes($this->input->post('destination_phone_no'));
				$country_of_origin_id = stripslashes($this->input->post('country_of_origin'));
				$total_unit_value = stripslashes($this->input->post('total_unit_value'));
				$fba_fees = stripslashes($this->input->post('fba_fees'));
				$total_value_of_shipment = stripslashes($this->input->post('total_value_of_shipment'));
				$updated_at = date('Y-m-d H:i:s');

				if (!empty($_FILES['fosr']['name']) || !empty($_FILES['simulator']['name'])) {
					$current_timestamp = now();
					$upload_path_file = 'uploads/shipping_invoice_pdf/' . $user_id;

					if (!file_exists($upload_path_file)) {
						mkdir($upload_path_file, 0777, true);
					}

					if (!empty($_FILES['fosr']['name'])) {
						$config['upload_path'] = $upload_path_file;
						$config['allowed_types'] = 'pdf';
						$config['max_size'] = 25000;
						$config['file_name'] = 'fosr_' . $current_timestamp;
						$this->upload->initialize($config);
					} else {
						$fosr = $this->input->post('fosr_value');
					}

					/** SIMULATOR */

					if (!empty($_FILES['simulator']['name'])) {
						$temp = explode(".", $_FILES["simulator"]["name"]);
						$simulator = 'simulator_' . $current_timestamp . '.' . end($temp);
						$uploaded = move_uploaded_file($_FILES["simulator"]["tmp_name"],  './uploads/shipping_invoice_pdf/' . $user_id . '/' . $simulator);
					} else {
						$simulator = $this->input->post('simulator_value');
					}

					if (!$this->upload->do_upload('fosr') && empty($_FILES['simulator']['name'])) {
						$data['external_page'] = 2;
						$data['active_page'] = 'shipping_invoices';

						$shipping_invoice_id_uri = $this->uri->segment(3);

						$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
						$data['user_details'] = $q_user_details->row();

						$q_fetch_countries = $this->Japan_ior_model->fetch_countries();
						$data['countries'] = $q_fetch_countries->result();

						$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification($data['user_details']->user_id);
						$data['prod_q'] = $q_fetch_prod_q->result();

						$q_shipping_invoice = $this->Japan_ior_model->fetch_shipping_invoice_by_id($shipping_invoice_id_uri);
						$data['shipping_invoice'] = $q_shipping_invoice->row();

						$q_shipping_invoice_products = $this->Japan_ior_model->fetch_shipping_invoice_products_by_id($shipping_invoice_id_uri);
						$data['shipping_invoice_products'] = $q_shipping_invoice_products->result();

						$data['revision_message'] = $this->Japan_ior_model->fetch_latest_revision_message($shipping_invoice_id_uri);

						$data['page_view'] = 'japan_ior/shipping_invoices/edit_shipping_invoice';
						$this->load->view('page', $data);
					} else {
						if (!empty($_FILES['fosr']['name'])) {
							$fosr_filename = $config['file_name'] . $this->upload->data('file_ext');
						} else {
							$fosr_filename = $fosr;
						}
						$simulator_filename = $simulator;
						$this->Japan_ior_model->update_shipping_invoice($shipping_invoice_id, $shipping_company, $supplier_name, $supplier_address, $supplier_phone_no, $same_address, $destination_recipient_name, $destination_company_name, $destination_address, $destination_phone_no, $country_of_origin_id, $total_unit_value, $fba_fees, $total_value_of_shipment, $fosr_filename, $simulator_filename, 3, 1, $user_id, $updated_at);
					}
				} else {
					$this->Japan_ior_model->update_shipping_invoice_blank_file($shipping_invoice_id, $shipping_company, $supplier_name, $supplier_address, $supplier_phone_no, $same_address, $destination_recipient_name, $destination_company_name, $destination_address, $destination_phone_no, $country_of_origin_id, $total_unit_value, $fba_fees, $total_value_of_shipment, 3, 1, $user_id, $updated_at);
				}

				$result = array();
				$product_tbl_count = $this->input->post('product_tbl_count');

				for ($i = 0; $i < $product_tbl_count; $i++) {
					$shipping_invoice_product_id = $this->input->post('shipping_invoice_product_id[' . $i . ']');
					$shipping_invoice_active = $this->input->post('shipping_invoice_active[' . $i . ']');
					$new_shipping_invoice = $this->input->post('new_shipping_invoice[' . $i . ']');
					$product_registration_id = $this->input->post('product[' . $i . ']');
					$asin = stripslashes($this->input->post('asin[' . $i . ']'));
					$online_selling_price = (!empty($this->input->post('price[' . $i . ']')) ? $this->input->post('price[' . $i . ']') : '0.00');

					if ($fba_location == 2) {
						$unit_value = '0.00';
						$fba_listing_fee = '0.00';
						$fba_shipping_fee = '0.00';
						$unit_value_total_amount = '0.00';
					} else {
						$fba_listing_fee = (!empty($this->input->post('fba_listing_fee[' . $i . ']')) ? $this->input->post('fba_listing_fee[' . $i . ']') : '0.00');
						$fba_shipping_fee = (!empty($this->input->post('fba_shipping_fee[' . $i . ']')) ? $this->input->post('fba_shipping_fee[' . $i . ']') : '0.00');
						$unit_value = (!empty($this->input->post('unit_value[' . $i . ']')) ? str_replace(',', '', $this->input->post('unit_value[' . $i . ']')) : '0.00');
						$unit_value_total_amount = (!empty($this->input->post('unit_value_total_amount[' . $i . ']')) ? str_replace(',', '', $this->input->post('unit_value_total_amount[' . $i . ']')) : '0.00');
					}

					$quantity = $this->input->post('qty[' . $i . ']');
					$total_amount = (!empty($this->input->post('total_amount[' . $i . ']')) ? str_replace(',', '', $this->input->post('total_amount[' . $i . ']')) : '0.00');

					if ($shipping_invoice_active == '0') {
						$result[] = $this->Japan_ior_model->inactive_shipping_invoice_products($shipping_invoice_product_id, $shipping_invoice_id, 0, $updated_at);
					}

					if ($new_shipping_invoice == '0') {
						$result[] = $this->Japan_ior_model->update_shipping_invoice_products($shipping_invoice_product_id, $shipping_invoice_id, $product_registration_id, $asin, $online_selling_price, $fba_listing_fee, $fba_shipping_fee, $quantity, $unit_value, $unit_value_total_amount, $total_amount, 1, $updated_at);
					}

					if ($new_shipping_invoice == '1') {
						$created_at = date('Y-m-d H:i:s');
						if ($product_sampling == 1) {
							$result[] = $this->Japan_ior_model->insert_shipping_invoice_products_sampling($shipping_invoice_id, $product_registration_id, $asin, $online_selling_price, $fba_listing_fee, $fba_shipping_fee, $quantity, $unit_value, $unit_value_total_amount, $total_amount, 1, $created_at);
						} else {
							$result[] = $this->Japan_ior_model->insert_shipping_invoice_products($shipping_invoice_id, $product_registration_id, $asin, $online_selling_price, $fba_listing_fee, $fba_shipping_fee, $quantity, $unit_value, $unit_value_total_amount, $total_amount, 1, $created_at);
						}
					}
				}

				ob_start();

				if (isset($_POST['submit'])) {
					$this->default_shipping_invoice($shipping_invoice_id, 0, $invoice = '', $fba_location, $product_sampling, $shipping_company_link);

					if (isset($_POST['submit'])) {
						$result[] = $this->Japan_ior_model->pending_shipping_invoice($shipping_invoice_id, $user_id, $updated_at);

						if (in_array(1, $result)) {

							$this->session->set_flashdata('success', 'Congratulations, successfully submitted the shipping invoice request for approval!');
							$this->send_email_notification(2,  $company_name, $shipping_invoice_id);

							if ($product_sampling == 1) {
								redirect('japan-ior/shipping-invoices-product-sampling', 'refresh');
							} else {
								redirect('japan-ior/shipping-invoices', 'refresh');
							}

							redirect('japan-ior/shipping-invoices', 'refresh');
						} else {
							$data['errors'] = 1;
							if ($product_sampling == 1) {
								$data['page_view'] = 'japan_ior/shipping_invoices/shipping_invoices_product_sampling';
							} else {
								$data['page_view'] = 'japan_ior/shipping_invoices/shipping_invoices';
							}
							$this->load->view('page', $data);
						}
					}
				}

				if (isset($_POST['preview'])) {
					$this->default_shipping_invoice($shipping_invoice_id, 0, $invoice = '', $fba_location, $product_sampling, $shipping_company_link);
					redirect('/uploads/shipping_invoice_pdf/' . $user_id . '/' . $shipping_invoice_id . '/' . 'Shipping Invoice Preview.pdf', 'refresh');
				}
			}
		} else {
			$results = array();

			$shipping_company = stripslashes($this->input->post('shipping_company'));
			$supplier_name = stripslashes($this->input->post('supplier_name'));
			$supplier_address = stripslashes($this->input->post('supplier_address'));
			$supplier_phone_no = stripslashes($this->input->post('supplier_phone_no'));
			$same_address = (!empty($this->input->post('same_address')) ? $this->input->post('same_address') : '0');
			$destination_recipient_name = stripslashes($this->input->post('destination_recipient_name'));
			$destination_company_name = stripslashes($this->input->post('destination_company_name'));
			$destination_address = stripslashes($this->input->post('destination_address'));
			$destination_phone_no = stripslashes($this->input->post('destination_phone_no'));
			$country_of_origin_id = stripslashes($this->input->post('country_of_origin'));
			$total_unit_value = stripslashes($this->input->post('total_unit_value'));
			$fba_fees = stripslashes($this->input->post('fba_fees'));
			$total_value_of_shipment = stripslashes($this->input->post('total_value_of_shipment'));
			$updated_at = date('Y-m-d H:i:s');

			if (!empty($_FILES['fosr']['name'])) {
				$current_timestamp = now();
				$upload_path_file = 'uploads/shipping_invoice_pdf/' . $user_id;

				if (!file_exists($upload_path_file)) {
					mkdir($upload_path_file, 0777, true);
				}


				if (!empty($_FILES['fosr']['name'])) {
					$config['upload_path'] = $upload_path_file;
					$config['allowed_types'] = 'pdf';
					$config['max_size'] = 25000;
					$config['file_name'] = 'fosr_' . $current_timestamp;
					$this->upload->initialize($config);
				} else {
					$fosr = $this->input->post('fosr_value');
				}

				/** SIMULATOR */

				if (!empty($_FILES['simulator']['name'])) {
					$temp = explode(".", $_FILES["simulator"]["name"]);
					$simulator = 'simulator_' . $current_timestamp . '.' . end($temp);
					$uploaded = move_uploaded_file($_FILES["simulator"]["tmp_name"],  './uploads/shipping_invoice_pdf/' . $user_id . '/' . $simulator);
				} else {
					$simulator = $this->input->post('simulator_value');
				}

				if (!$this->upload->do_upload('fosr') && empty($_FILES['simulator']['name'])) {
					$data['external_page'] = 2;
					$data['active_page'] = 'japan_ior';

					$shipping_invoice_id_uri = $this->uri->segment(3);

					$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
					$data['user_details'] = $q_user_details->row();

					$q_fetch_countries = $this->Japan_ior_model->fetch_countries();
					$data['countries'] = $q_fetch_countries->result();

					$q_fetch_prod_q = $this->Japan_ior_model->fetch_approved_product_qualification($data['user_details']->user_id);
					$data['prod_q'] = $q_fetch_prod_q->result();

					$q_shipping_invoice = $this->Japan_ior_model->fetch_shipping_invoice_by_id($shipping_invoice_id_uri);
					$data['shipping_invoice'] = $q_shipping_invoice->row();

					$q_shipping_invoice_products = $this->Japan_ior_model->fetch_shipping_invoice_products_by_id($shipping_invoice_id_uri);
					$data['shipping_invoice_products'] = $q_shipping_invoice_products->result();

					$data['revision_message'] = $this->Japan_ior_model->fetch_latest_revision_message($shipping_invoice_id_uri);

					$data['page_view'] = 'japan_ior/shipping_invoices/edit_shipping_invoice';
					$this->load->view('page', $data);
				} else {

					if (!empty($_FILES['fosr']['name'])) {
						$fosr_filename = $config['file_name'] . $this->upload->data('file_ext');
					} else {
						$fosr_filename = $fosr;
					}

					$simulator_filename = $simulator;

					$results[] = $this->Japan_ior_model->update_shipping_invoice($shipping_invoice_id, $shipping_company, $supplier_name, $supplier_address, $supplier_phone_no, $same_address, $destination_recipient_name, $destination_company_name, $destination_address, $destination_phone_no, $country_of_origin_id, $total_unit_value, $fba_fees, $total_value_of_shipment, $fosr_filename, $simulator_filename, 3, 1, $user_id, $updated_at);
				}
			} else {
				$results[] = $this->Japan_ior_model->update_shipping_invoice_blank_file($shipping_invoice_id, $shipping_company, $supplier_name, $supplier_address, $supplier_phone_no, $same_address, $destination_recipient_name, $destination_company_name, $destination_address, $destination_phone_no, $country_of_origin_id, $total_unit_value, $fba_fees, $total_value_of_shipment, 3, 1, $user_id, $updated_at);
			}

			$product_tbl_count = $this->input->post('product_tbl_count');

			for ($i = 0; $i < $product_tbl_count; $i++) {
				$shipping_invoice_product_id = $this->input->post('shipping_invoice_product_id[' . $i . ']');
				$shipping_invoice_active = $this->input->post('shipping_invoice_active[' . $i . ']');
				$new_shipping_invoice = $this->input->post('new_shipping_invoice[' . $i . ']');
				$product_registration_id = $this->input->post('product[' . $i . ']');
				$asin = stripslashes($this->input->post('asin[' . $i . ']'));
				$online_selling_price = (!empty($this->input->post('price[' . $i . ']')) ? $this->input->post('price[' . $i . ']') : '0.00');
				$fba_listing_fee = (!empty($this->input->post('fba_listing_fee[' . $i . ']')) ? $this->input->post('fba_listing_fee[' . $i . ']') : '0.00');
				$fba_shipping_fee = (!empty($this->input->post('fba_shipping_fee[' . $i . ']')) ? $this->input->post('fba_shipping_fee[' . $i . ']') : '0.00');
				$quantity = $this->input->post('qty[' . $i . ']');
				$unit_value = (!empty($this->input->post('unit_value[' . $i . ']')) ? str_replace(',', '', $this->input->post('unit_value[' . $i . ']')) : '0.00');
				$unit_value_total_amount = (!empty($this->input->post('unit_value_total_amount[' . $i . ']')) ? str_replace(',', '', $this->input->post('unit_value_total_amount[' . $i . ']')) : '0.00');
				$total_amount = (!empty($this->input->post('total_amount[' . $i . ']')) ? str_replace(',', '', $this->input->post('total_amount[' . $i . ']')) : '0.00');

				if ($shipping_invoice_active == '0') {
					$result[] = $this->Japan_ior_model->inactive_shipping_invoice_products($shipping_invoice_product_id, $shipping_invoice_id, 0, $updated_at);
				}

				if ($new_shipping_invoice == '0') {
					$result[] = $this->Japan_ior_model->update_shipping_invoice_products($shipping_invoice_product_id, $shipping_invoice_id, $product_registration_id, $asin, $online_selling_price, $fba_listing_fee, $fba_shipping_fee, $quantity, $unit_value, $unit_value_total_amount, $total_amount, 1, $updated_at);
				}

				if ($new_shipping_invoice == '1') {
					$created_at = date('Y-m-d H:i:s');
					if ($product_sampling == 1) {
						$result[] = $this->Japan_ior_model->insert_shipping_invoice_products_sampling($shipping_invoice_id, $product_registration_id, $asin, $online_selling_price, $fba_listing_fee, $fba_shipping_fee, $quantity, $unit_value, $unit_value_total_amount, $total_amount, 1, $created_at);
					} else {
						$result[] = $this->Japan_ior_model->insert_shipping_invoice_products($shipping_invoice_id, $product_registration_id, $asin, $online_selling_price, $fba_listing_fee, $fba_shipping_fee, $quantity, $unit_value, $unit_value_total_amount, $total_amount, 1, $created_at);
					}
				}
			}

			if (isset($_POST['save'])) {
				if (in_array(1, $results)) {
					$this->session->set_flashdata('success', 'Successfully saved the shipping invoice request as draft!');
					$this->send_email_notification(2,  $company_name, $shipping_invoice_id);
					if ($product_sampling == 1) {
						redirect('japan-ior/shipping-invoices-product-sampling', 'refresh');
					} else {
						redirect('japan-ior/shipping-invoices', 'refresh');
					}
				} else {
					$this->session->set_flashdata('errors', 'Sorry for the inconvenience. Some errors found. Please contact administrator through livechat or email.');
					if ($product_sampling == 1) {
						redirect('japan-ior/shipping-invoices-product-sampling', 'refresh');
					} else {
						redirect('japan-ior/shipping-invoices', 'refresh');
					}
				}
			}
		}
	}

	public function custom_shipping_invoice($shipping_invoice_id, $status, $invoice_no = '')
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
			$user_details = $q_user_details->row();

			if ($user_details->ior_registered != '1' && $user_details->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$q_country = $this->Japan_ior_model->fetch_country_by_id($user_details->country);
		$country = $q_country->row();

		$q_shipping_invoice = $this->Japan_ior_model->fetch_shipping_invoice_by_id($shipping_invoice_id);
		$shipping_invoice_details = $q_shipping_invoice->row();

		$pdf = new TCPDF();

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->AddPage('L');
		$pdf->SetFont('cid0jp', 'B', 14);
		$pdf->Ln(0);
		$pdf->Cell(40, 10, 'Company Name (会社名)');
		$pdf->SetFont('cid0jp', '', 10);
		$pdf->Ln(10);
		$pdf->Cell(40, 10, $user_details->company_name);
		$pdf->Ln(5);
		$pdf->Cell(40, 10, $user_details->company_address);
		$pdf->Ln(5);
		$pdf->Cell(40, 10, $user_details->city . ', ' . $country->nicename . ', ' . $user_details->zip_code);
		$pdf->Ln(5);
		$pdf->Cell(40, 10, $user_details->contact_number);
		$pdf->Ln(10);
		$pdf->Cell(40, 10, 'Business License #: ' . $user_details->business_license);
		$pdf->Ln(5);
		$pdf->Cell(40, 10, 'Contact Person: ' . $user_details->contact_person);
		$pdf->Ln(5);
		$pdf->Cell(40, 10, 'Contact Email: ' . $user_details->email);

		$pdf->SetY(10);
		$pdf->Ln(0);
		$pdf->SetX(170);
		$pdf->SetFont('cid0jp', 'B', 14);
		$pdf->Cell(40, 10, 'Shipping Invoice (シッピングインボイス)');
		$pdf->SetFont('cid0jp', '', 10);
		$pdf->Ln(10);
		$pdf->SetX(170);

		if ($status == 0) {
			$pdf->Cell(40, 10, 'Invoice #: N/A');
		} else {
			$pdf->Cell(40, 10, 'Invoice #: ' . $invoice_no);
		}

		$pdf->Ln(5);
		$pdf->SetX(170);

		if (!empty($shipping_invoice_details->invoice_date)) {
			if ($shipping_invoice_details->invoice_date != '0000-00-00') {
				$pdf->Cell(40, 10, 'Date: ' . date('F d, Y', strtotime($shipping_invoice_details->invoice_date)));
			} else {
				$pdf->Cell(40, 10, 'Date: N/A');
			}
		} else {
			$pdf->Cell(40, 10, 'Date: N/A');
		}

		$pdf->Ln(5);
		$pdf->SetX(170);
		$pdf->Cell(40, 10, 'Shipping Company: ' . $shipping_invoice_details->shipping_company_name);
		$pdf->Ln(10);
		$pdf->SetX(170);
		$pdf->Cell(40, 10, 'Total Shipment Value: ' . number_format($shipping_invoice_details->total_value_of_shipment, 2));

		$shipping_invoice_pdf_dir = getcwd() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'shipping_invoice_pdf' . DIRECTORY_SEPARATOR . $user_id . DIRECTORY_SEPARATOR . $shipping_invoice_id;

		if (file_exists($shipping_invoice_pdf_dir)) {
			$pdf->Output($shipping_invoice_pdf_dir . DIRECTORY_SEPARATOR . 'Shipping Invoice Only Preview' .  '.pdf', 'F');
		} else {
			mkdir($shipping_invoice_pdf_dir, 0777);
			$pdf->Output($shipping_invoice_pdf_dir . DIRECTORY_SEPARATOR . 'Shipping Invoice Only Preview' . '.pdf', 'F');
		}

		$q_shipping_invoice = $this->Japan_ior_model->fetch_shipping_invoice_by_id($shipping_invoice_id);
		$shipping_invoice_data = $q_shipping_invoice->row();

		$pdf_merge = new PDFMerger;
		$pdf_merge->addPDF('./uploads/shipping_invoice_pdf/' . $user_id . '/' . $shipping_invoice_id . '/' . 'Shipping Invoice Only Preview.pdf', 'all');

		$pdf_merge->addPDF('./uploads/shipping_invoice_pdf/' . $user_id . '/' . $shipping_invoice_data->fosr, 'all');
		$pdf_merge->merge('file', APPPATH . '../uploads/shipping_invoice_pdf/' . $user_id . '/' . $shipping_invoice_id . '/' . 'Shipping Invoice Preview.pdf');

		$pdf_watermark = new Fpdi();
		$pdf_watermark->setSourceFile('./uploads/shipping_invoice_pdf/' . $user_id . '/' . $shipping_invoice_id . '/' . 'Shipping Invoice Preview.pdf');
		$pdf_pagecount = (new TCPDI())->setSourceData((string)file_get_contents('./uploads/shipping_invoice_pdf/' . $user_id . '/' . $shipping_invoice_id . '/' . 'Shipping Invoice Preview.pdf'));

		$imgWidth = 110;
		$imgHeight = 170;

		for ($i = 1; $i <= $pdf_pagecount; $i++) {
			$tplId = $pdf_watermark->importPage($i);
			$size = $pdf_watermark->getTemplateSize($tplId);
			$pdf_watermark->AddPage(($size['height'] > $size['width']) ? 'P' : 'L', array($size['width'], $size['height']));
			$pdf_watermark->useTemplate($tplId);

			$x = ($size['width'] - $imgWidth) / 2;
			$y = ($size['height'] - $imgHeight) / 2;

			if ($status == 0) {
				$pdf_watermark->Image('assets/img/not_approved.png', $x, $y, $imgWidth, $imgHeight);
			} else {
				$pdf_watermark->Image('assets/img/approved.png', $x, $y, $imgWidth, $imgHeight);
			}
		}

		if ($status == 0) {
			$pdf_watermark->Output($shipping_invoice_pdf_dir . DIRECTORY_SEPARATOR . 'Shipping Invoice Preview' .  '.pdf', 'F');
		} else {
			$pdf_watermark->Output($shipping_invoice_pdf_dir . DIRECTORY_SEPARATOR . $invoice_no . ' Shipping Invoice' .  '.pdf', 'F');
		}
	}
	public function default_shipping_invoice($shipping_invoice_id, $status, $invoice_no = '', $fba, $product_sampling, $company_link)
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
			$user_details = $q_user_details->row();

			if ($user_details->ior_registered != '1' && $user_details->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$q_country = $this->Japan_ior_model->fetch_country_by_id($user_details->country);
		$country = $q_country->row();

		$q_shipping_invoice = $this->Japan_ior_model->fetch_shipping_invoice_by_id($shipping_invoice_id);
		$shipping_invoice_details = $q_shipping_invoice->row();

		$q_shipping_invoice_products = $this->Japan_ior_model->fetch_shipping_invoice_products_by_id($shipping_invoice_id);
		$shipping_invoice_products = $q_shipping_invoice_products->result();

		$pdf = new TCPDF();

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->AddPage('L');
		$pdf->SetFont('cid0jp', 'B', 14);
		$pdf->Ln(0);
		$pdf->Cell(40, 10, 'Company Name (会社名)');
		$pdf->SetFont('cid0jp', '', 10);
		$pdf->Ln(10);
		$pdf->Cell(40, 10, $user_details->company_name);
		$pdf->Ln(5);
		$pdf->Cell(40, 10, $user_details->company_address);
		$pdf->Ln(5);
		$pdf->Cell(40, 10, $user_details->city . ', ' . $country->nicename . ', ' . $user_details->zip_code);
		$pdf->Ln(5);
		$pdf->Cell(40, 10, $user_details->contact_number);
		$pdf->Ln(10);
		$pdf->Cell(40, 10, 'Business License #: ' . $user_details->business_license);
		$pdf->Ln(5);
		$pdf->Cell(40, 10, 'Contact Person: ' . $user_details->contact_person);
		$pdf->Ln(5);
		$pdf->Cell(40, 10, 'Contact Email: ' . $user_details->email);

		$pdf->SetY(10);
		$pdf->Ln(0);
		$pdf->SetX(170);
		$pdf->SetFont('cid0jp', 'B', 14);
		$pdf->Cell(40, 10, 'Shipping Invoice (シッピングインボイス)');
		$pdf->SetFont('cid0jp', '', 10);
		$pdf->Ln(10);
		$pdf->SetX(170);

		if ($status == 0) {
			$pdf->Cell(40, 10, 'Invoice #: N/A');
		} else {
			$pdf->Cell(40, 10, 'Invoice #: ' . $invoice_no);
		}

		$pdf->Ln(5);
		$pdf->SetX(170);

		if (!empty($shipping_invoice_details->invoice_date)) {
			if ($shipping_invoice_details->invoice_date != '0000-00-00') {
				$pdf->Cell(40, 10, 'Date: ' . date('F d, Y', strtotime($shipping_invoice_details->invoice_date)));
			} else {
				$pdf->Cell(40, 10, 'Date: N/A');
			}
		} else {
			$pdf->Cell(40, 10, 'Date: N/A');
		}

		if ($company_link == 1 && $product_sampling != 1) {
			$pdf->Ln(5);
			$pdf->SetX(170);
			$pdf->Cell(40, 10, 'Shipping Company: ' . $shipping_invoice_details->shipping_company_name);
		}

		if ($shipping_invoice_details->same_address != 1) {
			$pdf->SetY(70);
			$pdf->Ln(0);
			$pdf->SetFont('cid0jp', 'B', 14);
			$pdf->Cell(40, 10, 'Supplier (供給元)');
			$pdf->SetFont('cid0jp', '', 10);
			$pdf->Ln(10);
			$pdf->Cell(40, 10, $shipping_invoice_details->supplier_name);
			$pdf->SetXY(10, 88);
			$pdf->MultiCell(100, 10, $shipping_invoice_details->supplier_address, 0, 'L', 0, 1, '', '', true);
			$pdf->Ln(-3);
			$pdf->Cell(40, 10, $shipping_invoice_details->supplier_phone_no);
		}

		$pdf->SetY(70);
		$pdf->Ln(0);
		$pdf->SetX(112);
		$pdf->SetFont('cid0jp', 'B', 14);
		$pdf->Cell(40, 10, 'Destination (送り先)');
		$pdf->SetFont('cid0jp', '', 10);
		$pdf->Ln(10);
		$pdf->SetX(112);
		$pdf->Cell(40, 10, $shipping_invoice_details->destination_recipient_name);
		$pdf->Ln(5);
		$pdf->SetX(112);
		$pdf->Cell(40, 10, $shipping_invoice_details->destination_company_name);
		$pdf->SetXY(112, 93);
		$pdf->MultiCell(90, 10, $shipping_invoice_details->destination_address, 0, 'L', 0, 1, '', '', true);
		$pdf->Ln(-3);
		$pdf->SetX(112);
		$pdf->Cell(40, 10, $shipping_invoice_details->destination_phone_no);

		$pdf->SetY(70);
		$pdf->Ln(0);
		$pdf->SetX(200);
		$pdf->SetFont('cid0jp', 'B', 14);
		$pdf->Cell(40, 10, 'Importer of Record - IOR');
		$pdf->SetFont('cid0jp', '', 10);
		$pdf->Ln(10);
		$pdf->SetX(200);
		$pdf->Cell(40, 10, 'Company Name: COVUE JAPAN K.K.');
		$pdf->Ln(5);
		$pdf->SetX(200);
		$pdf->Cell(40, 10, 'Japan Customs Number: P002AK300000');
		$pdf->Ln(5);
		$pdf->SetX(200);
		$pdf->Cell(70, 10, 'Address: 3/F, 1-6-19 Azuchimachi Chuo-ku,');
		$pdf->Ln(5);
		$pdf->SetX(200);
		$pdf->Cell(40, 10, 'Osaka, Japan 541-0052 Japan');
		$pdf->Ln(5);
		$pdf->SetX(200);
		$pdf->Cell(40, 10, 'Phone Number: +81 (50) 8881-2699');
		$pdf->Ln(10);
		$pdf->SetX(200);
		$pdf->SetFont('cid0jp', 'B', 13);
		$pdf->SetTextColor(139, 0, 0);
		$pdf->Cell(40, 10, 'Incoterms: DDP');
		$pdf->SetTextColor(0, 0, 0);

		$pdf->SetFont('cid0jp', '', 10);
		$pdf->SetY(110);
		$pdf->Ln(0);
		$pdf->Cell(40, 10, 'Country of Origin: ' . $shipping_invoice_details->country_name);

		$pdf->SetY(130);
		if ($product_sampling == 1) {
			$tbl = 	<<<EOD
			<table border="1" cellpadding="2" cellspacing="0" nobr="true">
				<thead>
					<tr>
						<th align="center"><br><br>品名</th>
						<th align="center"><br><br>HS Code</th>
						<th align="center"><br><br>数量</th>
						<th align="center">日本小売価格<br>JPY/pcs(税込)</th>
						<th align="center"><br><br>JPY</th>
					</tr>
				</thead>
				<tbody>					
					<tr>
						<td align="center"><strong><br><br>Product Name <br> (Product Sample for Import Application and Testing. Not for use or sale. No Commercial Value.)</strong></td>
						<td align="center"><strong><br><br>HS Code</strong></td>
						<td align="center"><strong><br><br>Quantity</strong></td>
						<td align="center"><strong><br><br>Unit Cost</strong></td>
						<td align="center"><strong><br><br>Total Unit Cost</strong></td>
					</tr>
				
			EOD;
		} else {
			if ($fba == 2) {
				if ($shipping_invoice_products[0]->is_mailing_product == 1) {
					$tbl = 	<<<EOD
				<table border="1" cellpadding="2" cellspacing="0" nobr="true">
					<thead>
						<tr>
							<th align="center"><br><br>品名</th>
							<th align="center"><br><br>品型</th>
							<th align="center"><br><br>HS Code</th>
							<th align="center"><br><br>数量</th>
							<th align="center"><br><br>単価</th>
							<th align="center"><br><br>総単価</th>
						</tr>
					</thead>
					<tbody>					
						<tr>
							<td align="center"><strong><br><br>Product Name</strong></td>
							<td align="center"><strong><br><br>Product Type</strong></td>
							<td align="center"><strong><br><br>HS Code</strong></td>
							<td align="center"><strong><br><br>Quantity</strong></td>
							<td align="center"><strong><br><br>Unit Cost</strong></td>
							<td align="center"><strong><br><br>Total Unit Cost</strong></td>
						</tr>
					
				EOD;
				} else {
					$tbl = 	<<<EOD
				<table border="1" cellpadding="2" cellspacing="0" nobr="true">
					<thead>
						<tr>
							<th align="center"><br><br>品名</th>
							<th align="center"><br><br>HS Code</th>
							<th align="center"><br><br>数量</th>
							<th align="center">日本小売価格<br>JPY/pcs(税込)</th>
							<th align="center"><br><br>JPY</th>
						</tr>
					</thead>
					<tbody>					
						<tr>
							<td align="center"><strong><br><br>Product Name</strong></td>
							<td align="center"><strong><br><br>HS Code</strong></td>
							<td align="center"><strong><br><br>Quantity</strong></td>
							<td align="center"><strong>Declared<br>Online Selling<br>Price/Value<br>(per unit)</strong></td>
							<td align="center"><strong>Total Declared<br>Online Selling<br>Pricing/Value</strong></td>
						</tr>
					
				EOD;
				}
			} else {
				$tbl = 	<<<EOD
				<table border="1" cellpadding="2" cellspacing="0" nobr="true">
					<thead>
						<tr>
							<th align="center"><br><br>品名</th>
							<th align="center"><br><br>HS Code</th>
							<th align="center"><br><br>ASIN番号</th>
							<th align="center"><br><br>数量</th>
							<th align="center">日本小売価格<br>JPY/pcs(税込)</th>
							<th align="center">申告価格<br>JPY/pcs</th>
							<th align="center">AMZ販売手数料<br>JPY/pcs(税込)</th>
							<th align="center">AMZ FBA手数料<br>JPY/pcs(税込)</th>
							<th align="center"><br><br>JPY</th>
							<th align="center">合計金額<br>JPY</th>
						</tr>
					</thead>
					<tbody>					
						<tr>
							<td align="center"><strong><br><br>Product Name</strong></td>
							<td align="center"><strong><br><br>HS Code</strong></td>
							<td align="center"><strong><br><br>ASIN</strong></td>
							<td align="center"><strong><br><br>Quantity</strong></td>
							<td align="center"><strong>Declared<br>Online Selling<br>Price/Value<br>(per unit)</strong></td>
							<td align="center"><strong>Adjusted Online<br>Declared Selling<br>Price/Value<br>(per unit)</strong></td>
							<td align="center"><strong>AMZ<br>Selling Fee<br>(per unit)</strong></td>
							<td align="center"><strong>AMZ<br>FBA Fee<br>(per unit)</strong></td>
							<td align="center"><strong>Total Declared<br>Online Selling<br>Pricing/Value</strong></td>
							<td align="center"><strong>Total Adjusted<br>Online Declared<br>Selling<br>Price/Value<br>(- Fee)</strong></td>
						</tr>
					
				EOD;
			}
		}

		foreach ($shipping_invoice_products as $shipping_invoice_product) {
			$product_name_formatted = str_replace('&apos;', "'", $shipping_invoice_product->product_name);

			$online_selling_price_formatted = number_format($shipping_invoice_product->online_selling_price, 2);
			$unit_value_formatted = number_format($shipping_invoice_product->unit_value, 2);

			$fba_listing_fee_formatted = number_format($shipping_invoice_product->fba_listing_fee, 2);
			$fba_shipping_fee_formatted = number_format($shipping_invoice_product->fba_shipping_fee, 2);

			$total_amount_formatted = number_format($shipping_invoice_product->total_amount, 2);
			$unit_value_total_amount_formatted = number_format($shipping_invoice_product->unit_value_total_amount, 2);

			$total_unit_value_formatted = number_format($shipping_invoice_details->total_unit_value, 2);
			$fba_fees_formatted = number_format($shipping_invoice_details->fba_fees, 2);
			$total_value_of_shipment_formatted = number_format($shipping_invoice_details->total_value_of_shipment, 2);
			$prodtype = ($shipping_invoice_product->product_type == 1) ? 'Commercial' : 'Non-Commercial';
			if ($fba == 2) {
				if ($shipping_invoice_products[0]->is_mailing_product == 1) {
					$tbl .= <<<EOD
						<tr>
							<td align="center">$product_name_formatted</td>
							<td align="center">$prodtype</td>
							<td align="center">$shipping_invoice_product->sku</td>
							<td align="center">$shipping_invoice_product->quantity</td>
							<td align="center">$online_selling_price_formatted</td>
							<td align="center">$total_amount_formatted</td>
						</tr>
					EOD;
				} else {
					$tbl .= <<<EOD
						<tr>
							<td align="center">$product_name_formatted</td>
							<td align="center">$shipping_invoice_product->sku</td>
							<td align="center">$shipping_invoice_product->quantity</td>
							<td align="center">$online_selling_price_formatted</td>
							<td align="center">$total_amount_formatted</td>
						</tr>
					EOD;
				}
			} else {
				$tbl .= <<<EOD
				<tr>
					<td align="center">$product_name_formatted</td>
					<td align="center">$shipping_invoice_product->sku</td>
					<td align="center">$shipping_invoice_product->asin</td>
					<td align="center">$shipping_invoice_product->quantity</td>
					<td align="center">$online_selling_price_formatted</td>
					<td align="center">$unit_value_formatted</td>
					<td align="center">$fba_listing_fee_formatted</td>
					<td align="center">$fba_shipping_fee_formatted</td>
					<td align="center">$total_amount_formatted</td>
					<td align="center">$unit_value_total_amount_formatted</td>
				</tr>
			EOD;
			}
		}
		if ($product_sampling == 1) {
			$tbl .= <<<EOD
			<tr>
				<td align="right" colspan="4"><h4>Total Declared Value</h4></td>
				<td align="center"><h4>$total_value_of_shipment_formatted</h4></td>
			</tr>
			</tbody>
			</table>
		EOD;
		} else {
			if ($fba == 2) {
				if ($shipping_invoice_products[0]->is_mailing_product == 1) {
					$tbl .= <<<EOD
					<tr>
						<td align="right" colspan="5"><h4>Total Cost</h4></td>
						<td align="center"><h4>$total_value_of_shipment_formatted</h4></td>
					</tr>
					</tbody>
					</table>
				EOD;
				} else {
					$tbl .= <<<EOD
					<tr>
						<td align="right" colspan="4"><h4>Total Declared Online Selling Price</h4></td>
						<td align="center"><h4>$total_value_of_shipment_formatted</h4></td>
					</tr>
					</tbody>
					</table>
				EOD;
				}
			} else {
				$tbl .= <<<EOD
						<tr>
							<td align="right" colspan="9">Total Declared Online Selling Price</td>
							<td align="center">$total_value_of_shipment_formatted</td>
						</tr>
						<tr>
							<td align="right" colspan="9" >AMZ Fees (JPY)</td>
							<td align="center">$fba_fees_formatted</td>
						</tr>
						<tr>
							<td align="right" colspan="9"><h4>Total Adjusted Selling Price</h4></td>
							<td align="center"><h4>$total_unit_value_formatted</h4></td>
						</tr>
					</tbody>
				</table>
				EOD;
			}
		}

		$pdf->writeHTML($tbl, true, false, false, false, '');

		$shipping_invoice_pdf_dir = getcwd() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'shipping_invoice_pdf' . DIRECTORY_SEPARATOR . $user_id . DIRECTORY_SEPARATOR . $shipping_invoice_id;

		if (file_exists($shipping_invoice_pdf_dir)) {
			$pdf->Output($shipping_invoice_pdf_dir . DIRECTORY_SEPARATOR . 'Shipping Invoice Only Preview' .  '.pdf', 'F');
		} else {
			mkdir($shipping_invoice_pdf_dir, 0777);
			$pdf->Output($shipping_invoice_pdf_dir . DIRECTORY_SEPARATOR . 'Shipping Invoice Only Preview' . '.pdf', 'F');
		}

		$q_shipping_invoice = $this->Japan_ior_model->fetch_shipping_invoice_by_id($shipping_invoice_id);
		$shipping_invoice_data = $q_shipping_invoice->row();

		if ($product_sampling == 1 && $shipping_invoice_data->fosr == '') {
			$pdf_merge = new PDFMerger;
			$pdf_watermark = new Fpdi();
			$pdf_watermark->setSourceFile('./uploads/shipping_invoice_pdf/' . $user_id . '/' . $shipping_invoice_id . '/' . 'Shipping Invoice Only Preview.pdf');
			$pdf_pagecount = (new TCPDI())->setSourceData((string)file_get_contents('./uploads/shipping_invoice_pdf/' . $user_id . '/' . $shipping_invoice_id . '/' . 'Shipping Invoice Only Preview.pdf'));

			for ($i = 1; $i <= $pdf_pagecount; $i++) {
				if ($i != 1) {
					$tplId = $pdf_watermark->importPage($i);
					$size = $pdf_watermark->getTemplateSize($tplId);
					$pdf_watermark->AddPage(($size['height'] > $size['width']) ? 'P' : 'L', array($size['width'], $size['height']));
					$pdf_watermark->useTemplate($tplId);

					$imgWidth = 150;
					$imgHeight = 210;

					$x = ($size['width'] - $imgWidth) / 2;
					$y = ($size['height'] - $imgHeight) / 2;

					if ($status == 0) {
						$pdf_watermark->Image('assets/img/not_approved.png', $x, $y, $imgWidth, $imgHeight);
					} else {
						$pdf_watermark->Image('assets/img/approved.png', $x, $y, $imgWidth, $imgHeight);
					}
				} else {
					$pdf_watermark->AddPage('L');
					$tplId = $pdf_watermark->importPage($i);
					$pdf_watermark->useTemplate($tplId);

					if ($status == 0) {
						$pdf_watermark->Image('assets/img/not_approved.png', 70, 0, 150, 210);
					} else {
						$pdf_watermark->Image('assets/img/approved.png', 70, 0, 150, 210);
					}
				}
			}

			if ($status == 0) {
				$pdf_watermark->Output($shipping_invoice_pdf_dir . DIRECTORY_SEPARATOR . 'Shipping Invoice Preview' .  '.pdf', 'F');
			} else {
				$pdf_watermark->Output($shipping_invoice_pdf_dir . DIRECTORY_SEPARATOR . $invoice_no . ' Shipping Invoice' .  '.pdf', 'F');
			}
		} else {
			$pdf_merge = new PDFMerger;
			$pdf_merge->addPDF('./uploads/shipping_invoice_pdf/' . $user_id . '/' . $shipping_invoice_id . '/' . 'Shipping Invoice Only Preview.pdf', 'all');
			if ($fba == 1) {
				$pdf_merge->addPDF('./uploads/shipping_invoice_pdf/' . $user_id . '/' . $shipping_invoice_data->fosr, 'all');
				$pdf_merge->addPDF('./uploads/shipping_invoice_pdf/' . $user_id . '/' . $shipping_invoice_data->simulator, 'all');
			} else {
				$pdf_merge->addPDF('./uploads/shipping_invoice_pdf/' . $user_id . '/' . $shipping_invoice_data->fosr, 'all');
			}
			$pdf_merge->merge('file', APPPATH . '../uploads/shipping_invoice_pdf/' . $user_id . '/' . $shipping_invoice_id . '/' . 'Shipping Invoice Preview.pdf');

			$pdf_watermark = new Fpdi();
			$pdf_watermark->setSourceFile('./uploads/shipping_invoice_pdf/' . $user_id . '/' . $shipping_invoice_id . '/' . 'Shipping Invoice Preview.pdf');
			$pdf_pagecount = (new TCPDI())->setSourceData((string)file_get_contents('./uploads/shipping_invoice_pdf/' . $user_id . '/' . $shipping_invoice_id . '/' . 'Shipping Invoice Preview.pdf'));

			for ($i = 1; $i <= $pdf_pagecount; $i++) {
				if ($i != 1) {
					$tplId = $pdf_watermark->importPage($i);
					$size = $pdf_watermark->getTemplateSize($tplId);
					$pdf_watermark->AddPage(($size['height'] > $size['width']) ? 'P' : 'L', array($size['width'], $size['height']));
					$pdf_watermark->useTemplate($tplId);

					$imgWidth = 150;
					$imgHeight = 210;

					$x = ($size['width'] - $imgWidth) / 2;
					$y = ($size['height'] - $imgHeight) / 2;

					if ($status == 0) {
						$pdf_watermark->Image('assets/img/not_approved.png', $x, $y, $imgWidth, $imgHeight);
					} else {
						$pdf_watermark->Image('assets/img/approved.png', $x, $y, $imgWidth, $imgHeight);
					}
				} else {
					$pdf_watermark->AddPage('L');
					$tplId = $pdf_watermark->importPage($i);
					$pdf_watermark->useTemplate($tplId);

					if ($status == 0) {
						$pdf_watermark->Image('assets/img/not_approved.png', 70, 0, 150, 210);
					} else {
						$pdf_watermark->Image('assets/img/approved.png', 70, 0, 150, 210);
					}
				}
			}

			if ($status == 0) {
				$pdf_watermark->Output($shipping_invoice_pdf_dir . DIRECTORY_SEPARATOR . 'Shipping Invoice Preview' .  '.pdf', 'F');
			} else {
				$pdf_watermark->Output($shipping_invoice_pdf_dir . DIRECTORY_SEPARATOR . $invoice_no . ' Shipping Invoice' .  '.pdf', 'F');
			}
		}
	}

	public function default_shipping_invoice_zoho($shipping_invoice_id,$product_sampling, $invoice_no = '',$fba,$poa_array)
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
			$user_details = $q_user_details->row();

			if ($user_details->ior_registered != '1' && $user_details->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$q_country = $this->Japan_ior_model->fetch_country_by_id($user_details->country);
		$country = $q_country->row();

		$q_shipping_invoice = $this->Japan_ior_model->fetch_shipping_invoice_by_id($shipping_invoice_id);
		$shipping_invoice_details = $q_shipping_invoice->row();

		$q_shipping_invoice_products = $this->Japan_ior_model->fetch_shipping_invoice_products_by_id($shipping_invoice_id);
		$shipping_invoice_products = $q_shipping_invoice_products->result();

		$pdf = new TCPDF();

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->AddPage('L');
		$pdf->SetFont('cid0jp', 'B', 14);
		$pdf->Ln(0);
		$pdf->Cell(40, 10, 'Port of Arrival');
		$pdf->SetFont('cid0jp', '', 10);
		$pdf->Ln(10);
		$pdf->Cell(40, 10, $poa_array['company_name']);
		$pdf->Ln(5);
		$pdf->Cell(40, 10, $poa_array['address_line_2']);
		$pdf->Ln(5);
		$pdf->Cell(40, 10, $poa_array['city'] . ', ' . $poa_array['state']. ', ' . $poa_array['country_1'] . ', ' . $poa_array['postal']);
		$pdf->Ln(5);

		

		$pdf->SetY(10);
		$pdf->Ln(0);
		$pdf->SetX(170);
		$pdf->SetFont('cid0jp', 'B', 14);
		$pdf->Cell(40, 10, 'Destination (送り先)');
		$pdf->SetFont('cid0jp', '', 10);
		$pdf->Ln(10);
		$pdf->SetX(170);
		$pdf->Cell(40, 10, $shipping_invoice_details->destination_recipient_name);
		$pdf->Ln(4);
		$pdf->SetX(170);
		$pdf->Cell(40, 10, $shipping_invoice_details->destination_company_name);
		$pdf->Ln(7);
		$pdf->SetX(170);
		$pdf->MultiCell(60, 10, $shipping_invoice_details->destination_address, 0, 'L', 0, 1, '', '', true);
		$pdf->Ln(-8);
		$pdf->SetX(170);
		$pdf->Cell(40, 10, $shipping_invoice_details->destination_phone_no);

		// $pdf->SetY(10);
		// $pdf->Ln(0);
		// $pdf->SetX(170);
		// $pdf->SetFont('cid0jp', 'B', 14);
		// $pdf->Cell(40, 10, 'Shipping Invoice (シッピングインボイス)');
		// $pdf->SetFont('cid0jp', '', 10);
		// $pdf->Ln(10);
		// $pdf->SetX(170);

		// if ($status == 0) {
		// 	$pdf->Cell(40, 10, 'Invoice #: N/A');
		// } else {
		// 	$pdf->Cell(40, 10, 'Invoice #: ' . $invoice_no);
		// }

		// $pdf->Ln(5);
		// $pdf->SetX(170);

		// if (!empty($shipping_invoice_details->invoice_date)) {
		// 	if ($shipping_invoice_details->invoice_date != '0000-00-00') {
		// 		$pdf->Cell(40, 10, 'Date: ' . date('F d, Y', strtotime($shipping_invoice_details->invoice_date)));
		// 	} else {
		// 		$pdf->Cell(40, 10, 'Date: N/A');
		// 	}
		// } else {
		// 	$pdf->Cell(40, 10, 'Date: N/A');
		// }

		// if ($company_link == 1 && $product_sampling != 1) {
		// 	$pdf->Ln(5);
		// 	$pdf->SetX(170);
		// 	$pdf->Cell(40, 10, 'Shipping Company: ' . $shipping_invoice_details->shipping_company_name);
		// }

		// if ($shipping_invoice_details->same_address != 1) {
		// 	$pdf->SetY(70);
		// 	$pdf->Ln(0);
		// 	$pdf->SetFont('cid0jp', 'B', 14);
		// 	$pdf->Cell(40, 10, 'Supplier (供給元)');
		// 	$pdf->SetFont('cid0jp', '', 10);
		// 	$pdf->Ln(10);
		// 	$pdf->Cell(40, 10, $shipping_invoice_details->supplier_name);
		// 	$pdf->SetXY(10, 88);
		// 	$pdf->MultiCell(100, 10, $shipping_invoice_details->supplier_address, 0, 'L', 0, 1, '', '', true);
		// 	$pdf->Ln(-3);
		// 	$pdf->Cell(40, 10, $shipping_invoice_details->supplier_phone_no);
		// }

		// $pdf->SetY(70);
		// $pdf->Ln(0);
		// $pdf->SetX(112);
		// $pdf->SetFont('cid0jp', 'B', 14);
		// $pdf->Cell(40, 10, 'Destination (送り先)');
		// $pdf->SetFont('cid0jp', '', 10);
		// $pdf->Ln(10);
		// $pdf->SetX(112);
		// $pdf->Cell(40, 10, $shipping_invoice_details->destination_recipient_name);
		// $pdf->Ln(5);
		// $pdf->SetX(112);
		// $pdf->Cell(40, 10, $shipping_invoice_details->destination_company_name);
		// $pdf->SetXY(112, 93);
		// $pdf->MultiCell(90, 10, $shipping_invoice_details->destination_address, 0, 'L', 0, 1, '', '', true);
		// $pdf->Ln(-3);
		// $pdf->SetX(112);
		// $pdf->Cell(40, 10, $shipping_invoice_details->destination_phone_no);

		// $pdf->SetY(70);
		// $pdf->Ln(0);
		// $pdf->SetX(200);
		// $pdf->SetFont('cid0jp', 'B', 14);
		// $pdf->Cell(40, 10, 'Importer of Record - IOR');
		// $pdf->SetFont('cid0jp', '', 10);
		// $pdf->Ln(10);
		// $pdf->SetX(200);
		// $pdf->Cell(40, 10, 'Company Name: COVUE JAPAN K.K.');
		// $pdf->Ln(5);
		// $pdf->SetX(200);
		// $pdf->Cell(40, 10, 'Japan Customs Number: P002AK300000');
		// $pdf->Ln(5);
		// $pdf->SetX(200);
		// $pdf->Cell(70, 10, 'Address: 3/F, 1-6-19 Azuchimachi Chuo-ku,');
		// $pdf->Ln(5);
		// $pdf->SetX(200);
		// $pdf->Cell(40, 10, 'Osaka, Japan 541-0052 Japan');
		// $pdf->Ln(5);
		// $pdf->SetX(200);
		// $pdf->Cell(40, 10, 'Phone Number: +81 (50) 8881-2699');
		// $pdf->Ln(10);
		// $pdf->SetX(200);
		// $pdf->SetFont('cid0jp', 'B', 13);
		// $pdf->SetTextColor(139, 0, 0);
		// $pdf->Cell(40, 10, 'Incoterms: DDP');
		// $pdf->SetTextColor(0, 0, 0);

		// $pdf->SetFont('cid0jp', '', 10);
		// $pdf->SetY(110);
		// $pdf->Ln(0);
		// $pdf->Cell(40, 10, 'Country of Origin: ' . $shipping_invoice_details->country_name);

		$pdf->SetY(130);
		if ($product_sampling == 1) {
			$tbl = 	<<<EOD
			<table border="1" cellpadding="2" cellspacing="0" nobr="true">
				<thead>
					<tr>
						<th align="center"><br><br>品名</th>
						<th align="center"><br><br>HS Code</th>
						<th align="center"><br><br>数量</th>
						<th align="center">日本小売価格<br>JPY/pcs(税込)</th>
						<th align="center"><br><br>JPY</th>
					</tr>
				</thead>
				<tbody>					
					<tr>
						<td align="center"><strong><br><br>Product Name <br> (Product Sample for Import Application and Testing. Not for use or sale. No Commercial Value.)</strong></td>
						<td align="center"><strong><br><br>HS Code</strong></td>
						<td align="center"><strong><br><br>Quantity</strong></td>
						<td align="center"><strong><br><br>Unit Cost</strong></td>
						<td align="center"><strong><br><br>Total Unit Cost</strong></td>
					</tr>
				
			EOD;
		} else {
			if ($fba == 2) {
				if ($shipping_invoice_products[0]->is_mailing_product == 1) {
					$tbl = 	<<<EOD
				<table border="1" cellpadding="2" cellspacing="0" nobr="true">
					<thead>
						<tr>
							<th align="center"><br><br>品名</th>
							<th align="center"><br><br>品型</th>
							<th align="center"><br><br>HS Code</th>
							<th align="center"><br><br>数量</th>
							<th align="center"><br><br>単価</th>
							<th align="center"><br><br>総単価</th>
						</tr>
					</thead>
					<tbody>					
						<tr>
							<td align="center"><strong><br><br>Product Name</strong></td>
							<td align="center"><strong><br><br>Product Type</strong></td>
							<td align="center"><strong><br><br>HS Code</strong></td>
							<td align="center"><strong><br><br>Quantity</strong></td>
							<td align="center"><strong><br><br>Unit Cost</strong></td>
							<td align="center"><strong><br><br>Total Unit Cost</strong></td>
						</tr>
					
				EOD;
				} else {
					$tbl = 	<<<EOD
				<table border="1" cellpadding="2" cellspacing="0" nobr="true">
					<thead>
						<tr>
							<th align="center"><br><br>品名</th>
							<th align="center"><br><br>HS Code</th>
							<th align="center"><br><br>数量</th>
							<th align="center">日本小売価格<br>JPY/pcs(税込)</th>
							<th align="center"><br><br>JPY</th>
						</tr>
					</thead>
					<tbody>					
						<tr>
							<td align="center"><strong><br><br>Product Name</strong></td>
							<td align="center"><strong><br><br>HS Code</strong></td>
							<td align="center"><strong><br><br>Quantity</strong></td>
							<td align="center"><strong>Declared<br>Online Selling<br>Price/Value<br>(per unit)</strong></td>
							<td align="center"><strong>Total Declared<br>Online Selling<br>Pricing/Value</strong></td>
						</tr>
					
				EOD;
				}
			} else {
				$tbl = 	<<<EOD
				<table border="1" cellpadding="2" cellspacing="0" nobr="true">
					<thead>
						<tr>
							<th align="center"><br><br>品名</th>
							<th align="center"><br><br>HS Code</th>
							<th align="center"><br><br>ASIN番号</th>
							<th align="center"><br><br>数量</th>
							<th align="center">日本小売価格<br>JPY/pcs(税込)</th>
							<th align="center">申告価格<br>JPY/pcs</th>
							<th align="center">AMZ販売手数料<br>JPY/pcs(税込)</th>
							<th align="center">AMZ FBA手数料<br>JPY/pcs(税込)</th>
							<th align="center"><br><br>JPY</th>
							<th align="center">合計金額<br>JPY</th>
						</tr>
					</thead>
					<tbody>					
						<tr>
							<td align="center"><strong><br><br>Product Name</strong></td>
							<td align="center"><strong><br><br>HS Code</strong></td>
							<td align="center"><strong><br><br>ASIN</strong></td>
							<td align="center"><strong><br><br>Quantity</strong></td>
							<td align="center"><strong>Declared<br>Online Selling<br>Price/Value<br>(per unit)</strong></td>
							<td align="center"><strong>Adjusted Online<br>Declared Selling<br>Price/Value<br>(per unit)</strong></td>
							<td align="center"><strong>AMZ<br>Selling Fee<br>(per unit)</strong></td>
							<td align="center"><strong>AMZ<br>FBA Fee<br>(per unit)</strong></td>
							<td align="center"><strong>Total Declared<br>Online Selling<br>Pricing/Value</strong></td>
							<td align="center"><strong>Total Adjusted<br>Online Declared<br>Selling<br>Price/Value<br>(- Fee)</strong></td>
						</tr>
					
				EOD;
			}
		}

		foreach ($shipping_invoice_products as $shipping_invoice_product) {
			$product_name_formatted = str_replace('&apos;', "'", $shipping_invoice_product->product_name);

			$online_selling_price_formatted = number_format($shipping_invoice_product->online_selling_price, 2);
			$unit_value_formatted = number_format($shipping_invoice_product->unit_value, 2);

			$fba_listing_fee_formatted = number_format($shipping_invoice_product->fba_listing_fee, 2);
			$fba_shipping_fee_formatted = number_format($shipping_invoice_product->fba_shipping_fee, 2);

			$total_amount_formatted = number_format($shipping_invoice_product->total_amount, 2);
			$unit_value_total_amount_formatted = number_format($shipping_invoice_product->unit_value_total_amount, 2);

			$total_unit_value_formatted = number_format($shipping_invoice_details->total_unit_value, 2);
			$fba_fees_formatted = number_format($shipping_invoice_details->fba_fees, 2);
			$total_value_of_shipment_formatted = number_format($shipping_invoice_details->total_value_of_shipment, 2);
			$prodtype = ($shipping_invoice_product->product_type == 1) ? 'Commercial' : 'Non-Commercial';
			if ($fba == 2) {
				if ($shipping_invoice_products[0]->is_mailing_product == 1) {
					$tbl .= <<<EOD
						<tr>
							<td align="center">$product_name_formatted</td>
							<td align="center">$prodtype</td>
							<td align="center">$shipping_invoice_product->sku</td>
							<td align="center">$shipping_invoice_product->quantity</td>
							<td align="center">$online_selling_price_formatted</td>
							<td align="center">$total_amount_formatted</td>
						</tr>
					EOD;
				} else {
					$tbl .= <<<EOD
						<tr>
							<td align="center">$product_name_formatted</td>
							<td align="center">$shipping_invoice_product->sku</td>
							<td align="center">$shipping_invoice_product->quantity</td>
							<td align="center">$online_selling_price_formatted</td>
							<td align="center">$total_amount_formatted</td>
						</tr>
					EOD;
				}
			} else {
				$tbl .= <<<EOD
				<tr>
					<td align="center">$product_name_formatted</td>
					<td align="center">$shipping_invoice_product->sku</td>
					<td align="center">$shipping_invoice_product->asin</td>
					<td align="center">$shipping_invoice_product->quantity</td>
					<td align="center">$online_selling_price_formatted</td>
					<td align="center">$unit_value_formatted</td>
					<td align="center">$fba_listing_fee_formatted</td>
					<td align="center">$fba_shipping_fee_formatted</td>
					<td align="center">$total_amount_formatted</td>
					<td align="center">$unit_value_total_amount_formatted</td>
				</tr>
			EOD;
			}
		}
		if ($product_sampling == 1) {
			$tbl .= <<<EOD
			<tr>
				<td align="right" colspan="4"><h4>Total Declared Value</h4></td>
				<td align="center"><h4>$total_value_of_shipment_formatted</h4></td>
			</tr>
			</tbody>
			</table>
		EOD;
		} else {
			if ($fba == 2) {
				if ($shipping_invoice_products[0]->is_mailing_product == 1) {
					$tbl .= <<<EOD
					<tr>
						<td align="right" colspan="5"><h4>Total Cost</h4></td>
						<td align="center"><h4>$total_value_of_shipment_formatted</h4></td>
					</tr>
					</tbody>
					</table>
				EOD;
				} else {
					$tbl .= <<<EOD
					<tr>
						<td align="right" colspan="4"><h4>Total Declared Online Selling Price</h4></td>
						<td align="center"><h4>$total_value_of_shipment_formatted</h4></td>
					</tr>
					</tbody>
					</table>
				EOD;
				}
			} else {
				$tbl .= <<<EOD
						<tr>
							<td align="right" colspan="9">Total Declared Online Selling Price</td>
							<td align="center">$total_value_of_shipment_formatted</td>
						</tr>
						<tr>
							<td align="right" colspan="9" >AMZ Fees (JPY)</td>
							<td align="center">$fba_fees_formatted</td>
						</tr>
						<tr>
							<td align="right" colspan="9"><h4>Total Adjusted Selling Price</h4></td>
							<td align="center"><h4>$total_unit_value_formatted</h4></td>
						</tr>
					</tbody>
				</table>
				EOD;
			}
		}

		$pdf->writeHTML($tbl, true, false, false, false, '');

		$shipping_invoice_pdf_dir = getcwd() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'shipping_invoice_pdf' . DIRECTORY_SEPARATOR . $user_id . DIRECTORY_SEPARATOR . $shipping_invoice_id;

		// if (file_exists($shipping_invoice_pdf_dir)) {
		// 	$pdf->Output($shipping_invoice_pdf_dir . DIRECTORY_SEPARATOR . 'Shipping Invoice Only Preview' .  '.pdf', 'F');
		// } else {
		// 	mkdir($shipping_invoice_pdf_dir, 0777);
		// 	$pdf->Output($shipping_invoice_pdf_dir . DIRECTORY_SEPARATOR . 'Shipping Invoice Only Preview' . '.pdf', 'F');
		// }

		$q_shipping_invoice = $this->Japan_ior_model->fetch_shipping_invoice_by_id($shipping_invoice_id);
		$shipping_invoice_data = $q_shipping_invoice->row();

		

		$pdf_watermark = new Fpdi();
		$pdf_watermark->setSourceFile('./uploads/shipping_invoice_pdf/' . $user_id . '/' . $shipping_invoice_id . '/' . 'Shipping Invoice Preview.pdf');
		// $pdf_pagecount = (new TCPDI())->setSourceData((string)file_get_contents('./uploads/shipping_invoice_pdf/' . $user_id . '/' . $shipping_invoice_id . '/' . 'Shipping Invoice Preview.pdf'));

		// for ($i = 1; $i <= $pdf_pagecount; $i++) {
		// 	if ($i != 1) {
		// 		$tplId = $pdf_watermark->importPage($i);
		// 		$size = $pdf_watermark->getTemplateSize($tplId);
		// 		$pdf_watermark->AddPage(($size['height'] > $size['width']) ? 'P' : 'L', array($size['width'], $size['height']));
		// 		$pdf_watermark->useTemplate($tplId);

		// 		$imgWidth = 150;
		// 		$imgHeight = 210;

		// 		$x = ($size['width'] - $imgWidth) / 2;
		// 		$y = ($size['height'] - $imgHeight) / 2;

		// 		// if ($status == 0) {
		// 		// 	$pdf_watermark->Image('assets/img/not_approved.png', $x, $y, $imgWidth, $imgHeight);
		// 		// } else {
		// 		// 	$pdf_watermark->Image('assets/img/approved.png', $x, $y, $imgWidth, $imgHeight);
		// 		// }
		// 	} else {
		// 		$pdf_watermark->AddPage('L');
		// 		$tplId = $pdf_watermark->importPage($i);
		// 		$pdf_watermark->useTemplate($tplId);

		// 		// if ($status == 0) {
		// 		// 	$pdf_watermark->Image('assets/img/not_approved.png', 70, 0, 150, 210);
		// 		// } else {
		// 		// 	$pdf_watermark->Image('assets/img/approved.png', 70, 0, 150, 210);
		// 		// }
		// 	}
		// }

		
		$pdf->Output($shipping_invoice_pdf_dir . DIRECTORY_SEPARATOR . $invoice_no . ' Shipping Invoice Zoho' .  '.pdf', 'F');
		
		
	}

	public function cancel_shipping_invoice()
	{
		// if (!$this->logged_in_external()) {
		// 	$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
		// 	redirect('/home/login');
		// } else {
		// 	$user_id = $this->session->userdata('user_id');

		// 	$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
		// 	$data['user_details'] = $q_user_details->row();

		// 	if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
		// 		redirect('/japan-ior/product-services-fee');
		// 	}
		// }

		$shipping_invoice_id = $this->input->post('id');

		$updated_at = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('user_id');

		$result = $this->Japan_ior_model->cancel_shipping_invoice($shipping_invoice_id, $updated_at, $updated_by);

		if ($result == 1) {
			echo $result;
		}
	}

	public function remove_file_upload()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$file_id = $this->input->post('id');
		$result = $this->Japan_ior_model->remove_file_upload($file_id);

		if ($result == 1) {
			echo $result;
		}
	}


	public function get_shipping_discount($user_id, $category)
	{

		$year = date('Y');

		$q_fetch_total_value_by_user = $this->Japan_ior_model->fetch_total_value_by_user($user_id, $category, $year);
		$total_value_by_user = $q_fetch_total_value_by_user->result();
		$totalval = 0;

		foreach ($total_value_by_user as $total_value) {
			$totalval += $total_value->total_value_of_shipment;
		}

		$q_check_shipping_discount = $this->Japan_ior_model->check_shipping_invoice_discount($user_id,  $category, $year);
		$check_discount = $q_check_shipping_discount->num_rows();
		$get_discount_year = $q_check_shipping_discount->row();

		if (isset($get_discount_year->s_year) && isset($get_discount_year->e_year)) {
			$s_year = $get_discount_year->s_year;
			$e_year = $get_discount_year->e_year;
		} else {
			$s_year = "";
			$e_year = "";
		}

		if ($check_discount == 0) {
			if ($totalval >= '100000001') {
				$this->Japan_ior_model->insert_shipping_invoice_discount($user_id, $category, $year, $totalval);
				$discount = 1;
			} else {
				if ($s_year == $year || $e_year == $year) {
					$discount = 1;
				} else {
					$discount = 0;
				}
			}
		} else {
			if (($get_discount_year->user_id == $user_id) && ($s_year == $year || $e_year == $year)) {
				$discount = 1;
			} else {
				$discount = 0;
			}
		}

		return $discount;
	}

	public function shipping_invoice_fee()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$shipping_invoice_id = $this->uri->segment(3);

		$data['external_page'] = 2;
		$data['active_page'] = 'shipping_invoices';
		$data['page_view'] = 'japan_ior/shipping_invoices/shipping_invoice_fee';

		$q_system_settings = $this->Japan_ior_model->fetch_system_settings();
		$data['system_settings'] = $q_system_settings->row();

		$q_fetch_shipping_invoice_by_id = $this->Japan_ior_model->fetch_shipping_invoice_by_id($shipping_invoice_id);
		$shipping_invoice_details = $q_fetch_shipping_invoice_by_id->row();

		$q_fetch_shipping_invoice_products_by_id = $this->Japan_ior_model->fetch_shipping_invoice_products_by_id($shipping_invoice_id);
		$shipping_invoice_products_by_id = $q_fetch_shipping_invoice_products_by_id->result();

		$data['shipping_invoice_products_by_id'] = $shipping_invoice_products_by_id;

		$q_fetch_pricing_fee = $this->Japan_ior_model->fetch_pricing_fee($shipping_invoice_details->category_type);
		$products_pricing = $q_fetch_pricing_fee->result();

		$discount = $this->get_shipping_discount($user_id, $shipping_invoice_details->category_type);

		$last_paypal_product_value = '';
		$percentage = 10;
		$mailing_product = '';
		$total_mailing_price = 0;
		foreach ($shipping_invoice_products_by_id as $key => $value) {
			if ($value->is_mailing_product == 1) {
				$mailing_price = $value->quantity * $value->mailing_product_price;
				$total_mailing_price = $total_mailing_price + $mailing_price;
				$mailing_product .= '<div class="row">
									<div class="col-md-8">
										<span>' . $value->product_name . '</span>
										<span>(' . $value->quantity . ' x ' . $value->mailing_product_price . ')</span>
									</div>
									<div class="col-md-4">
										<span style="float: right;">$' . number_format($mailing_price, 2) . '</span>
									</div>
									</div><br>';
			}
		}

		// ** NON - REGULATED CATEGORY **/
		if ($shipping_invoice_details->category_type == 1) {

			if ($shipping_invoice_details->total_value_of_shipment <= 10000000) {

				foreach ($products_pricing as $pricing_product) {

					if ($shipping_invoice_details->total_value_of_shipment <= $pricing_product->value && $shipping_invoice_details->total_value_of_shipment == '500000' && $pricing_product->id == 1) {

						if ($discount == 1) {

							$val_id   = 7;
							$pid      = 7;
							$discount_span = '<span style="float: right;">(0.0625% of the total value)</span>';
							$q_fetch_pricing_fee_v2 = $this->Japan_ior_model->fetch_pricing_fee_v2($shipping_invoice_details->category_type, $val_id);
							$products_pricing_v2 = $q_fetch_pricing_fee_v2->result();

							foreach ($products_pricing_v2 as $pricing_product2) {
								$ior_fee  =  $shipping_invoice_details->total_value_of_shipment  * $pricing_product2->ior_fees;
								$shipment_fee = $pricing_product2->ior_shipment_fees;
							}
						} else {
							$pid     = $pricing_product->id;
							$ior_fee =  $pricing_product->ior_fees;
							$shipment_fee = $pricing_product->ior_shipment_fees;
							$discount_span = '';
						}

						$percent =  ($percentage / 100) * ((float)$ior_fee + $total_mailing_price);
						$total   =  $ior_fee +  $percent + $total_mailing_price;

						$data['ior_fees'] = '<form action="" method="POST" id="frmShippingFee" role="form">
												<div id="ior-fees">
												<div class="row">
												<div class="col-md-6">
													<p>' . $shipment_fee . '</p>
												</div>
												<div class="col-md-6">
												<span style="float: right;">$' . $ior_fee . '</span>
												<br>
												' . $discount_span . '
												</div>
												</div>
												' . $mailing_product . '
												<div class="row">
												<div class="col-md-8">
													<p>Japan Consumer Tax (10%)</p>
												</div>
												<div class="col-md-4">
													<span style="float: right;">$' . number_format($percent, 2) . '</span>
												</div>
												</div>

												<hr>

												<div class="row">
												<div class="col-md-6">
													<h2 style="font-weight: bolder;">Total</h2>
												</div>
												<div class="col-md-6">
													<h2 style="float: right; font-weight: bolder;">$' .  number_format($total, 2)  . '</h2>
												</div>
												</div>

											</div>
											
											

											<br>

											<div class="row">
											<div class="col-md-12">
											<center>
											    <input type="hidden" id="ior_shipment_fees" name="ior_shipment_fees" value="' . $shipment_fee . '">
												<input type="hidden" id="ior_fee" name="ior_fee" value="' . $ior_fee . '">
												<input type="hidden" id="total" name="total" value="' . $total . '">
												<input type="hidden" id="id" name="fee_id" value="' . $pid . '">
												<input type="hidden" id="jct" name="jct" value="' . $percent  . '">
												<input type="hidden" id="id" name="shipping_id" value="' . $this->uri->segment(3)  . '">
												<a href="#" id="btn_product_services" data-toggle="modal" data-target="#modal_billing_checkout_shipping" class="btn btn-dark-blue btn-lg"><i class="fa fa-shopping-cart mr-2"></i>Checkout</a>
											</center>
											</div>
											</div>
											</form>';
					} else {
						if ($shipping_invoice_details->total_value_of_shipment > $last_paypal_product_value && $shipping_invoice_details->total_value_of_shipment <= $pricing_product->value) {
							if ($discount == 1) {

								$val_id   = 7;
								$pid      = 7;
								$discount_span = '<span style="float: right;">(0.0625% of the total value)</span>';
								$q_fetch_pricing_fee_v2 = $this->Japan_ior_model->fetch_pricing_fee_v2($shipping_invoice_details->category_type, $val_id);
								$products_pricing_v2 = $q_fetch_pricing_fee_v2->result();

								foreach ($products_pricing_v2 as $pricing_product2) {
									$ior_fee  =  $shipping_invoice_details->total_value_of_shipment  * $pricing_product2->ior_fees;
									$shipment_fee = $pricing_product2->ior_shipment_fees;
								}
							} else {
								$pid     = $pricing_product->id;
								$ior_fee =  $pricing_product->ior_fees;
								$shipment_fee = $pricing_product->ior_shipment_fees;
								$discount_span = '';
							}

							$percent =  ($percentage / 100) * ((float)$ior_fee + $total_mailing_price);
							$total   =  $ior_fee +  $percent + $total_mailing_price;

							$data['ior_fees'] = '<form action="" method="POST" id="frmShippingFee" role="form">
												<div id="ior-fees">
												<div class="row">
												<div class="col-md-6">
													<p>' . $shipment_fee . '</p>
												</div>
												<div class="col-md-6">
													<span style="float: right;">$' . $ior_fee . '</span>
													<br>
													' . $discount_span . '
												</div>
												</div>
												' . $mailing_product . '
												<div class="row">
												<div class="col-md-8">
													<p>Japan Consumer Tax (10%)</p>
												</div>
												<div class="col-md-4">
													<span style="float: right;">$' . number_format($percent, 2) . '</span>
												</div>
												</div>

												<hr>

												<div class="row">
												<div class="col-md-6">
													<h2 style="font-weight: bolder;">Total</h2>
												</div>
												<div class="col-md-6">
													<h2 style="float: right; font-weight: bolder;">$' .  number_format($total, 2)  . '</h2>
												</div>
												</div>

											</div>
												

											<br>

											<div class="row">
											<div class="col-md-12">
												<center>
											        <input type="hidden" id="ior_shipment_fees" name="ior_shipment_fees" value="' . $shipment_fee . '">
													<input type="hidden" id="ior_fee" name="ior_fee" value="' . $ior_fee . '">
													<input type="hidden" id="total" name="total" value="' . $total . '">
													<input type="hidden" id="id" name="fee_id" value="' . $pid . '">
													<input type="hidden" id="jct" name="jct" value="' . $percent  . '">
													<input type="hidden" id="shipping_id" name="shipping_id" value="' . $this->uri->segment(3)  . '">
													<a href="#" id="btn_product_services" data-toggle="modal" data-target="#modal_billing_checkout_shipping" class="btn btn-dark-blue btn-lg"><i class="fa fa-shopping-cart mr-2"></i>Checkout</a>
												</center>
											</div>
											</div>
											</form>';
						}

						$last_paypal_product_value = $pricing_product->value;
					}
				}
			} else {
				foreach ($products_pricing as $pricing_product) {
					if ($pricing_product->id == 6) {
						if ($discount == 1) {

							$val_id   = 7;
							$pid      = 7;
							$discount_span = '<span style="float: right;">(0.0625% of the total value)</span>';
							$q_fetch_pricing_fee_v2 = $this->Japan_ior_model->fetch_pricing_fee_v2($shipping_invoice_details->category_type, $val_id);
							$products_pricing_v2 = $q_fetch_pricing_fee_v2->result();

							foreach ($products_pricing_v2 as $pricing_product2) {
								$ior_fee  =  $pricing_product2->ior_fees;
								$shipment_fee = $pricing_product2->ior_shipment_fees;
							}
						} else {
							$pid     = $pricing_product->id;
							$ior_fee =  $pricing_product->ior_fees;
							$shipment_fee = $pricing_product->ior_shipment_fees;
							$discount_span = '<span style="float: right;">(0.125% of the total value)</span>';
						}

						$ship_fee =  $shipping_invoice_details->total_value_of_shipment * $ior_fee;
						$totalusd =  $ship_fee;
						$japan_consumer_tax = ($percentage / 100) * (float) $totalusd;
						$total   =  $totalusd +  $japan_consumer_tax;

						$data['ior_fees'] = '<form action="" method="POST" id="frmShippingFee" role="form">
												<div id="ior-fees">
															<div class="row">
															<div class="col-md-6">
															<p>' . $shipment_fee . '</p>
															</div>
															<div class="col-md-6">
																<span style="float: right;">$' . number_format($totalusd, 2) . ' </span>
																<br>
																' . $discount_span . '
																
															</div>
															</div>
															' . $mailing_product . '
															<div class="row">
															<div class="col-md-8">
																<p>Japan Consumer Tax (10%)</p>
															</div>
															<div class="col-md-4">
																<span style="float: right;">$' . number_format($japan_consumer_tax, 2) . '</span>
															</div>
															</div>
	
															<hr>
	
															<div class="row">
															<div class="col-md-6">
																<h2 style="font-weight: bolder;">Total</h2>
															</div>
															<div class="col-md-6">
																<h2 style="float: right; font-weight: bolder;">$' . number_format($total, 2) . '</h2>
															</div>
															</div>
	
														</div>
	
														<br>
	
	
														<div class="row">
														<div class="col-md-12">
															<center>
																<input type="hidden" id="ior_shipment_fees" name="ior_shipment_fees" value="' . $shipment_fee . '">
																<input type="hidden" id="ior_fee" name="ior_fee" value="' . $totalusd . '">
																<input type="hidden" id="total" name="total" value="' . $total . '">
																<input type="hidden" id="id" name="fee_id" value="' . $pid  . '">
																<input type="hidden" id="jct" name="jct" value="' . $japan_consumer_tax  . '">
																<input type="hidden" id="shipping_id" name="shipping_id" value="' . $this->uri->segment(3)  . '">
																<a href="#" id="btn_product_services" data-toggle="modal" data-target="#modal_billing_checkout_shipping" class="btn btn-dark-blue btn-lg"><i class="fa fa-shopping-cart mr-2"></i>Checkout</a>
															</center>
														</div>
														</div>
														</form>';
					}
				}
			}
		}

		// ** Electronics - Japan Radio **/
		else if ($shipping_invoice_details->category_type == 8) {

			if ($shipping_invoice_details->total_value_of_shipment <= 10000000) {

				foreach ($products_pricing as $pricing_product) {

					if ($shipping_invoice_details->total_value_of_shipment <= $pricing_product->value && $shipping_invoice_details->total_value_of_shipment == '50000' && $pricing_product->id == 43) {

						if ($discount == 1) {
							$val_id   = 26;
							$pid      = 26;
							$discount_span = '<span style="float: right;">(0.0625% of the total value)</span>';
							$q_fetch_pricing_fee_v2 = $this->Japan_ior_model->fetch_pricing_fee_v2($shipping_invoice_details->category_type, $val_id);
							$products_pricing_v2 = $q_fetch_pricing_fee_v2->result();

							foreach ($products_pricing_v2 as $pricing_product2) {
								$ior_fee  =  $shipping_invoice_details->total_value_of_shipment  * $pricing_product2->ior_fees;
								$shipment_fee = $pricing_product2->ior_shipment_fees;
							}
						} else {
							$pid     = $pricing_product->id;
							$ior_fee =  $pricing_product->ior_fees;
							$shipment_fee = $pricing_product->ior_shipment_fees;
							$discount_span = '';
						}


						$percent =  ($percentage / 100) * ((float)$ior_fee + $total_mailing_price);
						$total   =  $ior_fee +  $percent + $total_mailing_price;
						$data['ior_fees'] = '<form action="" method="POST" id="frmShippingFee" role="form">
												<div id="ior-fees">
												<div class="row">
												<div class="col-md-6">
													<p>' . $shipment_fee . '</p>
												</div>
												<div class="col-md-6">
												<span style="float: right;">$' . $ior_fee . '</span>
												<br>
												' . $discount_span . '
												</div>
												</div>
												' . $mailing_product . '
												<div class="row">
												<div class="col-md-8">
													<p>Japan Consumer Tax (10%)</p>
												</div>
												<div class="col-md-4">
													<span style="float: right;">$' . number_format($percent, 2) . '</span>
												</div>
												</div>

												<hr>

												<div class="row">
												<div class="col-md-6">
													<h2 style="font-weight: bolder;">Total</h2>
												</div>
												<div class="col-md-6">
													<h2 style="float: right; font-weight: bolder;">$' .  number_format($total, 2)  . '</h2>
												</div>
												</div>

											</div>
											
											

											<br>

											<div class="row">
											<div class="col-md-12">
											<center>
										    	<input type="hidden" id="ior_shipment_fees" name="ior_shipment_fees" value="' . $shipment_fee . '">
												<input type="hidden" id="ior_fee" name="ior_fee" value="' . $ior_fee . '">
												<input type="hidden" id="total" name="total" value="' . $total . '">
												<input type="hidden" id="id" name="fee_id" value="' . $pid  . '">
												<input type="hidden" id="jct" name="jct" value="' . $percent  . '">
												<input type="hidden" id="id" name="shipping_id" value="' . $this->uri->segment(3)  . '">
												<a href="#" id="btn_product_services" data-toggle="modal" data-target="#modal_billing_checkout_shipping" class="btn btn-dark-blue btn-lg"><i class="fa fa-shopping-cart mr-2"></i>Checkout</a>
											</center>
											</div>
											</div>
											</form>';
					} else {
						if ($shipping_invoice_details->total_value_of_shipment > $last_paypal_product_value && $shipping_invoice_details->total_value_of_shipment <= $pricing_product->value) {
							if ($discount == 1) {
								$val_id   = 26;
								$pid      = 26;
								$discount_span = '<span style="float: right;">(0.0625% of the total value)</span>';
								$q_fetch_pricing_fee_v2 = $this->Japan_ior_model->fetch_pricing_fee_v2($shipping_invoice_details->category_type, $val_id);
								$products_pricing_v2 = $q_fetch_pricing_fee_v2->result();

								foreach ($products_pricing_v2 as $pricing_product2) {
									$ior_fee  =  $shipping_invoice_details->total_value_of_shipment  * $pricing_product2->ior_fees;
									$shipment_fee = $pricing_product2->ior_shipment_fees;
								}
							} else {
								$pid     = $pricing_product->id;
								$ior_fee =  $pricing_product->ior_fees;
								$shipment_fee = $pricing_product->ior_shipment_fees;
								$discount_span = '';
							}
							$percent =  ($percentage / 100) * ((float)$ior_fee + $total_mailing_price);
							$total   =  $ior_fee +  $percent + $total_mailing_price;
							$data['ior_fees'] = '<form action="" method="POST" id="frmShippingFee" role="form">
												<div id="ior-fees">
												<div class="row">
												<div class="col-md-6">
													<p>' . $shipment_fee . '</p>
												</div>
												<div class="col-md-6">
													<span style="float: right;">$' . $ior_fee . '</span>
													<br>
													' . $discount_span . '
												</div>
												</div>
												' . $mailing_product . '
												<div class="row">
												<div class="col-md-8">
													<p>Japan Consumer Tax (10%)</p>
												</div>
												<div class="col-md-4">
													<span style="float: right;">$' . number_format($percent, 2) . '</span>
												</div>
												</div>

												<hr>

												<div class="row">
												<div class="col-md-6">
													<h2 style="font-weight: bolder;">Total</h2>
												</div>
												<div class="col-md-6">
													<h2 style="float: right; font-weight: bolder;">$' .  number_format($total, 2)  . '</h2>
												</div>
												</div>

											</div>
												

											<br>

											<div class="row">
											<div class="col-md-12">
												<center>
													<input type="hidden" id="ior_shipment_fees" name="ior_shipment_fees" value="' . $shipment_fee . '">
													<input type="hidden" id="ior_fee" name="ior_fee" value="' . $ior_fee . '">
													<input type="hidden" id="total" name="total" value="' . $total . '">
													<input type="hidden" id="id" name="fee_id" value="' . $pid  . '">
													<input type="hidden" id="jct" name="jct" value="' . $percent  . '">
													<input type="hidden" id="shipping_id" name="shipping_id" value="' . $this->uri->segment(3)  . '">
													<a href="#" id="btn_product_services" data-toggle="modal" data-target="#modal_billing_checkout_shipping" class="btn btn-dark-blue btn-lg"><i class="fa fa-shopping-cart mr-2"></i>Checkout</a>
												</center>
											</div>
											</div>
											</form>';
						}

						$last_paypal_product_value = $pricing_product->value;
					}
				}
			} else {
				foreach ($products_pricing as $pricing_product) {
					if ($pricing_product->id == 25) {
						if ($discount == 1) {
							$val_id   = 26;
							$pid      = 26;
							$discount_span = '<span style="float: right;">(0.0625% of the total value)</span>';
							$q_fetch_pricing_fee_v2 = $this->Japan_ior_model->fetch_pricing_fee_v2($shipping_invoice_details->category_type, $val_id);
							$products_pricing_v2 = $q_fetch_pricing_fee_v2->result();

							foreach ($products_pricing_v2 as $pricing_product2) {
								$ior_fee  =  $pricing_product2->ior_fees;
								$shipment_fee = $pricing_product2->ior_shipment_fees;
							}
						} else {
							$pid     = $pricing_product->id;
							$ior_fee =  $pricing_product->ior_fees;
							$shipment_fee = $pricing_product->ior_shipment_fees;
							$discount_span = '<span style="float: right;">(0.125% of the total value)</span>';
						}

						$ship_fee =  $shipping_invoice_details->total_value_of_shipment * $ior_fee;
						$totalusd =  $ship_fee;
						$japan_consumer_tax = ($percentage / 100) * (float) $totalusd;
						$total   =  $totalusd +  $japan_consumer_tax;
						$data['ior_fees'] = '<form action="" method="POST" id="frmShippingFee" role="form">
												<div id="ior-fees">
															<div class="row">
															<div class="col-md-6">
															<p>' . $shipment_fee . '</p>
															</div>
															<div class="col-md-6">
																<span style="float: right;">$' . number_format($totalusd, 2) . ' </span>
																<br>
																' . $discount_span . '
															</div>
															</div>
															' . $mailing_product . '
															<div class="row">
															<div class="col-md-8">
																<p>Japan Consumer Tax (10%)</p>
															</div>
															<div class="col-md-4">
																<span style="float: right;">$' . number_format($japan_consumer_tax, 2) . '</span>
															</div>
															</div>
	
															<hr>
	
															<div class="row">
															<div class="col-md-6">
																<h2 style="font-weight: bolder;">Total</h2>
															</div>
															<div class="col-md-6">
																<h2 style="float: right; font-weight: bolder;">$' . number_format($total, 2) . '</h2>
															</div>
															</div>
	
														</div>
	
														<br>
	
	
														<div class="row">
														<div class="col-md-12">
															<center>
																<input type="hidden" id="ior_shipment_fees" name="ior_shipment_fees" value="' . $shipment_fee . '">
																<input type="hidden" id="ior_fee" name="ior_fee" value="' . $totalusd . '">
																<input type="hidden" id="total" name="total" value="' . $total . '">
																<input type="hidden" id="id" name="fee_id" value="' . $pid  . '">
																<input type="hidden" id="jct" name="jct" value="' . $japan_consumer_tax  . '">
																<input type="hidden" id="shipping_id" name="shipping_id" value="' . $this->uri->segment(3)  . '">
																<a href="#" id="btn_product_services" data-toggle="modal" data-target="#modal_billing_checkout_shipping" class="btn btn-dark-blue btn-lg"><i class="fa fa-shopping-cart mr-2"></i>Checkout</a>
															</center>
														</div>
														</div>
														</form>';
					}
				}
			}
		}

		// ** Non-Regulated - Baby Products **/
		else if ($shipping_invoice_details->category_type == 11) {
			if ($shipping_invoice_details->total_value_of_shipment <= 10000000) {

				foreach ($products_pricing as $pricing_product) {
					if ($shipping_invoice_details->total_value_of_shipment <= $pricing_product->value && $shipping_invoice_details->total_value_of_shipment == '50000' && $pricing_product->id == 36) {
						if ($discount == 1) {
							$val_id   = 42;
							$pid      = 42;
							$discount_span = '<span style="float: right;">(0.0625% of the total value)</span>';
							$q_fetch_pricing_fee_v2 = $this->Japan_ior_model->fetch_pricing_fee_v2($shipping_invoice_details->category_type, $val_id);
							$products_pricing_v2 = $q_fetch_pricing_fee_v2->result();

							foreach ($products_pricing_v2 as $pricing_product2) {
								$ior_fee  =  $shipping_invoice_details->total_value_of_shipment  * $pricing_product2->ior_fees;
								$shipment_fee = $pricing_product2->ior_shipment_fees;
							}
						} else {
							$pid     = $pricing_product->id;
							$ior_fee =  $pricing_product->ior_fees;
							$shipment_fee = $pricing_product->ior_shipment_fees;
							$discount_span = '';
						}
						$percent =  ($percentage / 100) * ((float)$ior_fee + $total_mailing_price);
						$total   =  $ior_fee +  $percent + $total_mailing_price;
						$data['ior_fees'] = '<form action="" method="POST" id="frmShippingFee" role="form">
												<div id="ior-fees">
												<div class="row">
												<div class="col-md-6">
													<p>' . $shipment_fee . '</p>
												</div>
												<div class="col-md-6">
												<span style="float: right;">$' . $ior_fee . '</span>
												<br>
													' . $discount_span . '
												</div>
												</div>
												' . $mailing_product . '
												<div class="row">
												<div class="col-md-8">
													<p>Japan Consumer Tax (10%)</p>
												</div>
												<div class="col-md-4">
													<span style="float: right;">$' . number_format($percent, 2) . '</span>
												</div>
												</div>

												<hr>

												<div class="row">
												<div class="col-md-6">
													<h2 style="font-weight: bolder;">Total</h2>
												</div>
												<div class="col-md-6">
													<h2 style="float: right; font-weight: bolder;">$' .  number_format($total, 2)  . '</h2>
												</div>
												</div>

											</div>
											
											

											<br>

											<div class="row">
											<div class="col-md-12">
											<center>
												<input type="hidden" id="ior_shipment_fees" name="ior_shipment_fees" value="' . $shipment_fee . '">
												<input type="hidden" id="ior_fee" name="ior_fee" value="' . $ior_fee . '">
												<input type="hidden" id="total" name="total" value="' . $total . '">
												<input type="hidden" id="id" name="fee_id" value="' . $pid  . '">
												<input type="hidden" id="jct" name="jct" value="' . $percent  . '">
												<input type="hidden" id="id" name="shipping_id" value="' . $this->uri->segment(3)  . '">
												<a href="#" id="btn_product_services" data-toggle="modal" data-target="#modal_billing_checkout_shipping" class="btn btn-dark-blue btn-lg"><i class="fa fa-shopping-cart mr-2"></i>Checkout</a>
											</center>
											</div>
											</div>
											</form>';
					} else {
						if ($shipping_invoice_details->total_value_of_shipment > $last_paypal_product_value && $shipping_invoice_details->total_value_of_shipment <= $pricing_product->value) {
							if ($discount == 1) {
								$val_id   = 42;
								$pid      = 42;
								$discount_span = '<span style="float: right;">(0.0625% of the total value)</span>';
								$q_fetch_pricing_fee_v2 = $this->Japan_ior_model->fetch_pricing_fee_v2($shipping_invoice_details->category_type, $val_id);
								$products_pricing_v2 = $q_fetch_pricing_fee_v2->result();

								foreach ($products_pricing_v2 as $pricing_product2) {
									$ior_fee  =  $shipping_invoice_details->total_value_of_shipment  * $pricing_product2->ior_fees;
									$shipment_fee = $pricing_product2->ior_shipment_fees;
								}
							} else {
								$pid     = $pricing_product->id;
								$ior_fee =  $pricing_product->ior_fees;
								$shipment_fee = $pricing_product->ior_shipment_fees;
								$discount_span = '';
							}
							$percent =  ($percentage / 100) * ((float)$ior_fee + $total_mailing_price);
							$total   =  $ior_fee +  $percent + $total_mailing_price;
							$data['ior_fees'] = '<form action="" method="POST" id="frmShippingFee" role="form">
												<div id="ior-fees">
												<div class="row">
												<div class="col-md-6">
													<p>' . $shipment_fee . '</p>
												</div>
												<div class="col-md-6">
													<span style="float: right;">$' . $ior_fee . '</span>
													<br>
													' . $discount_span . '
												</div>
												</div>
												' . $mailing_product . '
												<div class="row">
												<div class="col-md-8">
													<p>Japan Consumer Tax (10%)</p>
												</div>
												<div class="col-md-4">
													<span style="float: right;">$' . number_format($percent, 2) . '</span>
												</div>
												</div>

												<hr>

												<div class="row">
												<div class="col-md-6">
													<h2 style="font-weight: bolder;">Total</h2>
												</div>
												<div class="col-md-6">
													<h2 style="float: right; font-weight: bolder;">$' .  number_format($total, 2)  . '</h2>
												</div>
												</div>

											</div>
												

											<br>

											<div class="row">
											<div class="col-md-12">
												<center>
													<input type="hidden" id="ior_shipment_fees" name="ior_shipment_fees" value="' . $shipment_fee . '">
													<input type="hidden" id="ior_fee" name="ior_fee" value="' . $ior_fee . '">
													<input type="hidden" id="total" name="total" value="' . $total . '">
													<input type="hidden" id="id" name="fee_id" value="' . $pid  . '">
													<input type="hidden" id="jct" name="jct" value="' . $percent  . '">
													<input type="hidden" id="shipping_id" name="shipping_id" value="' . $this->uri->segment(3)  . '">
													<a href="#" id="btn_product_services" data-toggle="modal" data-target="#modal_billing_checkout_shipping" class="btn btn-dark-blue btn-lg"><i class="fa fa-shopping-cart mr-2"></i>Checkout</a>
												</center>
											</div>
											</div>
											</form>';
						}

						$last_paypal_product_value = $pricing_product->value;
					}
				}
			} else {
				foreach ($products_pricing as $pricing_product) {
					if ($pricing_product->id == 41) {
						if ($discount == 1) {
							$val_id   = 42;
							$pid      = 42;
							$discount_span = '<span style="float: right;">(0.0625% of the total value)</span>';
							$q_fetch_pricing_fee_v2 = $this->Japan_ior_model->fetch_pricing_fee_v2($shipping_invoice_details->category_type, $val_id);
							$products_pricing_v2 = $q_fetch_pricing_fee_v2->result();

							foreach ($products_pricing_v2 as $pricing_product2) {
								$ior_fee  =  $pricing_product2->ior_fees;
								$shipment_fee = $pricing_product2->ior_shipment_fees;
							}
						} else {
							$pid     = $pricing_product->id;
							$ior_fee =  $pricing_product->ior_fees;
							$shipment_fee = $pricing_product->ior_shipment_fees;
							$discount_span = '<span style="float: right;">(0.125% of the total value)</span>';
						}

						$ship_fee =  $shipping_invoice_details->total_value_of_shipment * $ior_fee;
						$totalusd =  $ship_fee;
						$japan_consumer_tax = ($percentage / 100) * (float) $totalusd;
						$total   =  $totalusd +  $japan_consumer_tax;
						$data['ior_fees'] = '<form action="" method="POST" id="frmShippingFee" role="form">
												<div id="ior-fees">
															<div class="row">
															<div class="col-md-6">
															<p>' . $shipment_fee . '</p>
															</div>
															<div class="col-md-6">
																<span style="float: right;">$' . number_format($totalusd, 2) . ' </span>
																<br>
																' . $discount_span . '
															</div>
															</div>
															' . $mailing_product . '
															<div class="row">
															<div class="col-md-8">
																<p>Japan Consumer Tax (10%)</p>
															</div>
															<div class="col-md-4">
																<span style="float: right;">$' . number_format($japan_consumer_tax, 2) . '</span>
															</div>
															</div>
	
															<hr>
	
															<div class="row">
															<div class="col-md-6">
																<h2 style="font-weight: bolder;">Total</h2>
															</div>
															<div class="col-md-6">
																<h2 style="float: right; font-weight: bolder;">$' . number_format($total, 2) . '</h2>
															</div>
															</div>
	
														</div>
	
														<br>
	
	
														<div class="row">
														<div class="col-md-12">
															<center>
																<input type="hidden" id="ior_shipment_fees" name="ior_shipment_fees" value="' . $shipment_fee . '">
																<input type="hidden" id="ior_fee" name="ior_fee" value="' . $totalusd . '">
																<input type="hidden" id="total" name="total" value="' . $total . '">
																<input type="hidden" id="id" name="fee_id" value="' . $pid  . '">
																<input type="hidden" id="jct" name="jct" value="' . $japan_consumer_tax  . '">
																<input type="hidden" id="shipping_id" name="shipping_id" value="' . $this->uri->segment(3)  . '">
																<a href="#" id="btn_product_services" data-toggle="modal" data-target="#modal_billing_checkout_shipping" class="btn btn-dark-blue btn-lg"><i class="fa fa-shopping-cart mr-2"></i>Checkout</a>
															</center>
														</div>
														</div>
														</form>';
					}
				}
			}
		}

		// ** SUPPLEMENTAL PSE **/
		else if ($shipping_invoice_details->category_type == 9) {

			if ($shipping_invoice_details->total_value_of_shipment <= 10000000) {

				foreach ($products_pricing as $pricing_product) {

					if ($shipping_invoice_details->total_value_of_shipment <= $pricing_product->value && $shipping_invoice_details->total_value_of_shipment == '500000' && $pricing_product->id == 27) {

						if ($discount == 1) {

							$val_id   = 33;
							$pid      = 33;
							$discount_span = '<span style="float: right;">(0.0625% of the total value)</span>';
							$q_fetch_pricing_fee_v2 = $this->Japan_ior_model->fetch_pricing_fee_v2($shipping_invoice_details->category_type, $val_id);
							$products_pricing_v2 = $q_fetch_pricing_fee_v2->result();

							foreach ($products_pricing_v2 as $pricing_product2) {
								$ior_fee  =  $shipping_invoice_details->total_value_of_shipment  * $pricing_product2->ior_fees;
								$shipment_fee = $pricing_product2->ior_shipment_fees;
							}
						} else {
							$pid     = $pricing_product->id;
							$ior_fee =  $pricing_product->ior_fees;
							$shipment_fee = $pricing_product->ior_shipment_fees;
							$discount_span = '';
						}

						$percent =  ($percentage / 100) * ((float)$ior_fee + $total_mailing_price);
						$total   =  $ior_fee +  $percent + $total_mailing_price;

						$data['ior_fees'] = '<form action="" method="POST" id="frmShippingFee" role="form">
													<div id="ior-fees">
													<div class="row">
													<div class="col-md-6">
														<p>' . $shipment_fee . '</p>
													</div>
													<div class="col-md-6">
													<span style="float: right;">$' . $ior_fee . '</span>
													<br>
													' . $discount_span . '
													</div>
													</div>
													' . $mailing_product . '
													<div class="row">
													<div class="col-md-8">
														<p>Japan Consumer Tax (10%)</p>
													</div>
													<div class="col-md-4">
														<span style="float: right;">$' . number_format($percent, 2) . '</span>
													</div>
													</div>
	
													<hr>
	
													<div class="row">
													<div class="col-md-6">
														<h2 style="font-weight: bolder;">Total</h2>
													</div>
													<div class="col-md-6">
														<h2 style="float: right; font-weight: bolder;">$' .  number_format($total, 2)  . '</h2>
													</div>
													</div>
	
												</div>
												
												
	
												<br>
	
												<div class="row">
												<div class="col-md-12">
												<center>
													<input type="hidden" id="ior_shipment_fees" name="ior_shipment_fees" value="' . $shipment_fee . '">
													<input type="hidden" id="ior_fee" name="ior_fee" value="' . $ior_fee . '">
													<input type="hidden" id="total" name="total" value="' . $total . '">
													<input type="hidden" id="id" name="fee_id" value="' . $pid . '">
													<input type="hidden" id="jct" name="jct" value="' . $percent  . '">
													<input type="hidden" id="id" name="shipping_id" value="' . $this->uri->segment(3)  . '">
													<a href="#" id="btn_product_services" data-toggle="modal" data-target="#modal_billing_checkout_shipping" class="btn btn-dark-blue btn-lg"><i class="fa fa-shopping-cart mr-2"></i>Checkout</a>
												</center>
												</div>
												</div>
												</form>';
					} else {
						if ($shipping_invoice_details->total_value_of_shipment > $last_paypal_product_value && $shipping_invoice_details->total_value_of_shipment <= $pricing_product->value) {
							if ($discount == 1) {

								$val_id   = 33;
								$pid      = 33;
								$discount_span = '<span style="float: right;">(0.0625% of the total value)</span>';
								$q_fetch_pricing_fee_v2 = $this->Japan_ior_model->fetch_pricing_fee_v2($shipping_invoice_details->category_type, $val_id);
								$products_pricing_v2 = $q_fetch_pricing_fee_v2->result();

								foreach ($products_pricing_v2 as $pricing_product2) {
									$ior_fee  =  $shipping_invoice_details->total_value_of_shipment  * $pricing_product2->ior_fees;
									$shipment_fee = $pricing_product2->ior_shipment_fees;
								}
							} else {
								$pid     = $pricing_product->id;
								$ior_fee =  $pricing_product->ior_fees;
								$shipment_fee = $pricing_product->ior_shipment_fees;
								$discount_span = '';
							}

							$percent =  ($percentage / 100) * ((float)$ior_fee + $total_mailing_price);
							$total   =  $ior_fee +  $percent + $total_mailing_price;

							$data['ior_fees'] = '<form action="" method="POST" id="frmShippingFee" role="form">
													<div id="ior-fees">
													<div class="row">
													<div class="col-md-6">
														<p>' . $shipment_fee . '</p>
													</div>
													<div class="col-md-6">
														<span style="float: right;">$' . $ior_fee . '</span>
														<br>
														' . $discount_span . '
													</div>
													</div>
													' . $mailing_product . '
													<div class="row">
													<div class="col-md-8">
														<p>Japan Consumer Tax (10%)</p>
													</div>
													<div class="col-md-4">
														<span style="float: right;">$' . number_format($percent, 2) . '</span>
													</div>
													</div>
	
													<hr>
	
													<div class="row">
													<div class="col-md-6">
														<h2 style="font-weight: bolder;">Total</h2>
													</div>
													<div class="col-md-6">
														<h2 style="float: right; font-weight: bolder;">$' .  number_format($total, 2)  . '</h2>
													</div>
													</div>
	
												</div>
													
	
												<br>
	
												<div class="row">
												<div class="col-md-12">
													<center>
														<input type="hidden" id="ior_shipment_fees" name="ior_shipment_fees" value="' . $shipment_fee . '">
														<input type="hidden" id="ior_fee" name="ior_fee" value="' . $ior_fee . '">
														<input type="hidden" id="total" name="total" value="' . $total . '">
														<input type="hidden" id="id" name="fee_id" value="' . $pid . '">
														<input type="hidden" id="jct" name="jct" value="' . $percent  . '">
														<input type="hidden" id="shipping_id" name="shipping_id" value="' . $this->uri->segment(3)  . '">
														<a href="#" id="btn_product_services" data-toggle="modal" data-target="#modal_billing_checkout_shipping" class="btn btn-dark-blue btn-lg"><i class="fa fa-shopping-cart mr-2"></i>Checkout</a>
													</center>
												</div>
												</div>
												</form>';
						}

						$last_paypal_product_value = $pricing_product->value;
					}
				}
			} else {
				foreach ($products_pricing as $pricing_product) {
					if ($pricing_product->id == 32) {
						if ($discount == 1) {

							$val_id   = 33;
							$pid      = 33;
							$discount_span = '<span style="float: right;">(0.0625% of the total value)</span>';
							$q_fetch_pricing_fee_v2 = $this->Japan_ior_model->fetch_pricing_fee_v2($shipping_invoice_details->category_type, $val_id);
							$products_pricing_v2 = $q_fetch_pricing_fee_v2->result();

							foreach ($products_pricing_v2 as $pricing_product2) {
								$ior_fee  =  $pricing_product2->ior_fees;
								$shipment_fee = $pricing_product2->ior_shipment_fees;
							}
						} else {
							$pid     = $pricing_product->id;
							$ior_fee =  $pricing_product->ior_fees;
							$shipment_fee = $pricing_product->ior_shipment_fees;
							$discount_span = '<span style="float: right;">(0.125% of the total value)</span>';
						}

						$ship_fee =  $shipping_invoice_details->total_value_of_shipment * $ior_fee;
						$totalusd =  $ship_fee;
						$japan_consumer_tax = ($percentage / 100) * (float) $totalusd;
						$total   =  $totalusd +  $japan_consumer_tax;

						$data['ior_fees'] = '<form action="" method="POST" id="frmShippingFee" role="form">
													<div id="ior-fees">
																<div class="row">
																<div class="col-md-6">
																<p>' . $shipment_fee . '</p>
																</div>
																<div class="col-md-6">
																	<span style="float: right;">$' . number_format($totalusd, 2) . ' </span>
																	<br>
																	' . $discount_span . '
																	
																</div>
																</div>
																' . $mailing_product . '
																<div class="row">
																<div class="col-md-8">
																	<p>Japan Consumer Tax (10%)</p>
																</div>
																<div class="col-md-4">
																	<span style="float: right;">$' . number_format($japan_consumer_tax, 2) . '</span>
																</div>
																</div>
		
																<hr>
		
																<div class="row">
																<div class="col-md-6">
																	<h2 style="font-weight: bolder;">Total</h2>
																</div>
																<div class="col-md-6">
																	<h2 style="float: right; font-weight: bolder;">$' . number_format($total, 2) . '</h2>
																</div>
																</div>
		
															</div>
		
															<br>
		
		
															<div class="row">
															<div class="col-md-12">
																<center>
																	<input type="hidden" id="ior_shipment_fees" name="ior_shipment_fees" value="' . $shipment_fee . '">
																	<input type="hidden" id="ior_fee" name="ior_fee" value="' . $totalusd . '">
																	<input type="hidden" id="total" name="total" value="' . $total . '">
																	<input type="hidden" id="id" name="fee_id" value="' . $pid  . '">
																	<input type="hidden" id="jct" name="jct" value="' . $japan_consumer_tax  . '">
																	<input type="hidden" id="shipping_id" name="shipping_id" value="' . $this->uri->segment(3)  . '">
																	<a href="#" id="btn_product_services" data-toggle="modal" data-target="#modal_billing_checkout_shipping" class="btn btn-dark-blue btn-lg"><i class="fa fa-shopping-cart mr-2"></i>Checkout</a>
																</center>
															</div>
															</div>
															</form>';
					}
				}
			}
		}


		// ** REGULATED Application **//
		else {

			if ($shipping_invoice_details->total_value_of_shipment <= 100000000) {

				foreach ($products_pricing as $pricing_product) {

					if ($discount == 1) {

						$val_id   = $pricing_product->id + 1;
						$pid      = $pricing_product->id;

						$q_fetch_pricing_fee_v2 = $this->Japan_ior_model->fetch_pricing_fee_v2($shipping_invoice_details->category_type, $val_id);
						$products_pricing_v2 = $q_fetch_pricing_fee_v2->result();

						foreach ($products_pricing_v2 as $pricing_product2) {
							$ior_fee  =  $pricing_product2->ior_fees;
							$shipment_fee = $pricing_product2->ior_shipment_fees;
						}
					} else {
						if (
							$pricing_product->id == 8 || $pricing_product->id == 10 || $pricing_product->id == 12 || $pricing_product->id == 14 ||
							$pricing_product->id == 16 || $pricing_product->id == 18 || $pricing_product->id == 34 || $pricing_product->id == 43 ||
							$pricing_product->id == 45
						) {

							$pid      =  $pricing_product->id;
							$ior_fee  =  $pricing_product->ior_fees;
							$shipment_fee = $pricing_product->ior_shipment_fees;
						}
					}
					$value    =  $ior_fee * 10000;
					$ship_fee =  $shipping_invoice_details->total_value_of_shipment * $ior_fee;
					$totalusd =  $ship_fee;
					$percent  =  ($percentage / 100) * ((float)$totalusd + $total_mailing_price);
					$total    =  $totalusd +  $percent + $total_mailing_price;
					$japan_consumer_tax = ($percentage / 100) * (float) $totalusd;

					$data['ior_fees'] = '<form action="" method="POST" id="frmShippingFee" role="form">
												<div id="ior-fees">
												<div class="row">
												<div class="col-md-6">
													<p>' . $shipment_fee . '</p>
												</div>
												<div class="col-md-6">
												<span style="float: right;">$' . number_format($totalusd, 2) . '</span>
												<br>
												<span style="float: right;">(' . $value . '% of the total value)</span>
												</div>
												</div>
												' . $mailing_product . '
												<div class="row">
												<div class="col-md-8">
													<p>Japan Consumer Tax (10%)</p>
												</div>
												<div class="col-md-4">
													<span style="float: right;">$' . number_format($percent, 2) . '</span>
												</div>
												</div>
												<hr>
												<div class="row">
												<div class="col-md-6">
													<h2 style="font-weight: bolder;">Total</h2>
												</div>
												<div class="col-md-6">
													<h2 style="float: right; font-weight: bolder;">$' .  number_format($total, 2)  . '</h2>
												</div>
												</div>
											</div>
											<br>
											<div class="row">
											<div class="col-md-12">
											<center>
												<input type="hidden" id="ior_shipment_fees" name="ior_shipment_fees" value="' . $shipment_fee . '">
												<input type="hidden" id="ior_fee" name="ior_fee" value="' . $totalusd . '">
												<input type="hidden" id="total" name="total" value="' . $total . '">
												<input type="hidden" id="id" name="fee_id" value="' . $pid  . '">
												<input type="hidden" id="jct" name="jct" value="' . $percent  . '">
												<input type="hidden" id="id" name="shipping_id" value="' . $this->uri->segment(3)  . '">
												<a href="#" id="btn_product_services" data-toggle="modal" data-target="#modal_billing_checkout_shipping" class="btn btn-dark-blue btn-lg"><i class="fa fa-shopping-cart mr-2"></i>Checkout</a>
											</center>
											</div>
											</div>
											</form>';
				}
			} else {

				foreach ($products_pricing as $pricing_product) {
					if (
						$pricing_product->id == 9 || $pricing_product->id == 11 || $pricing_product->id == 13 || $pricing_product->id == 15 ||
						$pricing_product->id == 17 || $pricing_product->id == 19 || $pricing_product->id == 35 || $pricing_product->id == 44 ||
						$pricing_product->id == 46
					) {

						$pid      =  $pricing_product->id;
						$ior_fee  =  $pricing_product->ior_fees;
						$value    =  $ior_fee * 10000;
						$ship_fee =  $shipping_invoice_details->total_value_of_shipment * $ior_fee;
						$totalusd =  $ship_fee;
						$japan_consumer_tax = ($percentage / 100) * (float) $totalusd;
						$total    =  $totalusd +  $japan_consumer_tax;
						$data['ior_fees'] = '<form action="" method="POST" id="frmShippingFee" role="form">
												<div id="ior-fees">
															<div class="row">
															<div class="col-md-6">
															<p>' . $pricing_product->ior_shipment_fees . '</p>
															</div>
															<div class="col-md-6">
																<span style="float: right;">$' . number_format($totalusd, 2) . ' </span>
																<br>
																<span style="float: right;">(' . $value . '% of the total value)</span>
																</div>
															</div>
															' . $mailing_product . '
															<div class="row">
															<div class="col-md-8">
																<p>Japan Consumer Tax (10%)</p>
															</div>
															<div class="col-md-4">
																<span style="float: right;">$' . number_format($japan_consumer_tax, 2) . '</span>
															</div>
															</div>
	
															<hr>
	
															<div class="row">
															<div class="col-md-6">
																<h2 style="font-weight: bolder;">Total</h2>
															</div>
															<div class="col-md-6">
																<h2 style="float: right; font-weight: bolder;">$' . number_format($total, 2) . '</h2>
															</div>
															</div>
	
														</div>
	
														<br>
	
	
														<div class="row">
														<div class="col-md-12">
															<center>
																<input type="hidden" id="ior_shipment_fees" name="ior_shipment_fees" value="' . $pricing_product->ior_shipment_fees . '">
																<input type="hidden" id="ior_fee" name="ior_fee" value="' . $totalusd . '">
																<input type="hidden" id="total" name="total" value="' . $total . '">
																<input type="hidden" id="id" name="fee_id" value="' . $pid  . '">
																<input type="hidden" id="jct" name="jct" value="' . $japan_consumer_tax  . '">
																<input type="hidden" id="shipping_id" name="shipping_id" value="' . $this->uri->segment(3)  . '">
																<a href="#" id="btn_product_services" data-toggle="modal" data-target="#modal_billing_checkout_shipping" class="btn btn-dark-blue btn-lg"><i class="fa fa-shopping-cart mr-2"></i>Checkout</a>
															</center>
														</div>
														</div>
														</form>';
					}
				}
			}
		}

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$ior_shipment_fees = $this->input->post('ior_shipment_fees');
			$ior_fee = $this->input->post('ior_fee');
			$total = $this->input->post('total');
			$fee_id = $this->input->post('fee_id');
			$shipping_id = $this->input->post('shipping_id');
			$jct = $this->input->post('jct');
			$created_at = date('Y-m-d H:i:s');
			$billing_invoice_id = $this->Japan_ior_model->insert_user_payment_shipping_invoice($user_id, $shipping_id, $fee_id, $ior_fee, $total, $jct, $user_id, $created_at);
			$this->Japan_ior_model->update_shipping_invoice_billing_id($user_id, $shipping_id, $billing_invoice_id);
			redirect('/japan-ior/billing-invoice/' . $billing_invoice_id, 'refresh');
		} else {
			$this->load->view('page', $data);
		}
	}

	public function shipping_invoice_checkout()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$id = $this->uri->segment(3);

		$returnURL = base_url() . 'japan-ior/shipping-invoice-success';
		$cancelURL = base_url() . 'japan-ior/payment-cancelled';
		$notifyURL = base_url() . 'japan-ior/ipn';

		// Get System Settings data from the database
		$q_system_settings = $this->Japan_ior_model->fetch_system_settings();
		$system_settings = $q_system_settings->row();

		// Get product data from the database
		$q_product = $this->Japan_ior_model->getProductbyID($id);
		$product = $q_product->row_array();

		$userID = $this->uri->segment(4);

		\Stripe\Stripe::setApiKey($system_settings->stripe_secret_key);
		header('Content-Type: application/json');
		$checkout_session = \Stripe\Checkout\Session::create([
			'payment_method_types' => ['card'],
			'line_items' => [[
				'price_data' => [
					'currency' => 'usd',

					'unit_amount' => $product['price'] * 100,
					'product_data' => [
						'name' =>   $product['name'],
						'images' => ["https://www.covueior.com/assets/img/covue_main_logo.png"],
					],
				],
				'quantity' => 1,
			]],
			'mode' => 'payment',
			'success_url' => $returnURL,
			'cancel_url' => $cancelURL,
			'client_reference_id' => $userID . '|0' . '|'

		]);
		echo json_encode(['id' => $checkout_session->id]);
	}

	public function generate_shipping_invoice()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$shipping_invoice_id = $this->uri->segment(3);
		$fba = $this->uri->segment(4);
		$shipping_link = $this->uri->segment(5);

		$q_shipping_invoice = $this->Japan_ior_model->fetch_shipping_invoice_by_id($shipping_invoice_id);
		$shipping_invoice = $q_shipping_invoice->row();

		$q_shipping_company = $this->Japan_ior_model->fetch_shipping_companies_v($shipping_invoice->shipping_company);
		$shipping_companies = $q_shipping_company->row();

		$q_logistic_form= $this->Japan_ior_model->fetch_logistic_form($shipping_invoice_id);
		$logistic_form = $q_logistic_form->row();

		$product_sampling = $shipping_invoice->product_sampling;
		$s_company_name = $shipping_invoice->company_name;

		if (!empty($shipping_companies)) {
			$s_email = $shipping_companies->email;
		} else {
			$s_email = '';
		}

		$user_id = $shipping_invoice->user_id;

		if ($shipping_invoice->paid == 0) {
			$data['external_page'] = 2;
			$data['active_page'] = 'shipping_invoices';
			$data['page_view'] = 'japan_ior/shipping_invoices/shipping_invoice_unpaid';
			$this->load->view('page', $data);
		} else {
			$invoice_user_id = str_pad($user_id, 2, '0', STR_PAD_LEFT);

			if (empty($shipping_invoice->invoice_no_big) && empty($shipping_invoice->invoice_no_tiny)) {
				$q_fetch_latest_invoice_no_big = $this->Japan_ior_model->fetch_latest_invoice_no_big();
				$latest_invoice_no_big = $q_fetch_latest_invoice_no_big->row();

				if (empty($latest_invoice_no_big->invoice_no_big)) {
					$big_series_no = str_pad(1, 5, '0', STR_PAD_LEFT);
				} else {
					$big_series_no = $latest_invoice_no_big->invoice_no_big;
				}

				$q_fetch_latest_invoice_no_tiny = $this->Japan_ior_model->fetch_latest_invoice_no_tiny($big_series_no);
				$latest_invoice_no_tiny = $q_fetch_latest_invoice_no_tiny->row();

				if (empty($latest_invoice_no_tiny->invoice_no_tiny)) {
					$tiny_series_no = str_pad(1, 3, '0', STR_PAD_LEFT);

					$invoice_no = $invoice_user_id . '-' . $big_series_no . '-' .  $tiny_series_no;
					$this->Japan_ior_model->insert_invoice_no($shipping_invoice_id, $big_series_no, $tiny_series_no);
				} else {
					$tiny_series_no = $latest_invoice_no_tiny->invoice_no_tiny;

					if ($latest_invoice_no_tiny->invoice_no_tiny == '999') {
						$big_series_no_inc = $big_series_no + 1;
						$big_series_no_sum = str_pad($big_series_no_inc, 5, '0', STR_PAD_LEFT);

						$tiny_series_no_new = str_pad(1, 3, '0', STR_PAD_LEFT);

						$invoice_no = $invoice_user_id . '-' . $big_series_no_sum . '-' .  $tiny_series_no_new;

						$this->Japan_ior_model->insert_invoice_no($shipping_invoice_id, $big_series_no_sum, $tiny_series_no_new);
					} else {
						$tiny_series_no_inc = $tiny_series_no + 1;
						$tiny_series_no_sum = str_pad($tiny_series_no_inc, 3, '0', STR_PAD_LEFT);

						$invoice_no = $invoice_user_id . '-' . $big_series_no . '-' .  $tiny_series_no_sum;
						$this->Japan_ior_model->insert_invoice_no($shipping_invoice_id, $big_series_no, $tiny_series_no_sum);
					}
				}
			} else {
				$invoice_no = $invoice_user_id . '-' . $shipping_invoice->invoice_no_big . '-' .  $shipping_invoice->invoice_no_tiny;
			}

			ob_start();

			$date_today = date('Y-m-d');
			$updated_by = $this->session->userdata('user_id');
			$updated_at = date('Y-m-d H:i:s');

		    $this->Japan_ior_model->update_shipping_invoice_date($shipping_invoice_id, $date_today, $updated_by, $updated_at);

			if (!empty($s_email)) {
				$this->send_mail_verification($s_email, $s_company_name);
			}

			if ($shipping_link != 0) {
				$link = 1;
			} else {
				$link = 0;
			}

			$this->default_shipping_invoice($shipping_invoice_id, 1, $invoice_no, $fba, $product_sampling, $link);

			$shipping_invoice_file = base_url().'/uploads/shipping_invoice_pdf/' . $user_id . '/' . $shipping_invoice_id . '/' . $invoice_no . ' Shipping Invoice.pdf';
			
			$this->add_logistic($logistic_form->street_address,
								$logistic_form->address_line_2,
								$logistic_form->city,
								$logistic_form->state,
								$logistic_form->postal,
								$logistic_form->country_1,
								$logistic_form->company_name,
								$logistic_form->id,
								$shipping_invoice_file,
								$shipping_invoice_id,
							    $shipping_invoice->shipping_code);

			$poa_array = array(
				'address_line_2' => $logistic_form->address_line_2,
				'city' => $logistic_form->city,
				'state' => $logistic_form->state,
				'postal' => $logistic_form->postal,
				'country_1' => $logistic_form->country_1,
				'company_name' => $logistic_form->company_name,
			);


			$this->default_shipping_invoice_zoho($shipping_invoice_id,0,'', 2, $poa_array);
			redirect('/uploads/shipping_invoice_pdf/' . $user_id . '/' . $shipping_invoice_id . '/' . $invoice_no . ' Shipping Invoice.pdf', 'refresh');
		}
	}

	public function shipping_invoice_success()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'shipping_invoices';

		$data['page_view'] = 'japan_ior/shipping_invoices/shipping_invoice_success';
		$this->load->view('page', $data);
	}

	public function check_shipping_invoice_pdf()
	{
		$shipping_invoice_final_pdf_file = $this->input->post('shipping_invoice_final_pdf_file');

		if (!file_exists($shipping_invoice_final_pdf_file)) {
			$response['status'] = false;
		} else {
			$response['status'] = true;
		}

		echo json_encode($response);
	}

	public function send_shipping_invoice()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
			$user_details_login = $q_user_details->row();

			if ($user_details_login->ior_registered != '1' && $user_details_login->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$this->clear_apost();

		$data['external_page'] = 2;
		$data['active_page'] = 'shipping_invoices';

		$data['shipping_invoice_id'] = $this->uri->segment(3);

		$q_shipping_invoice = $this->Japan_ior_model->fetch_shipping_invoice_by_id($data['shipping_invoice_id']);
		$data['shipping_invoice'] = $q_shipping_invoice->row();

		$q_user_details = $this->Japan_ior_model->fetch_user_by_id($data['shipping_invoice']->user_id);
		$data['user_details'] = $q_user_details->row();

		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('invoice_send_to', 'Send To', 'trim|required');
			$this->form_validation->set_rules('invoice_subject', 'Subject', 'trim|required');
			// $this->form_validation->set_rules('invoice_msg', 'Body', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$q_shipping_invoice = $this->Japan_ior_model->fetch_shipping_invoice_by_id($data['shipping_invoice_id']);
				$data['shipping_invoice'] = $q_shipping_invoice->row();

				$q_user_details = $this->Japan_ior_model->fetch_user_by_id($data['shipping_invoice']->user_id);
				$data['user_details'] = $q_user_details->row();

				$data['page_view'] = 'japan_ior/shipping_invoices/send_shipping_invoice';
				$this->load->view('page', $data);
			} else {
				$invoice_user_id = str_pad($data['shipping_invoice']->user_id, 2, '0', STR_PAD_LEFT);
				$invoice_no = $invoice_user_id . '-' . $data['shipping_invoice']->invoice_no_big . '-' . $data['shipping_invoice']->invoice_no_tiny;

				$invoice_file = getcwd() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'shipping_invoice_pdf' . DIRECTORY_SEPARATOR . $data['shipping_invoice']->user_id . DIRECTORY_SEPARATOR . $data['shipping_invoice']->shipping_invoice_id . DIRECTORY_SEPARATOR . $invoice_no . ' Shipping Invoice.pdf';

				$invoice_send_to = stripslashes($this->input->post('invoice_send_to'));
				$invoice_cc = stripslashes($this->input->post('invoice_cc'));
				$invoice_subject = stripslashes($this->input->post('invoice_subject'));
				$invoice_msg = stripslashes($this->input->post('invoice_msg'));
				$created_at = date('Y-m-d H:i:s');

				$mail = $this->phpmailer_library->load();

				$mail->isSMTP();
				$mail->Host     = 'mail.covueior.com';
				$mail->SMTPAuth = true;
				$mail->Username = 'admin@covueior.com';
				$mail->Password = 'Y.=Sa3hZxq+>@6';
				// $mail->SMTPSecure = 'ssl'; // tls
				$mail->Port     = 26; // 587
				$mail->setFrom($data['user_details']->email, $data['user_details']->contact_person);

				if (!empty($invoice_send_to)) {
					$findthis = ',';
					$pos = strpos($invoice_send_to, $findthis);

					if ($pos === false) {
						$mail->addAddress($invoice_send_to);
					} else {
						$invoice_send_to_arr = array();
						$invoice_send_to_arr = explode(",", $invoice_send_to);
						$invoice_send_to_arr_count = count($invoice_send_to_arr);

						for ($i = 0; $i < $invoice_send_to_arr_count; $i++) {
							$mail->addAddress($invoice_send_to_arr[$i]);
						}
					}
				}

				if (!empty($invoice_cc)) {
					$findthis = ',';
					$pos = strpos($invoice_cc, $findthis);

					if ($pos === false) {
						$mail->addCC($invoice_cc);
					} else {
						$invoice_cc_arr = array();
						$invoice_cc_arr = explode(",", $invoice_cc);
						$invoice_cc_arr_count = count($invoice_cc_arr);

						for ($i = 0; $i < $invoice_cc_arr_count; $i++) {
							$mail->addCC($invoice_cc_arr[$i]);
						}
					}
				}

				$mail->addBCC($data['user_details']->email);
				$mail->addBCC('mikecoros05@gmail.com');

				$mail->Subject = $invoice_subject;
				$mail->isHTML(true);
				$mail->addAttachment($invoice_file);

				if (empty($invoice_msg)) {
					$mail->Body = ' ';
				} else {
					$mail->Body = $invoice_msg;
				}

				if ($mail->send()) {
					$result = 1;
					// $this->Japan_ior_model->insert_sent_invoice($invoice_send_to, $invoice_cc, $invoice_subject, $invoice_msg, $created_at);
				} else {
					$result = 0;
				}

				if ($result == 1) {
					$this->session->set_flashdata('success', 'Successfully sent shipping invoice, your registered email also will be able to receive the email for copy.');
					redirect('japan-ior/shipping-invoices', 'refresh');
				} else {
					$data['errors'] = 1;

					$q_shipping_invoice = $this->Japan_ior_model->fetch_shipping_invoice_by_id($data['shipping_invoice_id']);
					$data['shipping_invoice'] = $q_shipping_invoice->row();

					$q_user_details = $this->Japan_ior_model->fetch_user_by_id($data['shipping_invoice']->user_id);
					$data['user_details'] = $q_user_details->row();

					$data['page_view'] = 'japan_ior/shipping_invoices/send_shipping_invoice';
					$this->load->view('page', $data);
				}
			}
		} else {
			$data['page_view'] = 'japan_ior/shipping_invoices/send_shipping_invoice';
			$this->load->view('page', $data);
		}
	}

	public function product_services_fee()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'regulated_applications';

		$data['user_id'] = $this->session->userdata('user_id');

		$q_user_details = $this->Japan_ior_model->fetch_users_by_id($data['user_id']);
		$data['user_details'] = $q_user_details->row();

		$billing_invoices_unpaid_count = $this->Japan_ior_model->fetch_billing_invoices_unpaid($data['user_id']);

		if ($billing_invoices_unpaid_count > 0) {
			$data['external_page'] = 2;
			$data['active_page'] = 'regulated_applications';
			$data['page_view'] = 'japan_ior/billing_invoices/billing_invoice_unpaid';
			$this->load->view('page', $data);
		} else {
			$data['page_view'] = 'japan_ior/regulated_applications/product_services_fee';

			$q_country = $this->Japan_ior_model->fetch_country_by_id($data['user_details']->country);
			$data['country_name'] = $q_country->row();

			$q_fetch_product_services = $this->Japan_ior_model->fetch_product_services();
			$data['product_services'] = $q_fetch_product_services->result();

			$q_products_offer = $this->Japan_ior_model->fetch_products_offer();
			$data['products_offer'] = $q_products_offer->result();

			$q_ior_reg_fee = $this->Japan_ior_model->fetch_product_offer(1);
			$data['ior_reg_fee'] = $q_ior_reg_fee->row();

			$q_pli_fee = $this->Japan_ior_model->fetch_product_offer(2);
			$data['pli_fee'] = $q_pli_fee->row();

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$products_offer_val = explode('|', $this->input->post('products_offer'));
				$product_category_id = $products_offer_val[0];
				$product_offer_id = $products_offer_val[1];

				$subtotal = $this->input->post('subtotal');
				$jct = $this->input->post('jct');
				$total = $this->input->post('total');
				$plt = $this->input->post('plt');
				$created_at = date('Y-m-d H:i:s');

				if ($data['user_details']->ior_registered == 0) {
					$register_ior = 1;
				} else {
					$register_ior = 0;
				}

				if ($data['user_details']->pli == 0) {
					$pli = 1;
				} else {
					$pli = 0;
				}

				$amazon_account_id = 0;

				if ($this->input->post('product_services') == 'amazon') {
					$pli = 0;
					$amazon_account_id = $this->Japan_ior_model->insert_amazon_account($data['user_id'], $created_at);
				}

				$billing_invoice_id = $this->Japan_ior_model->insert_user_payment_invoice($data['user_id'], $product_category_id, $register_ior, $pli, $product_offer_id, $plt, $subtotal, $jct, $total, $data['user_id'], $created_at, $amazon_account_id);

				redirect('/japan-ior/billing-invoice/' . $billing_invoice_id, 'refresh');
			} else {
				$this->load->view('page', $data);
			}
		}
	}

	public function fetch_product_offer()
	{
		$product_offer_id = $this->input->post('product_offer_id');

		$q_product_offer = $this->Japan_ior_model->fetch_product_offer($product_offer_id);
		$product_offer = $q_product_offer->row();

		echo $product_offer->name . '|' . $product_offer->price . '|' . $product_offer->value;
	}

	public function fetch_product_offer_by_service_id()
	{
		$id = $this->input->post('id');

		$q_product_offer_by_service_id = $this->Japan_ior_model->fetch_product_offer_by_service_id($id);
		$product_offer_by_service_id = $q_product_offer_by_service_id->result();

		if ($id == 1) {
			$option = '<option value="" selected>Non-regulated</option>';
		}

		if ($id == 2) {
			$option = '<option value="" selected>- Please select Amazon Product services -</option>';
		}

		foreach ($product_offer_by_service_id as $product_offer) {
			$option .= '<option value="' . $product_offer->product_offer_id . '">' . $product_offer->name . '</option>';
		}

		echo $option;
	}

	// public function regulated_status_notification()
	// {
	// 	$data = $this->session->userdata('user_id');
	// 	$notificaton = $this->Japan_ior_model->fetch_regulated_remarks_status($data);
	// 	$results = $notificaton->result();
	// 	echo json_encode($results);
	// }

	public function regulated_applications()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$data['user_id'] = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'regulated_applications';
		$data['page_view'] = 'japan_ior/regulated_applications/regulated_applications';

		$q_fetch_paid_regulated = $this->Japan_ior_model->fetch_paid_regulated($data['user_id']);
		$data['paid_regulated_applications'] = $q_fetch_paid_regulated->result();

		$data['billing_invoices_unpaid_count'] = $this->Japan_ior_model->fetch_billing_invoices_unpaid($data['user_id']);

		$this->load->view('page', $data);
	}

	public function import_logistics()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$data['user_id'] = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$data['logistic_infos'] = $this->get_zoho_logistics($data['user_details']->company_name);

		$data['external_page'] = 2;
		$data['active_page'] = 'import_logistics';
		$data['page_view'] = 'japan_ior/import_logistics/index';

		$q_fetch_paid_regulated = $this->Japan_ior_model->fetch_paid_regulated($data['user_id']);
		$data['paid_regulated_applications'] = $q_fetch_paid_regulated->result();


		$this->load->view('page', $data);
	}

	public function create_regulated_application()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$data['user_id'] = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$data['external_page'] = 1;
		$data['active_page'] = 'japan_ior';
		$data['page_view'] = 'japan_ior/regulated_applications/add_regulated_application';

		$created_by = $this->session->userdata('user_id');
		$created_at = date('Y-m-d H:i:s');

		$user_payment_invoice_id = $this->uri->segment(3);

		$q_user_payment_invoice = $this->Japan_ior_model->fetch_user_payment_invoice($user_payment_invoice_id);
		$user_payment_invoice = $q_user_payment_invoice->row();

		$reg_application_id = $this->Japan_ior_model->insert_new_reg_application($user_payment_invoice_id, $user_payment_invoice->product_category_id, $created_by, $created_at);
		$today = date('Y-m-d');

		$result = $this->Japan_ior_model->insert_reg_application_tracking($reg_application_id, $today, 1, 4, $created_by, $created_at);

		if ($result == 1) {
			$q_user_compliance = $this->Japan_ior_model->fetch_admin_user_compliance();
			$user_compliance   = $q_user_compliance->result();
			$cnt_res           = $q_user_compliance->num_rows();
			if ($cnt_res != 0) {
				// $this->send_mail_to_compliance($user_compliance);
			}
			redirect('/japan-ior/tracking-application/' . $reg_application_id);
		} else {
			redirect('/japan-ior/dashboard');
		}
	}

	public function tracking_application()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$data['user_id'] = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'regulated_applications';
		$data['page_view'] = 'japan_ior/regulated_applications/tracking_application';

		$regulated_application_id = $this->uri->segment(3);

		$q_fetch_reg_application = $this->Japan_ior_model->fetch_reg_application($regulated_application_id);
		$data['reg_application'] = $q_fetch_reg_application->row();

		$q_update_notification_view = $this->Japan_ior_model->update_reg_application_tracking_notification($regulated_application_id);

		// if ($data['reg_application']->product_category_id == 3 || $data['reg_application']->product_category_id == 4 || $data['reg_application']->product_category_id == 12 || $data['reg_application']->product_category_id == 13 || $data['reg_application']->product_category_id == 9) {
		$q_fetch_tracking_steps_a = $this->Japan_ior_model->fetch_tracking_steps_a($regulated_application_id);
		$data['tracking_steps'] = $q_fetch_tracking_steps_a->result();

		$q_fetch_tracking_latest_a = $this->Japan_ior_model->fetch_tracking_latest_a($regulated_application_id);
		$data['tracking_latest'] = $q_fetch_tracking_latest_a->row();

		$q_fetch_reg_application_tracking_a = $this->Japan_ior_model->fetch_reg_application_tracking_a($regulated_application_id);
		$data['reg_application_trackings'] = $q_fetch_reg_application_tracking_a->result();

		// } else {
		// 	$q_fetch_tracking_steps_b = $this->Japan_ior_model->fetch_tracking_steps_b();
		// 	$data['tracking_steps'] = $q_fetch_tracking_steps_b->result();

		// 	$q_fetch_tracking_latest_b = $this->Japan_ior_model->fetch_tracking_latest_b($regulated_application_id);
		// 	$data['tracking_latest'] = $q_fetch_tracking_latest_b->row();

		// 	$q_fetch_reg_application_tracking_b = $this->Japan_ior_model->fetch_reg_application_tracking_b($regulated_application_id);
		// 	$data['reg_application_trackings'] = $q_fetch_reg_application_tracking_b->result();
		// }

		$q_fetch_reg_products = $this->Japan_ior_model->fetch_regulated_products($regulated_application_id);
		$data['req_products_cnt'] =  $q_fetch_reg_products->num_rows();

		$data['reg_products_revisions_cnt'] = $this->Japan_ior_model->reg_products_revisions_count($regulated_application_id);
		$data['reg_products_declined_cnt'] = $this->Japan_ior_model->reg_products_declined_count($regulated_application_id);

		$data['is_regulated_label_paid'] = $this->Japan_ior_model->check_regulated_label_payment($regulated_application_id);

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// $products_offer_val = explode('|', $this->input->post('products_offer'));
			$product_category_id = $this->input->post('category_id');
			$product_offer_id = 0;

			$subtotal = $this->input->post('subtotal');
			$jct = $this->input->post('jct');
			$total = $this->input->post('total');
			$plt = 0;
			$created_at = date('Y-m-d H:i:s');

			if ($data['user_details']->ior_registered == 0) {
				$register_ior = 1;
			} else {
				$register_ior = 0;
			}

			$pli = 0;

			$billing_invoice_id = $this->Japan_ior_model->insert_user_payment_invoice_product_label($data['user_id'], $product_category_id, $register_ior, $pli, $product_offer_id, $plt, $subtotal, $jct, $total, $data['user_id'], $created_at, 0, $regulated_application_id);

			redirect('/japan-ior/billing-invoice/' . $billing_invoice_id, 'refresh');
		} else {
			$this->load->view('page', $data);
		}
	}

	public function regulated_products_list()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$data['user_id'] = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$this->clear_apost();
		$current_timestamp = now();
		$data['external_page'] = 2;
		$data['active_page'] = 'regulated_applications';

		$data['regulated_application_id'] = $this->uri->segment(3);

		$q_fetch_manufacturer_details = $this->Japan_ior_model->fetch_manufacturer_details($data['regulated_application_id']);
		$data['manufacturer_details'] = $q_fetch_manufacturer_details->row();

		$q_fetch_reg_application = $this->Japan_ior_model->fetch_reg_application($data['regulated_application_id']);
		$data['reg_application'] = $q_fetch_reg_application->row();

		$q_fetch_reg_products = $this->Japan_ior_model->fetch_regulated_products($data['regulated_application_id']);
		$data['reg_products'] = $q_fetch_reg_products->result();

		$q_fetch_countries = $this->Japan_ior_model->fetch_countries();
		$data['countries'] = $q_fetch_countries->result();

		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('manufacturer_name', 'Company Name', 'trim|required');
			$this->form_validation->set_rules('manufacturer_address', 'Company Address', 'trim|required');
			$this->form_validation->set_rules('manufacturer_city', 'City', 'trim|required');
			$this->form_validation->set_rules('manufacturer_country', 'Country', 'trim|required');
			$this->form_validation->set_rules('manufacturer_zipcode', 'Zip Code', 'trim|required');
			$this->form_validation->set_rules('manufacturer_contact', 'Company Contact', 'trim|required');

			if ($this->input->post('manuaction') == 'add') {
				if ($data['reg_application']->product_category_id != 4) {
					if (empty($_FILES['manufacturer_flow_process']['name'])) {
						$this->form_validation->set_rules('manufacturer_flow_process', 'Manufacturing Flow Process', 'required');
					}
				}

				if ($this->form_validation->run() == FALSE) {
					$data['page_view'] = 'japan_ior/regulated_applications/regulated_products_list';
					$this->load->view('page', $data);
				} else {

					if (!empty($_FILES['manufacturer_flow_process']['name'])) {
						$upload_path_file = 'uploads/regulated_applications/' . $data['regulated_application_id'];

						if (!file_exists($upload_path_file)) {
							mkdir($upload_path_file, 0777, true);
						}

						$config['upload_path'] = $upload_path_file;
						$config['allowed_types'] = 'pdf|jpg|jpeg|png';
						$config['max_size'] = 5000000;
						$config['file_name'] = 'manufacturer_flow_process_' . $data['regulated_application_id'] . '_' . $current_timestamp;

						$this->upload->initialize($config);

						if (!$this->upload->do_upload('manufacturer_flow_process')) {

							$data['errors'] = 2;
							$data['error_msgs'] = $this->upload->display_errors();

							$this->load->view('page', $data);
						} else {
							$manufacturer_name = stripslashes($this->input->post('manufacturer_name'));
							$manufacturer_address = stripslashes($this->input->post('manufacturer_address'));
							$manufacturer_city = stripslashes($this->input->post('manufacturer_city'));
							$manufacturer_country = stripslashes($this->input->post('manufacturer_country'));
							$manufacturer_zipcode = stripslashes($this->input->post('manufacturer_zipcode'));
							$manufacturer_contact = stripslashes($this->input->post('manufacturer_contact'));
							$manufacturer_website = stripslashes($this->input->post('manufacturer_website'));
							$created_by = $this->session->userdata('user_id');
							$created_at = date('Y-m-d H:i:s');

							$result = $this->Japan_ior_model->insert_manufacturer_details($data['regulated_application_id'], $config['file_name'] . $this->upload->data('file_ext'), $manufacturer_name, $manufacturer_address, $manufacturer_city, $manufacturer_country, $manufacturer_zipcode, $manufacturer_contact, $manufacturer_website, $created_by, $created_at);

							if ($result == 1) {
								$this->session->set_flashdata('success', 'Successfully updated manufacturer details!');
								redirect('/japan-ior/regulated-products-list/' . $data['regulated_application_id'], 'refresh');
							} else {
								$this->session->set_flashdata('error', 'Sorry for the inconvenience! Some errors found. Please contact our administrator through livechat or email.');
								redirect('/japan-ior/regulated-products-list/' . $data['regulated_application_id'], 'refresh');
							}
						}
					} else {
						$manufacturer_name = stripslashes($this->input->post('manufacturer_name'));
						$manufacturer_address = stripslashes($this->input->post('manufacturer_address'));
						$manufacturer_city = stripslashes($this->input->post('manufacturer_city'));
						$manufacturer_country = stripslashes($this->input->post('manufacturer_country'));
						$manufacturer_zipcode = stripslashes($this->input->post('manufacturer_zipcode'));
						$manufacturer_contact = stripslashes($this->input->post('manufacturer_contact'));
						$manufacturer_website = stripslashes($this->input->post('manufacturer_website'));
						$created_by = $this->session->userdata('user_id');
						$created_at = date('Y-m-d H:i:s');

						$result = $this->Japan_ior_model->insert_manufacturer_details($data['regulated_application_id'], '', $manufacturer_name, $manufacturer_address, $manufacturer_city, $manufacturer_country, $manufacturer_zipcode, $manufacturer_contact, $manufacturer_website, $created_by, $created_at);

						if ($result == 1) {
							$this->session->set_flashdata('success', 'Successfully updated manufacturer details!');
							redirect('/japan-ior/regulated-products-list/' . $data['regulated_application_id'], 'refresh');
						} else {
							$this->session->set_flashdata('error', 'Sorry for the inconvenience! Some errors found. Please contact our administrator through livechat or email.');
							redirect('/japan-ior/regulated-products-list/' . $data['regulated_application_id'], 'refresh');
						}
					}
				}
			} else {
				$upload_path_file = 'uploads/regulated_applications/' . $data['regulated_application_id'];
				if ($this->form_validation->run() == FALSE) {
					$data['page_view'] = 'japan_ior/regulated_applications/regulated_products_list';
					$this->load->view('page', $data);
				} else {
					if (!empty($_FILES['manufacturer_flow_process']['name'])) {

						$config1['upload_path'] = $upload_path_file;
						$config1['allowed_types'] = 'pdf|jpg|jpeg|png';
						$config1['max_size'] = 5000000;
						$config1['file_name'] = 'manufacturer_flow_process_' . $data['regulated_application_id'] . '_' . $current_timestamp;
						$this->upload->initialize($config1);
						if (!$this->upload->do_upload('manufacturer_flow_process')) {
							$data['errors'] = 2;
							$data['error_msgs'] = $this->upload->display_errors();
							$data['page_view'] = 'japan_ior/regulated_applications/regulated_products_list';
							$this->load->view('page', $data);
						} else {
							$manufacturer_flow_process_filename = $config1['file_name'] . $this->upload->data('file_ext');
						}
					} else {
						$manufacturer_flow_process_filename = '';
					}

					$manufacturer_name = stripslashes($this->input->post('manufacturer_name'));
					$manufacturer_address = stripslashes($this->input->post('manufacturer_address'));
					$manufacturer_city = stripslashes($this->input->post('manufacturer_city'));
					$manufacturer_country = stripslashes($this->input->post('manufacturer_country'));
					$manufacturer_zipcode = stripslashes($this->input->post('manufacturer_zipcode'));
					$manufacturer_contact = stripslashes($this->input->post('manufacturer_contact'));
					$manufacturer_website = stripslashes($this->input->post('manufacturer_website'));
					$created_by = $this->session->userdata('user_id');
					$created_at = date('Y-m-d H:i:s');

					$result = $this->Japan_ior_model->update_manufacturer_details($data['regulated_application_id'], $manufacturer_flow_process_filename, $manufacturer_name, $manufacturer_address, $manufacturer_city, $manufacturer_country, $manufacturer_zipcode, $manufacturer_contact, $manufacturer_website, $created_by, $created_at);

					if ($result == 1) {
						$this->session->set_flashdata('success', 'Successfully updated manufacturer details!');
						redirect('/japan-ior/regulated-products-list/' . $data['regulated_application_id'], 'refresh');
					} else {
						$this->session->set_flashdata('error', 'Sorry for the inconvenience! Some errors found. Please contact our administrator through livechat or email.');
						redirect('/japan-ior/regulated_products-list/' . $data['regulated_application_id'], 'refresh');
					}
				}
			}
		} else {
			$data['page_view'] = 'japan_ior/regulated_applications/regulated_products_list';
			$this->load->view('page', $data);
		}
	}

	public function add_regulated_products()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$data['user_id'] = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$this->clear_apost();

		$data['external_page'] = 2;
		$data['active_page'] = 'regulated_applications';

		$data['regulated_application_id'] = $this->uri->segment(3);

		$q_fetch_reg_application = $this->Japan_ior_model->fetch_reg_application($data['regulated_application_id']);
		$data['reg_application'] = $q_fetch_reg_application->row();
		$regulated_application_id = $data['reg_application']->regulated_application_id;
		$q_fetch_reg_products = $this->Japan_ior_model->fetch_regulated_products($regulated_application_id);
		$data['req_products_cnt'] =  $q_fetch_reg_products->num_rows();
		$product_category_id = $data['reg_application']->product_category_id;

		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('sku', 'HS Code', 'trim|required');
			$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
			if (empty($_FILES['product_img']['name'])) {
				$this->form_validation->set_rules('product_img', 'Product Image', 'required');
			}
			if (empty($_FILES['ingredients_formula']['name'])) {
				$this->form_validation->set_rules('ingredients_formula', 'Ingredients Formula', 'required');
			}
			$this->form_validation->set_rules('product_use_and_info', 'Product Use and Information', 'trim|required');
			$this->form_validation->set_rules('volume_weight', 'Volume/Weight', 'trim|required');
			// if (empty($_FILES['consumer_product_packaging_img']['name'])) {
			// 	$this->form_validation->set_rules('consumer_product_packaging_img', 'Ingredients Formula', 'required');
			// }
			// if (empty($_FILES['outerbox_frontside']['name'])) {
			// 	$this->form_validation->set_rules('outerbox_frontside', 'Outebox(Frontside)', 'required');
			// }
			// if (empty($_FILES['outerbox_backside']['name'])) {
			// 	$this->form_validation->set_rules('outerbox_backside', 'Outebox(Backside)', 'required');
			// }
			// $this->form_validation->set_rules('approx_size_of_package', 'Approximately Size of Package', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data['page_view'] = 'japan_ior/regulated_applications/add_regulated_products';
				$this->load->view('page', $data);
			} else {
				if (($product_category_id == 3 || $product_category_id == 4 || $product_category_id == 12 || $product_category_id == 13) && $data['req_products_cnt'] > 150) {
					$this->session->set_flashdata('error', 'Exceeding limit of 150 products for this category is invalid');
					redirect('/japan-ior/regulated-products-list/' . $data['regulated_application_id'], 'refresh');
				}

				// else {
				// 	if ($data['req_products_cnt'] > 25) {
				// 		$this->session->set_flashdata('error', 'Exceeding limit of 25 products for this category is invalid');
				// 		redirect('/japan-ior/regulated-products-list/' . $data['regulated_application_id'], 'refresh');
				// 	}
				// }

				$current_timestamp = now();
				$upload_path_file1 = 'uploads/product_qualification/' . $data['user_id'];

				if (!file_exists($upload_path_file1)) {
					mkdir($upload_path_file1, 0777, true);
				}

				$config1['upload_path'] = $upload_path_file1;
				$config1['allowed_types'] = 'pdf|jpg|jpeg|png';
				$config1['max_size'] = 5000000;
				$config1['file_name'] = 'product_qualification_' . $current_timestamp;

				$this->upload->initialize($config1);

				if (!$this->upload->do_upload('product_img')) {
					$data['errors'] = 2;
					$data['error_msgs'] = $this->upload->display_errors();
					$data['page_view'] = 'japan_ior/regulated_applications/add_regulated_products';
					$this->load->view('page', $data);
				} else {
					$sku = stripslashes($this->input->post('sku'));
					$product_name = stripslashes($this->input->post('product_name'));
					$product_img_filename = $config1['file_name'] . $this->upload->data('file_ext');
					$created_by = $this->session->userdata('user_id');
					$created_at = date('Y-m-d H:i:s');

					$regulated_product_id = $this->Japan_ior_model->insert_regulated_product($data['user_id'], $data['regulated_application_id'], $data['reg_application']->product_category_id,  $sku, $product_name, $product_img_filename, $created_by, $created_at);

					$upload_path_file2 = 'uploads/regulated_applications/' . $data['regulated_application_id'];

					if (!file_exists($upload_path_file2)) {
						mkdir($upload_path_file2, 0777, true);
					}

					$config2['upload_path'] = $upload_path_file2;
					$config2['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config2['max_size'] = 5000000;
					$config2['file_name'] = 'ingredients_formula_' . $current_timestamp;

					$this->upload->initialize($config2);

					if (!$this->upload->do_upload('ingredients_formula')) {
						$data['errors'] = 2;
						$data['error_msgs'] = $this->upload->display_errors();
						$data['page_view'] = 'japan_ior/regulated_applications/add_regulated_products';
						$this->load->view('page', $data);
					} else {
						$ingredients_formula_filename = $config2['file_name'] . $this->upload->data('file_ext');
					}

					$config4['upload_path'] = $upload_path_file2;
					$config4['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config4['max_size'] = 5000000;
					$config4['file_name'] = 'consumer_product_packaging_img_' . $current_timestamp;

					$this->upload->initialize($config4);

					if (!$this->upload->do_upload('consumer_product_packaging_img')) {
						$consumer_product_packaging_img_filename = '';
					} else {
						$consumer_product_packaging_img_filename = $config4['file_name'] . $this->upload->data('file_ext');
					}

					$config5['upload_path'] = $upload_path_file2;
					$config5['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config5['max_size'] = 5000000;
					$config5['file_name'] = 'outerbox_frontside_' . $current_timestamp;

					$this->upload->initialize($config5);

					if (!$this->upload->do_upload('outerbox_frontside')) {
						$outerbox_frontside_filename = '';
					} else {
						$outerbox_frontside_filename = $config5['file_name'] . $this->upload->data('file_ext');
					}

					$config6['upload_path'] = $upload_path_file2;
					$config6['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config6['max_size'] = 5000000;
					$config6['file_name'] = 'outerbox_backside_' . $current_timestamp;

					$this->upload->initialize($config6);

					if (!$this->upload->do_upload('outerbox_backside')) {
						$outerbox_backside_filename = '';
					} else {
						$outerbox_backside_filename = $config6['file_name'] . $this->upload->data('file_ext');
					}

					$product_use_and_info = stripslashes($this->input->post('product_use_and_info'));
					$volume_weight = stripslashes($this->input->post('volume_weight'));
					$approx_size_of_package = stripslashes($this->input->post('approx_size_of_package'));

					$result = $this->Japan_ior_model->insert_regulated_product_a($regulated_product_id, $ingredients_formula_filename, $product_use_and_info, $outerbox_frontside_filename, $outerbox_backside_filename, $volume_weight, $consumer_product_packaging_img_filename, $approx_size_of_package);

					if ($result == 1) {
						$this->session->set_flashdata('success', 'Successfully submitted regulated product details!');
						redirect('/japan-ior/regulated-products-list/' . $data['regulated_application_id'], 'refresh');
					} else {
						$this->session->set_flashdata('error', 'Sorry for the inconvenience! Some errors found. Please contact our administrator through livechat or email.');
						redirect('/japan-ior/add-regulated-products/' . $data['regulated_application_id'], 'refresh');
					}
				}
			}
		} else {
			$this->session->set_flashdata('modal_product_name_info', 'Product Name Info');
			$data['page_view'] = 'japan_ior/regulated_applications/add_regulated_products';
			$this->load->view('page', $data);
		}
	}

	public function edit_regulated_products()
	{
		$this->clear_apost();

		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$data['user_id'] = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'regulated_applications';

		$data['regulated_product_id'] = $this->uri->segment(3);

		$q_fetch_reg_product_by_id = $this->Japan_ior_model->fetch_reg_product_by_id($data['regulated_product_id']);
		$data['reg_product'] = $q_fetch_reg_product_by_id->row();

		$q_fetch_reg_product_cust_by_id = $this->Japan_ior_model->fetch_reg_product_cust_by_id($data['reg_product']->id);
		$data['reg_product_cust'] = $q_fetch_reg_product_cust_by_id->result();

		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('sku', 'HS Code', 'trim|required');
			$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
			$this->form_validation->set_rules('product_use_and_info', 'Product Use and Information', 'trim|required');
			$this->form_validation->set_rules('volume_weight', 'Volume/Weight', 'trim|required');
			// $this->form_validation->set_rules('approx_size_of_package', 'Approximately Size of Package', 'trim|required');

			$regulated_application_id = stripslashes($this->input->post('regulated_application_id'));

			if ($this->form_validation->run() == FALSE) {
				$data['page_view'] = 'japan_ior/regulated_applications/edit_regulated_products';
				$this->load->view('page', $data);
			} else {
				$current_timestamp = now();
				$upload_path_file1 = 'uploads/product_qualification/' . $data['user_id'];
				$upload_path_file2 = 'uploads/regulated_applications/' . $regulated_application_id;

				if (!empty($_FILES['product_img']['name'])) {
					$config1['upload_path'] = $upload_path_file1;
					$config1['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config1['max_size'] = 5000000;
					$config1['file_name'] = 'product_qualification_' . $current_timestamp;

					$this->upload->initialize($config1);

					if (!$this->upload->do_upload('product_img')) {
						$data['errors'] = 2;
						$data['error_msgs'] = $this->upload->display_errors();
						$data['page_view'] = 'japan_ior/regulated_applications/edit_regulated_products';
						$this->load->view('page', $data);
					} else {
						$product_img_filename = $config1['file_name'] . $this->upload->data('file_ext');
					}
				} else {
					$product_img_filename = '';
				}

				if (!empty($_FILES['ingredients_formula']['name'])) {
					$config2['upload_path'] = $upload_path_file2;
					$config2['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config2['max_size'] = 5000000;
					$config2['file_name'] = 'ingredients_formula_' . $current_timestamp;

					$this->upload->initialize($config2);

					if (!$this->upload->do_upload('ingredients_formula')) {
						$data['errors'] = 2;
						$data['error_msgs'] = $this->upload->display_errors();
						$data['page_view'] = 'japan_ior/regulated_applications/edit_regulated_products';
						$this->load->view('page', $data);
					} else {
						$ingredients_formula_filename = $config2['file_name'] . $this->upload->data('file_ext');
					}
				} else {
					$ingredients_formula_filename = '';
				}

				if (!empty($_FILES['consumer_product_packaging_img']['name'])) {
					$config5['upload_path'] = $upload_path_file2;
					$config5['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config5['max_size'] = 5000000;
					$config5['file_name'] = 'consumer_product_packaging_img_' . $current_timestamp;

					$this->upload->initialize($config5);

					if (!$this->upload->do_upload('consumer_product_packaging_img')) {
						$data['errors'] = 2;
						$data['error_msgs'] = $this->upload->display_errors();
						$data['page_view'] = 'japan_ior/regulated_applications/edit_regulated_products';
						$this->load->view('page', $data);
					} else {
						$consumer_product_packaging_img_filename = $config5['file_name'] . $this->upload->data('file_ext');
					}
				} else {
					$consumer_product_packaging_img_filename = '';
				}

				if (!empty($_FILES['outerbox_frontside']['name'])) {
					$config6['upload_path'] = $upload_path_file2;
					$config6['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config6['max_size'] = 5000000;
					$config6['file_name'] = 'outerbox_frontside_' . $current_timestamp;

					$this->upload->initialize($config6);

					if (!$this->upload->do_upload('outerbox_frontside')) {
						$data['errors'] = 2;
						$data['error_msgs'] = $this->upload->display_errors();
						$data['page_view'] = 'japan_ior/regulated_applications/edit_regulated_products';
						$this->load->view('page', $data);
					} else {
						$outerbox_frontside_filename = $config6['file_name'] . $this->upload->data('file_ext');
					}
				} else {
					$outerbox_frontside_filename = '';
				}

				if (!empty($_FILES['outerbox_backside']['name'])) {
					$config7['upload_path'] = $upload_path_file2;
					$config7['allowed_types'] = 'pdf|jpg|jpeg|png';
					$config7['max_size'] = 5000000;
					$config7['file_name'] = 'outerbox_backside_' . $current_timestamp;

					$this->upload->initialize($config7);

					if (!$this->upload->do_upload('outerbox_backside')) {
						$data['errors'] = 2;
						$data['error_msgs'] = $this->upload->display_errors();
						$data['page_view'] = 'japan_ior/regulated_applications/edit_regulated_products';
						$this->load->view('page', $data);
					} else {
						$outerbox_backside_filename = $config7['file_name'] . $this->upload->data('file_ext');
					}
				} else {
					$outerbox_backside_filename = '';
				}

				$sku = stripslashes($this->input->post('sku'));
				$product_name = stripslashes($this->input->post('product_name'));
				$updated_by = $this->session->userdata('user_id');
				$updated_at = date('Y-m-d H:i:s');

				$this->Japan_ior_model->update_regulated_product($data['regulated_product_id'], $sku, $product_name, $product_img_filename, $updated_by, $updated_at);

				$product_use_and_info = stripslashes($this->input->post('product_use_and_info'));
				$volume_weight = stripslashes($this->input->post('volume_weight'));
				$approx_size_of_package = stripslashes($this->input->post('approx_size_of_package'));

				$this->Japan_ior_model->update_regulated_product_a($data['regulated_product_id'], $ingredients_formula_filename, $product_use_and_info, $outerbox_frontside_filename, $outerbox_backside_filename, $volume_weight, $consumer_product_packaging_img_filename, $approx_size_of_package);

				foreach ($data['reg_product_cust'] as $key => $value) {

					$name_arr = explode(" ", ucwords($value->detail_name));
					$cust_id = '';
					$loop_cnt = 0;
					foreach ($name_arr as $value1) {
						# code...
						if ($loop_cnt > 0) {
							$cust_id = $cust_id . '_' . $value1;
						} else {
							$cust_id = $value1;
						}

						$loop_cnt++;
					}

					if ($value->detail_type == 'input') {
						if ($this->input->post(strtolower($cust_id)) != '') {
							$this->Japan_ior_model->update_regulated_product_one_cust($value->id, $this->input->post(strtolower($cust_id)));
						}
					} else if ($value->detail_type == 'file') {
						if (!empty($_FILES[strtolower($cust_id)]['name'])) {
							$config2['upload_path'] = $upload_path_file2;
							$config2['allowed_types'] = 'pdf|jpg|jpeg|png';
							$config2['max_size'] = 5000000;
							$config2['file_name'] = strtolower($cust_id) . '_' . $current_timestamp;
							$this->upload->initialize($config2);
							if (!$this->upload->do_upload(strtolower($cust_id))) {
								$data['errors'] = 2;
								$data['error_msgs'] = $this->upload->display_errors();
								$data['page_view'] = 'regulated_applications/edit_regulated_products';
								$this->load->view('page', $data);
							} else {
								$cust_file = $config2['file_name'] . $this->upload->data('file_ext');
								$this->Japan_ior_model->update_regulated_product_one_cust($value->id, $cust_file);
							}
						}
					}


					# code...
				}

				$this->session->set_flashdata('success', 'Congratulations! You successfully updated your regulated product.');
				redirect('/japan-ior/edit-regulated-products/' . $data['regulated_product_id'], 'refresh');
			}
		} else {
			$this->session->set_flashdata('modal_product_name_info', 'Product Name Info');
			$data['page_view'] = 'japan_ior/regulated_applications/edit_regulated_products';
			$this->load->view('page', $data);
		}
	}

	public function add_regulated_products_bulk()
	{
		$this->clear_apost();

		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$data['user_id'] = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'regulated_applications';

		$data['regulated_application_id'] = $this->uri->segment(3);

		$q_fetch_reg_application = $this->Japan_ior_model->fetch_reg_application($data['regulated_application_id']);
		$data['reg_application'] = $q_fetch_reg_application->row();
		$product_category_id = $data['reg_application']->product_category_id;
		if (isset($_POST['submit'])) {
			$output = '';
			$read_error = 0;
			$error_arr = array();

			if ($_FILES['zip_file']['name'] != '') {
				$file_name = $_FILES['zip_file']['name'];
				$array = explode(".", $file_name);
				$name = $array[0];
				$ext = $array[1];
				$dir = "uploads/regulated_applications/" . $this->uri->segment(3);
				$prod_qual_dir = "uploads/product_qualification/" . $data['user_id'];
				if (!is_dir($dir)) {
					mkdir($dir, 0755);
				}
				if ($ext == 'zip')  // CHECK IF FILE EXT IS ZIP FORMAT
				{
					$path = $dir . "/";
					$location = $path . $name;
					if (move_uploaded_file($_FILES['zip_file']['tmp_name'], $location)) {
						$zip = new ZipArchive;
						if ($zip->open($location)) {
							$zip->extractTo($path);
							$zip->close();
						}
						$files = scandir($path);
						foreach ($files as $file) {

							$file_ext = explode(".", $file);
							$file_extension = end($file_ext);
							$allowed_ext = array('jpg', 'png', 'csv');
							if (in_array($file_extension, $allowed_ext)) {
								if ($file_extension == 'csv') { // CHECK IF EXT IS CSV FILE
									$row = 1;
									if (($handle = fopen($path . $file, "r")) !== FALSE) {
										while (($datas = fgetcsv($handle, 1000, ",")) !== FALSE) {
											$num = count($datas);

											for ($i = 0; $i < $num; $i++) {
												# code...
												if ($datas[$i] == '') {
													$error_arr_row = array(
														'row' => $row,
														'column' => $i + 1,
														'msg' => 'Data must not null',
													);
													array_push($error_arr, $error_arr_row);
													$read_error++;
												}

												if ($i == 2 || $i == 3 || $i == 6) {
													if (!is_file($path . $datas[$i])) {
														$error_arr_row = array(
															'row' => $row,
															'column' => $i + 1,
															'msg' => 'file ' . $datas[$i] . ' does not exist',
														);
														array_push($error_arr, $error_arr_row);
														$read_error++;
													}
												}
											}

											if (($product_category_id == 3 || $product_category_id == 4 || $product_category_id == 12 || $product_category_id == 13) && $row > 150) {
												$error_arr_row = array(
													'row' => $row,
													'msg' => 'Exceeding limit of 150 products for this category is invalid',
												);
												array_push($error_arr, $error_arr_row);
												$read_error++;
											}

											// else {
											// 	if ($row > 25) {
											// 		$error_arr_row = array(
											// 			'row' => $row,
											// 			'msg' => 'Exceeding limit of 25 products for this category is invalid',
											// 		);
											// 		array_push($error_arr, $error_arr_row);
											// 		$read_error++;
											// 	}
											// }

											$row++;
										}
										fclose($handle);
									}
								}
							}
						}

						if ($read_error == 0) {
							foreach ($files as $file) {

								$file_ext = explode(".", $file);
								$file_extension = end($file_ext);
								$allowed_ext = array('jpg', 'png', 'csv');
								if (in_array($file_extension, $allowed_ext)) {
									if ($file_extension == 'csv') { // CHECK IF EXT IS CSV FILE
										if (($handle = fopen($path . $file, "r")) !== FALSE) {
											while (($datas = fgetcsv($handle, 1000, ",")) !== FALSE) {

												$created_by = $this->session->userdata('user_id');
												$created_at = date('Y-m-d H:i:s');
												$product_reg_id = $this->Japan_ior_model->insert_product_registration_for_bulk_upload($created_by, $this->uri->segment(3), $data['reg_application']->product_category_id, $datas[0], addslashes($datas[1]), $datas[2], $created_by, $created_at);
												if (!is_dir($prod_qual_dir)) {
													mkdir($prod_qual_dir, 0755);
												}

												rename($dir . '/' . $datas[2], $prod_qual_dir . '/' . $datas[2]);

												$result = $this->Japan_ior_model->insert_regulated_product_a($product_reg_id,  $datas[3], $datas[4], $datas[5], $datas[6], $datas[7]);
											}
											fclose($handle);
										}
										unlink($path . $file);
									}
								}
							}
							$this->session->set_flashdata('success', 'Successfully submitted regulated bulk product details!');
							redirect('/japan-ior/add-regulated-products-bulk/' . $this->uri->segment(3), 'refresh');
						} else {
							$this->session->set_flashdata('error', 'ERROR <br>' . json_encode($error_arr) . '<br>UPLOAD FAILED');
							redirect('/japan-ior/add-regulated-products-bulk/' . $this->uri->segment(3), 'refresh');
						}
					}
				} else {
					$this->session->set_flashdata('error', 'File must be a zip format!');
					redirect('/japan-ior/add-regulated-products-bulk/' . $this->uri->segment(3), 'refresh');
				}
			} else {
				$this->session->set_flashdata('error', 'File upload is empty!');
				redirect('/japan-ior/add-regulated-products-bulk/' . $this->uri->segment(3), 'refresh');
			}
		} else {
			$data['page_view'] = 'japan_ior/regulated_applications/add_regulated_products_bulk';
			$this->load->view('page', $data);
		}
	}

	public function submit_pre_import()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$id = $this->input->post('id');

		$manufacturer_details_count = $this->Japan_ior_model->check_manufacturer_details_count($id);
		$regulated_products_count = $this->Japan_ior_model->check_regulated_products_count($id);

		if ($manufacturer_details_count == 0 || $regulated_products_count == 0) {
			echo 0;
		} else {
			$updated_at = date('Y-m-d H:i:s');
			$updated_by = $this->session->userdata('user_id');

			$result = $this->Japan_ior_model->submit_pre_import($id, $updated_at, $updated_by);

			if ($result == 1) {
				echo $result;
			}
		}
	}

	public function cancel_reg_application()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$id = $this->input->post('id');
		$updated_at = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('user_id');

		$result = $this->Japan_ior_model->cancel_reg_application($id, $updated_at, $updated_by);

		if ($result == 1) {
			echo $result;
		}
	}

	public function delete_regulated_product()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$id = $this->input->post('id');
		$updated_at = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('user_id');

		$result = $this->Japan_ior_model->delete_regulated_product($id, $updated_at, $updated_by);

		if ($result == 1) {
			echo $result;
		}
	}

	public function product_test_results()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {

			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_users_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$this->clear_apost();
		$current_timestamp = now();
		$data['external_page'] = 2;
		$data['active_page'] = 'regulated_applications';

		$data['regulated_application_id'] = $this->uri->segment(3);
		$data['user_id'] = $this->session->userdata('user_id');

		$q_user_details = $this->Japan_ior_model->fetch_users_by_id($data['user_id']);
		$data['user_details'] = $q_user_details->row();

		$q_fetch_manufacturer_details = $this->Japan_ior_model->fetch_manufacturer_details($data['regulated_application_id']);
		$data['manufacturer_details'] = $q_fetch_manufacturer_details->row();

		$q_fetch_reg_application = $this->Japan_ior_model->fetch_reg_application($data['regulated_application_id']);
		$data['reg_application'] = $q_fetch_reg_application->row();

		$q_fetch_reg_products = $this->Japan_ior_model->fetch_regulated_products($data['regulated_application_id']);
		$data['reg_products'] = $q_fetch_reg_products->result();

		$q_fetch_countries = $this->Japan_ior_model->fetch_countries();
		$data['countries'] = $q_fetch_countries->result();

		$data['page_view'] = 'japan_ior/regulated_applications/product_test_results';

		$current_timestamp = now();
		$upload_path_file = 'uploads/regulated_applications/' . $data['reg_application']->regulated_application_id;

		if (isset($_POST['upload_test_result'])) {
			if (!file_exists($upload_path_file)) {
				mkdir($upload_path_file, 0777, true);
			}

			$config['upload_path'] = $upload_path_file;
			$config['allowed_types'] = 'pdf|jpg|jpeg|png';
			$config['max_size'] = 5000000;
			$config['file_name'] = 'test_result_' . $current_timestamp;

			$this->upload->initialize($config);

			if (!$this->upload->do_upload('test_result')) {
				$data['errors'] = 2;
				$data['error_msgs'] = $this->upload->display_errors();
				$data['page_view'] = 'japan_ior/regulated_applications/product_test_results';
				$this->load->view('page', $data);
			} else {
				$product_registration_id_upload = stripslashes($this->input->post('product_registration_id_upload'));
				$test_result_filename = $config['file_name'] . $this->upload->data('file_ext');
				$updated_by = $this->session->userdata('user_id');
				$updated_at = date('Y-m-d H:i:s');

				$result = $this->Japan_ior_model->insert_test_result($product_registration_id_upload, $test_result_filename, $updated_by, $updated_at);

				if ($result == 1) {
					$this->session->set_flashdata('success', 'Successfully added Lab/Product Test Result!');
					redirect('/japan_ior/product_test_results/' . $data['regulated_application_id'], 'refresh');
				} else {
					$this->session->set_flashdata('error', 'Sorry for the inconvenience! Some errors found. Please contact our administrator through livechat or email.');
					redirect('/japan_ior/product_test_results/' . $data['regulated_application_id'], 'refresh');
				}
			}
		} else if (isset($_POST['delete_test_result'])) {
			$product_registration_id_delete = stripslashes($this->input->post('product_registration_id_delete'));
			$updated_by = $this->session->userdata('user_id');
			$updated_at = date('Y-m-d H:i:s');

			$result = $this->Japan_ior_model->remove_test_result($product_registration_id_delete, $updated_by, $updated_at);

			if ($result == 1) {
				$this->session->set_flashdata('success', 'Successfully deleted Lab/Product Test Result!');
				redirect('/japan_ior/product_test_results/' . $data['regulated_application_id'], 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Sorry for the inconvenience! Some errors found. Please contact our administrator through livechat or email.');
				redirect('/japan_ior/product_test_results/' . $data['regulated_application_id'], 'refresh');
			}
		} else {
			$this->load->view('page', $data);
		}
	}

	public function billing_invoices()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'billing_invoices';
		$data['page_view'] = 'japan_ior/billing_invoices/billing_invoices';

		$data['user_id'] = $this->session->userdata('user_id');

		$q_user_details = $this->Japan_ior_model->fetch_users_by_id($data['user_id']);
		$data['user_details'] = $q_user_details->row();

		$q_billing_invoices = $this->Japan_ior_model->fetch_billing_invoices($data['user_id']);
		$data['billing_invoices'] = $q_billing_invoices->result();

		$data['billing_invoices_unpaid_count'] = $this->Japan_ior_model->fetch_billing_invoices_unpaid($data['user_id']);

		$this->load->view('page', $data);
	}

	public function billing_invoice()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'billing_invoices';
		$data['page_view'] = 'japan_ior/billing_invoices/billing_invoice';

		$data['user_id'] = $this->session->userdata('user_id');
		$id = $this->uri->segment(3);

		// Get System Settings data from the database
		$q_system_settings = $this->Japan_ior_model->fetch_system_settings();
		$data['system_settings'] = $q_system_settings->row();

		$q_user_details = $this->Japan_ior_model->fetch_users_by_id($data['user_id']);
		$data['user_details'] = $q_user_details->row();

		$q_country = $this->Japan_ior_model->fetch_country_by_id($data['user_details']->country);
		$data['country_name'] = $q_country->row();

		$q_ior_reg_fee = $this->Japan_ior_model->fetch_product_offer(1);
		$data['ior_reg_fee'] = $q_ior_reg_fee->row();

		$q_pli_fee = $this->Japan_ior_model->fetch_product_offer(2);
		$data['pli_fee'] = $q_pli_fee->row();

		$q_user_payment_invoice = $this->Japan_ior_model->fetch_user_payment_invoice($id);
		$data['user_payment_invoice'] = $q_user_payment_invoice->row();

		$q_user_payment_invoice_product_label = $this->Japan_ior_model->fetch_user_payment_invoice_product_label($id);
		$data['user_payment_invoice_product_label'] = $q_user_payment_invoice_product_label->row();

		$fee_id =  $data['user_payment_invoice']->pricing_fee_id;

		$q_product_pricing_fee = $this->Japan_ior_model->fetch_product_pricing_fee($fee_id);
		$data['product_pricing_fee'] = $q_product_pricing_fee->row();

		$q_fetch_reg_products = $this->Japan_ior_model->fetch_regulated_products($data['user_payment_invoice']->regulated_label_id);
		$data['req_products_cnt'] =  $q_fetch_reg_products->num_rows();
		$q_total_mailing_price = $this->Japan_ior_model->get_total_mailing_price($id);
		$data['total_mailing_price'] = $q_total_mailing_price->result();
		$this->load->view('page', $data);
	}

	public function billing_invoice_checkout()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		}

		$id = $this->uri->segment(3);
		$user_id = $this->session->userdata('user_id');

		$q_billing_invoice = $this->Japan_ior_model->fetch_billing_invoice($id);
		$billing_invoice = $q_billing_invoice->row();

		$q_billing_invoice_product_label = $this->Japan_ior_model->fetch_billing_invoice_product_label($id);
		$billing_invoice_product_label = $q_billing_invoice_product_label->row();

		if ($billing_invoice->register_ior == 1) {
			$returnURL = base_url() . 'japan-ior/ior-success';
		} else {
			$returnURL = base_url() . 'japan-ior/billing-invoice-success';
		}

		$cancelURL = base_url() . 'japan-ior/billing-invoice-cancel';
		$notifyURL = base_url() . 'japan-ior/ipn';

		// Get System Settings data from the database
		$q_system_settings = $this->Japan_ior_model->fetch_system_settings();
		$system_settings = $q_system_settings->row();

		$product_name = '';

		if ($billing_invoice->register_ior == 1) {
			$q_ior_reg_fee = $this->Japan_ior_model->fetch_product_offer(1);
			$ior_reg_fee = $q_ior_reg_fee->row();

			$product_name .= $ior_reg_fee->name;
		}

		if ($billing_invoice->register_ior == 1 && $billing_invoice->pli_sub == 1) {
			$product_name .= ', ';
		}

		if ($billing_invoice->pli_sub == 1) {
			$q_pli_fee = $this->Japan_ior_model->fetch_product_offer(2);
			$pli_fee = $q_pli_fee->row();

			$product_name .= $pli_fee->name;
		}

		if ($billing_invoice->shipping_invoice_id != 0) {

			$q_user_payment_invoice = $this->Japan_ior_model->fetch_user_payment_invoice($id);
			$data['user_payment_invoice'] = $q_user_payment_invoice->row();
			$fee_id =  $data['user_payment_invoice']->pricing_fee_id;
			$q_product_pricing_fee = $this->Japan_ior_model->fetch_product_pricing_fee($fee_id);
			$product_pricing_fee = $q_product_pricing_fee->row();

			$product_name .= 'Shipping Products - ' . $product_pricing_fee->ior_shipment_fees;
		}

		if ($product_name != '' && $billing_invoice->product_offer_id != 0) {
			$product_name .= ', ';
		}

		if ($billing_invoice->product_offer_id != 0) {
			$q_product_offer = $this->Japan_ior_model->fetch_product_offer($billing_invoice->product_offer_id);
			$product_offer = $q_product_offer->row();

			$product_name .= $product_offer->name;
		}

		if ($billing_invoice->regulated_label_id != 0) {


			$product_name .= $billing_invoice_product_label->category_name;
		}

		\Stripe\Stripe::setApiKey($system_settings->stripe_secret_key);
		header('Content-Type: application/json');
		$checkout_session = \Stripe\Checkout\Session::create([
			'payment_method_types' => ['card'],
			'line_items' => [[
				'price_data' => [
					'currency' => 'usd',
					'unit_amount' => (number_format($billing_invoice->total, 2, '.', '') * 100),
					'product_data' => [
						'name' =>   $product_name,
						'images' => ["https://www.covueior.com/assets/img/covue_main_logo.png"],
					],
				],
				'quantity' => 1,
			]],
			'mode' => 'payment',
			'success_url' => $returnURL,
			'cancel_url' => $cancelURL,
			'client_reference_id' => $user_id . '|' . $id . '|1'
		]);
		echo json_encode(['id' => $checkout_session->id]);
	}

	public function billing_invoice_success()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'billing_invoices';

		$data['user_id'] = $this->session->userdata('user_id');

		$q_user_details = $this->Japan_ior_model->fetch_users_by_id($data['user_id']);
		$data['user_details'] = $q_user_details->row();

		$data['page_view'] = 'japan_ior/billing_invoices/billing_invoice_success';
		$this->load->view('page', $data);
	}

	public function billing_invoice_cancel()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'billing_invoices';

		$data['user_id'] = $this->session->userdata('user_id');

		$q_user_details = $this->Japan_ior_model->fetch_users_by_id($data['user_id']);
		$data['user_details'] = $q_user_details->row();

		$data['page_view'] = 'japan_ior/billing_invoices/billing_invoice_cancel';
		$this->load->view('page', $data);
	}

	public function billing_invoice_print()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'billing_invoices';

		$data['user_id'] = $this->session->userdata('user_id');
		$id = $this->uri->segment(3);

		$q_user_details = $this->Japan_ior_model->fetch_users_by_id($data['user_id']);
		$data['user_details'] = $q_user_details->row();

		$q_country = $this->Japan_ior_model->fetch_country_by_id($data['user_details']->country);
		$data['country_name'] = $q_country->row();

		$q_ior_reg_fee = $this->Japan_ior_model->fetch_product_offer(1);
		$data['ior_reg_fee'] = $q_ior_reg_fee->row();

		$q_pli_fee = $this->Japan_ior_model->fetch_product_offer(2);
		$data['pli_fee'] = $q_pli_fee->row();

		$q_user_payment_invoice = $this->Japan_ior_model->fetch_user_payment_invoice($id);
		$data['user_payment_invoice'] = $q_user_payment_invoice->row();

		$fee_id =  $data['user_payment_invoice']->pricing_fee_id;

		$q_product_pricing_fee = $this->Japan_ior_model->fetch_product_pricing_fee($fee_id);
		$data['product_pricing_fee'] = $q_product_pricing_fee->row();

		$this->load->view('billing_invoices/billing_invoice_print', $data);
	}

	public function delete_billing_invoice()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		}

		$id = $this->input->post('id');
		$updated_at = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('user_id');

		$result = $this->Japan_ior_model->delete_billing_invoice($id, $updated_at, $updated_by);

		echo $result;
	}

	public function ior_success()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'billing_invoices';

		$user_id = $this->session->userdata('user_id');

		$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
		$data['user_details'] = $q_user_details->row();

		$data['page_view'] = 'japan_ior/billing_invoices/ior_success';
		$this->load->view('page', $data);
	}

	public function payment_cancelled()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'billing_invoices';

		$user_id = $this->session->userdata('user_id');

		$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
		$data['user_details'] = $q_user_details->row();

		$data['page_view'] = 'japan_ior/billing_invoices/payment_cancelled';
		$this->load->view('page', $data);
	}

	public function helpful_links()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'helpful_links';

		$data['page_view'] = 'japan_ior/index/helpful_links';
		$this->load->view('page', $data);
	}

	public function ior_manual_guide()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'helpful_links';

		$data['page_view'] = 'japan_ior/index/ior_manual_guide';
		$this->load->view('page', $data);
	}

	public function shipping_invoice_docs()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'helpful_links';

		$data['page_view'] = 'japan_ior/index/shipping_invoice_docs';
		$this->load->view('page', $data);
	}

	public function product_labelling_compliance()
	{
		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			$user_id = $this->session->userdata('user_id');

			$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
			$data['user_details'] = $q_user_details->row();

			if ($data['user_details']->ior_registered != '1' && $data['user_details']->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		$data['external_page'] = 2;
		$data['active_page'] = 'helpful_links';

		$data['page_view'] = 'japan_ior/index/product_labelling_compliance';
		$this->load->view('page', $data);
	}

	public function get_zoho_logistics($company_name){
		$client_id ='1000.ZCWLXFP9952W2HBEOJHV2OPRI7P9TX';//Enter your Client ID here
        $client_secret = '3e80beb431890c908d29186e069fdaac31e52abe91';//Enter your Client Secret here
        $code = '1000.9589afca7a8be967eab9b7d3f4ff8042.9afbe83bf41911eab0d8d0fcdfff606a';//Enter your Code here
        $base_acc_url = 'https://accounts.zoho.com';
        $service_url = 'https://creator.zoho.com';

        $refresh_token = '1000.c75e998d0adc76bf68573cee147e2e8a.77635c78d0c75cb35fab078b0f2cb1f6';

        $access_token_url = $base_acc_url .  '/oauth/v2/token?refresh_token='.$refresh_token.'&client_id='.$client_id.'&client_secret='.$client_secret .'&grant_type=refresh_token';

        $access_token = $this->generate_access_token($access_token_url);
        // var_dump($access_token);
        $result = $this->search_record($access_token,$company_name);

        return $result;
	}

	function search_record($access_token,$account_name){

		$curl_pointer = curl_init();
        
        $curl_options = array();
        $url = "https://www.zohoapis.com/crm/v2/Logistics/search?";
        $parameters = array();

        $parameters["criteria"]='(Name:equals:'.urlencode($account_name).')';
        
        foreach ($parameters as $key=>$value){
            $url =$url.$key."=".$value."&";
        }
        $curl_options[CURLOPT_URL] = $url;
        $curl_options[CURLOPT_RETURNTRANSFER] = true;
        $curl_options[CURLOPT_HEADER] = 1;
        $curl_options[CURLOPT_CUSTOMREQUEST] = "GET";
        $headersArray = array();
        $headersArray[] = "Authorization". ":" . "Zoho-oauthtoken " . $access_token;
        $headersArray[] = "Content-Type". ":" . "application/x-www-form-urlencoded";
        $curl_options[CURLOPT_HTTPHEADER]=$headersArray;
        
        curl_setopt_array($curl_pointer, $curl_options);
        
        $result = curl_exec($curl_pointer);
        $responseInfo = curl_getinfo($curl_pointer);
        curl_close($curl_pointer);
        list ($headers, $content) = explode("\r\n\r\n", $result, 2);
        if(strpos($headers," 100 Continue")!==false){
            list( $headers, $content) = explode( "\r\n\r\n", $content , 2);
        }
        $headerArray = (explode("\r\n", $headers, 50));
        $headerMap = array();
        foreach ($headerArray as $key) {
            if (strpos($key, ":") != false) {
                $firstHalf = substr($key, 0, strpos($key, ":"));
                $secondHalf = substr($key, strpos($key, ":") + 1);
                $headerMap[$firstHalf] = trim($secondHalf);
            }
        }
        $jsonResponse = json_decode($content, true);
        if ($jsonResponse == null && $responseInfo['http_code'] != 204) {
            list ($headers, $content) = explode("\r\n\r\n", $content, 2);
            $jsonResponse = json_decode($content, true);

            return 'error';
        }else{
        	if(empty($jsonResponse)){
        		return 'false';
        	}else{
        		return json_encode($jsonResponse);
        	}
        	
        }

        
    }

    function add_logistic($street,$address_line_2,$city,$state,$postal,$country_1,$company_name,$id,$link,$shipping_invoice_id,$shipping_code){
    	
		$this->Japan_ior_model->create_zoho_logistic($street,$address_line_2,$city,$state,$postal,$country_1,$company_name,$id,$link);
		$this->Japan_ior_model->create_zoho_inventory_system($shipping_invoice_id,$company_name,$id,$shipping_code);
	
    }

	function generate_access_token($url){

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, 1);
      $result = curl_exec($ch);
      curl_close($ch);
      return json_decode($result)->access_token;
    }

	public function terms_agreement()
	{
		$user_id = $this->session->userdata('user_id');

		$q_user_details = $this->Japan_ior_model->fetch_user_by_id($user_id);
		$user_details = $q_user_details->row();

		if (!$this->logged_in_external()) {
			$this->session->set_flashdata('noaccess', 'You don\'t have authorization to view this page!');
			redirect('/home/login');
		} else {
			if ($user_details->ior_registered != '1' && $user_details->pli != '1') {
				redirect('/japan-ior/product-services-fee');
			}
		}

		if (!empty($user_details->updated_at)) {
			$date_updated = date('F j, Y', strtotime($user_details->updated_at));
		} else {
			$date_updated = date('F j, Y', strtotime($user_details->created_at));
		}

		$q_country = $this->Japan_ior_model->fetch_country_by_id($user_details->country);
		$country = $q_country->row();

		$q_product_registration = $this->Japan_ior_model->fetch_product_registrations_approved($user_id);
		$product_registrations = $q_product_registration->result();

		$pdf = new TCPDF_TERMS(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Covue Japan');
		$pdf->SetTitle('IOR Registration Terms and Condition');
		$pdf->SetSubject('Covue IOR');
		$pdf->SetKeywords('IOR registration, Terms and Conditions, Agreement');

		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

		$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		$pdf->SetFont('cid0jp', '', 12);

		$pdf->AddPage();

		$pdf->Ln(10);
		$pdf->Cell(40, 10, $user_details->company_name);
		$pdf->Ln(5);
		$pdf->Cell(40, 10, $user_details->company_address);
		$pdf->Ln(5);
		$pdf->Cell(40, 10, $user_details->city . ', ' . $country->nicename . ', ' . $user_details->zip_code);
		$pdf->Ln(5);
		$pdf->Cell(40, 10, $user_details->contact_number);
		$pdf->Ln(10);
		$pdf->Cell(40, 10, 'Business License #: ' . $user_details->business_license);
		$pdf->Ln(5);
		$pdf->Cell(40, 10, 'Contact Person: ' . $user_details->contact_person);
		$pdf->Ln(5);
		$pdf->Cell(40, 10, 'Contact Email: ' . $user_details->email);

		$pdf->SetY(90);
		$pdf->SetFont('cid0jp', '', 12);

		$pdf->SetFont('cid0jp', 'B', 14);
		$pdf->Cell(40, 10, 'Importer of Record - IOR');
		$pdf->SetFont('cid0jp', '', 10);
		$pdf->Ln(10);
		$pdf->Cell(40, 10, 'Company Name: COVUE JAPAN K.K');
		$pdf->Ln(5);
		$pdf->Cell(40, 10, 'Japan Customs Number: P002AK300000');
		$pdf->Ln(5);
		$pdf->Cell(70, 10, 'Address: 3/F, 1-6-19 Azuchimachi Chou-ku,');
		$pdf->Ln(5);
		$pdf->Cell(40, 10, 'Osaka, Japan 541-0052 Japan');
		$pdf->Ln(5);
		$pdf->Cell(40, 10, 'Phone Number: +81 (50) 8881-2699');

		$pdf->SetY(140);

		$agreement = <<<EOD
		<h3>COVUE JAPAN IMPORT OF RECORD AGREEMENT</h3>

		<p>This COVUE JAPAN K.K. (“CJ”) Import of Record Agreement, includes the following optional Services, which are “Service(s)” offered by CJ for SELLER(S): (A) Import of Record (“IOR”) Registration of Non-Regulated or Regulated Products Approved by CJ; (B) Order Fulfillment, Storage and Shipping; and (C) Special Services: Import Application, Regulatory and Compliance Consulting; Product Testing and Inspection; Translation Services; or Warranty Support.
		CJ Import of Record Agreement (“Agreement“) contains the terms and conditions that govern Seller use of the Services and Seller agrees to be bound by the terms of this Agreement.  In this Agreement, “we, “our” or “us,” means CJ any of its applicable Affiliates, and “Seller(s)” means the applicant (if registering for or using a Service as an individual or entity) and any of its Affiliates.  “Affiliates” mean any related entity representing or doing business with CJ on behalf of the Seller.</p>
		
		<p><strong>1.	 Registration.</strong></p>
		<p>Seller must complete the online registration process for one or more of the services. As part of the application, Seller must provide us with the legal name, address, phone number and e-mail address, as well as any other information we may request.</p>
		
		<p><strong>2.	 Service Fee Payments.</strong></p>
		<p>Fee details are described online or on the invoice which shall be non-refundable, non-prorated and pre-paid prior to any start of Service. Service fees pricing are subject to change. Seller are responsible for all of Seller fees and expenses in connection with this Agreement. To use a Service, Seller must provide us with valid credit card information from a credit card or credit cards acceptable by CJ or valid bank account information for a bank account or bank accounts acceptable by CJ (conditions for acceptance may be modified or discontinued by us at any time without notice). Seller will use only a name Seller are authorized to use in connection with a Service and will update all of the information Seller provide to us in connection with the Services as necessary to ensure that it at all times remains accurate, complete, and valid. Seller authorize us (and will provide us documentation evidencing Seller authorization upon our request) to verify Seller information (including any updated information), to obtain credit authorizations from the issuer of Seller credit card, and to charge Seller credit card or debit Seller bank account for any sums payable by Seller to us.  All amounts in this Agreement are displayed in United States Dollars or Japanese Yen.  In addition, we may require that Seller pay other amounts to secure the performance of Seller obligations under this Agreement or to mitigate the risk of returns, chargebacks, claims, disputes, violations of our terms or policies, or other risks to CJ or third parties.</p>
		
		<p><strong>3.	 Term and Termination.</strong></p>
		<p>The term of this Agreement will start on the date of Seller completed registration with full payment for use of a Service and continue until terminated by us or Seller as provided below. Seller may at any time terminate Seller use of any Service upon Thirty (30) days notice by email or other written means. We may terminate Seller use of any Services or terminate this Agreement for convenience immediately with no advance notice. We may suspend or terminate Seller use of any Services immediately if we determine that (a) Seller have materially breached the Agreement and failed to cure within one (1) day of a cure notice unless Seller breach exposes us to liability toward a third party, in which case we are entitled to reduce, or waive, the aforementioned cure period at our reasonable discretion; (b) Seller account has been, or our controls identify that it may be used for deceptive or fraudulent, or  illegal activity; or (c) Seller use of the Services has harmed, or our controls identify that it might harm, other sellers, customers, or CJ’s legitimate interests. We will promptly notify Seller of any such termination or suspension via email or similar written means including, indicating the reason and any options to appeal, except where we have reason to believe that providing this information will hinder the investigation or prevention of deceptive, fraudulent, or illegal activity, or will enable Seller to circumvent our safeguards. On termination of this Agreement, all related rights and obligations under this Agreement immediately terminate, except that (d) Seller will remain responsible for performing all of Seller obligations in connection with transactions entered into before termination and for any liabilities that accrued before or as a result of termination (for example, liability for storage fees shall accrue until the product is completely removed from the storage site), and (e) all these Terms survive merger or acquisition.</p>
		
		<p><strong>4.	 Representations.</strong></p>
		<p>Each party represents and warrants that: (a) if it is a business, it is duly organized, validly existing and in good standing under the laws of the country in which the business is registered and that Seller are registering for the Service(s) within such country; (b) it has all requisite right, power, and authority to enter into this Agreement, perform its obligations, and grant the rights, licenses, and authorizations in this Agreement; (c) any information provided or made available by one party to the other party or its Affiliates is at all times accurate and complete; (d) it is not subject to sanctions by Japan; (e) it will comply with all applicable laws in performance of its obligations and exercise of its rights under this Agreement; (f) Seller have valid legal title to all products and all necessary rights to distribute the products; (g) Seller will deliver all products to us in new condition and in a merchantable condition; (h) all products and their packaging will comply with all applicable marking, labeling, and other requirements required by Japan law; and (i) product can be lawfully imported into, and comply with Japan law.</p>
		
		<p><strong>5.	 Indemnification.</strong></p>
		<p>Seller will defend, indemnify, and hold harmless CJ, and our officers, directors, employees, and agents, against any third-party claim, loss, damage, settlement, cost, expense, or other liability (including, without limitation, attorneys’ fees) (each, a “Claim”) arising from or related to (a) Seller non-compliance with applicable Laws; (b) Seller products, including the offer, sale, refund, cancellation, return, or adjustments thereof, Seller material, any actual or alleged infringement of any intellectual property rights; such as, any technology, patent, copyright, trademark, domain name, moral right, trade secret right, or any other intellectual property right arising under any Laws by any of the foregoing, and any personal injury, death (to the extent the injury or death is not caused by CJ), or property damage related thereto; (c) Seller taxes and duties or the collection, payment, or failure to collect or pay Seller taxes which includes any and all sales, goods and services, use, excise, premium, import, export, value added, consumption, and other taxes, regulatory fees, levies (specifically including environmental levies), or charges and duties assessed, incurred, or required to be collected or paid for any reason, or the failure to meet tax registration obligations or duties; or (d) actual or alleged breach of any representations Seller have made.  Seller automatically authorizes CJ to charge Seller’s credit card without additional authorization and Seller agrees to fully pay any and all taxes, duties, penalties and related fees or costs related to Seller’s failure to pay the above mentioned liabilities if CJ had to pay those liabilities on behalf of the Seller.</p>
		
		<p><strong>6.	 Disclaimer & General Release.</strong></p>
		<p>a.	CJ website and Services, including all content, software, functions, materials, and information made available on or provided in connection with the services, are provided “as-is.”  As a user of the Services and CJ’s website, at Seller’s own risk. To the fullest extent permissible by law, CJ and CJ’s Affiliates disclaim: (i) any representations or warranties regarding this Agreement, the Services or the transactions contemplated by this Agreement, including any implied warranties of merchantability, fitness for a particular purpose, or non-infringement; (ii) implied warranties arising out of course of dealing, course of performance, or usage of trade; and (iii) any obligation, liability, right, claim, or remedy in tort, whether or not arising from our negligence.  We do not warrant that the functions contained in the CJ website and the Services will meet Seller requirements or be available, timely, secure, uninterrupted, or error free, and we will not be liable for any service interruptions, including but not limited to system failures or interruptions that may affect the receipt, processing, acceptance, completion, or settlement of any transactions.
		<p>b.	CJ disclaims any duties of a bailee or storage person, and Seller waives all rights and remedies of a bailor (whether arising under common law or otherwise), related to or arising out of any possession, storage, or shipment of Seller’s products by CJ, CJ’s Affiliates or any of CJ’s contractors or agents.</p>
		
		<p>c.	Since CJ is not involved in transactions between the Seller and Seller’s customers, if a dispute arises between the Seller and Seller’s customers, Seller and Seller’s customers releases CJ (and its agents and employees) from claims, demands, and damages (actual and consequential) of every kind and nature, known and unknown, suspected and unsuspected, disclosed and undisclosed, arising out of or in any way connected with such disputes.</p>
		
		<p>d.	Seller, on behalf of Seller and any successors, subsidiaries, Affiliates, officers, directors, shareholders, employees, assigns, and any other person or entity claiming by, under, or in concert with them (collectively, the “Releasing Parties”), irrevocably acknowledge full and complete satisfaction of and unconditionally and irrevocably release and forever fully discharge CJ and each of our Affiliates, and any and all of our and their predecessors, successors, and Affiliates, past and present, as well as each of our and their partners, officers, directors, shareholders, agents, employees, representatives, attorneys, and assigns, past and present, and each of them and all Persons acting by, under, or in concert with any of them (collectively, the “Released Parties”), from any and all claims, obligations, demands, causes of action, suits, damages, losses, debts, or rights of any kind or nature, whether known or unknown, suspected or unsuspected, absolute or contingent, accrued or unaccrued, determined or speculative (collectively, “Losses”) which the Releasing Parties now own or hold or at any time have owned or held or in the future may hold or own against the Released Parties, or any of them, arising out of, resulting from, or in any way related to the shipment or delivery of Seller’s products to Seller’s shipping destination or customer, including any tax registration or collection obligations.</p>
		
		<p><strong>7.	 Limitation of Liability.</strong></p>
		<p>CJ shall not be liable (whether in contract, warranty, tort (including negligence, product liability, or other theory), or otherwise) to Seller or any other person or entity for cost of cover, recovery, or recoupment of any investment made by Seller or Seller’s Affiliates in connection with this Agreement, or for any loss of profit, revenue, business, or data or punitive or consequential damages arising out of or relating to this Agreement, even if CJ has been advised of the possibility of those costs or damages.  Further, CJ’s aggregate liability arising out of or in connection with this Agreement or the transactions contemplated will not exceed at any time the amounts paid by Seller during the prior month to CJ in connection with the particular service giving rise to the claim.</p>
		
		<p><strong>8.	  Insurance.</strong></p>
		<p>Seller will maintain at Seller expense commercial general, umbrella or liability insurance per occurrence and in aggregate covering liabilities caused by or occurring in conjunction with the operation of Seller business, including products, products/completed operations and bodily injury, with policy naming CJ and its assignees as additional insureds. At our request, Seller will provide to us certificates of insurance for the coverage.
		Seller agrees to pay CJ’s Product Liability Insurance fee for additional liability risk to CJ related to Seller’s product. This Product Liability Insurance fee does not cover the Seller’s liability obligations.</p>
		
		<p><strong>9.	 Force Majeure.</strong></p>
		<p>We will not be liable for any delay or failure to perform any of our obligations under this Agreement by reasons, events or other matters beyond our control; including, but limited to Acts of God, war, pandemic, cyber hack, or terrorism.</p>
		
		<p><strong>10.	Relationship of Parties.</strong></p>
		<p>CJ and Seller are independent contractors, and nothing in this Agreement will create any partnership, joint venture, agency, franchise, sales representative, or employment relationship between us. Seller will have no authority to make or accept any offers or representations on our behalf. This Agreement will not create an exclusive relationship between Seller and us. Nothing expressed or mentioned in or implied from this Agreement is intended or will be construed to give to any person other than the parties to this Agreement any legal or equitable right, remedy, or claim under or in respect to this Agreement. This Agreement and all of the representations, warranties, covenants, conditions, and provisions in this Agreement are intended to be and are for the sole and exclusive benefit of CJ, Seller, and customers. As between Seller and us, Seller will be solely responsible for all obligations associated with the use of any third party service or feature that Seller permit us to use on Seller behalf, including compliance with any applicable terms of use. Seller will not make any statement, whether on Seller site or otherwise, that would contradict anything in this section.</p>
		
		<p><strong>11.	  Modification.</strong></p>
		<p>We may change or modify the Agreement at any time with immediate effect (a) for legal, regulatory, fraud and abuse prevention, or security reasons; (b) to change existing features or add additional features to the Services (where this does not materially adversely affect Seller use of the Services); or (c) to restrict products or activities that we deem unsafe, inappropriate, or offensive. Seller continued use of the Services after the effective date of any change to this Agreement will constitute Seller acceptance of that change. If any change is unacceptable to Seller, Seller agree not to use the Services and give notice of cancellation.</p>
		
		<p><strong>12.	Miscellaneous.</strong></p>
		<p>Japan laws will govern this Agreement, without reference to rules governing choice of laws or the Convention on Contracts for the International Sale of products.  Seller may not assign this Agreement, by operation of law or otherwise, without our prior written consent. Any attempt to assign or otherwise transfer in violation of this section is void; provided, however, that upon notice to CJ, Seller may assign or transfer this Agreement, in whole or in part, to any of Seller Affiliates as long as Seller remain liable for Seller obligations that arose prior to the effective date of the assignment or transfer under this Agreement. Seller agree that we may assign or transfer our rights and obligations under this Agreement: (a) in connection with a merger, consolidation, acquisition or sale of all or substantially all of our assets or similar transaction; or (b) to any Affiliate or as part of a corporate reorganization; and effective upon such assignment, the assignee is deemed substituted for CJ as the party to this Agreement. Subject to that restriction, this Agreement will be binding on, inure to, and be enforceable against the parties and their respective successors and assigns. We may perform any of our obligations or exercise any of our rights under this Agreement through one or more of our Affiliates. CJ retains the right to immediately halt any of Seller transactions, prevent or restrict access to the Services or take any other action to restrict access to or availability of any inaccurate listing, any inappropriately categorized items, any unlawful items, or any items otherwise prohibited.  If any provision of this Agreement is deemed unlawful, void, or for any reason unenforceable, then that provision will be deemed severable from these terms and conditions and will not affect the validity and enforceability of any remaining provisions. This Agreement represents the entire agreement between the parties with respect to the Services and related subject matter and supersedes any previous or contemporaneous oral or written agreements and understandings.</p>
		
		
		<p><strong>A. Import of Record (“IOR”) Registration of Non-Regulated or Regulated Products Approved by CJ.</strong></p>
		<p>Seller registers and pays for the CJ Import of Record Service(s) online and follows the instructions described online. Seller shall provide complete and accurate information in order to determine if the product that is registered is an approved regulated or non-regulated product according to Japan law. CJ confirms the Seller’s product is approved prior to allowing Seller to use CJ’s Import of Record license or services. CJ is not a customs broker; thus, CJ only assists with the registration of the Seller’s products to be imported and not other documentation. Only CJ approved products can be shipped. CJ is not responsible if unauthorized products are shipped. The non-regulated product registration process is different from the regulated product registration process. The regulated product registration process may require additional health and safety laboratory testing, labeling, documentation, insurance, fees, or licenses from the relevant Japan government. The following imported products are regulated: cosmetics, supplements, skin care, quasi-drugs (vitamins), food apparatus, class 1 medical device products and Cannabidiol (“CBD”) products. CJ does not offer services for hazardous, perishable or refrigerated or frozen products.
		CJ is not responsible for products that are delayed or banned in customs if the Seller fails to fully pay the proper fees, undervalue the imported products, unlawfully use CJ’s Import of Record license without payment for each shipment or product, or comply with any instructions provided by CJ or Japanese laws. If the Seller is not sure whether or not the product to be imported is regulated or non-regulated; then Seller can pay for CJ’s product validation fee. CJ charges a non-refundable product import validation fee which covers the research to validate with the Japanese government whether a product is regulated or non-regulated and whether the product can be imported or not.
		CJ only accepts the Incoterms: Delivered Duties and Taxes Paid (“DDP”). If the Seller ships the product different from DDP, CJ may decide not to accept the product or charge additional customs recovery, delivery, duties or penalty taxes or fees. Seller agrees for CJ to automatically charge Seller’s credit card on file or recoup from the Seller’s online facilitator any fees, taxes, and costs to expedite the customs and delivery process. CJ will notify Japan government after all fees and costs are paid to approve the accurate shipping invoice and allow the product to be delivered. CJ is not responsible if the imported product is rejected by the Japan government if the Seller changes the invoice after CJ approves the shipping invoice that is submitted to the Japan government. The shipping invoice quantity, quality, description, weight, size and value of the product must exactly match all the import documentation and the actual imported product that is received. CJ is not liable for damage or loss of the product before, during or after shipment from CJ’s office or storage sites. The Japan government and CJ may inspect the product to confirm it is in compliance with the import documentation; including labeling in Japanese language, product testing, product tracking and reporting to the Japan government.</p>
		
		<p><strong>B. Order Fulfillment, Storage and Shipping Services.</strong></p>
		<p>Seller shall provide accurate and complete information to register online for Order Fulfillment, Storage and Shipping Services. Order Fulfillment fee will apply whenever a product enters or exits CJ’s office or storage site and handled for distribution or release, unpacked, assembled, packed, labeled, whenever physical inventory is requested by Seller, or whenever additional handling service is requested.
		Seller will be responsible for all costs incurred to ship the product to CJ’s office, storage site or Seller’s chosen shipping destination (including costs of freight and transit insurance) and CJ will not pay any shipping costs. Seller is responsible for payment of all customs, duties, taxes, and other charges. In the case of any improperly packaged or labeled product, we may return it to Seller at Seller’s expense or re-package or re-label the product and charge Seller an administrative fee. Seller must receive approval from CJ prior to shipping the product and CJ may refuse any damaged, incomplete, or unapproved product from Seller.
		Seller may request CJ to use the Seller’s chosen shipping company or Seller may use CJ’s Shipping Service to ship Seller’s product within Japan. CJ shall charge a non-refundable Shipping fee to be determined based on size, weight and destination address, insurance (if applicable), and handling fee. Seller must provide accurate and complete detailed written instructions for order fulfillment and shipping address. Seller must provide labels, tools, packing containers and packing materials for packing, unpacking, assembling, disassembling, and labeling of product for order fulfillment and shipping.
		Seller may request Storage Service from CJ. CJ will keep records that track inventory of Seller’s products. If there is a loss of or damage to any products while they are being stored, CJ may replace or repair the product as Seller’s sole compensation. At all other times, Seller will be solely responsible for any loss of, or damage to, any Seller’s products. Our confirmed receipt of delivery does not: (a) indicate or imply that any product has been delivered free of loss or damage, or that any loss or damage to any product later discovered occurred after confirmed receipt of delivery; (b) indicate or imply that we actually received the number of products specified by Seller for such shipment; or (c) waive, limit, or reduce any of our rights under this Agreement.
		Seller warrants that the products are properly marked, packaged, labeled and classified for handling and are fit for safe storage. CJ will not accept products that are not properly packaged or which, in the reasonable opinion of CJ, are not suitable for movement or storage within the storage. If Seller delivers hazardous products, dangerous goods, or otherwise delivers any such unfit products to CJ, CJ shall be entitled to exercise all available remedies including the immediate destruction or removal of the products from the storage without notice to Seller. In the event of the foregoing breach of Seller warranties, Seller shall be liable for all expenses costs, losses, damages, fines, penalties or other expenses of any sort incurred by CJ in connection with the removal, or destruction, or handling of the products and shall indemnify CJ against all amounts, liabilities, claims, or damages arising in connection with the products.
		CJ insures the products while in storage for any loss or damage. CJ will not be responsible for any loss or damage to the products that result from fluctuations in temperature range or in humidity levels of the storage.
		CJ reserves the right to terminate storage and to require the removal of the products, or any portion thereof, by giving Seller Seventy-Two (72) hours advance written notice. Seller shall be responsible for payment of all charges attributable to said products within the stated period and for removing the products from the storage upon payment of all charges. If the products are not so removed, CJ may exercise its rights under applicable law including but not limited to disposing or selling the products. Seller shall be responsible for any returns and refunds of products by Seller’s customers. Seller may pay CJ to handle any returns and refunds. CJ will have no customer service obligations other than to pass any inquiries to Seller’s attention.
		Seller must pay in advance, the non-prorated monthly Storage Service fees beginning on the day (up to midnight) that the product arrives at a CJ office or storage site and subsequent months until Seller terminates by Thirty (30) days advance notice. All Storage Service invoices that are not paid by the start of each month will be subject to a late fee equal to one additional month of the Storage Service fee. If it becomes necessary for CJ to utilize a collection agency and/or an attorney to collect any unpaid amount owed, Seller shall be obligated to pay the collection agency fees and/or attorney fees, and expenses including court costs incurred, regardless of whether litigation is actually filed. Following any termination of the Agreement, Seller shall pick-up the products or pay CJ to return ship the products to the Seller. If Seller fails to direct CJ to return or dispose of the products within Seventy-Two (72) hours after termination, then CJ may elect to return and/or dispose of the products in whole or in part, all rights and obligations will be extinguished.</p>
		
		<p><strong>C. Special Services.</strong></p>
		<p>CJ offers the following Special Services “Special Services”: (1) Import Application, (2) Regulatory and Compliance Consulting; (3) Product Testing and Inspection; (4) Translation Services; or (5) Warranty Support.
		CJ’s Special Services are customized to fit the needs of each Seller. CJ shall provide a separate agreement and invoice to cover each Special Service. The terms and conditions of this Import of Record Agreement that do not conflict with the Special Service shall apply to the Special Service agreement and invoice. Special Service fees are non-refundable regardless of outcome; such as, compliance or non-compliance, government approval or not. Seller is solely responsible for providing accurate and complete information and payment of fees and costs for the Special Services. CJ not responsible for any delays or any problems caused by the Seller, third parties or government in providing the Special Services.</p>

		<br>

		<img src="assets/img/checked.png" width="15">&nbsp;&nbsp;
		<label for="agreement">I accept COVUE IOR TERMS AND CONDITION</label>
		<br><br>
		Date Accepted:  $date_updated
		
		EOD;

		$pdf->writeHTML($agreement, true, false, false, false, '');

		$pdf->Output('terms and condition.pdf', 'I');
	}

	public function ipn()
	{
		// Get System Settings data from the database
		$q_system_settings = $this->Japan_ior_model->fetch_system_settings();
		$system_settings = $q_system_settings->row();

		$stripe = new \Stripe\StripeClient(
			$system_settings->stripe_secret_key
		);

		$session_id =  $_GET['session_id'];

		$data = $stripe->checkout->sessions->retrieve(
			$session_id,
			[]
		);
		$customs = $_GET['userid'] . '|' . $_GET['id'] . '|' . $_GET['id1'];
		$custom = explode('|', $customs);
		if ($data->payment_status == 'paid') {
			$custom_id     			= $custom[0];
			$custom_product_id  	= $custom[1];
			$billing_invoice_on	  	= $custom[2];

			if (!empty($billing_invoice_on)) {
				$q_billing_invoice = $this->Japan_ior_model->fetch_billing_invoice($custom_product_id);
				$billing_invoice = $q_billing_invoice->row();

				if ($billing_invoice->status == 0) {

					$this->Japan_ior_model->update_billing_invoice_to_paid($custom_product_id);

					$subject = 'Product Services Payment Status';
					$template = 'emails/success_regulated_payment.php';
					$q_fetch_user = $this->Japan_ior_model->fetch_user_by_id($custom_id);
					$fetch_user = $q_fetch_user->row();
					$contact_person = $fetch_user->contact_person;
					$this->send_mail($fetch_user->email, $template, $subject, $contact_person, '', '');

					if ($billing_invoice->register_ior == 1 && $billing_invoice->pli_sub == 1) {

						$this->Japan_ior_model->update_ior_pli($custom_id);

						$subject = 'Covue IOR Registration Payment Status';
						$template = 'emails/success_ior_registration.php';
						$q_fetch_user = $this->Japan_ior_model->fetch_user_by_id($custom_id);
						$fetch_user = $q_fetch_user->row();
						$contact_person = $fetch_user->contact_person;
						$this->send_mail($fetch_user->email, $template, $subject, $contact_person, '', '');
					} else {
						if ($billing_invoice->register_ior == 1) {

							$this->Japan_ior_model->update_to_registered($custom_id);

							$subject = 'Covue IOR Registration Payment Status';
							$template = 'emails/success_ior_registration.php';
							$q_fetch_user = $this->Japan_ior_model->fetch_user_by_id($custom_id);
							$fetch_user = $q_fetch_user->row();
							$contact_person = $fetch_user->contact_person;
							$this->send_mail($fetch_user->email, $template, $subject, $contact_person, '', '');
						}

						if ($billing_invoice->pli_sub == 1) {

							$this->Japan_ior_model->update_to_paid_pli($custom_id);

							$subject = 'Product Liability Insurance Payment Status';
							$template = 'emails/success_pli_payment.php';
							$q_fetch_user = $this->Japan_ior_model->fetch_user_by_id($custom_id);
							$fetch_user = $q_fetch_user->row();
							$contact_person = $fetch_user->contact_person;
							$this->send_mail($fetch_user->email, $template, $subject, $contact_person, '', '');
						}
						if ($billing_invoice->shipping_invoice_id != '') {
							$this->Japan_ior_model->update_shipping_invoice_id($custom_id, $custom_product_id);
						}
					}
				}
			} else {

				if ($custom_product_id == 0) {

					$date_today = date('Y-m-d');

					$this->Japan_ior_model->shipping_invoice_paid($custom_id, $date_today);

					$subject = 'Covue IOR Shipping Payment Status';
					$template = 'emails/success_ior_shipping.php';
					$q_fetch_user = $this->Japan_ior_model->fetch_user_by_shipping_id($custom_id);
					$fetch_user = $q_fetch_user->row();
					$contact_person = $fetch_user->contact_person;
					$this->send_mail($fetch_user->email, $template, $subject, $contact_person, '', '');
				}

				if ($custom_product_id == 16) {
					$this->Japan_ior_model->update_to_paid_product_label($custom_id);
					// $this->Japan_ior_model->update_to_paid_pli($custom_id);

					$subject = 'Product Label Payment Status';
					$template = 'emails/success_label_payment.php';
					$q_fetch_user = $this->Japan_ior_model->fetch_user_by_id($custom_id);
					$fetch_user = $q_fetch_user->row();
					$contact_person = $fetch_user->contact_person;
					$this->send_mail($fetch_user->email, $template, $subject, $contact_person, '', '');
				}
			}
			redirect($_GET['return_url']);
		}
	}

	public function send_mail($to_email, $template, $subject, $contact_person, $username, $password)
	{
		$mail = $this->phpmailer_library->load();
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

		$data['contact_person'] = $contact_person;
		$data['username'] = $username;
		$data['password'] = $password;
		$mailContent = $this->load->view($template, $data, true);

		$mail->Body = $mailContent;

		if ($mail->send()) {
			$message = 'success';
		} else {
			$message = 'failed';
		}

		return $message;
	}

	public function send_mail_verification($email, $company)
	{
		$subject = 'Shipping Invoice';
		$template = 'emails/company_email_notification.php';

		$mail = $this->phpmailer_library->load();
		$mail->isSMTP();
		$mail->Host     = 'mail.covueior.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'admin@covueior.com';
		$mail->Password = 'Y.=Sa3hZxq+>@6';
		// $mail->SMTPSecure = 'ssl'; // tls
		$mail->Port     = 26; // 587
		$mail->setFrom('admin@covueior.com', 'COVUE IOR Japan');
		$mail->addAddress($email);
		$mail->addBCC('mikecoros05@gmail.com');
		$mail->Subject = $subject;
		$mail->isHTML(true);

		$data['company'] = $company;
		$mailContent = $this->load->view($template, $data, true);

		$mail->Body = $mailContent;

		if ($mail->send()) {
			$message = 'success';
		} else {
			$message = 'failed';
		}
	}
	public function send_email_notification($status, $company, $shipping_invoice)
	{
		if ($status == 1) {
			$subject = 'New Shipping Invoice created from ' . $company;
		} else {
			$subject = 'Updated Shipping Invoice from ' . $company;
		}

		$template = 'emails/shipping_invoice_notification.php';

		$mail = $this->phpmailer_library->load();
		$mail->isSMTP();
		$mail->Host     = 'mail.covueior.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'admin@covueior.com';
		$mail->Password = 'Y.=Sa3hZxq+>@6';
		// $mail->SMTPSecure = 'ssl'; // tls
		$mail->Port     = 26; // 587
		$mail->setFrom('admin@covueior.com', 'COVUE IOR Japan');
		//$mail->addAddress("complianceinternal@covue0.zohodesk.com");
		$mail->addAddress("kevinjayroluna@gmail.com");
		//$mail->addBCC('mikecoros05@gmail.com');
		$mail->Subject = $subject;
		$mail->isHTML(true);

		if ($status == 1) {
			$data['content'] = "Hi, <br><br>  New Shipping Invoice ID: <b>" . $shipping_invoice . "</b> has been created. Please check!";
		} else {
			$data['content']  = "Hi, <br><br>   Shipping Invoice ID: <b>" . $shipping_invoice . "</b> has been updated. Please check!";
		}

		$mailContent = $this->load->view($template, $data, true);

		$mail->Body = $mailContent;



		if ($mail->send()) {
			$message = 'success';
		} else {
			$message = 'failed';
		}
	}
	public function send_mail_to_compliance($to_email)
	{
		$subject = 'New Regulated Application Started';
		$template = 'emails/new_regulated_application.php';

		$mail = $this->phpmailer_library->load();
		$mail->isSMTP();
		$mail->Host     = 'mail.covueior.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'admin@covueior.com';
		$mail->Password = 'Y.=Sa3hZxq+>@6';
		// $mail->SMTPSecure = 'ssl'; // tls
		$mail->Port     = 26; // 587
		$mail->setFrom('admin@covueior.com', 'COVUE IOR Japan');

		foreach ($to_email as $row) {
			$mail->addAddress($row->email);
		}

		$mail->addBCC('mikecoros05@gmail.com');

		$mail->Subject = $subject;
		$mail->isHTML(true);
		$mailContent = $this->load->view($template, '', true);

		$mail->Body = $mailContent;

		if ($mail->send()) {
			$message = 'success';
		} else {
			$message = 'failed';
		}

		return $message;
	}

	public function webhook()
	{
		header('Content-Type: application/json');

		if ($_SERVER['REQUEST_METHOD'] != 'POST') {
			echo json_encode(['error' => 'Invalid request.']);
			exit;
		}

		$q_system_settings = $this->Japan_ior_model->fetch_system_settings();
		$system_settings = $q_system_settings->row();
		\Stripe\Stripe::setApiKey($system_settings->stripe_secret_key);

		$endpoint_secret = $system_settings->endpoint_secret;

		$payload = file_get_contents('php://input');
		$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];

		try {
			$event = \Stripe\Webhook::constructEvent(
				$payload,
				$sig_header,
				$endpoint_secret
			);
		} catch (\UnexpectedValueException $e) {
			// Invalid payload
			http_response_code(400);
			echo $e;
			exit();
		} catch (\Stripe\Exception\SignatureVerificationException $e) {
			// Invalid signature
			http_response_code(400);
			echo $e;
			exit();
		}

		if ($event->type == "checkout.session.completed") {



			$customs = $event->data->object->client_reference_id;
			$custom = explode('|', $customs);
			if ($event->data->object->payment_status == 'paid') {
				$custom_id     			= $custom[0];
				$custom_product_id  	= $custom[1];
				$billing_invoice_on	  	= $custom[2];

				if (!empty($billing_invoice_on)) {
					$q_billing_invoice = $this->Japan_ior_model->fetch_billing_invoice($custom_product_id);
					$billing_invoice = $q_billing_invoice->row();

					if ($billing_invoice->status == 0) {

						$this->Japan_ior_model->update_billing_invoice_to_paid($custom_product_id);

						$subject = 'Product Services Payment Status';
						$template = 'emails/success_regulated_payment.php';
						$q_fetch_user = $this->Japan_ior_model->fetch_user_by_id($custom_id);
						$fetch_user = $q_fetch_user->row();
						$contact_person = $fetch_user->contact_person;
						$this->send_mail($fetch_user->email, $template, $subject, $contact_person, '', '');

						if ($billing_invoice->register_ior == 1 && $billing_invoice->pli_sub == 1) {

							$this->Japan_ior_model->update_ior_pli($custom_id);

							$subject = 'Covue IOR Registration Payment Status';
							$template = 'emails/success_ior_registration.php';
							$q_fetch_user = $this->Japan_ior_model->fetch_user_by_id($custom_id);
							$fetch_user = $q_fetch_user->row();
							$contact_person = $fetch_user->contact_person;
							$this->send_mail($fetch_user->email, $template, $subject, $contact_person, '', '');
						} else {
							if ($billing_invoice->register_ior == 1) {

								$this->Japan_ior_model->update_to_registered($custom_id);

								$subject = 'Covue IOR Registration Payment Status';
								$template = 'emails/success_ior_registration.php';
								$q_fetch_user = $this->Japan_ior_model->fetch_user_by_id($custom_id);
								$fetch_user = $q_fetch_user->row();
								$contact_person = $fetch_user->contact_person;
								$this->send_mail($fetch_user->email, $template, $subject, $contact_person, '', '');
							}

							if ($billing_invoice->pli_sub == 1) {

								$this->Japan_ior_model->update_to_paid_pli($custom_id);

								$subject = 'Product Liability Insurance Payment Status';
								$template = 'emails/success_pli_payment.php';
								$q_fetch_user = $this->Japan_ior_model->fetch_user_by_id($custom_id);
								$fetch_user = $q_fetch_user->row();
								$contact_person = $fetch_user->contact_person;
								$this->send_mail($fetch_user->email, $template, $subject, $contact_person, '', '');
							}
							if ($billing_invoice->shipping_invoice_id != '') {
								$this->Japan_ior_model->update_shipping_invoice_id($custom_id, $custom_product_id);
							}
						}
					}
				} else {

					if ($custom_product_id == 0) {

						$date_today = date('Y-m-d');

						$this->Japan_ior_model->shipping_invoice_paid($custom_id, $date_today);

						$subject = 'Covue IOR Shipping Payment Status';
						$template = 'emails/success_ior_shipping.php';
						$q_fetch_user = $this->Japan_ior_model->fetch_user_by_shipping_id($custom_id);
						$fetch_user = $q_fetch_user->row();
						$contact_person = $fetch_user->contact_person;
						$this->send_mail($fetch_user->email, $template, $subject, $contact_person, '', '');
					}

					if ($custom_product_id == 16) {
						$this->Japan_ior_model->update_to_paid_product_label($custom_id);

						$subject = 'Product Label Payment Status';
						$template = 'emails/success_label_payment.php';
						$q_fetch_user = $this->Japan_ior_model->fetch_user_by_id($custom_id);
						$fetch_user = $q_fetch_user->row();
						$contact_person = $fetch_user->contact_person;
						$this->send_mail($fetch_user->email, $template, $subject, $contact_person, '', '');
					}
				}
			}
		}
	}

	public function add_logistic_product_details(){
		$this->Japan_ior_model->add_logistic_product_details($_POST);
	}

	public function add_port_of_arrival_details(){
		$this->Japan_ior_model->add_port_of_arrival_details($_POST);
	}
}
