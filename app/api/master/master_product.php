<?php

// print_r($_REQUEST);exit;

    include '../config.php';

    // print_r($_POST);exit;
    $code = ($_REQUEST['action'] == 'add') ? uniqid() : $_POST['code'];
    $nama_product = $_POST['nama_product'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual_grosir = $_POST['harga_jual_grosir'];
    $harga_jual_retail = $_POST['harga_jual_retail'];
    $scanable = 2; //tidak bisa di scan

    if($_REQUEST['action'] == 'add'){

        $sql = sprintf("INSERT INTO master_harga 
            (code, nama_product, harga_beli, harga_jual_grosir, harga_jual_retail, scanable)
            VALUES 
            ('%s', '%s', %d, %d, %d, %d)"
            , $code
            , $nama_product
            , $harga_beli
            , $harga_jual_grosir
            , $harga_jual_retail
            , $scanable
        );

    }elseif($_REQUEST['action'] == 'update'){

        $sql = sprintf("UPDATE master_harga 
            SET nama_product='%s',
                harga_beli=%d,
                harga_jual_grosir=%d,
                harga_jual_retail=%d,
                scanable=%d
            WHERE code = ('%s')"
                , $nama_product
                , $harga_beli
                , $harga_jual_grosir
                , $harga_jual_retail
                , $scanable
                , $code
        );
        
    }

    $result = $conn->query($sql);

    $resp = array(
        'resp_code' => ($result) ? '00' : '99',
        'message' => ($result) ? 'success' : 'failed',
        'data' => array(),
        'query' => $sql
    );

    echo json_encode($resp, TRUE);

?>