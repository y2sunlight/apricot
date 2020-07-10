<?php
//-------------------------------------------------------------------
// Valitron\Validatorの初期設定
//-------------------------------------------------------------------
return function():bool
{
    \Valitron\Validator::langDir(config('validator.lang_dir'));
    \Valitron\Validator::lang(config('validator.lang'));

    //-------------------------------------------------------------------
    // カスタムルールの追加
    //-------------------------------------------------------------------
    /*
     * uniqueルール: ユニーク属性の検査を行う
     * [例] rule('unique','ユニークカラム名','テーブル名','IDカラム名')
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
