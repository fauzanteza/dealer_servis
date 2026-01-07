<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">🔧 Dashboard Antrian Servis</h2>
        <a href="<?= base_url('index.php/dealer/tambah') ?>" class="btn btn-primary shadow-sm">
            + Daftar Servis Baru
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Daftar Pelanggan Hari Ini</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Pelanggan</th>
                            <th>Jenis Motor</th>
                            <th>Keluhan</th>
                            <th width="15%">Status</th>
                            <th width="20%">Aksi Mekanik</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        // Kita meloop variable $antrian yang dikirim dari Controller
                        foreach($antrian as $row):
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="fw-bold"><?= $row['nama_pelanggan'] ?></td>
                            <td><?= $row['jenis_motor'] ?></td>
                            <td><?= $row['keluhan'] ?></td>

                            <td>
                                <?php if($row['status'] == 'Menunggu'): ?>
                                    <span class="badge bg-danger p-2">⏳ Menunggu</span>
                                <?php elseif($row['status'] == 'Diproses'): ?>
                                    <span class="badge bg-warning text-dark p-2">⚙️ Sedang Dikerjakan</span>
                                <?php else: ?>
                                    <span class="badge bg-success p-2">✅ Selesai</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if($row['status'] == 'Menunggu'): ?>
                                    <a href="<?= base_url('index.php/dealer/proses_servis/'.$row['id']) ?>" 
                                       class="btn btn-sm btn-info text-white">
                                       🔧 Kerjakan
                                    </a>

                                <?php elseif($row['status'] == 'Diproses'): ?>
                                    <a href="<?= base_url('index.php/dealer/selesai_servis/'.$row['id']) ?>" 
                                       class="btn btn-sm btn-success">
                                       ✅ Selesai
                                    </a>
                                <?php endif; ?>

                                <a href="<?= base_url('index.php/dealer/hapus_servis/'.$row['id']) ?>" 
                                   class="btn btn-sm btn-outline-danger ms-1"
                                   onclick="return confirm('Yakin ingin menghapus antrian ini?')">
                                   🗑️
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <?php if(empty($antrian)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i>Belum ada antrian servis saat ini. Silakan tambah data baru.</i>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
