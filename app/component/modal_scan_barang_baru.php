<!-- Modal -->
<div class="modal fade" id="modal_barang_baru" tabindex="-1" role="dialog" aria-labelledby="modal_barang_baruTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modal_barang_baruLongTitle">Action</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form id="form_scan">
                <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-center">
                        <input name="code" id="code_modal" type="hidden"/>
                        <input name="session" id="session_modal" type="hidden"/>
                        <h5 id="desc_barcode">XXXX</h5>
                        <div id="input_append"></div>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button> -->
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-gradient-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>