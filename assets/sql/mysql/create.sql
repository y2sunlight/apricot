/*
 * User Table
 */
create table if not exists user
(
    id int not null auto_increment,
    account varchar(128) unique not null,
    password varchar(256) not null,
    email varchar(256),
    note text,
    remember_token varchar(256),
    created_at datetime not null,
    updated_at datetime not null,
    version_no int default 0 not null,
    primary key(id)
);
