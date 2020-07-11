<?php
namespace App\Foundation;

use Apricot\Foundation\ErrorBag;

class ValidatorErrorBag extends ErrorBag
{
    public const BAG_KEY = 'validator';

    /**
     * Create Validator Error Bag
     * @param array $errors \Valitron\Validator Errors
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
