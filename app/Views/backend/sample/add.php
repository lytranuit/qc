<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('content') ?>
<div class="row clearfix">
    <div class="col-12">
        <form method="POST" action="" id="form-dang-tin">
            <?= csrf_field() ?>
            <section class="card card-fluid">
                <h5 class="card-header">
                    <div class="d-inline-block w-100">
                        <button type="submit" name="dangtin" class="btn btn-sm btn-primary float-right">Save</button>
                    </div>
                </h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Tên sản phẩm:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="name" required=""
                                        placeholder="Tên" />
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Số lô:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="code_batch"
                                        required="" placeholder="Số lô" />
                                </div>

                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Mã sản phẩm:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="code"
                                        placeholder="Mã sản phẩm" />
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Mục đích nghiên cứu:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <select class="form-control form-control-sm" id="code_research_select">
                                        <option value="">-- Chọn mục đích --</option>
                                        <option value="3 lô sản xuất đầu tiên">3 lô sản xuất đầu tiên</option>
                                        <option value="Lô nghiên cứu hằng năm">Lô nghiên cứu hằng năm</option>
                                        <option value="Lô thẩm định do thay đổi công thức pha chế">Lô thẩm định do thay
                                            đổi công thức pha chế</option>
                                        <option value="Lô thẩm định do thay đổi quy trình sản xuất">Lô thẩm định do thay
                                            đổi quy trình sản xuất</option>
                                        <option value="Nghiên cứu hạn dùng sau khi mở nắp">Nghiên cứu hạn dùng sau khi
                                            mở nắp</option>
                                        <option value="Nghiên cứu độ ổn định lô pilot">Nghiên cứu độ ổn định lô pilot
                                        </option>
                                        <option value="custom">Tùy chỉnh (Tự điền nội dung)</option>
                                    </select>
                                    <input class="form-control form-control-sm mt-1 code_research_custom_input"
                                        type="text" placeholder="Tự điền nội dung" style="display:none;" />
                                    <input type="hidden" name="code_research" id="code_research" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Số đề cương:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="outline_number"
                                        placeholder="Số đề cương" />
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Số quyết định:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="decision_number"
                                        placeholder="Số quyết định" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Ngày sản xuất:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='date' name="date_manufacture"
                                        required="" placeholder="Ngày sản xuất" />
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Ngày lưu mẫu:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='date' name="date_storage"
                                        required="" placeholder="Ngày lưu mẫu vào tủ" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Quy cách:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-10 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="specification"
                                        placeholder="Quy cách" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Hạn dùng:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='date' name="date_expire"
                                        placeholder="Hạn dùng" />
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Đơn vị:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="unit"
                                        placeholder="Đơn vị" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Tổng số:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='number' name="amount" required=""
                                        readonly style="background:#e9ecef;" />
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Còn lại:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='number' name="remain" readonly />
                                </div>
                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Thông báo cho:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-10 pt-1">
                                    <select name="alerts[]" class="form-control form-control-sm chosen" multiple="">
                                        <?php foreach ($users as $row): ?>
                                            <option value="<?= $row->Email ?>"><?= $row->FullName ?> (<?= $row->Email ?>)
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">

                        </div>
                    </div>

                </div>
            </section>
        </form>

        <!-- Storage Summary Card -->
        <section class="card card-fluid mt-2 storage-summary-card">
            <h5 class="card-header d-flex align-items-center" style="gap:8px">
                <i class="fas fa-warehouse text-primary"></i>
                <span style="font-size:1rem;font-weight:700;">Khu vực &amp; Điều kiện lưu mẫu</span>
            </h5>
            <div class="card-body p-0">
                <div id="storage-summary-container">
                    <div class="text-center text-muted p-3 ss-empty">
                        <i class="fas fa-info-circle mr-1"></i>Thêm dòng ngày lấy mẫu để hiển thị thống kê khu vực lưu
                        mẫu.
                    </div>
                </div>
            </div>
        </section>

        <section class="card card-fluid mt-2 sample-table-card">
            <h5 class="card-header d-flex align-items-center justify-content-between flex-wrap" style="gap:8px">
                <span class="sample-table-title"><i class="fas fa-calendar-alt mr-2 text-primary"></i>Ngày lấy
                    mẫu</span>
                <div class="d-flex align-items-center" style="gap:8px">
                    <select class="form-control form-control-sm env_id" style="width:210px">
                        <?php foreach ($envs as $row): ?>
                            <option value="<?= $row->id ?>"><?= $row->name ?></option>
                        <?php endforeach ?>
                    </select>
                    <button class="btn btn-sm btn-outline-primary quick_add"><i class="fas fa-magic mr-1"></i>Thêm
                        nhanh</button>
                    <button class="btn btn-sm btn-success add_time"><i class="fas fa-plus mr-1"></i>Thêm dòng</button>
                </div>
            </h5>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover sample-times-table mb-0">
                        <thead>
                            <tr>
                                <th class="text-center" style="min-width:130px">Tên</th>
                                <th class="text-center" style="min-width:140px">Khu vực lưu mẫu</th>
                                <th class="text-center" style="min-width:120px">Vị trí</th>
                                <th class="text-center" style="min-width:160px">Điều kiện</th>
                                <th class="text-center" style="min-width:90px">Thời gian</th>
                                <th class="text-center" style="min-width:110px">Loại TG</th>
                                <th class="text-center" style="min-width:180px">So với</th>
                                <th class="text-center" style="min-width:90px">SL lấy mẫu</th>
                                <th class="text-center" style="min-width:145px">Ngày LM lý thuyết</th>
                                <th class="text-center" style="min-width:145px">Ngày LM thực tế</th>
                                <th class="text-center" style="min-width:220px">Chỉ tiêu</th>
                            </tr>
                        </thead>
                        <tbody class="list_time">
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>

