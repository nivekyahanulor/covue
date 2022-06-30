<?php
date_default_timezone_set("Asia/Tokyo");

class Product_sampling_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function fetch_shipping_invoices()
	{
		$query = $this->db->query("SELECT t1.`id` AS shipping_invoice_id, t6.`category_name`, t1.`invoice_date`, t1.`invoice_no_big`, t1.`invoice_no_tiny`, t2.`company_name`, t1.`total_value_of_shipment`, t1.`user_id`, t3.`id` AS shipping_status_id, t3.`label`, t1.`paid`, t1.`custom_report`, t1.`approved_by`, t1.`approved_date`, t1.`updated_by` AS 'last_updated_by_id', t4.`contact_person` AS 'last_updated_by', t1.`updated_at` AS 'last_date_updated', t5.`contact_person` AS 'approved_name'
									FROM `shipping_invoices` AS t1
									LEFT JOIN `users` AS t2 ON t1.`user_id` = t2.`id`
									LEFT JOIN `shipping_invoice_status` AS t3 ON t1.`status` = t3.`id`
									LEFT JOIN `users` AS t4 ON t1.`updated_by` = t4.`id`
									LEFT JOIN `users` AS t5 ON t1.`approved_by` = t5.`id`
									LEFT JOIN `product_categories` AS t6 ON t1.`product_category` = t6.`id`
									WHERE t1.`active` = 1 AND t1.`product_sampling` = 1 ORDER BY t1.`created_at` DESC");
		return $query;
	}

	function fetch_shipping_custom($status)
	{
		$query = $this->db->query("SELECT t1.`id` AS shipping_invoice_id, t6.`category_name`, t1.`invoice_date`, t1.`invoice_no_big`, t1.`invoice_no_tiny`, t2.`company_name`, t1.`total_value_of_shipment`, t1.`user_id`, t3.`id` AS shipping_status_id, t3.`label`, t1.`paid`, t1.`custom_report`, t1.`approved_by`, t1.`approved_date`, t1.`updated_by` AS 'last_updated_by_id', t4.`contact_person` AS 'last_updated_by', t1.`updated_at` AS 'last_date_updated', t5.`contact_person` AS 'approved_name'
									FROM `shipping_invoices` AS t1
									LEFT JOIN `users` AS t2 ON t1.`user_id` = t2.`id`
									LEFT JOIN `shipping_invoice_status` AS t3 ON t1.`status` = t3.`id`
									LEFT JOIN `users` AS t4 ON t1.`updated_by` = t4.`id`
									LEFT JOIN `users` AS t5 ON t1.`approved_by` = t5.`id`
									LEFT JOIN `product_categories` AS t6 ON t1.`product_category` = t6.`id`
									WHERE t1.`active` = 1  AND t1.`status` = $status AND t1.`product_sampling` = 1 ORDER BY t1.`created_at` DESC");
		return $query;
	}

	function fetch_shipping_invoice_by_id($shipping_invoice_id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS shipping_invoice_id, t3.`id` AS shipping_status_id FROM `shipping_invoices` AS t1
									LEFT JOIN `users` AS t2 ON t1.`user_id` = t2.`id`
									LEFT JOIN `shipping_invoice_status` AS t3 ON t1.`status` = t3.`id`
									WHERE t1.`id` = $shipping_invoice_id AND t1.`active` = 1");
		return $query;
	}

	function accept_shipping_invoice($shipping_invoice_id, $approved_by, $approved_date, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `shipping_invoices` SET `status` = 1, `approved_by` = '$approved_by', `approved_date` = '$approved_date',  `updated_by` = '$updated_by', `updated_at` = '$updated_at' WHERE `id` = $shipping_invoice_id");
		return $this->db->affected_rows() > 0;
	}

	function paid_shipping_invoice($shipping_invoice_id, $date_today, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `shipping_invoices` SET `status` = 1, `paid` = 1, `invoice_date` = '$date_today', `updated_by` = '$updated_by', `updated_at` = '$updated_at' WHERE `id` = $shipping_invoice_id");
		return $this->db->affected_rows() > 0;
	}

	function completed_shipping_invoice($shipping_invoice_id, $custom_report_filename, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `shipping_invoices` SET `status` = 2, `custom_report` = '$custom_report_filename', `updated_by` = '$updated_by', `updated_at` = '$updated_at' WHERE `id` = $shipping_invoice_id");
		return $this->db->affected_rows() > 0;
	}

	function revision_shipping_invoice($shipping_invoice_id, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `shipping_invoices` SET `status` = 5, `updated_by` = '$updated_by', `updated_at` = '$updated_at' WHERE `id` = $shipping_invoice_id");
		return $this->db->affected_rows() > 0;
	}

	function arrived_shipping_invoice($shipping_invoice_id, $approved_by, $approved_date, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `shipping_invoices` SET `status` = 7, `approved_by` = '$approved_by', `approved_date` = '$approved_date',  `updated_by` = '$updated_by', `updated_at` = '$updated_at' WHERE `id` = $shipping_invoice_id");
		return $this->db->affected_rows() > 0;
	}

	function ready_shipping_invoice($shipping_invoice_id, $approved_by, $approved_date, $updated_by, $updated_at)
	{
		$this->db->query("UPDATE `shipping_invoices` SET `status` = 8, `approved_by` = '$approved_by', `approved_date` = '$approved_date',  `updated_by` = '$updated_by', `updated_at` = '$updated_at' WHERE `id` = $shipping_invoice_id");
		return $this->db->affected_rows() > 0;
	}

	function create_revision_message($shipping_invoice_id, $message, $created_by, $created_at)
	{
		$this->db->query("INSERT INTO `messages`(`s_id`, `type`, `message`, `created_by`, `created_at`) VALUES ('$shipping_invoice_id','Revisions','$message','$created_by','$created_at')");
		return $this->db->affected_rows() > 0;
	}

	function fetch_latest_revision_message($id)
	{
		$query = $this->db->query("SELECT * FROM `messages` WHERE `type` = 'Revisions' AND `s_id` = $id");
		return $query->last_row();
	}
}
