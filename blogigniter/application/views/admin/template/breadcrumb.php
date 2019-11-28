<ol class="breadcrumb">
    <?php foreach ($breadcrumb as $key => $li) : ?>
        <li><a href="<?php echo base_url() . $li[0] ?>"> <?php echo $li[1] ?></a></li>
    <?php endforeach ?>
</ol>