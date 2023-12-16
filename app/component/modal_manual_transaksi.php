<!-- Modal -->
<div class="modal fade modal_form" id="modal_manual_tran" tabindex="-1" role="dialog" aria-labelledby="modal_formLabelby" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title font-weight-normal" id="modal_formLabel">Manual Action</h5>
            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="">
            <div class="modal-body text-center">

                <div class="row">
                    <div class="col-lg-12">
                        <a href="master_product.php"><small style="font-size: small;color:red !important;" id="emailHelp" class="form-text text-muted">*Barang tidak ada ? klik disini</small></a>
                        <br>
                    </div>
                    <div class="col-lg-12">
                        <hr>
                    </div>
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        <!-- <a href="master_product.php"><p style="font-size:small;">Barang tidak ada ?</p></a> -->
                        <select name="code" id="code_manual" class="form-control select2">
                            <?php get_list_barang_not_scanable(); ?>
                        </select>
                    </div>
                    <div class="col-lg-2"></div>
                </div>

                <div class="col-lg-12">
                    <hr>
                </div>
                
                <div class="form-check form-check-radio form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="def_harga_manual" id="def_harga_manual_1" value="1" checked> Harga Grosir
                        <span class="circle">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>
                <div class="form-check form-check-radio form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="def_harga_manual" id="def_harga_manual_2" value="2"> Harga Retail
                        <span class="circle">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>
                
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="button" class="btn bg-gradient-primary" id="btn_save_barang_manual">Save</button>
            </div>
        </form>
        </div>
    </div>
</div>