<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card rounded">
                <div class="card-body">
                    <select id="barang" class="form form-control mb-3">
                        <?php
                        foreach ($barang as $bar) {
                        ?>
                            <option value="<?=$bar->id?>"><?=$bar->nama_barang?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <table id="table_log" class="table table-bordered align-items-center mb-0" width="100%">
                        <thead class="table-secondary custh"></thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>