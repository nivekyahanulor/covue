<?php
date_default_timezone_set("Asia/Tokyo");

class Shipping_companies_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function fetch_all_shipping_companies()
    {
        $query = $this->db->query("SELECT t1.`id` AS shipping_company_id, t1.`shipping_company_name`, t2.`contact_person`, t1.`active`, t1.`contact_person`, t1.`email`, t1.`partner`, t1.`created_by`, t1.`created_at`, t1.`updated_by` AS 'last_updated_by_id', t3.`contact_person` AS 'last_updated_by', t1.`updated_at` AS 'last_date_updated' 
                                    FROM `shipping_companies` AS t1
                                    LEFT JOIN `users` AS t2 ON t1.`created_by` = t2.`id`
                                    LEFT JOIN `users` AS t3 ON t1.`updated_by` = t3.`id`
                                    WHERE t1.`active` = 1 ORDER BY t1.`id` DESC");
        return $query;
    }

    function fetch_shipping_company($id)
    {
        $query = $this->db->query("SELECT t1.`id` AS shipping_company_id, t1.`shipping_company_name`, t2.`contact_person`, t1.`created_at`, t1.`active` , t1.`email` , t1.`username` , t1.`password` , t1.`partner`  , t1.`contact_person`  , t1.`country` 
									FROM `shipping_companies` AS t1
                                    LEFT JOIN `users` AS t2 ON t1.`created_by` = t2.`id`
                                    WHERE t1.`active` = 1 AND t1.`id` = $id");
        return $query;
    }

    function update_shipping_company($id, $shipping_company_name, $shipping_company_email, $shipping_company_username, $shipping_company_password, $shipping_company_partner,$shipping_contact_person,$shipping_country, $updated_at, $updated_by)
    {
        $this->db->query("UPDATE `shipping_companies` SET `shipping_company_name` = '$shipping_company_name',
						`email`='$shipping_company_email' , `username`='$shipping_company_username' , `password` =  '$shipping_company_password', `partner`='$shipping_company_partner' , `contact_person`='$shipping_contact_person' , `country`='$shipping_country',`updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `id` = $id");
        return $this->db->affected_rows() > 0;
    }

    function delete_shipping_company($id, $updated_at, $updated_by)
    {
        $this->db->query("UPDATE `shipping_companies` SET `active` = 0, `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `id` = $id");
        return $this->db->affected_rows() > 0;
    }
	function fetch_countries()
	{
		$query = $this->db->query("SELECT * FROM `countries`");
		return $query;
	}
}
