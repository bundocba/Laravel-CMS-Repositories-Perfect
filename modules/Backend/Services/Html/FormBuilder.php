<?php

namespace Modules\Backend\Services\Html;

class FormBuilder extends \Collective\Html\FormBuilder
{

    public function bsOpen(array $options = [])
    {
        $options['class'] = isset($options['class']) ? $options['class'] : 'form-horizontal';
        $options['role'] = 'form';

        echo parent::open($options);
    }

    public function bsModel($model, array $options = [])
    {
        $options['class'] = isset($options['class']) ? $options['class'] : 'form-horizontal';
        $options['role'] = 'form';

        echo parent::model($model, $options);
    }

    public function bsText($name, $value = null, $options = [])
    {
        $options['class'] = isset($options['class']) ? $options['class'] . ' form-control' : 'form-control';
        $options['autocomplete'] = isset($options['autocomplete']) ? $options['autocomplete'] . ' off' : 'off';
        $options['id'] = isset($options['id']) ? $options['id'] : $name;

        echo parent::text($name, $value, $options);
    }

    public function bsTextarea($name, $value = null, $options = [])
    {
        $options['class'] = isset($options['class']) ? $options['class'] . ' form-control' : 'form-control';
        $options['autocomplete'] = isset($options['autocomplete']) ? $options['autocomplete'] . ' off' : 'off';
        $options['id'] = isset($options['id']) ? $options['id'] : $name;

        echo parent::textarea($name, $value, $options);
    }

    public function bsPassword($name, $options = [])
    {
        $options['class'] = isset($options['class']) ? $options['class'] . ' form-control' : 'form-control';
        $options['autocomplete'] = isset($options['autocomplete']) ? $options['autocomplete'] . ' off' : 'off';
        $options['id'] = isset($options['id']) ? $options['id'] : $name;

        echo parent::password($name, $options);
    }

    public function bsSelect($name, $list = [], $value = null, $options = [])
    {
        $options['class'] = isset($options['class']) ? $options['class'] . ' form-control' : 'form-control';
        $options['id'] = isset($options['id']) ? $options['id'] : $name;

        echo parent::select($name, $list, $value, $options);
    }

    public function bsSubmit($value = null, $options = [])
    {
        $options['class'] = isset($options['class']) ? $options['class'] . ' btn btn-primary' : 'btn btn-primary';

        return parent::submit($value, $options);
    }

    public function bsTextRow($name, $label, $errors, $labelOptions = [], $inputOptions = [])
    {
        $labelOptions['class'] = 'form-label';
        $inputOptions['class'] = 'form-control';
        $inputOptions['placeholder'] = $label;

        return sprintf('<div class="form-group">%s<div%s>%s%s</div></div>',
                parent::label($name, $label, $labelOptions),
                $errors->has($name) ? ' class="error-control"' : '',
                parent::text($name, null, $inputOptions),
                $errors->has($name) ? '<span class="error"><label class="error" for="' . $name . '">' . $errors->first($name) . '</label></span>' : '');
    }
}
