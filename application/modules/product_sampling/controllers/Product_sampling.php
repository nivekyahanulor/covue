<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_sampling extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation', 'session', 'upload', 'phpmailer_library'));
		$this->load->module('users');
		$this->load->model('Product_sampling_model');
	}

	public function index()
	{
		if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

		$data['external_page'] = 0;
		$data['active_page'] = "product_sampling";
		$data['active_url'] = "product_sampling";
		$data['page_view'] = 'product_sampling/product_sampling_v';

		$q_all_shipping = $this->Product_sampling_model->fetch_shipping_invoices();
		$data['shipping_invoices'] = $q_all_shipping->result();

		$data['user_id'] = $this->session->userdata('user_id');

		$this->load->view('page', $data);
	}

	public function accepted()
	{
		if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

		$data['external_page'] = 0;
		$data['active_page'] = "product_sampling";
		$data['active_url'] = "product_sampling/accepted";
		$data['page_view'] = 'product_sampling/product_sampling_v';

		$q_all_shipping = $this->Product_sampling_model->fetch_shipping_custom(1);
		$data['shipping_invoices'] = $q_all_shipping->result();

		$data['user_id'] = $this->session->userdata('user_id');

		$this->load->view('page', $data);
	}

	public function completed()
	{
		if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

		$data['external_page'] = 0;
		$data['active_page'] = "product_sampling";
		$data['active_url'] = "product_sampling/completed";
		$data['page_view'] = 'product_sampling/product_sampling_v';

		$q_all_shipping = $this->Product_sampling_model->fetch_shipping_custom(2);
		$data['shipping_invoices'] = $q_all_shipping->result();

		$data['user_id'] = $this->session->userdata('user_id');

		$this->load->view('page', $data);
	}

	public function draft()
	{
		if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

		$data['external_page'] = 0;
		$data['active_page'] = "product_sampling";
		$data['active_url'] = "product_sampling/draft";
		$data['page_view'] = 'product_sampling/product_sampling_v';

		$q_all_shipping = $this->Product_sampling_model->fetch_shipping_custom(3);
		$data['shipping_invoices'] = $q_all_shipping->result();

		$data['user_id'] = $this->session->userdata('user_id');

		$this->load->view('page', $data);
	}

	public function pending()
	{
		if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

		$data['external_page'] = 0;
		$data['active_page'] = "product_sampling";
		$data['active_url'] = "product_sampling/pending";
		$data['page_view'] = 'product_sampling/product_sampling_v';

		$q_all_shipping = $this->Product_sampling_model->fetch_shipping_custom(4);
		$data['shipping_invoices'] = $q_all_shipping->result();

		$data['user_id'] = $this->session->userdata('user_id');

		$this->load->view('page', $data);
	}

	public function revisions()
	{
		if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

		$data['external_page'] = 0;
		$data['active_page'] = "product_sampling";
		$data['active_url'] = "product_sampling/revisions";
		$data['page_view'] = 'product_sampling/product_sampling_v';

		$q_all_shipping = $this->Product_sampling_model->fetch_shipping_custom(5);
		$data['shipping_invoices'] = $q_all_shipping->result();

		$data['user_id'] = $this->session->userdata('user_id');

		$this->load->view('page', $data);
	}

	public function updated()
	{
		if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

		$data['external_page'] = 0;
		$data['active_page'] = "product_sampling";
		$data['active_url'] = "product_sampling/updated";
		$data['page_view'] = 'product_sampling/product_sampling_v';

		$q_all_shipping = $this->Product_sampling_model->fetch_shipping_custom(6);
		$data['shipping_invoices'] = $q_all_shipping->result();

		$data['user_id'] = $this->session->userdata('user_id');

		$this->load->view('page', $data);
	}

	public function accept_shipping_invoice()
	{
		if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

		$subject = 'IOR Shipping Invoice Status';
		$template = 'emails/notification_accepted.php';

		$shipping_invoice_id = $this->input->post('id');

		$approved_date = date('Y-m-d');
		$updated_by = $this->session->userdata('user_id');
		$updated_at = date('Y-m-d H:i:s');

		$q_shipping_invoice_id = $this->Shipping_invoices_model->fetch_shipping_invoice_by_id($shipping_invoice_id);
		$shipping_invoice = $q_shipping_invoice_id->row();

		$contact_person = $shipping_invoice->contact_person;

		$result = $this->Shipping_invoices_model->accept_shipping_invoice($shipping_invoice_id, $updated_by, $approved_date, $updated_by, $updated_at);

		if ($result == 1) {
			$this->send_mail($shipping_invoice->email, $template, '', $subject, $contact_person);
			echo $result;
		}
	}

	public function paid_shipping_invoice()
	{
		if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

		$subject = 'IOR Shipping Invoice Status';
		$template = 'emails/success_ior_shipping.php';

		$shipping_invoice_id = $this->input->post('id');

		$date_today = date('Y-m-d');

		$updated_by = $this->session->userdata('user_id');
		$updated_at = date('Y-m-d H:i:s');

		$q_shipping_invoice_id = $this->Shipping_invoices_model->fetch_shipping_invoice_by_id($shipping_invoice_id);
		$shipping_invoice = $q_shipping_invoice_id->row();

		$contact_person = $shipping_invoice->contact_person;

		$result = $this->Shipping_invoices_model->paid_shipping_invoice($shipping_invoice_id, $date_today, $updated_by, $updated_at);

		if ($result == 1) {
			$this->send_mail($shipping_invoice->email, $template, '', $subject, $contact_person);
			echo $result;
		}
	}

	public function do_upload()
	{

		$current_timestamp = now();
		$upload_path_file = 'uploads/shipping_invoice_custom_report';

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

	public function completed_shipping_invoice()
	{
		if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

		$subject = 'IOR Shipping Invoice Status';
		$template = 'emails/notification_completed.php';

		$custom_report_filename = $this->input->post('custom_report_filename');
		$shipping_invoice_id = $this->input->post('custom_report_id');

		$updated_by = $this->session->userdata('user_id');
		$updated_at = date('Y-m-d H:i:s');

		$q_shipping_invoices_id = $this->Shipping_invoices_model->fetch_shipping_invoice_by_id($shipping_invoice_id);
		$shipping_invoices = $q_shipping_invoices_id->row();

		$contact_person = $shipping_invoices->contact_person;

		$result = $this->Shipping_invoices_model->completed_shipping_invoice($shipping_invoice_id, $custom_report_filename, $updated_by, $updated_at);

		if ($result == 1) {
			$this->send_mail($shipping_invoices->email, $template, '', $subject, $contact_person);
			echo $result;
		}
	}

	public function revision_shipping_invoice()
	{
		if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

		$this->users->clear_apost();

		$subject = 'IOR Shipping Invoice Status';
		$template = 'emails/notification_revision.php';

		$shipping_invoice_id = $this->input->post('id');
		$message = $this->input->post('message');

		$created_by = $this->session->userdata('user_id');
		$created_at = date('Y-m-d H:i:s');


		$q_shipping_invoices_id = $this->Shipping_invoices_model->fetch_shipping_invoice_by_id($shipping_invoice_id);
		$shipping_invoices = $q_shipping_invoices_id->row();

		$contact_person = $shipping_invoices->contact_person;

		$this->Shipping_invoices_model->revision_shipping_invoice($shipping_invoice_id, $created_by, $created_at);
		$result = $this->Shipping_invoices_model->create_revision_message($shipping_invoice_id, $message, $created_by, $created_at);

		if ($result == 1) {
			$this->send_mail($shipping_invoices->email, $template, $message, $subject, $contact_person);
			echo $result;
		}
	}

	public function arrived_shipping_invoice()
	{
		if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

		$subject = 'IOR Shipping Invoice Status';
		$template = 'emails/notification_arrived.php';

		$shipping_invoice_id = $this->input->post('id');

		$approved_date = date('Y-m-d');
		$updated_by = $this->session->userdata('user_id');
		$updated_at = date('Y-m-d H:i:s');

		$q_shipping_invoice_id = $this->Shipping_invoices_model->fetch_shipping_invoice_by_id($shipping_invoice_id);
		$shipping_invoice = $q_shipping_invoice_id->row();

		$contact_person = $shipping_invoice->contact_person;

		$result = $this->Shipping_invoices_model->arrived_shipping_invoice($shipping_invoice_id, $updated_by, $approved_date, $updated_by, $updated_at);

		if ($result == 1) {
			$this->send_mail($shipping_invoice->email, $template, '', $subject, $contact_person);
			echo $result;
		}
	}

	public function ready_shipping_invoice()
	{
		if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

		$subject = 'IOR Shipping Invoice Status';
		$template = 'emails/notification_ready.php';

		$shipping_invoice_id = $this->input->post('id');

		$approved_date = date('Y-m-d');
		$updated_by = $this->session->userdata('user_id');
		$updated_at = date('Y-m-d H:i:s');

		$q_shipping_invoice_id = $this->Shipping_invoices_model->fetch_shipping_invoice_by_id($shipping_invoice_id);
		$shipping_invoice = $q_shipping_invoice_id->row();

		$contact_person = $shipping_invoice->contact_person;

		$result = $this->Shipping_invoices_model->ready_shipping_invoice($shipping_invoice_id, $updated_by, $approved_date, $updated_by, $updated_at);

		if ($result == 1) {
			$this->send_mail($shipping_invoice->email, $template, '', $subject, $contact_person);
			echo $result;
		}
	}

	public function view_revisions_message()
	{
		if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
        }

		$data['external_page'] = 0;
		$data['active_page'] = "shipping_invoices";
		$data['active_url'] = "shipping_invoices";

		$shipping_invoice_id = $this->uri->segment(3);

		$data['revision_message'] = $this->Shipping_invoices_model->fetch_latest_revision_message($shipping_invoice_id);

		$q_shipping_invoice_id = $this->Shipping_invoices_model->fetch_shipping_invoice_by_id($shipping_invoice_id);
		$data['shipping_invoice'] = $q_shipping_invoice_id->row();

		$data['page_view'] = 'shipping_invoices/view_revisions_message';
		$this->load->view('page', $data);
	}

	public function send_mail($to_email, $template, $custom, $subject, $contact_person)
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
