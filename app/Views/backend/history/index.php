<?= $this->extend('backend/layouts/main') ?>


<?= $this->section('content') ?>
<!-- ============================================================== -->
<!-- pageheader -->
<!-- ============================================================== -->
<div class="row clearfix">
    <div class="col-12">
        <section class="card card-fluid">
            <div class="card-header">
                <div class="w-100">
                    <div class="row align-items-center">
                        <div class="col-md-5">
                            <div class="form-group mb-0">
                                <input type="text" id="daterange" class="form-control"
                                    placeholder="Chọn khoảng thời gian..." readonly
                                    style="background:#fff;cursor:pointer;">
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-end" style="gap:8px;">
                            <button type="button" id="btn-search" class="btn btn-primary">
                                <i class="fa fa-search"></i> Tìm kiếm
                            </button>
                            <button type="button" id="btn-clear" class="btn btn-secondary">
                                <i class="fa fa-times"></i> Xóa lọc
                            </button>
                        </div>
                        <div class="col-md-3 text-right d-flex align-items-end justify-content-end">
                            <button type="button" id="btn-export" class="btn btn-success">
                                <i class="fa fa-file-excel"></i> Export Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive-md">
                    <table id="quanlytin" class="table table-striped table-bordered table-hover" cellspacing="0"
                        width="100%">
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
<link rel="stylesheet" href="<?= base_url("assets/lib/daterangepicker/daterangepicker.css") ?>">
<?= $this->endSection() ?>

<!-- Script --->
<?= $this->section('script') ?>

<script src="<?= base_url('assets/lib/datatables/datatables.min.js') ?>"></script>
<script src="<?= base_url('assets/lib/datatables/jquery.highlight.js') ?>"></script>
<script src="<?= base_url('assets/lib/daterangepicker/daterangepicker.js') ?>"></script>

<script type="text/javascript">
    $(document).ready(function () {
        // Biến lưu filter ngày
        var dateFrom = '';
        var dateTo = '';

        // Khởi tạo daterangepicker
        $('#daterange').daterangepicker({
            autoUpdateInput: false,
            opens: 'right',
            locale: {
                format: 'DD/MM/YYYY',
                separator: ' - ',
                applyLabel: 'Áp dụng',
                cancelLabel: 'Xóa',
                fromLabel: 'Từ',
                toLabel: 'Đến',
                daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                    'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
                ],
                firstDay: 1
            }
        });

        $('#daterange').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            dateFrom = picker.startDate.format('YYYY-MM-DD');
            dateTo = picker.endDate.format('YYYY-MM-DD');
        });

        $('#daterange').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
            dateFrom = '';
            dateTo = '';
        });

        // DataTable
        var table = $('#quanlytin').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [[0, "desc"]],
            "ajax": {
                "url": path + "admin/<?= $controller ?>/table",
                "dataType": "json",
                "type": "POST",
                'data': function (data) {
                    data['<?= csrf_token() ?>'] = "<?= csrf_hash() ?>";
                    data['date_from'] = dateFrom;
                    data['date_to'] = dateTo;

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

        // Nút tìm kiếm
        $('#btn-search').on('click', function () {
            table.ajax.reload();
        });

        // Nút xóa lọc
        $('#btn-clear').on('click', function () {
            $('#daterange').val('');
            dateFrom = '';
            dateTo = '';
            table.ajax.reload();
        });

        // Nút export Excel
        $('#btn-export').on('click', function () {
            var btn = $(this);
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Đang xuất...');

            $.ajax({
                url: path + "admin/<?= $controller ?>/export",
                type: "POST",
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                    'date_from': dateFrom,
                    'date_to': dateTo,
                    'search_text': table.search()
                },
                success: function (response) {
                    var url = JSON.parse(response);
                    // Tạo link download tự động
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = '';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);

                    btn.prop('disabled', false).html('<i class="fa fa-file-excel"></i> Export Excel');
                },
                error: function () {
                    alert('Có lỗi xảy ra khi xuất file!');
                    btn.prop('disabled', false).html('<i class="fa fa-file-excel"></i> Export Excel');
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>