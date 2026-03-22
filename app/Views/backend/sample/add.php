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
                                <b class="col-12 col-lg-2 col-form-label">Hạn dùng:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='date' name="date_expire"
                                        placeholder="Hạn dùng" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Tổng số:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='number' name="amount"
                                        required="" />
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
            <select class="form-control form-control-sm type_id" name="type_id">
                <option value="1">Lão hóa</option>
                <option value="2">Trung gian</option>
                <option value="3">Dài hạn (Vùng IV)</option>
                <option value="4">Dài hạn (Vùng II)</option>
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
                Hạn dùng
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
</script>

<?= $this->endSection() ?>