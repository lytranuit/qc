<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('content') ?>
<div class="row clearfix">
    <div class="col-12">
        <form method="POST" action="" id="form-dang-tin">
            <?= csrf_field() ?>
            <section class="card card-fluid">
                <h5 class="card-header">
                    <div class="d-inline-block w-100">

                        <?php if (in_groups(array("admin", "editor"))) : ?>
                            <button type="submit" name="dangtin" class="btn btn-sm btn-primary float-right">Save</button>
                        <?php endif ?>
                    </div>
                </h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Tên sản phẩm:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="name" required="" placeholder="Tên" />
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Số lô:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="code_batch" required="" placeholder="Số lô" />
                                </div>

                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Mã sản phẩm:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="code" placeholder="Mã sản phẩm" />
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Mã số nghiên cứu:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="code_research" placeholder="Mã số nghiên cứu" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Số đề cương:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="outline_number" placeholder="Số đề cương" />
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Số phân tích:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="code_analysis" placeholder="Số phân tích" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Ngày sản xuất:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='date' name="date_manufacture" required="" placeholder="Ngày sản xuất" />
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Ngày lưu mẫu:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='date' name="date_storage" required="" placeholder="Ngày lưu mẫu vào tủ" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Tổng số:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='number' name="amount" required="" />
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
                                        <?php foreach ($users as $row) : ?>
                                            <option value="<?= $row->Email ?>"><?= $row->FullName ?> (<?= $row->Email ?>)</option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-12 pt-2 pt-md-0">
                                    <div class="card no-shadow border">
                                        <div class="card-header">
                                            QR code
                                            <div class="ml-auto">
                                                <a class="btn btn-success text-white" onclick="printJS('<?= base_url($tin->image_url) ?>', 'image')"><i class="fas fa-print"></i> Print</a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <a href="<?= base_url($tin->image_url) ?>" target="_blank" class="text-center d-block">
                                                <img src="<?= base_url($tin->image_url) ?>" class="img-fluid w-50">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </form>



        <section class="card card-fluid mt-2">
            <h5 class="card-header">
                Ngày lấy mẫu
                <div class="ml-auto">
                </div>
                <div class="ml-auto">
                    <select class="form-control form-control-sm d-inline-block mr-1 env_id" style="width:200px">

                        <?php foreach ($envs as $row) : ?>
                            <option value="<?= $row->id ?>"><?= $row->name ?></option>
                        <?php endforeach ?>
                    </select>
                    <button class="btn btn-sm btn-success float-right quick_add">+ Thêm</button>
                </div>
            </h5>
            <div class="card-body">
                <button class="btn btn-sm btn-success add_time">+ Thêm</button>
                <div class="list_time">
                    <div class="form-group row pt-1">
                        <div class="col text-center">
                            <b>Tên</b>
                        </div>
                        <div class="col text-center">
                            <b>Vị trí</b>
                        </div>
                        <div class="col text-center">
                            <b>Điều kiện</b>
                        </div>
                        <div class="col text-center">
                            <b>Thời gian</b>
                        </div>
                        <div class="col text-center">
                            <b>Loại thời gian</b>
                        </div>
                        <div class="col text-center">
                            <b>So với</b>
                        </div>
                        <div class="col text-center">
                            <b>Số lượng lấy mẫu</b>
                        </div>
                        <div class="col text-center">
                            <b>Ngày lấy mẫu lý thuyết</b>
                        </div>
                        <div class="col text-center">
                            <b>Ngày lấy mẫu thực tế</b>
                        </div>
                        <div class="col text-center">
                            <b>Chỉ tiêu</b>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
</div>

<template class="times">
    <div class="form-group row py-2 item align-items-center" data-id="{{id}}">
        <div class="col">
            <input type="text" name="name" class="form-control form-control-sm name" placeholder="Tên">
        </div>
        <div class="col">
            <input type="text" name="location" class="form-control form-control-sm location" placeholder="Vị trí">
        </div>
        <div class="col">
            <select class="form-control form-control-sm type_id" name="type_id">
                <option value="1">Lão hóa</option>
                <option value="2">Trung hạn</option>
                <option value="3">Dài hạn(Vùng IV)</option>
                <option value="4">Dài hạn(Vùng II)</option>
                <option value="5">Dài hạn(Vùng I)</option>
            </select>
        </div>
        <div class="col">
            <input type="number" name="time" class="form-control form-control-sm time" placeholder="Thời gian">
        </div>
        <div class="col">
            <select class="form-control form-control-sm type_time" name="type_time">
                <option value="d">Ngày</option>
                <option value="w">Tuần</option>
                <option value="M" selected>Tháng</option>
                <option value="y">Năm</option>
            </select>
        </div>
        <div class="col">
            <select class="form-control form-control-sm based" name="based">
                <option value="custom">Tùy chỉnh</option>
                <option value="date_manufacture">So với ngày sản xuất</option>
                <option value="date_storage">So với ngày lưu mẫu</option>
            </select>
        </div>
        <div class="col">
            <input type="number" name="num_get" class="form-control form-control-sm num_get">
        </div>
        <div class="col">
            <input type="date" name="date_theory" class="form-control form-control-sm date_theory" readonly placeholder="Ngày lấy mẫu lý thuyết">
        </div>
        <div class="col">
            <input type="date" name="date_reality" class="form-control form-control-sm date_reality" placeholder="Ngày lấy mẫu thực tế">
        </div>
        <div class="col">
            <textarea type="text" name="note" class="form-control form-control-sm note" rows="1" placeholder="Chỉ tiêu" style="width:60%;display:inline-block;vertical-align: middle;"></textarea>
            <button class="btn btn-sm btn-danger remove_time d-inline-block"><i class="fas fa-trash-alt"></i> Xóa</button>
            <span class="btn btn-success rounded-circle btn-icon ml-2 status d-none">
                <i class="fas fa-check"></i>
            </span>
        </div>
    </div>
