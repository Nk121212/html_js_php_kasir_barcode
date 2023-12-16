<?php

    // Include the PhpSpreadsheet autoload file
    include '../api/config.php';
    include '../api/helper.php';
    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    // var_dump($_REQUEST);exit;
    $target = $_REQUEST['target'];

    $hari = "";
    $bulan = "";
    $tahun = "";

    if(strtolower($target) == 'report_harian'){

        $date = date("Y-m-d");

        $hari = helper_hari($date);
        $tgl = date("d");
        $bulan = helper_bulan($date);
        $tahun = date("Y");

        $title = "Laporan Hari ".$hari.", ".$tgl." ".$bulan." ".$tahun;

        $sql = "SELECT
            A.`code`,
            B.nama_product as nama_produk,
            A.harga_beli,
            A.harga_jual,
            SUM(A.total_pcs) AS total_pcs,
            SUM(A.harga_jual * total_pcs) AS total_harga,
            SUM((A.harga_jual * total_pcs)-(A.harga_beli * total_pcs)) AS total_laba,
            A.datetime as tanggal_transaksi
        FROM
            transaction_in A
            INNER JOIN master_harga B ON A.`code` = B.`code` 
        WHERE
            DATE ( A.`datetime` ) = '".$date."'
            GROUP BY A.`code` ";

        //     var_dump($hari, $tgl, $bulan, $tahun, $title, $sql);
        // exit;
        // echo $sql;
    }elseif(strtolower($target) == 'report_bulanan'){

        $month = date("m");
        $year = date("Y");

        $dateString = $year.'-'.$month;

        $bulan = helper_bulan($dateString);

        $title = "Laporan Bulan ".$bulan." ".$year;

        $sql = "SELECT
            A.`code`,
            B.nama_product as nama_produk,
            A.harga_beli,
            A.harga_jual,
            SUM(A.total_pcs) AS total_pcs,
            SUM(A.harga_jual * total_pcs) AS total_harga,
            SUM((A.harga_jual * total_pcs)-(A.harga_beli * total_pcs)) AS total_laba,
            A.datetime as tanggal_transaksi
        FROM
            transaction_in A
            INNER JOIN master_harga B ON A.`code` = B.`code` 
        WHERE
            MONTH ( A.`datetime` ) = '".$month."'
            AND YEAR ( A.`datetime` ) = '".$year."'
            GROUP BY A.`code` ";

    }elseif(strtolower($target) == 'report_tahunan'){

        $year = date("Y");

        $title = "Laporan Tahun ".$year;

        $sql = "SELECT
            A.`code`,
            B.nama_product as nama_produk,
            A.harga_beli,
            A.harga_jual,
            SUM(A.total_pcs) AS total_pcs,
            SUM(A.harga_jual * total_pcs) AS total_harga,
            SUM((A.harga_jual * total_pcs)-(A.harga_beli * total_pcs)) AS total_laba,
            A.datetime as tanggal_transaksi
        FROM
            transaction_in A
            INNER JOIN master_harga B ON A.`code` = B.`code` 
        WHERE
            YEAR ( A.`datetime` ) = '".$year."'
            GROUP BY A.`code` ";

    }

    // echo $sql;exit;

    $result = $conn->query($sql);

    $spreadsheet = new Spreadsheet();

    // Set the active sheet
    $sheet = $spreadsheet->getActiveSheet();

    // Add headers to the Excel file
    $columns = ['Code', 'Nama Produk', 'Tanggal Transaksi', 'Harga Jual', 'Harga Beli', 'Total Pcs', 'Total Income', 'Total Laba'];
    $columnIndex = 1;

    foreach ($columns as $column) {
        $sheet->setCellValueByColumnAndRow($columnIndex++, 5, $column);
    }

    //title
    $sheet->mergeCells('A1:H3');
    $sheet->setCellValueByColumnAndRow(1, 1, $title);

    // Fetch data from MySQL and add it to the Excel file
    $rowIndex = 6;
    $grand_total_harga_jual = $grand_total_harga_beli = $grand_total_pcs = $grand_total_income = $grand_total_laba = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        // print_r($row);
        // exit;
        $columnIndex = 1;
        // foreach ($row as $value) {
            // var_dump($columnIndex++, $rowIndex, $value);
            // $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $value);
            $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $row['code']);
            $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $row['nama_produk']);
            $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $row['tanggal_transaksi']);
            $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, 'Rp. '.number_format($row['harga_jual'], 0, ',', '.'));
            $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, 'Rp. '.number_format($row['harga_beli'], 0, ',', '.'));
            $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $row['total_pcs']);
            $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, 'Rp. '.number_format($row['total_harga'], 0, ',', '.'));
            $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, 'Rp. '.number_format($row['total_laba'], 0, ',', '.'));

            $grand_total_harga_jual += $row['harga_jual'];
            $grand_total_harga_beli += $row['harga_beli'];
            $grand_total_pcs += $row['total_pcs'];
            $grand_total_income += $row['total_harga'];
            $grand_total_laba += $row['total_laba'];

        // }
        $rowIndex++;
    }

    $rowIndexForTotal = ($rowIndex+1);
    $sheet->mergeCells('A'.$rowIndexForTotal. ':C'.$rowIndexForTotal);
    $sheet->setCellValueByColumnAndRow(1, $rowIndexForTotal, 'Grand Total');
    $sheet->setCellValueByColumnAndRow(4, $rowIndexForTotal, 'Rp. '.number_format($grand_total_harga_jual, 0, ',', '.'));
    $sheet->setCellValueByColumnAndRow(5, $rowIndexForTotal, 'Rp. '.number_format($grand_total_harga_beli, 0, ',', '.'));
    $sheet->setCellValueByColumnAndRow(6, $rowIndexForTotal, $grand_total_pcs);
    $sheet->setCellValueByColumnAndRow(7, $rowIndexForTotal, 'Rp. '.number_format($grand_total_income, 0, ',', '.'));
    $sheet->setCellValueByColumnAndRow(8, $rowIndexForTotal, 'Rp. '.number_format($grand_total_laba, 0, ',', '.'));

    $sheet->getColumnDimension('A')->setWidth(25);
    $sheet->getColumnDimension('B')->setWidth(25);
    $sheet->getColumnDimension('C')->setWidth(25);
    $sheet->getColumnDimension('D')->setWidth(15);
    $sheet->getColumnDimension('E')->setWidth(20);
    $sheet->getColumnDimension('F')->setWidth(15);
    $sheet->getColumnDimension('G')->setWidth(15);
    $sheet->getColumnDimension('H')->setWidth(15);

    $alignment = [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ];

    $spreadsheet->getDefaultStyle()->getAlignment()->applyFromArray($alignment);

    $styleHeader = $sheet->getStyle('A1:H3');
    $fontHeader = $styleHeader->getFont();
    $fontHeader->setBold(true);

    $styleThead = $sheet->getStyle('A5:H5');
    $fontThead = $styleThead->getFont();
    $fontThead->setBold(true);

    $style = $sheet->getStyle('A'.$rowIndexForTotal. ':H'.$rowIndexForTotal);
    $font = $style->getFont();
    $font->setBold(true);

    $columnAStyle = $sheet->getStyle('A:A');
    $columnAStyle->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

    // Create a writer
    $writer = new Xlsx($spreadsheet);

    // Set headers to force download the file
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="exported_data_"'.date("YmdHis").'".xlsx"');
    header('Cache-Control: max-age=0');

    // Write the spreadsheet to the response
    $writer->save('php://output');

?>