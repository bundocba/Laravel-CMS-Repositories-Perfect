<?php if (!$loggedInUser) : ?>

    <li class="dropdown messages-menu">
        <a href="<?php echo url($data['lang'] . '/user/login'); ?>"><?php echo trans('frontend::global.login'); ?></a>
    </li>
    <li class="dropdown messages-menu">
        <a href="<?php echo url($data['lang'] . '/user/register'); ?>"><?php echo trans('frontend::global.register'); ?></a>
    </li>

<?php else : ?>

    <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?php echo e(asset('assets/frontend/img/photo.png')); ?>" class="user-image" alt="User Image">
            <span class="hidden-xs"><?php echo $loggedInUser->first_name . ' ' . $loggedInUser->last_name; ?></span>
        </a>
        <ul class="dropdown-menu">
            <li class="" style="padding: 5px 5px"><a href="<?php echo url($data['lang'] . '/account/profile'); ?>">
                    <i class="fa fa-edit"></i> <span><?php echo trans('frontend::global.profile'); ?></span></a>
            </li>

            <li class="" style="padding: 5px 5px"><a href="<?php echo url($data['lang'] . '/account/changepassword'); ?>">
                    <i class="fa fa-edit"></i> <span><?php echo trans('frontend::global.changepassword'); ?></span></a>
            </li>

            <li class="" style="padding: 5px 5px"><a href="<?php echo url($data['lang'] . '/account/setting'); ?>">
                    <i class="fa fa-edit"></i> <span><?php echo trans('frontend::global.setting'); ?></span></a>
            </li>

            <li class="user-footer" style="padding: 5px 5px">
                <div class="pull-right">
                    <a href="<?php echo url($data['lang'] . '/account/logout'); ?>" class="btn btn-default btn-flat"><?php echo trans('frontend::global.logout'); ?></a>
                </div>
            </li>
        </ul>

    </li>

<?php endif; ?>