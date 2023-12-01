<?= $this->extend('backend/layouts/main') ?>


<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url("/assets/lib/chosen/chosen.min.css") ?>" ?>
<div class="row clearfix">
    <div class="col-12">
        <form method="POST" action="/admin/export/export" id="form-dang-tin">
            <?= csrf_field() ?>
            <section class="card card-fluid">
                <h5 class="card-header">
                    KẾ HOẠCH NGHIÊN CỨU ĐỘ ỔN ĐỊNH TỔNG THỂ
                </h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Điều kiện:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <select class="chosen form-control form-control-sm type_id" name="types[]" multiple data-placeholder="Tất cả">
                                        <option value="1">Lão hóa</option>
                                        <option value="3">Dài hạn</option>
                                    </select>
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Mẫu - Số lô:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <select class="chosen form-control form-control-sm sample" name="samples[]" multiple data-placeholder="Tất cả">
                                        <?php foreach ($samples as $sample) : ?>
                                            <option value='<?= $sample->id ?>'><?= $sample->code_batch ?> - <?= $sample->name ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="col-12 col-lg-4 pt-1">
                                <button class="btn btn-sm btn-primary export">Xuất File</button>
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
    $(document).ready(function() {
        $(".chosen").chosen();
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
        $(".export").click(async function(e) {
            e.preventDefault();
            $(".page-loader-wrapper").show();
            let url = await $.ajax({
                "url": path + "admin/export/export",
                "data": $("#form-dang-tin").serialize(),
                "type": "POST",
                "dataType": "JSON"
            })
            $(".page-loader-wrapper").hide();
            location.href = url;
        });
    });
</script>

<?= $this->endSection() ?>