<?php
/**
 * Initial settings of Valitron\Validator
 */
return function():bool
{
    \Valitron\Validator::langDir(config('validator.lang_dir'));
    \Valitron\Validator::lang(config('validator.lang'));

    //-------------------------------------------------------------------
    // Adds custom rules
    //-------------------------------------------------------------------
    /*
     * unique rule: Check for unique attributes
     * [Example] rule('unique','Unique column name','Table name','ID column name')
     */
    Valitron\Validator::addRule('unique', function($field, $value, array $params, array $fields)
    {
        if (count($params)<1) return false;

        $query = ORM::for_table($params[0])->where($field, $value);
        if ((count($params)>1) && array_key_exists($params[1], $fields))
        {
            $id_field = $params[1];
            $query = $query->where_not_equal($id_field, $fields[$id_field]);
        }
        $users = $query->find_one();

        return ($users===false);

    }, 'is not unique');

    return true; // Must return true on success
};
