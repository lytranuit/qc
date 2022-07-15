<?= $this->extend('backend/layouts/main') ?>


<?= $this->section('content') ?>
<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css"> -->

<link rel="stylesheet" type="text/css" href="<?= base_url("assets/lib/jquery-ui/jquery-ui.css") ?>">
<style>
    .ui-datepicker-calendar {
        display: none;
    }
</style>
<div class="row clearfix">
    <div class="col-12">
        <form method="POST" action="/admin/export/exportmonth" id="form-dang-tin">
            <?= csrf_field() ?>
            <section class="card card-fluid">
                <h5 class="card-header">
                    KẾ HOẠCH NGHIÊN CỨU ĐỘ ỔN ĐỊNH HÀNG THÁNG
                </h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Tháng:</b>
                                <div class="col-12 col-lg-10 pt-1">
                                    <input type="text" id="datepicker" readonly name="monthyear" class="form-control form-control-sm bg-white">
                                </div>
                            </div>
                        </div>
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
        $("#datepicker").datepicker({
            dateFormat: "yy-mm",
            changeMonth: true,
            changeYear: true,
            onClose: function(dateText, inst) {
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
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
</script>

<?= $this->endSection() ?>