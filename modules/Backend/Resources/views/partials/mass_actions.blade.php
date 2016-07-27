 &nbsp;&nbsp;
<div class="form-group">
    <select name="mass_actions" id="mass_actions" class="form-control">
        <option value="">--<?php echo trans('backend::global.mass_action'); ?>--</option>
        <?php if (isset($mass_activate_url)) : ?>
            <option value="<?php echo $mass_activate_url ?>"><?php echo trans('backend::global.activate'); ?></option>
        <?php endif; ?>
        <?php if (isset($mass_deactivate_url)) : ?>
            <option value="<?php echo $mass_deactivate_url ?>"><?php echo trans('backend::global.deactivate'); ?></option>
        <?php endif; ?>
        <?php if (isset($mass_delete_url)) : ?>
            <option value="<?php echo $mass_delete_url ?>"><?php echo trans('backend::global.delete'); ?></option>
        <?php endif; ?>
    </select>
</div>
 &nbsp;&nbsp;
<div class="form-group">
    <input type="button" class="btn btn-primary" id="mass-actions-btn" value="<?php echo trans('backend::global.apply'); ?>" />
</div>

<div class="modal fade" id="mass-delete-modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <?php echo Form::bsOpen(['id' => 'mass-delete-form']); ?>
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
