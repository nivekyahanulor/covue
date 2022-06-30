<?php
date_default_timezone_set("Asia/Tokyo");

class Japan_ior_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function fetch_system_settings()
	{
		$query = $this->db->query("SELECT * FROM `system_settings`");
		return $query;
	}

	function fetch_shipping_companies()
	{
		$query = $this->db->query("SELECT * FROM `shipping_companies` WHERE `active` = 1 ORDER BY `shipping_company_name` ASC");
		return $query;
	}

	function fetch_shipping_company_by_id($shipping_company_id)
	{
		$query = $this->db->query("SELECT * FROM `shipping_companies` WHERE `id` = $shipping_company_id");
		return $query;
	}

	function check_shipping_company($shipping_company)
	{
		$query = $this->db->query("SELECT * FROM `shipping_companies` WHERE `shipping_company_name` = '$shipping_company'");
		return $query->num_rows();
	}

	function insert_shipping_company($shipping_company, $created_by, $created_at)
	{
		$this->db->query("INSERT INTO `shipping_companies`(`shipping_company_name`, `created_by`, `created_at`) VALUES ('$shipping_company','$created_by','$created_at')");
		return $this->db->affected_rows() > 0;
	}

	function fetch_admin_user_compliance()
	{
		$query = $this->db->query("SELECT * from `users` WHERE `active` = 1 AND `super_admin` = 1 and `department` = 2 ");
		return $query;
	}

	function fetch_countries()
	{
		$query = $this->db->query("SELECT * FROM `countries`");
		return $query;
	}

	function fetch_country_by_id($country_id)
	{
		$query = $this->db->query("SELECT `nicename` FROM `countries` WHERE `id` = $country_id");
		return $query;
	}

	function insert_new_user_file($username, $password, $company_name, $company_address, $city, $country, $zip_code, $business_license, $contact_number, $contact_person, $email, $online_seller, $amazon_seller, $created_at)
	{
		$this->db->query("INSERT INTO `users`(`username`, `password`, `company_name`, `company_address`, `city`, `country`, `zip_code`, `business_license`, `user_role_id`, `contact_number`, `contact_person`, `email`, `super_admin`, `online_seller`, `amazon_seller`, `created_at`) 
							VALUES ('$username','$password','$company_name','$company_address','$city','$country','$zip_code','$business_license',2,'$contact_number','$contact_person','$email',0,'$online_seller','$amazon_seller','$created_at')");
		return $this->db->affected_rows() > 0;
	}

	function fetch_users_by_id($user_id)
	{
		$query = $this->db->query("SELECT *, `id` AS 'user_id' FROM `users` WHERE `active` = 1 AND `id` = $user_id");
		return $query;
	}

	function fetch_users_file($user_id)
	{
		$query = $this->db->query("SELECT * FROM `users_files`  WHERE `users_id` = $user_id and `active`=1");
		return $query;
	}

	function upload_file($data, $userid)
	{
		$file = addslashes(file_get_contents($_FILES['file_location']['tmp_name']));
		$file_name = addslashes($_FILES['file_location']['name']);
		$file_sizwe = getimagesize($_FILES['file_location']['tmp_name']);

		$path       = pathinfo($_FILES["file_location"]["name"], PATHINFO_EXTENSION);
		$location   = 'user_file_' . time() . '.' . $path;
		$filename   = $data['file_name'];
		$upload_path_file = 'uploads/users_files/' . $userid;

		if (!file_exists($upload_path_file)) {
			mkdir($upload_path_file, 0777, true);
		}

		move_uploaded_file($_FILES["file_location"]["tmp_name"], $upload_path_file .'/'. $location);

		$query = $this->db->query("INSERT INTO `users_files` (`users_id` , `file_name` , `file_location` , `active`) 
								  VALUES ('$userid' , '$filename' , '$location' , 1)");
		return $query;
	}

	function remove_file_upload($id){
		$query = $this->db->query("UPDATE  `users_files` set active =0 where file_id='$id'");
		return $this->db->affected_rows() > 0;
	}

	function update_user($get_id, $username, $password, $company_address, $city, $country, $zip_code, $contact_person, $contact_number, $online_seller, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `users` SET `username`='$username',`password`='$password',`company_address`='$company_address',`city`='$city',`country`='$country',`zip_code`='$zip_code',`contact_person`='$contact_person',`contact_number`='$contact_number',`online_seller`='$online_seller',`updated_by`='$updated_by',`updated_at`='$updated_at'
							WHERE `id` = $get_id");
		return $this->db->affected_rows() > 0;
	}

	function fetch_product_registrations_dashboard_limited($user_id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'prod_registration_id', t3.`id` AS 'product_label_id', t1.`user_id` AS 'end_user_id', t1.`status` AS 'product_status', t3.`status` AS 'product_label_status', t1.`created_at` AS 'product_registration_created'
									FROM `product_registrations` AS t1
									LEFT JOIN `product_registration_status` AS t2 ON t1.`status` = t2.`id`
									LEFT JOIN `product_labels` AS t3 ON t1.`id` = t3.`product_registration_id`
									WHERE t1.`active` = 1 AND t1.`user_id` = $user_id
									ORDER BY t1.`id` DESC LIMIT 5");
		return $query;
	}

	function fetch_product_registrations_dashboard($user_id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'prod_registration_id', t3.`id` AS 'product_label_id', t1.`user_id` AS 'end_user_id', t1.`status` AS 'product_status', t3.`status` AS 'product_label_status', t1.`created_at` AS 'product_registration_created'
									FROM `product_registrations` AS t1
									LEFT JOIN `product_registration_status` AS t2 ON t1.`status` = t2.`id`
									LEFT JOIN `product_labels` AS t3 ON t1.`id` = t3.`product_registration_id`
									LEFT JOIN `product_categories` AS t4 ON t1.`product_category_id` = t4.`id`
									WHERE t1.`active` = 1 AND t1.`user_id` = $user_id
									ORDER BY t1.`id` DESC");
		return $query;
	}

	function fetch_product_registrations_approved($user_id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'prod_registration_id', t3.`id` AS 'product_label_id', t1.`user_id` AS 'end_user_id', t1.`status` AS 'product_status', t3.`status` AS 'product_label_status', t1.`created_at` AS 'product_registration_created'
									FROM `product_registrations` AS t1
									LEFT JOIN `product_registration_status` AS t2 ON t1.`status` = t2.`id`
									LEFT JOIN `product_labels` AS t3 ON t1.`id` = t3.`product_registration_id`
									WHERE t1.`active` = 1 AND t1.`status` = 1 AND t1.`user_id` = $user_id");
		return $query;
	}

	function fetch_approved_product_qualification($user_id, $category = '')
	{
		if ($category == 4 || $category == 13) {
			$query = $this->db->query("SELECT * FROM `product_registrations` WHERE `active` = 1 AND `status` = 1 AND `user_id` = $user_id  AND `status` = 1  AND `application_status` = 1 AND product_category_id IN (4,13) ");
		} else if ($category == 1 || $category == 11 || $category == 8 || $category == 9) {
			$query = $this->db->query("SELECT * FROM `product_registrations` WHERE `active` = 1 AND `status` = 1 AND `user_id` = $user_id  AND `status` = 1  AND product_category_id IN (1,11,8,9)");
		} else if ($category == 12 || $category == 3) {
			$query = $this->db->query("SELECT * FROM `product_registrations` WHERE `active` = 1 AND `status` = 1 AND `user_id` = $user_id  AND `status` = 1  AND `application_status` = 1  AND product_category_id IN (12,3) ");
		} else {
			$query = $this->db->query("SELECT * FROM `product_registrations` WHERE `active` = 1 AND `status` = 1  AND  (regulated_application_id = 0 OR product_category_id IN (1,11,8)  OR application_status = 1  ) AND `user_id` = $user_id");
		}
		return $query;
	}

	function fetch_approved_product_qualification_v($user_id, $category = '')
	{
		if ($category == 1 || $category == 11 || $category == 8 || $category == 3 || $category == 4 || $category == 9 || $category == 12 || $category == 13) {
			$query = $this->db->query("SELECT `id`, `product_name` FROM `product_registrations` WHERE `active` = 1 AND `status` = 1 AND `user_id` = $user_id AND `product_category_id` IN (1,11,8,3,4,9,12,13) ");
		} else {
			$query = $this->db->query("SELECT * FROM `product_registrations` WHERE `active` = 1 AND `status` = 1 AND  `user_id` = $user_id");
		}
		return $query;
	}

	function fetch_product_registration($id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'product_registration_id' FROM `product_registrations` AS t1
									LEFT JOIN `product_registration_status` AS t2 ON t1.`status` = t2.`id`
									WHERE t1.`active` = 1 AND t1.`id` = $id");
		return $query;
	}

	function count_approved_product_registrations($user_id)
	{
		$query = $this->db->query("SELECT * FROM `product_registrations` AS t1
									LEFT JOIN `product_registration_status` AS t2 ON t1.`status` = t2.`id`
									WHERE t1.`active` = 1 AND t1.`user_id` = $user_id AND t1.`status` = 1");

		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	function insert_product_registration($user_id, $sku, $product_name, $product_img, $product_label, $product_type, $dimensions_by_piece, $weight_by_piece, $is_mailing_product, $created_by, $created_at)
	{
		$this->db->query("INSERT INTO `product_registrations`(`user_id`, `sku`, `product_name`, `product_img`, `product_label`,`product_type`, `dimensions_by_piece`,`weight_by_piece`,`is_mailing_product`, `status`, `created_by`, `created_at`) 
	 						VALUES ('$user_id','$sku','$product_name','$product_img', '$product_label','$product_type','$dimensions_by_piece','$weight_by_piece','$is_mailing_product', '4', '$created_by', '$created_at')");
		return $this->db->affected_rows() > 0;
	}

	function update_products($id, $sku, $product_name, $product_type, $dimensions_by_piece, $weight_by_piece, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `product_registrations` SET `sku` = '$sku', `product_name` = '$product_name', `product_type` = '$product_type', `dimensions_by_piece` = '$dimensions_by_piece', `weight_by_piece` = '$weight_by_piece', `status` = 5, `updated_by` = '$updated_by', `updated_at` = '$updated_at' WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function update_products_img($id, $sku, $product_name, $product_type, $dimensions_by_piece, $weight_by_piece, $product_img, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `product_registrations` SET `sku` = '$sku', `product_name` = '$product_name', `product_type` = '$product_type', `dimensions_by_piece` = '$dimensions_by_piece', `weight_by_piece` = '$weight_by_piece', `product_img` = '$product_img', `status` = 5, `updated_by` = '$updated_by', `updated_at` = '$updated_at' WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function update_products_label($id, $sku, $product_name, $product_label, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `product_registrations` SET `sku` = '$sku', `product_name` = '$product_name', `product_label` = '$product_label', `status` = 5, `updated_by` = '$updated_by', `updated_at` = '$updated_at' WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function update_products_img_and_label($id, $sku, $product_name, $product_img, $product_label, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `product_registrations` SET `sku` = '$sku', `product_name` = '$product_name', `product_img` = '$product_img', `product_label` = '$product_label', `status` = 5, `updated_by` = '$updated_by', `updated_at` = '$updated_at' WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function update_product_certificate($id, $product_certificate, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `product_registrations` SET `product_certificate` = '$product_certificate', `updated_by` = '$updated_by', `updated_at` = '$updated_at', `status` = 5 WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function fetch_product_labels($user_id)
	{
		$query = $this->db->query("SELECT t1.`id` AS 'product_label_id', t3.`company_name`, t7.`category_name`, t2.`product_name`, t1.`product_label_filename`, t4.`nicename` AS 'made_in', t1.`status` AS 'product_label_status', t5.`label`, t2.`id` AS 'product_registration_id', t3.`id` AS 'user_details_id', t1.`created_at` AS 'product_label_date', t1.`updated_by` AS 'last_updated_by_id', t6.`contact_person` AS 'last_updated_by', t1.`updated_at` AS 'last_date_updated'
									FROM `product_labels` AS t1
									LEFT JOIN `product_registrations` AS t2 ON t1.`product_registration_id` = t2.`id`
									LEFT JOIN `users` AS t3 ON t1.`user_id` = t3.`id`
									LEFT JOIN `countries` AS t4 ON t1.`country_of_origin` = t4.`id`
									LEFT JOIN `product_label_status` AS t5 ON t1.`status` = t5.`id`
									LEFT JOIN `users` AS t6 ON t1.`updated_by` = t6.`id`
									LEFT JOIN `product_categories` AS t7 ON t2.`product_category_id` = t7.`id`
									WHERE t1.`active` = 1 AND t2.`user_id` = $user_id ORDER BY t1.`created_at` DESC");
		return $query;
	}

	function insert_product_registration_for_label($user_id, $sku, $product_name, $product_img, $created_by, $created_at)
	{
		$this->db->query("INSERT INTO `product_registrations`(`user_id`, `sku`, `product_name`, `product_img`, `status`, `created_by`, `created_at`) 
	 						VALUES ('$user_id','$sku','$product_name','$product_img', 6, '$created_by', '$created_at')");
		return $this->db->insert_id();
	}

	function insert_product_label_details($user_id, $product_registration_id, $website, $product_info, $product_handling, $country_of_origin, $expiration_date, $created_by, $created_at)
	{
		$this->db->query("INSERT INTO `product_labels`(`user_id`, `product_registration_id`, `website`, `product_info`, `product_handling`, `country_of_origin`, `expiration_date`, `status`, `active`, `created_by`, `created_at`) 
							VALUES ('$user_id','$product_registration_id','$website','$product_info','$product_handling','$country_of_origin','$expiration_date',2,1,'$created_by','$created_at')");
		return $this->db->affected_rows() > 0;
	}

	function update_user_product_label($user_id)
	{
		$this->db->query("UPDATE `users` SET `paid_product_label` = 0 WHERE `id` = $user_id");
		return $this->db->affected_rows() > 0;
	}

	function update_product_label_details($id, $website, $product_info, $product_handling, $country_of_origin, $expiration_date, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `product_labels` SET `website`='$website',`product_info`='$product_info',`product_handling`='$product_handling',
							`country_of_origin`='$country_of_origin',`expiration_date`='$expiration_date',`status`=2,`updated_by`='$updated_by',`updated_at`='$updated_at' 
							WHERE `id`=$id");
		return $this->db->affected_rows() > 0;
	}

	function fetch_product_services()
	{
		$query = $this->db->query("SELECT * FROM `product_services` WHERE `active` = 1 ORDER BY `id` ASC");
		return $query;
	}

	function fetch_products_offer()
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'product_offer_id' FROM `products_offer` AS t1
									LEFT JOIN `product_categories` AS t2 ON t1.`product_category_id` = t2.`id`
									LEFT JOIN `product_services` AS t3 ON t2.`product_service_id` = t3.`id`
									WHERE t1.`active` = 1 ORDER BY t1.`name` ASC");
		return $query;
	}

	function fetch_product_offer($id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'product_offer_id' FROM `products_offer` AS t1
									LEFT JOIN `product_categories` AS t2 ON t1.`product_category_id` = t2.`id`
									LEFT JOIN `product_services` AS t3 ON t2.`product_service_id` = t3.`id`
									WHERE t1.`id` = $id AND t1.`active` = 1");
		return $query;
	}

	function getProductbyID($id)
	{
		$query = $this->db->query("SELECT * FROM `products` WHERE `id` = $id");
		return $query;
	}

	function fetch_paypal_products()
	{
		$query = $this->db->query("SELECT * FROM `products` WHERE `status` = 1 AND `id` != 1 ORDER BY id ASC");
		return $query;
	}

	function fetch_pricing_fee($data)
	{
		$query = $this->db->query("SELECT * FROM `product_pricing_fee` where category_id='$data'");
		return $query;
	}

	function fetch_pricing_fee_v2($data , $data2)
	{
		$query = $this->db->query("SELECT * FROM `product_pricing_fee` where category_id='$data' and id ='$data2'");
		return $query;
	}
	
	function update_ior_pli($user_id)
	{
		$today = date('Y-m-d');
		$this->db->query("UPDATE `users` SET `ior_registered` = 1, `ior_registration_date` = '$today', `pli` = 1, `pli_date` = '$today' WHERE `id` = $user_id");
		return $this->db->affected_rows() > 0;
	}

	function update_to_registered($user_id)
	{
		$today = date('Y-m-d');
		$this->db->query("UPDATE `users` SET `ior_registered` = 1, `ior_registration_date` = '$today' WHERE `id` = $user_id");
		return $this->db->affected_rows() > 0;
	}

	function update_to_pli($user_id)
	{
		$today = date('Y-m-d');
		$this->db->query("UPDATE `users` SET `pli` = 1, `pli_date` = '$today' WHERE `id` = $user_id");
		return $this->db->affected_rows() > 0;
	}

	function update_shipping_invoice_id($user_id, $billing_id)
	{
		$today = date('Y-m-d');
		$this->db->query("UPDATE `shipping_invoices` SET `paid` = 1 WHERE `user_id` = $user_id AND billing_invoice_id='$billing_id' ");
		return $this->db->affected_rows() > 0;
	}


	function update_to_paid_product_label($user_id)
	{
		$this->db->query("UPDATE `users` SET `paid_product_label` = 1 WHERE `id` = $user_id");
		return $this->db->affected_rows() > 0;
	}

	function fetch_user_by_id($user_id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'user_id', t2.`nicename` AS country_name 
									FROM `users` AS t1
									LEFT JOIN `countries` AS t2 ON t1.`country` = t2.`id`
									WHERE t1.`id` = $user_id");
		return $query;
	}

	function fetch_product_data($product_registration_id)
	{
		$query = $this->db->query("SELECT t1.`sku` , t2.`category_name` ,t2.`id` as category_id , t1.`regulated_application_id`, t1.`product_type` FROM `product_registrations` t1 
		LEFT JOIN product_categories t2 on t1.product_category_id =  t2.id
		WHERE t1.`active` = 1 AND t1.`id` = $product_registration_id");
		return $query;
	}

	function fetch_registered_products($user_id, $category)
	{

		if ($category == 4 || $category == 13) {
			$query = $this->db->query("SELECT `id`, `product_name` FROM `product_registrations` WHERE `active` = 1 AND `status` = 1 AND `user_id` = $user_id AND `application_status` = 1 AND `product_category_id` IN (4,13) ");
		} else if ($category == 3 || $category == 12) {
			$query = $this->db->query("SELECT `id`, `product_name` FROM `product_registrations` WHERE `active` = 1 AND `status` = 1 AND `user_id` = $user_id AND `application_status` = 1 AND `product_category_id` IN (3,12)  ");
		} else if ($category == 1 || $category == 11 || $category == 8 || $category == 9) {
			$query = $this->db->query("SELECT `id`, `product_name` FROM `product_registrations` WHERE `active` = 1 AND `status` = 1 AND `user_id` = $user_id AND `product_category_id` IN (1,11,8,9) ");
		} else {
			$query = $this->db->query("SELECT * FROM `product_registrations` WHERE `active` = 1 AND `status` = 1  AND  (regulated_application_id = 0 OR product_category_id IN (1,11,8)  OR application_status = 1  ) AND `user_id` = $user_id");
		}
		return $query;
	}
	
	function fetch_registered_products_sampling($user_id, $category)
	{

		// if ($category == 4 || $category == 13) {
		// 	$query = $this->db->query("SELECT `id`, `product_name` FROM `product_registrations` WHERE `active` = 1 AND `status` = 1 AND `user_id` = $user_id AND `product_category_id` IN (4,13) ");
		// } else if ($category == 3 || $category == 12) {
		// 	$query = $this->db->query("SELECT `id`, `product_name` FROM `product_registrations` WHERE `active` = 1 AND `status` = 1 AND `user_id` = $user_id AND `product_category_id` IN (3,12)  ");
		// } else 
		
		if ($category == 1 || $category == 11 || $category == 8 || $category == 3 || $category == 4 || $category == 9 || $category == 12 || $category == 13) {
			$query = $this->db->query("SELECT `id`, `product_name` FROM `product_registrations` WHERE `active` = 1 AND `status` = 1 AND `user_id` = $user_id AND `product_category_id` IN (1,11,8,3,4,9,12,13) ");
		} else {
			$query = $this->db->query("SELECT `id`, `product_name` FROM `product_registrations` WHERE `active` = 1 AND `status` = 1 AND `user_id` = $user_id AND `product_category_id`='$category' ");
		}
		return $query;
	}
	
	

	function quick_update_contact($user_id, $contact_name, $contact_number, $email, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `users` SET `contact_person` = '$contact_name', `contact_number` = '$contact_number', `email` = '$email', `updated_at` = '$updated_at', `updated_by` = '$updated_by' 
							WHERE `id` = $user_id");
		return $this->db->affected_rows() > 0;
	}

	function fetch_shipping_invoices()
	{
		$query = $this->db->query("SELECT *, t1.`id` AS shipping_invoice_id, t2.`id` AS shipping_status_id FROM `shipping_invoices` AS t1
									LEFT JOIN `shipping_invoice_status` AS t2 ON t1.`status` = t2.`id`
									WHERE t1.`active` = 1");
		return $query;
	}

	function fetch_all_regulated_category_data($category, $regulated, $id)
	{
		$query = $this->db->query("SELECT `sku`, `product_name`, `id` as prod_reg_id FROM `product_registrations`
								   WHERE `active` = 1 AND `status` = 1 AND `regulated_application_id`='$regulated' AND `product_category_id` ='$category' and `id` NOT IN('$id')");

		return $query;
	}

	function fetch_logistic_product_details($sid, $shipping_code)
	{
		$query = $this->db->query("SELECT * FROM logistic_product_details WHERE `shippping_code` = '$shipping_code' AND `product_id`='$sid'");

		return $query;
	}


	function fetch_shipping_invoices_by_user_id_limited($user_id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS shipping_invoice_id, t2.`id` AS shipping_status_id FROM `shipping_invoices` AS t1
									LEFT JOIN `shipping_invoice_status` AS t2 ON t1.`status` = t2.`id`
									LEFT JOIN `users` AS t3 ON t1.`user_id` = t3.`id`
									WHERE t1.`user_id` = $user_id AND t1.`active` = 1
									ORDER BY t1.`id` DESC LIMIT 5");
		return $query;
	}

	function fetch_shipping_invoices_by_user_id($user_id , $sampling)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS shipping_invoice_id, t2.`id` AS shipping_status_id , t1.`shipping_company` as ship_company
									FROM `shipping_invoices` AS t1
									LEFT JOIN `shipping_invoice_status` AS t2 ON t1.`status` = t2.`id`
									LEFT JOIN `users` AS t3 ON t1.`user_id` = t3.`id`
									LEFT JOIN `product_categories` AS t4 ON t1.`product_category` = t4.`id`
									WHERE t1.`user_id` = $user_id AND t1.`active` = 1 AND t1.`product_sampling` = '$sampling'
									ORDER BY t1.`id` DESC");
		return $query;
	}

	function fetch_shipping_invoice_by_id($shipping_invoice_id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS shipping_invoice_id, t2.`id` AS shipping_status_id, t3.`nicename` AS country_name , t1.`shipping_company` as shipping_invoice_company
									FROM `shipping_invoices` AS t1
									LEFT JOIN `shipping_invoice_status` AS t2 ON t1.`status` = t2.`id`
									LEFT JOIN `countries` AS t3 ON t1.`country_of_origin` = t3.`id`
									LEFT JOIN `shipping_companies` AS t4 ON t1.`shipping_company` = t4.`id`
									LEFT JOIN `users` AS t5 ON t1.`user_id` = t5.`id`
									WHERE t1.`id` = $shipping_invoice_id AND t1.`active` = 1");
		return $query;
	}

	function fetch_shipping_products($shipping_invoice_id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS shipping_invoice_product_id , t2.`product_name` FROM `shipping_invoice_products` AS t1
		LEFT JOIN `product_registrations` AS t2 ON t1.`product_registration_id` = t2.`id` 
		WHERE t1.`shipping_invoice_id` = $shipping_invoice_id");
		return $query;
	}

	function fetch_logistic_form($shipping_invoice_id)
	{
		$query = $this->db->query("SELECT *, t2.company_name ,  t2.contact_person 
									FROM import_logistics AS t1
									LEFT JOIN `users` AS t2 ON t1.`user_id` = t2.`id`
									WHERE t1.`shipping_invoice_id` = $shipping_invoice_id");
		return $query;
	}

	function fetch_shipping_invoice_products_by_id($shipping_invoice_id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS shipping_invoice_product_id FROM `shipping_invoice_products` AS t1
									LEFT JOIN `product_registrations` AS t2 ON t1.`product_registration_id` = t2.`id` 
									WHERE t1.`active` = 1 AND t1.`shipping_invoice_id` = $shipping_invoice_id");
		return $query;
	}

	function insert_shipping_invoice($user_id, $invoice_date, $shipping_company, $shipping_tracking_no, $supplier_name, $supplier_address, $supplier_phone_no, $same_address, $destination_recipient_name, $destination_company_name, $destination_address, $destination_phone_no, $country_of_origin, $total_unit_value, $fba_fees, $total_value_of_shipment, $fosr, $simulator, $status, $active, $created_by, $fba, $prodcat, $category_type,$product_sampling, $paid, $created_at,$shipping_session)
	{
		$this->db->query("INSERT INTO `shipping_invoices`(`user_id`, `invoice_date`, `shipping_company`, `shipping_tracking_no`, `supplier_name`, `supplier_address`, `supplier_phone_no`, `same_address`, `destination_recipient_name`, `destination_company_name`, `destination_address`, `destination_phone_no`, `country_of_origin`, `total_unit_value`, `fba_fees`, `total_value_of_shipment`, `fosr`, `simulator`, `status`, `active`, `fba_location`,`product_category`,`category_type`, `created_by`,`product_sampling`, `paid`,`shipping_code`, `created_at`) 
							VALUES ('$user_id', '$invoice_date', '$shipping_company', '$shipping_tracking_no', '$supplier_name', '$supplier_address', '$supplier_phone_no', '$same_address', '$destination_recipient_name', '$destination_company_name', '$destination_address', '$destination_phone_no', '$country_of_origin', '$total_unit_value', '$fba_fees', '$total_value_of_shipment', '$fosr',  '$simulator', '$status', '$active', '$fba','$prodcat','$category_type','$created_by','$product_sampling','$paid','$shipping_session', '$created_at')");
		return $this->db->insert_id();
	}

	function insert_logistic_form($user_id,$shipping_invoice_id,$shipping_session, $street_address,$address_line_2,$city,$state,$postal,$country_1,$created_at)
	{

		$check = $this->db->query("SELECT * from import_logistics where shippping_code = '$shipping_session'");
		$cnt = $check->num_rows();

		if($cnt ==0){
			$this->db->query("INSERT INTO `import_logistics`(`user_id`, `shipping_invoice_id`, `street_address`, `address_line_2`, `city`, `state`, `postal`, `country_1`,`created_at`) 
							VALUES ('$user_id', '$shipping_invoice_id', '$street_address', '$address_line_2', '$city', '$state', '$postal', '$country_1','$created_at')");
		} else {
			$this->db->query("UPDATE import_logistics SET shipping_invoice_id =  '$shipping_invoice_id' where shippping_code = '$shipping_session' ");
		}
		return $this->db->insert_id();	
	}

	function insert_shipping_invoice_ups($user_id, $invoice_date, $shipping_company, $total_value_of_shipment, $fosr, $status, $active, $created_by, $created_at)
	{
		$this->db->query("INSERT INTO `shipping_invoices`(`user_id`, `invoice_date`, `shipping_company`, `total_value_of_shipment`, `fosr`, `status`, `active`, `created_by`, `created_at`) 
							VALUES ('$user_id', '$invoice_date', '$shipping_company', '$total_value_of_shipment', '$fosr', '$status', '$active', '$created_by', '$created_at')");
		return $this->db->insert_id();
	}

	function insert_shipping_invoice_products($shipping_invoice_id, $product_registration_id, $asin, $online_selling_price, $fba_listing_fee, $fba_shipping_fee,  $quantity, $unit_value, $unit_value_total_amount, $total_amount, $active, $created_at)
	{
		
		$online_selling_price = str_replace(',', '', $online_selling_price);

		$this->db->query("INSERT INTO `shipping_invoice_products`(`shipping_invoice_id`, `product_registration_id`, `asin`, `online_selling_price`, `fba_listing_fee`, `fba_shipping_fee`, `quantity`, `unit_value`, `unit_value_total_amount`, `total_amount`, `active`, `created_at`) 
							VALUES ('$shipping_invoice_id', '$product_registration_id', '$asin', '$online_selling_price', '$fba_listing_fee', '$fba_shipping_fee', '$quantity', '$unit_value', '$unit_value_total_amount', '$total_amount', '$active', '$created_at')");
		return $this->db->affected_rows() > 0;
	}

	function insert_shipping_invoice_products_sampling($shipping_invoice_id, $product_registration_id, $asin, $online_selling_price, $fba_listing_fee, $fba_shipping_fee,  $quantity, $unit_value, $unit_value_total_amount, $total_amount, $active, $created_at)
	{
		$this->db->query("INSERT INTO `shipping_invoice_products`(`shipping_invoice_id`, `product_registration_id`, `asin`, `online_selling_price`, `fba_listing_fee`, `fba_shipping_fee`, `quantity`, `unit_value`, `unit_value_total_amount`, `total_amount`, `active`, `product_sample`, `created_at`) 
							VALUES ('$shipping_invoice_id', '$product_registration_id', '$asin', '$online_selling_price', '$fba_listing_fee', '$fba_shipping_fee', '$quantity', '$unit_value', '$unit_value_total_amount', '$total_amount', '$active', 1, '$created_at')");
		return $this->db->affected_rows() > 0;
	}

	function update_shipping_invoice($shipping_invoice_id, $shipping_company, $supplier_name, $supplier_address, $supplier_phone_no, $same_address, $destination_recipient_name, $destination_company_name, $destination_address, $destination_phone_no, $country_of_origin, $total_unit_value, $fba_fees, $total_value_of_shipment, $fosr, $simulator, $status, $active, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `shipping_invoices` SET `shipping_company`='$shipping_company',`supplier_name`='$supplier_name',`supplier_address`='$supplier_address',`supplier_phone_no`='$supplier_phone_no', `same_address`='$same_address',`destination_recipient_name`='$destination_recipient_name',`destination_company_name`='$destination_company_name',`destination_address`='$destination_address',`destination_phone_no`='$destination_phone_no',`country_of_origin`='$country_of_origin',`total_unit_value`='$total_unit_value',`fba_fees`='$fba_fees',`total_value_of_shipment`='$total_value_of_shipment',`fosr`='$fosr',`simulator`='$simulator',`status`='$status',`active`='$active',`updated_by`='$updated_by',`updated_at`='$updated_at'
							WHERE `id` = $shipping_invoice_id");
		return $this->db->affected_rows() > 0;
	}

	function update_shipping_invoice_blank_file($shipping_invoice_id, $shipping_company, $supplier_name, $supplier_address, $supplier_phone_no, $same_address, $destination_recipient_name, $destination_company_name, $destination_address, $destination_phone_no, $country_of_origin, $total_unit_value, $fba_fees, $total_value_of_shipment, $status, $active, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `shipping_invoices` SET `shipping_company`='$shipping_company',`supplier_name`='$supplier_name',`supplier_address`='$supplier_address',`supplier_phone_no`='$supplier_phone_no', `same_address`='$same_address',`destination_recipient_name`='$destination_recipient_name',`destination_company_name`='$destination_company_name',`destination_address`='$destination_address',`destination_phone_no`='$destination_phone_no',`country_of_origin`='$country_of_origin',`total_unit_value`='$total_unit_value',`fba_fees`='$fba_fees',`total_value_of_shipment`='$total_value_of_shipment',`status`='$status',`active`='$active',`updated_by`='$updated_by',`updated_at`='$updated_at'
							WHERE `id` = $shipping_invoice_id");
		return $this->db->affected_rows() > 0;
	}

	function update_shipping_invoice_date($shipping_invoice_id, $invoice_date, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `shipping_invoices` SET `invoice_date`='$invoice_date',`updated_by`='$updated_by',`updated_at`='$updated_at'
							WHERE `id` = $shipping_invoice_id");
		return $this->db->affected_rows() > 0;
	}

	function update_shipping_invoice_products($shipping_invoice_product_id, $shipping_invoice_id, $product_registration_id, $asin, $online_selling_price, $fba_listing_fee, $fba_shipping_fee, $quantity, $unit_value, $unit_value_total_amount, $total_amount, $active, $updated_at)
	{
		
		$online_selling_price = str_replace(',', '', $online_selling_price);

		$this->db->query("UPDATE `shipping_invoice_products` SET `product_registration_id`='$product_registration_id',`asin`='$asin',`online_selling_price`='$online_selling_price',`fba_listing_fee`='$fba_listing_fee',`fba_shipping_fee`='$fba_shipping_fee',`quantity`='$quantity',`unit_value`='$unit_value',`unit_value_total_amount`='$unit_value_total_amount',`total_amount`='$total_amount',`active`='$active',`updated_at`='$updated_at'
							WHERE `active` = 1 AND `shipping_invoice_id` = $shipping_invoice_id AND `id` = $shipping_invoice_product_id");
		return $this->db->affected_rows() > 0;
	}

	function update_shipping_invoice_products_to_inactive($shipping_invoice_id, $updated_at)
	{
		$this->db->query("UPDATE `shipping_invoice_products` SET `active`=0,`updated_at`='$updated_at' WHERE `active` = 1 AND `shipping_invoice_id` = $shipping_invoice_id");
		return $this->db->affected_rows() > 0;
	}

	function pending_shipping_invoice($shipping_invoice_id, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `shipping_invoices` SET `status`=4,`updated_by`='$updated_by',`updated_at`='$updated_at'
							WHERE `id` = $shipping_invoice_id");
		return $this->db->affected_rows() > 0;
	}

	function inactive_shipping_invoice_products($shipping_invoice_product_id, $shipping_invoice_id, $active, $updated_at)
	{
		$this->db->query("UPDATE `shipping_invoice_products` SET `active`='$active',`updated_at`='$updated_at'
							WHERE `active` = 1 AND `shipping_invoice_id` = $shipping_invoice_id AND `id` = $shipping_invoice_product_id");
		return $this->db->affected_rows() > 0;
	}

	function cancel_shipping_invoice($shipping_invoice_id, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `shipping_invoices` SET `active` = 0, `updated_by` = '$updated_by', `updated_at` = '$updated_at' WHERE `id` = $shipping_invoice_id");
		return $this->db->affected_rows() > 0;
	}

	function shipping_invoice_paid($shipping_invoice_id, $date_today)
	{
		$this->db->query("UPDATE `shipping_invoices` SET `paid` = 1, `invoice_date` = '$date_today' WHERE `active` = 1 AND `id` = $shipping_invoice_id");
		return $this->db->affected_rows() > 0;
	}

	function fetch_user_by_shipping_id($shipping_invoice_id)
	{
		$query = $this->db->query("SELECT * FROM `shipping_invoices` AS t1
									LEFT JOIN `users` AS t2 ON t1.`user_id` = t2.`id`
									WHERE t1.`id` = $shipping_invoice_id");
		return $query;
	}

	function fetch_latest_revision_message($id)
	{
		$query = $this->db->query("SELECT * FROM `messages` WHERE `type` = 'Revisions' AND `s_id` = $id");
		return $query->last_row();
	}

	function fetch_latest_invoice_no_big()
	{
		$query = $this->db->query("SELECT `invoice_no_big` FROM `shipping_invoices` ORDER BY `invoice_no_big` DESC LIMIT 1");
		return $query;
	}

	function fetch_latest_invoice_no_tiny($invoice_no_big)
	{
		$query = $this->db->query("SELECT `invoice_no_tiny` FROM `shipping_invoices` WHERE `invoice_no_big` = '$invoice_no_big' ORDER BY `invoice_no_tiny` DESC LIMIT 1");
		return $query;
	}

	function insert_invoice_no($shipping_invoice_id, $invoice_no_big, $invoice_no_tiny)
	{
		$this->db->query("UPDATE `shipping_invoices` SET `invoice_no_big` = '$invoice_no_big', `invoice_no_tiny` = '$invoice_no_tiny' WHERE `active` = 1 AND `id` = $shipping_invoice_id");
		return $this->db->affected_rows() > 0;
	}

	function insert_product_registration_for_bulk_upload($user_id, $regulated_application_id, $product_category_id, $sku, $product_name, $product_img, $created_by, $created_at)
	{
		$this->db->query("INSERT INTO `product_registrations`(`user_id`, `regulated_application_id`, `product_category_id`, `sku`, `product_name`, `product_img`, `status`, `created_by`, `created_at`) 
	 						VALUES ('$user_id','$regulated_application_id','$product_category_id','$sku','$product_name','$product_img', 4, '$created_by', '$created_at')");
		return $this->db->insert_id();
	}

	function fetch_product_label_details($id)
	{
		$query = $this->db->query("SELECT * FROM `product_labels` WHERE `id` = '$id'");
		return $query;
	}

	function fetch_product_offer_by_service_id($id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'product_offer_id' FROM `products_offer` AS t1
									LEFT JOIN `product_categories` AS t2 ON t1.`product_category_id` = t2.`id`
									LEFT JOIN `product_services` AS t3 ON t2.`product_service_id` = t3.`id`
									WHERE t2.`product_service_id` = $id AND t1.`active` = 1");
		return $query;
	}

	function fetch_billing_invoices_limited($user_id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'user_payment_invoice_id', t1.`created_at` AS 'invoice_date', t5.`company_name` AS 'user_company_name', t1.`status` AS 'payment_status', t1.`pli` AS 'pli_sub' , t5.`user_role_id`
                                    FROM `users_payment_invoice` AS t1
                                    LEFT JOIN `products_offer` AS t2 ON t1.`product_offer_id` = t2.`id`
                                    LEFT JOIN `product_categories` AS t3 ON t2.`product_category_id` = t3.`id`
                                    LEFT JOIN `product_services` AS t4 ON t3.`product_service_id` = t4.`id`
                                    LEFT JOIN `users` AS t5 ON t1.`user_id` = t5.`id`
                                    WHERE t1.`user_id` = $user_id AND t1.`active` = 1 
									ORDER BY t1.`id` DESC LIMIT 7");
		return $query;
	}
	function fetch_product_pricing_fee($id)
	{
		$query = $this->db->query("SELECT * FROM `product_pricing_fee` WHERE `id` = '$id'");
		return $query;
	}
	function fetch_billing_invoices($user_id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'user_payment_invoice_id', t1.`created_at` AS 'invoice_date', t5.`company_name` AS 'user_company_name', t1.`status` AS 'payment_status', t1.`pli` AS 'pli_sub' , t5.`user_role_id`
                                    FROM `users_payment_invoice` AS t1
                                    LEFT JOIN `products_offer` AS t2 ON t1.`product_offer_id` = t2.`id`
                                    LEFT JOIN `product_categories` AS t3 ON t2.`product_category_id` = t3.`id`
                                    LEFT JOIN `product_services` AS t4 ON t3.`product_service_id` = t4.`id`
                                    LEFT JOIN `users` AS t5 ON t1.`user_id` = t5.`id`
                                    WHERE t1.`user_id` = $user_id AND t1.`active` = 1 
									ORDER BY t1.`id` DESC");
		return $query;
	}

	function fetch_billing_invoice($id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'user_payment_invoice_id', t1.`created_at` AS 'invoice_date', t5.`company_name` AS 'user_company_name', t1.`status` AS 'payment_status', t1.`pli` AS 'pli_sub' , t5.`user_role_id`
                                    FROM `users_payment_invoice` AS t1
                                    LEFT JOIN `products_offer` AS t2 ON t1.`product_offer_id` = t2.`id`
									LEFT JOIN `product_categories` AS t3 ON t2.`product_category_id` = t3.`id`
                                    LEFT JOIN `product_services` AS t4 ON t3.`product_service_id` = t4.`id`
                                    LEFT JOIN `users` AS t5 ON t1.`user_id` = t5.`id`
                                    WHERE t1.`id` = $id AND t1.`active` = 1 ORDER BY t1.`id` ASC");
		return $query;
	}

	function fetch_billing_invoice_product_label($id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'user_payment_invoice_id', t1.`created_at` AS 'invoice_date', t5.`company_name` AS 'user_company_name', t1.`status` AS 'payment_status', t1.`pli` AS 'pli_sub'
                                    FROM `users_payment_invoice` AS t1
                                    LEFT JOIN `products_offer` AS t2 ON t1.`product_offer_id` = t2.`id`
									LEFT JOIN `product_categories` AS t3 ON t1.`product_category_id` = t3.`id`
                                    LEFT JOIN `product_services` AS t4 ON t3.`product_service_id` = t4.`id`
                                    LEFT JOIN `users` AS t5 ON t1.`user_id` = t5.`id`
                                    WHERE t1.`id` = $id AND t1.`active` = 1 ORDER BY t1.`id` ASC");
		return $query;
	}

	function fetch_billing_invoices_unpaid($user_id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'user_payment_invoice_id', t1.`created_at` AS 'invoice_date', t5.`company_name` AS 'user_company_name', t1.`status` AS 'payment_status', t1.`pli` AS 'pli_sub'
                                    FROM `users_payment_invoice` AS t1
                                    LEFT JOIN `products_offer` AS t2 ON t1.`product_offer_id` = t2.`id`
                                    LEFT JOIN `product_categories` AS t3 ON t2.`product_category_id` = t3.`id`
                                    LEFT JOIN `product_services` AS t4 ON t3.`product_service_id` = t4.`id`
                                    LEFT JOIN `users` AS t5 ON t1.`user_id` = t5.`id`
                                    WHERE t1.`user_id` = $user_id AND t1.`active` = 1 AND t1.`status` = 0 ORDER BY t1.`id` ASC");
		return $query->num_rows();
	}

	function insert_user_payment_invoice($user_id, $product_category_id, $register_ior, $pli, $product_offer_id, $plt, $subtotal, $jct, $total, $created_by, $created_at, $amazon_account_id)
	{
		$this->db->query("INSERT INTO `users_payment_invoice`(`user_id`, `product_category_id`,`amazon_account_id`, `register_ior`, `pli`, `product_offer_id`, `product_lab_testing_total`, `status`, `subtotal`, `jct`, `total`, `created_by`, `created_at`) 
							VALUES ('$user_id', '$product_category_id','$amazon_account_id', '$register_ior','$pli','$product_offer_id','$plt',0,'$subtotal','$jct','$total','$created_by','$created_at')");
		return $this->db->insert_id();
	}

	function insert_user_payment_shipping_invoice($user_id, $shipping_id, $fee_id, $ior_fee, $total, $jct, $created_by, $created_at)
	{
		$this->db->query("INSERT INTO `users_payment_invoice`(`user_id`, `shipping_invoice_id`,`pricing_fee_id`, `subtotal` , `status`, `jct`, `total`, `created_by`, `created_at`) 
							VALUES ('$user_id', '$shipping_id','$fee_id','$ior_fee',0,'$jct','$total','$created_by','$created_at')");


		return $this->db->insert_id();
	}

	function insert_user_payment_invoice_product_label($user_id, $product_category_id, $register_ior, $pli, $product_offer_id, $plt, $subtotal, $jct, $total, $created_by, $created_at, $amazon_account_id, $regulated_label_id)
	{
		$this->db->query("INSERT INTO `users_payment_invoice`(`user_id`, `product_category_id`, `regulated_label_id`,`amazon_account_id`, `register_ior`, `pli`, `product_offer_id`, `product_lab_testing_total`, `status`, `subtotal`, `jct`, `total`, `created_by`, `created_at`) 
							VALUES ('$user_id', '$product_category_id', '$regulated_label_id','$amazon_account_id', '$register_ior','$pli','$product_offer_id','$plt',0,'$subtotal','$jct','$total','$created_by','$created_at')");
		return $this->db->insert_id();
	}

	function update_shipping_invoice_billing_id($user_id, $shipping_id, $billing_invoice_id)
	{
		$this->db->query("UPDATE shipping_invoices SET billing_invoice_id='$billing_invoice_id'  where user_id='$user_id' and id='$shipping_id'");
	}

	function fetch_user_payment_invoice($id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'user_payment_invoice_id', t1.`created_at` AS 'invoice_date', t5.`company_name` AS 'user_company_name', t1.`status` AS 'paid_sub', t1.`pli` AS 'pli_sub'
                                    FROM `users_payment_invoice` AS t1
                                    LEFT JOIN `products_offer` AS t2 ON t1.`product_offer_id` = t2.`id`
                                    LEFT JOIN `product_categories` AS t3 ON t2.`product_category_id` = t3.`id`
                                    LEFT JOIN `product_services` AS t4 ON t3.`product_service_id` = t4.`id`
                                    LEFT JOIN `users` AS t5 ON t1.`user_id` = t5.`id`
                                    WHERE t1.`id` = $id ORDER BY t1.`id` ASC");
		return $query;
	}

	function fetch_user_payment_invoice_product_label($id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'user_payment_invoice_id', t1.`created_at` AS 'invoice_date', t5.`company_name` AS 'user_company_name', t1.`status` AS 'paid_sub', t1.`pli` AS 'pli_sub', t3.`id` AS 'cat_id'
                                    FROM `users_payment_invoice` AS t1
                                    LEFT JOIN `products_offer` AS t2 ON t1.`product_offer_id` = t2.`id`
                                    LEFT JOIN `product_categories` AS t3 ON t1.`product_category_id` = t3.`id`
                                    LEFT JOIN `product_services` AS t4 ON t3.`product_service_id` = t4.`id`
                                    LEFT JOIN `users` AS t5 ON t1.`user_id` = t5.`id`
                                    WHERE t1.`id` = $id ORDER BY t1.`id` ASC");
		return $query;
	}

	function fetch_approved_regulated_products($regulated_application_id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'product_registration_id', t3.`id` AS 'product_registration_status_id' 
                    FROM `product_registrations` AS t1
                    LEFT JOIN `regulated_products_a` AS t2 ON t1.`id` = t2.`product_registration_id`
                    LEFT JOIN `product_registration_status` AS t3 ON t1.`status` = t3.`id`
                    WHERE t1.`regulated_application_id` = $regulated_application_id AND t1.`active` = 1 AND t1.`status` = 1
                    ORDER BY t1.`id` DESC");
		return $query;
	}

	function check_manufacturer_details_count($id)
	{
		$query = $this->db->query("SELECT * FROM `regulated_manufacturer_details_a` WHERE `regulated_application_id` = $id");
		return $query->num_rows();
	}

	function check_regulated_products_count($id)
	{
		$query = $this->db->query("SELECT * FROM `product_registrations` WHERE `regulated_application_id` = $id");
		return $query->num_rows();
	}

	function submit_pre_import($id, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `regulated_application_tracking` SET `approve_status` = 6, `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `regulated_application_id` = $id AND `tracking_status` = 1");
		return $this->db->affected_rows() > 0;
	}

	function cancel_reg_application($id, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `regulated_applications` SET `active` = 0, `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function delete_regulated_product($id, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `product_registrations` SET `active` = 0, `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function delete_billing_invoice($id, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `users_payment_invoice` set `active` = 0,`updated_by`='$updated_by',`updated_at`='$updated_at' WHERE `id` = '$id'");
		return $this->db->affected_rows() > 0;
	}

	function update_billing_invoice_to_paid($id)
	{
		$this->db->query("UPDATE `users_payment_invoice` SET `status` = 1 WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function fetch_shipping_companies_v($partner_id)
	{
		$query = $this->db->query("SELECT * FROM `shipping_companies` where id='$partner_id'");
		return $query;
	}

	function fetch_paid_regulated_limited($user_id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'user_payment_invoice_id', t1.`created_at` AS 'invoice_date', t4.`company_name` AS 'user_company_name', t1.`status` AS 'payment_status', t5.`id` AS 'regulated_application_id', t5.`active` AS 'reg_application_active'
                                    FROM `users_payment_invoice` AS t1
                                    LEFT JOIN `product_categories` AS t2 ON t1.`product_category_id` = t2.`id`
                                    LEFT JOIN `product_services` AS t3 ON t2.`product_service_id` = t3.`id`
                                    LEFT JOIN `users` AS t4 ON t1.`user_id` = t4.`id`
									LEFT JOIN `regulated_applications` AS t5 ON t1.`id` = t5.`user_payment_invoice_id`
									LEFT JOIN `regulated_application_tracking` AS t6 ON t5.`tracking_status` = t6.`tracking_status`
                                    AND t6.`regulated_application_id` = t5.`id`
                                    WHERE t1.`user_id` = $user_id AND t1.`active` = 1 AND t1.`status` = 1 AND t3.`id` = 1 
									ORDER BY t1.`id` DESC LIMIT 1");
		return $query;
	}

	function fetch_paid_regulated($user_id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'user_payment_invoice_id', t1.`created_at` AS 'invoice_date', t4.`company_name` AS 'user_company_name', t1.`status` AS 'payment_status', t5.`id` AS 'regulated_application_id', t5.`active` AS 'reg_application_active'
                                    FROM `users_payment_invoice` AS t1
                                    LEFT JOIN `product_categories` AS t2 ON t1.`product_category_id` = t2.`id`
                                    LEFT JOIN `product_services` AS t3 ON t2.`product_service_id` = t3.`id`
                                    LEFT JOIN `users` AS t4 ON t1.`user_id` = t4.`id`
									LEFT JOIN `regulated_applications` AS t5 ON t1.`id` = t5.`user_payment_invoice_id`
									LEFT JOIN `regulated_application_tracking` AS t6 ON t5.`tracking_status` = t6.`tracking_status`
                                    AND t6.`regulated_application_id` = t5.`id`
                                    WHERE t1.`user_id` = $user_id AND t1.`active` = 1 AND t1.`status` = 1 AND t3.`id` = 1 AND regulated_label_id = 0
									ORDER BY t1.`id` DESC");
		return $query;
	}

	function insert_new_reg_application($user_payment_invoice_id, $product_category_id, $created_by, $created_at)
	{
		$this->db->query("INSERT INTO `regulated_applications`(`user_payment_invoice_id`, `product_category_id`, `tracking_status`, `created_by`, `created_at`) 
							VALUES ('$user_payment_invoice_id', '$product_category_id', 1, '$created_by', '$created_at')");
		return $this->db->insert_id();
	}

	function fetch_reg_application_count($user_payment_invoice_id)
	{
		$query = $this->db->query("SELECT * FROM `regulated_applications` WHERE `user_payment_invoice_id` = $user_payment_invoice_id");
		return $query->num_rows();
	}


	function check_regulated_label_payment($regulated_application_id)
	{
		$query = $this->db->query("SELECT * FROM `users_payment_invoice` WHERE `regulated_label_id` = $regulated_application_id");
		return $query->num_rows();
	}

	function fetch_reg_application($regulated_application_id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'regulated_application_id', t1.`tracking_status` AS 'track' FROM `regulated_applications` AS t1
									LEFT JOIN `users_payment_invoice` AS t2 ON t1.`user_payment_invoice_id` = t2.`id`
									LEFT JOIN `product_categories` AS t3 ON t2.`product_category_id` = t3.`id`
                                    LEFT JOIN `product_services` AS t4 ON t3.`product_service_id` = t4.`id`
									LEFT JOIN `regulated_status_a` AS t5 ON t1.`tracking_status` = t5.`id`
									WHERE t1.`id` = $regulated_application_id");
		return $query;
	}

	function fetch_reg_product_by_id($regulated_product_id)
	{
		$query = $this->db->query("SELECT * FROM `product_registrations` AS t1
									LEFT JOIN `regulated_products_a` AS t2 ON t1.`id` = t2.`product_registration_id`
									WHERE t1.`id` = $regulated_product_id");
		return $query;
	}

	function fetch_reg_product_cust_by_id($regulated_product_id)
    {
        $query = $this->db->query("SELECT * FROM `regulated_product_custom_details` AS t1
                                    WHERE t1.`regulated_product_id` = $regulated_product_id");
        return $query;
    }
    
    function update_regulated_product_one_cust($reg_prod_cut_id,$detail_value)
    {
        $this->db->query(" UPDATE regulated_product_custom_details 
                       SET 
                     `detail_value`           =  '" . $detail_value . "'
                     
                        WHERE `id` = '" . $reg_prod_cut_id . "' ");

        return $this->db->affected_rows();
    }

	function insert_reg_application_tracking($regulated_application_id, $date, $tracking_status, $approve_status, $created_by, $created_at)
	{
		$this->db->query("INSERT INTO `regulated_application_tracking`(`regulated_application_id`, `date`, `tracking_status`, `approve_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
							VALUES ('$regulated_application_id', '$date', '$tracking_status', '$approve_status', '$created_by', '$created_by', '$created_at', '$created_at')");
		return $this->db->affected_rows() > 0;
	}

	function fetch_tracking_steps_a($regulated_application_id)
	{
		///$query = $this->db->query("SELECT * FROM `regulated_status_a` AS t1 WHERE `show` = 1 ORDER BY `id` ASC");

		$query =  $this->db->query("SELECT t1.`id`, t1.`tracking_status_name`, t2.`tracking_status`, t2.`regulated_application_id`,  t2.`tracking_steps`
		FROM regulated_status_a as t1 
		LEFT JOIN regulated_application_tracking as t2 
		ON t1.`id` = t2.`tracking_status`
		AND t2.`regulated_application_id` = $regulated_application_id
		OR t2.`tracking_status` IS NULL
		LEFT JOIN regulated_tracking_status as t3 ON t2.`approve_status` = t3.`id` WHERE `show` = 1
		ORDER BY t2.updated_at IS NULL, t2.updated_at");

		return $query;
	}

	function fetch_tracking_steps_b()
	{
		$query = $this->db->query("SELECT * FROM `regulated_status_b` AS t1 WHERE `show` = 1 ORDER BY `id` ASC");
		return $query;
	}
	function fetch_tracking_latest_a($regulated_application_id)
	{
		$query = $this->db->query("SELECT *, t1.`regulated_application_id`, t1.`id` AS 'regulated_application_tracking_id'  ,  t1.`tracking_steps`
									FROM `regulated_application_tracking` AS t1
									LEFT JOIN `regulated_status_a` AS t2 ON t1.`tracking_status` = t2.`id`
									LEFT JOIN `regulated_tracking_status` AS t3 ON t1.`approve_status` = t3.`id`
									WHERE t1.`regulated_application_id` = $regulated_application_id ORDER BY t2.`id` DESC LIMIT 1");
		return $query;
	}

	function fetch_tracking_latest_b($regulated_application_id)
	{
		$query = $this->db->query("SELECT *, t1.`regulated_application_id`, t1.`id` AS 'regulated_application_tracking_id' 
									FROM `regulated_application_tracking` AS t1
									LEFT JOIN `regulated_status_b` AS t2 ON t1.`tracking_status` = t2.`id`
									LEFT JOIN `regulated_tracking_status` AS t3 ON t1.`approve_status` = t3.`id`
									WHERE t1.`regulated_application_id` = $regulated_application_id ORDER BY t2.`id` DESC LIMIT 1");
		return $query;
	}

	function fetch_reg_application_tracking_a($regulated_application_id)
	{
		$query = $this->db->query("SELECT *, t1.`regulated_application_id`, t1.`tracking_status` AS 'tracking_status_id', t1.`id` AS 'regulated_application_tracking_id'
									FROM `regulated_application_tracking` AS t1
									LEFT JOIN `regulated_status_a` AS t2 ON t1.`tracking_status` = t2.`id`
									LEFT JOIN `regulated_tracking_status` AS t3 ON t1.`approve_status` = t3.`id`
									LEFT JOIN `regulated_applications` AS t4 ON t1.`regulated_application_id` = t4.`id`
									WHERE t1.`regulated_application_id` = $regulated_application_id ORDER BY t1.`updated_at` DESC");
		return $query;
	}

	function fetch_reg_application_tracking_b($regulated_application_id)
	{
		$query = $this->db->query("SELECT *, t1.`regulated_application_id`, t1.`tracking_status` AS 'tracking_status_id', t1.`id` AS 'regulated_application_tracking_id'
									FROM `regulated_application_tracking` AS t1
									LEFT JOIN `regulated_status_b` AS t2 ON t1.`tracking_status` = t2.`id`
									LEFT JOIN `regulated_tracking_status` AS t3 ON t1.`approve_status` = t3.`id`
									LEFT JOIN `regulated_applications` AS t4 ON t1.`regulated_application_id` = t4.`id`
									WHERE t1.`regulated_application_id` = $regulated_application_id ORDER BY t2.`id` DESC");
		return $query;
	}

	function fetch_regulated_remarks_status($user)
	{
		$query = $this->db->query("SELECT t3.`remarks_status` , t1.`id` FROM `regulated_applications` AS t1
									LEFT JOIN `users_payment_invoice` AS t2 ON t1.`user_payment_invoice_id` = t2.`id`
									LEFT JOIN `regulated_application_tracking` AS t3 ON t1.`id` = t3.`regulated_application_id`
									WHERE t2.`user_id` = $user and t3.`remarks_status` !='' and t3.`is_viewed` != 1 ");
		return $query;
	}

	function update_reg_application_tracking_notification($regulated_application_id)
	{
		$query = $this->db->query("UPDATE regulated_application_tracking set is_viewed=1 where regulated_application_id='$regulated_application_id' and remarks_status!=''");
		return $query;
	}

	function fetch_manufacturer_details($regulated_application_id)
	{
		$query = $this->db->query("SELECT * FROM `regulated_manufacturer_details_a` WHERE `regulated_application_id` = $regulated_application_id");
		return $query;
	}

	function insert_manufacturer_details($regulated_application_id, $manufacturer_flow_process, $manufacturer_name, $manufacturer_address, $manufacturer_city, $manufacturer_country, $manufacturer_zipcode, $manufacturer_contact, $manufacturer_website, $created_by, $created_at)
	{
		$this->db->query("INSERT INTO `regulated_manufacturer_details_a`(`regulated_application_id`, `manufacturer_flow_process`, `manufacturer_name`, `manufacturer_address`, `manufacturer_city`, `manufacturer_country`, `manufacturer_zipcode`, `manufacturer_contact`, `manufacturer_website`, `created_by`, `created_at`) 
							VALUES ('$regulated_application_id', '$manufacturer_flow_process', '$manufacturer_name', '$manufacturer_address', '$manufacturer_city', '$manufacturer_country', '$manufacturer_zipcode', '$manufacturer_contact', '$manufacturer_website', '$created_by', '$created_at')");
		return $this->db->affected_rows() > 0;
	}


	function update_manufacturer_details($regulated_application_id, $manufacturer_flow_process, $manufacturer_name, $manufacturer_address, $manufacturer_city, $manufacturer_country, $manufacturer_zipcode, $manufacturer_contact, $manufacturer_website, $created_by, $created_at)
	{
		$this->db->query(" UPDATE regulated_manufacturer_details_a 
					   SET 
					 `manufacturer_name`      	 = Coalesce('$manufacturer_name',regulated_manufacturer_details_a.manufacturer_name) , 
					 `manufacturer_address`   	 = Coalesce('$manufacturer_address',regulated_manufacturer_details_a.manufacturer_address) ,
					 `manufacturer_city`   	  	 = Coalesce('$manufacturer_city',regulated_manufacturer_details_a.manufacturer_city) ,
					 `manufacturer_country`   	 = Coalesce('$manufacturer_country',regulated_manufacturer_details_a.manufacturer_country) ,
					 `manufacturer_zipcode`   	 = Coalesce('$manufacturer_zipcode',regulated_manufacturer_details_a.manufacturer_zipcode) ,
					 `manufacturer_contact`   	 = Coalesce('$manufacturer_contact',regulated_manufacturer_details_a.manufacturer_contact) ,
					 `manufacturer_website`   	 = Coalesce('$manufacturer_website',regulated_manufacturer_details_a.manufacturer_website) ,
					 `manufacturer_flow_process` = IF('$manufacturer_flow_process' = '' OR '$manufacturer_flow_process' IS NULL,regulated_manufacturer_details_a.manufacturer_flow_process,'$manufacturer_flow_process') 
					 
					    WHERE `regulated_application_id` = '" . $regulated_application_id . "' ");

		return $this->db->affected_rows();
	}

	function insert_regulated_product($user_id, $regulated_application_id, $product_category_id, $sku, $product_name, $product_img, $created_by, $created_at)
	{
		$this->db->query("INSERT INTO `product_registrations`(`user_id`, `regulated_application_id`, `product_category_id`, `sku`, `product_name`, `product_img`, `product_label`, `status`, `created_by`, `created_at`) 
	 						VALUES ('$user_id','$regulated_application_id','$product_category_id','$sku','$product_name','$product_img', '', '4', '$created_by', '$created_at')");
		return $this->db->insert_id();
	}

	function insert_regulated_product_a($product_registration_id, $ingredients_formula, $product_use_and_info, $outerbox_frontside, $outerbox_backside, $volume_weight, $consumer_product_packaging_img, $approx_size_of_package)
	{
		$this->db->query("INSERT INTO `regulated_products_a`(`product_registration_id`, `ingredients_formula`, `product_use_and_info`, `outerbox_frontside`, `outerbox_backside`, `volume_weight`, `consumer_product_packaging_img`, `approx_size_of_package`) 
							VALUES ('$product_registration_id', '$ingredients_formula', '$product_use_and_info', '$outerbox_frontside', '$outerbox_backside', '$volume_weight', '$consumer_product_packaging_img', '$approx_size_of_package')");
		return $this->db->affected_rows() > 0;
	}

	function fetch_regulated_products($regulated_application_id)
	{
		$query = $this->db->query("SELECT *,t1.`id` as `rpi`,t2.`id` as `rai` FROM `product_registrations` AS t1
					LEFT JOIN `regulated_products_a` AS t2 ON t1.`id` = t2.`product_registration_id`
					LEFT JOIN `product_registration_status` AS t3 ON t1.`status` = t3.`id`
					WHERE t1.`regulated_application_id` = $regulated_application_id AND t1.`active` = 1
					");

		return $query;
		// , count(t4.`detail_name`) as det_count
		// LEFT JOIN `regulated_product_custom_details` AS t4 ON t2.`id` = t4.`regulated_product_id`
		// GROUP BY t2.`id`
	}

	function fetch_labtest($regulated_application_id)
	{
		$query = $this->db->query("SELECT *, t1.`created_at` AS 'created_at_test' FROM `lab_test_results` AS t1
									LEFT JOIN `regulated_applications` AS t2 ON t1.`regulated_application_id` = t2.`id`
									LEFT JOIN `product_categories` AS t3 ON t2.`product_category_id` = t3.`id`
									LEFT JOIN `users_payment_invoice` AS t4 ON t2.`user_payment_invoice_id` = t4.`id`
									LEFT JOIN `users` AS t5 ON t4.`user_id` = t5.`id`
									WHERE t1.`regulated_application_id` = $regulated_application_id");
		return $query;
	}

	function reg_products_revisions_count($regulated_application_id)
	{
		$query = $this->db->query("SELECT * FROM `product_registrations` WHERE `regulated_application_id` = $regulated_application_id AND `status` = 3 AND `active` = 1");
		return $query->num_rows();
	}

	function reg_products_declined_count($regulated_application_id)
	{
		$query = $this->db->query("SELECT * FROM `product_registrations` WHERE `regulated_application_id` = $regulated_application_id AND `status` = 2 AND `active` = 1");
		return $query->num_rows();
	}

	// AMAZON Account
	function insert_amazon_account($user_id, $created_at)
	{
		$this->db->query("INSERT INTO `amazon_account`(`user_id`,`active`,`created_by`) 
							VALUES ('$user_id',1,'$user_id')");
		return $this->db->insert_id();
	}

	function insert_amazon_account_store_info($user_id, $store_display_name, $is_product_barcode, $is_manufacturer_brand_owner, $owned_gov_reg_trademark, $created_at)
	{
		$this->db->query("INSERT INTO `amazon_account_store_info`(`store_display_name`,`is_product_barcode`,`is_product_barcode`,`is_manufacturer_brand_owner`,`owned_gov_reg_trademark`,`created_by`) 
							VALUES ('$store_display_name','$is_product_barcode','$is_manufacturer_brand_owner','$owned_gov_reg_trademark','$user_id')");
		return $this->db->affected_rows() > 0;
	}

	function insert_amazon_account_pcp($user_id, $contact_person, $middle_name, $last_name, $citizenship_country, $birth_country, $birth_date, $passport_number, $passport_expirydate, $passport_country_issued, $is_beneficial_owner, $is_legal_representative, $is_nonlegal_representative, $created_at)
	{
		$this->db->query("INSERT INTO `amazon_account_pcp`(`contact_person`,`middle_name`,`last_name`,`citizenship_country`,`birth_country`,`birth_date`,`passport_number`,`passport_expirydate`,`passport_country_issued`,`is_beneficial_owner`,`is_legal_representative`,`is_nonlegal_representative`,`created_by`) 
							VALUES ('$contact_person','$middle_name','$last_name','$citizenship_country','$birth_country','$birth_date','$passport_number','$passport_expirydate','$passport_country_issued','$is_beneficial_owner','$is_legal_representative','$is_nonlegal_representative','$user_id')");
		return $this->db->affected_rows() > 0;
	}

	function insert_amazon_account_credit_card_details($user_id, $holder_name, $card_num, $card_expiry, $card_type, $billing_address, $contact_person, $address_1, $address_2, $city_town, $country, $province_region_state, $postal_zip_code, $created_at)
	{
		$this->db->query("INSERT INTO `amazon_account_credit_card_details`(`holder_name`,`card_num`,`card_expiry`,`card_type`,`billing_address`,`contact_person`,`address_1`,`address_2`,`city_town`,`country`,`province_region_state`,`postal_zip_code`,`created_by`) 
							VALUES ('$holder_name','$card_num','$card_expiry','$card_type','$billing_address','$contact_person','$address_1','$address_2','$city_town','$country','$province_region_state','$postal_zip_code','$user_id')");
		return $this->db->affected_rows() > 0;
	}

	function insert_amazon_account_business_info($user_id, $business_location, $business_type, $business_register_num, $acknowledgment, $business_address, $created_at)
	{
		$this->db->query("INSERT INTO `amazon_account_bank_deposit_info`(`business_location`,`business_type`,`business_register_num`,`acknowledgment`,`business_address`,`created_by`) 
							VALUES ('$business_location','$business_type','$business_register_num','$acknowledgment','$business_address','$user_id')");
		return $this->db->affected_rows() > 0;
	}

	function insert_amazon_account_bank_deposit_info($user_id, $bank_location_country, $accnt_holder_name, $bank_code, $branch_code, $bank_accnt_num, $bank_accnt_type, $bic, $iban, $created_at)
	{
		$this->db->query("INSERT INTO `amazon_account_business_info`(`bank_location_country`,`accnt_holder_name`,`bank_code`,`branch_code`,`bank_accnt_num`,`bank_accnt_type`,`bic`,`iban`,`created_by`) 
							VALUES ('$bank_location_country','$accnt_holder_name','$bank_code','$branch_code','$bank_accnt_num','$bank_accnt_type','$bic','$iban','$user_id')");
		return $this->db->affected_rows() > 0;
	}

	function insert_amazon_account_beneficial_owner($user_id, $title, $contact_person, $middle_name, $last_name, $citizenship_country, $birth_country, $birth_date, $passport_number, $passport_expirydate, $is_benificial_owner, $created_at)
	{
		$this->db->query("INSERT INTO `amazon_account_beneficial_owner`(`title`,`contact_person`,`middle_name`,`last_name`,`citizenship_country`,`birth_country`,`birth_date`,`passport_number`,`passport_expirydate`,`is_benificial_owner`,`created_by`) 
							VALUES ('$title','$contact_person','$middle_name','$last_name','$citizenship_country','$birth_country','$birth_date','$passport_number','$passport_expirydate','$is_benificial_owner','$user_id')");
		return $this->db->affected_rows() > 0;
	}

	function update_regulated_product($product_registration_id, $sku, $product_name, $product_img, $updated_by, $updated_at)
	{
		$this->db->query(" UPDATE product_registrations SET 
							`sku`       	 = Coalesce('$sku',product_registrations.sku), 
							`product_name`   = Coalesce('$product_name',product_registrations.product_name),
							`product_img`    = IF('$product_img' = '' OR '$product_img' IS NULL,product_registrations.product_img,'$product_img'),
							`status`		 = 5,
							`updated_by`     = Coalesce('$updated_by',product_registrations.updated_by),
							`updated_at`     = Coalesce('$updated_at',product_registrations.updated_at)
							WHERE `id` = '" . $product_registration_id . "'");

		return $this->db->affected_rows();
	}

	function update_regulated_product_a($product_registration_id, $ingredients_formula, $product_use_and_info, $outerbox_frontside, $outerbox_backside, $volume_weight, $consumer_product_packaging_img, $approx_size_of_package)
	{
		$this->db->query(" UPDATE regulated_products_a SET 
							`product_use_and_info`      	= Coalesce('$product_use_and_info',regulated_products_a.product_use_and_info), 
							`volume_weight`   				= Coalesce('$volume_weight',regulated_products_a.volume_weight),
							`approx_size_of_package`   		= Coalesce('$approx_size_of_package',regulated_products_a.approx_size_of_package),
							`ingredients_formula`       	= IF('$ingredients_formula' = '' OR '$ingredients_formula' IS NULL,regulated_products_a.ingredients_formula,'$ingredients_formula'),
							`consumer_product_packaging_img`= IF('$consumer_product_packaging_img' = '' OR '$consumer_product_packaging_img' IS NULL,regulated_products_a.consumer_product_packaging_img,'$consumer_product_packaging_img'),
							`outerbox_frontside`= IF('$outerbox_frontside' = '' OR '$outerbox_frontside' IS NULL,regulated_products_a.outerbox_frontside,'$outerbox_frontside'),
							`outerbox_backside`= IF('$outerbox_backside' = '' OR '$outerbox_backside' IS NULL,regulated_products_a.outerbox_backside,'$outerbox_backside')
							WHERE `product_registration_id` = '" . $product_registration_id . "' ");

		return $this->db->affected_rows();
	}

	function insert_test_result($product_registration_id, $lab_result, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `regulated_products_a` SET `lab_result` = IF('$lab_result' = '' OR '$lab_result' IS NULL, `regulated_products_a`.`lab_result`,'$lab_result') WHERE `product_registration_id` = '" . $product_registration_id . "' ");
		$this->db->query("UPDATE `product_registrations` SET `updated_by` = '$updated_by', `updated_at` = '$updated_at' WHERE `id` = '$product_registration_id' ");
		return $this->db->affected_rows();
	}

	function remove_test_result($product_registration_id, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `regulated_products_a` SET `lab_result` = '' WHERE `product_registration_id` = $product_registration_id");
		$this->db->query("UPDATE `product_registrations` SET `updated_by` = '$updated_by', `updated_at` = '$updated_at' WHERE `id` = '$product_registration_id' ");
		return $this->db->affected_rows();
	}

	function fetch_total_value_by_user($user_id, $categoryid, $year)
	{
		$query = $this->db->query("SELECT * FROM `shipping_invoices` WHERE `user_id` = $user_id and category_type='$categoryid' and YEAR(created_at)  =  '$year' and active =1 and paid=1");
		return $query;
	}

	function check_shipping_invoice_discount($user_id, $categoryid, $year)
	{
		$query = $this->db->query("SELECT * FROM `shipping_invoice_discount` WHERE `user_id` = $user_id and `category_id`='$categoryid' and (`s_year`='$year' OR `e_year`='$year')");
		return $query;
	}

	function insert_shipping_invoice_discount($user_id, $categoryid, $year, $totalval)
	{
		$query = $this->db->query("INSERT INTO  `shipping_invoice_discount` (`user_id`,  `category_id` , `s_year` , `e_year`,`total_shipment_value`) 
									VALUES ('$user_id' ,'$categoryid' , '$year' , '$year' + 1 ,  $totalval) ");
		return $query;
	}

	function get_total_mailing_price($id)
	{
		$query = $this->db->query("SELECT *,t1.`id` as `rpi` FROM `users_payment_invoice` AS t1
					LEFT JOIN `shipping_invoice_products` AS t2 ON t1.`shipping_invoice_id` = t2.`shipping_invoice_id`
					LEFT JOIN `product_registrations` AS t3 ON t2.`product_registration_id` = t3.`id`
					WHERE t1.`id` = $id AND t1.`active` = 1");
		return $query;
	}

	function add_logistic_product_details($data)
	{

		$shipping_session =  $data['shipping_session'];
		$prod_log_id =  $data['prod_log_id'];
		$batch_number =  $data['batch_number'];
		$fda_no =  $data['fda_no'];
		$barcode =  $data['barcode'];
		$pallets =  $data['pallets'];
		$cases =  $data['cases'];
		$units =  $data['units'];
		$pallet_length =  $data['pallet_length'];
		$pallet_width =  $data['pallet_width'];
		$pallet_height =  $data['pallet_height'];
		$gw =  $data['gw'];
		$volume =  $data['volume'];
		$md =  $data['md'];
		$ed =  $data['ed'];
		$work_order =  json_encode($data['work_order']);
		$check = $this->db->query("SELECT * from logistic_product_details where shippping_code = '$shipping_session' and product_id ='$prod_log_id'");
		$cnt = $check->num_rows();

		if($cnt ==0){

			$query = $this->db->query("INSERT INTO logistic_product_details
			(`work_order`,`shippping_code`,`product_id`,`batch_number`,`fda_no`,`barcode`,`pallets`,`cases`,`units`,`pallet_length`,`pallet_width`,`pallet_height`,`gw`,`volume`,`date_of_manufacture`,`expiration_date`)
				VALUES
			('$work_order','$shipping_session','$prod_log_id','$batch_number','$fda_no','$barcode','$pallets','$cases','$units','$pallet_length','$pallet_width','$pallet_height','$gw','$volume','$md','$ed')
			");
		
		} else {

			$query = $this->db->query("UPDATE logistic_product_details SET 
										`work_order` = '$work_order',
										`batch_number` = '$batch_number',
										`fda_no` = '$fda_no',
										`barcode` = '$barcode',
										`pallets` = '$pallets',
										`cases` = '$cases',
										`units` = '$units',
										`pallet_length` = '$pallet_length',
										`pallet_width` = '$pallet_width',
										`pallet_height` = '$pallet_height',
										`gw` = '$gw',
										`volume` = '$volume',
										`date_of_manufacture` = '$md',
										`expiration_date` = '$ed'
										where shippping_code = '$shipping_session' and product_id ='$prod_log_id'");
			
		}

		
	
		return $this->db->affected_rows() > 0;
	}

	function add_port_of_arrival_details($data)
	{

		$shipping_session =  $data['shipping_session'];
		$street_address =  $data['street_address'];
		$address_line_2 =  $data['address_line_2'];
		$city =  $data['city'];
		$state =  $data['state'];
		$postal =  $data['postal'];
		$country_1 =  $data['country_1'];
		$user_id =  $data['user_id'];

		$check = $this->db->query("SELECT * from import_logistics where shippping_code = '$shipping_session'");
		$cnt = $check->num_rows();

		if($cnt ==0){

			$query = $this->db->query("INSERT INTO import_logistics
			(`street_address`,`address_line_2`,`city`,`state`,`postal`,`country_1`,`shippping_code`,`user_id`)
				VALUES
			('$street_address','$address_line_2','$city','$state','$postal','$country_1','$shipping_session','$user_id')
			");
		
		} else {

			$query = $this->db->query("UPDATE import_logistics SET 
										`street_address` = '$street_address',
										`address_line_2` = '$address_line_2',
										`city` = '$city',
										`state` = '$state',
										`postal` = '$postal',
										`country_1` = '$country_1'
										where shippping_code = '$shipping_session'");
			
		}

		
	
		return $this->db->affected_rows() > 0;
	}

	function fetch_product_logistic_details($data){

		$query = $this->db->query("SELECT * FROM `logistic_product_details` WHERE `shippping_code` = '$data'");
		return $query;

	}

	function create_zoho_logistic($street,$address_line_2,$city,$state,$postal,$country_1,$company_name,$id,$link){
        $client_id ='1000.ZCWLXFP9952W2HBEOJHV2OPRI7P9TX';//Enter your Client ID here
        $client_secret = '3e80beb431890c908d29186e069fdaac31e52abe91';//Enter your Client Secret here
        $code = '1000.9589afca7a8be967eab9b7d3f4ff8042.9afbe83bf41911eab0d8d0fcdfff606a';//Enter your Code here
        $base_acc_url = 'https://accounts.zoho.com';
        $service_url = 'https://creator.zoho.com';

        $refresh_token = '1000.c75e998d0adc76bf68573cee147e2e8a.77635c78d0c75cb35fab078b0f2cb1f6';

        $access_token_url = $base_acc_url .  '/oauth/v2/token?refresh_token='.$refresh_token.'&client_id='.$client_id.'&client_secret='.$client_secret .'&grant_type=refresh_token';

        $access_token = $this->generate_access_token($access_token_url);
        // var_dump($access_token);
        $this->create_record($access_token,$street,$address_line_2,$city,$state,$postal,$country_1,$company_name,$id,$link);
    }

    function create_zoho_inventory_system($shipping_invoice_id,$company_name,$id,$shipping_code){
        $client_id ='1000.ZCWLXFP9952W2HBEOJHV2OPRI7P9TX';//Enter your Client ID here
        $client_secret = '3e80beb431890c908d29186e069fdaac31e52abe91';//Enter your Client Secret here
        $code = '1000.9589afca7a8be967eab9b7d3f4ff8042.9afbe83bf41911eab0d8d0fcdfff606a';//Enter your Code here
        $base_acc_url = 'https://accounts.zoho.com';
        $service_url = 'https://creator.zoho.com';

        $refresh_token = '1000.c75e998d0adc76bf68573cee147e2e8a.77635c78d0c75cb35fab078b0f2cb1f6';

        $access_token_url = $base_acc_url .  '/oauth/v2/token?refresh_token='.$refresh_token.'&client_id='.$client_id.'&client_secret='.$client_secret .'&grant_type=refresh_token';

        $access_token = $this->generate_access_token($access_token_url);
       
	
		$shipping_product = $this->fetch_shipping_products($shipping_invoice_id);
		$logistic_product = $shipping_product->result();

		$q_get_product_details= $this->Japan_ior_model->fetch_product_logistic_details($shipping_code);
		$prod_logictics = $q_get_product_details->row();

		foreach($logistic_product as $row){

			$productname = $row->product_name;
			$quantity = $row->quantity;
			
			$this->create_record_inventory_product($access_token,
												   $productname,
												   $quantity,
												   $company_name,
												   $prod_logictics->batch_number,
												   $prod_logictics->fda_no,
												   $prod_logictics->barcode,
											       $id,
												   $prod_logictics->date_of_manufacture,
												   $prod_logictics->expiration_date,
												   $prod_logictics->work_order,
												   $prod_logictics->pallets,
												   $prod_logictics->cases,
												   $prod_logictics->units,
												   $prod_logictics->pallet_length,
												   $prod_logictics->pallet_width,
												   $prod_logictics->pallet_height,
												   $prod_logictics->gw,
												   $prod_logictics->volume
												 );

		}
	
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

    function create_record($access_token,$street,$address_line_2,$city,$state,$postal,$country_1,$company_name,$id,$link){
      $service_url ='https://www.zohoapis.com/crm/v2/Logistics';
      //Authorization: Zoho-oauthtoken access_token
      // $data = array("data" => array("Name" => "Ruben", "Email" => "zoho@aorborc.com"));
      $header = array(
        'Authorization: Zoho-oauthtoken ' . $access_token,
        'Content-Type: application/x-www-form-urlencoded'
      );

         $requestBody = array();
         $recordArray = array();
         $recordObject = array();

      	 $recordObject["Name"] = strval($company_name);
      	 $recordObject["Port_of_Arrival_Street_Address"] = strval($street);
      	 $recordObject["Port_of_Arrival_Address_Line_2"] = strval($address_line_2);
      	 $recordObject["Port_of_Arrival_City"] = strval($city);
      	 $recordObject["Port_of_Arrival_State_Region_Province"] = strval($state);
       	 $recordObject["Port_of_Arrival_Country"] = strval($country_1);
         $recordObject["Port_of_Arrival_Postal_Zip_Code"] = strval($postal);
         $recordObject["Shipping_Invoice"] = strval($link);
         $recordObject["Import_Logistic_ID"] = strval($id);
        
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

	// Create Inventory Productsss

    function create_record_inventory_product($access_token,$product_name,$quantity,$company_name,$batch_number,$fda_no,$barcode, $id, $date_of_manufacture, $expiration_date, $work_order, $pallets, $cases, $units, $pallet_l, $pallet_w, $pallet_h, $gw, $volume){
      $service_url ='https://www.zohoapis.com/crm/v2/Inventory_Products';
      //Authorization: Zoho-oauthtoken access_token
      // $data = array("data" => array("Name" => "Ruben", "Email" => "zoho@aorborc.com"));
      $header = array(
        'Authorization: Zoho-oauthtoken ' . $access_token,
        'Content-Type: application/x-www-form-urlencoded'
      );

     	$requestBody = array();
        $recordArray = array();
        $recordObject = array();
        $recordObject["Product"] = strval($product_name);
        $recordObject["Name"] = strval($company_name);
        $recordObject["Import_Logistic_ID"] = strval($id);
        $recordObject["Quantity"] = strval($quantity);
        $recordObject["FDALicenceNo"]= strval($fda_no);
        $recordObject["Lot_No_BatchNo"]= strval($batch_number);
        $recordObject["date_of_manufacture"]= strval($date_of_manufacture);
        $recordObject["Expiration_date"]= strval($expiration_date);
        $recordObject["Barcode"]= strval($barcode);
        $recordObject["Work_Order"]= [str_replace(array( '[', ']' ), '', $work_order)];
        $recordObject["Pallets"]= strval($pallets);
        $recordObject["Cases"]= strval($cases);
        $recordObject["Units"]= strval($units);
        $recordObject["Pallet_Length_CM"]= strval($pallet_l);
        $recordObject["Pallet_Width_CM"]= strval($pallet_w);
        $recordObject["Pallet_Height_CM"]= strval($pallet_h);
        $recordObject["G_W_KG"]= strval($gw);
        $recordObject["VOLUME_CBM"]= strval($volume);

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
}
