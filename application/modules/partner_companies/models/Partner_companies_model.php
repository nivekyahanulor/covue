<?php
date_default_timezone_set("Asia/Tokyo");

class Partner_companies_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function fetch_users_by_id($user_id)
	{
		$query = $this->db->query("SELECT * FROM `shipping_companies` WHERE `partner` = 1 AND `id` = $user_id");
		return $query;
	}
	function fectch_company_customer($user_id)
	{
		$query = $this->db->query("SELECT t3.`contact_person` ,  t2.`user_id`, t2.`invoice_date` , t2.`total_value_of_shipment` ,
									t2.`invoice_no_big`, t2.`invoice_no_tiny`, t2.`paid` ,  t3.`company_name`, t2.`id` AS 'shipping_invoice_id'
									from `shipping_companies` AS t1
									LEFT JOIN `shipping_invoices` AS t2 ON t1.`id`=t2.`shipping_company`
									LEFT JOIN `users` AS t3 ON  t2.`user_id` = t3.`id`
									WHERE  t2.`shipping_company` = $user_id AND t2.`active` = 1
									ORDER BY t3.`id`");
		return $query;
	}

	function fectch_reffered_user($user_id)
	{
		$query = $this->db->query("SELECT * from `users` AS t1
									WHERE  t1.`shipping_company` = $user_id AND t1.`shipping_company_link` = 1
									ORDER BY t1.`id`");
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

	function fetch_regulated_application($user_id)
	{
		$query = $this->db->query("SELECT t1.`company_name` , t3.`category_name` , t2.`tracking_status` , t2.`created_at`  FROM `users` AS t1
									LEFT JOIN regulated_applications AS t2 on t2.`created_by` = t1.`id`
									LEFT JOIN product_categories AS t3 on t3.`id` = t2.`product_category_id`
									WHERE t1.`shipping_company` = $user_id AND t1.`active` = 1 and t2.created_by = t1.id");
		return $query;
	}




	function upload_logo($data, $userid)
	{
		$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
		$image_name = addslashes($_FILES['image']['name']);
		$image_size = getimagesize($_FILES['image']['tmp_name']);

		$path       = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
		$filename   = 'partners_' . time() . '.' . $path;
		move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/partners/" . $filename);

		$query = $this->db->query("UPDATE shipping_companies set logo ='$filename' WHERE  `id` = $userid");
		return $query;
	}

	function update_banner($data, $userid)
	{
		$image = addslashes(file_get_contents($_FILES['banner']['tmp_name']));
		$image_name = addslashes($_FILES['banner']['name']);
		$image_size = getimagesize($_FILES['banner']['tmp_name']);

		$path       = pathinfo($_FILES["banner"]["name"], PATHINFO_EXTENSION);
		$filename   = 'partners_banner_' . time() . '.' . $path;
		move_uploaded_file($_FILES["banner"]["tmp_name"], "uploads/partners/" . $filename);

		$query = $this->db->query("UPDATE shipping_companies set landing_page_banner ='$filename' WHERE  `id` = $userid");
		return $query;
	}

	function update_background($data, $userid)
	{
		$image = addslashes(file_get_contents($_FILES['background']['tmp_name']));
		$image_name = addslashes($_FILES['background']['name']);
		$image_size = getimagesize($_FILES['background']['tmp_name']);

		$path       = pathinfo($_FILES["background"]["name"], PATHINFO_EXTENSION);
		$filename   = 'partners_background_' . time() . '.' . $path;
		move_uploaded_file($_FILES["background"]["tmp_name"], "uploads/partners/" . $filename);

		$query = $this->db->query("UPDATE shipping_companies set landing_page_background ='$filename' WHERE  `id` = $userid");
		return $query;
	}

	function update_content($data, $userid)
	{
		$content = $data['content'];
		$query = $this->db->query("UPDATE shipping_companies set landing_page_content ='$content' WHERE  `id` = $userid");
		return $query;
	}

	function update_color_header($data, $userid)
	{
		if($data['header_color']!=""){
			$header = $data['header_color'];
		} else {
			$header = $data['header'];
		}
		$query = $this->db->query("UPDATE shipping_companies set header_color ='$header' WHERE  `id` = $userid");
		return $query;
	}

	function update_color_footer($data, $userid)
	{
		if($data['footer_color']!=""){
			$footer = $data['footer_color'];
		} else {
			$footer = $data['footer'];
		}
		$query = $this->db->query("UPDATE shipping_companies set footer_color ='$footer' WHERE  `id` = $userid");
		return $query;
	}

	function update_profile($data, $userid)
	{
		$email = $data['shipping_company_email'];
		$username = $data['shipping_company_username'];
		$password = $data['shipping_company_password'];
		$contact_person = $data['contact_person'];
        $country = $data['country'];
		$query = $this->db->query("UPDATE shipping_companies set email = '$email' , username ='$username' , password='$password' , contact_person='$contact_person', country='$country' WHERE  `id` = $userid");
		return $query;
	}

	function fetch_countries()
    {
        $query = $this->db->query("SELECT * FROM `countries`");
        return $query;
    }
}
