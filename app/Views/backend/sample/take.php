<?= $this->extend('backend/layouts/main') ?>


<?= $this->section('content') ?>

<div class="row clearfix">
    <div class="col-12">
        <form method="POST" action="" id="form-dang-tin">
            <?= csrf_field() ?>
            <section class="card card-fluid">
                <h5 class="card-header text-center">
                    <div class="d-inline-block w-100">
                        <button type="submit" name="dangtin" class="btn btn-sm btn-primary float-center">Lấy mẫu</button>
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
                                <b class="col-12 col-lg-2 col-form-label">Mã sản phẩm:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="code" required="" placeholder="Mã sản phẩm" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Số lô:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="code_batch" required="" placeholder="Số lô" />
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Vị trí lưu mẫu:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <select class="form-control form-control-sm" name="location_id" require>
                                        <?php foreach ($location as $row) : ?>
                                            <option value="<?= $row->id ?>"><?= $row->name ?></option>
                                        <?php endforeach ?>
                                    </select>
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
                                <b class="col-12 col-lg-2 col-form-label">Mã số nghiên cứu:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="code_research" placeholder="Mã số nghiên cứu" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                        </div>
                    </div>

                </div>
            </section>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url("assets/lib/qrcode/qrcode.css") ?> " ?>
<?= $this->endSection() ?>
<!-- Script --->
<?= $this->section('script') ?>
<div id="div_video" class="d-none">
    <video id="preview" class="d-none"></video>
    <div class="custom-scanner"></div>
</div>

<script type="module">
    import QrScanner from "<?= base_url('assets/lib/qr-scanner/qr-scanner.min.js') ?>";
    QrScanner.WORKER_PATH = "<?= base_url('assets/lib/qr-scanner/qr-scanner-worker.min.js') ?>";

    const video = document.getElementById('preview');
    const camList = document.getElementById('cam-list');
    var prev = "";
    var scanner = new QrScanner(video, content => {
        if (content == "" || content == prev)
            return;
        prev = content;
    });
    var select_cam = 0;
    var cameras = [];

    QrScanner.hasCamera().then(hasCamera => {
        if (hasCamera) {
            QrScanner.listCameras(true).then(c => {
                cameras = c;
                if (cameras.length > 1) {
                    select_cam = cameras.length - 1;
                }
                let cam = cameras[select_cam];
                scanner.setCamera(cam.id)
                scanner.setInversionMode('both');
                scanner.start();
                $("#preview").before(scanner.$canvas);

                $("#div_video").removeClass("d-none");
            });
        }
    }).catch(error => alert(error || 'No QR code found.'));
</script>
<?= $this->endSection() ?>