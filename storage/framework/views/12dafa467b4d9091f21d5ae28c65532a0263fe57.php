<?php $__env->startSection('content'); ?>

<?php
    //echo($this);
?>

<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?php echo $categoryCount; ?></h3>
                <p><?php echo trans('backend::dashboard.categories') ?></p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?php echo $pageCount; ?></h3>
                <p><?php echo trans('backend::dashboard.pages') ?></p>
            </div>
            <div class="icon">
                <i class="ion ion-record"></i>
            </div>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?php echo $articleCount; ?></h3>
                <p><?php echo trans('backend::dashboard.articles') ?></p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-list"></i>
            </div>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?php echo $adminUserCount; ?></h3>
                <p><?php echo trans('backend::dashboard.admins') ?></p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
        </div>
    </div><!-- ./col -->
</div><!-- /.row -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>