<header class="main-header">

    <!-- Logo -->
    <a href="<?php echo url($data['prefix'] . '/dashboard/index'); ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>CMS-Admin</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>CMS-Admin</b></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <?php echo $__env->make('backend::partials.user_info', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </ul>
        </div>

    </nav>
</header>