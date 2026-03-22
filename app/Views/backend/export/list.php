<?= $this->extend('backend/layouts/main') ?>


<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url("/assets/lib/chosen/chosen.min.css") ?>" ?>
<div class="row clearfix">
    <div class="col-12">
        <form method="POST" action="/admin/export/exportlist" id="form-dang-tin">
            <?= csrf_field() ?>
            <section class="card card-fluid">
                <h5 class="card-header">
                    DANH SÁCH MẪU LƯU
                </h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group row">
                                <b class="col-12 col-lg-3 col-form-label">Khu vực lưu mẫu:</b>
                                <div class="col-12 col-lg-9 pt-1">
                                    <select class="chosen form-control form-control-sm storage_id" name="storage_id"
                                        data-placeholder="-- Chọn khu vực --">

                                        <?php foreach ($storages as $storage): ?>
                                            <option value='<?= $storage->id ?>'><?= $storage->name ?>
                                                <?= isset($storage->code) && $storage->code ? '(' . $storage->code . ')' : '' ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="col-12 col-lg-4 pt-1">
                                <button class="btn btn-sm btn-primary export"><i class="fas fa-file-excel mr-1"></i>Xuất
                                    Excel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </div>
</div>


<?= $this->endSection() ?>


<!-- Script --->
<?= $this->section('script') ?>
<script src='<?= base_url() ?>/assets/lib/chosen/chosen.jquery.min.js'></script>
<script type='text/javascript'>
    $(document).ready(function () {
        $(".chosen").chosen();
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
                form.submit();
                return false;
            }
        });
        $(".export").click(async function (e) {
            if ($(".storage_id").val() == "") {
                alert("Vui lòng chọn khu vực lưu mẫu!");
                return;
            }
            e.preventDefault();
            $(".page-loader-wrapper").show();
            try {
                let url = await $.ajax({
                    "url": path + "admin/export/exportlist",
                    "data": $("#form-dang-tin").serialize(),
                    "type": "POST",
                    "dataType": "JSON"
                });
                $(".page-loader-wrapper").hide();
                location.href = url;
            } catch (err) {
                $(".page-loader-wrapper").hide();
                alert("Có lỗi xảy ra khi xuất file. Vui lòng thử lại!");
            }
        });
    });
</script>

<?= $this->endSection() ?>