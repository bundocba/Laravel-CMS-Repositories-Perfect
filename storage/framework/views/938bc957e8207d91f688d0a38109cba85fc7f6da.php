<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $__env->yieldContent('title'); ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <link rel="stylesheet" href="<?php echo e(asset('assets/backend/dist/css/AdminLTE.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('assets/backend/dist/css/skins/_all-skins.min.css')); ?>">

        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?php echo e(asset('assets/backend/bootstrap/css/bootstrap.min.css')); ?>">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/font-awesome.min.css')); ?>">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/ionicons.min.css')); ?>">

        <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/main.css')); ?>">

        <!-- jQuery 2.1.4 -->
        <script src="<?php echo e(asset('assets/backend/plugins/jQuery/jQuery-2.1.4.min.js')); ?>"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="<?php echo e(asset('assets/backend/bootstrap/js/bootstrap.min.js')); ?>"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo e(asset('assets/backend/dist/js/app.js')); ?>"></script>

        <script type="text/javascript">

            $(document).ready(function () {

                if (window.self !== window.top) {
                    alert('<?php echo trans('backend::global.clickjacking') ?>' + ' ' + location.hostname.toString());
                }

            });

        </script>

    </head>
    <body class="hold-transition login-page">

        <div class="wrapper">

            <!-- Main content -->
            <section class="content">

                <div class="row">
                    <div class="col-xs-12">

                        <?php $__env->startSection('content'); ?>
                        <?php echo $__env->yieldSection(); ?>

                    </div>
                </div>

            </section><!-- /.content -->

        </div><!-- ./wrapper -->

    </body>
</html>