</template>
<?= $this->endSection() ?>



<!-- Style --->
<?= $this->section("style") ?>
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/lib/printjs/print.min.css") ?>">">
<link rel="stylesheet" href="<?= base_url("assets/lib/chosen/chosen.min.css") ?>" ?>
<?= $this->endSection() ?>

<!-- Script --->
<?= $this->section('script') ?>

<script src="<?= base_url("assets/lib/printjs/print.min.js") ?>"></script>
<script src="<?= base_url("assets/lib/mustache/mustache.min.js") ?>"></script>
<script src="<?= base_url("assets/lib/moment/js/moment.js") ?>"></script>
<script src="<?= base_url("assets/lib/chosen/chosen.jquery.js") ?>"></script>
<script type='text/javascript'>
    var tin = <?= json_encode($tin) ?>;
    var controller = '<?= $controller ?>';
    if (tin.emails) {
        tin.alerts = tin.emails.split(',');
    }
    fillForm($("#form-dang-tin"), tin);
    $(document).ready(function() {
        $(".chosen").chosen();
        let list_delete = [];
        if (tin.time) {
            for (let item of tin.time) {
                add_time(item);
                let row = $(".item[data-id='" + item.id + "'");
                fillForm(row, item);
                done(row);
            }
            check_remain();
        }
        $(".add_time").click(function(e) {
            e.preventDefault();
            add_time();
        });
        $(".quick_add").click(async function() {
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
                obj.type_id = env.type_id
                add_time();
                let row = $(".item").last();
                fillForm(row, obj);
                calculate_date(row);
            }
        });
        $(document).on("click", ".remove_time", function(e) {
            e.preventDefault();
            if (confirm("Bạn thực sự muốn xóa!") == true) {
                let parent = $(this).closest(".form-group");
                let id = parent.data("id");
                if (id > 0) {
                    list_delete.push(id);
                }
                parent.remove();
            }
        });
        $(document).on("change", "[name=date_manufacture],[name=date_storage]", function(e) {
            e.preventDefault();
            $(".item").each(function() {
                calculate_date($(this));
            })
        });
        $(document).on("change", ".time,.type_time,.based", function(e) {
            e.preventDefault();
            let parent = $(this).closest(".item");
            calculate_date(parent);
        });

        $(document).on("change", ".date_reality,.num_get", function(e) {
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
            highlight: function(input) {
                $(input).parents('.form-line').addClass('error');
            },
            unhighlight: function(input) {
                $(input).parents('.form-line').removeClass('error');
            },
            errorPlacement: function(error, element) {
                $(element).parents('.form-group').append(error);
            },
            submitHandler: function(form) {
                let append = "";
                ///delete
                for (let id of list_delete) {
                    append += "<input type='hidden' name='time[delete][]' value='" + id + "' />";
                }
                //add/edit
                $(".list_time .item").each(function() {
                    let id = $(this).data("id");
                    let data = $(this).wrap('<form>').parent().serializeArray();
                    $(this).unwrap('form');
                    if (id > 0) {
                        //update
                        append += "<input type='hidden' name='time[update][id][]' value='" + id + "' />";
                        for (let obj of data) {
                            append += "<input type='hidden' name='time[update][" + obj.name + "][]' value='" + obj.value + "' />";
                        }
                    } else {
                        //add
                        for (let obj of data) {
                            append += "<input type='hidden' name='time[insert][" + obj.name + "][]' value='" + obj.value + "' />";
                        }
                    }
                });
                $(form).append(append);
                form.submit();
                return false;
            }
        });

    });


    function fix_row() {
        $(".list_time > .row").each(function(item) {
            $(".col:eq(1)", $(this)).css({
                "max-width": "120px"
            });
            $(".col:eq(2)", $(this)).css({
                "max-width": "180px"
            });
            $(".col:eq(3)", $(this)).css({
                "max-width": "100px"
            });
            $(".col:eq(4)", $(this)).css({
                "max-width": "120px"
            });
            $(".col:eq(5)", $(this)).css({
                "max-width": "200px"
            });
            $(".col:eq(6)", $(this)).css({
                "max-width": "100px"
            });
            $(".col:eq(7)", $(this)).css({
                "max-width": "150px"
            });
            $(".col:eq(8)", $(this)).css({
                "max-width": "150px"
            });
        })
    }

    function add_time(item = {}) {
        var template = $(".times").html();
        var rendered = Mustache.render(template, item);
        $(".list_time").append(rendered);
        fix_row();
    }

    function calculate_date(row) {
        let date_manufacture = $("[name=date_manufacture]").val();
        let date_storage = $("[name=date_storage]").val();
        let time = $(".time", row).val();
        let type_time = $(".type_time", row).val();
        let based = $(".based", row).val();
        if (based != "custom") {
            $(".date_theory", row).prop("readonly", true);
            let date_theory = moment(eval(based)).add(time, type_time);
            $(".date_theory", row).val(date_theory.format("YYYY-MM-DD"));
        } else {
            $(".date_theory", row).prop("readonly", false);
        }
    }

    function done(row) {
        let time = $(".date_reality", row).val();
        // console.log($(".date_reality", row));
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
        $(".num_get").map(function(item) {
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