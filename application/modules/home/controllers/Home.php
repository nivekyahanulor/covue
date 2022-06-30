<?php
date_default_timezone_set("Asia/Tokyo");
// require_once APPPATH . "libraries/zoho_sdk/vendor/autoload.php";
require_once(APPPATH.'modules/zoho_sdk/controllers/Zoho_sdk.php'); 
// use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
// use zcrmsdk\oauth\ZohoOAuth;
// use zcrmsdk\crm\crud\ZCRMRecord;
class Home extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(["form", "date", "text"]);
        $this->load->library(["form_validation", "session", "upload"]);
        $this->load->model("Home_model");
        $this->load->library("phpmailer_library");
    }

    public function logged_in_external()
    {
        if (
            $this->session->userdata("admin") != "1" &&
            $this->session->userdata("logged_in") == "1"
        ) {
            return true;
        } else {
            $this->session->set_userdata("admin", 0);
            $this->session->set_userdata("contact_person", "");
            $this->session->set_userdata("user_id", 0);
            $this->session->set_userdata("logged_in", "0");
            return false;
        }
    }

    public function clear_apost()
    {
        foreach ($_POST as $key => $value) {
            $_POST[$key] = str_replace("'", "&apos;", $value);
        }
    }

    public function index()
    {
        if (!$this->logged_in_external()) {
            $this->session->set_userdata("admin", 0);
            $this->session->set_userdata("contact_person", "");
            $this->session->set_userdata("user_id", 0);
            $this->session->set_userdata("logged_in", "0");
        }

        $this->session->set_flashdata("modal_holidays", "Holiday Notice");

        $data["active_page"] = "home";
        $data["external_page"] = 1;
        $data["page_view"] = "home/index";
        $this->load->view("page", $data);
    }

    public function register_link()
    {
        $get1 = $_GET["name"];
        $get2 = base64_decode($_GET["data"]);
        redirect("home/client_signup?name=" . $get1 . "&data=" . $get2);
    }

    public function register_user()
    {
        $get1 = base64_decode($_GET["consultant"]);
        redirect("home/consultant_client_signup?consultant=" . $get1);
    }

    public function login()
    {
        if ($this->logged_in_external()) {
            if ($this->session->userdata("admin") == "partners") {
                redirect("/home/dashboard");
            } else {
                redirect("/japan-ior/dashboard");
            }
        }

        $this->clear_apost();

        $data["external_page"] = 1;
        $data["active_page"] = "home";

        if (isset($_POST["submit"])) {
            $username = stripslashes($this->input->post("username"));
            $password = stripslashes($this->input->post("password"));

            $q_users = $this->Home_model->login($username, $password);

            if ($q_users == "0") {
                $this->session->set_userdata("logged_in", "0");
                redirect("/home/login?error=1");
            } else {
                foreach ($q_users->result_array() as $row) {
                    if ($row["user_role_id"] != 1) {
                        $contact_person = $row["contact_person"];
                        $user_id = $row["id"];

                        $this->session->set_userdata(
                            "admin",
                            $row["super_admin"]
                        );
                        $this->session->set_userdata(
                            "contact_person",
                            $contact_person
                        );
                        $this->session->set_userdata("user_id", $user_id);
                        $this->session->set_userdata(
                            "ior_registered",
                            $row["ior_registered"]
                        );
                        $this->session->set_userdata("pli", $row["pli"]);
                        $this->session->set_userdata("logged_in", "1");
                        $this->session->set_userdata(
                            "user_role_id",
                            $row["user_role_id"]
                        );
                    }
                }

                if ($row["user_role_id"] != 1) {
                    if ($row["ior_registered"] != 1 || $row["pli"] != 1) {
                        redirect("/japan-ior/product-services-fee");
                    } else {
                        redirect("/japan-ior/dashboard");
                    }
                } else {
                    $this->session->set_flashdata(
                        "noaccess",
                        'You don\'t have authorization to view this page!'
                    );
                    redirect("/home/login");
                }
            }
        } else {
            $data["page_view"] = "home/login";
            $this->load->view("page", $data);
        }
    }

    public function dashboard()
    {
        if (!$this->logged_in_external()) {
            redirect("/home/login");
        }

        $data["active_page"] = "home";
        $data["external_page"] = 1;
        $data["page_view"] = "home/dashboard";

        $data["user_id"] = $this->session->userdata("user_id");

        $q_user_details = $this->Home_model->fetch_users_by_id(
            $data["user_id"]
        );
        $data["user_details"] = $q_user_details->row();

        $this->load->view("page", $data);
    }

    public function partner_login()
    {
        if ($this->logged_in_external()) {
            redirect("/japan-ior/dashboard");
        }

        $this->clear_apost();

        $data["external_page"] = 1;
        $data["active_page"] = "home";

        if (isset($_POST["submit"])) {
            $username = stripslashes($this->input->post("username"));
            $password = stripslashes($this->input->post("password"));

            $q_users = $this->Home_model->login_partner($username, $password);

            if ($q_users == "0") {
                $this->session->set_userdata("logged_in", "0");
                redirect("/home/partner-login?loginattempt=1");
            } else {
                foreach ($q_users->result_array() as $row) {
                    $contact_person = $row["shipping_company_name"];
                    $user_id = $row["id"];
                    $logo = $row["logo"];
                    $this->session->set_userdata("admin", "partners");
                    $this->session->set_userdata(
                        "contact_person",
                        $contact_person
                    );
                    $this->session->set_userdata("user_id", $user_id);
                    $this->session->set_userdata("logo", $logo);
                    $this->session->set_userdata("logged_in", "3");
                }
                redirect("/partner-companies/dashboard");
            }
        } else {
            $data["page_view"] = "home/partner_login";
            $this->load->view("page", $data);
        }
    }

    public function consultant_login()
    {
        if ($this->logged_in_external()) {
            redirect("/japan-ior/dashboard");
        }

        $this->clear_apost();

        $data["external_page"] = 1;
        $data["active_page"] = "home";

        if (isset($_POST["submit"])) {
            $username = stripslashes($this->input->post("username"));
            $password = stripslashes($this->input->post("password"));

            $q_users = $this->Home_model->login_consultant(
                $username,
                $password
            );

            if ($q_users == "0") {
                $this->session->set_userdata("logged_in", "0");
                redirect("/home/consultant-login?loginattempt=1");
            } else {
                foreach ($q_users->result_array() as $row) {
                    $contact_person = $row["company_name"];
                    $user_id = $row["id"];
                    $logo = $row["avatar"];
                    $this->session->set_userdata("admin", "partners");
                    $this->session->set_userdata(
                        "contact_person",
                        $contact_person
                    );
                    $this->session->set_userdata("user_id", $user_id);
                    $this->session->set_userdata("logo", $logo);
                    $this->session->set_userdata("logged_in", "3");
                }
                redirect("/consultant/dashboard");
            }
        } else {
            $data["page_view"] = "home/consultant_login";
            $this->load->view("page", $data);
        }
    }

    public function forgot_password()
    {
        $data["external_page"] = 1;
        $data["active_page"] = "home";

        if (isset($_POST["submit"])) {
            $email = stripslashes($this->input->post("email"));

            $q_check_email = $this->Home_model->check_email($email);
            $check_email_count = $q_check_email->num_rows();
            $check_email = $q_check_email->row();

            if ($check_email_count > 0) {
                $subject = "Covue IOR Online Credentials";
                $template = "emails/forgot_password.php";
                $contact_person = $check_email->contact_person;

                $this->send_mail(
                    $check_email->email,
                    $template,
                    $subject,
                    $contact_person,
                    $check_email->username,
                    $check_email->password
                );

                $data["errors"] = 0;
                $data["page_view"] = "home/forgot_password";
                $this->load->view("page", $data);
            } else {
                $data["errors"] = 1;
                $data["page_view"] = "home/forgot_password";
                $this->load->view("page", $data);
            }
        } else {
            $data["page_view"] = "home/forgot_password";
            $this->load->view("page", $data);
        }
    }

    public function partners_forgot_password()
    {
        $data["external_page"] = 1;
        $data["active_page"] = "home";

        if (isset($_POST["submit"])) {
            $email = stripslashes($this->input->post("email"));

            $q_check_email = $this->Home_model->check_partners_email($email);
            $check_email_count = $q_check_email->num_rows();
            $check_email = $q_check_email->row();

            if ($check_email_count > 0) {
                $subject = "Covue IOR Online Credentials";
                $template = "emails/forgot_password.php";
                $contact_person = $check_email->shipping_company_name;

                $this->send_mail(
                    $check_email->email,
                    $template,
                    $subject,
                    $contact_person,
                    $check_email->username,
                    $check_email->password
                );

                $data["errors"] = 0;
                $data["page_view"] = "home/partners_forgot_password";
                $this->load->view("page", $data);
            } else {
                $data["errors"] = 1;
                $data["page_view"] = "home/partners_forgot_password";
                $this->load->view("page", $data);
            }
        } else {
            $data["page_view"] = "home/partners_forgot_password";
            $this->load->view("page", $data);
        }
    }

    public function consultant_forgot_password()
    {
        $data["external_page"] = 1;
        $data["active_page"] = "home";

        if (isset($_POST["submit"])) {
            $email = stripslashes($this->input->post("email"));

            $q_check_email = $this->Home_model->check_email($email);
            $check_email_count = $q_check_email->num_rows();
            $check_email = $q_check_email->row();

            if ($check_email_count > 0) {
                $subject = "Covue IOR Online Credentials";
                $template = "emails/forgot_password.php";
                $contact_person = $check_email->shipping_company_name;

                $this->send_mail(
                    $check_email->email,
                    $template,
                    $subject,
                    $contact_person,
                    $check_email->username,
                    $check_email->password
                );

                $data["errors"] = 0;
                $data["page_view"] = "home/consultant_forgot_password";
                $this->load->view("page", $data);
            } else {
                $data["errors"] = 1;
                $data["page_view"] = "home/consultant_forgot_password";
                $this->load->view("page", $data);
            }
        } else {
            $data["page_view"] = "home/consultant_forgot_password";
            $this->load->view("page", $data);
        }
    }

    public function signup()
    {
        $this->clear_apost();

        $data["external_page"] = 1;
        $data["active_page"] = "home";

        $q_fetch_countries = $this->Home_model->fetch_countries();
        $data["countries"] = $q_fetch_countries->result();

        $q_shipping_company = $this->Home_model->fetch_shipping_companies();
        $data["shipping_companies"] = $q_shipping_company->result();

        if (isset($_POST["submit"])) {
            $this->form_validation->set_rules(
                "username",
                "Username",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "password",
                "Password",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "company_name",
                "Legal Company Name",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "company_address",
                "Company Address",
                "trim|required"
            );
            $this->form_validation->set_rules("city", "City", "trim|required");
            $this->form_validation->set_rules(
                "country",
                "Country",
                "trim|required|integer"
            );
            $this->form_validation->set_rules(
                "zip_code",
                "Zip Code",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "business_license",
                "Business License Number",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "contact_number",
                "Contact Number",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "contact_person",
                "Primary Contact Person",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "email",
                "Email",
                "trim|required|valid_email"
            );
            $this->form_validation->set_rules(
                "online_seller",
                "Online Seller",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "terms",
                "Terms and Condition",
                "required"
            );

            if ($this->form_validation->run() == false) {
                $q_fetch_countries = $this->Home_model->fetch_countries();
                $data["countries"] = $q_fetch_countries->result();

                $data["page_view"] = "home/signup";
                $this->load->view("page", $data);
            } else {
                $username = stripslashes($this->input->post("username"));
                $password = stripslashes($this->input->post("password"));
                $company_name = stripslashes(
                    $this->input->post("company_name")
                );
                $company_address = stripslashes(
                    $this->input->post("company_address")
                );
                $city = stripslashes($this->input->post("city"));
                $country = stripslashes($this->input->post("country"));
                $zip_code = stripslashes($this->input->post("zip_code"));
                $business_license = stripslashes(
                    $this->input->post("business_license")
                );
                $contact_number = stripslashes(
                    $this->input->post("contact_number")
                );
                $contact_person = stripslashes(
                    $this->input->post("contact_person")
                );
                $email = stripslashes($this->input->post("email"));
                $online_seller = $this->input->post("online_seller");
                $client_type = $this->input->post("client_type");
                $shipping_company = 0;
                $created_at = date("Y-m-d H:i:s");
                $shipping_company_link = 0;

                $company_name_ascii = ascii_to_entities($company_name, true);
                $contact_person_ascii = ascii_to_entities(
                    $contact_person,
                    true
                );

                if (
                    strpos($company_name_ascii, "&#") !== false ||
                    strpos($contact_person_ascii, "&#") !== false
                ) {
                    $data["errors"] = 3;

                    $q_fetch_countries = $this->Home_model->fetch_countries();
                    $data["countries"] = $q_fetch_countries->result();

                    $data["page_view"] = "home/signup";
                    $this->load->view("page", $data);
                } else {
                  
                    $result = $this->Home_model->insert_new_user($username, $password, $company_name, $company_address, $city, $country, $zip_code, $business_license, $contact_number, $contact_person, $email, $shipping_company, $online_seller, $client_type, $shipping_company_link, $created_at);
                   if ($result == 1) {
                     $outh =  new Zoho_sdk();
                     $tokens = $outh->get_auth_token();
                      $q_country = $this->Home_model->fetch_country_by_id($country);
                    $countries = $q_country->row();
                    // $account_arr['Portal_ID'] = $portal_id =$result['portal_id'];
                    $account_arr['Username'] =$username;
                    $account_arr['Account_Name'] =$company_name;
                    $account_arr['Address_Line_1'] =$company_address;
                    $account_arr['City'] =$city;
                    $account_arr['Contact_Name'] =$contact_person;
                    $account_arr['Email_1'] =$email;
                    $account_arr['Country'] =$countries->nicename;
                    $account_arr['Zip_Code'] =$zip_code;
                    $account_arr['Phone'] =$contact_number;
                    // $account_arr['Portal_ID'] ="454";
                    $account_arr['Portal_ID'] = $this->db->insert_id();
                    // $account_arr['Portal_ID'] =$result['portal_id'];
                    $account_arr['client_type'] =$client_type;
                    $account_arr['online_seller'] =$online_seller;
                    $account_arr['Business_License_Number'] =$business_license;
                    $resp = $outh->create_zoho_account_by_sdk($account_arr,$tokens['refreshToken'],$tokens['userIdentifier']);
                        $this->send_mail_verification($email, $username);
                        $this->session->set_flashdata('success', 'Congratulations, you can now login to your account.');
                        $this->session->set_flashdata('success', 'Congratulations, you\'ll need to verify your email address first to login.');
                        redirect('home/login', 'refresh');
                   } else if ($result == 2) {
                        $data['errors'] = 2;

                        $q_fetch_countries = $this->Home_model->fetch_countries();
                        $data['countries'] = $q_fetch_countries->result();

                        $data['page_view'] = 'home/signup';
                        $this->load->view('page', $data);
                    } else {
                        $data['errors'] = 1;

                        $q_fetch_countries = $this->Home_model->fetch_countries();
                        $data['countries'] = $q_fetch_countries->result();

                        $data['page_view'] = 'home/signup';
                        $this->load->view('page', $data);
                    }
                }
            }
        } else {
            $data["page_view"] = "home/signup";
            $this->load->view("page", $data);
        }
    }



    // public function create_zoho_account($company_name, $company_address, $city, $country, $zip_code, $business_license, $contact_number, $contact_person, $email, $shipping_company, $online_seller, $client_type, $shipping_company_link){
    //     $client_id ='1000.DKV3SE6483MKB9ULSC6406IZF1MR2W';//Enter your Client ID here
    //     $client_secret = '0ce16f31cb6be340286b10841a6fd506cc89ca6396';//Enter your Client Secret here
    //     $code = '1000.f19b7d6a6092890df7cff74e2b63c4a7.bbb554d35bd21049aeca20d554e3ab09';//Enter your Code here
    //     $base_acc_url = 'https://accounts.zoho.com';
    //     $service_url = 'https://creator.zoho.com';

    //     $refresh_token = '1000.4124d4f4e8cf99ff4b88ad5b5cc883c2.17c7b979e5ab221e1abc703e94ac55f0';

    //     $access_token_url = $base_acc_url .  '/oauth/v2/token?refresh_token='.$refresh_token.'&client_id='.$client_id.'&client_secret='.$client_secret .'&grant_type=refresh_token';

    //     $access_token = $this->generate_access_token($access_token_url);
    //     $this->create_record($access_token,$company_name, $company_address, $city, $country, $zip_code, $business_license, $contact_number, $contact_person, $email, $shipping_company, $online_seller, $client_type, $shipping_company_link);
    // }

    public function create_zoho_account_partners(
        $company_name,
        $country,
        $contact_person,
        $email
    ) {
        $client_id = "1000.DKV3SE6483MKB9ULSC6406IZF1MR2W"; //Enter your Client ID here
        $client_secret = "0ce16f31cb6be340286b10841a6fd506cc89ca6396"; //Enter your Client Secret here
        $code =
            "1000.f19b7d6a6092890df7cff74e2b63c4a7.bbb554d35bd21049aeca20d554e3ab09"; //Enter your Code here
        $base_acc_url = "https://accounts.zoho.com";
        $service_url = "https://creator.zoho.com";

        $refresh_token =
            "1000.4124d4f4e8cf99ff4b88ad5b5cc883c2.17c7b979e5ab221e1abc703e94ac55f0";

        $access_token_url =
            $base_acc_url .
            "/oauth/v2/token?refresh_token=" .
            $refresh_token .
            "&client_id=" .
            $client_id .
            "&client_secret=" .
            $client_secret .
            "&grant_type=refresh_token";

        $access_token = $this->generate_access_token($access_token_url);
        $this->create_record_partners(
            $access_token,
            $company_name,
            $country,
            $contact_person,
            $email
        );
    }

    function generate_access_token($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result)->access_token;
    }

    function create_record(
        $access_token,
        $company_name,
        $company_address,
        $city,
        $country,
        $zip_code,
        $business_license,
        $contact_number,
        $contact_person,
        $email,
        $shipping_company,
        $online_seller,
        $client_type,
        $shipping_company_link
    ) {
        $service_url = "https://www.zohoapis.com/crm/v2/Accounts";
        //Authorization: Zoho-oauthtoken access_token
        // $data = array("data" => array("Name" => "Ruben", "Email" => "zoho@aorborc.com"));
        $header = [
            "Authorization: Zoho-oauthtoken " . $access_token,
            "Content-Type: application/x-www-form-urlencoded",
        ];

        $requestBody = [];
        $recordArray = [];
        $recordObject = [];
        $recordObject["Account_Name"] = $company_name;
        $recordObject["Address_Line_1"] = $company_address;
        $recordObject["City"] = $city;
        $recordObject["Zip_Code"] = $zip_code;
        $recordObject["Country"] = $country;
        $recordObject["Contact_Name"] = $contact_person;
        $recordObject["Email_1"] = $email;
        $recordObject["Phone"] = $contact_number;

        $recordArray[] = $recordObject;
        $requestBody["data"] = $recordArray;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);
        curl_close($ch);
    }

    function create_record_partners(
        $access_token,
        $company_name,
        $country,
        $contact_person,
        $email
    ) {
        $service_url = "https://www.zohoapis.com/crm/v2/Accounts";
        //Authorization: Zoho-oauthtoken access_token
        // $data = array("data" => array("Name" => "Ruben", "Email" => "zoho@aorborc.com"));
        $header = [
            "Authorization: Zoho-oauthtoken " . $access_token,
            "Content-Type: application/x-www-form-urlencoded",
        ];

        $requestBody = [];
        $recordArray = [];
        $recordObject = [];
        $recordObject["Account_Name"] = $company_name;
        $recordObject["Country"] = $country;
        $recordObject["Contact_Name"] = $contact_person;
        $recordObject["Email_Address"] = $email;

        $recordArray[] = $recordObject;
        $requestBody["data"] = $recordArray;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);
        curl_close($ch);
        var_dump($result);
    }

    public function partner_signup()
    {
        $this->clear_apost();

        $data["external_page"] = 1;
        $data["active_page"] = "home";

        $q_fetch_countries = $this->Home_model->fetch_countries();
        $data["countries"] = $q_fetch_countries->result();

        if (isset($_POST["submit"])) {
            $this->form_validation->set_rules(
                "username",
                "Username",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "password",
                "Password",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "company_name",
                "Legal Company Name",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "country",
                "Country",
                "trim|required|integer"
            );
            $this->form_validation->set_rules(
                "contact_person",
                "Primary Contact Person",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "email",
                "Email",
                "trim|required|valid_email"
            );
            $this->form_validation->set_rules(
                "terms",
                "Terms and Condition",
                "required"
            );
            $this->form_validation->set_rules(
                "content",
                "Landing Page Content",
                "required"
            );

            if ($this->form_validation->run() == false) {
                $q_fetch_countries = $this->Home_model->fetch_countries();
                $data["countries"] = $q_fetch_countries->result();

                $data["page_view"] = "home/partner_signup";
                $this->load->view("page", $data);
            } else {
                $username = stripslashes($this->input->post("username"));
                $password = stripslashes($this->input->post("password"));
                $company_name = stripslashes(
                    $this->input->post("company_name")
                );
                $country = stripslashes($this->input->post("country"));
                $contact_person = stripslashes(
                    $this->input->post("contact_person")
                );
                $email = stripslashes($this->input->post("email"));
                $content = stripslashes($this->input->post("content"));

                $header_color = stripslashes(
                    $this->input->post("header_color")
                );
                if ($header_color != "") {
                    $hcolor = stripslashes($this->input->post("header_color"));
                } else {
                    $hcolor = stripslashes($this->input->post("header"));
                }

                $footer_color = stripslashes(
                    $this->input->post("footer_color")
                );
                if ($footer_color != "") {
                    $fcolor = stripslashes($this->input->post("footer_color"));
                } else {
                    $fcolor = stripslashes($this->input->post("footer"));
                }

                $created_at = date("Y-m-d H:i:s");

                //** LOGO */
                $image = addslashes(
                    file_get_contents($_FILES["logo"]["tmp_name"])
                );
                $image_name = addslashes($_FILES["logo"]["name"]);
                $image_size = getimagesize($_FILES["logo"]["tmp_name"]);

                $path = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
                $filename = "partners_" . time() . "." . $path;

                //** BANNER */
                $image1 = addslashes(
                    file_get_contents($_FILES["banner"]["tmp_name"])
                );
                $image_name1 = addslashes($_FILES["banner"]["name"]);
                $image_size1 = getimagesize($_FILES["banner"]["tmp_name"]);

                $path1 = pathinfo(
                    $_FILES["banner"]["name"],
                    PATHINFO_EXTENSION
                );
                $filename1 = "partners_banner_" . time() . "." . $path1;

                //** BACKGROUND */
                $image2 = addslashes(
                    file_get_contents($_FILES["background"]["tmp_name"])
                );
                $image_name2 = addslashes($_FILES["background"]["name"]);
                $image_size2 = getimagesize($_FILES["background"]["tmp_name"]);

                $path2 = pathinfo(
                    $_FILES["background"]["name"],
                    PATHINFO_EXTENSION
                );
                $filename2 = "partners_background_" . time() . "." . $path2;

                move_uploaded_file(
                    $_FILES["logo"]["tmp_name"],
                    "uploads/partners/" . $filename
                );
                move_uploaded_file(
                    $_FILES["banner"]["tmp_name"],
                    "uploads/partners/" . $filename1
                );
                move_uploaded_file(
                    $_FILES["background"]["tmp_name"],
                    "uploads/partners/" . $filename2
                );

                $result = $this->Home_model->insert_new_partner(
                    $username,
                    $password,
                    $company_name,
                    $country,
                    $contact_person,
                    $email,
                    $filename,
                    $content,
                    $filename1,
                    $filename2,
                    $hcolor,
                    $fcolor,
                    $created_at
                );

                if ($result == 1) {
                    // $this->create_zoho_account_partners($company_name, $country, $contact_person, $email);
                    // $this->send_mail_verification($email, $username);
                    $this->session->set_flashdata(
                        "success",
                        "Registration Success! Please wait for your account verification by our Administrator"
                    );
                    redirect("home/partner-login", "refresh");
                } elseif ($result == 2) {
                    $data["errors"] = 2;

                    $q_fetch_countries = $this->Home_model->fetch_countries();
                    $data["countries"] = $q_fetch_countries->result();

                    $data["page_view"] = "home/partner_signup";
                    $this->load->view("page", $data);
                } else {
                    $data["errors"] = 1;

                    $q_fetch_countries = $this->Home_model->fetch_countries();
                    $data["countries"] = $q_fetch_countries->result();

                    $data["page_view"] = "home/partner_signup";
                    $this->load->view("page", $data);
                }
            }
        } else {
            $data["page_view"] = "home/partner_signup";
            $this->load->view("page", $data);
        }
    }
    public function consultant_signup()
    {
        $this->clear_apost();

        $data["external_page"] = 1;
        $data["active_page"] = "home";

        $q_fetch_countries = $this->Home_model->fetch_countries();
        $data["countries"] = $q_fetch_countries->result();

        if (isset($_POST["submit"])) {
            $this->form_validation->set_rules(
                "username",
                "Username",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "password",
                "Password",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "company_name",
                "Legal Company Name",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "country",
                "Country",
                "trim|required|integer"
            );
            $this->form_validation->set_rules(
                "contact_person",
                "Primary Contact Person",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "email",
                "Email",
                "trim|required|valid_email"
            );
            $this->form_validation->set_rules(
                "terms",
                "Terms and Condition",
                "required"
            );
            $this->form_validation->set_rules(
                "content",
                "Landing Page Content",
                "required"
            );
            $this->form_validation->set_rules(
                "header_title",
                "Landing Page Header Title",
                "required"
            );

            if ($this->form_validation->run() == false) {
                $q_fetch_countries = $this->Home_model->fetch_countries();
                $data["countries"] = $q_fetch_countries->result();

                $data["page_view"] = "home/consultant_signup";
                $this->load->view("page", $data);
            } else {
                $username = stripslashes($this->input->post("username"));
                $password = stripslashes($this->input->post("password"));
                $company_name = stripslashes(
                    $this->input->post("company_name")
                );
                $contact_person = stripslashes(
                    $this->input->post("contact_person")
                );
                $email = stripslashes($this->input->post("email"));
                $country = stripslashes($this->input->post("country"));
                $header_title = stripslashes(
                    $this->input->post("header_title")
                );
                $content = stripslashes($this->input->post("content"));

                $header_color = stripslashes(
                    $this->input->post("header_color")
                );
                if ($header_color != "") {
                    $hcolor = stripslashes($this->input->post("header_color"));
                } else {
                    $hcolor = stripslashes($this->input->post("header"));
                }

                $footer_color = stripslashes(
                    $this->input->post("footer_color")
                );
                if ($footer_color != "") {
                    $fcolor = stripslashes($this->input->post("footer_color"));
                } else {
                    $fcolor = stripslashes($this->input->post("footer"));
                }

                $created_at = date("Y-m-d H:i:s");

                //** LOGO */
                $image = addslashes(
                    file_get_contents($_FILES["logo"]["tmp_name"])
                );
                $image_name = addslashes($_FILES["logo"]["name"]);
                $image_size = getimagesize($_FILES["logo"]["tmp_name"]);

                $path = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
                $filename = "consultants_" . time() . "." . $path;

                //** BANNER */
                $image1 = addslashes(
                    file_get_contents($_FILES["banner"]["tmp_name"])
                );
                $image_name1 = addslashes($_FILES["banner"]["name"]);
                $image_size1 = getimagesize($_FILES["banner"]["tmp_name"]);

                $path1 = pathinfo(
                    $_FILES["banner"]["name"],
                    PATHINFO_EXTENSION
                );
                $filename1 = "consultants_banner_" . time() . "." . $path1;

                //** BACKGROUND */
                $image2 = addslashes(
                    file_get_contents($_FILES["background"]["tmp_name"])
                );
                $image_name2 = addslashes($_FILES["background"]["name"]);
                $image_size2 = getimagesize($_FILES["background"]["tmp_name"]);

                $path2 = pathinfo(
                    $_FILES["background"]["name"],
                    PATHINFO_EXTENSION
                );
                $filename2 = "consultants_background_" . time() . "." . $path2;

                move_uploaded_file(
                    $_FILES["logo"]["tmp_name"],
                    "uploads/consultants/" . $filename
                );
                move_uploaded_file(
                    $_FILES["banner"]["tmp_name"],
                    "uploads/consultants/" . $filename1
                );
                move_uploaded_file(
                    $_FILES["background"]["tmp_name"],
                    "uploads/consultants/" . $filename2
                );

                $result = $this->Home_model->insert_new_consultant(
                    $username,
                    $password,
                    $company_name,
                    $country,
                    $contact_person,
                    $email,
                    $filename,
                    $header_title,
                    $content,
                    $filename1,
                    $filename2,
                    $hcolor,
                    $fcolor,
                    $created_at
                );

                if ($result == 1) {
                    // $this->create_zoho_account_partners($company_name, $country, $contact_person, $email);
                    // $this->send_mail_verification($email, $username);
                    $this->session->set_flashdata(
                        "success",
                        "Registration Success! You can now login to your account."
                    );
                    redirect("home/consultant-login", "refresh");
                } elseif ($result == 2) {
                    $data["errors"] = 2;

                    $q_fetch_countries = $this->Home_model->fetch_countries();
                    $data["countries"] = $q_fetch_countries->result();

                    $data["page_view"] = "home/consultant_signup";
                    $this->load->view("page", $data);
                } else {
                    $data["errors"] = 1;

                    $q_fetch_countries = $this->Home_model->fetch_countries();
                    $data["countries"] = $q_fetch_countries->result();

                    $data["page_view"] = "home/consultant_signup";
                    $this->load->view("page", $data);
                }
            }
        } else {
            $data["page_view"] = "home/consultant_signup";
            $this->load->view("page", $data);
        }
    }

    public function client_signup()
    {
        $this->clear_apost();

        $data["external_page"] = 3;
        $data["active_page"] = "home";

        $q_fetch_countries = $this->Home_model->fetch_countries();
        $data["countries"] = $q_fetch_countries->result();
        $partner_id = $_GET["data"];
        $q_shipping_company = $this->Home_model->fetch_shipping_companies_v(
            $partner_id
        );
        $data["shipping_companies"] = $q_shipping_company->result();

        if (isset($_POST["submit"])) {
            $this->form_validation->set_rules(
                "username",
                "Username",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "password",
                "Password",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "company_name",
                "Legal Company Name",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "company_address",
                "Company Address",
                "trim|required"
            );
            $this->form_validation->set_rules("city", "City", "trim|required");
            $this->form_validation->set_rules(
                "country",
                "Country",
                "trim|required|integer"
            );
            $this->form_validation->set_rules(
                "zip_code",
                "Zip Code",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "business_license",
                "Business License Number",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "contact_number",
                "Contact Number",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "contact_person",
                "Primary Contact Person",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "email",
                "Email",
                "trim|required|valid_email"
            );
            $this->form_validation->set_rules(
                "online_seller",
                "Online Seller",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "shipping_company",
                "Shipping Company",
                "required"
            );
            $this->form_validation->set_rules(
                "terms",
                "Terms and Condition",
                "required"
            );

            if ($this->form_validation->run() == false) {
                $q_fetch_countries = $this->Home_model->fetch_countries();
                $data["countries"] = $q_fetch_countries->result();

                $data["page_view"] = "home/signup_client";
                $this->load->view("page", $data);
            } else {
                $username = stripslashes($this->input->post("username"));
                $password = stripslashes($this->input->post("password"));
                $company_name = stripslashes(
                    $this->input->post("company_name")
                );
                $company_address = stripslashes(
                    $this->input->post("company_address")
                );
                $city = stripslashes($this->input->post("city"));
                $country = stripslashes($this->input->post("country"));
                $zip_code = stripslashes($this->input->post("zip_code"));
                $business_license = stripslashes(
                    $this->input->post("business_license")
                );
                $contact_number = stripslashes(
                    $this->input->post("contact_number")
                );
                $contact_person = stripslashes(
                    $this->input->post("contact_person")
                );
                $email = stripslashes($this->input->post("email"));
                $online_seller = $this->input->post("online_seller");
                $shipping_company = $this->input->post("shipping_company");
                $client_type = $this->input->post("client_type");
                $created_at = date("Y-m-d H:i:s");
                $shipping_company_link = 1;
                $result = $this->Home_model->insert_new_user(
                    $username,
                    $password,
                    $company_name,
                    $company_address,
                    $city,
                    $country,
                    $zip_code,
                    $business_license,
                    $contact_number,
                    $contact_person,
                    $email,
                    $shipping_company,
                    $online_seller,
                    $client_type,
                    $shipping_company_link,
                    $created_at
                );

                if ($result == 1) {
                    // $this->send_mail_verification($email, $username);
                    $this->session->set_flashdata(
                        "success",
                        "Congratulations, you can now login to your account."
                    );
                    // $this->session->set_flashdata('success', 'Congratulations, you\'ll need to verify your email address first to login.');
                    redirect("home/login", "refresh");
                } elseif ($result == 2) {
                    $data["errors"] = 2;

                    $q_fetch_countries = $this->Home_model->fetch_countries();
                    $data["countries"] = $q_fetch_countries->result();

                    $data["page_view"] = "home/signup_client";
                    $this->load->view("page", $data);
                } else {
                    $data["errors"] = 1;

                    $q_fetch_countries = $this->Home_model->fetch_countries();
                    $data["countries"] = $q_fetch_countries->result();

                    $data["page_view"] = "home/signup_client";
                    $this->load->view("page", $data);
                }
            }
        } else {
            $data["page_view"] = "home/signup_client";
            $this->load->view("page", $data);
        }
    }

    public function consultant_client_signup()
    {
        $this->clear_apost();

        $data["external_page"] = 5;
        $data["active_page"] = "home";

        $q_fetch_countries = $this->Home_model->fetch_countries();
        $data["countries"] = $q_fetch_countries->result();

        $q_shipping_company = $this->Home_model->fetch_shipping_companies();
        $data["shipping_companies"] = $q_shipping_company->result();

        $q_user_details = $this->Home_model->fetch_users_by_consultant_id(
            $_GET["consultant"]
        );
        $data["user_details"] = $q_user_details->row();

        $consultant_id = $_GET["consultant"];

        if (isset($_POST["submit"])) {
            $this->form_validation->set_rules(
                "username",
                "Username",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "password",
                "Password",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "company_name",
                "Legal Company Name",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "company_address",
                "Company Address",
                "trim|required"
            );
            $this->form_validation->set_rules("city", "City", "trim|required");
            $this->form_validation->set_rules(
                "country",
                "Country",
                "trim|required|integer"
            );
            $this->form_validation->set_rules(
                "zip_code",
                "Zip Code",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "business_license",
                "Business License Number",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "contact_number",
                "Contact Number",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "contact_person",
                "Primary Contact Person",
                "trim|required"
            );
            $this->form_validation->set_rules(
                "email",
                "Email",
                "trim|required|valid_email"
            );
            $this->form_validation->set_rules(
                "online_seller",
                "Online Seller",
                "trim|required"
            );
            // $this->form_validation->set_rules('shipping_company', 'Shipping Company', 'required');
            $this->form_validation->set_rules(
                "terms",
                "Terms and Condition",
                "required"
            );

            if ($this->form_validation->run() == false) {
                $q_fetch_countries = $this->Home_model->fetch_countries();
                $data["countries"] = $q_fetch_countries->result();

                $data["page_view"] = "home/signup_consultant_client";
                $this->load->view("page", $data);
            } else {
                $username = stripslashes($this->input->post("username"));
                $password = stripslashes($this->input->post("password"));
                $company_name = stripslashes(
                    $this->input->post("company_name")
                );
                $company_address = stripslashes(
                    $this->input->post("company_address")
                );
                $city = stripslashes($this->input->post("city"));
                $country = stripslashes($this->input->post("country"));
                $zip_code = stripslashes($this->input->post("zip_code"));
                $business_license = stripslashes(
                    $this->input->post("business_license")
                );
                $contact_number = stripslashes(
                    $this->input->post("contact_number")
                );
                $contact_person = stripslashes(
                    $this->input->post("contact_person")
                );
                $email = stripslashes($this->input->post("email"));
                $online_seller = $this->input->post("online_seller");
                $client_type = $this->input->post("client_type");
                // $shipping_company = $this->input->post('shipping_company');
                $shipping_company = 0;
                $created_at = date("Y-m-d H:i:s");

                $company_name_ascii = ascii_to_entities($company_name, true);
                $contact_person_ascii = ascii_to_entities(
                    $contact_person,
                    true
                );

                if (
                    strpos($company_name_ascii, "&#") !== false ||
                    strpos($contact_person_ascii, "&#") !== false
                ) {
                    $data["errors"] = 3;

                    $q_fetch_countries = $this->Home_model->fetch_countries();
                    $data["countries"] = $q_fetch_countries->result();

                    $data["page_view"] = "home/signup_consultant_client";
                    $this->load->view("page", $data);
                } else {
                    $result = $this->Home_model->insert_new_consultant_user(
                        $username,
                        $password,
                        $company_name,
                        $company_address,
                        $city,
                        $country,
                        $zip_code,
                        $business_license,
                        $contact_number,
                        $contact_person,
                        $email,
                        $shipping_company,
                        $online_seller,
                        $client_type,
                        $created_at,
                        $consultant_id
                    );

                    if ($result == 1) {
                        // $this->send_mail_verification($email, $username);
                        $this->session->set_flashdata(
                            "success",
                            "Congratulations, you can now login to your account."
                        );
                        // $this->session->set_flashdata('success', 'Congratulations, you\'ll need to verify your email address first to login.');
                        redirect("home/login", "refresh");
                    } elseif ($result == 2) {
                        $data["errors"] = 2;

                        $q_fetch_countries = $this->Home_model->fetch_countries();
                        $data["countries"] = $q_fetch_countries->result();

                        $data["page_view"] = "home/signup_consultant_client";
                        $this->load->view("page", $data);
                    } elseif ($result == 3) {
                        $data["errors"] = 3;

                        $q_fetch_countries = $this->Home_model->fetch_countries();
                        $data["countries"] = $q_fetch_countries->result();

                        $data["page_view"] = "home/signup_consultant_client";
                        $this->load->view("page", $data);
                    } else {
                        $data["errors"] = 1;

                        $q_fetch_countries = $this->Home_model->fetch_countries();
                        $data["countries"] = $q_fetch_countries->result();

                        $data["page_view"] = "home/signup_consultant_client";
                        $this->load->view("page", $data);
                    }
                }
            }
        } else {
            $data["page_view"] = "home/signup_consultant_client";
            $this->load->view("page", $data);
        }
    }

    public function verify_account()
    {
        $mail = $_GET["mail"];

        $validate = $this->Home_model->validate_registration($mail);

        $this->session->set_flashdata(
            "success",
            "Congratulations! Your account has been successfully verified, you can now login."
        );
        redirect("home/login", "refresh");
    }

    public function send_mail_verification($email, $username)
    {
        $subject = "COVUE IOR Account Verification";
        $template = "emails/verify_email_account.php";

        $mail = $this->phpmailer_library->load();
        $mail->isSMTP();
        $mail->Host = "mail.covueior.com";
        $mail->SMTPAuth = true;
        $mail->Username = "admin@covueior.com";
        $mail->Password = "Y.=Sa3hZxq+>@6";
        // $mail->SMTPSecure = 'ssl'; // tls
        $mail->Port = 26; // 587
        $mail->setFrom("admin@covueior.com", "COVUE IOR Japan");

        $mail->addAddress($email);
        $mail->addBCC("mikecoros05@gmail.com");
        $mail->Subject = $subject;
        $mail->isHTML(true);

        $data["username"] = $username;
        $data["email"] = $email;
        $mailContent = $this->load->view($template, $data, true);

        $mail->Body = $mailContent;

        if ($mail->send()) {
            $message = "success";
        } else {
            $message = "failed";
        }
    }

    public function get_a_quote()
    {
        $data["category_data"] = $this->Home_model->fetch_category();
        $data["category_ior_data"] = $this->Home_model->fetch_ior_category();

        $data["external_page"] = 1;
        $data["active_page"] = "get-a-quote";

        $data["page_view"] = "home/get_a_quote";
        $this->load->view("page", $data);
    }

    public function quotes_result()
    {
        $data["category_data"] = $this->Home_model->fetch_category();
        $data["category_ior_data"] = $this->Home_model->fetch_ior_category();

        $data["external_page"] = 1;
        $data["active_page"] = "get-a-quote";

        $data["page_view"] = "home/quotes_result";
        $this->load->view("page", $data);
    }

    public function get_category_details()
    {
        $category = $_POST["category"];
        $details = $this->Home_model->get_category_details($category);
        $result = '<div class="col-md-12 col-12"><table class="" width="100%">';
        foreach ($details as $row => $val) {
            $ior_reg_fee = $val->ior_reg_fee;
            $product_liability_insurance = $val->product_liability_insurance;
            if (
                $val->category_name == "Non-regulated" ||
                $val->category_name == "Japan Radio"
            ) {
                $subtotal = $ior_reg_fee + $product_liability_insurance;
                $jct = $subtotal / 10;
                $total = $subtotal + $jct;
                $result .=
                    '   <tr><td><h4>IOR Registration Fee</h4></td><td style="text-align:right;"><h4>USD</h4></td></tr>
                                    <tr><td>One Time  IOR Registration Fee</td><td style="text-align:right;"> ' .
                    number_format($ior_reg_fee, 2) .
                    '</td></tr>
                                    <tr class="spaceUnder"><td>Product Liability Insurance / Year</td><td style="text-align:right;"> ' .
                    number_format($product_liability_insurance, 2) .
                    '</td></tr> 
                                    <tr><td><b>Subtotal</b></td><td style="text-align:right;"><b> ' .
                    number_format($subtotal, 2) .
                    ' </b></td></tr> 
                                    <tr><td>Japan Consumer Tax (10%)</td><td style="text-align:right;"> ' .
                    number_format($jct, 2) .
                    '</td></tr> 
                                    <tr class="spaceUnder"><td><h4>TOTAL</h4></td><td style="text-align:right;"><h4>$' .
                    number_format($total, 2) .
                    '</h4></td></tr> 
                                ';
            } elseif ($val->category_name == "CBD") {
                $application_fee = $val->application_fee;
                $subtotal =
                    $ior_reg_fee +
                    $product_liability_insurance +
                    $application_fee;
                $jct = $subtotal / 10;
                $total = $subtotal + $jct;
                $result .=
                    '<tr><td><h4>IOR Registration Fee</h4></td><td style="text-align:right;"><h4>USD</h4></td></tr>
                                    <tr><td>CBD Import Application Fee (1st application)</td><td style="text-align:right;"> ' .
                    number_format($application_fee, 2) .
                    '</td></tr>
                                    <tr><td>One Time  IOR Registration Fee</td><td style="text-align:right;"> ' .
                    number_format($ior_reg_fee, 2) .
                    '</td></tr>
                                    <tr class="spaceUnder"><td>Product Liability Insurance / Year</td><td style="text-align:right;"> ' .
                    number_format($product_liability_insurance, 2) .
                    '</td></tr> 
                                    <tr><td><b>Subtotal</b></td><td style="text-align:right;"><b> ' .
                    number_format($subtotal, 2) .
                    ' </b></td></tr> 
                                    <tr><td>Japan Consumer Tax (10%)</td><td style="text-align:right;"> ' .
                    number_format($jct, 2) .
                    '</td></tr> 
                                    <tr class="spaceUnder"><td><h4>TOTAL</h4></td><td style="text-align:right;"><h4>$' .
                    number_format($total, 2) .
                    '</h4></td></tr> 
                                  ';
            } elseif ($val->category_name == "Cosmetics and Personal Care") {
                $application_fee = $val->application_fee;
                $subtotal =
                    $ior_reg_fee +
                    $product_liability_insurance +
                    $application_fee;
                $jct = $subtotal / 10;
                $total = $subtotal + $jct;
                $result .=
                    '<tr><td><h4>IOR Registration Fee</h4></td><td style="text-align:right;"><h4>USD</h4></td></tr>
                                    <tr><td>Cosmetics and Personal Care Product Approval Application<br>(up to 150 products from same manufacture)</td><td style="text-align:right;">' .
                    number_format($application_fee, 2) .
                    ' </td></tr>
                                    <tr><td>One Time  IOR Registration Fee</td><td style="text-align:right;"> ' .
                    number_format($ior_reg_fee, 2) .
                    '</td></tr>
                                    <tr class="spaceUnder"><td>Product Liability Insurance / Year</td><td style="text-align:right;"> ' .
                    number_format($product_liability_insurance, 2) .
                    '</td></tr> 
                                    <tr><td><b>Cosmetics and Personal Care Product Approval Application Fee includes:</b></td></tr>
                                    <tr><td><i> - MHLW Manufacturer & Ingredient Pre-Notification Product Labeling </i></td></tr>
                                    <tr><td><i> - Compliance </td></tr>
                                    <tr class="spaceUnder"><td><i> - Product Approval Application </i></td></tr>
                                    <tr><td><b>Subtotal</b></td><td style="text-align:right;"><b> ' .
                    number_format($subtotal, 2) .
                    ' </b></td></tr> 
                                    <tr><td>Japan Consumer Tax (10%)</td><td style="text-align:right;"> ' .
                    number_format($jct, 2) .
                    '</td></tr> 
                                    <tr class="spaceUnder"><td><h4>TOTAL</h4></td><td style="text-align:right;"><h4>$' .
                    number_format($total, 2) .
                    '</h4></td></tr> 
                                   ';
            } elseif ($val->category_name == "Quasi Drugs") {
                $application_fee = $val->application_fee;
                $subtotal =
                    $ior_reg_fee +
                    $product_liability_insurance +
                    $application_fee;
                $jct = $subtotal / 10;
                $total = $subtotal + $jct;
                $result .=
                    '<tr><td><h4>IOR Registration Fee</h4></td><td style="text-align:right;"><h4>USD</h4></td></tr>
                                                        <tr><td>Quasi Drugs Product Approval Application<br>(up to 150 products from same manufacture)</td><td style="text-align:right;">' .
                    number_format($application_fee, 2) .
                    ' </td></tr>
                                                        <tr><td>One Time  IOR Registration Fee</td><td style="text-align:right;"> ' .
                    number_format($ior_reg_fee, 2) .
                    '</td></tr>
                                                        <tr class="spaceUnder"><td>Product Liability Insurance / Year</td><td style="text-align:right;"> ' .
                    number_format($product_liability_insurance, 2) .
                    '</td></tr> 
                                                        <tr><td><b>Quasi Drugs Product Approval Application Fee includes:</b></td></tr>
                                                        <tr><td><i> - MHLW Manufacturer & Ingredient Pre-Notification Product Labeling </i></td></tr>
                                                        <tr><td><i> - Compliance </td></tr>
                                                        <tr class="spaceUnder"><td><i> - Product Approval Application </i></td></tr>
                                                        <tr><td><b>Subtotal</b></td><td style="text-align:right;"><b> ' .
                    number_format($subtotal, 2) .
                    ' </b></td></tr> 
                                                        <tr><td>Japan Consumer Tax (10%)</td><td style="text-align:right;"> ' .
                    number_format($jct, 2) .
                    '</td></tr> 
                                                        <tr class="spaceUnder"><td><h4>TOTAL</h4></td><td style="text-align:right;"><h4>$' .
                    number_format($total, 2) .
                    '</h4></td></tr> 
                                                       ';
            } elseif ($val->category_name == "Food Apparatus") {
                $application_fee = $val->application_fee;
                $subtotal =
                    $ior_reg_fee +
                    $product_liability_insurance +
                    $application_fee;
                $jct = $subtotal / 10;
                $total = $subtotal + $jct;
                $result .=
                    '<tr><td><h4>IOR Registration Fee</h4></td><td style="text-align:right;"><h4>USD</h4></td></tr>
                                    <tr><td>Food apparatus Import Application Fee (1st application)</td><td style="text-align:right;"> ' .
                    number_format($application_fee, 2) .
                    ' </td></tr>
                                    <tr><td>One Time  IOR Registration Fee</td><td style="text-align:right;"> ' .
                    number_format($ior_reg_fee, 2) .
                    '</td></tr>
                                    <tr class="spaceUnder"><td>Product Liability Insurance / Year</td><td style="text-align:right;"> ' .
                    number_format($product_liability_insurance, 2) .
                    '</td></tr> 
                                    <tr><td><b>Subtotal</b></td><td style="text-align:right;"><b> ' .
                    number_format($subtotal, 2) .
                    ' </b></td></tr> 
                                    <tr><td>Japan Consumer Tax (10%)</td><td style="text-align:right;"> ' .
                    number_format($jct, 2) .
                    '</td></tr> 
                                    <tr class="spaceUnder"><td><h4>TOTAL</h4></td><td style="text-align:right;"><h4>$' .
                    number_format($total, 2) .
                    '</h4></td></tr> 
                                  ';
            } elseif ($val->category_name == "Food Import - Food Supplement") {
                $application_fee = $val->application_fee;
                $subtotal =
                    $ior_reg_fee +
                    $product_liability_insurance +
                    $application_fee;
                $jct = $subtotal / 10;
                $total = $subtotal + $jct;
                $result .=
                    '<tr><td><h4>IOR Registration Fee</h4></td><td style="text-align:right;"><h4>USD</h4></td></tr>
                                    <tr><td>Food supplement  Import Application Fee (1st application)</td><td style="text-align:right;"> ' .
                    number_format($application_fee, 2) .
                    ' </td></tr>
                                    <tr><td>One Time  IOR Registration Fee</td><td style="text-align:right;"> ' .
                    number_format($ior_reg_fee, 2) .
                    '</td></tr>
                                    <tr class="spaceUnder"><td>Product Liability Insurance / Year</td><td style="text-align:right;"> ' .
                    number_format($product_liability_insurance, 2) .
                    '</td></tr> 
                                    <tr><td><b>Subtotal</b></td><td style="text-align:right;"><b> ' .
                    number_format($subtotal, 2) .
                    ' </b></td></tr> 
                                    <tr><td>Japan Consumer Tax (10%)</td><td style="text-align:right;"> ' .
                    number_format($jct, 2) .
                    '</td></tr> 
                                    <tr class="spaceUnder"><td><h4>TOTAL</h4></td><td style="text-align:right;"><h4>$' .
                    number_format($total, 2) .
                    '</h4></td></tr> 
                                  ';
            } elseif ($val->category_name == "Shelf Stable Food") {
                $application_fee = $val->application_fee;
                $subtotal =
                    $ior_reg_fee +
                    $product_liability_insurance +
                    $application_fee;
                $jct = $subtotal / 10;
                $total = $subtotal + $jct;
                $result .=
                    '<tr><td><h4>IOR Registration Fee</h4></td><td style="text-align:right;"><h4>USD</h4></td></tr>
                                    <tr><td>Shelf Stable Food  Import Application Fee (1st application)</td><td style="text-align:right;"> ' .
                    number_format($application_fee, 2) .
                    ' </td></tr>
                                    <tr><td>One Time  IOR Registration Fee</td><td style="text-align:right;"> ' .
                    number_format($ior_reg_fee, 2) .
                    '</td></tr>
                                    <tr class="spaceUnder"><td>Product Liability Insurance / Year</td><td style="text-align:right;"> ' .
                    number_format($product_liability_insurance, 2) .
                    '</td></tr> 
                                    <tr><td><b>Subtotal</b></td><td style="text-align:right;"><b> ' .
                    number_format($subtotal, 2) .
                    ' </b></td></tr> 
                                    <tr><td>Japan Consumer Tax (10%)</td><td style="text-align:right;"> ' .
                    number_format($jct, 2) .
                    '</td></tr> 
                                    <tr class="spaceUnder"><td><h4>TOTAL</h4></td><td style="text-align:right;"><h4>$' .
                    number_format($total, 2) .
                    '</h4></td></tr> 
                                    ';
            } elseif ($val->category_name == "Supplemental PSE") {
                $application_fee = $val->application_fee;
                $subtotal =
                    $ior_reg_fee +
                    $product_liability_insurance +
                    $application_fee;
                $jct = $subtotal / 10;
                $total = $subtotal + $jct;
                $result .=
                    '   <tr><td><h4>IOR Registration Fee</h4></td><td style="text-align:right;"><h4>USD</h4></td></tr>
                                    <tr><td>One Time  IOR Registration Fee</td><td style="text-align:right;"> ' .
                    number_format($ior_reg_fee, 2) .
                    '</td></tr>
                                    <tr class="spaceUnder"><td>PSE Supplemental Application <br> <i>(acceptance 30-45 days after submission )</td><td style="text-align:right;"> ' .
                    $application_fee .
                    '</td></tr> 
                                    <tr><td><b>Subtotal</b></td><td style="text-align:right;"><b> ' .
                    number_format($subtotal, 2) .
                    ' </b></td></tr> 
                                    <tr><td>Japan Consumer Tax (10%)</td><td style="text-align:right;"> ' .
                    number_format($jct, 2) .
                    '</td></tr> 
                                    <tr class="spaceUnder"><td><h4>TOTAL</h4></td><td style="text-align:right;"><h4>$' .
                    number_format($total, 2) .
                    '</h4></td></tr> 
                                ';
            } elseif (
                $val->category_name ==
                "Toys under 6 years old and Baby products"
            ) {
                $application_fee = $val->application_fee;
                $subtotal =
                    $ior_reg_fee +
                    $product_liability_insurance +
                    $application_fee;
                $jct = $subtotal / 10;
                $total = $subtotal + $jct;
                $result .=
                    '<tr><td><h4>IOR Registration Fee</h4></td><td style="text-align:right;"><h4>USD</h4></td></tr>
                                    <tr><td>Toys Import Application Fee (1st application)</td><td style="text-align:right;"> ' .
                    number_format($application_fee, 2) .
                    ' </td></tr>
                                    <tr><td>One Time  IOR Registration Fee</td><td style="text-align:right;"> ' .
                    number_format($ior_reg_fee, 2) .
                    '</td></tr>
                                    <tr class="spaceUnder"><td>Product Liability Insurance / Year</td><td style="text-align:right;"> ' .
                    number_format($product_liability_insurance, 2) .
                    '</td></tr> 
                                    <tr><td><b>Subtotal</b></td><td style="text-align:right;"><b> ' .
                    number_format($subtotal, 2) .
                    ' </b></td></tr> 
                                    <tr><td>Japan Consumer Tax (10%)</td><td style="text-align:right;"> ' .
                    number_format($jct, 2) .
                    '</td></tr> 
                                    <tr class="spaceUnder"><td><h4>TOTAL</h4></td><td style="text-align:right;"><h4>$' .
                    number_format($total, 2) .
                    '</h4></td></tr> 
                                  ';
            } elseif ($val->category_name == "Class 1 Medical Devices") {
                $application_fee = $val->application_fee;
                $subtotal =
                    $ior_reg_fee +
                    $product_liability_insurance +
                    $application_fee;
                $jct = $subtotal / 10;
                $total = $subtotal + $jct;
                $result .=
                    '<tr><td><h4>IOR Registration Fee</h4></td><td style="text-align:right;"><h4>USD</h4></td></tr>
                                    <tr><td>One Time  IOR Registration Fee</td><td style="text-align:right;"> ' .
                    number_format($ior_reg_fee, 2) .
                    '</td></tr>
                                    <tr><td>Annual Liability Insurance Insurance</td><td style="text-align:right;">  ' .
                    number_format($product_liability_insurance, 2) .
                    ' </td></tr> 
                                    <tr class="spaceUnder"><td>Class 1 Medical Device Application (Up to 25 Products)</td><td style="text-align:right;"> ' .
                    number_format($application_fee, 2) .
                    ' </td></tr> 
                                    <tr><td><b>Class 1 Medical Device Approval Application Fee includes:</b></td></tr>
                                    <tr><td><i> <center>- Product Labeling Compliance </center></i></td></tr>
                                    <tr class="spaceUnder"><td><i> <center>- Product Approval Application</center> </td></tr>
                                    <tr><td><b>Subtotal</b></td><td style="text-align:right;"><b> ' .
                    number_format($subtotal, 2) .
                    ' </b></td></tr> 
                                    <tr><td>Japan Consumer Tax (10%)</td><td style="text-align:right;"> ' .
                    number_format($jct, 2) .
                    '</td></tr> 
                                    <tr class="spaceUnder"><td><h4>TOTAL</h4></td><td style="text-align:right;"><h4>$' .
                    number_format($total, 2) .
                    '</h4></td></tr> 
                                  ';
            } elseif ($val->category_name == "Class 2 Medical Devices") {
                $application_fee = $val->application_fee;
                $subtotal =
                    $ior_reg_fee +
                    $product_liability_insurance +
                    $application_fee;
                $jct = $subtotal / 10;
                $total = $subtotal + $jct;
                $result .=
                    '<tr><td><h4>IOR Registration Fee</h4></td><td style="text-align:right;"><h4>USD</h4></td></tr>
                                                        <tr><td>One Time  IOR Registration Fee</td><td style="text-align:right;"> ' .
                    number_format($ior_reg_fee, 2) .
                    '</td></tr>
                                                        <tr><td>Annual Liability Insurance Insurance</td><td style="text-align:right;">  ' .
                    number_format($product_liability_insurance, 2) .
                    ' </td></tr> 
                                                        <tr class="spaceUnder"><td>Class 2 Medical Device Application (Up to 25 Products)</td><td style="text-align:right;"> ' .
                    number_format($application_fee, 2) .
                    ' </td></tr> 
                                                        <tr><td><b>Class 2 Medical Device Approval Application Fee includes:</b></td></tr>
                                                        <tr><td><i> <center>- Product Labeling Compliance </center></i></td></tr>
                                                        <tr class="spaceUnder"><td><i> <center>- Product Approval Application</center> </td></tr>
                                                        <tr><td><b>Subtotal</b></td><td style="text-align:right;"><b> ' .
                    number_format($subtotal, 2) .
                    ' </b></td></tr> 
                                                        <tr><td>Japan Consumer Tax (10%)</td><td style="text-align:right;"> ' .
                    number_format($jct, 2) .
                    '</td></tr> 
                                                        <tr class="spaceUnder"><td><h4>TOTAL</h4></td><td style="text-align:right;"><h4>$' .
                    number_format($total, 2) .
                    '</h4></td></tr> 
                                                      ';
            }
            $result .= "</table> </div>";
            echo $result;
        }
    }

    public function send_mail(
        $to_email,
        $template,
        $subject,
        $contact_person,
        $username,
        $password
    ) {
        $mail = $this->phpmailer_library->load();
        $mail->isSMTP();
        $mail->Host = "mail.covueior.com";
        $mail->SMTPAuth = true;
        $mail->Username = "admin@covueior.com";
        $mail->Password = "Y.=Sa3hZxq+>@6";
        // $mail->SMTPSecure = 'ssl'; // tls
        $mail->Port = 26; // 587
        $mail->setFrom("admin@covueior.com", "COVUE IOR Japan");

        $mail->addAddress($to_email);
        $mail->addBCC("mikecoros05@gmail.com");

        $mail->Subject = $subject;
        $mail->isHTML(true);

        $data["contact_person"] = $contact_person;
        $data["username"] = $username;
        $data["password"] = $password;
        $mailContent = $this->load->view($template, $data, true);

        $mail->Body = $mailContent;

        if ($mail->send()) {
            $message = "success";
        } else {
            $message = "failed";
        }

        return $message;
    }
}
