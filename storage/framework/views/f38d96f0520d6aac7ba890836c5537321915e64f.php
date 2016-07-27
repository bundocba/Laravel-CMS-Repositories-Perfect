<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $__env->yieldContent('title'); ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/css/main.css')); ?>">

        <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/jquery-ui/jquery-ui.css')); ?>">

        <!-- jQuery 2.1.4 -->
        <script src="<?php echo e(asset('assets/frontend/js/jquery-2.1.4.min.js')); ?>"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="<?php echo e(asset('assets/frontend/jquery-ui/jquery-ui.js')); ?>"></script>

        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/bootstrap/css/bootstrap.min.css')); ?>">
        <script src="<?php echo e(asset('assets/frontend/bootstrap/js/bootstrap.min.js')); ?>"></script>

        <style type="text/css">

            .required {
                margin: 2px;
                padding: 2px;
                /*font-family: Arial, Helvetica, sans-serif;*/
                color: #ff3232;
                font-weight:bold;
                font-size: 13px;
            }
            .table-responsive {
              /*overflow-x: visible !important;*/
              /*overflow-y: visible !important;*/
            }
            .form-control {
                border-radius: 0;
            }

            .main-content {
                min-height: 600px;
            }

            .dropdown-submenu {
                position:relative;
            }
            .dropdown-submenu>.dropdown-menu {
                top:0;
                left:100%;
                margin-top:-6px;
                margin-left:-1px;
                -webkit-border-radius:0 6px 6px 6px;
                -moz-border-radius:0 6px 6px 6px;
                border-radius:0 6px 6px 6px;
            }
            .dropdown-submenu:hover>.dropdown-menu {
                display:block;
            }
            .dropdown-submenu>a:after {
                display:block;
                content:" ";
                float:right;
                width:0;
                height:0;
                border-color:transparent;
                border-style:solid;
                border-width:5px 0 5px 5px;
                border-left-color:#cccccc;
                margin-top:5px;
                margin-right:-10px;
            }
            .dropdown-submenu:hover>a:after {
                border-left-color:#ffffff;
            }
            .dropdown-submenu.pull-left {
                float:none;
            }
            .dropdown-submenu.pull-left>.dropdown-menu {
                left:-100%;
                margin-left:10px;
                -webkit-border-radius:6px 0 6px 6px;
                -moz-border-radius:6px 0 6px 6px;
                border-radius:6px 0 6px 6px;
            }

        </style>

        <script type="text/javascript">

            $(document).ready(function() {
                $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
                // Avoid following the href location when clicking
                event.preventDefault();
                // Avoid having the menu to close when clicking
                event.stopPropagation();
                // If a menu is already open we close it
                $('ul.dropdown-menu [data-toggle=dropdown]').parent().removeClass('open');
                // opening the one you clicked on
                $(this).parent().addClass('open');
              });
            });

        </script>


    </head>

    <body>


        <div id="main">

            

            <div class="container main-content">

                <div class="row">
                <div class="col-xs-12">

                    

                    <?php $__env->startSection('content'); ?>
                    <?php echo $__env->yieldSection(); ?>

                    </div>
                </div>


            </div>

            <?php echo $__env->make('frontend::partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        </div>

        <?php  
            //$debugbar = \App::make('debugbar');
            //$debugbar->addCollector(new DebugBar\DataCollector\MessagesCollector('my_messages'));
            //$renderer = \Debugbar::getJavascriptRenderer();
        ?>
        
    </body>