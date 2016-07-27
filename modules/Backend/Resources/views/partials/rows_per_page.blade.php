<?php
    //$url = $models->appends(Input::except('page', 'per_page'));

    $inputs = Input::except('page', 'per_page');

    $perPages = ['5' => '5', '10' => '10', '20' => '20', '50' => '50', '100' => '100'];

    $newUrl = \Request::url('/');
    $queryString = http_build_query($inputs);
    $newUrl .= '' . ($queryString != '' ? '?' . $queryString : '');
    $newUrl = strpos($newUrl, '?') ? $newUrl . '&per_page=' : $newUrl . '?per_page=';

?>

<script type="text/javascript">

        $(document).ready(function () {

            $('[name="per_page"]').change(function(event) {
                document.location = '<?php echo $newUrl; ?>' + $(this).val();;
            });

        });

</script>

<div class="form-inline">

    <span><?php echo trans('backend::global.per_page'); ?></span>
    &nbsp;&nbsp;
    <?php echo Form::bsSelect('per_page', $perPages, (int)\Request::query('per_page')); ?>

</div>

