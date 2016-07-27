<?php

namespace Modules\Frontend\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use Modules\Frontend\Providers\FrontendValidator;

class Frontend
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
        \Validator::resolver(function($translator, $data, $rules, $messages)
        {
            return new FrontendValidator($translator, $data, $rules, $messages);
        });

        \Validator::extend('foo', function($attribute, $value, $parameters, $validator) {
            return $value == 'foo';
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

        \Widget::register('printMenuLinks', 'Modules\Frontend\Widgets\Navigation@printMenuLinks');

        \App::register('Modules\Frontend\Services\Html\HtmlServiceProvider');

        return $next($request);
    }
}
