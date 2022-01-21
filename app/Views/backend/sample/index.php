<?= $this->extend('backend/layouts/main') ?>


<?= $this->section('content') ?>
<!-- ============================================================== -->
<!-- pageheader -->
<!-- ============================================================== -->
<div class="row clearfix">
    <div class="col-12">
        <section class="card card-fluid">
            <h5 class="card-header drag-handle">
                <?php if (in_groups(array("admin", "editor"))) : ?>
                    <a class="btn btn-success btn-sm" href="<?= base_url("admin/$controller/add") ?>">Thêm</a>
                <?php endif ?>
                <a class="btn btn-primary btn-sm ml-2 text-white export">
                    <i class="fas fa-file-excel"></i>
                    Excel
                </a>
            </h5>
            <div class="card-body">
                <div class="table-responsive-md">
                    <table id="quanlytin" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Tên sản phẩm</th>
                                <th>Mã số sản phẩm</th>
                                <th>Mã số nghiên cứu</th>
                                <th>Số đề cương</th>
                                <th>Số lô</th>
                                <th>Số phân tích</th>
                                <th>Ngày sản xuất</th>
                                <th>Ngày lưu mẫu</th>
                                <th>Hành động</th>
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
        let table = $('#quanlytin').DataTable({
            "stateSave": true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": path + "admin/<?= $controller ?>/table",
                "dataType": "json",
                "type": "POST",
                'data': function(data) {
                    data['<?= csrf_token() ?>'] = "<?= csrf_hash() ?>";
                }
            },
            "columns": [{
                    "data": "id"
                }, {
                    "data": "name",
                    "width": "200px"
                },
                {
                    "data": "code"
                },
                {
                    "data": "code_research"
                },
                {
                    "data": "outline_number"
                },
                {
                    "data": "code_batch"
                },
                {
                    "data": "code_analysis"
                },
                {
                    "data": "date_manufacture"
                },
                {
                    "data": "date_storage"
                },
                {
                    "data": "action"
                }
            ],

        });

        $(".export").click(async function() {
            $(".page-loader-wrapper").show();
            let url = await $.ajax({
                "url": path + "admin/<?= $controller ?>/exportexcel",
                "data": table.ajax.params(),
                "type": "POST",
                "dataType": "JSON"
            })
            $(".page-loader-wrapper").hide();
            location.href = url;
        });
    });
</script>

<?= $this->endSection() ?>