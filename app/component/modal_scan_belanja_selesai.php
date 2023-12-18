<!-- Modal -->
<div class="modal fade" id="totalBelanjaModal" tabindex="-1" role="dialog" aria-labelledby="totalBelanjaModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="totalBelanjaModalTitle">Total</h5>
            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <!--<form id="form_scan">-->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Harga Jual</th>
                                            <th>Total PCS</th>
                                            <th>Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody id="fetch_table_detail_shop">
                                        
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col-8" id="fetch_done_kembalian">

                                    </div>
                                    <div class="col-2"></div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="button" onclick="loadAndPrint()" class="btn btn-primary"><span class="material-icons">print</span> Print</button>
                </div>
            <!--</form>-->
        </div>
    </div>
</div>