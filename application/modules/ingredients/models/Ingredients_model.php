<?php
date_default_timezone_set("Asia/Tokyo");

class Ingredients_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function fetch_ingredients()
    {
        $query = $this->db->query("SELECT * FROM `ingredients_list` ORDER BY `id`");
        return $query;
    }
}
