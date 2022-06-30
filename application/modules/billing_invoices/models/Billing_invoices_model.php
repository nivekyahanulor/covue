<?php
date_default_timezone_set("Asia/Tokyo");

class Billing_invoices_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function fetch_billing_invoices()
    {
        $query = $this->db->query("SELECT *, t1.`id` AS 'user_payment_invoice_id', t1.`created_at` AS 'invoice_date', t5.`company_name` AS 'user_company_name', t1.`pli` AS 'pli_sub', t1.`status` AS 'payment_status'
                                    FROM `users_payment_invoice` AS t1
                                    LEFT JOIN `products_offer` AS t2 ON t1.`product_offer_id` = t2.`id`
                                    LEFT JOIN `product_categories` AS t3 ON t1.`product_category_id` = t3.`id`
                                    LEFT JOIN `product_services` AS t4 ON t3.`product_service_id` = t4.`id`
                                    LEFT JOIN `users` AS t5 ON t1.`user_id` = t5.`id`
                                    WHERE t1.`active` = 1 ORDER BY t1.`id` DESC");
        return $query;
    }

    function complete_billing_invoice($id, $updated_by, $updated_at)
    {
        $this->db->query("UPDATE `users_payment_invoice` set `status` = 2,`updated_by`='$updated_by',`updated_at`='$updated_at' WHERE `id` = '$id'");
        return $this->db->affected_rows() > 0;
    }

    function paid_billing_invoice($id, $updated_by, $updated_at)
    {
        $this->db->query("UPDATE `users_payment_invoice` set `status` = 1,`updated_by`='$updated_by',`updated_at`='$updated_at' WHERE `id` = '$id'");
        return $this->db->affected_rows() > 0;
    }

    function cancel_billing_invoice($id, $updated_by, $updated_at)
    {
        $this->db->query("UPDATE `users_payment_invoice` set `status` = 0, `active` = 0,`updated_by`='$updated_by',`updated_at`='$updated_at' WHERE `id` = '$id'");
        return $this->db->affected_rows() > 0;
    }
}
