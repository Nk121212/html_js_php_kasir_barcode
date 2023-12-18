<!-- Modal -->
<div class="modal fade modal_form" id="modal_barang_ada" tabindex="-1" role="dialog" aria-labelledby="modal_formLabelby" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title font-weight-normal" id="modal_formLabel">Action</h5>
            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- <form id="form_scan_ada"> -->
            <div class="modal-body text-center">

                <div class="col-12">
                    <div class="input-group input-group-dynamic mb-4">
                        <input type="number" class="form-control" name="total_pcs" id="total_pcs_brg_ada" placeholder="Total Pcs">
                    </div>
                </div>
                <div class="form-check form-check-radio form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="def_harga_ada" id="def_harga_ada_1" value="1" checked> Harga Grosir
                        <span class="circle">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>
                <div class="form-check form-check-radio form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="def_harga_ada" id="def_harga_ada_2" value="2"> Harga Retail
                        <span class="circle">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>
                
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="button" class="btn bg-gradient-primary" id="btn_save_barang_ada">Save</button>
            </div>
        <!-- </form> -->
        </div>
    </div>
</div>