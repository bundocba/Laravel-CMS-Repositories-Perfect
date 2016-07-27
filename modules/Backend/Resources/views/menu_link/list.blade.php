@extends('backend::layouts.master')

@section('content')
@parent

@include('backend::partials.breadcrumbs')

<div class="box box-primary">

    <div id="u-l-list" class="box-body">

        @include('backend::partials.flash_message')

        <div id="toolbar">

            <div class="pull-left">

                <a href="<?php echo url($data['prefix'] . '/menu_link/add/?lang=' . $data['lang']); ?>">
                    <button class="btn btn-success">
                        <?php echo trans('backend::global.addnew'); ?> &nbsp; <i class="fa fa-plus"></i>
                    </button>
                </a>

            </div>

            <div class="pull-right">

                <?php echo Form::bsSelect('lang', $languageList, $data['lang']); ?> &nbsp;&nbsp;
                <span class="alert-danger"><?php echo $errors->first('lang', ':message'); ?></span>

            </div>

            <div class="clearfix"></div>

        </div>

        <script type="text/javascript">

            $(document).ready(function () {

                $('#lang').change(function (event) {

                    var lang = encodeURI($('#lang').val());
                    var query = '?lang=' + lang;

                    document.location.href = '<?php echo url($data['prefix'] . '/menu_link/list/'); ?>' + query;

                });

                $('#update-weight-btn').click(function (event) {
                    $('#list-form').attr('action', '<?php echo url($data['prefix'] . '/menu_link/updateweight/?lang=' . $data['lang']) ?>');
                    $('#list-form').submit();
                });

            });

        </script>


        <?php if (!empty($models) && $models->total() > 0) : ?>

            <?php echo Form::bsOpen(['id' => 'list-form', 'name' => 'list-form']); ?>

            <?php echo Form::token(); ?>

            <div class="table-responsive-custom">

                <table class="table table-striped table-hover table-bordered dataTable no-footer dtr-inline">
                    <tr>
                        <td align="center" style="width: 5%"><strong><?php echo trans('backend::global.#') ?></strong></td>
                        <td align="left" style="width: 20%"><strong><?php echo trans('backend::menu_link.name'); ?></strong></td>
                        <td align="left" style="width: 15%"><strong><?php echo trans('backend::menu_link.link_to'); ?></strong></td>
                        <td align="left" style="width: 30%"><strong><?php echo trans('backend::menu_link.link_url'); ?></strong></td>
                        <td align="center" style="width: 10%">
                            <strong><?php echo trans('backend::menu_link.weight'); ?></strong>
                            <img id="update-weight-btn" style="cursor: pointer" src="{{ asset('assets/backend/img/refresh.png') }}"></img>
                        </td>
                        <td align="center" style="width: 10%"><strong><?php echo trans('backend::menu_link.status'); ?></strong></td>
                        <td align="center" style="width: 10%"><strong><?php echo trans('backend::global.actions') ?></strong></td>
                    </tr>
                    <?php $count = $models->firstItem(); ?>
                    <?php foreach ($models as $model): ?>
                        <tr class="<?php echo ($count % 2 ? '' : 'alternate'); ?>">
                            <td align="center"><?php echo $count; ?></td>
                            <td align="left">
                                <?php echo \Widget::call('indentation', [$model->depth]); ?>
                                {{ $model->name }}
                            </td>
                            <td align="left">
                                <div>{{ $model->content_name }}</div>
                            </td>
                            <td align="left">
                                <div>{{ $model->full_url }}</div>
                                <div style="display: none">{{ $model->url }}</div>
                            </td>
                            <td align="center">
                                <?php echo Form::hidden('weight_ids[]', $model->id); ?>
                                <?php echo Form::bsSelect('weights[]', $weightList, $model->weight, ['style' => 'width: 75px']); ?>
                            </td>
                            <td align="center">@status($model->status)</td>
                            <td align="center">
                                @include('backend::partials.row_actions',
                                [
                                'view_url' => url($data['prefix'] . '/menu_link/view/' . $model->id . '/?lang=' . $data['lang']),
                                'edit_url' => url($data['prefix'] . '/menu_link/edit/' . $model->id . '/?lang=' . $data['lang']),
                                'delete_url' => url($data['prefix'] . '/menu_link/delete/' . $model->id . '/?lang=' . $data['lang'])
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