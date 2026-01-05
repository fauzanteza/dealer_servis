<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-success text-white">
            <h6 class="m-0 font-weight-bold">📝 Form Transaksi Penjualan Motor</h6>
        </div>
        <div class="card-body">
            
            <form action="<?= base_url('index.php/dealer/proses_beli') ?>" method="post">
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Nama Pembeli</label>
                        <input type="text" name="nama_pembeli" class="form-control" placeholder="Nama lengkap pembeli..." required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Tanggal Transaksi</label>
                        <input type="text" class="form-control" value="<?= date('d F Y') ?>" readonly>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="font-weight-bold">Pilih Unit Motor</label>
                    <select name="id_motor" class="form-control" required>
                        <option value="">-- Pilih Motor --</option>
                        <?php foreach($motor as $mtr): ?>
                            <?php if($mtr['stok'] > 0): ?>
                                <option value="<?= $mtr['id_motor'] ?>">
                                    <?= $mtr['merk'] ?> - <?= $mtr['tipe'] ?> (Harga: Rp <?= number_format($mtr['harga'],0,',','.') ?>)
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted">* Hanya motor dengan stok tersedia yang muncul disini.</small>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Jumlah Beli</label>
                        <input type="number" name="jumlah" class="form-control" value="1" min="1" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Total Bayar (Rp)</label>
                        <input type="number" name="total_bayar" class="form-control" placeholder="Masukkan total harga deal..." required>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="<?= base_url('index.php/dealer/penjualan') ?>" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-success">💰 Proses Pembayaran</button>
                </div>

            </form>
        </div>
    </div>
</div>
