@extends('backend::layouts.master')

@section('content')
@parent

@include('backend::partials.breadcrumbs')

<div class="box box-primary">

    <div id="u-l-list" class="box-body">

        @include('backend::partials.flash_message')

        <div id="toolbar">

            <div class="pull-left">

                <div class="form-inline">

                    <div class="form-group">
                        <a href="<?php echo url($data['prefix'] . '/role/add'); ?>">
                            <button class="btn btn-success">
                                <?php echo trans('backend::global.addnew'); ?> &nbsp; <i class="fa fa-plus"></i>
                            </button>
                        </a>
                    </div>

                </div>

            </div>

            <div class="pull-right">

            </div>

            <div class="clearfix"></div>

        </div>


        <?php if (!empty($models) && $models->total() > 0) : ?>

            <?php echo Form::bsOpen(['id' => 'list-form', 'name' => 'list-form']); ?>

            <?php echo Form::token(); ?>

            <div class="table-responsive-custom">

                <table class="table table-striped table-hover table-bordered dataTable no-footer dtr-inline">
                    <tr>
                        <td align="center" style="width: 5%"><strong><?php echo trans('backend::global.#') ?></strong></td>
                        <td align="left" style="width: 30%"><strong>@column(trans('backend::role.name'), 'name')</strong></td>
                        <td align="left" style="width: 35%"><strong>@column(trans('backend::role.description'), 'description')</strong></td>
                        <td align="center" style="width: 10%"><strong>@column(trans('backend::role.priority'), 'priority')</strong></td>
                        <td align="center" style="width: 10%"><strong>@column(trans('backend::role.status'), 'status')</strong></td>
                        <td align="center" style="width: 10%"><strong><?php echo trans('backend::global.actions') ?></strong></td>
                    </tr>
                    <?php $count = $models->firstItem(); ?>
                    <?php foreach ($models as $model): ?>
                        <tr class="<?php echo ($count % 2 ? '' : 'alternate'); ?>">
                            <td align="center"><?php echo $count; ?></td>
                            <td align="left">{{ $model->name }}</td>
                            <td align="left">{{ $model->description }}</td>
                            <td align="center">{{ $model->priority }}</td>
                            <td align="center">@status($model->status)</td>
                            <td align="center">
                                @include('backend::partials.row_actions',
                                [
                                'view_url' => url($data['prefix'] . '/role/view/' . $model->id),
                                'edit_url' => url($data['prefix'] . '/role/edit/' . $model->id),
                                'delete_url' => url($data['prefix'] . '/role/delete/' . $model->id)
                                ]
                                )
                            </td>
                        </tr>
                        <?php $count++; ?>
                    <?php endforeach; ?>
                </table>

            </div>

            <?php echo Form::close(); ?>

            @include('backend::partials.paginator')

        <?php else: ?>

            <div class="alert"><?php echo trans('backend::global.no_record_found'); ?></div>

        <?php endif; ?>

        <div class="clearfix"></div>

        @include('backend::partials.delete_modal')

    </div>

</div>

@endsection