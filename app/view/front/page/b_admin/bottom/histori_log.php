<script>
    const requestUrl = '<?= base_url() ?>/admin/log/getLogByDate/'+ $('#date').val();
    const logTable = $('#table_log').DataTable({
        dom: 'B<"mt-2"l>frtip',
        ajax: {
            url: requestUrl,
            dataSrc: 'data'
        },
        columns: [{
                data: 'id',
                title: 'ID'
            },
            {
                data: 'aktivitas',
                title: 'Aktivitas'
            },
            {
                data: 'waktu',
                title: 'Waktu'
            },
            {
                data: 'nama',
                title: 'User'
            },
            {
                data: 'detail',
                title: 'Detil'
            }
        ],
        columnDefs: [{
            targets: [0, 1, 2, 3, 4], // Specify the columns you want to customize
            className: 'text-uppercase text-dark text-xxs font-weight-bolder opacity-7'
        }],
        buttons: [{
                extend: 'print',
                exportOptions: {
                    columns: ':visible:not(:last-child)' // Exclude last column from print
                }
            },
            {
                extend: 'copy',
                exportOptions: {
                    columns: ':visible:not(:last-child)' // Exclude last column from print
                }
            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: ':visible:not(:last-child)' // Exclude last column from print
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:not(:last-child)' // Exclude last column from print
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':visible:not(:last-child)' // Exclude last column from print
                }
            }
        ]
    });

    document.getElementById('date').addEventListener('change', () => {
        const newUrl = '<?= base_url() ?>/admin/log/getLogByDate/'+ $('#date').val();
        console.log(logTable.ajax);
        logTable.ajax.url(newUrl);
        logTable.ajax.reload(null, false);
    });
</script>