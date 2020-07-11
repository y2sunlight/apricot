<?php
//-------------------------------------------------------------------
// ORM(idirom)の初期設定
//-------------------------------------------------------------------
return function():bool
{
    // データベースファイルの準備
    $db_file = config('idiorm.sqlite.db_file');
    if (!file_exists($db_path=dirname($db_file)))
    {
        @mkdir($db_path, null, true);
    }

    // DBファイルの存在確認
    $new_db_file = !file_exists($db_file);

    // データベース接続
    ORM::configure([
        'connection_string' => config('idiorm.sqlite.connection_string'),
        'caching' => config('idiorm.sqlite.caching',false),
        'logging' => false,
        'logger' => function($log_string, $query_time)
        {
            // SQL debug logging
            Apricot\Log::info("SQL",[$log_string]);
    },
    ]);

    //-------------------------------------------
    // テーブルの作成 (新しくDBを作った時)
    //-------------------------------------------
    if ($new_db_file)
    {
        $sql_text = file_get_sql(assets_dir('sql/create.sql'));
        if (!empty($sql_text))
        {
            foreach($sql_text as $sql)
            {
                ORM::get_db()->exec($sql);
            }
        }
    }

    //-------------------------------------------
    // 初期ユーザの作成 (ユーザテーブルが空の時)
    //-------------------------------------------
    $initial_data = config('idiorm.initial_data');
    if (isset($initial_data))
    {
        foreach($initial_data as $key=>$item)
        {
            if(ORM::for_table($key)->find_one()===false)
            {
                if (array_key_exists('exec', $item))
                {
                    // SQLの実行
                    $exec = (array)$item['exec'];
                    foreach($exec as $sql)
                    {
                        ORM::get_db()->exec($sql);
                    }
                }
                if (array_key_exists('rows', $item))
                {
                    // 新しいレコードの作成
                    $rows = (array)$item['rows'];
                    foreach($rows as $row)
                    {
                        $row = ORM::for_table($key)->create($row);
                        $row->set_expr('created_at', "datetime('now')");
                        $row->set_expr('updated_at', "datetime('now')");
                        $row->save();
                    }
                }
            }
        }
    }

    // SQLログ開始
    ORM::configure('logging' , config('idiorm.sqlite.logging',false));
    return true; // Must return true on success
};