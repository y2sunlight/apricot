<?php
/**
 * Initial setting of ORM (idirom)
 */
return function():bool
{
    // Gets the database type
    $database = config('idiorm.database');
    if (is_null($database))return true;

    // Prepares the database file such as SQLite
    $db_file = config("idiorm.connections.{$database}.db_file");
    if (isset($db_file) && !file_exists($db_path=dirname($db_file)))
    {
        @mkdir($db_path, null, true);
    }

    $new_db_file = !empty($db_file) && !file_exists($db_file);

    //-------------------------------------------
    // Connects to database
    //-------------------------------------------
    ORM::configure([
        'connection_string' => config("idiorm.connections.{$database}.connection_string"),
        'caching' => config('idiorm.caching',false),
        'logging' => false,
        'logger' => function($log_string, $query_time)
        {
            // SQL debug logging
            Apricot\Log::info("SQL",[$log_string]);
        },
    ]);

    $user = config("idiorm.connections.{$database}.username");
    if (!empty($user))
    {
        ORM::configure('username', $user);
        ORM::configure('password', config("idiorm.connections.{$database}.password",''));
    }

    $options = config("idiorm.connections.{$database}.driver_options");
    if (!empty($options))
    {
        ORM::configure('driver_options', $options);
    }

    // Executes initial SQL statements
    $initial_statements = config("idiorm.connections.{$database}.initial_statements");
    if (isset($initial_statements))
    {
        foreach((array)$initial_statements as $sql)
        {
            ORM::get_db()->exec($sql);
        }
    }

    //-------------------------------------------
    // Creates tables if they doesn't exist.
    //-------------------------------------------
    $chech_tables = config("idiorm.connections.{$database}.check_tables");
    $no_tabels = !empty($chech_tables) && ORM::raw_execute($chech_tables) && (ORM::get_last_statement()->fetch(PDO::FETCH_ASSOC) === false);

    if ($new_db_file || $no_tabels)
    {
        $sql_text = file_get_sql(assets_dir("sql/{$database}/create.sql"));
        if (!empty($sql_text))
        {
            foreach($sql_text as $sql)
            {
                ORM::get_db()->exec($sql);
            }
        }
    }

    //-------------------------------------------
    // Creates initial data when a table is empty
    //-------------------------------------------
    $initial_data = config('idiorm.initial_data');
    if (isset($initial_data))
    {
        foreach($initial_data as $key=>$item)
        {
            if(ORM::forTable($key)->findOne()===false)
            {
                // SQL execution
                $exec=[];
                if (array_key_exists("exec", $item))
                {
                    $exec = array_merge($exec, (array)$item["exec"]);
                }
                if (array_key_exists("exec:{$database}", $item))
                {
                    $exec = array_merge($exec, (array)$item["exec:{$database}"]);
                }
                foreach($exec as $sql)
                {
                    ORM::get_db()->exec($sql);
                }

                // Creates new records
                if (array_key_exists('rows', $item))
                {
                    $rows = (array)$item['rows'];
                    foreach($rows as $row)
                    {
                        $row = ORM::forTable($key)->create($row);
                        $row->save();
                    }
                }
            }
        }
    }

    // Starts SQL log
    ORM::configure('logging' , config('idiorm.logging',false));
    return true; // Must return true on success
};