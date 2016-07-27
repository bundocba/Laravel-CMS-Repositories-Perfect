<?php
    $breadcrumbs = $data['breadcrumbs'];

    //var_dump($breadcrumbs);

    $output = '';
    $index = 0;
    if ($breadcrumbs) {
        foreach ($breadcrumbs as $item) {
            if ($index > 0) {
                $output = ' > <a href="' . $item->alias . '">' . $item->name . '</a> ' . $output;
            } else {
                $output = ' > <a href="' . $item->alias . '">' . $item->name . '</a> ' . $output;
            }
            $index++;
            //echo $item->slug;
        }
    }
?>
<ol class="breadcrumb push-10-t">
    <li><a href="<?php echo url($data['lang'] . '/') ?>"><?php echo trans('frontend::global.home') ?></a></li>
    <?php echo $output ?>
</ol>
