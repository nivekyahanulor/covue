<?php
date_default_timezone_set("Asia/Tokyo");

class Product_registration_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function fetch_product_registrations()
	{
		$query = $this->db->query("SELECT t1.`id` AS 'product_registration_id', t1.`created_at` AS 'product_registration_date', t3.`company_name`, t3.`id` AS 'user_details_id', t1.`sku`, t1.`product_category_id`, t5.`category_name`, t1.`product_name`, t1.`product_img`, t1.`product_label`, t1.`product_certificate`, t1.`status`, t2.`label`, t1.`revisions_msg`, t1.`declined_msg`, t1.`updated_by` AS 'last_updated_by_id', t4.`contact_person` AS 'last_updated_by', t1.`updated_at` AS 'last_date_updated', t1.`regulated_application_id`,t1.`is_mailing_product`
									FROM `product_registrations` AS t1
									LEFT JOIN `product_registration_status` AS t2 ON t1.`status` = t2.`id`
									LEFT JOIN `users` AS t3 ON t1.`user_id` = t3.`id`
									LEFT JOIN `users` AS t4 ON t1.`updated_by` = t4.`id`
									LEFT JOIN `product_categories` AS t5 ON t1.`product_category_id` = t5.`id`
									WHERE t1.`active` = 1 AND t1.`is_mailing_product` = 0 ORDER BY t1.`created_at` DESC");
		return $query;
	}

	function fetch_product_registrations_custom($status)
	{
		$query = $this->db->query("SELECT t1.`id` AS 'product_registration_id', t1.`created_at` AS 'product_registration_date', t3.`company_name`, t3.`id` AS 'user_details_id', t1.`sku`, t1.`product_category_id`, t5.`category_name`, t1.`product_name`, t1.`product_img`, t1.`product_label`, t1.`product_certificate`, t1.`status`, t2.`label`, t1.`revisions_msg`, t1.`declined_msg`, t1.`updated_by` AS 'last_updated_by_id', t4.`contact_person` AS 'last_updated_by', t1.`updated_at` AS 'last_date_updated', t1.`regulated_application_id`, t1.`regulated_application_id`,t1.`is_mailing_product`
		 							FROM `product_registrations` AS t1
									LEFT JOIN `product_registration_status` AS t2 ON t1.`status` = t2.`id`
									LEFT JOIN `users` AS t3 ON t1.`user_id` = t3.`id`
									LEFT JOIN `users` AS t4 ON t1.`updated_by` = t4.`id`
									LEFT JOIN `product_categories` AS t5 ON t1.`product_category_id` = t5.`id`
									WHERE t1.`active` = 1 AND t1.`status` = $status AND t1.`is_mailing_product` = 0 ORDER BY t1.`created_at` DESC");
		return $query;
	}

	function fetch_product_registrations_mailing_products(){
		$query = $this->db->query("SELECT t1.`id` AS 'product_registration_id', t1.`created_at` AS 'product_registration_date', t3.`company_name`, t3.`id` AS 'user_details_id', t1.`sku`,t1.`product_type`,t1.`dimensions_by_piece`,t1.`weight_by_piece`,t1.`is_mailing_product`,t1.`mailing_product_price`, t1.`product_category_id`, t5.`category_name`, t1.`product_name`, t1.`product_img`, t1.`product_label`, t1.`product_certificate`, t1.`status`, t2.`label`, t1.`revisions_msg`, t1.`declined_msg`, t1.`updated_by` AS 'last_updated_by_id', t4.`contact_person` AS 'last_updated_by', t1.`updated_at` AS 'last_date_updated', t1.`regulated_application_id`
									FROM `product_registrations` AS t1
									LEFT JOIN `product_registration_status` AS t2 ON t1.`status` = t2.`id`
									LEFT JOIN `users` AS t3 ON t1.`user_id` = t3.`id`
									LEFT JOIN `users` AS t4 ON t1.`updated_by` = t4.`id`
									LEFT JOIN `product_categories` AS t5 ON t1.`product_category_id` = t5.`id`
									WHERE t1.`active` = 1 AND t1.`is_mailing_product` = 1 ORDER BY t1.`created_at` DESC");
		return $query;
	
	}

	function add_mailing_price($id, $mailing_product_price, $updated_at, $updated_by){
		$this->db->query("UPDATE `product_registrations` SET `mailing_product_price` = '$mailing_product_price', `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function fetch_product_registration($id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'product_registration_id' FROM `product_registrations` AS t1
									LEFT JOIN `product_registration_status` AS t2 ON t1.`status` = t2.`id`
									LEFT JOIN `users` AS t3 ON t1.`user_id` = t3.`id`
									WHERE t1.`active` = 1 AND t1.`id` = $id");
		return $query;
	}

	function fetch_product_categories()
	{
		$query = $this->db->query("SELECT * FROM `product_categories` WHERE `active` = 1 ORDER BY `category_name` ASC");
		return $query;
	}

	function fetch_latest_revision_message($id)
	{
		$query = $this->db->query("SELECT * FROM `messages` WHERE `type` = 'Revisions' AND `s_id` = $id");
		return $query->last_row();
	}

	function update_products($id, $sku, $product_name, $product_type, $dimensions_by_piece, $weight_by_piece, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `product_registrations` SET `sku` = '$sku', `product_name` = '$product_name', `product_type` = '$product_type', `dimensions_by_piece` = '$dimensions_by_piece', `weight_by_piece` = '$weight_by_piece', `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}


	function update_products_img($id, $sku, $product_name, $product_img, $product_type, $dimensions_by_piece, $weight_by_piece, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `product_registrations` SET `sku` = '$sku', `product_name` = '$product_name', `product_img` = '$product_img', `product_type` = '$product_type', `dimensions_by_piece` = '$dimensions_by_piece', `weight_by_piece` = '$weight_by_piece', `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function update_products_label($id, $sku, $product_name, $product_label, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `product_registrations` SET `sku` = '$sku', `product_name` = '$product_name', `product_label` = '$product_label', `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function update_products_img_and_label($id, $sku, $product_name, $product_img, $product_label, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `product_registrations` SET `sku` = '$sku', `product_name` = '$product_name', `product_img` = '$product_img', `product_label` = '$product_label', `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function product_approve($id, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `product_registrations` SET `status` = 1, `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function product_decline($id, $declined_msg, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `product_registrations` SET `status` = 2, `declined_msg` = '$declined_msg', `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function product_revisions($id, $revisions_msg, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `product_registrations` SET `status` = 3, `revisions_msg` = '$revisions_msg', `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function product_delete($id, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `product_registrations` SET `active` = 0, `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function fetch_product_labels()
	{
		$query = $this->db->query("SELECT t1.`id` AS 'product_label_id', t3.`company_name`, t2.`product_name`, t1.`product_label_filename`, t4.`nicename` AS 'made_in', t1.`status` AS 'product_label_status', t5.`label`, t2.`id` AS 'product_registration_id', t3.`id` AS `user_details_id`, t1.`created_at` AS 'product_label_date', t1.`updated_by` AS 'last_updated_by_id', t6.`contact_person` AS 'last_updated_by', t1.`updated_at` AS 'last_date_updated'
									FROM `product_labels` AS t1
									LEFT JOIN `product_registrations` AS t2 ON t1.`product_registration_id` = t2.`id`
									LEFT JOIN `users` AS t3 ON t1.`user_id` = t3.`id`
									LEFT JOIN `countries` AS t4 ON t1.`country_of_origin` = t4.`id`
									LEFT JOIN `product_label_status` AS t5 ON t1.`status` = t5.`id`
									LEFT JOIN `users` AS t6 ON t1.`updated_by` = t6.`id`
									WHERE t1.`active` = 1 ORDER BY t1.`created_at` DESC");
		return $query;
	}

	function fetch_product_label($id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'product_label_id', t1.`created_at` AS 'product_label_date', t4.`nicename` AS 'made_in', t1.`status` AS 'product_label_status', t2.`id` AS 'product_registration_id'
									FROM `product_labels` AS t1
									LEFT JOIN `product_registrations` AS t2 ON t1.`product_registration_id` = t2.`id`
									LEFT JOIN `users` AS t3 ON t1.`user_id` = t3.`id`
									LEFT JOIN `countries` AS t4 ON t1.`country_of_origin` = t4.`id`
									LEFT JOIN `product_label_status` AS t5 ON t1.`status` = t5.`id`
									WHERE t1.`active` = 1 AND t1.`id` = $id");
		return $query;
	}

	function fetch_country($id)
	{
		$query = $this->db->query("SELECT `nicename` FROM `countries` WHERE `id` = $id");
		return $query;
	}

	function update_product_label_approve($id, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `product_labels` SET `status` = 1, `updated_by` = '$updated_by', `updated_at` = '$updated_at' WHERE `active` = 1 AND `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function update_product_registration_label($id, $product_label, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `product_registrations` SET `product_label` = '$product_label', `status` = 1, `updated_by` = '$updated_by', `updated_at` = '$updated_at' WHERE `active` = 1 AND `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function update_product_label_on_process($id, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `product_labels` SET `status` = 2, `updated_by` = '$updated_by', `updated_at` = '$updated_at' WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function update_product_label_revision($id, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `product_labels` SET `status` = 3, `updated_by` = '$updated_by', `updated_at` = '$updated_at' WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function create_revision_message($id, $message, $created_by, $created_at)
	{
		$this->db->query("INSERT INTO `messages`(`s_id`, `type`, `message`, `created_by`, `created_at`) VALUES ('$id','Revisions','$message','$created_by','$created_at')");
		return $this->db->affected_rows() > 0;
	}

	function update_product_label_generated($id, $product_label_filename, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `product_labels` SET `status` = 5, `product_label_filename` = '$product_label_filename', `updated_by` = '$updated_by', `updated_at` = '$updated_at' WHERE `active` = 1 AND `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function update_product_category($id, $product_category_id, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `product_registrations` SET `product_category_id` = $product_category_id, `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function update_product_category_regulated($id, $product_category_id, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `product_registrations` SET `product_category_id` = $product_category_id, `status` = 2, `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function fetch_user_by_id($user_id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'user_id', t2.`nicename` AS country_name FROM `users` AS t1
									LEFT JOIN `countries` AS t2 ON t1.`country` = t2.`id`
									WHERE t1.`id` = $user_id");
		return $query;
	}
}
