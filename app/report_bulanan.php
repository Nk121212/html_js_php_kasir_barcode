    <?php $active = 'report_bulanan'; include 'template/header.php'; ?>

    <div class="container-fluid py-4">
        <!-- main here -->
        <div class="col-lg-12">
          <a id="btn_download_excel" class="btn btn-sm btn-success"><span class="material-icons">file_download</span> Excel</a>
          <!-- <a id="btn_download_pdf" class="btn btn-sm btn-danger"><span class="material-icons">file_download</span> PDF</a> -->
        </div>

        <table class="table" id="table-report">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Code</th>
                    <th>Harga Jual</th>
                    <th>Total PCS</th>
                    <th>Total Harga</th>
                    <th>Date</th>
                </tr>
            </thead>
        </table>
    </div>

  
  <?php include 'template/footer.php'; ?>

  <script src="../assets/js/jquery.dataTables.min.js"></script>
  
  <script>

    $(document).ready(function(){

      var table_report = $('#table-report').DataTable( {
        ajax: {
            url: "api/datatable/report_bulanan.php",
            data: function(data){
                //data.search.status = $("#status").val();
                // data.search.doc_type = $("#doc_type").val();
                // data.search.date_from = $("#date_from").val();
                // data.search.date_to = $("#date_to").val();
                // data.search.search = $('#search').val();
            },
            dataSrc: 'data',
        },
        searching: false,
        "bLengthChange" : false,
        fnInfoCallback: function( oSettings, iStart, iEnd, iMax, iTotal, sPre ) {
            return "Show "+iStart+" to "+iEnd+" of "+(oSettings.json ? oSettings.json.recordsTotal : iTotal)+" Entries";
        },
        pagingType: 'full_numbers',
        language: {paginate: {
            first: '<i class="fa fa-step-backward"></i>',
            last: '<i class="fa fa-step-forward"></i>',
            previous: '<i class="fa fa-backward"></i>',
            next: '<i class="fa fa-forward"></i>',
        },
        lengthMenu: ",Show _MENU_ Entries"},
        paging: true,
        order: [[ 5, "desc" ]],
        dom: 'tilp',
        pageLength: 10,
        lengthMenu: [
            [ 10, 25, 50, 100, -1 ],
            [ '10', '25', '50','100', 'Show all' ]
        ],
        serverSide: true,
        serverMethod: 'post',
        columns: [
            {
              data: "no", visible: true
            },
            {
              data: "code", visible: true
            },
            {
              data: "harga_jual", visible: true
            },
            {
              data: "total_pcs", visible: true
            },
            {
              data: "total_harga", visible: true
            },
            {
              data: "datetime", visible: true
            },
        ],
        initComplete: function () {
            // $("#DataTables_Table_0_length").addClass("mt-2 mb-2 ml-1")
            // const labelElm = $("#DataTables_Table_0_length").find("label")
            // labelElm.addClass("d-flex align-items-center")
            // const selectElm = $("#DataTables_Table_0_length").find("select")
            // selectElm.addClass("form-control form-control-sm ml-2 mr-2")
        }
      });

      $('#btn_download_excel').click(function(){
        var url = 'export_excel/export_file.php?target=report_bulanan';
        window.open(url, '_blank');
      })

      $('#btn_download_pdf').click(function(){
        var url = 'export_pdf/export_file.php?target=report_bulanan';
        window.open(url, '_blank');
      })

    })

  </script>