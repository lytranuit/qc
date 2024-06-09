<center>
    <table>
        <tbody>
            <tr>
                <td width="600">
                    <div>
                        <div style="box-sizing:border-box;margin:0;padding:0 40px">
                            <h2 style="text-align:left">Xin chào,</h2>
                            <p style="text-align:left">Hệ thống Asta, thông tin lấy mẫu độ ổn định.</p>
                            <p style="text-align:left">Tên Mẫu: <b><?= $data->name ?></b></p>
                            <p style="text-align:left">Tên sản phẩm: <b><?= $data->sample->name ?></b></p>
                            <p style="text-align:left">Mã sản phẩm: <b><?= $data->sample->code ?></b></p>
                            <p style="text-align:left">Số lô: <b><?= $data->sample->code_batch ?></b></p>
                            <p style="text-align:left">Số lượng lấy mẫu: <b><?= $data->num_get ?></b></p>
                            <p style="text-align:left">Thời gian: <b><?= $data->time ?> <?= $data->type_time ?></b></p>
                            <p style="text-align:left">Vị trí: <b><?= $data->location ?></b></p>
                            <p style="text-align:left">Ngày lấy mẫu: <b><?= $data->date_theory ?></b></p>
                            <p>Chi tiết:</p>
                            <p style="text-align:center;">
                                <a href="<?= $link ?>" target="_blank" style="padding: 10px 30px;
    display:inline-block;
    background: #ffb009;
    color: white;
    text-decoration: none;
    font-size: 13px;
    border-radius: 5px;">Đi Đến</a>
                            </p>
                            <p style="text-align:left">Trân trọng.</p>
                            <p style="text-align:left">ASTA</p>
                            <br>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</center>