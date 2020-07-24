<?php
/**
 * Initial setting of ORM (idirom)
 */
return function():bool
{
    // Prepare the database files
    $db_file = config('idiorm.sqlite.db_file');
    if (!file_exists($db_path=dirname($db_file)))
    {
        @mkdir($db_path, null, true);
    }

    // Check if DB file exists
    $new_db_file = !file_exists($db_file);

    // Connect to database
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
    // Create tables when creating a new DB
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
    // Create initial data when a table is empty
    //-------------------------------------------
    $initial_data = config('idiorm.initial_data');
    if (isset($initial_data))
    {
        foreach($initial_data as $key=>$item)
        {
            if(ORM::for_table($key)->find_one()===false)
            {
                // SQL execution
                if (array_key_exists('exec', $item))
                {
                    $exec = (array)$item['exec'];
                    foreach($exec as $sql)
                    {
                        ORM::get_db()->exec($sql);
                    }
                }

                // Create new records
                if (array_key_exists('rows', $item))
                {
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

    // Start SQL log
    ORM::configure('logging' , config('idiorm.sqlite.logging',false));
    return true; // Must return true on success
};