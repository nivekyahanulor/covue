<?php
date_default_timezone_set("Asia/Tokyo");

class Ecommerce_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function fetch_product_offer_by_platform($id)
	{
		$query = $this->db->query("SELECT ");
		return $query;
	}

	function fetch_amazon_products()
	{
		$query = $this->db->query("SELECT * FROM `products_offer` AS t1
									LEFT JOIN `product_categories` AS t3 ON t1.`product_category_id` = t3.`id`
									LEFT JOIN `product_services` AS t2 ON t3.`product_service_id` = t2.`id`
									WHERE t1.`active` = 1 AND t3.`ecommerce_platform_id` = 1");
		return $query;
	}

	function fetch_amazon_account_setup($user_id)
	{
		$query = $this->db->query("SELECT * FROM `users_payment_invoice` AS t1
                                    WHERE t1.`user_id` = $user_id AND t1.`active` = 1 AND t1.`product_offer_id` = 12");
		return $query->num_rows();
	}

	function fetch_product_offer($id)
	{
		$query = $this->db->query("SELECT * FROM `products_offer` AS t1
									LEFT JOIN `product_categories` AS t3 ON t1.`product_category_id` = t3.`id`
									LEFT JOIN `product_services` AS t2 ON t3.`product_service_id` = t2.`id`
									WHERE t1.`id` = $id AND t1.`active` = 1");
		return $query;
	}

	function fetch_reg_fee()
	{
		$query = $this->db->query("SELECT * FROM `products_offer` AS t1
									LEFT JOIN `product_categories` AS t3 ON t1.`product_category_id` = t3.`id`
									LEFT JOIN `product_services` AS t2 ON t3.`product_service_id` = t2.`id`
									WHERE t1.`id` = 1 AND t1.`active` = 1");
		return $query->result();
	}

	function fetch_billing_invoices_unpaid($user_id, $ecom_id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'user_payment_invoice_id', t1.`created_at` AS 'invoice_date', t5.`company_name` AS 'user_company_name', t1.`status` AS 'payment_status'
                                    FROM `users_payment_invoice` AS t1
                                    LEFT JOIN `products_offer` AS t2 ON t1.`product_offer_id` = t2.`id`
                                    LEFT JOIN `product_categories` AS t3 ON t2.`product_category_id` = t3.`id`
                                    LEFT JOIN `product_services` AS t4 ON t3.`product_service_id` = t4.`id`
                                    LEFT JOIN `users` AS t5 ON t1.`user_id` = t5.`id`
                                    WHERE t1.`user_id` = $user_id AND t1.`active` = 1 AND t1.`status` = 0 AND t3.`ecommerce_platform_id` = $ecom_id ORDER BY t1.`id` ASC");
		return $query->num_rows();
	}

	function fetch_countries()
	{
		$query = $this->db->query("SELECT * FROM `countries`");
		return $query;
	}

	function fetch_billing_invoices($user_id, $ecom_id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS 'user_payment_invoice_id', t1.`created_at` AS 'invoice_date', t5.`company_name` AS 'user_company_name', t1.`status` AS 'payment_status'
                                    FROM `users_payment_invoice` AS t1
                                    LEFT JOIN `products_offer` AS t2 ON t1.`product_offer_id` = t2.`id`
                                    LEFT JOIN `product_categories` AS t3 ON t2.`product_category_id` = t3.`id`
                                    LEFT JOIN `product_services` AS t4 ON t3.`product_service_id` = t4.`id`
                                    LEFT JOIN `users` AS t5 ON t1.`user_id` = t5.`id`
                                    WHERE t1.`user_id` = $user_id AND t1.`active` = 1 AND t3.`ecommerce_platform_id` = $ecom_id ORDER BY t1.`id` ASC");
		return $query;
	}

	function fetch_product_registrations_custom($status)
	{
		$query = $this->db->query("SELECT t1.`id` AS 'product_registration_id', t1.`created_at` AS 'product_registration_date', t3.`company_name`, t3.`id` AS 'users_details_id', t1.`hscode`, t5.`category_name`, t1.`product_details`, t1.`product_img`, t1.`product_label`, t1.`status`, t2.`label`, t1.`revisions_msg`, t1.`declined_msg`, t1.`updated_by` AS 'last_updated_by_id', t4.`contact_person` AS 'last_updated_by', t1.`updated_at` AS 'last_date_updated'
		 							FROM `product_registrations` AS t1
									LEFT JOIN `product_registration_status` AS t2 ON t1.`status` = t2.`id`
									LEFT JOIN `users` AS t3 ON t1.`user_id` = t3.`id`
									LEFT JOIN `users` AS t4 ON t1.`updated_by` = t4.`id`
									LEFT JOIN `product_categories` AS t5 ON t1.`product_category_id` = t5.`id`
									WHERE t1.`active` = 1 AND t1.`status` = $status ORDER BY t1.`created_at` DESC");
		return $query;
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
		$query = $this->db->query("SELECT * FROM `product_categories` WHERE `active` = 1 ORDER BY `id` ASC");
		return $query;
	}

	function fetch_latest_revision_message($id)
	{
		$query = $this->db->query("SELECT * FROM `messages` WHERE `type` = 'Revisions' AND `s_id` = $id");
		return $query->last_row();
	}

	function update_products($id, $hscode, $product_details, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `product_registrations` SET `hscode` = '$hscode', `product_details` = '$product_details', `updated_at` = '$updated_at', `status` = 5, `updated_by` = '$updated_by' WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function update_products_img($id, $hscode, $product_details, $product_img, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `product_registrations` SET `hscode` = '$hscode', `product_details` = '$product_details', `product_img` = '$product_img', `status` = 5, `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function update_products_label($id, $hscode, $product_details, $product_label, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `product_registrations` SET `hscode` = '$hscode', `product_details` = '$product_details', `product_label` = '$product_label', `status` = 5, `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `id` = $id");
		return $this->db->affected_rows() > 0;
	}

	function update_products_img_and_label($id, $hscode, $product_details, $product_img, $product_label, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `product_registrations` SET `hscode` = '$hscode', `product_details` = '$product_details', `product_img` = '$product_img', `product_label` = '$product_label', `status` = 5, `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `id` = $id");
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
		$query = $this->db->query("SELECT t1.`id` AS 'product_label_id', t3.`company_name`, t2.`product_details`, t1.`product_label_filename`, t4.`nicename` AS 'made_in', t1.`status` AS 'product_label_status', t5.`label`, t2.`id` AS 'product_registration_id', t3.`id` AS 'user_details_id', t1.`created_at` AS 'product_label_date', t1.`updated_by` AS 'last_updated_by_id', t6.`contact_person` AS 'last_updated_by', t1.`updated_at` AS 'last_date_updated'
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

	function fetch_users_by_id($user_id)
	{

		$query = $this->db->query("SELECT *, `id` AS 'user_id' FROM `users` WHERE `active` = 1 AND `id` = '$user_id'");
		return $query;
	}
}
