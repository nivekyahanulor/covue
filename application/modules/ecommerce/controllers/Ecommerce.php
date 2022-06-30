<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ecommerce extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'date'));
		$this->load->library(array('form_validation', 'session', 'upload', 'phpmailer_library'));
		$this->load->module('users');
		$this->load->model('Ecommerce_model');
	}

	public function index()
	{
		if ($this->session->userdata('logged_in') != '1') {
			redirect('/home/login');
		} else {
			$data['external_page'] = 1;
			$data['active_page'] = "ecommerce";
			$data['active_url'] = "ecommerce";
			$data['page_view'] = 'ecommerce/platform';

			// $data['user_id'] = $this->session->userdata('user_id');
			// $data['admin'] = $this->session->userdata('admin');

			// $q_product_registrations = $this->Product_registration_model->fetch_product_registrations();
			// $data['product_registrations'] = $q_product_registrations->result();

			// $q_product_categories = $this->Product_registration_model->fetch_product_categories();
			// $data['product_categories'] = $q_product_categories->result();
			$data['user_id'] = $this->session->userdata('user_id');

			$q_user_details = $this->Ecommerce_model->fetch_users_by_id($data['user_id']);
			$data['user_details'] = $q_user_details->row();

			$this->load->view('ecommerce_page', $data);
		}
	}

	public function amazon()
	{
		$data['external_page'] = 1;
		$data['active_page'] = "ecommerce";
		$data['active_url'] = "ecommerce";
		$data['page_view'] = 'ecommerce/amazon';
		$data['user_id'] = $this->session->userdata('user_id');

		$q_user_details = $this->Ecommerce_model->fetch_users_by_id($data['user_id']);
		$data['user_details'] = $q_user_details->row();
		$this->load->view('ecommerce_page', $data);
	}

	public function amazon_account_setup_form()
	{
		$data['external_page'] = 1;
		$data['active_page'] = "ecommerce";
		$data['active_url'] = "ecommerce";
		$data['page_view'] = 'ecommerce/amazon_account_setup_form';
		$data['user_id'] = $this->session->userdata('user_id');
		$q_fetch_countries = $this->Ecommerce_model->fetch_countries();
		$data['countries'] = $q_fetch_countries->result();

		$q_user_details = $this->Ecommerce_model->fetch_users_by_id($data['user_id']);
		$data['user_details'] = $q_user_details->row();
		$this->load->view('ecommerce_page', $data);
	}

	public function pre_check_form()
	{
		$data['external_page'] = 1;
		$data['active_page'] = "ecommerce";
		$data['active_url'] = "ecommerce";
		$data['page_view'] = 'ecommerce/pre_check_form';
		$this->load->view('ecommerce_page', $data);
	}

	public function amazon_purchase_service()
	{
		$data['external_page'] = 1;
		$data['active_page'] = "ecommerce";
		$data['active_url'] = "ecommerce";
		$data['page_view'] = 'ecommerce/amazon_purchase_service';
		$data['user_id'] = $this->session->userdata('user_id');
		$q_ior_reg_fee = $this->Ecommerce_model->fetch_product_offer(1);
		$data['ior_reg_fee'] = $q_ior_reg_fee->row();
		$q_user_details = $this->Ecommerce_model->fetch_users_by_id($data['user_id']);
		$data['user_details'] = $q_user_details->row();
		$q_amazon_products = $this->Ecommerce_model->fetch_amazon_products();
		$data['amazon_products'] = $q_amazon_products->result();
		$billing_invoices_unpaid_count = $this->Ecommerce_model->fetch_billing_invoices_unpaid($data['user_id'], 1);
		$amazon_account_setup_count = $this->Ecommerce_model->fetch_amazon_account_setup($data['user_id']);
		$data['amazon_account_setup_count'] = $amazon_account_setup_count;
		if ($billing_invoices_unpaid_count > 0) {
			$data['page_view'] = 'amazon_invoice_unpaid';
		}
		$this->load->view('ecommerce_page', $data);
	}

	public function amazon_list_services()
	{
		$data['external_page'] = 1;
		$data['active_page'] = "ecommerce";
		$data['active_url'] = "ecommerce";
		$data['page_view'] = 'ecommerce/amazon_list_services';
		$data['user_id'] = $this->session->userdata('user_id');

		$q_user_details = $this->Ecommerce_model->fetch_users_by_id($data['user_id']);

		$q_billing_invoices = $this->Ecommerce_model->fetch_billing_invoices($data['user_id'], 1);
		$data['billing_invoices'] = $q_billing_invoices->result();

		$data['billing_invoices_unpaid_count'] = $this->Ecommerce_model->fetch_billing_invoices_unpaid($data['user_id'], 1);
		$data['user_details'] = $q_user_details->row();
		$this->load->view('ecommerce_page', $data);
	}

	public function order_tracking()
	{
		$data['external_page'] = 1;
		$data['active_page'] = "ecommerce";
		$data['active_url'] = "ecommerce";
		$data['page_view'] = 'ecommerce/order_tracking';
		$data['user_id'] = $this->session->userdata('user_id');

		$q_user_details = $this->Ecommerce_model->fetch_users_by_id($data['user_id']);
		$data['user_details'] = $q_user_details->row();
		$this->load->view('ecommerce_page', $data);
	}

	public function fetch_reg_fee()
	{
		$q_reg_fee = $this->Ecommerce_model->fetch_reg_fee();
		echo json_encode($q_reg_fee[0]->price);
	}

	public function purchase_product()
	{
		$products_offer_val = explode('|', $this->input->post('products_offer'));
		$product_category_id = $products_offer_val[0];
		$product_offer_id = $products_offer_val[1];

		$data['user_id'] = $this->session->userdata('user_id');

		$q_user_details = $this->Ecommerce_model->fetch_users_by_id($data['user_id']);
		$data['user_details'] = $q_user_details->row();

		$subtotal = $this->input->post('subtotal');
		$jct = $this->input->post('jct');
		$total = $this->input->post('total');
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
		$pli = 1;
		$billing_invoice_id = $this->Japan_ior_model->insert_user_payment_invoice($data['user_id'], $product_category_id, $register_ior, $pli, $product_offer_id, $subtotal, $jct, $total, $data['user_id'], $created_at);
	}

	function file_upload()
	{
		$ds = DIRECTORY_SEPARATOR;  //1

		$storeFolder = '../../../../uploads';   //2
		if ($_POST['request'] == "add") {
			if (!empty($_FILES)) {

				$tempFile = $_FILES['file']['tmp_name'];          //3             

				$targetPath = dirname(__FILE__) . $ds . $storeFolder . $ds;  //4

				$targetFile =  $targetPath . $_FILES['file']['name'];  //5

				move_uploaded_file($tempFile, $targetFile); //6
				$success_message = array(
					'success' => 200,
					'filename' => $_FILES['file']['name'],
				);
				echo json_encode($success_message);
			}
		} else {
			$targetPath = dirname(__FILE__) . $ds . $storeFolder . $ds;  //4
			$fileName = $targetPath . $_POST['name'];
			unlink($fileName);
		}
	}
}
