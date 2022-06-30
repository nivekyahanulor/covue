<?php
date_default_timezone_set("Asia/Tokyo");

class Shipping_details_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function fetch_all_shipping()
	{
		$query = $this->db->query("SELECT *, t1.`amazon_seller` AS 'amazon_seller_report', t1.`created_at` AS 'shipping_date'
									FROM `shipping` AS t1
									LEFT JOIN `users` AS t2 ON t1.`users_id` = t2.`id`
									WHERE t1.`is_active` = 1 ORDER BY t1.`created_at` DESC");
		return $query;
	}

	function fetch_shipping_pending()
	{
		$query = $this->db->query("SELECT *, t1.`amazon_seller` AS 'amazon_seller_report', t1.`created_at` AS 'shipping_date'
									FROM `shipping` AS t1
									LEFT JOIN `users` AS t2 ON t1.`users_id` = t2.`id`
									WHERE t1.`is_active` = 1 AND t1.`ior_status` = 'Pending' ORDER BY t1.`created_at` DESC");
		return $query;
	}

	function fetch_shipping_accepted()
	{
		$query = $this->db->query("SELECT *, t1.`amazon_seller` AS 'amazon_seller_report', t1.`created_at` AS 'shipping_date'
									FROM `shipping` AS t1
									LEFT JOIN `users` AS t2 ON t1.`users_id` = t2.`id`
									WHERE t1.`is_active` = 1 AND t1.`ior_status` = 'Accepted' ORDER BY t1.`created_at` DESC");
		return $query;
	}

	function fetch_shipping_revisions()
	{
		$query = $this->db->query("SELECT *, t1.`amazon_seller` AS 'amazon_seller_report', t1.`created_at` AS 'shipping_date'
									FROM `shipping` AS t1
									LEFT JOIN `users` AS t2 ON t1.`users_id` = t2.`id`
									WHERE t1.`is_active` = 1 AND t1.`ior_status` = 'Needs Revision' ORDER BY t1.`created_at` DESC");
		return $query;
	}

	function fetch_shipping_updated()
	{
		$query = $this->db->query("SELECT *, t1.`amazon_seller` AS 'amazon_seller_report', t1.`created_at` AS 'shipping_date'
									FROM `shipping` AS t1
									LEFT JOIN `users` AS t2 ON t1.`users_id` = t2.`id`
									WHERE t1.`is_active` = 1 AND t1.`ior_status` = 'Updated' ORDER BY t1.`created_at` DESC");
		return $query;
	}

	function fetch_shipping_completed()
	{
		$query = $this->db->query("SELECT *, t1.`amazon_seller` AS 'amazon_seller_report', t1.`created_at` AS 'shipping_date'
									FROM `shipping` AS t1
									LEFT JOIN `users` AS t2 ON t1.`users_id` = t2.`id`
									WHERE t1.`is_active` = 1 AND t1.`ior_status` = 'Completed' ORDER BY t1.`created_at` DESC");
		return $query;
	}

	function fetch_shipping_by_id($shipping_id)
	{
		$query = $this->db->query("SELECT *, t1.`amazon_seller` AS 'amazon_seller_report', t1.`created_at` AS 'shipping_date', t2.`id` AS 'user_id' 
									FROM `shipping` AS t1
									LEFT JOIN `users` AS t2 ON t1.`users_id` = t2.`id`
									WHERE t1.`is_active` = 1 AND t1.`shipping_id` = $shipping_id");
		return $query;
	}

	function fetch_hscode($id)
	{
		$query = $this->db->query("SELECT * FROM `product_qualification` WHERE `is_active` = 1 AND `status` = 'Approved' AND `id` = $id");
		return $query;
	}

	function accept_shipping($shipping_id, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `shipping` SET `ior_status` = 'Accepted', `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `shipping_id` = $shipping_id");
		return $this->db->affected_rows() > 0;
	}

	function update_shipping_no_uploads($shipping_id, $hscode_ship, $total_value_of_shipment, $is_paid, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `shipping` SET `product_qualification_id` = '$hscode_ship', `total_value_of_shipment` = '$total_value_of_shipment', `is_paid` = '$is_paid', `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `shipping_id` = $shipping_id");
		return $this->db->affected_rows() > 0;
	}

	function update_shipping_with_shipping_invoice($shipping_id, $hscode_ship, $total_value_of_shipment, $shipping_invoice, $is_paid, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `shipping` SET `product_qualification_id` = '$hscode_ship', `total_value_of_shipment` = '$total_value_of_shipment', `shipping_invoice` = '$shipping_invoice', `is_paid` = '$is_paid', `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `shipping_id` = $shipping_id");
		return $this->db->affected_rows() > 0;
	}

	function update_shipping_with_amazon_seller($shipping_id, $hscode_ship, $total_value_of_shipment, $amazon_seller, $is_paid, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `shipping` SET `product_qualification_id` = '$hscode_ship', `total_value_of_shipment` = '$total_value_of_shipment', `amazon_seller` = '$amazon_seller', `is_paid` = '$is_paid', `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `shipping_id` = $shipping_id");
		return $this->db->affected_rows() > 0;
	}

	function update_shipping_both_uploads($shipping_id, $hscode_ship, $total_value_of_shipment, $shipping_invoice, $amazon_seller, $is_paid, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `shipping` SET `product_qualification_id` = '$hscode_ship', `total_value_of_shipment` = '$total_value_of_shipment', `shipping_invoice` = '$shipping_invoice', `amazon_seller` = '$amazon_seller', `is_paid` = '$is_paid', `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `shipping_id` = $shipping_id");
		return $this->db->affected_rows() > 0;
	}

	function accept_shipping_if_paid($shipping_id)
	{
		$this->db->query("UPDATE `shipping` SET `ior_status` = 'Accepted' WHERE `shipping_id` = $shipping_id");
		return $this->db->affected_rows() > 0;
	}

	function fetch_user_by_shipping_id($shipping_id)
	{
		$query = $this->db->query("SELECT * FROM `shipping` AS t1
									LEFT JOIN `users` AS t2 ON t1.`id` = t2.`id`
									WHERE t1.`shipping_id` = $shipping_id");
		return $query;
	}

	function revision_shipping($shipping_id, $revisions_msg, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `shipping` SET `ior_status` = 'Needs Revision', `revisions_msg` = '$revisions_msg', `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `shipping_id` = $shipping_id");
		return $this->db->affected_rows() > 0;
	}

	function completed_shipping($shipping_id, $custom_report_filename, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `shipping` SET `ior_status` = 'Completed', `custom_report` = '$custom_report_filename', `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `shipping_id` = $shipping_id");
		return $this->db->affected_rows() > 0;
	}

	function delete_shipping($shipping_id, $updated_at, $updated_by)
	{
		$this->db->query("UPDATE `shipping` SET `is_active` = 0, `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `shipping_id` = $shipping_id");
		return $this->db->affected_rows() > 0;
	}
}
