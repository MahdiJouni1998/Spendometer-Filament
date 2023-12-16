<?php
$con = mysqli_connect('127.0.0.1', 'root', 'P@ssw0rd', 'spendometer');
mysqli_begin_transaction($con);

try {
    $sql = "alter table transactions add balance_id bigint unsigned null after wallet_id;";
    mysqli_query($con, $sql);
    $sql = "alter table wallets_transactions add balance_from bigint unsigned null after wallet_from;";
    mysqli_query($con, $sql);
    $sql = "alter table wallets_transactions add balance_to bigint unsigned null after wallet_to;";
    mysqli_query($con, $sql);


    $sql = "SELECT * FROM transactions";
    $query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_assoc($query)) {
        $id = $row['id'];
        $wallet = $row['wallet_id'];
        $currency = $row['currency'];
        // get balance
        $sql2 = "SELECT id FROM balances WHERE wallet_id=$wallet AND currency='$currency';";
        $query2 = mysqli_query($con, $sql2);
        $row2 = mysqli_fetch_assoc($query2);
        $balance = $row2['id'];
        // update
        $sql = "UPDATE transactions SET balance_id=$balance WHERE id=$id;";
        mysqli_query($con, $sql);
    }

    $sql = "SELECT * FROM wallets_transactions";
    $query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_assoc($query)) {
        $id = $row['id'];
        //
        // FROM
        $wallet = $row['wallet_from'];
        $currency = $row['currency_from'];
        // get balance
        $sql3 = "SELECT id FROM balances WHERE wallet_id=$wallet AND currency='$currency';";
        $query3 = mysqli_query($con, $sql3);
        $row3 = mysqli_fetch_assoc($query3);
        $balance = $row3['id'];
        // update
        $sql = "UPDATE wallets_transactions SET balance_from=$balance WHERE id=$id;";
        mysqli_query($con, $sql);
        //
        // TO
        $wallet = $row['wallet_to'];
        $currency = $row['currency_to'];
        // get balance
        $sql4 = "SELECT id FROM balances WHERE wallet_id=$wallet AND currency='$currency';";
        $query4 = mysqli_query($con, $sql4);
        $row4 = mysqli_fetch_assoc($query4);
        $balance = $row4['id'];
        // update
        $sql = "UPDATE wallets_transactions SET balance_to=$balance WHERE id=$id;";
        mysqli_query($con, $sql);
    }

    $sql = "alter table transactions modify balance_id bigint unsigned not null;";
    mysqli_query($con, $sql);
    $sql = "alter table wallets_transactions modify balance_from bigint unsigned not null;";
    mysqli_query($con, $sql);
    $sql = "alter table wallets_transactions modify balance_to bigint unsigned not null;";
    mysqli_query($con, $sql);
    $sql = "alter table transactions drop foreign key transactions_wallet_id_foreign;";
    mysqli_query($con, $sql);
    $sql = "alter table wallets_transactions drop foreign key wallets_transactions_wallet_from_foreign;";
    mysqli_query($con, $sql);
    $sql = "alter table wallets_transactions drop foreign key wallets_transactions_wallet_to_foreign;";
    mysqli_query($con, $sql);
    $sql = "alter table transactions drop column wallet_id;";
    mysqli_query($con, $sql);
    $sql = "alter table wallets_transactions drop column wallet_from;";
    mysqli_query($con, $sql);
    $sql = "alter table wallets_transactions drop column wallet_to;";
    mysqli_query($con, $sql);
    $sql = "alter table transactions drop column currency;";
    mysqli_query($con, $sql);
    $sql = "alter table wallets_transactions drop column currency_from;";
    mysqli_query($con, $sql);
    $sql = "alter table wallets_transactions drop column currency_to;";
    mysqli_query($con, $sql);
    $sql = "alter table transactions add constraint transactions_balance_id_foreign foreign key (balance_id) references balances (id);";
    mysqli_query($con, $sql);
    $sql = "alter table wallets_transactions add constraint wallets_transactions_balance_from_foreign foreign key (balance_from) references balances (id);";
    mysqli_query($con, $sql);
    $sql = "alter table wallets_transactions add constraint wallets_transactions_balance_to_foreign foreign key (balance_to) references balances (id);";
    mysqli_query($con, $sql);

    mysqli_commit($con);
}
catch (Exception $exception) {
    mysqli_rollback($con);

    throw $exception;
}
