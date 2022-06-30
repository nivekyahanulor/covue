<?php
date_default_timezone_set("Asia/Tokyo");

require_once APPPATH . "libraries/tcpdf/tcpdf.php";
require_once APPPATH . "libraries/tcpdf/tcpdf_terms.php";
require_once APPPATH . "libraries/tcpdf/PDFMerger.php";

use PDFMerger\PDFMerger;
use setasign\Fpdi\Fpdi;

class Consultant extends MX_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'date', 'download'));
		$this->load->library(array('form_validation', 'session', 'upload', 'phpmailer_library', 'paypal_lib', 'image_lib', 'user_agent'));
		$this->load->model('Consultant_model');
	}

	public function clear_apost()
	{
		foreach ($_POST as $key => $value) {
			$_POST[$key] = str_replace("'", "&apos;", $value);
		}
	}



	public function logged_in_external()
	{
		if ($this->session->userdata('logged_in') == '3') {
			return true;
		} else {
			return false;
		}
	}


	public function logout()
	{
		$this->session->set_userdata('admin', 0);
		$this->session->set_userdata('contact_person', "");
		$this->session->set_userdata('user_id', 0);
		$this->session->set_userdata('logged_in', '0');

		redirect('/home/consultant-login');
	}

	public function dashboard()
	{
		if (!$this->logged_in_external()) {
			redirect('/home/login');
		}

		$data['user_id'] = $this->session->userdata('user_id');

		if (isset($_POST['uploadlogo'])) {
			$result = $this->Consultant_model->upload_logo($_POST, $data['user_id']);
			if ($result == 1) {
				$this->session->set_flashdata('success', 'Logo upload Success!');
				redirect('consultant/' . $this->uri->segment(2), 'refresh');
			}
		}

		$data['external_page'] = 1;
		$data['active_page'] = 'japan_ior';
		$data['page_view'] = 'consultant/dashboard';

		$data['user_id'] = $this->session->userdata('user_id');

		$q_user_details = $this->Consultant_model->fetch_users_by_id($data['user_id']);
		$data['user_details'] = $q_user_details->row();

		$q_company_customer = $this->Consultant_model->fectch_company_consultant_customer($data['user_id']);
		$data['count_customer']	  = $q_company_customer->num_rows();

		if ($data['count_customer'] != 0) {
			$data['company_customer'] = $q_company_customer->result();
			// $q_shipping_invoices = $this->Consultant_model->fetch_shipping_invoices_by_user_id($data['company_customer'][0]->user_id);
			// $r_shipping_invoices = $q_shipping_invoices->result();
			// $data['shipping_invoice_id'] =  $r_shipping_invoices[0]->shipping_invoice_id;
		} else {
			$data['company_customer'] = "";
		}
		$this->load->view('page', $data);
	}

	public function pricing_list()
	{
		if (!$this->logged_in_external()) {
			redirect('/home/login');
		}

		$data['user_id'] = $this->session->userdata('user_id');

		if (isset($_POST['uploadlogo'])) {
			$result = $this->Consultant_model->upload_logo($_POST, $data['user_id']);
			if ($result == 1) {
				$this->session->set_flashdata('success', 'Logo upload Success!');
				redirect('consultant/' . $this->uri->segment(2), 'refresh');
			}
		}

		$data['external_page'] = 1;
		$data['active_page'] = 'japan_ior';
		$data['page_view'] = 'consultant/pricing_list';

		$data['user_id'] = $this->session->userdata('user_id');

		$q_user_details = $this->Consultant_model->fetch_users_by_id($data['user_id']);
		$data['user_details'] = $q_user_details->row();


		$this->load->view('page', $data);
	}

	public function shipping_companies()
	{
		if (!$this->logged_in_external()) {
			redirect('/home/login');
		}

		$data['user_id'] = $this->session->userdata('user_id');

		if (isset($_POST['uploadlogo'])) {
			$result = $this->Consultant_model->upload_logo($_POST, $data['user_id']);
			if ($result == 1) {
				$this->session->set_flashdata('success', 'Logo upload Success!');
				redirect('consultant/' . $this->uri->segment(2), 'refresh');
			}
		}

		$data['external_page'] = 1;
		$data['active_page'] = 'japan_ior';
		$data['page_view'] = 'consultant/shipping_companies';

		$data['user_id'] = $this->session->userdata('user_id');

		$q_user_details = $this->Consultant_model->fetch_users_by_id($data['user_id']);
		$data['user_details'] = $q_user_details->row();

		$q_company_customer = $this->Consultant_model->fectch_company_customer($data['user_id']);
		$data['count_customer']	  = $q_company_customer->num_rows();

		if ($data['count_customer'] != 0) {
			$data['company_customer'] = $q_company_customer->result();
			$q_shipping_invoices = $this->Consultant_model->fetch_shipping_invoices_by_user_id($data['company_customer'][0]->user_consultant_id);
			$r_shipping_invoices = $q_shipping_invoices->result();
			// $data['shipping_invoice_id'] =  $r_shipping_invoices->shipping_invoice_id;
		} else {
			$data['company_customer'] = "";
		}
		$this->load->view('page', $data);
	}

	public function content()
	{
		if (!$this->logged_in_external()) {
			redirect('/home/login');
		}

		$data['user_id'] = $this->session->userdata('user_id');

		if (isset($_POST['uploadlogo'])) {
			$result = $this->Consultant_model->upload_logo($_POST, $data['user_id']);
			if ($result == 1) {
				$this->session->set_flashdata('success-logo', 'Logo upload Success!');
				redirect('consultant/' . $this->uri->segment(2), 'refresh');
			}
		}

		if (isset($_POST['updatebanner'])) {
			$result = $this->Consultant_model->update_banner($_POST, $data['user_id']);
			if ($result == 1) {
				$this->session->set_flashdata('success-banner', 'Banner Updated Successfully!');
				redirect('consultant/content', 'refresh');
			}
		}

		if (isset($_POST['updatebackground'])) {
			$result = $this->Consultant_model->update_background($_POST, $data['user_id']);
			if ($result == 1) {
				$this->session->set_flashdata('success-background', 'Background Updated Successfully!');
				redirect('consultant/content', 'refresh');
			}
		}

		if (isset($_POST['updatecontent'])) {
			$result = $this->Consultant_model->update_content($_POST, $data['user_id']);
			if ($result == 1) {
				$this->session->set_flashdata('success-content', 'Content Updated Successfully!');
				redirect('consultant/content', 'refresh');
			}
		}

		if (isset($_POST['updateheadertitle'])) {
			$result = $this->Consultant_model->update_header_title($_POST, $data['user_id']);
			if ($result == 1) {
				$this->session->set_flashdata('success-content', 'Content Updated Successfully!');
				redirect('consultant/content', 'refresh');
			}
		}

		if (isset($_POST['updateheadercolor'])) {
			$result = $this->Consultant_model->update_color_header($_POST, $data['user_id']);
			if ($result == 1) {
				$this->session->set_flashdata('success-header-color', 'Header Color Updated Successfully!');
				redirect('consultant/content', 'refresh');
			}
		}

		if (isset($_POST['updatefootercolor'])) {
			$result = $this->Consultant_model->update_color_footer($_POST, $data['user_id']);
			if ($result == 1) {
				$this->session->set_flashdata('success-footer-color', 'Footer Color Updated Successfully!');
				redirect('consultant/content', 'refresh');
			}
		}

		$data['external_page'] = 1;
		$data['active_page'] = 'japan_ior';
		$data['page_view'] = 'consultant/content';

		$data['user_id'] = $this->session->userdata('user_id');

		$q_user_details = $this->Consultant_model->fetch_users_by_id($data['user_id']);
		$data['user_details'] = $q_user_details->row();


		$this->load->view('page', $data);
	}

	public function regulated_application()
	{
		if (!$this->logged_in_external()) {
			redirect('/home/login');
		}

		$data['user_id'] = $this->session->userdata('user_id');


		$data['external_page'] = 1;
		$data['active_page'] = 'japan_ior';
		$data['page_view'] = 'consultant/regulated_application';

		$data['user_id'] = $this->session->userdata('user_id');

		$q_user_details = $this->Consultant_model->fetch_users_by_id($data['user_id']);
		$data['user_details'] = $q_user_details->row();

		$q_regulated_application = $this->Consultant_model->fetch_regulated_application($data['user_id']);
		$data['regulated_application'] = $q_regulated_application->result();

		if (isset($_POST['uploadlogo'])) {
			$result = $this->Consultant_model->upload_logo($_POST, $data['user_id']);
			if ($result == 1) {
				$this->session->set_flashdata('success', 'Logo upload Success!');
				redirect('consultant/' . $this->uri->segment(2), 'refresh');
			}
		}

		$this->load->view('page', $data);
	}

	public function edit_consultant_info()
	{
		if (!$this->logged_in_external()) {
			redirect('/home/login');
		}

		$this->clear_apost();

		$data['external_page'] = 1;
		$data['active_page'] = 'japan_ior';
		$data['page_view'] = 'consultant/edit_consultant_info';

		$data['user_id'] = $this->session->userdata('user_id');
		$q_fetch_countries = $this->Consultant_model->fetch_countries();
		$data['countries'] = $q_fetch_countries->result();
		$q_user_details = $this->Consultant_model->fetch_users_by_id($data['user_id']);
		$data['user_details'] = $q_user_details->row();

		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('company_name', 'Legal Company Name', 'trim|required');
			$this->form_validation->set_rules('country', 'Country', 'trim|required|integer');
			$this->form_validation->set_rules('contact_person', 'Primary Contact Person', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

			if ($this->form_validation->run() == FALSE) {
				$q_user_details = $this->Consultant_model->fetch_consultant_by_id($data['user_id']);
				$data['user_details'] = $q_user_details->row();

				$q_fetch_countries = $this->Consultant_model->fetch_countries();
				$data['countries'] = $q_fetch_countries->result();

				$this->load->view('page', $data);
			} else {
				$q_user_details_before = $this->Consultant_model->fetch_consultant_by_id($data['user_id']);
				$user_details_before = $q_user_details_before->row();

				$username = stripslashes($this->input->post('username'));
				$password = stripslashes($this->input->post('password'));
				$company_name = stripslashes($this->input->post('company_name'));
				$country = stripslashes($this->input->post('country'));
				$contact_person = stripslashes($this->input->post('contact_person'));
				$email = stripslashes($this->input->post('email'));

				$updated_at = date('Y-m-d H:i:s');
				$updated_by = $this->session->userdata('user_id');

				$result = $this->Consultant_model->update_consultant_user($data['user_id'], $username, $password, $company_name, $country, $contact_person, $email, $updated_at, $updated_by);

				if ($result == 1) {
					$data['errors'] = 0;
					$this->session->set_flashdata('success-update', 'Your profile is now updated!');
					redirect('consultant/edit-consultant-info/' . $data['user_details']->consultant_id, 'refresh');
				} else {
					$data['errors'] = 1;
					$this->load->view('page', $data);
				}
			}
		} else {
			$this->load->view('page', $data);
		}
	}

	function download_price_list($filename)
	{
		$this->load->helper('download');
		$file = 'uploads/docs/price_list/' . $filename . '';
		force_download($file, NULL);
	}
}
