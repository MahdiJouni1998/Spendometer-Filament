<?php
$con = mysqli_connect('127.0.0.1', 'root', 'P@ssw0rd', 'spendometer');
mysqli_begin_transaction($con);

try {
    $sql = "alter table incomes add balance_id bigint unsigned null after wallet_id;";
    mysqli_query($con, $sql);


    $sql = "SELECT * FROM incomes";
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
        $sql = "UPDATE incomes SET balance_id=$balance WHERE id=$id;";
        mysqli_query($con, $sql);
    }

    $sql = "alter table incomes modify balance_id bigint unsigned not null;";
    mysqli_query($con, $sql);
    $sql = "alter table incomes drop foreign key incomes_wallet_id_foreign;";
    mysqli_query($con, $sql);
    $sql = "alter table incomes drop column wallet_id;";
    mysqli_query($con, $sql);
    $sql = "alter table incomes drop column currency;";
    mysqli_query($con, $sql);
    $sql = "alter table incomes add constraint incomes_balance_id_foreign foreign key (balance_id) references balances (id);";
    mysqli_query($con, $sql);

    mysqli_commit($con);
}
catch (Exception $exception) {
    mysqli_rollback($con);

    throw $exception;
}
