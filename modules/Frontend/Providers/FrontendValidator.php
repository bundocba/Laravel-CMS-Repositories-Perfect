<?php

namespace Modules\Frontend\Providers;

use Illuminate\Validation\Validator;
use Illuminate\Support\Str;

class FrontendValidator extends Validator
{

    public function __construct($translator, $data, $rules, $messages = array())
    {
        parent::__construct($translator, $data, $rules, $messages);
    }

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

        $customKey = "frontend::validation.custom.{$attribute}.{$lowerRule}";

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
        $key = "frontend::validation.{$lowerRule}";

        if ($key != ($value = $this->translator->trans($key))) {
            return $value;
        }

        return $this->getInlineMessage(
                        $attribute, $lowerRule, $this->fallbackMessages
                ) ? : $key;
    }

}
