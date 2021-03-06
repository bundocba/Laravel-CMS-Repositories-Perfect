<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $__env->yieldContent('title'); ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
        <meta http-equiv="Pragma" content="no-cache"/>
        <meta http-equiv="Expires" content="0"/>

        <link rel="stylesheet" href="<?php echo e(asset('assets/backend/dist/css/AdminLTE.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('assets/backend/dist/css/skins/_all-skins.min.css')); ?>">

        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?php echo e(asset('assets/backend/bootstrap/css/bootstrap.min.css')); ?>">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/font-awesome.min.css')); ?>">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/ionicons.min.css')); ?>">

        <link rel="stylesheet" href="<?php echo e(asset('assets/backend/plugins/datepicker/datepicker3.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('assets/backend/plugins/timepicker/bootstrap-timepicker.css')); ?>">

        <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/main.css')); ?>">

        <!-- jQuery 2.1.4 -->
        <script src="<?php echo e(asset('assets/backend/plugins/jQuery/jQuery-2.1.4.min.js')); ?>"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="<?php echo e(asset('assets/backend/bootstrap/js/bootstrap.min.js')); ?>"></script>

        <script src="<?php echo e(asset('assets/backend/js/slug.js')); ?>"></script>

        <script src="<?php echo e(asset('assets/backend/js/jquery.cookie.js')); ?>"></script>

        <script type="text/javascript">

            $(document).ready(function () {

                if (window.self !== window.top) {
                    alert('<?php echo trans('backend::global.clickjacking') ?>' + ' ' + location.hostname.toString());
                }

                // Handle delete modal
                $('.row-delete-modal').on('click', function (e) {
                    e.preventDefault();
                    var el = $(this).parent();
                    var title = el.attr('data-title');
                    var msg = el.attr('data-message');
                    var dataForm = el.attr('data-form');
                    $('#row-delete-form').attr('action', dataForm);
                });

                $('#row-delete-modal').on('click', '#submit-btn', function (e) {
                    $('#row-delete-form').submit();
                });

                $('#mass-delete-modal').on('click', '#submit-btn', function (e) {
                    $('#list-form').submit();
                });

                $('.table-responsive').on('shown.bs.dropdown', function (e) {
                    var $table = $(this),
                            $menu = $(e.target).find('.dropdown-menu'),
                            tableOffsetHeight = $table.offset().top + $table.height(),
                            menuOffsetHeight = $menu.offset().top + $menu.outerHeight(true);

                    if (menuOffsetHeight > tableOffsetHeight) {
                        $table.css("padding-bottom", menuOffsetHeight - tableOffsetHeight + 16);
                    }
                });

                $('.table-responsive').on('hide.bs.dropdown', function () {
                    $(this).css("padding-bottom", 0);
                });

                $('#check_all').click(function (event) {
                    var items = $("*[name='ids[]']");
                    for (var i = 0; i < items.length; i++) {
                        items[i].checked = this.checked;
                    }
                });

                $("[name='ids[]']").click(function (event) {
                    var flag = true;
                    var items = $("*[name='ids[]']");
                    for (var i = 0; i < items.length; i++) {
                        if (items[i].checked != true) {
                            flag = false;
                        }
                    }
                    if (flag == true) {
                        //alert(flag);
                        $('#check_all').prop('checked', true);
                    } else {
                        $('#check_all').prop('checked', false);
                    }
                });


                $('#mass-actions-btn').click(function (event) {
                    if ($('#mass_actions').val() !== '') {

                        var items = $("*[name='ids[]']:checked:enabled");
                        if (items.length == 0) {
                            alert('<?php echo trans('backend::global.you_must_select_at_least_one_item') ?>');
                            return;
                        }

                        var url = $('#mass_actions').val();
                        if (url.indexOf('massdelete') > 0) {
                            $('#list-form').attr('action', url);
                            $('#mass-delete-modal').modal('show');
                            return;
                        }
                        $('#list-form').attr('action', url);
                        $('#list-form').submit();

                    } else {
                        alert('<?php echo trans('backend::global.you_must_select_an_action') ?>');
                    }
                });

//                $('form').submit(function (event) {
//                    var $submit = $('input[type="submit"]');
//                    $submit.prop('disabled', true);
//                });

                $(document).on('click', 'input[type=submit], button[type=submit], a.submit, button.submit', function() {

                    var loadingImage = "<?php echo e(asset('assets/backend/img/icons.png')); ?>";
                    // Preserves element width
                    var w = $(this).outerWidth();
                    $(this).css('width', w+'px');

                    // Replaces "input" text with "Wait..."
                    if ($(this).is('input')) {
                        //$(this).val('Wait...');
                    } else if ($(this).is('button') || $(this).is('a')) {
                        // Replaces "button" and "a" html with a
                        // loading image.
                        $(this).html('<img style="width: 16px; height: 16px;" src="' + loadingImage + '"></img>');
                    }

                    // Disables the element.
                    $(this).attr('disabled', 'disabled');

                    // If the element IS NOT a link, submits the
                    // enclosing form.
                    if (!$(this).is('a'))
                        if ($(this).parents('form').length)
                            $(this).parents('form')[0].submit();

                    return true;
                });

            });

        </script>

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <?php echo $__env->make('backend::partials.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <?php echo $__env->make('backend::partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">

                            <?php $__env->startSection('content'); ?>
                            <?php echo $__env->yieldSection(); ?>

                        </div>
                    </div>

                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->


            <?php echo $__env->make('backend::partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        </div><!-- ./wrapper -->

        <!-- Sparkline -->
        <script src="<?php echo e(asset('assets/backend/plugins/sparkline/jquery.sparkline.min.js')); ?>"></script>
        <!-- jvectormap -->
        <script src="<?php echo e(asset('assets/backend/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/backend/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')); ?>"></script>
        <!-- jQuery Knob Chart -->
        <script src="<?php echo e(asset('assets/backend/plugins/knob/jquery.knob.js')); ?>"></script>
        <!-- daterangepicker -->
        <script src="<?php echo e(asset('assets/backend/plugins/daterangepicker/daterangepicker.js')); ?>"></script>
        <!-- datepicker -->
        <script src="<?php echo e(asset('assets/backend/plugins/datepicker/bootstrap-datepicker.js')); ?>"></script>
        <!-- bootstrap time picker -->
        <script src="<?php echo e(asset('assets/backend/plugins/timepicker/bootstrap-timepicker.js')); ?>"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="<?php echo e(asset('assets/backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')); ?>"></script>
        <!-- Slimscroll -->
        <script src="<?php echo e(asset('assets/backend/plugins/slimScroll/jquery.slimscroll.min.js')); ?>"></script>
        <!-- FastClick -->
        <script src="<?php echo e(asset('assets/backend/plugins/fastclick/fastclick.min.js')); ?>"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo e(asset('assets/backend/dist/js/app.js')); ?>"></script>
    </body>
</html>
