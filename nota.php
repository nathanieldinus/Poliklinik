<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pembayaran</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous">
    <style>
        .invoice {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }
        .invoice-box {
            margin-top: 20px;
        }
        .separator {
            border-top: 2px solid #eee;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="invoice-box">
            <h2 class="text-center mb-4">Nota Pembayaran</h2>
            <?php
            include_once("koneksi.php");
            if (isset($_GET['id'])) {
                $id_periksa = $_GET['id'];
                
                // Ambil data periksa, pasien, dokter, dan obat
                $result = mysqli_query($mysqli, 
                "SELECT pr.*, p.nama AS nama_pasien, p.alamat AS alamat_pasien, p.no_hp AS no_hp_pasien, 
                        d.nama AS nama_dokter, d.alamat AS alamat_dokter, d.no_hp AS no_hp_dokter 
                 FROM periksa pr 
                 LEFT JOIN pasien p ON pr.id_pasien = p.id 
                 LEFT JOIN dokter d ON pr.id_dokter = d.id 
                 WHERE pr.id = '$id_periksa'");
                
                $data = mysqli_fetch_array($result);

                if ($data) {
                    $id_pasien = $data['id_pasien'];
                    $id_dokter = $data['id_dokter'];
                    $nama_pasien = $data['nama_pasien'];
                    $alamat_pasien = $data['alamat_pasien'];
                    $no_hp_pasien = $data['no_hp_pasien'];
                    $nama_dokter = $data['nama_dokter'];
                    $alamat_dokter = $data['alamat_dokter'];
                    $no_hp_dokter = $data['no_hp_dokter'];
                    $tgl_periksa = $data['tgl_periksa'];
                    $obat_ids = explode(',', $data['obat']);
                ?>
                <div class="invoice">
                    <p><strong>Nota Pembayaran</strong></p>
                    <div class="separator"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nomor Periksa:</strong></p>
                            <p><?php echo $id_periksa; ?></p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p><strong>Tanggal Periksa:</strong></p>
                            <p><?php echo $tgl_periksa; ?></p>
                        </div>
                    </div>
                    <div class="separator"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Pasien</strong></p>
                            <p><?php echo $nama_pasien; ?></p>
                            <p><?php echo $alamat_pasien; ?></p>
                            <p><?php echo $no_hp_pasien; ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Dokter</strong></p>
                            <p><?php echo $nama_dokter; ?></p>
                            <p><?php echo $alamat_dokter; ?></p>
                            <p><?php echo $no_hp_dokter; ?></p>
                        </div>
                    </div>
                    <div class="separator"></div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Obat</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total_harga_obat = 0;
                        foreach ($obat_ids as $obat_id) {
                            $obat_query = mysqli_query($mysqli, "SELECT * FROM obat WHERE id = '$obat_id'");
                            $obat_data = mysqli_fetch_array($obat_query);
                            $total_harga_obat += $obat_data['harga'];
                        ?>
                            <tr>
                                <td><?php echo $obat_data['nama_obat']; ?></td>
                                <td><?php echo number_format($obat_data['harga'], 2, ',', '.'); ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Jasa Dokter:</strong></p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p><strong>Rp 150.000</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Subtotal Harga Obat:</strong></p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p><strong>Rp <?php echo number_format($total_harga_obat, 2, ',', '.'); ?></strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Total:</strong></p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p><strong>Rp <?php echo number_format($total_harga_obat + 150000, 2, ',', '.'); ?></strong></p>
                        </div>
                    </div>
                </div>
            <?php
                } else {
                    echo "<p>Data tidak ditemukan</p>";
                }
            } else {
                echo "<p>ID periksa tidak ditemukan</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
