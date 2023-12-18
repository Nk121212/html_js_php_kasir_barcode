<?php
    // print_r($_POST);exit;
    include '../config.php';
    include '../helper.php';

    $code = (isset($_POST['code'])) ? $_POST['code'] : '';
    $harga_jual_grosir = (isset($_POST['harga_jual_grosir'])) ? $_POST['harga_jual_grosir'] : '';
    $harga_jual_retail = (isset($_POST['harga_jual_retail'])) ? $_POST['harga_jual_retail'] : '';
    $harga_beli = (isset($_POST['harga_beli'])) ? $_POST['harga_beli'] : '';
    $nama_product = (isset($_POST['nama_product'])) ? $_POST['nama_product'] : '';
    // $session = (isset($_POST['session'])) ? $_POST['session'] : '';
    $def_harga = (isset($_POST['def_harga'])) ? $_POST['def_harga'] : '';
    $total_pcs = (isset($_POST['total_pcs'])) ? $_POST['total_pcs'] : 0;
    $session = get_session();
    
    if(isset($code) && $harga_beli !== '' && $harga_jual_grosir !== '' && $harga_jual_retail !== ''){ //kode belum ada di master

        $sql_master_harga = "INSERT INTO master_harga (code, harga_beli, harga_jual_grosir, harga_jual_retail, nama_product) VALUES('".$code."', ".$harga_beli.", ".$harga_jual_grosir.", ".$harga_jual_retail.", '".strtoupper($nama_product)."') ";
        $conn->query($sql_master_harga);
        // echo $sql_master_harga;

        if($def_harga == '1'){ //harga grosir
            $harga_jual = $harga_jual_grosir;
        }elseif($def_harga == '2'){ //harga retail
            $harga_jual = $harga_jual_retail;
        }

        for ($i=0; $i < (int)$total_pcs; $i++) { 
            $sql_transaction = "INSERT INTO transaction_in (code, harga_beli, harga_jual, session, def_harga) VALUES('".$code."', ".$harga_beli.", ".$harga_jual.", '".$session."', '".$def_harga."') ";
            // echo $sql_transaction;
            $conn->query($sql_transaction);
        }
        
        echo json_encode(array('res' => 00, 'message' => 'success', 'data' => array()));
        
    }
    
    $conn->close();

?>