<template class="times">
    <tr class="item" data-id="{{id}}">
        <td>
            <input type="text" name="name" class="form-control form-control-sm name" placeholder="Tên">
        </td>
        <td>
            <select name="storage_id" class="form-control form-control-sm storage_id">
                <option value="">-- Khu vực --</option>
            </select>
        </td>
        <td>
            <input type="text" name="location" class="form-control form-control-sm location" placeholder="Vị trí">
        </td>
        <td>
            <select class="form-control form-control-sm type_id" name="type_id" readonly>
                <option value="1">Lão hóa</option>
                <option value="2">Trung gian</option>
                <option value="3">Dài hạn (Vùng IV)</option>
                <option value="4">Dài hạn (Vùng III)</option>
                <option value="5">Dài hạn (Vùng I và II)</option>
            </select>
        </td>
        <td class="td-time">
            <input type="number" name="time" class="form-control form-control-sm time" placeholder="0">
        </td>
        <td class="td-type-time">
            <select class="form-control form-control-sm type_time" name="type_time">
                <option value="d">Ngày</option>
                <option value="w">Tuần</option>
                <option value="M" selected>Tháng</option>
                <option value="y">Năm</option>
            </select>
        </td>
        <td class="td-custom-date d-none" colspan="2" style="min-width:200px">
            <div class="text-center" style="gap:4px">
                <input type="text" name="note_type" class="form-control form-control-sm note_type" value="Hạn dùng">
            </div>
        </td>
        <td>
            <select class="form-control form-control-sm based" name="based">
                <option value="custom">Tùy chỉnh</option>
                <option value="date_manufacture">So với ngày sản xuất</option>
                <option value="date_storage">So với ngày lưu mẫu</option>
            </select>
        </td>
        <td>
            <input type="number" name="num_get" class="form-control form-control-sm num_get" placeholder="0">
        </td>
        <td>
            <input type="date" name="date_theory" class="form-control form-control-sm date_theory" readonly>
        </td>
        <td>
            <input type="date" name="date_reality" class="form-control form-control-sm date_reality">
        </td>
        <td>
            <div class="d-flex align-items-center" style="gap:6px">
                <textarea name="note" class="form-control form-control-sm note" rows="1" placeholder="Chỉ tiêu"
                    style="flex:1;min-width:0;"></textarea>
                <span class="badge badge-success status d-none" title="Đã lấy mẫu"
                    style="font-size:13px;padding:6px 8px;"><i class="fas fa-check"></i></span>
                <button class="btn btn-sm btn-outline-danger remove_time" title="Xóa dòng"><i
                        class="fas fa-trash-alt"></i></button>
            </div>
        </td>
    </tr>
</template>
<?= $this->endSection() ?>



<!-- Style --->
<?= $this->section('style') ?>

