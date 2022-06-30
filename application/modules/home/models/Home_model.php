<?php
date_default_timezone_set("Asia/Tokyo");

class Home_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function login($username, $password)
    {
        $query = $this->db->query("SELECT * FROM `users` WHERE `username` = '$username' AND `password`='$password' AND `active` = 1 AND user_role_id != 4");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    function login_partner($username, $password)
    {
        $query = $this->db->query("SELECT * FROM `shipping_companies` WHERE `username` = '$username' AND `password`='$password' AND `partner` = 1");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    function login_consultant($username, $password)
    {
        $query = $this->db->query("SELECT * FROM `users` WHERE `username` = '$username' AND `password`='$password' AND `user_role_id` = 4");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    function check_email($email)
    {
        $query = $this->db->query("SELECT * FROM `users` WHERE `email` = '$email' AND `active` = 1");
        return $query;
    }

    function check_partners_email($email)
    {
        $query = $this->db->query("SELECT * FROM `shipping_companies` WHERE `email` = '$email' AND `active` = 1");
        return $query;
    }

    function fetch_countries()
    {
        $query = $this->db->query("SELECT * FROM `countries`");
        return $query;
    }

    function fetch_shipping_companies()
    {

        $query = $this->db->query("SELECT * FROM `shipping_companies`");
        return $query;
    }

    function fetch_shipping_companies_v($partner_id)
    {

        $query = $this->db->query("SELECT * FROM `shipping_companies` where id = '$partner_id'");
        return $query;
    }

    function insert_new_user($username, $password, $company_name, $company_address, $city, $country, $zip_code, $business_license, $contact_number, $contact_person, $email, $shipping_company, $online_seller,$client_type,$link, $created_at)
    {
        $checkduplicate = $this->db->query("SELECT `email` FROM `users` WHERE `email` = '$email'");
        $count_row      = $checkduplicate->num_rows();
        $pli = 0;


        // if($client_type == '3'){
        //     $pli = 1;
        // }

        if ($count_row > 0) {
            return 2;
        } else {
           $this->db->query("INSERT INTO `users`(`username`, `password`, `company_name`, `company_address`, `city`, `country`, `zip_code`, `business_license`, `user_role_id`, `contact_number`, `contact_person`, `email`, `shipping_company`, `super_admin`, `online_seller`,`shipping_company_link`, `created_at`, `pli`) 
						  VALUES ('$username','$password','$company_name','$company_address','$city','$country','$zip_code','$business_license','$client_type','$contact_number','$contact_person','$email','$shipping_company', 0,'$online_seller','$link','$created_at', '$pli')");
           return $this->db->affected_rows() > 0;
        
        }
    }
    function insert_new_partner($username, $password, $company_name, $country, $contact_person, $email, $image,$content,$image1,$image2,$hcolor,$fcolor, $created_at)
    {
        $checkduplicate = $this->db->query("SELECT `email` FROM `shipping_companies` WHERE `email` = '$email'");
        $count_row      = $checkduplicate->num_rows();

        if ($count_row > 0) {
            return 2;
        } else {
            $this->db->query("INSERT INTO `shipping_companies`(`username`, `password`, `shipping_company_name`, `country`, `contact_person`, `email`, `logo`,`landing_page_banner`,`landing_page_content`,`landing_page_background`,`header_color`,`footer_color`, `created_at`, `active`) 
							    VALUES ('$username','$password','$company_name','$country','$contact_person','$email','$image','$image1','$content','$image2','$hcolor','$fcolor','$created_at',1)");
            return $this->db->affected_rows() > 0;
        }
    }

    function insert_new_consultant($username, $password, $company_name, $country, $contact_person, $email, $image,$header_title,$content,$image1,$image2,$hcolor,$fcolor, $created_at)
    {
        $checkduplicate = $this->db->query("SELECT `email` FROM `users` WHERE `email` = '$email' AND `user_role_id` = 4");
        $count_row      = $checkduplicate->num_rows();

        if ($count_row > 0) {
            return 2;
        } else {
            $this->db->query("INSERT INTO `users`(`username`, `password`, `company_name`, `country`, `contact_person`, `email`, `avatar`,`user_role_id`, `created_at`, `active`) 
                                VALUES ('$username','$password','$company_name','$country','$contact_person','$email','$image',4,'$created_at',1)");

            $consultant_id = $this->db->insert_id();

            $this->db->query("INSERT INTO `consultant`(`consultant_id`,`landing_page_banner`,`landing_page_header_title`,`landing_page_content`,`landing_page_background`,`header_color`,`footer_color`, `created_at`, `active`) 
                                VALUES ('$consultant_id','$image1','$header_title','$content','$image2','$hcolor','$fcolor','$created_at',1)");
            return $this->db->affected_rows() > 0;
        }
    }

    function insert_new_consultant_user($username, $password, $company_name, $company_address, $city, $country, $zip_code, $business_license, $contact_number, $contact_person, $email, $shipping_company, $online_seller,$client_type, $created_at,$consultant_id)
    {
        $checkduplicateemail = $this->db->query("SELECT `email` FROM `users` WHERE `email` = '$email'");
        $count_row_email      = $checkduplicateemail->num_rows();

        $checkduplicateusername = $this->db->query("SELECT `username` FROM `users` WHERE `username` = '$username'");
        $count_row_username      = $checkduplicateusername->num_rows();
        $pli = 0;

        // if($client_type == '3'){
        //     $pli = 1;
        // }

        if ($count_row_email > 0) {
            return 2;
        } else if ($count_row_username > 0) {
            return 3;
        } else {
            $this->db->query("INSERT INTO `users`(`username`, `password`, `company_name`, `company_address`, `city`, `country`, `zip_code`, `business_license`, `consultant_id`, `user_role_id`, `contact_number`, `contact_person`, `email`, `shipping_company`, `super_admin`, `online_seller`, `created_at`, `pli`) 
                                VALUES ('$username','$password','$company_name','$company_address','$city','$country','$zip_code','$business_license','$consultant_id','$client_type    ','$contact_number','$contact_person','$email','$shipping_company', 0,'$online_seller','$created_at', '$pli')");
            return $this->db->affected_rows() > 0;
        }
    }

    function validate_registration($email)
    {
        $query = $this->db->query("UPDATE users set active = 1 WHERE `email` = '$email'");
        return $this->db->affected_rows() > 0;
    }

    function fetch_category()
    {
        $this->db->select('*');
        $this->db->from('product_services');
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_ior_category()
    {
        $this->db->select('*');
        $this->db->from('quotation_values');
        $this->db->where("active", 1);
        $this->db->order_by('category_name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function get_category_details($data)
    {
        $this->db->select('*');
        $this->db->from('quotation_values');
        $this->db->where("category_name", $data);
        $query = $this->db->get();
        return $query->result();
    }

    function fetch_users_by_id($user_id)
    {
        $query = $this->db->query("SELECT *, `id` AS 'user_id' FROM `users` WHERE `active` = 1 AND `id` = $user_id");
        return $query;
    }

    function fetch_users_by_consultant_id($user_id)
    {
        $query = $this->db->query("SELECT * FROM `users` LEFT JOIN `consultant` ON `users`.`id` = `consultant`.`consultant_id` WHERE `users`.`user_role_id` = 4 AND `users`.`id` = $user_id");
        return $query;
    }

    function fetch_country_by_id($country_id)
    {
        $query = $this->db->query("SELECT `nicename` FROM `countries` WHERE `id` = $country_id");
        return $query;
    }



    function sync_user($data){
        return $this->check_zoho_account($data);
    }

    function create_zoho_account($data){
        $client_id ='1000.ZCWLXFP9952W2HBEOJHV2OPRI7P9TX';//Enter your Client ID here
        $client_secret = '3e80beb431890c908d29186e069fdaac31e52abe91';//Enter your Client Secret here
        $code = '1000.9589afca7a8be967eab9b7d3f4ff8042.9afbe83bf41911eab0d8d0fcdfff606a';//Enter your Code here
        $base_acc_url = 'https://accounts.zoho.com';
        $service_url = 'https://creator.zoho.com';

        $refresh_token = '1000.c75e998d0adc76bf68573cee147e2e8a.77635c78d0c75cb35fab078b0f2cb1f6';

        $access_token_url = $base_acc_url .  '/oauth/v2/token?refresh_token='.$refresh_token.'&client_id='.$client_id.'&client_secret='.$client_secret .'&grant_type=refresh_token';

        $access_token = $this->generate_access_token($access_token_url);
        // var_dump($access_token);
        return $this->create_record($access_token,$data);
    }

    function update_zoho_account($id,$data){
        $client_id ='1000.ZCWLXFP9952W2HBEOJHV2OPRI7P9TX';//Enter your Client ID here
        $client_secret = '3e80beb431890c908d29186e069fdaac31e52abe91';//Enter your Client Secret here
        $code = '1000.9589afca7a8be967eab9b7d3f4ff8042.9afbe83bf41911eab0d8d0fcdfff606a';//Enter your Code here
        $base_acc_url = 'https://accounts.zoho.com';
        $service_url = 'https://creator.zoho.com';

        $refresh_token = '1000.c75e998d0adc76bf68573cee147e2e8a.77635c78d0c75cb35fab078b0f2cb1f6';

        $access_token_url = $base_acc_url .  '/oauth/v2/token?refresh_token='.$refresh_token.'&client_id='.$client_id.'&client_secret='.$client_secret .'&grant_type=refresh_token';

        $access_token = $this->generate_access_token($access_token_url);
        // var_dump($access_token);
        return $this->update_record($access_token,$id,$data);
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

    function create_record($access_token,$data){
      $service_url ='https://www.zohoapis.com/crm/v2/Accounts';
      //Authorization: Zoho-oauthtoken access_token
      // $data = array("data" => array("Name" => "Ruben", "Email" => "zoho@aorborc.com"));
      $header = array(
        'Authorization: Zoho-oauthtoken ' . $access_token,
        'Content-Type: application/x-www-form-urlencoded'
      );
      $q_country = $this->fetch_country_by_id($data['country']);
        $countries = $q_country->row();



        

      $requestBody = array();
        $recordArray = array();
        $recordObject = array();
        $recordObject["Account_Name"]=$data['company_name'];
        $recordObject["Address_Line_1"]=$data['company_address'];
        $recordObject["City"]=$data['city'];
        $recordObject["Zip_Code"]=$data['zip_code'];
        $recordObject["Country"]=$countries->nicename;
        $recordObject["Contact_Name"]=$data['contact_person'];
        $recordObject["Email_1"]=$data['email'];
        $recordObject["Phone"]=$data['contact_number'];

        
        
        $recordArray[] = $recordObject;
        $requestBody["data"] =$recordArray;

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_URL, $service_url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));
      curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      $result = curl_exec($ch);
      curl_close($ch);
      return 1;
    }

    function update_record($access_token,$id,$data){
      // $service_url ='https://www.zohoapis.com/crm/v2/Accounts';
      // //Authorization: Zoho-oauthtoken access_token
      // // $data = array("data" => array("Name" => "Ruben", "Email" => "zoho@aorborc.com"));
      // $header = array(
      //   'Authorization: Zoho-oauthtoken ' . $access_token,
      //   'Content-Type: application/x-www-form-urlencoded'
      // );

      // $requestBody = array();
      //   $recordArray = array();
      //   $recordObject = array();
      //   $recordObject["Account_Name"]=$data['company_name'];
      //   $recordObject["Address_Line_1"]=$data['company_address'];
      //   $recordObject["City"]=$data['city'];
      //   $recordObject["Zip_Code"]=$data['zip_code'];
      //   $recordObject["Country"]=$data['country'];
      //   $recordObject["Contact_Name"]=$data['contact_person'];
      //   $recordObject["Email_1"]=$data['email'];
      //   $recordObject["Phone"]=$data['contact_number'];
      //   $recordObject["id"]=$id;

        
        
      //   $recordArray[] = $recordObject;
      //   $requestBody["data"] =$recordArray;

      // $ch = curl_init();
      // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      // curl_setopt($ch, CURLOPT_URL, $service_url);
      // curl_setopt($ch, CURLOPT_PUT, 1);
      // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
      // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));
      // curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      // $result = curl_exec($ch);
      // curl_close($ch);
      // var_dump($result);
        

        $curl_pointer = curl_init();
        
        $curl_options = array();
        $url = "https://www.zohoapis.com/crm/v2/Accounts";
        
        $curl_options[CURLOPT_URL] =$url;
        $curl_options[CURLOPT_RETURNTRANSFER] = true;
        $curl_options[CURLOPT_HEADER] = 1;
        $curl_options[CURLOPT_CUSTOMREQUEST] = "PUT";
        $requestBody = array();
        $recordArray = array();
        $recordObject = array();
        // $recordObject["Account_Name"]=$data['company_name'];
        $recordObject["Address_Line_1"]=$data['company_address'];
        $recordObject["City"]=$data['city'];
        $recordObject["Zip_Code"]=$data['zip_code'];
        $recordObject["Country"]=$data['country'];
        $recordObject["Contact_Name"]=$data['contact_person'];
        $recordObject["Email_1"]=$data['email'];
        $recordObject["Phone"]=$data['contact_number'];
        $recordObject["id"]=$id;

        
        
        $recordArray[] = $recordObject;
        $requestBody["data"] =$recordArray;
        $curl_options[CURLOPT_POSTFIELDS]= json_encode($requestBody);
        $headersArray = array();
        
        $headersArray[] = "Authorization". ":" . "Zoho-oauthtoken " . $access_token;
        
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
        }
        return 1;
    }

    function check_zoho_account($data){
        $client_id ='1000.ZCWLXFP9952W2HBEOJHV2OPRI7P9TX';//Enter your Client ID here
        $client_secret = '3e80beb431890c908d29186e069fdaac31e52abe91';//Enter your Client Secret here
        $code = '1000.9589afca7a8be967eab9b7d3f4ff8042.9afbe83bf41911eab0d8d0fcdfff606a';//Enter your Code here
        $base_acc_url = 'https://accounts.zoho.com';
        $service_url = 'https://creator.zoho.com';

        $refresh_token = '1000.c75e998d0adc76bf68573cee147e2e8a.77635c78d0c75cb35fab078b0f2cb1f6';

        $access_token_url = $base_acc_url .  '/oauth/v2/token?refresh_token='.$refresh_token.'&client_id='.$client_id.'&client_secret='.$client_secret .'&grant_type=refresh_token';

        $access_token = $this->generate_access_token($access_token_url);
        // var_dump($access_token);
        $result = $this->search_record($access_token,$data->company_name);

        return $result;
    }

    

    function check_zoho_account_update($account_name){
        $client_id ='1000.ZCWLXFP9952W2HBEOJHV2OPRI7P9TX';//Enter your Client ID here
        $client_secret = '3e80beb431890c908d29186e069fdaac31e52abe91';//Enter your Client Secret here
        $code = '1000.9589afca7a8be967eab9b7d3f4ff8042.9afbe83bf41911eab0d8d0fcdfff606a';//Enter your Code here
        $base_acc_url = 'https://accounts.zoho.com';
        $service_url = 'https://creator.zoho.com';

        $refresh_token = '1000.c75e998d0adc76bf68573cee147e2e8a.77635c78d0c75cb35fab078b0f2cb1f6';

        $access_token_url = $base_acc_url .  '/oauth/v2/token?refresh_token='.$refresh_token.'&client_id='.$client_id.'&client_secret='.$client_secret .'&grant_type=refresh_token';

        $access_token = $this->generate_access_token($access_token_url);
        // var_dump($access_token);
        $result = $this->search_record($access_token,$account_name);

        return $result;
    }

    function search_record($access_token,$account_name){

        $curl_pointer = curl_init();
        
        $curl_options = array();
        $url = "https://www.zohoapis.com/crm/v2/Accounts/search?";
        $parameters = array();

        $parameters["criteria"]='(Account_Name:equals:'.urlencode($account_name).')';
        
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
}
