<?php
namespace App\Foundation;

use Apricot\Foundation\ErrorBag;

/**
 * ErrorBag class for validator.
 */
class ValidatorErrorBag extends ErrorBag
{
    public const BAG_KEY = 'validator';

    /**
     * Creates a error bag for validator.
     *
     * @param array $validator_errors Errors of \Valitron\Validator
     */
    public function __construct($validator_errors)
    {
        $errors = [];
        foreach($validator_errors as $key=>$value)
        {
            $errors[$key] = $value[0];
        }
        parent::__construct($errors, self::BAG_KEY);
    }
}
