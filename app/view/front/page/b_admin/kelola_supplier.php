<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card rounded">
                <div class="card-body">
                    <table id="table_log" class="table table-bordered align-items-center mb-0" width="100%">
                        <thead class="table-info custh"></thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="editm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content container py-3">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="froms">
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="froms">
                                <label>Nama Supplier</label>
                                <input class="form-control mb-3" type="nama_supplier" id="nama_supplier" name="nama" placeholder="Nama User" required>
                                <label>No. Telepon</label>
                                <input class="form-control mb-3" type="telepon" id="telepon" name="email" placeholder="Masukan alamat email" required>
                                <label>Alamat</label>
                                <textarea name="alamat" id="alamat" class="form-control mb-3"></textarea>
                                <input type="hidden" id="id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" id="submit" data-bs-dismiss="modal">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>