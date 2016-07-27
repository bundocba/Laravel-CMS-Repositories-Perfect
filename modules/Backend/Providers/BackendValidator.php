<?php

namespace Modules\Backend\Providers;

use Illuminate\Validation\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class BackendValidator extends Validator
{

//    public function __construct($translator, $data, $rules, $messages = array())
//    {
//        parent::__construct($translator, $data, $rules, $messages);
//    }

    public function __construct($translator, array $data, array $rules, array $messages = [], array $customAttributes = [])
    {
        $this->translator = $translator;
        $this->customMessages = $messages;
        $this->data = $this->parseData($data);
        $this->customAttributes = $customAttributes;
        $this->initialRules = $rules;

        $this->setRules($rules);
    }

    /**
     * Get the validation message for an attribute and rule.
     *
     * @param  string  $attribute
     * @param  string  $rule
     * @return string
     */
    protected function getMessage($attribute, $rule)
    {
        $lowerRule = Str::snake($rule);

        $inlineMessage = $this->getInlineMessage($attribute, $lowerRule);

        // First we will retrieve the custom message for the validation rule if one
        // exists. If a custom validation message is being used we'll return the
        // custom message, otherwise we'll keep searching for a valid message.
        if (!is_null($inlineMessage)) {
            return $inlineMessage;
        }

        $customKey = "backend::validation.custom.{$attribute}.{$lowerRule}";

        $customMessage = $this->getCustomMessageFromTranslator($customKey);

        // First we check for a custom defined validation message for the attribute
        // and rule. This allows the developer to specify specific messages for
        // only some attributes and rules that need to get specially formed.
        if ($customMessage !== $customKey) {
            return $customMessage;
        }

        // If the rule being validated is a "size" rule, we will need to gather the
        // specific error message for the type of attribute being validated such
        // as a number, file or string which all have different message types.
        elseif (in_array($rule, $this->sizeRules)) {
            return $this->getSizeMessage($attribute, $rule);
        }

        // Finally, if no developer specified messages have been set, and no other
        // special messages apply for this rule, we will just pull the default
        // messages out of the translator service for this validation rule.
        $key = "backend::validation.{$lowerRule}";

        if ($key != ($value = $this->translator->trans($key))) {
            return $value;
        }

        return $this->getInlineMessage(
                        $attribute, $lowerRule, $this->fallbackMessages
                ) ? : $key;
    }

    protected function getAttribute($attribute)
    {
        $primaryAttribute = $this->getPrimaryAttribute($attribute);

        $expectedAttributes = $attribute != $primaryAttribute ? [$attribute, $primaryAttribute] : [$attribute];

        foreach ($expectedAttributes as $expectedAttributeName) {
            // The developer may dynamically specify the array of custom attributes
            // on this Validator instance. If the attribute exists in this array
            // it takes precedence over all other ways we can pull attributes.
            if (isset($this->customAttributes[$expectedAttributeName])) {
                return $this->customAttributes[$expectedAttributeName];
            }

            $key = "backend::validation.attributes.{$expectedAttributeName}";

            // We allow for the developer to specify language lines for each of the
            // attributes allowing for more displayable counterparts of each of
            // the attributes. This provides the ability for simple formats.
            if (($line = $this->translator->trans($key)) !== $key) {
                return $line;
            }
        }

        // When no language line has been specified for the attribute and it is
        // also an implicit attribute we will display the raw attribute name
        // and not modify it with any replacements before we display this.
        if (isset($this->implicitAttributes[$primaryAttribute])) {
            return $attribute;
        }

        return str_replace('_', ' ', Str::snake($attribute));
    }

    protected function getCustomMessageFromTranslator($customKey)
    {
        if (($message = $this->translator->trans($customKey)) !== $customKey) {
            return $message;
        }

        $shortKey = preg_replace('/^validation\.custom\./', '', $customKey);

        $customMessages = Arr::dot(
            (array) $this->translator->trans('backend::validation.custom')
        );

        foreach ($customMessages as $key => $message) {
            if (Str::contains($key, ['*']) && Str::is($key, $shortKey)) {
                return $message;
            }
        }

        return $customKey;
    }

    protected function getSizeMessage($attribute, $rule)
    {
        $lowerRule = Str::snake($rule);

        // There are three different types of size validations. The attribute may be
        // either a number, file, or string so we will check a few things to know
        // which type of value it is and return the correct line for that type.
        $type = $this->getAttributeType($attribute);

        $key = "backend::validation.{$lowerRule}.{$type}";

        return $this->translator->trans($key);
    }
    
    public function getDisplayableValue($attribute, $value)
    {
        if (isset($this->customValues[$attribute][$value])) {
            return $this->customValues[$attribute][$value];
        }

        $key = "backend::validation.values.{$attribute}.{$value}";

        if (($line = $this->translator->trans($key)) !== $key) {
            return $line;
        }

        return $value;
    }
    
    public function addError($attribute, $rule, $parameters = [])
    {
        $message = $this->getMessage($attribute, $rule);

        $message = $this->doReplacements($message, $attribute, $rule, $parameters);

        $this->messages->add($attribute, $message);
    }
}