<link rel="stylesheet" href="<?= base_url("assets/lib/chosen/chosen.min.css") ?>" ?>
<style>
    .sample-table-card .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 2px solid #dee2e6;
        padding: 12px 20px;
    }

    .sample-table-title {
        font-size: 1rem;
        font-weight: 700;
        color: #343a40;
        letter-spacing: 0.3px;
    }

    .sample-times-table thead th {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: #fff;
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        vertical-align: middle;
        border-color: #4a5568;
        padding: 10px 8px;
        white-space: nowrap;
    }

    .sample-times-table tbody tr {
        transition: background 0.15s;
    }

    .sample-times-table tbody tr:nth-child(even) {
        background-color: #f8faff;
    }

    .sample-times-table tbody tr:hover {
        background-color: #eaf4ff !important;
    }

    .sample-times-table tbody tr.done {
        background-color: #f0fff4 !important;
    }

    .sample-times-table tbody tr.done:hover {
        background-color: #d4f5e2 !important;
    }

    .sample-times-table td {
        vertical-align: middle;
        padding: 6px 7px;
        border-color: #dee2e6;
    }

    .sample-times-table .form-control-sm {
        font-size: 0.8rem;
    }

    .sample-times-table .btn-outline-danger {
        padding: 2px 8px;
        font-size: 0.78rem;
        flex-shrink: 0;
    }

    /* Storage Summary Table */
    .storage-summary-card .ss-col-header {
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.3px;
        vertical-align: middle;
        padding: 10px 8px;
        white-space: nowrap;
    }

    .storage-summary-table td {
        vertical-align: middle;
        padding: 7px 10px;
    }

    .ss-row-label {
        font-weight: 600;
        font-size: 0.85rem;
        white-space: nowrap;
        color: #2c3e50;
        background: #f8f9fa;
    }

    .ss-subheader-label {
        font-size: 0.82rem;
        font-weight: 600;
        padding: 6px 10px !important;
        white-space: nowrap;
    }

    .storage-summary-table .form-control[readonly] {
        background: #f0f4f8;
        color: #555;
        font-size: 0.8rem;
    }
</style>
<?= $this->endSection() ?>

<!-- Script --->
<?= $this->section('script') ?>

