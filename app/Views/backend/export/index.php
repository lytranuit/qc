<?= $this->extend('backend/layouts/main') ?>


<?= $this->section('content') ?>
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
                        <div class="col-md-4">
                            <div class="col-12 col-lg-4 pt-1">
                                <button class="btn btn-sm btn-primary">Xuất File</button>
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

<script type='text/javascript'>
    $(document).ready(function() {
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
</script>

<?= $this->endSection() ?>