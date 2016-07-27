
<div class="form-inline" style="margin-bottom: 15px">

    <div class="form-inline pull-left">
        <div class="form-group">
            <?php echo $models->appends(\Input::except('page'))->render(); ?>

        </div>
    </div>

    <div class="form-inline pull-right">
        <span><?php echo trans('backend::global.display_from_to_of_total_rows', ['from' => $models->firstItem(), 'to' => $models->lastItem(), 'total' => $models->total()]); ?></span>
        <div class="form-group" style="padding-left: 5px">
            <?php echo $__env->make('backend::partials.rows_per_page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
    </div>

    <div class="clearfix"></div>

</div>
