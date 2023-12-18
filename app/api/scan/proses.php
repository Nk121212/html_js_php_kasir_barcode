<?php
    
    include '../config.php';
    include '../helper.php';

    $code = $_POST['code'];
    $session_fe = isset($_POST['session']) ? $_POST['session'] : "";
    $session = get_session();

    $def_harga = (isset($_POST['def_harga'])) ? $_POST['def_harga'] : '';

    $total_pcs = (isset($_POST['total_pcs'])) ? $_POST['total_pcs'] : 0;
    
    $sql = "SELECT * FROM master_harga where code = '".$code."' ";
    $result = $conn->query($sql);
    
    // echo $result->num_rows;
    // $resp = '';
    if ($result->num_rows == 0) {

        $resp = array(
            'res' => 00,
            'condition' => false
        );
        
        echo json_encode($resp);
        
    } else {

        if($session_fe !== ""){

            $harga_beli = "0";
            $harga_jual = "0";

            while ($rows = $result->fetch_assoc()) {
                $harga_beli = $rows['harga_beli'];
                $harga_jual = ($def_harga == '1') ? $rows['harga_jual_grosir'] : $rows['harga_jual_retail'];
            }

            for ($i=0; $i < (int)$total_pcs; $i++) { 
                # code...
                $sql_transaction = "INSERT INTO transaction_in (code, harga_beli, harga_jual, session, def_harga) VALUES('".$code."', ".$harga_beli.", ".$harga_jual.", '".$session."', '".$def_harga."') ";
                $conn->query($sql_transaction);
            }

        }

        $resp = array(
            'res' => 00,
            'condition' => true
        );
        
        echo json_encode($resp);
      
    }
    
    $conn->close();

?>