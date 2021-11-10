<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->endSection() ?>

<!-- Style --->
<?= $this->section("style") ?>
<link rel="stylesheet" href="<?= base_url("assets/lib/datatables/datatables.min.css") ?> " ?>
<?= $this->endSection() ?>


<!-- Script --->
<?= $this->section('script') ?>

<script src="<?= base_url('assets/lib/datatables/datatables.min.js') ?>"></script>
<script src="<?= base_url('assets/lib/datatables/jquery.highlight.js') ?>"></script>
<script type='text/javascript'>
    $(document).ready(function() {
        let id = 1;
        let table = $('#quanly').DataTable({
            "stateSave": true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": path + "admin/document/table",
                "dataType": "json",
                "type": "POST",
                'data': function(data) {
                    // Read values
                    // let search_type = localStorage.getItem('SEARCH_TYPE') || "code";
                    // let search_status = localStorage.getItem('SEARCH_STATUS') || "0";
                    // let filter = localStorage.getItem('SEARCH_FILTER') || "0";
                    // data['search_type'] = search_type;
                    // data['search_status'] = search_status;
                    // data['filter'] = filter;
                    
                    data['search_type'] = "code";
                    switch (id) {
                        case 1:
                            break;
                        case 2:
                            data['search_type'] = "status";
                            data['search_status'] = 2;
                            break;
                        case 3:
                            data['search_type'] = "status";
                            data['search_status'] = 4;
                            break;
                        case 4:
                            data['filter'] = "4";
                            break;
                        case 5:
                            data['filter'] = "5";
                            break;
                        case 6:
                            data['filter'] = "6";
                            break;
                    }
                    data['<?= csrf_token() ?>'] = "<?= csrf_hash() ?>";

                    let orders = data['order'];
                    for (let i in orders) {
                        let order = orders[i];
                        let column = order['column'];
                        orders[i]['data'] = data['columns'][column]['data'];
                    }
                }
            },
            "columns": [{
                    "data": "id",
                }, {
                    "data": "code",
                }, {
                    "data": "name_vi",
                    "width": "500px",
                    "orderable": false
                },
                {
                    "data": "status"
                },
                {
                    "data": "type"
                },
                {
                    "data": "file",
                    "orderable": false
                },
                {
                    "data": "action",
                    "orderable": false
                }
            ]
        });
        $(".box-hover").click(function() {
            let name = $(this).find(".badge").text();
            id = $(this).data("id");
            $("#document .card-header").text(name);
            table.ajax.reload();
        })
    });
</script>
<?= $this->endSection() ?>