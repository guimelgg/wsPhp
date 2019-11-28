<div class="card">
    <div class="card-header">
        <img src="<?php echo image_post($post->post_id) ?>">
    </div>
    <div class="card-body">
        <h1><?php echo $post->title ?></h1>
        <?php echo $post->content ?>
        <a class="btn btn-danger" href="<?php echo base_url() ?>blog/category/<?php echo $post->c_url_clean ?>"><?php echo $post->category ?></a>

        <?php
        if ($this->session->userdata("id") !== null)
            $this->load->view("blog/utils/comment", ['post_id' => $post->post_id]);
        ?>

    </div>
</div>