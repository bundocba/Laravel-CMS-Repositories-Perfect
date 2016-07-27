<?php
    //echo $this;
    if ($data['breadcrumbs']) {
        $breadcrumbs = $data['breadcrumbs']->reverse();
    } else {
        $breadcrumbs = [];
    }
    //echo count($breadcrumbs);
?>
<ol class="breadcrumb push-10-t">
    <?php foreach ($breadcrumbs as $breadcrumb) : ?>
    <?php if ($breadcrumb->url != '') : ?>
        <li><a class="link-effect" href="<?php echo url('/') . '/' . $data['prefix'] . $breadcrumb->url; ?>"><?php echo trans($breadcrumb->title); ?></a></li>
    <?php else : ?>
        <li><a class="link-effect"><?php echo trans($breadcrumb->title); ?></a></li>
    <?php endif; ?>
    <?php endforeach; ?>
</ol>
<?php
    //var_dump($breadcrumbs);
?>