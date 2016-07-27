<?php

namespace Modules\Backend\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use Modules\Backend\Providers\BackendValidator;

class Backend
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
//        \DB::enableQueryLog();
//
//        \DB::listen(function ($executed) {
//            $sql = $executed->sql;
//            $logFile = fopen(storage_path('logs' . DIRECTORY_SEPARATOR . date('Y-m-d') . '_query.log'), 'a+');
//            fwrite($logFile, date('Y-m-d H:i:s') . ': ' . $sql . PHP_EOL);
//            fclose($logFile);
//        });

        \Validator::resolver(function($translator, $data, $rules, $messages)
        {
            return new BackendValidator($translator, $data, $rules, $messages);
        });

        \Blade::directive('numeric', function($expression) {
            return "<?php echo {$expression} != null ? number_format({$expression}, 0, '.', ',') : ''; ?>";
        });

        \Blade::directive('datetime', function($expression) {
            return "<?php echo {$expression} != null ? date('Y-m-d H:i', strtotime({$expression})) : ''; ?>";
        });

        \Blade::directive('date', function($expression) {
            return "<?php echo {$expression} != null ? date('Y-m-d', strtotime({$expression})) : ''; ?>";
        });

        \Blade::directive('time', function($expression) {
            return "<?php echo {$expression} != null ? date('H:i', strtotime({$expression})) : ''; ?>";
        });

        \Blade::directive('status', function($expression) {
            $active = trans('backend::global.active');
            $inactive = trans('backend::global.inactive');
            return "<?php echo {$expression} == 1 ? '<span class=\"label label-success\">{$active}</span>' : '<span class=\"label label-default\">{$inactive}</span>'; ?>";
        });

        \Blade::directive('postStatus', function($expression) {
            $active = trans('backend::global.active');
            $inactive = trans('backend::global.inactive');
            return "<?php echo {$expression} == 1 ? '<span class=\"label label-success\">{$active}</span>' : '<span class=\"label label-default\">{$inactive}</span>'; ?>";
        });

        \Widget::register('printMenuLinks', 'Modules\Backend\Widgets\Navigation@printMenuLinks');
        \Widget::register('indentation', 'Modules\Backend\Widgets\Indentation@indentation');
        \Widget::register('column', 'Modules\Backend\Widgets\TableColumn@column');

        \App::register('Modules\Backend\Services\Html\HtmlServiceProvider');

        return $next($request);
    }
}
