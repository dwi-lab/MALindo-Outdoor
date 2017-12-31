<div class="invoice">
    <div class="invoice-company">
        <span class="pull-right hidden-print">
        <a href="javascript:;" class="btn btn-sm btn-success m-b-10"><i class="fa fa-download m-r-5"></i> Export as PDF</a>
        <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-success m-b-10"><i class="fa fa-print m-r-5"></i> Print</a>
        </span>
        <b>MALindo Outdoor</b>
    </div>
    <div class="invoice-header">
        <div class="invoice-from">
            <small>dari</small>
            <address class="m-t-5 m-b-5">
                <strong>MALindo Outdoor.</strong><br />
                JL. DR. Moch. Hatta No. 168 Kel. Sukamanah <br />
                Kec. Cipedes Kota Tasikmalaya<br />
                Tlp : 085-220-296-494<br />
                e-mail : malindooutdoor@gmail.com
            </address>
        </div>
        <div class="invoice-to">
            <small>ke</small>
            <address class="m-t-5 m-b-5">
                <strong><?php echo $nama_member;?></strong><br />
                <?php echo $alamat_member;?><br />
                <?php echo $alamat_detil;?><br />
                Tlp: <?php echo $tlp_member;?><br />
                e-mail: <?php echo $email_member;?>
            </address>
        </div>
        <div class="invoice-date">
            <small>Invoice Booking</small>
            <div class="date m-t-5"><?php echo $tgl_booking;?></div>
            <div class="invoice-detail">
                #<?php echo $kode_booking;?><br />
                <b>Booking</b><br/>
                <b>Jenis Bayar : <font color="red"><?php echo $jns_bayar;?></font></b>
            </div>
        </div>
    </div>
    <div class="invoice-content">
        <div class="table-responsive">
            <table class="table table-invoice">
                <thead>
                    <tr>
                        <th>Booking Deskripsi</th>
                        <th>Harga Sewa</th>
                        <th>Lama Pinjam</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Website design &amp; development<br />
                            <small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id sagittis arcu.</small>
                        </td>
                        <td>$50.00</td>
                        <td>50</td>
                        <td>$2,500.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="invoice-price">
            <div class="invoice-price-left">
                <div class="invoice-price-row">
                    <div class="sub-price">
                        <small>SUBTOTAL</small>
                        $4,500.00
                    </div>
                    <div class="sub-price">
                        <i class="fa fa-plus"></i>
                    </div>
                    <div class="sub-price">
                        <small>PAYPAL FEE (5.4%)</small>
                        $108.00
                    </div>
                </div>
            </div>
            <div class="invoice-price-right">
                <small>TOTAL</small> $4508.00
            </div>
        </div>
    </div>
    <div class="invoice-note">
        * Make all cheques payable to [Your Company Name]<br />
        * Payment is due within 30 days<br />
        * If you have any questions concerning this invoice, contact  [Name, Phone Number, Email]
    </div>
    <div class="invoice-footer text-muted">
        <p class="text-center m-b-5">
            HATURNUHUN PARANTOS SUMPING
        </p>
        <p class="text-center">
            <span class="m-r-10"><i class="fa fa-globe"></i> malindooutdoor.com</span>
            <span class="m-r-10"><i class="fa fa-phone"></i> T:085-220-296-494</span>
            <span class="m-r-10"><i class="fa fa-envelope"></i> malindooutdoor@gmail.com</span>
        </p>
    </div>
</div>