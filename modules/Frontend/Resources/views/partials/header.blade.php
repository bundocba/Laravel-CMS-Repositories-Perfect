
<div class="top">
    <div class="container" id="top">

        <div>
            <a href="{{ url($data['lang'] . '/') }}">
                <div class="logo"></div>
            </a>
        </div>

        <div style="display: block; float: left; margin: 20px 20px">

            @include('frontend::partials.navigation')

        </div>

        <div style="display: block; float: right; margin: 20px 20px">
            <div class="inline">
                <div class="inline" style="float: left; display: inline-block; margin: 15px">
                    <?php echo Form::open(['method' => 'GET', 'url' => $data['lang'] . '/search/result']); ?>
                    <input type="input" name="keywords" placeholder="<?php echo trans('frontend::global.search-keywords'); ?>" style="width: 100px"> <button><?php echo trans('frontend::global.search'); ?></button>
                    <?php echo Form::close(); ?>
                </div>

                <div class="inline" style="float: right; display: inline-block">

                    <div style="margin: 0px 15px">

                        @include('frontend::partials.language_switch')

                    </div>

                    <ul class="nav navbar-nav">
                        @include('frontend::partials.user_info')
                    </ul>
                </div>
            </div>

        </div>
        <div class="clearfix"></div>
    </div>
</div>


