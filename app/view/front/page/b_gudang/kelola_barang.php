<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card rounded">
                <div class="card-body" style="overflow : auto">
                    <table id="table_log" class="table table-bordered align-items-center mb-0;">
                        <thead class="table-info custh"></thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modalStok" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content container py-3">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Tambah Stok</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <label>Stok</label>
                        <input class="form-control mb-3" type="number" id="tambah_stok" name="kode_barang" min="1" required>
                        <label>Kadaluarsa</label>
                        <input class="form-control mb-3" type="date" id="kadaluarsa" name="nama_barang" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="submit2" data-bs-dismiss="modal">Submit</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="editm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content container py-3">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="froms">
                    <div class="row">
                        <div class="col-sm-6">
                            <form id="froms">
                                <label>Kode Barang</label>
                                <input class="form-control mb-3" type="search" id="kode_barang" name="kode_barang" maxlength="50" required>
                                <label>Nama Barang</label>
                                <input class="form-control mb-3" type="search" id="nama_barang" name="nama_barang" maxlength="50" required>
                                <label for="">Kategori</label>
                                <select class="form-control bg-white mb-3" id="kategori" name="satuan" required>
                                    <option disabled selected hidden value="">Pilih kategori</option>
                                    <?php
                                    foreach ($kategori as $kat) {
                                    ?>
                                        <option value="<?= $kat->id ?>"><?= $kat->nama_kategori ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="">Satuan</label>
                                <select class="form-control bg-white mb-3" id="satuan" name="satuan" required>
                                    <option disabled selected hidden value="">Pilih satuan</option>
                                    <?php
                                    foreach ($satuan as $sat) {
                                    ?>
                                        <option value="<?= $sat->id ?>"><?= $sat->nama_satuan ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label>Jumlah</label>
                                <input class="form-control mb-3" type="number" id="jumlah_barang" name="jumlah_barang" min="1" required>

                        </div>
                        <div class="col-sm-6" id="uluk">
                            <label>Stok</label>
                            <input class="form-control mb-3" type="number" id="stok" name="stok" min="0" required>
                            <label>Harga Satuan</label>
                            <input class="form-control mb-3" type="number" id="harga_satuan" name="harga_satuan" min="1" required>
                            <label for="">Supplier</label>
                            <select class="form-control bg-white mb-3" id="supplier" name="supplier" required>
                                <option disabled selected hidden value="">Pilih Supplier</option>
                                <?php
                                foreach ($supplier as $sup) {
                                ?>
                                    <option value="<?= $sup->id ?>"><?= $sup->nama_supplier ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <label>Tanggal Masuk</label>
                            <input class="form-control mb-3" type="date" id="tanggal_masuk" name="tanggal_masuk" required>
                            <label>Tanggal Kadaluarsa</label>
                            <input class="form-control mb-3" type="date" id="expired_date" name="expired_date" required>
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