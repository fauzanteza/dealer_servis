<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">💰 Laporan Penjualan Dealer</h2>
        <a href="<?= base_url('index.php/dealer/tambah_penjualan') ?>" class="btn btn-success shadow-sm">
            + Transaksi Baru
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-success text-white">
            <h6 class="m-0 font-weight-bold">Riwayat Transaksi Masuk</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Pembeli</th>
                            <th>Unit Motor</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1; 
                        foreach($transaksi as $row): 
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
                            <td><?= $row['nama_pembeli'] ?></td>
                            <td>
                                <b><?= $row['merk'] ?></b> - <?= $row['tipe'] ?>
                            </td>
                            <td><?= $row['jumlah_beli'] ?> Unit</td>
                            <td class="text-right">
                                Rp <?= number_format($row['total_harga'], 0, ',', '.') ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <?php if(empty($transaksi)): ?>
                            <tr>
                                <td colspan="6" class="text-center">Belum ada transaksi penjualan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
