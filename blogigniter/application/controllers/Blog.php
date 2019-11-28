<?php

class Blog extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->optional_session_auto(1);
    }

    public function index($num_page = 1) {

        $num_page--;
        $num_post = $this->Post->count();
        $last_page = ceil($num_post / PAGE_SIZE);

        if ($num_page < 0) {
            $num_page = 0;
        } elseif ($num_page > $last_page) {
            // TODO
            $num_page = 0;
        }

        $offset = $num_page * PAGE_SIZE;

        $data['last_page'] = $last_page;
        $data['current_page'] = $num_page;
        $data['token_url'] = 'blog/';
        $data['posts'] = $this->Post->get_pagination($offset);
        $data['last_page'] = $last_page;
        $data['pagination'] = true;
        $view['body'] = $this->load->view("blog/utils/post_list", $data, TRUE);
        $this->parser->parse("blog/template/body", $view);
    }

    public function category($c_clean_url, $num_page = 1) {

        $category = $this->Category->GetByUrlClean($c_clean_url);

        if (!isset($category)) {
            show_404();
        }

        $num_page--;
        $num_post = $this->Post->countByCUrlClean($c_clean_url);
        $last_page = ceil($num_post / PAGE_SIZE);

        if ($num_page < 0 || $num_page > $last_page) {
            redirect('/blog/category' . $c_clean_url);
        }

        $offset = $num_page * PAGE_SIZE;

        $data['last_page'] = $last_page;
        $data['current_page'] = $num_page;
        $data['token_url'] = 'blog/category/' . $c_clean_url . '/';
        $data['posts'] = $this->Post->get_pagination($offset, 'Si', 'desc', $c_clean_url);
        $data['last_page'] = $last_page;
        $data['pagination'] = true;
        $view['body'] = $this->load->view("blog/utils/post_list", $data, TRUE);
        $this->parser->parse("blog/template/body", $view);
    }

    public function post_view($c_clean_url, $clean_url = null) {

        if (strpos($this->uri->uri_string(), 'blog/post_view') !== false)
            show_404();

        if (!isset($clean_url)) {
            show_404();
        }

        $post = $this->Post->GetByUrlClean($clean_url);

        if (!isset($post)) {
            show_404();
        }

        $category = $this->Category->GetByUrlClean($c_clean_url);

        if (!isset($category)) {
            show_404();
        }

        $data['post'] = $post;
        $view['body'] = $this->load->view("blog/utils/post_detail", $data, TRUE);
        $this->parser->parse("blog/template/body", $view);
    }

    public function search() {

        $search = $this->input->get_post("search");
        $category_id = $this->input->get_post("category_id");

        if ($search == "") {
            return "";
        }

        $searchs = explode(" ", $search);
        $posts = $this->Post->getBySearch($searchs, $category_id);
        $data['posts'] = $posts;
        $data['pagination'] = false;
        $this->load->view("blog/utils/post_list", $data);
    }

    /* Favorite */

    public function favorite_save($post_id) {

        $this->load->model('Group_user_post');

        if ($this->session->userdata("id") != null) {
            $save = array('user_id' => $this->session->userdata("id"), 'post_id' => $post_id);
            $this->Group_user_post->insert($save);
            echo $post_id;
        } else
            echo 0;
    }

    public function favorite_delete($post_id) {
        $this->load->model('Group_user_post');

        if ($this->session->userdata("id") != null) {
            $this->Group_user_post->deleteByPostIdAndUserId($post_id, $this->session->userdata("id"));
            echo $post_id;
        } else
            echo 0;
    }

    public function favorite_list() {
        $this->load->model('Group_user_post');

        if ($this->session->userdata("id") == null) {
            show_404();
        }

        $posts = $this->Post->getGUP($this->session->userdata("id"));
        $data['posts'] = $posts;
        $data['pagination'] = false;
        $view['body'] = $this->load->view("blog/utils/post_list", $data, TRUE);
        $this->parser->parse("blog/template/body", $view);
    }

}
