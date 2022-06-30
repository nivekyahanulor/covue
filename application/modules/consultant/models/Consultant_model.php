<?php
date_default_timezone_set("Asia/Tokyo");

class Consultant_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function fetch_users_by_id($user_id)
	{
		$query = $this->db->query("SELECT * FROM `users` LEFT JOIN `consultant` ON `users`.`id` = `consultant`.`consultant_id` WHERE `users`.`user_role_id` = 4 AND `users`.`id` = $user_id");
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

	function fectch_company_customer($user_id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS shipping_invoice_id, t2.`id` AS user_consultant_id
									FROM `shipping_invoices` AS t1
									LEFT JOIN `users` AS t2 ON t1.`user_id`= t2.`id`
									WHERE  t2.`consultant_id` = $user_id AND t1.`active` = 1
									ORDER BY t1.`id` DESC");
		return $query;
	}

	function fetch_shipping_invoices_by_user_id($user_id)
	{
		$query = $this->db->query("SELECT *, t1.`id` AS shipping_invoice_id FROM `shipping_invoices` AS t1
									LEFT JOIN `shipping_invoice_status` AS t2 ON t1.`status` = t2.`id`
									LEFT JOIN `users` AS t3 ON t1.`user_id` = t3.`id`
									WHERE t1.`user_id` = $user_id AND t1.`active` = 1");
		return $query;
	}

	function fectch_company_consultant_customer($user_id)
	{
		$query = $this->db->query("SELECT *
									from `users` AS t1
									
									WHERE  t1.`consultant_id` = $user_id AND t1.`active` = 1
									ORDER BY t1.`id` DESC");
		return $query;
	}


	function fetch_regulated_application($user_id)
	{
		$query = $this->db->query("SELECT t1.`company_name` , t3.`category_name` , t2.`tracking_status`  FROM `users` AS t1
									LEFT JOIN regulated_applications AS t2 on t2.`created_by` = t1.`id`
									LEFT JOIN product_categories AS t3 on t3.`id` = t2.`product_category_id`
									WHERE t1.`consultant_id` = $user_id AND t1.`active` = 1 and t2.created_by = t1.id AND t2.`active` = 1");
		return $query;
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

	function update_consultant_user($user_id, $username, $password, $company_name, $country, $contact_person, $email, $updated_at, $updated_by)
	{

		$this->db->query("UPDATE `users` SET `username`='$username',`password`='$password',`contact_person`='$contact_person',`company_name`='$company_name',`country`='$country',`email`='$email',`updated_at`='$updated_at',`updated_by`='$updated_by' WHERE `id` = $user_id");
		return $this->db->affected_rows() > 0;
	}

	function update_header_title($data, $userid)
	{
		$header_title = $data['header_title'];
		$query = $this->db->query("UPDATE consultant set landing_page_header_title ='$header_title' WHERE  `consultant_id` = $userid");
		return $query;
	}

	function update_color_header($data, $userid)
	{
		if ($data['header_color'] != "") {
			$header = $data['header_color'];
		} else {
			$header = $data['header'];
		}
		$query = $this->db->query("UPDATE consultant set header_color ='$header' WHERE  `consultant_id` = $userid");
		return $query;
	}

	function update_color_footer($data, $userid)
	{
		if ($data['footer_color'] != "") {
			$footer = $data['footer_color'];
		} else {
			$footer = $data['footer'];
		}
		$query = $this->db->query("UPDATE consultant set footer_color ='$footer' WHERE  `consultant_id` = $userid");
		return $query;
	}
}
