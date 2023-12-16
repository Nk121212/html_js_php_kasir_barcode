<?php

    include '../config.php';

    $sql = "SELECT
        -- A.`code`,
        B.nama_product AS top_selling_item,
        COUNT(*) AS total_sell_pcs
    FROM
        transaction_in A
        INNER JOIN master_harga B ON A.`code` = B.`code` 
    GROUP BY
        A.`code` 
    ORDER BY total_sell_pcs DESC
        LIMIT 0, 10";
    // echo $sql;
    $result = $conn->query($sql);

    $data = array();
    $i=0;

    while ($rows = $result->fetch_assoc()) {

        $data['labels'] = array(
            $rows['top_selling_item'], 
        );

        $data['values'] = array(
            (int)$rows['total_sell_pcs'], 
        );

        $i++;

    }
      
    // Send the data as JSON
    header('Content-Type: application/json');
    echo json_encode($data);

?>