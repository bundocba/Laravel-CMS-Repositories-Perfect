<?php
    //var_dump($loggedInAdmin);
?>

<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <img src="<?php echo e(asset('assets/backend/img/photo.png')); ?>" class="user-image" alt="User Image">
        <span class="hidden-xs"><?php echo $loggedInAdmin->name; ?></span>
    </a>
    <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header">
            <img src="<?php echo e(asset('assets/backend/img/photo.png')); ?>" class="img-circle" alt="User Image">
            <p>
                <?php echo $loggedInAdmin->name; ?> - <?php echo $loggedInAdmin->role_name; ?>
                <small></small>
            </p>
        </li>
        <!-- Menu Body -->
        <!-- Menu Footer-->
        <li class="user-footer">
            <div class="pull-left">
                <!--
                <a href="<?php echo url($data['prefix'] . '/account/changepassword'); ?>" class="btn btn-default btn-flat">Change password</a>
                -->
            </div>

            <div class="pull-right">
                <a href="<?php echo url($data['prefix'] . '/auth/logout'); ?>" class="btn btn-default btn-flat"><?php echo trans('backend::global.signout') ?></a>
            </div>
        </li>
    </ul>
</li>