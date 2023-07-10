<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card rounded">
                <div class="card-body" style="overflow : auto">
                    *Keterangan :
                    <ul>
                        <li>Kuning = Stok rendah</li>
                        <li>Merah = Stok habis</li>
                        <li>Putih = Stok aman</li>
                    </ul>
                    <table id="table_log" class="table table-bordered align-items-center mb-0;">
                        <thead class="table-info custh"></thead>
                        <tbody></tbody>
                    </table>
                </div>
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
                                <input type="hidden" id="kategori">
                                <div class="dropdown mb-3">
                                    <button class="form-control bg-white dropdown-toggle" style="text-align : left" type="button" id="kategori-select" data-bs-toggle="dropdown" aria-expanded="false">
                                        Pilih Kategori
                                    </button>
                                    <ul class="dropdown-menu shadow" aria-labelledby="kategori-select" style="width : 100%;">
                                        <div class="dropdown-item"><input class="form-control" type="search" oninput="filterFunction(this)" placeholder="search"></div>
                                        <?php
                                        foreach ($kategori as $kat) {
                                        ?>
                                            <li><a class="dropdown-item" data-select="<?= $kat->id ?>" onclick="$('#kategori').val(<?= $kat->id ?>); $('#kategori-select').html('<?= $kat->nama_kategori ?>')"><?= $kat->nama_kategori ?></a></li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <label for="">Satuan</label>
                                <input type="hidden" id="satuan">
                                <div class="dropdown mb-3">
                                    <button class="form-control bg-white dropdown-toggle" style="text-align : left" type="button" id="satuan-select" data-bs-toggle="dropdown" aria-expanded="false">
                                        Pilih Satuan
                                    </button>
                                    <ul class="dropdown-menu shadow" aria-labelledby="satuan-select" style="width : 100%;">
                                        <div class="dropdown-item"><input class="form-control" type="search" oninput="filterFunction(this)" placeholder="search"></div>
                                        <?php
                                        foreach ($satuan as $sat) {
                                        ?>
                                            <li><a class="dropdown-item" data-select="<?= $sat->id ?>" onclick="$('#satuan').val(<?= $sat->id ?>); $('#satuan-select').html('<?= $sat->nama_satuan ?>')"><?= $sat->nama_satuan ?></a></li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <label>Jumlah</label>
                                <input class="form-control mb-3" type="number" id="jumlah_barang" name="jumlah_barang" min="1" required>

                        </div>
                        <div class="col-sm-6" id="uluk">
                            <label>Stok</label>
                            <input class="form-control mb-3" type="number" id="stok" name="stok" min="0" required>
                            <label>Harga Satuan</label>
                            <input class="form-control mb-3" type="number" id="harga_satuan" name="harga_satuan" min="1" required>
                            <label for="">Supplier</label>

                            <input type="hidden" id="supplier">
                            <div class="dropdown mb-3">
                                <button class="form-control bg-white dropdown-toggle" style="text-align : left" type="button" id="supplier-select" data-bs-toggle="dropdown" aria-expanded="false">
                                    Pilih supplier
                                </button>
                                <ul class="dropdown-menu shadow" aria-labelledby="supplier-select" style="width : 100%;">
                                    <div class="dropdown-item"><input class="form-control" type="search" oninput="filterFunction(this)" placeholder="search"></div>
                                    <?php
                                    foreach ($supplier as $sup) {
                                    ?>
                                        <li><a class="dropdown-item" data-select="<?= $sup->id ?>" onclick="$('#supplier').val(<?= $sup->id ?>); $('#supplier-select').html('<?= $sup->nama_supplier ?>');"><?= $sup->nama_supplier ?></a></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>
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