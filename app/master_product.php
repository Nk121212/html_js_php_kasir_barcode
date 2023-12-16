    <?php $active = 'master_product'; include 'template/header.php'; ?>

    <div class="container-fluid py-4">
        <!-- main here -->
        <a id="btn_add_barang" onclick="handle_action('', 'add')" class="btn btn-sm btn-success"><span class="material-icons">add</span> Tambah Barang</a>

        <table class="table" id="table-report">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Code</th>
                    <th>Nama Product</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual Grosir</th>
                    <th>Harga Jual Retail</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>

        <!-- Modal -->
        <div class="modal fade modal_form" class="modal_global" id="form_barang" tabindex="-1" role="dialog" aria-labelledby="modal_formLabelby" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="modal_formLabel">Edit Product</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form class="form_global">
                <div class="modal-body">
                  <div class="input-group input-group-dynamic mb-4">
                    <!-- <span class="input-group-text" id="basic-addon1">@</span> -->
                    <input type="text" class="form-control bg-gray-200" name="code" id="medit_code" placeholder="Code" readonly>
                  </div>
                  <div class="input-group input-group-dynamic mb-4">
                    <!-- <span class="input-group-text" id="basic-addon1">@</span> -->
                    <input type="text" class="form-control" name="nama_product" id="medit_nama_product" placeholder="Nama Product">
                  </div>
                  <div class="input-group input-group-dynamic mb-4">
                    <!-- <span class="input-group-text" id="basic-addon1">@</span> -->
                    <input type="number" class="form-control" name="harga_beli" id="medit_harga_beli" placeholder="Harga Beli">
                  </div>
                  <div class="input-group input-group-dynamic mb-4">
                    <!-- <span class="input-group-text" id="basic-addon1">@</span> -->
                    <input type="number" class="form-control" name="harga_jual_grosir" id="medit_harga_jual_grosir" placeholder="Harga Jual Grosir">
                  </div>
                  <div class="input-group input-group-dynamic mb-4">
                    <!-- <span class="input-group-text" id="basic-addon1">@</span> -->
                    <input type="number" class="form-control" name="harga_jual_retail" id="medit_harga_jual_retail" placeholder="Harga Jual Retail">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn bg-gradient-primary">Save changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>

    </div>

  
  <?php include 'template/footer.php'; ?>

  <script src="../assets/js/jquery.dataTables.min.js"></script>
  
  <script>

    $(document).ready(function(){

      var table_report = $('#table-report').DataTable( {
        ajax: {
            url: "api/datatable/master_product.php",
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
              data: "no", 
              visible: true,
              orderable: false,
            },
            {
              data: "code", 
              visible: true,
              orderable: true,
            },
            {
              data: "nama_product", 
              visible: true,
              orderable: true,
            },
            {
              data: "harga_beli", 
              visible: true,
              orderable: true,
            },
            {
              data: "harga_jual_grosir", 
              visible: true,
              orderable: true,
            },
            {
              data: "harga_jual_retail", 
              visible: true,
              orderable: true,
            },
            {
              data: "datetime", 
              visible: true,
              orderable: false,
              "render": function ( data, type, row, meta ) {
                return  '<button class="btn btn-sm" onclick=\'handle_action('+JSON.stringify(row)+', "edit")\'><span class="material-icons">edit</span></button>';
                        // '<button class="btn btn-sm" onclick=\'handle_action('+JSON.stringify(row)+', "delete")\'><span class="material-icons">delete</span></button>';
              }
            },
        ],
        initComplete: function () {

        }

      });

    }) //onload close

    function handle_action(data="", action){
      console.log(data);
      if(action == 'edit'){
        edit_function(data);
      }
      if(action == 'add'){
        add_function();
      }
    }

    function edit_function(data){

      $('.form_global').attr('action', 'api/master/master_product.php?action=update');

      $('#medit_code').show();
      
      $.each(data, function(k, v) {
        $('#medit_'+k).val(v);
      })
      
      $('#form_barang').modal('show');

    }

    function add_function(){

      $('.form_global')[0].reset();
      
      $('.form_global').attr('action', 'api/master/master_product.php?action=add');

      $('#medit_code').hide();

      $('#form_barang').modal('show');

    }

  </script>