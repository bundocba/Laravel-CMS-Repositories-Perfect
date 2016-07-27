<div class="modal fade" id="row-delete-modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <?php echo Form::bsOpen(['id' => 'row-delete-form']); ?>
    <?php echo Form::token(); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo trans('backend::global.close'); ?></span></button>
                <h4 class="modal-title" id="frm_title"><?php echo trans('backend::global.delete'); ?></h4>
            </div>
            <div class="modal-body" id="frm_body"><?php echo trans('backend::global.are_you_sure_to_delete'); ?></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default col-sm-2 pull-right" data-dismiss="modal" id="cancel-btn" style="margin-left:10px;"><?php echo trans('backend::global.no'); ?></button>
                <button type="button" class="btn btn-danger col-sm-2 pull-right" id="submit-btn"><?php echo trans('backend::global.yes'); ?></button>
            </div>
        </div>
    </div>
    <?php echo Form::close(); ?>
</div>