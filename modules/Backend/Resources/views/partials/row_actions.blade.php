<div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
        <i class="glyphicon glyphicon-asterisk"></i> <?php echo trans('backend::global.action'); ?> <span class="caret"></span>
    </button>
    <ul class="dropdown-menu dropdown-menu-right" role="menu">
        <?php if (isset($list_url)) : ?>
            <li>
                <a href="<?php echo $list_url; ?>"><i class="fa fa-list"></i> <?php echo trans('backend::global.item'); ?></a>
            </li>
        <?php endif ?>
        <?php if (isset($view_url)) : ?>
            <li>
                <a href="<?php echo $view_url; ?>"><i class="fa fa-search"></i> <?php echo trans('backend::global.view'); ?></a>
            </li>
        <?php endif; ?>
        <?php if (isset($edit_url)) : ?>
            <li>
                <a href="<?php echo $edit_url; ?>"><i class="fa fa-edit"></i> <?php echo trans('backend::global.edit'); ?></a>
            </li>
        <?php endif ?>
        <?php if (isset($delete_url)) : ?>
            <li class="divider" style="min-height: 0px; padding: 0px"></li>
            <li data-form="<?php echo $delete_url ?>" data-title="<?php echo trans('backend::global.delete'); ?>" data-message="<?php echo trans('backend::global.are_you_sure_to_delete'); ?>">
                <a class="row-delete-modal" href="#" data-target="#row-delete-modal" data-toggle="modal"><i class="fa fa-remove"></i> <?php echo trans('backend::global.delete'); ?></a>
            </li>
        <?php endif ?>
    </ul>
</div>

