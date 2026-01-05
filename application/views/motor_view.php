<div class="container-fluid">
    <h2 class="mb-4">🏍️ Data Stok Motor Dealer</h2>

    <a href="<?= base_url('index.php/dealer/tambah_motor') ?>" class="btn btn-success mb-3">
        + Tambah Unit Baru
    </a>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Merk</th>
                        <th>Tipe Motor</th>
                        <th>Warna</th>
                        <th>Harga (Rp)</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1; 
                    // PERHATIKAN: Disini kita pakai $stok_motor, bukan $antrian
                    foreach($stok_motor as $mtr): 
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $mtr['merk'] ?></td>
                        <td><?= $mtr['tipe'] ?></td>
                        <td><?= $mtr['warna'] ?></td>
                        <td>Rp <?= number_format($mtr['harga'], 0, ',', '.') ?></td>
                        <td>
                            <?php if($mtr['stok'] > 0): ?>
                                <span class="badge bg-primary"><?= $mtr['stok'] ?> Unit</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Habis</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= base_url('index.php/dealer/edit_motor/'.$mtr['id_motor']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= base_url('index.php/dealer/hapus_motor/'.$mtr['id_motor']) ?>" 
                              class="btn btn-sm btn-danger" 
                              onclick="return confirm('Yakin ingin menghapus data motor ini?')">
   Hapus
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
