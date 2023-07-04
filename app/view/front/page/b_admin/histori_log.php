<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card rounded">
                <div class="card-body">
                    <input type="date" id="date" class="form form-control mb-3" value="<?=date("Y-m-d", time())?>">

                    <table id="table_log" class="table table-bordered align-items-center mb-0" width="100%">
                        <thead class="table-info"></thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const data = <?= $log ?>;
    data.forEach(data => {
        if(!data.detail){
            data.detail = "-";
        }
    });
</script>