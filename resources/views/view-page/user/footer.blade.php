<div class="pre-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h4 style="text-align: center">
                    <b>THÔNG TIN VỀ CHỦ SỞ HỮU</b>
                </h4>
                <h5>
                    Tên cửa hàng: &nbsp;<strong>
                        Cửa Hàng Camera Quan Sát, Camera An Ninh, Camera Giám
                        Sát
                    </strong>
                </h5>
                <h5>Địa chỉ: {{ $dc->gia_tri }}</h5>

                <h5>
                    Điện thoại:
                    <a href="tel:{{ $dt->gia_tri }}" style="text-decoration: none">
                        {{ $dt->gia_tri }}
                    </a>
                </h5>

                <h5>
                    Email:
                    <a href="mailto:{{ $email->gia_tri }}" style="text-decoration: none">
                        {{ $email->gia_tri }}
                    </a>
                </h5>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</div>
<!-- END PRE-FOOTER -->
