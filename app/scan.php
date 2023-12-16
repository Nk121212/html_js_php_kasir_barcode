
    <?php 
        $active = 'scan'; 
        include 'api/helper.php';
        include 'template/header.php'; 
        include 'component/modal_scan_barang_ada.php'; 
        include 'component/modal_scan_barang_baru.php'; 
        include 'component/modal_scan_belanja_selesai.php'; 
        include 'component/modal_manual_transaksi.php'; 
    ?>

    <div class="container-fluid py-4">
        
        <div class="col-lg-12" id="scanner-container">

        </div>
        
        <div class="col-lg-12">
            <button class="btn btn-warning" id="btn_manual_transact" style="width: -webkit-fill-available;">Transaksi Manual <span class="material-icons">shopping_cart</span></button>
            <button class="btn btn-success" id="shop_done" style="width: -webkit-fill-available;">Belanja Selesai <span class="material-icons">done</span></button>
            <!-- <button type="button" class="btn btn-primary" id="btn_test" style="width: -webkit-fill-available;">test</button> -->
        </div>
        
        <audio id="myAudio" controls style="display:none;">
            <source src="sound_scan.mp3" type="audio/mp3">
            Your browser does not support the audio element.
        </audio>
        
    </div>
  
    <?php include 'template/footer.php'; ?>

    <script src="../quagga.min.js"></script>

    <script>

      let detectionFlag = false;
      let session = "";
      let shop = [];
      var audio = document.getElementById("myAudio");
      let dynamic_code = "";

    $(document).ready(function(){

        $('.select2').select2({
            data: <?php echo json_encode(get_list_barang_not_scanable()); ?>,
            dropdownParent: $("#modal_manual_tran")
        });

        const scannerContainer = document.getElementById("scanner-container");
        
        Quagga.init({
        inputStream: {
            name: "Live",
            type: "LiveStream",
            target: scannerContainer,
            constraints: {
                // width: 358,
                // height: 360,
                // width: window.innerWidth,
                // height: window.innerHeight,
                facingMode: "environment" // or "user" for front camera
            },
        },
        // locator: {
        //     patchSize: "medium",
        //     halfSample: true,
        // },
        decoder: {
            readers : [
                "code_128_reader", 
                "ean_reader", 
                // "upc_reader", 
                // "code_39_reader", 
                // "code_93_reader", 
                // "codabar_reader", 
                // "itf_reader"
            ]
        },
        // locate: true,
        frequency: 10,
        numOfWorkers: navigator.hardwareConcurrency || 3, // Use the number of available CPU cores for worker threads
            
        }, function (err) {

            if (err) {
                console.error(err);
                return;
            }

            Quagga.start();
            
        });
        
        Quagga.onDetected(function (result) {

            alert('scanned');
            
            if (detectionFlag == false) {
                audio.play();
                detectionFlag = true;
                var code = result.codeResult.code;
                dynamic_code = code;
                set_session(); //buat sesi baru jika sesi sudah kosong
                check_exist(code);
            }
        
        });


        // $('#btn_test').click(function(){
        //     detectionFlag = true;
        //     var code = '1234';
        //     dynamic_code = code;
        //     set_session(); //buat sesi baru jika sesi sudah kosong
        //     check_exist(code);
        // })
        
        $("#form_scan").submit(function(e) { //jika belum ada barangnya masuk sini

            e.preventDefault(); // avoid to execute the actual submit of the form.
        
            var form = $(this);
            // var actionUrl = form.attr('action');
            
            $.ajax({
                type: "POST",
                url: 'api/scan/actions.php',
                data: form.serialize(), // serializes the form's elements.
                success: function(data)
                {
                    result = JSON.parse(data);
                    
                    if(result.res == '00'){
                        alert('success save transaction & master data');
                        detectionFlag = false;
                        $('#modal_barang_baru').modal('toggle'); //tutup modal
                    }
                }
            });
            
        });

        $('#btn_save_barang_ada').click(function(){
            var def_harga = $('input[name="def_harga_ada"]:checked').val();
            save_transaction(dynamic_code, def_harga);
            $('#modal_barang_ada').modal('hide');
        })

        $('#btn_manual_transact').click(function(){
            $('#modal_manual_tran').modal('show');
        })

        $('#btn_save_barang_manual').click(function(){
            console.log($('#code_manual').val());
            var code_from_manual_transac = $('#code_manual').val();
            var def_harga = $('input[name="def_harga_manual"]:checked').val();
            set_session();
            save_transaction(code_from_manual_transac, def_harga);
            $('#modal_manual_tran').modal('hide');
        })
            
        $('#shop_done').click(function(){
            $.ajax({
                url: "api/scan/shop_count.php",
                method: "POST",
                data: {session: session},
                beforeSend: function() {
                    // notif_load();
                },
                success: function(data){

                    // alert('shop count = '+data);
                    // console.log(data);
                    $("#fetch_table_detail_shop").html("");

                    result = JSON.parse(data);
                    // audio.play();
                    
                    if(result.res == '00'){
                        
                        $('#totalBelanjaModal').modal('show');
                        var no = 1;
                        $.each(result.data, function(i, item) {
                            // alert(item.PageName);
                            $('#fetch_table_detail_shop').append('<tr>'+
                                '<td>'+no+'</td>'+
                                '<td>'+item.code+'</td>'+
                                '<td>'+item.harga_jual+'</td>'+
                                '<td>'+item.total_pcs+'</td>'+
                                '<td>'+item.total_harga+'</td>'+
                            '</tr>');
                            
                            no++;
                        });

                        // detectionFlag = false;
                        session = "";
                        
                    }
                }
            });
        })
    }) 

    function check_exist(code){
            
        var data_json = {
            code: code
        }

        $.ajax({
            url: "api/scan/proses.php",
            method: "POST",
            data: data_json,
            beforeSend: function() {
                // notif_load();
            },
            success: function(data){

                    result = JSON.parse(data);
                    
                if(result.res == '00'){

                    if(result.condition == false){ //jika data belum ada di tabel master barcode

                        $('#modal_barang_baru').modal('show');
                        $('#desc_barcode').html('<h6 style="color: red;">*Data Belum Ada, Silakan Masukan Harga Beli & Harga Jual</h6>');
                        $('#code_modal').val(code);
                        $('#session_modal').val(session);
                    //   $('div#input_append').html('<input type="number" name="harga_beli" id="harga_beli" class="form-control" placeholder="Input Harga Beli">'+
                    //   '<input type="number" name="harga_jual" id="harga_jual" class="form-control" placeholder="Input Harga Jual">');

                        $('div#input_append').html('<div class="input-group input-group-dynamic mb-4">'+
                        '<input type="text" class="form-control" name="nama_product" id="medit_nama_product" placeholder="Nama Product">'+
                        '</div>'+
                        '<div class="input-group input-group-dynamic mb-4">'+
                            '<input type="number" class="form-control" name="harga_beli" id="harga_beli" placeholder="Harga Beli">'+
                        '</div>'+
                        '<div class="input-group input-group-dynamic mb-4">'+
                            '<input type="number" class="form-control" name="harga_jual_grosir" id="harga_jual_grosir" placeholder="Harga Jual Grosir">'+
                        '</div>'+
                        '<div class="input-group input-group-dynamic mb-4">'+
                            '<input type="number" class="form-control" name="harga_jual_retail" id="harga_jual_retail" placeholder="Harga Jual Retail">'+
                        '</div>'+
                        '<div class="form-check form-check-radio form-check-inline">'+
                            '<label class="form-check-label">'+
                                '<input class="form-check-input" type="radio" name="def_harga" id="def_harga_1" value="1" checked> Harga Grosir '+
                                '<span class="circle">'+
                                    '<span class="check"></span>'+
                                '</span>'+
                            '</label>'+
                        '</div>'+
                        '<div class="form-check form-check-radio form-check-inline">'+
                            '<label class="form-check-label">'+
                                '<input class="form-check-input" type="radio" name="def_harga" id="def_harga_2" value="2"> Harga Retail '+
                                '<span class="circle">'+
                                    '<span class="check"></span>'+
                                '</span>'+
                            '</label>'+
                        '</div>');

                            // detectionFlag = false;

                    }else{

                        $('#modal_barang_ada').modal('show');
                        // save_transaction(code);
                        detectionFlag = false;
                    }
                        
                }

            }
        });
    }

    function save_transaction(code, def_harga){

        var data_json = {
            code: code,
            session: session,
            def_harga: def_harga
        }

        $.ajax({
            url: "api/scan/proses.php",
            method: "POST",
            data: data_json,
            beforeSend: function() {
                // notif_load();
                detectionFlag = true;
            },
            success: function(data){

                result = JSON.parse(data);
                // alert(result);
                if(result.res == '00'){
                    alert('success save transaction');
                    detectionFlag = false;
                }
            }
        });

    }

    function set_session(){

        if(session == ""){
            var currentDate = new Date();

            // Format the date as dmyhis
            var formattedDate = ('0' + currentDate.getDate()).slice(-2) + 
                                ('0' + (currentDate.getMonth() + 1)).slice(-2) + 
                                currentDate.getFullYear() + 
                                ('0' + currentDate.getHours()).slice(-2) + 
                                ('0' + currentDate.getMinutes()).slice(-2) + 
                                ('0' + currentDate.getSeconds()).slice(-2);

            var base64EncodedDate = btoa(formattedDate);

            session = base64EncodedDate;

        }
        
    }

    </script>