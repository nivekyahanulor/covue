<?php
date_default_timezone_set("Asia/Tokyo");

require_once APPPATH . "libraries/tcpdf/tcpdf.php";
require_once APPPATH . "libraries/tcpdf/tcpdf_terms.php";
require_once APPPATH . "libraries/tcpdf/PDFMerger.php";

use PDFMerger\PDFMerger;
use setasign\Fpdi\Fpdi;

class Partner_companies extends MX_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'date'));
		$this->load->library(array('form_validation', 'session', 'upload', 'phpmailer_library', 'paypal_lib', 'image_lib', 'user_agent'));
		$this->load->model('Partner_companies_model');
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

		redirect('/home/partner-login');
	}

	public function dashboard()
	{
		if (!$this->logged_in_external()) {
			redirect('/home/login');
		}

		$data['user_id'] = $this->session->userdata('user_id');

		if (isset($_POST['uploadlogo'])) {
			$result = $this->Partner_companies_model->upload_logo($_POST, $data['user_id']);
			if ($result == 1) {
				$this->session->set_flashdata('success', 'Logo upload Success!');
				redirect('partner_companies/dashboard', 'refresh');
			}
		}

		$data['external_page'] = 1;
		$data['active_page'] = 'japan_ior';
		$data['page_view'] = 'partner_companies/dashboard';

		$data['user_id'] = $this->session->userdata('user_id');
		$q_user_details = $this->Partner_companies_model->fetch_users_by_id($data['user_id']);
		$data['user_details'] = $q_user_details->row();

		$q_company_customer = $this->Partner_companies_model->fectch_reffered_user($data['user_id']);
		$data['count_customer']	  = $q_company_customer->num_rows();

		if ($data['count_customer'] != 0) {
			$data['company_customer'] = $q_company_customer->result();
		} else {
			$data['company_customer'] = "";
		}



		$this->load->view('page', $data);
	}

	public function customer_users()
	{
		if (!$this->logged_in_external()) {
			redirect('/home/login');
		}

		$data['user_id'] = $this->session->userdata('user_id');

		if (isset($_POST['uploadlogo'])) {
			$result = $this->Partner_companies_model->upload_logo($_POST, $data['user_id']);
			if ($result == 1) {
				$this->session->set_flashdata('success', 'Logo upload Success!');
				redirect('partner_companies/dashboard', 'refresh');
			}
		}

		$data['external_page'] = 1;
		$data['active_page'] = 'japan_ior';
		$data['page_view'] = 'partner_companies/customer';

		$data['user_id'] = $this->session->userdata('user_id');

		$q_user_details = $this->Partner_companies_model->fetch_users_by_id($data['user_id']);
		$data['user_details'] = $q_user_details->row();

		$q_company_customer = $this->Partner_companies_model->fectch_company_customer($data['user_id']);
		$data['count_customer']	  = $q_company_customer->num_rows();

		if ($data['count_customer'] != 0) {
			$data['company_customer'] = $q_company_customer->result();
			$q_shipping_invoices = $this->Partner_companies_model->fetch_shipping_invoices_by_user_id($data['company_customer'][0]->user_id);
			$r_shipping_invoices = $q_shipping_invoices->result();
			$data['shipping_invoice_id'] =  $r_shipping_invoices[0]->shipping_invoice_id;
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
			$result = $this->Partner_companies_model->upload_logo($_POST, $data['user_id']);
			if ($result == 1) {
				$this->session->set_flashdata('success', 'Logo upload Success!');
				redirect('partner_companies/dashboard', 'refresh');
			}
		}

		if (isset($_POST['updatebanner'])) {
			$result = $this->Partner_companies_model->update_banner($_POST, $data['user_id']);
			if ($result == 1) {
				$this->session->set_flashdata('success-banner', 'Banner Updated Successfully!');
				redirect('partner_companies/content', 'refresh');
			}
		}

		if (isset($_POST['updatebackground'])) {
			$result = $this->Partner_companies_model->update_background($_POST, $data['user_id']);
			if ($result == 1) {
				$this->session->set_flashdata('success-background', 'Background Updated Successfully!');
				redirect('partner_companies/content', 'refresh');
			}
		}

		if (isset($_POST['updatecontent'])) {
			$result = $this->Partner_companies_model->update_content($_POST, $data['user_id']);
			if ($result == 1) {
				$this->session->set_flashdata('success-content', 'Content Updated Successfully!');
				redirect('partner_companies/content', 'refresh');
			}
		}

		if (isset($_POST['updateheadercolor'])) {
			$result = $this->Partner_companies_model->update_color_header($_POST, $data['user_id']);
			if ($result == 1) {
				$this->session->set_flashdata('success-header-color', 'Header Color Updated Successfully!');
				redirect('partner_companies/content', 'refresh');
			}
		}

		if (isset($_POST['updatefootercolor'])) {
			$result = $this->Partner_companies_model->update_color_footer($_POST, $data['user_id']);
			if ($result == 1) {
				$this->session->set_flashdata('success-footer-color', 'Footer Color Updated Successfully!');
				redirect('partner_companies/content', 'refresh');
			}
		}

		$data['external_page'] = 1;
		$data['active_page'] = 'japan_ior';
		$data['page_view'] = 'partner_companies/content';

		$data['user_id'] = $this->session->userdata('user_id');

		$q_user_details = $this->Partner_companies_model->fetch_users_by_id($data['user_id']);
		$data['user_details'] = $q_user_details->row();


		$this->load->view('page', $data);
	}

	public function pricing_list()
	{
		if (!$this->logged_in_external()) {
			redirect('/home/login');
		}

		$data['user_id'] = $this->session->userdata('user_id');

		$data['external_page'] = 1;
		$data['active_page'] = 'japan_ior';
		$data['page_view'] = 'partner_companies/pricing_list';

		$data['user_id'] = $this->session->userdata('user_id');

		$q_user_details = $this->Partner_companies_model->fetch_users_by_id($data['user_id']);
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
		$data['page_view'] = 'partner_companies/regulated_application';

		$data['user_id'] = $this->session->userdata('user_id');

		$q_user_details = $this->Partner_companies_model->fetch_users_by_id($data['user_id']);
		$data['user_details'] = $q_user_details->row();

		$q_regulated_application = $this->Partner_companies_model->fetch_regulated_application($data['user_id']);
		$data['regulated_application'] = $q_regulated_application->result();

		$this->load->view('page', $data);
	}

	public function edit_profile()
	{
		if (!$this->logged_in_external()) {
			redirect('/home/login');
		}

		$data['external_page'] = 1;
		$data['active_page'] = 'japan_ior';

		$data['user_id'] = $this->session->userdata('user_id');

		$q_user_details = $this->Partner_companies_model->fetch_users_by_id($data['user_id']);
		$data['user_details'] = $q_user_details->row();

		$q_fetch_countries = $this->Partner_companies_model->fetch_countries();
		$data['countries'] = $q_fetch_countries->result();

		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('shipping_company_email', 'Email Address', 'trim|required');
			$this->form_validation->set_rules('shipping_company_username', 'Username', 'trim|required');
			$this->form_validation->set_rules('shipping_company_password', 'Password', 'trim|required');
			$this->form_validation->set_rules('contact_person', 'Contact Name', 'trim|required');
			$this->form_validation->set_rules('country', 'Country', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data['page_view'] = 'partner_companies/edit_profile';
				$this->load->view('page', $data);
			} else {
				$result = $this->Partner_companies_model->update_profile($_POST, $data['user_id']);
				if ($result == 1) {
					$this->session->set_flashdata('success-update', 'Your profile is now updated!');
					redirect('partner_companies/edit_profile', 'refresh');
				}
			}
		} else {
			$data['page_view'] = 'partner_companies/edit_profile';
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
