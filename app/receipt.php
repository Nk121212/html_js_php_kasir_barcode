<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
    </style>
</head>
<body>
    <table style="width:100%;font-size:xxx-large;text-align:center;" border="1">
        <thead>
        <tr>
            <th>Barang</th>
            <th>Total Pcs</th>
            <th>Harga</th>
        </tr>
        </thead>
        <tbody>
            <?php

                include 'api/config.php';
                include 'api/helper.php';

                $session = get_session_before();
                // $session = "Y3JlYXRlX3Nlc3Npb24yMDIzMTIxNjA5NTM1MA==";

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

                $result = $conn->query($sql);

                $grand_total_harga_jual = 0;
                while ($rows = $result->fetch_assoc()) {

                    $grand_total_harga_jual += $rows['total_harga'];

                    echo '<tr>
                        <td>'.$rows['nama_product'].'</td>
                        <td>'.$rows['total_pcs'].'</td>
                        <td>'.$rows['total_harga'].'</td>
                    </tr>';
                }

                echo '<tr>
                    <td colspan="2" style="text-align:left;">GRAND TOTAL</td>
                    <td>'.$grand_total_harga_jual.'</td>
                </tr>';
            ?>
        </tbody>
    </table>
</body>
</html>
