<?php $__env->startSection('content'); ?>
@parent

<?php echo $__env->make('backend::partials.breadcrumbs', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div class="box box-primary">

    <?php echo Form::bsModel($model, ['url' => $data['prefix'] . '/menu_link/edit/' . $model->id . '/?lang=' . $data['lang']]); ?>

    <?php echo Form::token(); ?>

    <div id="u-l-list" class="box-body">

        <?php echo $__env->make('backend::partials.flash_message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="form-group">
            <span class="alert-danger"><?php echo $errors->first('summary', ':message'); ?></span>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="name"><span class="required">*</span> <?php echo trans('backend::menu_link.name'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsText('name'); ?>
                <span class="alert-danger"><?php echo $errors->first('name', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="url"><?php echo trans('backend::menu_link.link_to'); ?></label>
            <div class="col-sm-10">
                <div class="input-group col-sm-12">
                    <?php echo Form::bsText('content_name', null, ['readonly' => 'readonly']); ?>
                    <div class="input-group-btn">
                        <button type="button" id="select-url-btn" class="btn btn-primary glyphicon glyphicon-link" data-toggle="modal" data-target="#selector-modal"></button>
                        <button type="button" id="remove-url-btn" class="btn btn-danger glyphicon glyphicon-remove"></button>
                    </div>
                </div>
                <span class="alert-danger"><?php echo $errors->first('url', ':message'); ?></span>
            </div>
        </div>

        <?php
            $contentType = '';
            $contentTypeId = $model->content_type_id;
            if ($contentTypeId == 1) {
                $contentType = trans('backend::menu_link.basic_page');
            } else if ($contentTypeId == 2) {
                $contentType = trans('backend::menu_link.category');;
            } else if ($contentTypeId == 3) {
                $contentType = trans('backend::menu_link.custom_link');;
            }
        ?>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="content_type"><?php echo trans('backend::menu_link.content_type'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsText('content_type', $contentType, ['readonly' => 'readonly']); ?>
            </div>
        </div>

        <div class="form-group" style="display: none">
            <label class="col-sm-2 control-label" for="content_type_id">Content type ID</label>
            <div class="col-sm-10">
                <?php echo Form::bsText('content_type_id', null, ['readonly' => 'readonly']); ?>
            </div>
        </div>

        <div class="form-group" style="display: none">
            <label class="col-sm-2 control-label" for="url">Link URL</label>
            <div class="col-sm-10">
                <?php echo Form::bsText('url', null, ['readonly' => 'readonly']); ?>
            </div>
        </div>

        <div class="form-group" style="display: none">
            <label class="col-sm-2 control-label" for="type">Link type</label>
            <div class="col-sm-10">
                <?php echo Form::bsText('type', null, ['readonly' => 'readonly']); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="link_target"><?php echo trans('backend::menu_link.link_target'); ?></label>
            <div class="form-inline col-sm-10">
                <?php echo Form::bsSelect('link_target', $linkTargetList); ?>
                <span class="alert-danger"><?php echo $errors->first('link_target', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="parent_id"><?php echo trans('backend::menu_link.parent'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsSelect('parent_id', $parentList, null); ?>
                <span class="alert-danger"><?php echo $errors->first('parent_id', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="weight"><span class="required">*</span> <?php echo trans('backend::menu_link.weight'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsSelect('weight', $weightList); ?>
                <span class="alert-danger"><?php echo $errors->first('weight', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="status"><span class="required">*</span> <?php echo trans('backend::menu_link.status'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsSelect('status', $statusList); ?>
                <span class="alert-danger"><?php echo $errors->first('status', ':message'); ?></span>
            </div>
        </div>

    </div>

    <div class="box-footer">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo Form::bsSubmit(trans('backend::global.submit')); ?>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="<?php echo $data['back_url'] ? $data['back_url'] : url($data['prefix'] . '/menu_link/list'); ?>"><?php echo trans('backend::global.back'); ?></a>
        </div>
    </div>

    <?php echo Form::close(); ?>

</div>


<div class="modal fade" id="selector-modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" style="width: 1000px; height: 620px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id=""><?php echo trans('backend::menu_link.select_link'); ?></h4>
            </div>
            <div class="modal-body">
                <iframe src="<?php echo e(url($data['prefix'] . '/selector/page/?lang=' . $data['lang'])); ?>" width="980" height="600" frameborder="0" allowtransparency="true"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo trans('backend::menu_link.close'); ?></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function () {

        $('#remove-url-btn').click(function (event) {
            $('#url').val('');
            $('#content_name').val('');
            $('#content_type').val('');
            $('#content_type_id').val('');
            $('#type').val('');
        });

    });

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>