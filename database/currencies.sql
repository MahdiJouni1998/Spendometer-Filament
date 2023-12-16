
create table spendometer.currencies
(
    id         bigint unsigned auto_increment
        primary key,
    user_id    bigint unsigned not null,
    name       varchar(10)     not null,
    symbol     varchar(20)     not null,
    created_at timestamp       null,
    updated_at timestamp       null,
    deleted_at timestamp       null,
    constraint currencies_users_id_fk
        foreign key (user_id) references spendometer.users (id)
);
insert into currencies (user_id, name, symbol) select id, 'lbp', 'ل.ل.' FROM users;
insert into currencies (user_id, name, symbol) select id, 'usd', '$' FROM users;
insert into currencies (user_id, name, symbol) select id, 'eur', '€' FROM users;
