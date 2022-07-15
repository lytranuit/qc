<?= $this->extend('backend/layouts/main') ?>


<?= $this->section('content') ?>
<!-- ============================================================== -->
<!-- pageheader -->
<!-- ============================================================== -->
<div class="row clearfix">
    <div class="col-12">
        <section class="card card-fluid">
            <div class="card-body">
                <div class="table-responsive-md">
                    <table id="quanlytin" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Ngày</th>
                                <th>User</th>
                                <th>Mô tả</th>
                                <th>Data cũ</th>
                                <th>Data mới</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>

<?= $this->endSection() ?>
<!-- Style --->
<?= $this->section("style") ?>

<link rel="stylesheet" href="<?= base_url("assets/lib/datatables/datatables.min.css") ?> " ?>
<?= $this->endSection() ?>

<!-- Script --->
<?= $this->section('script') ?>

<script src="<?= base_url('assets/lib/datatables/datatables.min.js') ?>"></script>
<script src="<?= base_url('assets/lib/datatables/jquery.highlight.js') ?>"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#quanlytin').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": path + "admin/<?= $controller ?>/table",
                "dataType": "json",
                "type": "POST",
                'data': function(data) {
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
                    "data": "created_at"
                }, {
                    "data": "name"
                },
                {
                    "data": "description",
                    "width": "400px"
                },
                {
                    "data": "old_values",
                    "orderable": false
                },
                {
                    "data": "new_values",
                    "orderable": false
                }
            ]


        });
    });
</script>

<?= $this->endSection() ?>