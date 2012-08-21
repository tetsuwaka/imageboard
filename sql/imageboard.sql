create database imageboard character set utf8;

create table thread (
    id serial,
    title varchar(255),
    name varchar(255) default 'nanashi',
    imageurl varchar(255),
    data timestamp default current_timestamp
) default charset=utf8;

create table comments (
    id serial,
    thread integer not null,
    name varchar(255) default 'nanashi',
    comment varchar(255),
    data timestamp default current_timestamp
) default charset=utf8;
