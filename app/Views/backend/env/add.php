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
                                <b class="col-12 col-lg-2 col-form-label">Tên:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="name" required="" placeholder="Tên" />
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Điều kiện:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <select class="form-control form-control-sm type_id" name="type_id" required>
                                        <option value="1">Lão hóa</option>
                                        <option value="3">Dài hạn</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-lg-12 col-form-label">Khoảng thời gian:</b>
                                <div class="col-12 col-lg-12 pt-1">
                                    <button class="btn btn-sm btn-success add_time">+ Thêm</button>
                                </div>
                                <div class="col-12 col-lg-12 pt-1 list_time">

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </form>
    </div>
</div>
<template class="time">
    <div class="form-group row pt-1">
        <div class="col-2">
            <input type="number" name="time[]" class="form-control form-control-sm">
        </div>
        <div class="col-4">
            <select class="form-control form-control-sm" name="type_time[]">
                <option value="d">Ngày</option>
                <option value="w">Tuần</option>
                <option value="M" selected>Tháng</option>
                <option value="y">Năm</option>
            </select>
        </div>
        <div class="col-4">
            <select class="form-control form-control-sm" name="based[]">
                <option value="custom">Tùy chỉnh</option>
                <option value="date_manufacture">So với ngày sản xuất</option>
                <option value="date_storage">So với ngày lưu mẫu</option>
            </select>
        </div>
        <div class="col-2">
            <button class="btn btn-sm btn-danger remove_time"><i class="fas fa-trash-alt"></i> Xóa</button>
        </div>
    </div>
</template>
<?= $this->endSection() ?>


<!-- Script --->
<?= $this->section('script') ?>

<script src="<?= base_url("assets/lib/mustache/mustache.min.js") ?>"></script>
<script type='text/javascript'>
    $(document).ready(function() {
        $(".add_time").click(function(e) {
            e.preventDefault();
            add_time();
        })
        $(document).on("click", ".remove_time", function(e) {
            e.preventDefault();
            if (confirm("Bạn thực sự muốn xóa!") == true) {
                $(this).closest(".form-group").remove();
            }
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
                form.submit();
                return false;
            }
        });
    });

    function add_time(item = {}) {
        var template = $(".time").html();
        var rendered = Mustache.render(template, item);
        $(".list_time").append(rendered);
    }
</script>

<?= $this->endSection() ?>