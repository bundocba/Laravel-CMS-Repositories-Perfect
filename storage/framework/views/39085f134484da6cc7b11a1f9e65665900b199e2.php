<?php $__env->startSection('content'); ?>
@parent

<div class="box box-primary">

    <div id="u-l-list" class="box-body">

        <?php echo $__env->make('backend::partials.flash_message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <script type="text/javascript">

            $(document).ready(function () {

                $('#select-btn').click(function (event) {

                    var url = $('#url').val();

                    if (!isUrlExt(url)) {

                        alert('<?php echo trans('backend::selector.url_invalid'); ?>');

                    } else {

                        var contentType = $(event.target).data('content-type');
                        var contentTypeId = 3;

                        $("[name='content_name']", window.parent.document).val(url);
                        $("[name='url']", window.parent.document).val(url);
                        $("[name='content_type_id']", window.parent.document).val(contentTypeId);
                        $("[name='content_type']", window.parent.document).val(contentType);
                        $("[name='type']", window.parent.document).val(2);

                        parent.$('#selector-modal').modal('hide');
                    }

                });

            });

        </script>

        <ul class="nav nav-tabs" style="padding: 20px 0px">
            <li><a href="<?php echo e(url($data['prefix'] . '/selector/page/?lang=' . $data['lang'])); ?>"><?php echo trans('backend::selector.basic_page'); ?></a></li>
            <li><a href="<?php echo e(url($data['prefix'] . '/selector/category/?lang=' . $data['lang'])); ?>"><?php echo trans('backend::selector.category'); ?></a></li>
            <li class="active"><a href="<?php echo e(url($data['prefix'] . '/selector/customlink/?lang=' . $data['lang'])); ?>"><?php echo trans('backend::selector.custom_link'); ?></a></li>
        </ul>

        <?php //echo Form::open(['url' => '']); ?>

        <?php //echo Form::token(); ?>

        <div class="form-group">
            <label class="control-label" for="url"><?php echo trans('backend::selector.url'); ?></label>
            <div class="form-inline">
                <?php echo Form::bsText('url', null, ['style' => 'width: 90%']); ?>
                &nbsp;&nbsp;
                <button type="button" id="select-btn" data-content-name=""  data-content-type="<?php echo trans('backend::selector.custom_link'); ?>" data-url="" class="btn btn-primary"><?php echo trans('backend::selector.select'); ?></button>
                <span class="alert-danger"><?php echo $errors->first('url', ':message'); ?></span>
            </div>
        </div>

        <!--
        <div class="form-group">
            <button id="select-btn" type="button" class="btn btn-primary">Select</button>
        </div>
        -->

        <?php //echo Form::close(); ?>

    </div>

</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend::layouts.popup', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>