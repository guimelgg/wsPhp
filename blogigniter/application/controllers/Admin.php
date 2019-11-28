<?php

class Admin extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('Form_validation');
        $this->load->library('grocery_CRUD');

        $this->load->helper('form');
        $this->load->helper('Breadcrumb_helper');

        $this->init_session_auto(9);
    }

    public function index() {
        redirect('admin/post_list');
    }

    public function user_crud() {
        $crud = new grocery_CRUD();

//        $crud->set_theme('datatables');
        $crud->set_table('users');
        $crud->set_subject('Usuario');

        $crud->where("auth_level", 9);

        $state = $crud->getState();

        $crud->columns('username', 'email', 'avatar');

        // editando el registro
        if ($state == 'edit' || $state == 'update' || $state == 'update_validation') {
            $crud->fields('auth_level', 'created_at', 'user_id', 'avatar');
        } else {
            $crud->fields('auth_level', 'created_at', 'user_id', 'username', 'email', 'passwd', 'avatar');
            $crud->set_rules('email', 'email', 'required|valid_email|is_unique[' . config_item('user_table') . '.email]');
            $crud->set_rules('username', 'Usuario', 'max_length[50]|is_unique[' . config_item('user_table') . '.username]|required');
            $crud->set_rules('passwd', 'Contraseña', 'min_length[8]|required|max_length[72]|callback_validate_passwd');
        }

        $crud->callback_before_insert(array($this, 'user_before_insert_callback'));
        $crud->callback_after_upload(array($this, 'user_after_upload_callback'));

        $crud->display_as('passwd', 'Contraseña');
        $crud->display_as('username', 'Usuario');

        $crud->field_type('auth_level', 'hidden');
        $crud->field_type('created_at', 'hidden');
        $crud->field_type('user_id', 'hidden');
        $crud->field_type('passwd', 'password');
        $crud->set_field_upload('avatar', 'uploads/user', 'png|jpg');

        $crud->unset_jquery();
        $crud->unset_clone();
        $crud->unset_read();

        $output = $crud->render();
        $view["grocery_crud"] = json_encode($output);
        $view['breadcrumb'] = breadcrumb_admin("users");
        $view["title"] = "Usuario";
        $this->parser->parse("admin/template/body", $view);
    }

    /*     * ***
     * CRUD PARA LOS POST
     */

    public function post_list() {
        // $data["posts"] = $this->Post->findAll();
        //$view["body"] = $this->load->view("admin/post/list", $data, TRUE);

        $crud = new grocery_CRUD();

        $crud->set_table('posts');
        $crud->set_subject('Post');
        $crud->columns('title', 'description', 'created_at', 'image', 'posted');

        $crud->callback_before_insert(array($this, 'category_iu_before_callback'));
        $crud->callback_before_update(array($this, 'category_iu_before_callback'));

        $crud->set_rules('name', 'Nombre', 'required|min_length[10]|max_length[100]');

        $crud->unset_jquery();
        $crud->unset_add();
        $crud->unset_clone();
        $crud->unset_read();
        $crud->unset_edit();

        $crud->add_action('Editar', '', 'admin/post_save', 'edit-icon');

        $output = $crud->render();
        $view["grocery_crud"] = json_encode($output);
        $view['breadcrumb'] = breadcrumb_admin("posts");
        $view["title"] = "Posts";
        $this->parser->parse("admin/template/body", $view);
    }

    public function post_save($post_id = null) {

        if ($post_id == null) {
            // crear post
            $data['category_id'] = $data['title'] = $data['image'] = $data['content'] = $data['description'] = $data['posted'] = $data['url_clean'] = "";
            $view["title"] = "Crear Post";
        } else {
            // edicion post
            $post = $this->Post->find($post_id);

            if (!isset($post)) {
                show_404();
            }

            $data['title'] = $post->title;
            $data['content'] = $post->content;
            $data['description'] = $post->description;
            $data['posted'] = $post->posted;
            $data['url_clean'] = $post->url_clean;
            $data['image'] = $post->image;
            $data['category_id'] = $post->category_id;
            $view["title"] = "Actualizar Post";
        }

        // para el listado de categorias
        $data['categories'] = categories_to_form($this->Category->findAll());

        if ($this->input->server('REQUEST_METHOD') == "POST") {

            $this->form_validation->set_rules('title', 'Título', 'required|min_length[10]|max_length[65]');
            $this->form_validation->set_rules('content', 'Contenido', 'required|min_length[10]');
            $this->form_validation->set_rules('description', 'Descripción', 'max_length[100]');
            $this->form_validation->set_rules('posted', 'Descripción', 'required');

            $data['title'] = $this->input->post("title");
            $data['content'] = $this->input->post("content");
            $data['description'] = $this->input->post("description");
            $data['posted'] = $this->input->post("posted");
            $data['url_clean'] = $this->input->post("url_clean");

            if ($this->form_validation->run()) {
                // nuestro form es valido

                $url_clean = $this->input->post("url_clean");

                if ($url_clean == "") {
                    $url_clean = clean_name($this->input->post("title"));
                }

                $save = array(
                    'title' => $this->input->post("title"),
                    'content' => $this->input->post("content"),
                    'description' => $this->input->post("description"),
                    'posted' => $this->input->post("posted"),
                    'category_id' => $this->input->post("category_id"),
                    'url_clean' => $url_clean
                );

                if ($post_id == null)
                    $post_id = $this->Post->insert($save);
                else
                    $this->Post->update($post_id, $save);

                $this->upload($post_id, $this->input->post("title"));

                redirect("admin/post_save/$post_id");
            }
        }

        $data["data_posted"] = posted();
        $view['breadcrumb'] = breadcrumb_admin("posts");
        $view["body"] = $this->load->view("admin/post/save", $data, TRUE);

        $this->parser->parse("admin/template/body", $view);
    }

    public function post_delete($post_id = null) {
        if ($post_id == null) {
            echo 0;
        } else {
            $this->Post->delete($post_id);
            echo 1;
        }
    }

    /*     * ***
     * CRUD PARA LOS CATEGORY
     */

    public function category_list() {
//        $data["categories"] = $this->Category->findAll();
//        $view["body"] = $this->load->view("admin/category/list", $data, TRUE);
        $crud = new grocery_CRUD();

//        $crud->set_theme('datatables');
        $crud->set_table('categories');
        $crud->set_subject('Categoria');
        $crud->columns('category_id', 'name');

        $crud->callback_before_insert(array($this, 'category_iu_before_callback'));
        $crud->callback_before_update(array($this, 'category_iu_before_callback'));

        $crud->set_rules('name', 'Nombre', 'required|min_length[10]|max_length[100]');

        $crud->unset_jquery();
        $crud->unset_clone();
        $crud->unset_read();

        $output = $crud->render();
        $view["grocery_crud"] = json_encode($output);
        $view['breadcrumb'] = breadcrumb_admin("categories");
        $view["title"] = "Categories";
        $this->parser->parse("admin/template/body", $view);
    }

    public function category_save($category_id = null) {

        if ($category_id == null) {
            // crear category
            $data['name'] = "";
            $data['url_clean'] = "";
            $view["title"] = "Crear Categoria";
        } else {
            // edicion category
            $category = $this->Category->find($category_id);
            $data['name'] = $category->name;
            $data['url_clean'] = $category->url_clean;
            $view["title"] = "Actualizar Categoria";
        }

        if ($this->input->server('REQUEST_METHOD') == "POST") {

            $this->form_validation->set_rules('name', 'Nombre', 'required|min_length[10]|max_length[100]');

            $data['name'] = $this->input->post("name");
            $data['url_clean'] = $this->input->post("url_clean");

            if ($this->form_validation->run()) {
                // nuestro form es valido

                $url_clean = $this->input->post("url_clean");

                if ($url_clean == "") {
                    $url_clean = clean_name($this->input->post("name"));
                }

                $save = array(
                    'name' => $this->input->post("name"),
                    'url_clean' => $url_clean
                );

                if ($category_id == null)
                    $category_id = $this->Category->insert($save);
                else
                    $this->Category->update($category_id, $save);
            }
        }

        $view["body"] = $this->load->view("admin/category/save", $data, TRUE);
        $view['breadcrumb'] = breadcrumb_admin("categories");
        $this->parser->parse("admin/template/body", $view);
    }

    public function category_delete($category_id = null) {
        if ($category_id == null) {
            echo 0;
        } else {
            $this->Category->delete($category_id);
            echo 1;
        }
    }

    function images_server() {
        $data["images"] = all_images();
        $this->load->view("admin/post/image", $data);
    }

    function upload($post_id = null, $title = null) {

        $image = "upload";

        if ($title != null)
            $title = clean_name($title);

        // configuraciones de carga
        $config['upload_path'] = 'uploads/post';
        if ($title != null)
            $config['file_name'] = $title;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 5000;
        $config['overwrite'] = TRUE;

        //cargamos la libreria
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($image)) {
            // se cargo la imagen
            // datos del upload
            $data = $this->upload->data();

            if ($title != null && $post_id != null) {
                $save = array(
                    'image' => $title . $data["file_ext"]
                );
                $this->Post->update($post_id, $save);
            } else {
                $title = $data["file_name"];
                echo json_encode(array("fileName" => $title, "uploaded" => 1, "url" => "/" . PROJECT_FOLDER . "/uploads/post/" . $title));
            }

            $this->resize_image($data['full_path']);
        } else if (!empty($_FILES[$image]['name'])) {
            //echo $this->upload->display_errors();
            $this->session->set_flashdata('text', $this->upload->display_errors());
            $this->session->set_flashdata('type', 'danger');
        }
    }

    function resize_image($path_image) {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $path_image;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 500;
        $config['height'] = 500;

        $this->load->library('image_lib', $config);

        $this->image_lib->resize();
    }

    /*     * *************
      Calback
     * */

    function category_iu_before_callback($post_array, $pk = null) {
        if ($post_array['url_clean'] == "") {
            $post_array['url_clean'] = clean_name($post_array["name"]);
        }

        return $post_array;
    }

    function user_before_insert_callback($post_array) {
        $post_array['passwd'] = $this->authentication->hash_passwd($post_array['passwd']);
        $post_array['user_id'] = $this->User->get_unused_id();
        $post_array['created_at'] = date('Y-m-d H:i:s');
        $post_array['auth_level'] = 9;

        return $post_array;
    }

    function user_after_upload_callback($uploader_response, $field_info, $files_to_upload) {
        $this->load->library('Image_moo');
        //Is only one file uploaded so it ok to use it with $uploader_response[0].
        $file_uploaded = $field_info->upload_path . '/' . $uploader_response[0]->name;
        $this->image_moo->load($file_uploaded)->resize(500, 500)->save($file_uploaded, true);

        return true;
    }

}
