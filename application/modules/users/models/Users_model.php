<?php
date_default_timezone_set("Asia/Tokyo");

class Users_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function login($username, $password)
	{
		$query = $this->db->query("SELECT * FROM `users` WHERE `username` = '$username' AND `password`='$password' AND `active`=1");

		if ($query->num_rows() > 0) {
			return $query;
		} else {
			return 0;
		}
	}

	function fetch_all_users()
	{
		$query = $this->db->query("SELECT t1.`id` AS 'user_id', t1.`company_name`, t1.`company_address`, t1.`city`, t2.`nicename`, t1.`zip_code`, t1.`business_license`, t1.`contact_person`, t1.`contact_number`, t1.`email`, t1.`ior_registered`, t1.`pli`, t1.`paid_product_label`, t1.`updated_by` AS 'last_updated_by_id', t3.`contact_person` AS 'last_updated_by', t1.`updated_at` AS 'last_date_updated', t1.`user_role_id`
									FROM `users` AS t1
									LEFT JOIN `countries` AS t2 ON t1.`country` = t2.`id`
									LEFT JOIN `users` AS t3 ON t1.`updated_by` = t3.`id`
									WHERE t1.`active` = 1 AND t1.`super_admin` != 1 AND t1.`user_role_id` != 4
									ORDER BY t1.`created_at` DESC");
		return $query;
	}

	function fetch_all_consultant_users()
	{
		$query = $this->db->query("SELECT t1.`id` AS 'user_id', t1.`company_name`, t1.`company_address`, t1.`city`, t2.`nicename`, t1.`zip_code`, t1.`contact_person`, t1.`contact_number`, t1.`email`, t1.`updated_by` AS 'last_updated_by_id', t3.`contact_person` AS 'last_updated_by', t1.`updated_at` AS 'last_date_updated', t1.`user_role_id`
									FROM `users` AS t1
									LEFT JOIN `countries` AS t2 ON t1.`country` = t2.`id`
									LEFT JOIN `users` AS t3 ON t1.`updated_by` = t3.`id`
									WHERE t1.`active` = 1 AND t1.`super_admin` != 1 AND t1.`user_role_id` = 4
									ORDER BY t1.`created_at` DESC");
		return $query;
	}

	function fetch_all_admin()
	{
		$query = $this->db->query("SELECT t1.`id` AS 'user_id', t1.`company_name`, t1.`company_address`, t1.`city`, t2.`nicename`, t1.`zip_code`, t1.`business_license`, t1.`contact_person`, t1.`contact_number`, t1.`email`, t1.`ior_registered`, t1.`pli`, t1.`paid_product_label`, t1.`updated_by` AS 'last_updated_by_id', t3.`contact_person` AS 'last_updated_by', t1.`updated_at` AS 'last_date_updated',t4.`department_name` AS 'department'
									FROM `users` AS t1
									LEFT JOIN `countries` AS t2 ON t1.`country` = t2.`id`
									LEFT JOIN `users` AS t3 ON t1.`updated_by` = t3.`id`
									LEFT JOIN `department` AS t4 ON t1.`department` = t4.`department_id`
									WHERE t1.`active` = 1 AND t1.`super_admin` = 1
									ORDER BY t1.`contact_person` ASC");
		return $query;
	}

	function fetch_department()
	{
		$query = $this->db->query("SELECT * FROM `department`");
		return $query;
	}

	function fetch_users_by_id($user_id)
	{
		$query = $this->db->query("SELECT *, `id` AS 'user_id' FROM `users` WHERE `active` = 1 AND `id` = $user_id");
		return $query;
	}

	function fetch_consultant_by_id($user_id)
	{
		$query = $this->db->query("SELECT * FROM `users` LEFT JOIN `consultant` ON `users`.`id` = `consultant`.`consultant_id` WHERE `users`.`user_role_id` = 4 AND `users`.`id` = $user_id");
		return $query;
	}

	function fetch_countries()
	{
		$query = $this->db->query("SELECT * FROM `countries`");
		return $query;
	}

	function insert_new_user($username, $password, $company_name, $company_address, $city, $country, $zip_code, $business_license, $contact_number, $contact_person, $email, $ior_registered, $online_seller, $created_at, $created_by)
	{

		$this->db->query("INSERT INTO `users`(`username`, `password`, `company_name`, `company_address`, `city`, `country`, `zip_code`, `business_license`, `user_role_id`, `contact_number`, `contact_person`, `email`, `super_admin`, `ior_registered`, `online_seller`, `created_at`,`created_by`) 
							VALUES ('$username','$password','$company_name','$company_address','$city','$country','$zip_code','$business_license',2,'$contact_number','$contact_person','$email',0,'$ior_registered','$online_seller','$created_at','$created_by')");
		return $this->db->affected_rows() > 0;
	}

	function insert_new_admin_user($username, $password, $contact_person, $email, $department, $department_head, $user_level, $created_at, $created_by)
	{

		$this->db->query("INSERT INTO `users`(`username`, `password`, `user_role_id`, `contact_person`, `email`,`department`,`department_head`, `super_admin`,`user_level`, `created_at`,`created_by`) VALUES ('$username','$password',1,'$contact_person','$email','$department', '$department_head',1,'$user_level', '$created_at','$created_by')");
		return $this->db->affected_rows() > 0;
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


	function update_user($user_id, $username, $password, $company_name, $company_address, $city, $country, $zip_code, $business_license, $contact_number, $contact_person, $email, $ior_registered, $online_seller, $updated_at, $updated_by)
	{

		$this->db->query("UPDATE `users` SET `username`='$username',`password`='$password',`contact_person`='$contact_person',`company_name`='$company_name', `company_address`='$company_address',`city`='$city',`country`='$country',`zip_code`='$zip_code',`business_license`='$business_license',`email`='$email', `contact_number`='$contact_number',`ior_registered`='$ior_registered', `online_seller`='$online_seller',`updated_at`='$updated_at',`updated_by`='$updated_by' WHERE `id` = $user_id");
		return $this->db->affected_rows() > 0;
	}

	function update_consultant_user($user_id, $username, $password, $company_name, $country, $contact_person, $email, $updated_at, $updated_by)
	{

		$this->db->query("UPDATE `users` SET `username`='$username',`password`='$password',`contact_person`='$contact_person',`company_name`='$company_name',`country`='$country',`email`='$email',`updated_at`='$updated_at',`updated_by`='$updated_by' WHERE `id` = $user_id");
		return $this->db->affected_rows() > 0;
	}

	function update_admin_user($user_id, $username, $password, $contact_person, $email, $department, $department_head, $user_level, $updated_at, $updated_by)
	{

		$this->db->query("UPDATE `users` SET `username`='$username',`password`='$password',`contact_person`='$contact_person',`email`='$email',`department`='$department' , `department_head`='$department_head',`user_level`='$user_level',`updated_at`='$updated_at',`updated_by`='$updated_by' WHERE `id` = $user_id");
		return $this->db->affected_rows() > 0;
	}

	function paid_pli($user_id, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `users` SET `pli` = 1, `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `id` = $user_id AND `active` = 1");
		return $this->db->affected_rows() > 0;
	}

	function paid_product_label($user_id, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `users` SET `paid_product_label` = 1, `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `id` = $user_id AND `active` = 1");
		return $this->db->affected_rows() > 0;
	}

	function delete_user($user_id, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `users` SET `active` = 0, `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `id` = $user_id");
		return $this->db->affected_rows() > 0;
	}

	function upload_logo($data, $userid)
	{
		$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
		$image_name = addslashes($_FILES['image']['name']);
		$image_size = getimagesize($_FILES['image']['tmp_name']);

		$path       = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
		$filename   = 'consultants_' . time() . '.' . $path;
		move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/consultants/" . $filename);

		$query = $this->db->query("UPDATE users set avatar ='$filename' WHERE  `id` = $userid");
		return $query;
	}

	function update_banner($data, $userid)
	{
		$image = addslashes(file_get_contents($_FILES['banner']['tmp_name']));
		$image_name = addslashes($_FILES['banner']['name']);
		$image_size = getimagesize($_FILES['banner']['tmp_name']);

		$path       = pathinfo($_FILES["banner"]["name"], PATHINFO_EXTENSION);
		$filename   = 'partners_banner_' . time() . '.' . $path;
		move_uploaded_file($_FILES["banner"]["tmp_name"], "uploads/consultants/" . $filename);

		$query = $this->db->query("UPDATE consultant set landing_page_banner ='$filename' WHERE  `consultant_id` = $userid");
		return $query;
	}

	function update_background($data, $userid)
	{
		$image = addslashes(file_get_contents($_FILES['background']['tmp_name']));
		$image_name = addslashes($_FILES['background']['name']);
		$image_size = getimagesize($_FILES['background']['tmp_name']);

		$path       = pathinfo($_FILES["background"]["name"], PATHINFO_EXTENSION);
		$filename   = 'partners_background_' . time() . '.' . $path;
		move_uploaded_file($_FILES["background"]["tmp_name"], "uploads/consultants/" . $filename);

		$query = $this->db->query("UPDATE consultant set landing_page_background ='$filename' WHERE  `consultant_id` = $userid");
		return $query;
	}

	function update_content($data, $userid)
	{
		$content = $data['content'];
		$query = $this->db->query("UPDATE consultant set landing_page_content ='$content' WHERE  `consultant_id` = $userid");
		return $query;
	}

	function update_header_title($data, $userid)
	{
		$header_title = $data['header_title'];
		$query = $this->db->query("UPDATE consultant set landing_page_header_title ='$header_title' WHERE  `consultant_id` = $userid");
		return $query;
	}

	function update_color_header($data, $userid)
	{
		if($data['header_color']!=""){
			$header = $data['header_color'];
		} else {
			$header = $data['header'];
		}
		$query = $this->db->query("UPDATE consultant set header_color ='$header' WHERE  `consultant_id` = $userid");
		return $query;
	}

	function update_color_footer($data, $userid)
	{
		if($data['footer_color']!=""){
			$footer = $data['footer_color'];
		} else {
			$footer = $data['footer'];
		}
		$query = $this->db->query("UPDATE consultant set footer_color ='$footer' WHERE  `consultant_id` = $userid");
		return $query;
	}

	function fetch_country_by_id($country_id)
	{
		$query = $this->db->query("SELECT `nicename` FROM `countries` WHERE `id` = $country_id");
		return $query;
	}

	// ZOHO API

	function sync_user($data){
		return $this->check_zoho_account($data);
	}

	function sync_user_update($account_name){
		return $this->check_zoho_account_update($account_name);
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
}
