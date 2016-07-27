<?php

namespace Modules\Backend\Widgets;

class Indentation
{

    public function indentation($depth, $attributes = [])
    {
        $indentation = '';

        for ($i = 0; $i < $depth; $i++) {
            if ($i == $depth - 1) {
                $indentation .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&mdash;&nbsp;&nbsp;';
            } else if ($i < $depth - 1) {
                $indentation .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            }
        }

        return $indentation;
    }

}
