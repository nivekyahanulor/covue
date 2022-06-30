<?php
date_default_timezone_set("Asia/Tokyo");

class Users extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'date'));
		$this->load->library(array('form_validation', 'session', 'upload', 'phpmailer_library'));
		$this->load->model('Users_model');
	}

	public function admin()
	{
		if ($this->session->userdata('logged_in') == '1') {
			redirect('/product-registrations/pending');
		} else {
			$data['active_page'] = "login";
			$data['external_page'] = 4;
			$data['page_view'] = 'users/login';
			$this->load->view('page', $data);
		}
	}

	public function clear_apost()
	{
		foreach ($_POST as $key => $value) {
			$_POST[$key] = str_replace("'", "&apos;", $value);
		}
	}

	public function logged_in()
	{
		if ($this->session->userdata('user_role_id') == '1' && $this->session->userdata('logged_in') == '1') {
			return true;
		} else {
			$this->session->set_userdata('admin', 0);
			$this->session->set_userdata('user_role_id', 0);
			$this->session->set_userdata('contact_person', "");
			$this->session->set_userdata('user_id', 0);
			$this->session->set_userdata('user_level', 0);
			$this->session->set_userdata('department', 0);
			$this->session->set_userdata('logged_in', '0');
			return false;
		}
	}

	public function login()
	{
		$username = stripslashes($this->input->post('username'));
		$password = stripslashes($this->input->post('password'));

		$q_users = $this->Users_model->login($username, $password);

		if ($q_users == '0') {
			$this->session->set_userdata('logged_in', '0');
			redirect('users/admin/?loginerror=1');
		} else {
			foreach ($q_users->result_array() as $row) {
				if ($row['user_role_id'] == 1) {
					$contact_person = $row['contact_person'];
					$user_id = $row['id'];
					$user_level = $row['user_level'];
					$department = $row['department'];

					$this->session->set_userdata('admin', $row['super_admin']);
					$this->session->set_userdata('user_role_id', $row['user_role_id']);
					$this->session->set_userdata('contact_person', $contact_person);
					$this->session->set_userdata('user_id', $user_id);
					$this->session->set_userdata('user_level', $user_level);
					$this->session->set_userdata('department', $department);
					$this->session->set_userdata('logged_in', '1');
				}
			}
			if ($row['user_role_id'] == 1) {
				redirect('/product-registrations/pending');
			} else {
				$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
				redirect('/users/admin');
			}
		}
	}

	public function logout()
	{
		$this->session->set_userdata('admin', 0);
		$this->session->set_userdata('user_role_id', 0);
		$this->session->set_userdata('contact_person', "");
		$this->session->set_userdata('user_id', 0);
		$this->session->set_userdata('user_level', 0);
		$this->session->set_userdata('department', 0);
		$this->session->set_userdata('logged_in', '0');

		redirect('/users/admin');
	}

	public function admin_users()
	{
		if (!$this->logged_in()) {
			$this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
			redirect('/users/admin');
		}

		$data['external_page'] = 0;
		$data['active_page'] = "users/admin_users";
		$data['page_view'] = 'users/admin_users';

		$q_all_users = $this->Users_model->fetch_all_admin();
		$data['users'] = $q_all_users->result();

		$this->load->view('page', $data);
	}

	public function listing()
	{
		if (!$this->logged_in()) {
			redirect('/');
		}

		$data['external_page'] = 0;
		$data['active_page'] = "users/listing";
		$data['page_view'] = 'users/listing';

		$q_all_users = $this->Users_model->fetch_all_users();
		$data['users'] = $q_all_users->result();

		$this->load->view('page', $data);
	}

	public function consultant_listing()
	{
		if (!$this->logged_in()) {
			redirect('/');
		}

		$data['external_page'] = 0;
		$data['active_page'] = "users/consultant_listing";
		$data['page_view'] = 'users/consultant_listing';

		$q_all_users = $this->Users_model->fetch_all_consultant_users();
		$data['users'] = $q_all_users->result();

		$this->load->view('page', $data);
	}

	public function add_admin_users()
	{
		if (!$this->logged_in()) {
			redirect('/');
		}

		$this->clear_apost();

		$data['external_page'] = 0;
		$data['active_page'] = "users/admin_users";
		$data['page_view'] = 'users/add_admin_users';

		$q_fetch_countries = $this->Users_model->fetch_countries();
		$data['countries'] = $q_fetch_countries->result();

		$q_all_users = $this->Users_model->fetch_all_admin();
		$data['users'] = $q_all_users->result();

		$q_department = $this->Users_model->fetch_department();
		$data['department'] = $q_department->result();

		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('contact_person', 'Name', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('department', 'Department', 'trim|required');
			$this->form_validation->set_rules('user_level', 'User Level ', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->load->view('page', $data);
			} else {
				$username = stripslashes($this->input->post('username'));
				$password = stripslashes($this->input->post('password'));
				$contact_person = stripslashes($this->input->post('contact_person'));
				$email = stripslashes($this->input->post('email'));
				$department = stripslashes($this->input->post('department'));
				$department_head = stripslashes($this->input->post('department_head'));
				$user_level = stripslashes($this->input->post('user_level'));
				$created_at = date('Y-m-d H:i:s');
				$created_by = $this->session->userdata('user_id');

				$result = $this->Users_model->insert_new_admin_user($username, $password, $contact_person, $email, $department, $department_head, $user_level, $created_at, $created_by);

				if ($result == 1) {
					$this->session->set_flashdata('success', 'Successfully added new admin user!');
					redirect('users/admin-users', 'refresh');
				} else {
					$data['errors'] = 1;
					$this->load->view('page', $data);
				}
			}
		} else {
			$this->load->view('page', $data);
		}
	}
	public function add_users()
	{
		if (!$this->logged_in()) {
			redirect('/');
		}

		$this->clear_apost();

		$data['external_page'] = 0;
		$data['active_page'] = "users/listing";
		$data['page_view'] = 'users/add_users';

		$q_fetch_countries = $this->Users_model->fetch_countries();
		$data['countries'] = $q_fetch_countries->result();

		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('company_name', 'Legal Company Name', 'trim|required');
			$this->form_validation->set_rules('company_address', 'Company Address', 'trim|required');
			$this->form_validation->set_rules('city', 'City', 'trim|required');
			$this->form_validation->set_rules('country', 'Country', 'trim|required|integer');
			$this->form_validation->set_rules('zip_code', 'Zip Code', 'trim|required');
			$this->form_validation->set_rules('business_license', 'Business License Number', 'trim|required');
			$this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|required');
			$this->form_validation->set_rules('contact_person', 'Primary Contact Person', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('ior_registered', 'IOR Registration', 'trim|required');
			$this->form_validation->set_rules('online_seller', 'Online Seller', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$q_fetch_countries = $this->Users_model->fetch_countries();
				$data['countries'] = $q_fetch_countries->result();
				$this->load->view('page', $data);
			} else {
				$username = stripslashes($this->input->post('username'));
				$password = stripslashes($this->input->post('password'));
				$company_name = stripslashes($this->input->post('company_name'));
				$company_address = stripslashes($this->input->post('company_address'));
				$city = stripslashes($this->input->post('city'));
				$country = stripslashes($this->input->post('country'));
				$zip_code = stripslashes($this->input->post('zip_code'));
				$business_license = stripslashes($this->input->post('business_license'));
				$contact_number = stripslashes($this->input->post('contact_number'));
				$contact_person = stripslashes($this->input->post('contact_person'));
				$email = stripslashes($this->input->post('email'));
				$ior_registered = $this->input->post('ior_registered');
				$online_seller = $this->input->post('online_seller');
				$created_at = date('Y-m-d H:i:s');
				$created_by = $this->session->userdata('user_id');

				$result = $this->Users_model->insert_new_user($username, $password, $company_name, $company_address, $city, $country, $zip_code, $business_license, $contact_number, $contact_person, $email, $ior_registered, $online_seller, $created_at, $created_by);

				if ($result == 1) {
					$q_country = $this->Users_model->fetch_country_by_id($country);
					$countries = $q_country->row();
					$accnt_Data = array(
						'company_name' => $company_name,
						'company_address' => $company_address,
						'city' => $city,
						'zip_code' => $zip_code,
						'country' => $countries->nicename,
						'contact_person' => $contact_person,
						'contact_number' => $contact_number,
						'email' => $email
					);
					$this->Users_model->create_zoho_account($accnt_Data);
					$this->session->set_flashdata('success', 'Successfully added new user!');
					redirect('users/listing', 'refresh');
				} else {
					$data['errors'] = 1;

					$q_fetch_countries = $this->Users_model->fetch_countries();
					$data['countries'] = $q_fetch_countries->result();

					$this->load->view('page', $data);
				}
			}
		} else {
			$this->load->view('page', $data);
		}
	}

	public function add_consultant()
	{
		if (!$this->logged_in()) {
			redirect('/');
		}


		$this->clear_apost();

		$data['external_page'] = 0;
		$data['active_page'] = "users/consultant_listing";
		$data['page_view'] = 'users/add_consultant';

		$q_fetch_countries = $this->Users_model->fetch_countries();
		$data['countries'] = $q_fetch_countries->result();

		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('company_name', 'Legal Company Name', 'trim|required');
			$this->form_validation->set_rules('contact_person', 'Primary Contact Person', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('country', 'Country', 'trim|required|integer');
			$this->form_validation->set_rules('header_title', 'Landing Page Header Title', 'required');
			$this->form_validation->set_rules('content', 'Landing Page Content', 'required');

			if ($this->form_validation->run() == FALSE) {
				$q_fetch_countries = $this->Users_model->fetch_countries();
				$data['countries'] = $q_fetch_countries->result();

				$data['page_view'] = 'users/add_consultant';
				$this->load->view('page', $data);
			} else {
				$username = stripslashes($this->input->post('username'));
				$password = stripslashes($this->input->post('password'));
				$company_name = stripslashes($this->input->post('company_name'));
				$country = stripslashes($this->input->post('country'));
				$contact_person = stripslashes($this->input->post('contact_person'));
				$email = stripslashes($this->input->post('email'));
				$content = stripslashes($this->input->post('content'));
				$header_title = stripslashes($this->input->post('header_title'));

				$header_color = stripslashes($this->input->post('header_color'));
				if ($header_color != "") {
					$hcolor = stripslashes($this->input->post('header_color'));
				} else {
					$hcolor = stripslashes($this->input->post('header'));
				}

				$footer_color = stripslashes($this->input->post('footer_color'));
				if ($footer_color != "") {
					$fcolor = stripslashes($this->input->post('footer_color'));
				} else {
					$fcolor = stripslashes($this->input->post('footer'));
				}

				$created_at = date('Y-m-d H:i:s');

				//** LOGO */
				$image = addslashes(file_get_contents($_FILES['logo']['tmp_name']));
				$image_name = addslashes($_FILES['logo']['name']);
				$image_size = getimagesize($_FILES['logo']['tmp_name']);

				$path       = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
				$filename   = 'consultants_' . time() . '.' . $path;

				//** BANNER */
				$image1 = addslashes(file_get_contents($_FILES['banner']['tmp_name']));
				$image_name1 = addslashes($_FILES['banner']['name']);
				$image_size1 = getimagesize($_FILES['banner']['tmp_name']);

				$path1       = pathinfo($_FILES["banner"]["name"], PATHINFO_EXTENSION);
				$filename1   = 'consultants_banner_' . time() . '.' . $path1;

				//** BACKGROUND */
				$image2 = addslashes(file_get_contents($_FILES['background']['tmp_name']));
				$image_name2 = addslashes($_FILES['background']['name']);
				$image_size2 = getimagesize($_FILES['background']['tmp_name']);

				$path2       = pathinfo($_FILES["background"]["name"], PATHINFO_EXTENSION);
				$filename2   = 'consultants_background_' . time() . '.' . $path2;

				move_uploaded_file($_FILES["logo"]["tmp_name"], "uploads/consultants/" . $filename);
				move_uploaded_file($_FILES["banner"]["tmp_name"], "uploads/consultants/" . $filename1);
				move_uploaded_file($_FILES["background"]["tmp_name"], "uploads/consultants/" . $filename2);

				$result = $this->Users_model->insert_new_consultant($username, $password, $company_name, $country, $contact_person, $email, $filename, $header_title, $content, $filename1, $filename2, $hcolor, $fcolor, $created_at);

				if ($result == 1) {
					$this->session->set_flashdata('success', 'Successfully added a new Amazon Consultant!');
					redirect('users/consultant-listing', 'refresh');
				} else if ($result == 2) {
					$data['errors'] = 2;

					$q_fetch_countries = $this->Users_model->fetch_countries();
					$data['countries'] = $q_fetch_countries->result();

					$data['page_view'] = 'users/add_consultant';
					$this->load->view('page', $data);
				} else {
					$data['errors'] = 1;

					$q_fetch_countries = $this->Users_model->fetch_countries();
					$data['countries'] = $q_fetch_countries->result();

					$data['page_view'] = 'users/add_consultant';
					$this->load->view('page', $data);
				}
			}
		} else {
			$this->load->view('page', $data);
		}
	}

	public function edit_admin_users()
	{
		if (!$this->logged_in()) {
			redirect('/');
		}

		$this->clear_apost();

		$data['external_page'] = 0;
		$data['active_page'] = "users/admin_users";
		$data['page_view'] = 'users/edit_admin_users';

		$get_id = $this->uri->segment(3);

		$q_user_details = $this->Users_model->fetch_users_by_id($get_id);
		$data['user_details'] = $q_user_details->row();

		$q_all_users = $this->Users_model->fetch_all_admin();
		$data['users'] = $q_all_users->result();

		$q_department = $this->Users_model->fetch_department();
		$data['department'] = $q_department->result();

		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('contact_person', 'Name', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('department', 'Department', 'trim|required');
			$this->form_validation->set_rules('user_level', 'User Level ', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$q_user_details = $this->Users_model->fetch_users_by_id($get_id);
				$data['user_details'] = $q_user_details->row();
				$this->load->view('page', $data);
			} else {
				$username = stripslashes($this->input->post('username'));
				$password = stripslashes($this->input->post('password'));
				$contact_person = stripslashes($this->input->post('contact_person'));
				$email = stripslashes($this->input->post('email'));
				$department = stripslashes($this->input->post('department'));
				$department_head = stripslashes($this->input->post('department_head'));
				$user_level = stripslashes($this->input->post('user_level'));
				$updated_at = date('Y-m-d H:i:s');
				$updated_by = $this->session->userdata('user_id');

				$result = $this->Users_model->update_admin_user($get_id, $username, $password, $contact_person, $email, $department, $department_head, $user_level,  $updated_at, $updated_by);

				if ($result == 1) {
					$this->session->set_flashdata('success', 'Successfully updated the admin user!');
					redirect('users/admin_users', 'refresh');
				} else {
					$data['errors'] = 1;

					$q_user_details = $this->Users_model->fetch_users_by_id($get_id);
					$data['user_details'] = $q_user_details->row();

					$q_fetch_countries = $this->Users_model->fetch_countries();
					$data['countries'] = $q_fetch_countries->result();

					$this->load->view('page', $data);
				}
			}
		} else {
			$this->load->view('page', $data);
		}
	}
	public function edit_users()
	{
		if (!$this->logged_in()) {
			redirect('/');
		}

		$this->clear_apost();

		$data['external_page'] = 0;
		$data['active_page'] = "users/listing";
		$data['page_view'] = 'users/edit_users';

		$get_id = $this->uri->segment(3);

		$q_user_details = $this->Users_model->fetch_users_by_id($get_id);
		$data['user_details'] = $q_user_details->row();

		$q_fetch_countries = $this->Users_model->fetch_countries();
		$data['countries'] = $q_fetch_countries->result();

		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('company_name', 'Legal Company Name', 'trim|required');
			$this->form_validation->set_rules('company_address', 'Company Address', 'trim|required');
			$this->form_validation->set_rules('city', 'City', 'trim|required');
			$this->form_validation->set_rules('country', 'Country', 'trim|required|integer');
			$this->form_validation->set_rules('zip_code', 'Zip Code', 'trim|required');
			$this->form_validation->set_rules('business_license', 'Business License Number', 'trim|required');
			$this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|required');
			$this->form_validation->set_rules('contact_person', 'Primary Contact Person', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('ior_registered', 'IOR Registration', 'trim|required');
			$this->form_validation->set_rules('online_seller', 'Online Seller', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$q_user_details = $this->Users_model->fetch_users_by_id($get_id);
				$data['user_details'] = $q_user_details->row();

				$q_fetch_countries = $this->Users_model->fetch_countries();
				$data['countries'] = $q_fetch_countries->result();

				$this->load->view('page', $data);
			} else {
				$q_user_details_before = $this->Users_model->fetch_users_by_id($get_id);
				$user_details_before = $q_user_details_before->row();

				$username = stripslashes($this->input->post('username'));
				$password = stripslashes($this->input->post('password'));
				$company_name = stripslashes($this->input->post('company_name'));
				$company_address = stripslashes($this->input->post('company_address'));
				$city = stripslashes($this->input->post('city'));
				$country = stripslashes($this->input->post('country'));
				$zip_code = stripslashes($this->input->post('zip_code'));
				$business_license = stripslashes($this->input->post('business_license'));
				$contact_number = stripslashes($this->input->post('contact_number'));
				$contact_person = stripslashes($this->input->post('contact_person'));
				$email = stripslashes($this->input->post('email'));
				$ior_registered = $this->input->post('ior_registered');
				$online_seller = $this->input->post('online_seller');

				$updated_at = date('Y-m-d H:i:s');
				$updated_by = $this->session->userdata('user_id');

				$result = $this->Users_model->update_user($get_id, $username, $password, $company_name, $company_address, $city, $country, $zip_code, $business_license, $contact_number, $contact_person, $email, $ior_registered, $online_seller, $updated_at, $updated_by);

				if ($result == 1) {
					if ($ior_registered == 1 && $user_details_before->ior_registered == 0) {
						$subject = 'Covue IOR Registration Status';
						$template = 'emails/success_ior_registration.php';
						$q_fetch_user = $this->Users_model->fetch_users_by_id($get_id);
						$fetch_user = $q_fetch_user->row();
						$contact_person = $fetch_user->contact_person;
						$this->send_mail($fetch_user->email, $template, $subject, $contact_person);
					}

					$data['errors'] = 0;

					$q_user_details = $this->Users_model->fetch_users_by_id($get_id);
					$data['user_details'] = $q_user_details->row();

					$q_fetch_countries = $this->Users_model->fetch_countries();
					$data['countries'] = $q_fetch_countries->result();

					$q_country = $this->Users_model->fetch_country_by_id($country);
					$countries = $q_country->row();

					$accnt_Data = array(
						'company_name' => $company_name,
						'company_address' => $company_address,
						'city' => $city,
						'zip_code' => $zip_code,
						'country' => $countries->nicename,
						'contact_person' => $contact_person,
						'contact_number' => $contact_number,
						'email' => $email
					);

					$search_res = $this->Users_model->sync_user_update($company_name);
					$update_res = $this->Users_model->update_zoho_account(json_decode($search_res)->data[0]->id,$accnt_Data);

					
					// var_dump($update_res);

					$this->load->view('page', $data);
				} else {
					$data['errors'] = 1;

					$q_user_details = $this->Users_model->fetch_users_by_id($get_id);
					$data['user_details'] = $q_user_details->row();

					$q_fetch_countries = $this->Users_model->fetch_countries();
					$data['countries'] = $q_fetch_countries->result();

					$this->load->view('page', $data);
				}
			}
		} else {
			$this->load->view('page', $data);
		}
	}

	public function edit_consultant()
	{
		if (!$this->logged_in()) {
			redirect('/');
		}

		$this->clear_apost();

		$data['external_page'] = 0;
		$data['active_page'] = "users/consultant_listing";
		$data['page_view'] = 'users/edit_consultant';

		$get_id = $this->uri->segment(3);

		$q_user_details = $this->Users_model->fetch_consultant_by_id($get_id);
		$data['user_details'] = $q_user_details->row();

		$q_fetch_countries = $this->Users_model->fetch_countries();
		$data['countries'] = $q_fetch_countries->result();

		$data['user_id'] = $this->session->userdata('user_id');

		if (isset($_POST['uploadlogo'])) {
			$result = $this->Users_model->upload_logo($_POST, $data['user_details']->consultant_id);
			if ($result == 1) {
				$this->session->set_flashdata('success-logo', 'Logo upload Success!');
				redirect('users/edit_consultant/' . $data['user_details']->consultant_id, 'refresh');
			}
		}

		if (isset($_POST['updatebanner'])) {
			$result = $this->Users_model->update_banner($_POST, $data['user_details']->consultant_id);
			if ($result == 1) {
				$this->session->set_flashdata('success-banner', 'Banner Updated Successfully!');
				redirect('users/edit_consultant/' . $data['user_details']->consultant_id, 'refresh');
			}
		}

		if (isset($_POST['updatebackground'])) {
			$result = $this->Users_model->update_background($_POST, $data['user_details']->consultant_id);
			if ($result == 1) {
				$this->session->set_flashdata('success-background', 'Background Updated Successfully!');
				redirect('users/edit_consultant/' . $data['user_details']->consultant_id, 'refresh');
			}
		}

		if (isset($_POST['updatecontent'])) {
			$result = $this->Users_model->update_content($_POST, $data['user_details']->consultant_id);
			if ($result == 1) {
				$this->session->set_flashdata('success-content', 'Content Updated Successfully!');
				redirect('users/edit_consultant/' . $data['user_details']->consultant_id, 'refresh');
			}
		}

		if (isset($_POST['updateheadertitle'])) {
			$result = $this->Users_model->update_header_title($_POST, $data['user_details']->consultant_id);
			if ($result == 1) {
				$this->session->set_flashdata('success-header-title', 'Header Title Updated Successfully!');
				redirect('users/edit_consultant/' . $data['user_details']->consultant_id, 'refresh');
			}
		}

		if (isset($_POST['updateheadercolor'])) {
			$result = $this->Users_model->update_color_header($_POST, $data['user_details']->consultant_id);
			if ($result == 1) {
				$this->session->set_flashdata('success-header-color', 'Header Color Updated Successfully!');
				redirect('users/edit_consultant/' . $data['user_details']->consultant_id, 'refresh');
			}
		}

		if (isset($_POST['updatefootercolor'])) {
			$result = $this->Users_model->update_color_footer($_POST, $data['user_details']->consultant_id);
			if ($result == 1) {
				$this->session->set_flashdata('success-footer-color', 'Footer Color Updated Successfully!');
				redirect('users/edit_consultant/' . $data['user_details']->consultant_id, 'refresh');
			}
		}


		$this->load->view('page', $data);
	}

	public function edit_consultant_info()
	{
		if (!$this->logged_in()) {
			redirect('/');
		}

		$this->clear_apost();

		$data['external_page'] = 0;
		$data['active_page'] = "users/consultant_listing";
		$data['page_view'] = 'users/edit_consultant_info';

		$get_id = $this->uri->segment(3);

		$q_user_details = $this->Users_model->fetch_consultant_by_id($get_id);
		$data['user_details'] = $q_user_details->row();

		$q_fetch_countries = $this->Users_model->fetch_countries();
		$data['countries'] = $q_fetch_countries->result();

		$data['user_id'] = $this->session->userdata('user_id');



		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('company_name', 'Legal Company Name', 'trim|required');
			$this->form_validation->set_rules('country', 'Country', 'trim|required|integer');
			$this->form_validation->set_rules('contact_person', 'Primary Contact Person', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			// $this->form_validation->set_rules('terms', 'Terms and Condition', 'required');
			// $this->form_validation->set_rules('content', 'Landing Page Content', 'required');

			if ($this->form_validation->run() == FALSE) {
				$q_user_details = $this->Users_model->fetch_consultant_by_id($get_id);
				$data['user_details'] = $q_user_details->row();

				$q_fetch_countries = $this->Users_model->fetch_countries();
				$data['countries'] = $q_fetch_countries->result();

				$this->load->view('page', $data);
			} else {
				$q_user_details_before = $this->Users_model->fetch_consultant_by_id($get_id);
				$user_details_before = $q_user_details_before->row();

				$username = stripslashes($this->input->post('username'));
				$password = stripslashes($this->input->post('password'));
				$company_name = stripslashes($this->input->post('company_name'));
				// $company_address = stripslashes($this->input->post('company_address'));
				// $city = stripslashes($this->input->post('city'));
				$country = stripslashes($this->input->post('country'));
				// $zip_code = stripslashes($this->input->post('zip_code'));
				// $business_license = stripslashes($this->input->post('business_license'));
				// $contact_number = stripslashes($this->input->post('contact_number'));
				$contact_person = stripslashes($this->input->post('contact_person'));
				$email = stripslashes($this->input->post('email'));
				// $ior_registered = $this->input->post('ior_registered');
				// $online_seller = $this->input->post('online_seller');

				$updated_at = date('Y-m-d H:i:s');
				$updated_by = $this->session->userdata('user_id');

				$result = $this->Users_model->update_consultant_user($get_id, $username, $password, $company_name, $country, $contact_person, $email, $updated_at, $updated_by);

				if ($result == 1) {
					// if ($ior_registered == 1 && $user_details_before->ior_registered == 0) {
					// 	$subject = 'Covue IOR Registration Status';
					// 	$template = 'emails/success_ior_registration.php';
					// 	$q_fetch_user = $this->Users_model->fetch_consultant_by_id($get_id);
					// 	$fetch_user = $q_fetch_user->row();
					// 	$contact_person = $fetch_user->contact_person;
					// 	$this->send_mail($fetch_user->email, $template, $subject, $contact_person);
					// }

					$data['errors'] = 0;

					// $get_id = $this->uri->segment(3);

					// $q_user_details = $this->Users_model->fetch_consultant_by_id($get_id);
					// $data['user_details'] = $q_user_details->row();

					// $q_fetch_countries = $this->Users_model->fetch_countries();
					// $data['countries'] = $q_fetch_countries->result();

					// $data['user_id'] = $this->session->userdata('user_id');
					$this->session->set_flashdata('success-footer-color', 'Consultant Info has been updated!');
					redirect('users/edit_consultant_info/' . $data['user_details']->consultant_id, 'refresh');
				} else {
					$data['errors'] = 1;

					// $get_id = $this->uri->segment(3);

					// $q_user_details = $this->Users_model->fetch_consultant_by_id($get_id);
					// $data['user_details'] = $q_user_details->row();

					// $q_fetch_countries = $this->Users_model->fetch_countries();
					// $data['countries'] = $q_fetch_countries->result();

					// $data['user_id'] = $this->session->userdata('user_id');

					$this->load->view('page', $data);
				}
			}
		} else {
			$this->load->view('page', $data);
		}
	}

	public function paid_pli()
	{
		if (!$this->logged_in()) {
			redirect('/');
		}

		$user_id = $this->input->post('id');

		$updated_at = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('user_id');

		$result = $this->Users_model->paid_pli($user_id, $updated_at, $updated_by);

		$subject = 'Product Liability Insurance Payment Status';
		$template = 'emails/success_pli_payment.php';
		$q_fetch_user = $this->Users_model->fetch_users_by_id($user_id);
		$fetch_user = $q_fetch_user->row();
		$contact_person = $fetch_user->contact_person;
		$this->send_mail($fetch_user->email, $template, $subject, $contact_person);

		echo $result;
	}

	public function paid_product_label()
	{
		if (!$this->logged_in()) {
			redirect('/');
		}

		$user_id = $this->input->post('id');

		$updated_at = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('user_id');

		$result = $this->Users_model->paid_product_label($user_id, $updated_at, $updated_by);

		$subject = 'Product Label Payment Status';
		$template = 'emails/success_label_payment.php';
		$q_fetch_user = $this->Users_model->fetch_users_by_id($user_id);
		$fetch_user = $q_fetch_user->row();
		$contact_person = $fetch_user->contact_person;
		$this->send_mail($fetch_user->email, $template, $subject, $contact_person);

		echo $result;
	}

	public function delete_user()
	{
		if (!$this->logged_in()) {
			redirect('/');
		}

		$user_id = $this->input->post('id');

		$updated_at = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('user_id');

		$result = $this->Users_model->delete_user($user_id, $updated_at, $updated_by);

		echo $result;
	}

	public function sync_user()
	{
		if (!$this->logged_in()) {
			redirect('/');
		}

		$user_id = $this->input->post('id');

		$updated_at = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('user_id');
		$q_user_details = $this->Users_model->fetch_users_by_id($user_id);
		$data = $q_user_details->row();

		$result = $this->Users_model->sync_user($data);

		$res_data = array(
			'local_data' => $data,
			'result_data' => json_decode($result)
		);

		echo json_encode($res_data);
	}

	public function add_user_zoho()
	{
		if (!$this->logged_in()) {
			redirect('/');
		}

		$data = $this->input->post('data');


		$result = $this->Users_model->create_zoho_account($data);

		// $res_data = array(
		// 	'local_data' => $data,
		// 	'result_data' => json_decode($result)
		// );

		echo json_encode($result);
	}

	public function update_user_zoho()
	{
		if (!$this->logged_in()) {
			redirect('/');
		}

		$data = $this->input->post('data');
		$id = $this->input->post('id');


		$result = $this->Users_model->update_zoho_account($id,$data);

		// $res_data = array(
		// 	'local_data' => $data,
		// 	'result_data' => json_decode($result)
		// );

		echo json_encode($result);
	}

	public function delete_consultant()
	{
		if (!$this->logged_in()) {
			redirect('/');
		}

		$user_id = $this->input->post('id');

		$updated_at = date('Y-m-d H:i:s');
		$updated_by = $this->session->userdata('user_id');

		$result = $this->Users_model->delete_user($user_id, $updated_at, $updated_by);

		echo $result;
	}

	public function notice_addendum()
	{
		if (!$this->logged_in()) {
			redirect('/');
		}

		$data['external_page'] = 0;
		$data['active_page'] = "users/listing";
		$data['page_view'] = 'users/notice_addendum';

		$q_user_details = $this->Users_model->fetch_users_by_id($this->session->userdata('user_id'));
		$data['user_details'] = $q_user_details->row();

		if (isset($_POST['submit'])) {
			if (!empty($_FILES['notice_addendum']['name'])) {
				$current_timestamp = now();
				$upload_path_file = 'uploads/docs/';
				$ext = pathinfo($_FILES['notice_addendum']['name'], PATHINFO_EXTENSION);
				$file_name = 'notice_and_addendum.' . $ext;

				if (!file_exists($upload_path_file)) {
					mkdir($upload_path_file, 0777, true);
				} else {
					if (file_exists($upload_path_file . $file_name)) {
						rename($upload_path_file . $file_name, $upload_path_file . 'notice_and_addendum_' . $current_timestamp . '.' . $ext);
					}
				}

				$config['upload_path'] = $upload_path_file;
				$config['allowed_types'] = 'pdf';
				$config['max_size'] = 5000000;
				$config['file_name'] = $file_name;

				$this->upload->initialize($config);

				if (!$this->upload->do_upload('notice_addendum')) {
					$data['errors'] = 2;
					$data['error_msgs'] = $this->upload->display_errors();
					$this->load->view('page', $data);
				} else {
					$data['errors'] = 0;
					$this->load->view('page', $data);
				}
			} else {
				$data['errors'] = 1;
				$this->load->view('page', $data);
			}
		} else {
			$this->load->view('page', $data);
		}
	}

	public function send_mail($to_email, $template, $subject, $contact_person)
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
