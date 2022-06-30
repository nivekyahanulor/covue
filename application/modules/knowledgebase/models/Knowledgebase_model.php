<?php
date_default_timezone_set("Asia/Tokyo");

class Knowledgebase_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function fetch_knowledgebase_products()
    {
        $query = $this->db->query("SELECT *, t1.`id` AS knowledgebase_id FROM `knowledgebase` AS t1
                                    LEFT JOIN `product_categories` AS t2 ON t1.`product_category_id` = t2.`id`
                                    LEFT JOIN `users` AS t3 ON t1.`updated_by` = t3.`id`
                                    WHERE t1.`active` = 1");
        return $query;
    }

    function fetch_product_categories()
    {
        $query = $this->db->query("SELECT * FROM `product_categories` WHERE `active` = 1 ORDER BY `category_name` ASC");
        return $query;
    }

    function insert_knowledgebase_product($product, $product_url, $product_category_id, $laws_req_docs, $contact_info, $comments, $created_by, $created_at)
    {
        $this->db->query("INSERT INTO `knowledgebase`(`product`, `product_url`, `product_category_id`, `laws_req_docs`, `contact_info`, `comments`, `active`, `created_by`, `created_at`) 
                            VALUES ('$product','$product_url',$product_category_id,'$laws_req_docs','$contact_info','$comments',1,$created_by,'$created_at')");
        return $this->db->affected_rows() > 0;
    }

    function fetch_knowledgebase_product($id)
    {
        $query = $this->db->query("SELECT *, t1.`id` AS knowledgebase_id FROM `knowledgebase` AS t1
                                    LEFT JOIN `product_categories` AS t2 ON t1.`product_category_id` = t2.`id`
                                    LEFT JOIN `users` AS t3 ON t1.`updated_by` = t3.`id`
                                    WHERE t1.`active` = 1 AND t1.`id` = $id");
        return $query;
    }

    function update_knowledgebase_product($id, $product, $product_url, $product_category_id, $laws_req_docs, $contact_info, $comments, $updated_by, $updated_at)
    {
        $this->db->query("UPDATE `knowledgebase` SET `product`='$product',`product_url`='$product_url',`product_category_id`='$product_category_id',`laws_req_docs`='$laws_req_docs',`contact_info`='$contact_info',`comments`='$comments',`updated_by`='$updated_by',`updated_at`='$updated_at' 
                            WHERE `id` = $id");
        return $this->db->affected_rows() > 0;
    }

    function delete_knowledgebase_product($id, $updated_by, $updated_at)
    {
        $this->db->query("UPDATE `knowledgebase` SET `active` = 0,`updated_by`='$updated_by',`updated_at`='$updated_at' WHERE `id` = '$id'");
        return $this->db->affected_rows() > 0;
    }
}
