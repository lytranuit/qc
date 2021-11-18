<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-3">
        <div class="card report-card bg-purple-gradient shadow-purple box-hover" data-id="1">
            <div class="card-body">
                <div class="float-right">
                    <i class="fa fa-print report-main-icon bg-icon-danger"></i>
                </div>
                <span class="badge badge-light text-purple">Mẫu</span>
                <h3 class="my-3"><?= $num_sample ?></h3>
            </div>
            <!--end card-body-->
        </div>
    </div>
</div>

<div class="row justify-content-center pt-3">

    <div class="col-md-6 pt-2 pt-md-0" id="sample">
        <div class="card card-fluid">
            <div class="card-header">
                Mẫu lấy trong
                <div class="btn-group ml-2 type_sample" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-light active" data-value="d">Ngày</button>
                    <button type="button" class="btn btn-light" data-value="w">Tuần</button>
                    <button type="button" class="btn btn-light" data-value="M">Tháng</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive-md">
                    <table id="quanly" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Tên sản phẩm</th>
                                <th>Mã số sản phẩm</th>
                                <th>Số lô</th>
                                <th>Ngày lấy mẫu</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 pt-2 pt-md-0" id="sample">
        <div class="card card-fluid">
            <div class="card-header">
                Quá ngày lấy mẫu
            </div>
            <div class="card-body">
                <div class="table-responsive-md">
                    <table id="quanly1" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Tên sản phẩm</th>
                                <th>Mã số sản phẩm</th>
                                <th>Số lô</th>
                                <th>Ngày lấy mẫu</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
<script type='text/javascript'>
    $(document).ready(function() {
        let id = 1;
        let table = $('#quanly').DataTable({
            "stateSave": true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": path + "admin/home/table",
                "dataType": "json",
                "type": "POST",
                'data': function(data) {
                    data['<?= csrf_token() ?>'] = "<?= csrf_hash() ?>";
                    let type = $(".type_sample .btn.active").data("value");
                    data['type'] = type;
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
                    "data": "name",
                    "orderable": false
                }, {
                    "data": "code",
                },
                {
                    "data": "code_batch"
                },
                {
                    "data": "date_theory"
                }
            ]
        });
        let table1 = $('#quanly1').DataTable({
            "stateSave": true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": path + "admin/home/table1",
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
                    "data": "id",
                }, {
                    "data": "name",
                    "orderable": false
                }, {
                    "data": "code",
                },
                {
                    "data": "code_batch"
                },
                {
                    "data": "date_theory"
                }
            ]
        });
        $(".type_sample .btn").click(function() {
            $(".type_sample .btn").removeClass("active");
            $(this).addClass("active");
            table.ajax.reload();
        })
        // $(".box-hover").click(function() {
        //     let name = $(this).find(".badge").text();
        //     id = $(this).data("id");
        //     $("#document .card-header").text(name);
        //     table.ajax.reload();
        // })
    });
</script>
<?= $this->endSection() ?>