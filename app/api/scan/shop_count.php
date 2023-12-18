<?php

    include '../config.php';
    include '../helper.php';
    
    // $session = $_POST['session'];
    // $session = 'MTAxMjIwMjMxNDI2MDk=';
    // $session = get_session(); //get dulu session sebelum di destroy untuk query get data nya

    destroy_session();   // destroy session disini karena sudah selesai belanja

    $session = get_session_before();
    
    $sql = "
    SELECT
        B.nama_product,
        A.CODE AS code,
        COUNT( A.total_pcs ) AS total_pcs,
        A.`session` AS `session`,
        A.harga_beli AS harga_beli,
        A.harga_jual AS harga_jual,
        SUM( A.harga_jual * total_pcs ) AS total_harga
    FROM
        transaction_in A 
        INNER JOIN master_harga B ON A.CODE = B.CODE
    WHERE
        `session` = '".$session."' 
    GROUP BY
    code;
    ";
    // echo $sql;exit;
    $result = $conn->query($sql);
    
    $data = array();
    $i=0;

    while ($rows = $result->fetch_assoc()) {
        $data[$i] = array('code' => $rows['code'], 'nama_product' => $rows['nama_product'], 'total_pcs' => $rows['total_pcs'], 'harga_beli' => $rows['harga_beli'], 'harga_jual' => $rows['harga_jual'], 'total_harga' => $rows['total_harga'] );
        $i++;
    }
    
    $resp = array(
        'res' => 00,
        'message' => 'success',
        'data' => $data
    );
    
    echo json_encode($resp);
    
    $conn->close();

?>