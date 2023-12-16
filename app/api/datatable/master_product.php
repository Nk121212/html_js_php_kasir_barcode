<?php

    include '../config.php';

    $month = date("m");
    $year = date("Y");

    $start = $_POST['start'];
    $length = $_POST['length'];

    $sql = "SELECT * FROM master_harga LIMIT $start, $length";
    // echo $sql;
    $result = $conn->query($sql);

    $data = array();
    $i=0;

    while ($rows = $result->fetch_assoc()) {

        $data[$i] = array(
            'no' => ($i+1),
            'code' => $rows['code'], 
            'harga_beli' => $rows['harga_beli'],
            'harga_jual_grosir' => $rows['harga_jual_grosir'],
            'harga_jual_retail' => $rows['harga_jual_retail'],
            'scanable' => $rows['scanable'],
            'nama_product' => $rows['nama_product'],
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