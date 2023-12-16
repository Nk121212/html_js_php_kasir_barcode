<?php

    include '../config.php';

    $date = date("Y-m-d");

    $start = $_POST['start'];
    $length = $_POST['length'];

    $sql = "SELECT
        A.`code`,
        A.`session`,
        A.harga_beli,
        A.harga_jual,
        SUM(A.total_pcs) AS total_pcs,
        SUM(A.harga_jual * total_pcs) AS total_harga,
        SUM((A.harga_jual * total_pcs)-(A.harga_beli * total_pcs)) AS total_laba,
        A.datetime
    FROM
        transaction_in A
        INNER JOIN master_harga B ON A.`code` = B.`code` 
    WHERE
        DATE ( A.`datetime` ) = '".$date."'
        GROUP BY A.`code` LIMIT $start, $length";
    // echo $sql;
    $result = $conn->query($sql);

    $data = array();
    $i=0;

    while ($rows = $result->fetch_assoc()) {

        $data[$i] = array(
            'no' => ($i+1),
            'code' => $rows['code'], 
            'total_pcs' => $rows['total_pcs'], 
            'datetime' => $rows['datetime'],
            'harga_beli' => $rows['harga_beli'],
            'harga_jual' => $rows['harga_jual'],
            'total_harga' => $rows['total_harga'],
            'total_laba' => $rows['total_laba'],
        );

        $i++;

    }

    $resp = array(
        'resp' => 00,
        'message' => 'success',
        'data' => $data,
        'recordsFiltered' => count($data),
        'recordsTotal' => count($data),
        'query' => $sql
    );

    echo json_encode($resp, TRUE);

?>