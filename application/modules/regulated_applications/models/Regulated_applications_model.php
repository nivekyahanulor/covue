<?php
date_default_timezone_set("Asia/Tokyo");

class Regulated_applications_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function fetch_users_by_id($user_id)
    {
        $query = $this->db->query("SELECT *, `id` AS 'user_id' FROM `users` WHERE `active` = 1 AND `id` = $user_id");
        return $query;
    }

    function fetch_countries()
    {
        $query = $this->db->query("SELECT * FROM `countries`");
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

    function fetch_all_regulated_applications()
    {
        $query = $this->db->query("SELECT t1.`id` AS 'regulated_application_id', t6.`company_name` AS 'user_company_name', t3.`category_name`, t1.`tracking_status`, t5.`tracking_status_name`, t1.`created_at` AS 'application_date', t9.`updated_at` AS 'last_date_updated',  t1.`assigned_admin_id`, t7.`contact_person` AS 'assigned_admin_name', t9.`approve_status`
                                    FROM `regulated_applications` AS t1
                                    LEFT JOIN `users_payment_invoice` AS t2 ON t1.`user_payment_invoice_id` = t2.`id`
                                    LEFT JOIN `product_categories` AS t3 ON t2.`product_category_id` = t3.`id`
                                    LEFT JOIN `product_services` AS t4 ON t3.`product_service_id` = t4.`id`
                                    LEFT JOIN `regulated_status_a` AS t5 ON t1.`tracking_status` = t5.`id`
                                    LEFT JOIN `users` AS t6 ON t2.`user_id` = t6.`id`
                                    LEFT JOIN `users` AS t7 ON t1.`assigned_admin_id` = t7.`id`
                                    LEFT JOIN `regulated_application_tracking` AS t9 ON t1.`tracking_status` = t9.`tracking_status`
                                    AND t9.`regulated_application_id` = t1.`id`
                                    WHERE t1.`active` = 1 ORDER BY t1.`id` DESC");
        return $query;
    }

    function fetch_all_regulated_applications_by_assigned_admin_id($assigned_admin_id)
    {
        $query = $this->db->query("SELECT t1.`id` AS 'regulated_application_id', t6.`company_name` AS 'user_company_name', t3.`category_name`, t1.`tracking_status`, t5.`tracking_status_name`, t1.`created_at` AS 'application_date', t9.`updated_at` AS 'last_date_updated',  t1.`assigned_admin_id`, t7.`contact_person` AS 'assigned_admin_name', t9.`approve_status`
                                    FROM `regulated_applications` AS t1
                                    LEFT JOIN `users_payment_invoice` AS t2 ON t1.`user_payment_invoice_id` = t2.`id`
                                    LEFT JOIN `product_categories` AS t3 ON t2.`product_category_id` = t3.`id`
                                    LEFT JOIN `product_services` AS t4 ON t3.`product_service_id` = t4.`id`
                                    LEFT JOIN `regulated_status_a` AS t5 ON t1.`tracking_status` = t5.`id`
                                    LEFT JOIN `users` AS t6 ON t2.`user_id` = t6.`id`
                                    LEFT JOIN `users` AS t7 ON t1.`assigned_admin_id` = t7.`id`
                                    LEFT JOIN `regulated_application_tracking` AS t9 ON t1.`tracking_status` = t9.`tracking_status`
                                    AND t9.`regulated_application_id` = t1.`id`
                                    WHERE t1.`active` = 1 AND t1.`assigned_admin_id` = $assigned_admin_id ORDER BY t1.`id` DESC");
        return $query;
    }

    function fetch_regulated_application($regulated_application_id)
    {
        $query = $this->db->query("SELECT *, t1.`id` AS 'regulated_application_id', t6.`contact_person` AS 'user_contact_person', t6.`email` AS 'user_email', t6.`company_name` AS 'user_company_name', t7.`contact_person` AS 'assigned_admin_name', t1.`created_at` AS 'regulated_application_date', t1.`updated_at` AS 'last_date_updated'
                                    FROM `regulated_applications` AS t1
                                    LEFT JOIN `users_payment_invoice` AS t2 ON t1.`user_payment_invoice_id` = t2.`id`
                                    LEFT JOIN `product_categories` AS t3 ON t2.`product_category_id` = t3.`id`
                                    LEFT JOIN `product_services` AS t4 ON t3.`product_service_id` = t4.`id`
                                    LEFT JOIN `regulated_status_a` AS t5 ON t1.`tracking_status` = t5.`id`
                                    LEFT JOIN `users` AS t6 ON t2.`user_id` = t6.`id`
                                    LEFT JOIN `users` AS t7 ON t1.`assigned_admin_id` = t7.`id`
                                    WHERE t1.`id` = $regulated_application_id AND t1.`active` = 1");
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

    function fetch_all_admins()
    {
        $query = $this->db->query("SELECT t1.`id`, t1.`company_name`, t1.`company_address`, t1.`city`, t2.`nicename`, t1.`zip_code`, t1.`business_license`, t1.`contact_person`, t1.`contact_number`, t1.`email`, t1.`ior_registered`, t1.`pli`, t1.`paid_product_label`, t1.`updated_by` AS 'last_updated_by_id', t3.`contact_person` AS 'last_updated_by', t1.`updated_at` AS 'last_date_updated'
									FROM `users` AS t1
									LEFT JOIN `countries` AS t2 ON t1.`country` = t2.`id`
									LEFT JOIN `users` AS t3 ON t1.`updated_by` = t3.`id`
									WHERE t1.`active` = 1 AND t1.`super_admin` = 1
									ORDER BY t1.`contact_person` ASC");
        return $query;
    }

    function fetch_all_admins_no_super()
    {
        $query = $this->db->query("SELECT t1.`id` AS 'user_details_id', t1.`company_name`, t1.`company_address`, t1.`city`, t2.`nicename`, t1.`zip_code`, t1.`business_license`, t1.`contact_person`, t1.`contact_number`, t1.`email`, t1.`ior_registered`, t1.`pli`, t1.`paid_product_label`, t1.`updated_by` AS 'last_updated_by_id', t3.`contact_person` AS 'last_updated_by', t1.`updated_at` AS 'last_date_updated'
									FROM `users` AS t1
									LEFT JOIN `countries` AS t2 ON t1.`country` = t2.`id`
									LEFT JOIN `users` AS t3 ON t1.`updated_by` = t3.`id`
									WHERE t1.`active` = 1 AND t1.`super_admin` = 1 AND t1.`id` != 1
									ORDER BY t1.`contact_person` ASC");
        return $query;
    }

    function update_assigned_admin($regulated_application_id, $assigned_admin_id, $updated_by, $updated_at)
    {
        $this->db->query("UPDATE `regulated_applications` SET `assigned_admin_id` = $assigned_admin_id, `updated_by` = '$updated_by', `updated_at` = '$updated_at' WHERE `id` = $regulated_application_id");
        return $this->db->affected_rows() > 0;
    }

    function insert_confirm_status($id, $tracking_status, $stepcount, $date, $updated_at, $updated_by)
    {
        $tracking_step =  $stepcount + 1;
        $this->db->query("INSERT into regulated_application_tracking (`regulated_application_id` ,`tracking_status`,`date`, `approve_status`,`tracking_steps`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
        VALUES ('$id', '$tracking_status', '$date', 4, '$tracking_step', '$updated_by', '$updated_by', '$updated_at', '$updated_at')");
    }

    function cancel_tracking_status($id, $tracking_status)
    {
        $this->db->query("DELETE from regulated_application_tracking where regulated_application_id = '$id' and tracking_status='$tracking_status'");
    }

    function update_regulated_application_status($product_category_id, $regulated_application_id, $tracking_status, $stepcount, $date, $updated_at, $updated_by)
    {
        $tracking_current_status = $tracking_status;
        $tracking_step =  $stepcount + 1;
        if ($tracking_status != '7') {
            $this->db->query("UPDATE `regulated_applications` SET `tracking_status` = $tracking_current_status, `tracking_steps` = '$tracking_step' , `updated_by` = '$updated_by', `updated_at` = '$updated_at' 
                            WHERE `id` = $regulated_application_id");
        }

        $this->db->query("UPDATE `regulated_application_tracking` SET `approve_status` = 1,  `updated_by` = '$updated_by', `updated_at` = '$updated_at' 
                            WHERE `regulated_application_id` = $regulated_application_id and tracking_status = '$tracking_status'");

        // if ($tracking_status != '7') {
        //     $this->db->query("INSERT into regulated_application_tracking (`regulated_application_id` ,`tracking_status`,`date`, `approve_status`,`tracking_steps`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
        //                         VALUES ('$regulated_application_id', '$tracking_current_status', '$date', 1, '$tracking_step', '$updated_by', '$updated_by', '$updated_at', '$updated_at')");
        // }

        if ($tracking_status == 7) {

            $this->db->query("UPDATE `regulated_applications` SET `tracking_status` = $tracking_current_status, `updated_by` = '$updated_by', `updated_at` = '$updated_at' 
            WHERE `id` = $regulated_application_id");

            //$this->db->query("INSERT into regulated_application_tracking (`regulated_application_id` ,`tracking_status`,`date`, `approve_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
            //VALUES ('$regulated_application_id', '$tracking_current_status', '$date', 1, '$updated_by', '$updated_by', '$updated_at', '$updated_at')");

            $this->db->query("UPDATE `product_registrations` SET `application_status` = 1 WHERE `regulated_application_id` = $regulated_application_id");
        }

        return $this->db->insert_id();
    }


    function update_regulated_application_remarks($regulated_application_id, $remarks, $tracking_status, $updated_at)
    {
        $this->db->query("UPDATE `regulated_application_tracking` SET `remarks_status`='$remarks' , `remarks_at`='$updated_at', `updated_at`='$updated_at' 
                            WHERE `regulated_application_id` = $regulated_application_id and `tracking_status`='$tracking_status'");
        return $this->db->affected_rows() > 0;
    }

    function fetch_all_regulated_status_a()
    {
        $query = $this->db->query("SELECT * FROM `regulated_status_a` ORDER by `id` ASC");
        return $query;
    }

    function fetch_all_regulated_status_b()
    {
        $query = $this->db->query("SELECT * FROM `regulated_status_b` ORDER by `id` ASC");
        return $query;
    }

    function fetch_tracking_status($id)
    {
        $query = $this->db->query("SELECT * FROM `regulated_application_tracking` AS t1
                                    LEFT JOIN `regulated_tracking_status` AS t2 ON t1.`tracking_status` = t2.`id`
                                    WHERE t1.`id` = $id");
        return $query;
    }

    function fetch_regulated_track_status_a($data)
    {
        $query = $this->db->query("SELECT t1.`id` AS 'regulated_status_id', t1.`tracking_status_name`, t2.`approve_status`, t2.`remarks_status` as 'remarks' , t2.`tracking_status`, t2.`regulated_application_id`, t2.`id` as r_id, t3.`tracking_status_label`, t2.`created_at`, t2.`updated_at`
                                   FROM regulated_status_a as t1 
                                   LEFT JOIN regulated_application_tracking as t2 
                                   ON t1.`id` = t2.`tracking_status`
                                   AND t2.`regulated_application_id` = $data
                                   OR t2.`tracking_status` IS NULL
                                   LEFT JOIN regulated_tracking_status as t3 ON t2.`approve_status` = t3.`id`
                                   ");
        return $query;
    }

    // function fetch_regulated_track_status_a($data)
    // {
    //     $query = $this->db->query("SELECT t1.`id` AS 'regulated_status_id', t1.`tracking_status_name`, t2.`approve_status`, t2.`remarks_status` as 'remarks' , t2.`tracking_status`, t2.`regulated_application_id`, t2.`id` as r_id, t3.`tracking_status_label`, t2.`created_at`, t2.`updated_at` 
    //     FROM regulated_status_a as t1 
    //     LEFT JOIN regulated_application_tracking as t2 ON t1.`id` = t2.`tracking_status` 
    //     LEFT JOIN regulated_tracking_status as t3 ON t2.`approve_status` = t3.`id` 
    //     WHERE t2.`regulated_application_id` = $data ORDER BY t1.`id` ASC");
    //     return $query;
    // }


    function fetch_regulated_status_a($data)
    {
        $query = $this->db->query("SELECT  t1.`id` AS 'regulated_status_id',t1.`tracking_status_name`,t2.`tracking_status`, t2.`approve_status` ,  t2.`id` as r_id , t2.`regulated_application_id` 
                                   FROM regulated_status_a as t1
                                   LEFT JOIN regulated_application_tracking as t2 ON t1.`id` = t2.`tracking_status`
                                   AND t2.`regulated_application_id` = $data OR t2.`tracking_status` IS NULL
                                   ORDER BY t1.`id` ASC  ");
        return $query;
    }

    function fetch_regulated_track_status_b($data)
    {
        $query = $this->db->query("SELECT t1.`id` AS 'regulated_status_id', t1.`tracking_status_name`, t2.`approve_status`, t2.`remarks_status` as remarks , t2.`tracking_status`, t2.`regulated_application_id`, t2.`id` as r_id, t3.`tracking_status_label`, t2.`created_at`, t2.`updated_at`
                                    FROM regulated_status_b as t1 
                                    LEFT JOIN regulated_application_tracking as t2 ON t1.`id` = t2.`tracking_status`
                                    LEFT JOIN regulated_tracking_status as t3 ON t2.`approve_status` = t3.`id`
                                    WHERE t2.`tracking_status` IS NULL OR t2.`regulated_application_id` = $data ORDER BY t1.`id` ASC");
        return $query;
    }

    function fetch_manufacturer_details($regulated_application_id)
    {
        $query = $this->db->query("SELECT * FROM `regulated_manufacturer_details_a`
                                    WHERE `regulated_application_id` = $regulated_application_id");
        return $query;
    }

    function fetch_regulated_products($regulated_application_id)
    {
        $query = $this->db->query("SELECT *, t1.`id` AS 'product_registration_id', t3.`id` AS 'product_registration_status_id' 
                    FROM `product_registrations` AS t1
                    LEFT JOIN `regulated_products_a` AS t2 ON t1.`id` = t2.`product_registration_id`
                    LEFT JOIN `product_registration_status` AS t3 ON t1.`status` = t3.`id`
                    WHERE t1.`regulated_application_id` = $regulated_application_id AND t1.`active` = 1
                    ORDER BY t1.`id` DESC");
        return $query;
    }

    function fetch_regulated_products_sampling($product_registration_id)
    {
        $query = $this->db->query("SELECT * FROM `shipping_invoice_products` AS t1
                                    LEFT JOIN `shipping_invoices` AS t2 ON t2.`id` = t1.`shipping_invoice_id`
                                    WHERE t1.`product_registration_id` = $product_registration_id AND t1.`active` = 1 AND t1.`product_sample` = 1 
                                    ORDER BY t1.`id` DESC");
        return $query;
    }

    function fetch_regulated_products_revisions($regulated_application_id)
    {
        $query = $this->db->query("SELECT *, t1.`id` AS 'product_registration_id', t3.`id` AS 'product_registration_status_id' 
                    FROM `product_registrations` AS t1
                    LEFT JOIN `regulated_products_a` AS t2 ON t1.`id` = t2.`product_registration_id`
                    LEFT JOIN `product_registration_status` AS t3 ON t1.`status` = t3.`id`
                    WHERE t1.`regulated_application_id` = $regulated_application_id AND t1.`active` = 1 AND t1.`status` = 3 
                    ORDER BY t1.`id` DESC");
        return $query;
    }

    function fetch_regulated_product_by_id($regulated_product_id)
    {
        $query = $this->db->query("SELECT *, t1.`id` AS 'product_registration_id', t3.`id` AS 'product_registration_status_id' 
                    FROM `product_registrations` AS t1
                    LEFT JOIN `regulated_products_a` AS t2 ON t1.`id` = t2.`product_registration_id`
                    LEFT JOIN `product_registration_status` AS t3 ON t1.`status` = t3.`id`
                    WHERE t1.`id` = $regulated_product_id AND t1.`active` = 1
                    ORDER BY t1.`id` DESC");
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

    function delete_regulated_product($id, $updated_at, $updated_by)
    {
        $this->db->query("UPDATE `product_registrations` SET `active` = 0, `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `id` = $id");
        return $this->db->affected_rows() > 0;
    }

    function insert_product_label($regulated_product_id, $product_label, $created_by, $created_at)
    {
        $this->db->query(" UPDATE product_registrations 
                       SET 
                 `product_label`       = IF('$product_label' = '' OR '$product_label' IS NULL,product_registrations.product_label,'$product_label') 
                 
                    WHERE `id` = '" . $regulated_product_id . "' ");

        return $this->db->affected_rows();
    }

    function remove_product_label($regulated_product_id, $updated_at, $updated_by)
    {
        $this->db->query("UPDATE `product_registrations` SET `product_label` = '', `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE 
            `id` = $regulated_product_id");
        return $this->db->affected_rows();
    }

    function insert_lab_testing_details($lab_testing_file, $regulated_application_id, $created_by, $created_at)
    {
        $this->db->query("INSERT INTO `lab_test_results`(`regulated_application_id`, `lab_test_filename`, `created_by`, `created_at`) 
                            VALUES ('$regulated_application_id', '$lab_testing_file', '$created_by', '$created_at')");
        return $this->db->affected_rows() > 0;
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
                     `manufacturer_name`         = Coalesce('$manufacturer_name',regulated_manufacturer_details_a.manufacturer_name) , 
                     `manufacturer_address`      = Coalesce('$manufacturer_address',regulated_manufacturer_details_a.manufacturer_address) ,
                     `manufacturer_city`         = Coalesce('$manufacturer_city',regulated_manufacturer_details_a.manufacturer_city) ,
                     `manufacturer_country`      = Coalesce('$manufacturer_country',regulated_manufacturer_details_a.manufacturer_country) ,
                     `manufacturer_zipcode`      = Coalesce('$manufacturer_zipcode',regulated_manufacturer_details_a.manufacturer_zipcode) ,
                     `manufacturer_contact`      = Coalesce('$manufacturer_contact',regulated_manufacturer_details_a.manufacturer_contact) ,
                     `manufacturer_website`      = Coalesce('$manufacturer_website',regulated_manufacturer_details_a.manufacturer_website) ,
                     `manufacturer_flow_process` = IF('$manufacturer_flow_process' = '' OR '$manufacturer_flow_process' IS NULL,regulated_manufacturer_details_a.manufacturer_flow_process,'$manufacturer_flow_process') 
                     
                        WHERE `regulated_application_id` = '" . $regulated_application_id . "' ");

        return $this->db->affected_rows();
    }

    function update_regulated_product($product_registration_id, $sku, $product_name, $product_img, $updated_by, $updated_at)
    {
        $this->db->query(" UPDATE product_registrations 
                       SET 
                     `sku`            = Coalesce('$sku',product_registrations.sku) , 
                     `product_name`   = Coalesce('$product_name',product_registrations.product_name) ,
                     `product_img`    = IF('$product_img' = '' OR '$product_img' IS NULL,product_registrations.product_img,'$product_img'),
                     `updated_by`     = Coalesce('$updated_by',product_registrations.updated_by),
                     `updated_at`     = Coalesce('$updated_at',product_registrations.updated_at)
                     
                        WHERE `id` = '" . $product_registration_id . "' ");

        return $this->db->affected_rows();
    }

    function update_regulated_product_one($product_registration_id, $ingredients_formula, $product_use_and_info, $outerbox_frontside, $outerbox_backside, $volume_weight, $consumer_product_packaging_img, $approx_size_of_package)
    {
        $this->db->query(" UPDATE regulated_products_a 
                       SET 
                     `product_use_and_info`           = Coalesce('$product_use_and_info',regulated_products_a.product_use_and_info) , 
                     `volume_weight`                  = Coalesce('$volume_weight',regulated_products_a.volume_weight) ,
                     `approx_size_of_package`         = Coalesce('$approx_size_of_package',regulated_products_a.approx_size_of_package) ,
                     `ingredients_formula`            = IF('$ingredients_formula' = '' OR '$ingredients_formula' IS NULL,regulated_products_a.ingredients_formula,'$ingredients_formula'),
                     `consumer_product_packaging_img` = IF('$consumer_product_packaging_img' = '' OR '$consumer_product_packaging_img' IS NULL,regulated_products_a.consumer_product_packaging_img,'$consumer_product_packaging_img'),
                     `outerbox_frontside` = IF('$outerbox_frontside' = '' OR '$outerbox_frontside' IS NULL,regulated_products_a.outerbox_frontside,'$outerbox_frontside'),
                     `outerbox_backside` = IF('$outerbox_backside' = '' OR '$outerbox_backside' IS NULL,regulated_products_a.outerbox_backside,'$outerbox_backside')
                     
                        WHERE `product_registration_id` = '" . $product_registration_id . "' ");

        return $this->db->affected_rows();
    }

    function update_regulated_product_one_cust($reg_prod_cut_id, $detail_value)
    {
        $this->db->query(" UPDATE regulated_product_custom_details 
                       SET 
                     `detail_value`           =  '" . $detail_value . "'
                     
                        WHERE `id` = '" . $reg_prod_cut_id . "' ");

        return $this->db->affected_rows();
    }

    function approve_pre_import($id, $updated_at, $updated_by)
    {
        $date_today = date('Y-m-d');
        $this->db->query("UPDATE `regulated_applications` SET `tracking_status` = 1, `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `id` = $id");
        $this->db->query("UPDATE `regulated_application_tracking` SET `approve_status` = 1, `tracking_steps`=1, `remarks_status` = '', `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `regulated_application_id` = $id AND `tracking_status` = 1");
        //$this->db->query("INSERT into regulated_application_tracking (`regulated_application_id` ,`tracking_status`,`date`, `approve_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES ($id, 2, '$date_today', 4, '$updated_by', '$updated_by', '$updated_at', '$updated_at')");
        return $this->db->affected_rows() > 0;
    }

    function check_approved_reg_prod($regulated_application_id)
    {
        $query = $this->db->query("SELECT * FROM `product_registrations` WHERE `regulated_application_id` = $regulated_application_id AND status = 1");
        return $query->num_rows();
    }

    function decline_pre_import($id, $remarks, $updated_at, $updated_by)
    {
        $this->db->query("UPDATE `regulated_application_tracking` SET `approve_status` = 2, `remarks_status` = '$remarks', `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `regulated_application_id` = $id AND `tracking_status` = 1");
        return $this->db->affected_rows() > 0;
    }

    function revision_pre_import($id, $remarks, $updated_at, $updated_by)
    {
        $this->db->query("UPDATE `regulated_application_tracking` SET `approve_status` = 3, `remarks_status` = '$remarks', `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `regulated_application_id` = $id AND `tracking_status` = 1");
        return $this->db->affected_rows() > 0;
    }

    function cancel_pre_import($id, $updated_at, $updated_by)
    {
        $this->db->query("UPDATE `regulated_application_tracking` SET `approve_status` = 5, `remarks_status` = '', `updated_at` = '$updated_at', `updated_by` = '$updated_by' WHERE `regulated_application_id` = $id");
        return $this->db->affected_rows() > 0;
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

    function add_custom_field($data)
    {
        $this->db->query("INSERT into regulated_product_custom_details (`regulated_product_id` ,`detail_name`,`detail_type`) 
                                VALUES ('" . $data['regulated_product_id'] . "', '" . $data['name'] . "', '" . $data['type'] . "')");
        $this->db->query("UPDATE `product_registrations` SET `status` = 4 WHERE `id` = '" . $data['product_registration_id'] . "'");
    }

    function remove_custom_field($data)
    {
        $this->db->query("DELETE FROM regulated_product_custom_details WHERE id = '" . $data['id'] . "'");
    }
}
