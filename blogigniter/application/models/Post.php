<?php

class Post extends MY_Model {

    public $table = "posts";
    public $table_id = "post_id";

    function get_pagination($offset = 0, $posted = 'Si', $order = 'desc', $c_url_clean = null) {

        $this->db->select('p.*, c.url_clean as c_url_clean, c.name as category, gup.group_user_post_id');
        $this->db->from("$this->table as p");
        $this->db->join("categories as c", "c.category_id = p.category_id");
        if ($this->session->userdata("id") == null)
            $this->db->join("group_user_posts as gup", "p.post_id = gup.post_id", 'left');
        else
            $this->db->join("group_user_posts as gup", "p.post_id = gup.post_id AND gup.user_id = " . $this->session->userdata("id"), 'left');
        $this->db->where("posted", $posted);
        if (isset($c_url_clean))
            $this->db->where("c.url_clean", $c_url_clean);
        $this->db->order_by("created_at", $order);
        $this->db->limit(PAGE_SIZE, $offset);
        $query = $this->db->get();

        return $query->result();
    }

    function GetByUrlClean($url_clean, $posted = 'Si') {

        $this->db->select('p.*, c.url_clean as c_url_clean, c.name as category');
        $this->db->from("$this->table as p");
        $this->db->join("categories as c", "c.category_id = p.category_id");
        $this->db->where("posted", $posted);
        $this->db->where("p.url_clean", $url_clean);

        $query = $this->db->get();

        return $query->row();
    }

    function countByCUrlClean($c_url_clean, $posted = 'Si') {

        $this->db->select('COUNT(p.post_id) as count');
        $this->db->from("$this->table as p");
        $this->db->join("categories as c", "c.category_id = p.category_id");
        $this->db->where("posted", $posted);
        $this->db->where("c.url_clean", $c_url_clean);
        $query = $this->db->get();
        return $query->row()->count;
    }

    function getBySearch($searchs, $category_id = null, $posted = 'Si', $order = 'desc') {
        $this->db->select('p.*, c.url_clean as c_url_clean, c.name as category, gup.group_user_post_id');
        $this->db->from("$this->table as p");
        $this->db->join("categories as c", "c.category_id = p.category_id");
        if ($this->session->userdata("id") == null)
            $this->db->join("group_user_posts as gup", "p.post_id = gup.post_id", 'left');
        else
            $this->db->join("group_user_posts as gup", "p.post_id = gup.post_id AND gup.user_id = " . $this->session->userdata("id"), 'left');
        $this->db->where("posted", $posted);

        foreach ($searchs as $key => $search) {
            $this->db->like('p.title', $search);
        }

        if ($category_id != null && $category_id != "")
            $this->db->where("c.category_id", $category_id);

        $this->db->order_by("created_at", $order);
        $query = $this->db->get();

        return $query->result();
    }

    function getGUP($user_id, $posted = 'Si', $order = 'desc') {
        $this->db->select('p.*, c.url_clean as c_url_clean, c.name as category, gup.group_user_post_id');
        $this->db->from("$this->table as p");
        $this->db->join("categories as c", "c.category_id = p.category_id");
        $this->db->join("group_user_posts as gup", "p.post_id = gup.post_id", 'left');
        $this->db->where("posted", $posted);
        $this->db->where('gup.user_id', $user_id);

        $this->db->order_by("created_at", $order);
        $query = $this->db->get();

        return $query->result();
    }

}