<script src="<?= base_url("assets/lib/mustache/mustache.min.js") ?>"></script>
<script src="<?= base_url("assets/lib/moment/js/moment.js") ?>"></script>
<script src="<?= base_url("assets/lib/chosen/chosen.jquery.js") ?>"></script>
<script type='text/javascript'>
    var controller = '<?= $controller ?>';
    var list_storages = <?= json_encode(array_values(array_map(function ($s) {
        return ['id' => $s->id, 'name' => $s->name, 'env_type' => $s->env_type];
    }, $storages ?? []))) ?>;

    function updateCodeResearch() {
        let val = $("#code_research_select").val();
        if (val === "custom") {
            let txt = $(".code_research_custom_input").val().trim();
            $("#code_research").val(txt);
        } else {
            $("#code_research").val(val);
        }
    }

    $(document).ready(function () {
        $("#code_research_select").change(function () {
            if ($(this).val() === "custom") {
                $(".code_research_custom_input").show();
            } else {
                $(".code_research_custom_input").hide();
            }
            updateCodeResearch();
        });
        $(".code_research_custom_input").on('input', updateCodeResearch);

        $(".chosen").chosen();
        $(".add_time").click(function (e) {
            e.preventDefault();
            add_time();
            $(".item").last().find('.type_id').trigger('change');
        });
        $(".quick_add").click(async function () {
            let env_id = $(".env_id").val();
            let env = await $.ajax({
                type: "GET",
                dataType: "JSON",
                url: path + "admin/env/get/" + env_id
            });
            let name = env.name;
            let times = env.time;
            for (let obj of times) {
                obj.name = name;
                obj.type_id = env.type_id;
                add_time();
                let row = $(".item").last();
                fillForm(row, obj);
                row.find('.type_id').trigger('change');
                calculate_date(row);
                toggle_based(row);
            }
        });
        $(document).on("click", ".remove_time", function (e) {
            e.preventDefault();
            if (confirm("Bạn thực sự muốn xóa!") == true) {
                let parent = $(this).closest(".item");
                let id = parent.data("id");
                parent.remove();
            }
        });
        $(document).on("change", "[name=date_manufacture],[name=date_storage]", function (e) {
            e.preventDefault();
            $(".item").each(function () {
                calculate_date($(this));
            })
        });
        $(document).on("change", ".based", function (e) {
            e.preventDefault();
            let parent = $(this).closest(".item");
            toggle_based(parent);
            calculate_date(parent);
        });
        $(document).on("change", ".time,.type_time", function (e) {
            e.preventDefault();
            let parent = $(this).closest(".item");
            calculate_date(parent);
        });

        $(document).on("change", ".storage_id", function () {
            let parent = $(this).closest(".item");
            let storageId = $(this).val();
            let storage = list_storages.find(s => s.id == storageId);
            if (storage && storage.env_type) {
                parent.find(".type_id").val(storage.env_type);
            }
            updateStorageSummary();
        });

        $(document).on("change", ".type_id", function () {
            let parent = $(this).closest(".item");
            let typeId = $(this).val();
            let storageId = parent.find(".storage_id").val();
            let currentStorage = list_storages.find(s => s.id == storageId);
            if (!currentStorage || currentStorage.env_type != typeId) {
                let storage = list_storages.find(s => s.env_type == typeId);
                if (storage) {
                    parent.find(".storage_id").val(storage.id);
                }
            }
            updateStorageSummary();
        });
        $(document).on("change", ".custom_date", function (e) {
            e.preventDefault();
            let parent = $(this).closest(".item");
            let cd = $(this).val();
            $(".date_theory", parent).val(cd);
        });

        $(document).on("change", ".date_reality,.num_get", function (e) {
            e.preventDefault();
            let parent = $(this).closest(".item");
            done(parent);
            check_remain();
            updateStorageSummary();
        });



        $.validator.setDefaults({
            debug: true,
            success: "valid"
        });
        $("#form-dang-tin").validate({
            highlight: function (input) {
                $(input).parents('.form-line').addClass('error');
            },
            unhighlight: function (input) {
                $(input).parents('.form-line').removeClass('error');
            },
            errorPlacement: function (error, element) {
                $(element).parents('.form-group').append(error);
            },
            submitHandler: function (form) {
                let append = "";
                //add/edit
                $(".list_time .item").each(function () {
                    let id = $(this).data("id");
                    let data = $(this).find(":input").serializeArray();
                    //add
                    for (let obj of data) {
                        append += "<input type='hidden' name='time[insert][" + obj.name + "][]' value='" + obj.value + "' />";
                    }
                });
                // Append amount1-5 from storage summary
                for (let i = 1; i <= 5; i++) {
                    let $input = $('.ss-amount-input[data-type="' + i + '"]');
                    if ($input.length) {
                        append += "<input type='hidden' name='amount" + i + "' value='" + ($input.val() || 0) + "' />";
                    }
                }
                $(form).append(append);
                form.submit();
                return false;
            }
        });
    });

    function add_time(item = {}) {
        var template = $(".times").html();
        var rendered = Mustache.render(template, item);
        $(".list_time").append(rendered);
        // Populate storage_id select
        let newRow = $(".list_time .item").last();
        let sel = newRow.find(".storage_id");
        list_storages.forEach(function (s) {
            let selected = (item.storage_id == s.id) ? ' selected' : '';
            sel.append('<option value="' + s.id + '"' + selected + '>' + s.name + '</option>');
        });
        toggle_based(newRow);
    }

    function toggle_based(row) {
        let based = $(".based", row).val();
        if (based === "custom") {
            $(".td-time", row).hide();
            $(".td-type-time", row).hide();
            $(".td-custom-date", row).removeClass("d-none").show();
            // Pre-fill from Hạn dùng if empty
            if (!$(".custom_date", row).val()) {
                let date_expire = $("[name=date_expire]").val();
                if (date_expire) $(".custom_date", row).val(date_expire);
            }
            // date_theory follows custom_date
            let cd = $(".custom_date", row).val();
            $(".date_theory", row).prop("readonly", false);
            if (cd) $(".date_theory", row).val(cd);
        } else {
            $(".td-time", row).show();
            $(".td-type-time", row).show();
            $(".td-custom-date", row).hide();
        }
    }

    function calculate_date(row) {
        let date_manufacture = $("[name=date_manufacture]").val();
        let date_storage = $("[name=date_storage]").val();
        let time = $(".time", row).val();
        let type_time = $(".type_time", row).val();
        let based = $(".based", row).val();
        if (based !== "custom") {
            $(".date_theory", row).prop("readonly", true);
            let date_theory = moment(eval(based)).add(time, type_time);
            $(".date_theory", row).val(date_theory.format("YYYY-MM-DD"));
        } else {
            let cd = $(".custom_date", row).val();
            $(".date_theory", row).prop("readonly", false);
            if (cd) $(".date_theory", row).val(cd);
        }
    }

    function done(row) {
        let time = $(".date_reality", row).val();
        if (moment(time).isValid()) {
            $(".status", row).removeClass("d-none");
            $(row).addClass("done");
        }
        let based = $(".based", row).val();
        if (based != "custom") {
            $(".date_theory", row).prop("readonly", true);
        } else {
            $(".date_theory", row).prop("readonly", false);
        }
    }

    function check_remain() {
        var tong = parseInt($("[name='amount']").val());
        var num_get_tong = 0;
        $(".num_get").map(function (item) {
            let parent = $(this).closest(".item");
            if (!parent.hasClass("done"))
                return;
            var value = $(this).val() || 0;
            num_get_tong += parseInt(value);
        });
        var remain = tong - num_get_tong;
        $("[name='remain']").val(remain);
    }

    // Tính toán và render bảng tổng hợp động — group by type_id, cho nhập SL lưu mẫu, tính SL còn lại
    var typeConditions = {
        1: { label: 'Lão hóa', condition: '40°C ± 2°C<br><span class="text-muted">75% ± 5% RH</span>', color: '#c0392b' },
        2: { label: 'Trung gian', condition: '30°C ± 2°C<br><span class="text-muted">65% ± 5% RH</span>', color: '#16a085' },
        3: { label: 'Dài hạn<br><small>(Vùng IV)</small>', condition: '30°C ± 2°C<br><span class="text-muted">75% ± 5% RH</span>', color: '#d35400' },
        4: { label: 'Dài hạn<br><small>(Vùng II)</small>', condition: '30°C ± 2°C<br><span class="text-muted">75% ± 5% RH</span>', color: '#7f8c8d' },
        5: { label: 'Dài hạn<br><small>(Vùng I và II)</small>', condition: '25°C ± 2°C<br><span class="text-muted">60% ± 5% RH</span>', color: '#2980b9' }
    };

    function updateStorageSummary() {
        var groups = {};
        var groupOrder = [];

        // Lưu lại giá trị đã nhập trước khi render lại
        var savedAmounts = {};
        $('.ss-amount-input').each(function () {
            savedAmounts[$(this).data('type')] = $(this).val();
        });

        $(".list_time .item").each(function () {
            var type = $(this).find('.type_id').val();
            var storage_id = $(this).find('.storage_id').val() || '';
            var $opt = $(this).find('.storage_id option:selected');
            var storage_name = (storage_id && $opt.val()) ? $opt.text() : '';
            var num = parseInt($(this).find('.num_get').val()) || 0;
            var is_done = $(this).hasClass('done');

            var key = type;
            if (!groups[key]) {
                groups[key] = {
                    type_id: parseInt(type),
                    storage_names: [],
                    total_sampled: 0
                };
                groupOrder.push(key);
            }
            if (storage_name && groups[key].storage_names.indexOf(storage_name) === -1) {
                groups[key].storage_names.push(storage_name);
            }
            if (is_done) {
                groups[key].total_sampled += num;
            }
        });

        var $container = $('#storage-summary-container');

        if (groupOrder.length === 0) {
            $container.html('<div class="text-center text-muted p-3 ss-empty"><i class="fas fa-info-circle mr-1"></i>Thêm dòng ngày lấy mẫu để hiển thị thống kê khu vực lưu mẫu.</div>');
            return;
        }

        var html = '<div class="table-responsive"><table class="table table-bordered mb-0 storage-summary-table">';
        html += '<colgroup><col style="min-width:150px;width:150px">';
        groupOrder.forEach(function () { html += '<col>'; });
        html += '</colgroup><thead>';

        html += '<tr class="text-center">';
        html += '<th class="align-middle ss-col-header" style="background:#2c3e50;color:#fff;"></th>';
        groupOrder.forEach(function (key) {
            var g = groups[key];
            var tc = typeConditions[g.type_id] || { label: 'Loại ' + g.type_id, color: '#6c757d' };
            html += '<th class="ss-col-header" style="background:' + tc.color + ';color:#fff;">' + tc.label + '</th>';
        });
        html += '</tr>';

        html += '<tr class="text-center">';
        html += '<th class="ss-subheader-label" style="background:#ecf0f1;color:#555;">Khu vực lưu mẫu</th>';
        groupOrder.forEach(function (key) {
            var g = groups[key];
            var tc = typeConditions[g.type_id] || { color: '#6c757d' };
            var areaText = g.storage_names.length > 0 ? g.storage_names.join(', ') : '<span class="text-muted fst-italic">Chưa chọn</span>';
            html += '<th class="ss-subheader-label" style="background:' + tc.color + '22;color:#333;border-top:2px solid ' + tc.color + '">' + areaText + '</th>';
        });
        html += '</tr></thead><tbody>';

        html += '<tr><td class="ss-row-label">Điều kiện lưu mẫu</td>';
        groupOrder.forEach(function (key) {
            var tc = typeConditions[groups[key].type_id] || { condition: '' };
            html += '<td class="text-center small">' + (tc.condition || '') + '</td>';
        });
        html += '</tr>';

        html += '<tr><td class="ss-row-label">Số lượng lưu mẫu</td>';
        groupOrder.forEach(function (key) {
            var g = groups[key];
            var savedVal = savedAmounts[g.type_id] !== undefined ? savedAmounts[g.type_id] : 0;
            html += '<td class="text-center">';
            html += '<input type="number" class="form-control form-control-sm ss-amount-input text-center" data-type="' + g.type_id + '" value="' + savedVal + '" min="0" style="max-width:100px;margin:0 auto;font-weight:700;font-size:1rem;">';
            html += '</td>';
        });
        html += '</tr>';

        html += '<tr><td class="ss-row-label">SL đã lấy mẫu</td>';
        groupOrder.forEach(function (key) {
            var g = groups[key];
            html += '<td class="text-center"><span class="badge badge-info" style="font-size:1rem;padding:6px 14px;">' + g.total_sampled + '</span></td>';
        });
        html += '</tr>';

        html += '<tr><td class="ss-row-label">Số lượng còn lại</td>';
        groupOrder.forEach(function (key) {
            var g = groups[key];
            var amountVal = savedAmounts[g.type_id] !== undefined ? parseInt(savedAmounts[g.type_id]) || 0 : 0;
            var remain = amountVal - g.total_sampled;
            var badgeClass = remain < 0 ? 'badge-danger' : (remain === 0 ? 'badge-secondary' : 'badge-warning text-dark');
            html += '<td class="text-center"><span class="badge ' + badgeClass + ' ss-remain-badge" data-type="' + g.type_id + '" style="font-size:1rem;padding:6px 14px;">' + remain + '</span></td>';
        });
        html += '</tr>';

        html += '</tbody></table></div>';
        $container.html(html);
    }

    // Tính lại Tổng số = tổng amount1..5
    function recalcTotalAmount() {
        var total = 0;
        $('.ss-amount-input').each(function () {
            total += parseInt($(this).val()) || 0;
        });
        $("[name='amount']").val(total);
        check_remain();
    }

    // Khi thay đổi SL lưu mẫu, tính lại SL còn lại
    $(document).on('input change', '.ss-amount-input', function () {
        var typeId = $(this).data('type');
        var amountVal = parseInt($(this).val()) || 0;
        var totalSampled = 0;
        $(".list_time .item").each(function () {
            var rowType = $(this).find('.type_id').val();
            if (rowType == typeId && $(this).hasClass('done')) {
                totalSampled += parseInt($(this).find('.num_get').val()) || 0;
            }
        });
        var remain = amountVal - totalSampled;
        var $badge = $('.ss-remain-badge[data-type="' + typeId + '"]');
        $badge.text(remain);
        $badge.removeClass('badge-danger badge-secondary badge-warning text-dark');
        if (remain < 0) {
            $badge.addClass('badge-danger');
        } else if (remain === 0) {
            $badge.addClass('badge-secondary');
        } else {
            $badge.addClass('badge-warning text-dark');
        }
        recalcTotalAmount();
    });
</script>

<?= $this->endSection() ?>