<?php foreach ($posts as $key => $p) : ?>
    <div class="card post">

        <div class="card-header bg-danger">
            <?php if ($this->session->userdata("id") != null): ?>
                <i class="fa fa-2x <?php echo ($p->group_user_post_id != null) ? "fa-heart" : "fa-heart-o" ?> favorite-post" data-id="<?php echo $p->post_id ?>"></i>
            <?php endif; ?>
        </div>
        <a href="<?php echo base_url() . 'blog/' . $p->c_url_clean . '/' . $p->url_clean ?>">
            <div class="card-body">
                <img src="<?php echo image_post($p->post_id) ?>">
                <h3><?php echo $p->title ?></h3>
                <p><?php echo $p->description ?></p>
            </div>
        </a>
    </div>
    <br>
<?php endforeach; ?>

<?php
if ($pagination):

    $prev = $current_page - 1;
    $next = $current_page + 1;

    if ($prev < 1)
        $prev = 1;

    if ($next > $last_page)
        $next = $last_page;
    ?>

    <ul class="pagination">
        <li class="page-item"><a class="page-link" href = "<?php echo base_url() . $token_url . $prev ?>">Prev</a></li>

        <?php for ($i = 1; $i <= $last_page; $i++) { ?>
            <li class="page-link"><a href ="<?php echo base_url() . $token_url . $i; ?> "> <?php echo $i; ?></a></li>
        <?php } ?>

        <?php if ($current_page != $next) { ?>
            <li class="page-link"><a class="next-link" href = "<?php echo base_url() . $token_url . $next; ?> ">Sig</a></li>
            <?php } ?>
    </ul>
<?php endif; ?>
