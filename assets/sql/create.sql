/*
 * User Table
 */
CREATE TABLE IF NOT EXISTS user
(
    id integer primary key autoincrement,
    account text unique not null,
    password text not null,
    email text not null,
    note text,
    remember_token text,
    created_at text not null,
    updated_at text not null,
    version_no integer default 0 not null
);