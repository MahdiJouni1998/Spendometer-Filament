
create table spendometer.balances
(
    id         bigint unsigned auto_increment
        primary key,
    wallet_id  bigint unsigned              not null,
    name       varchar(255)                 not null,
    amount     decimal(24, 2) default 0.00  not null,
    currency   varchar(10)    default 'usd' not null,
    user_id    bigint unsigned              not null,
    created_at timestamp                    null,
    updated_at timestamp                    null,
    deleted_at timestamp                    null,
    constraint balances_users_id_fk
        foreign key (user_id) references spendometer.users (id),
    constraint balances_wallets_id_fk
        foreign key (wallet_id) references spendometer.wallets (id)
);
insert into balances (wallet_id, name, amount, currency, user_id) select id, CONCAT(name, ' ', 'usd'), balance_usd, 'usd', user_id FROM wallets;
insert into balances (wallet_id, name, amount, currency, user_id) select id, CONCAT(name, ' ', 'eur'), balance_eur, 'eur', user_id FROM wallets;
insert into balances (wallet_id, name, amount, currency, user_id) select id, CONCAT(name, ' ', 'lbp'), balance_lbp, 'lbp', user_id FROM wallets;
