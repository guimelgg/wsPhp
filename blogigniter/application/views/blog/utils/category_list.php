<?php foreach ($categories as $key => $c) : ?>
    <a class="dropdown-item" href="#" data-id="<?php echo $c->category_id ?>">
        <?php echo $c->name ?>
    </a>
<?php endforeach; ?>
