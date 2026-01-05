<div class="container-fluid">
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">📝 Form Pendaftaran Servis Baru</h6>
        </div>
        <div class="card-body">
            
            <form action="<?= base_url('index.php/dealer/simpan') ?>" method="post">
                
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Nama Pelanggan</label>
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama pelanggan..." required>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Jenis Motor</label>
                    <input type="text" name="motor" class="form-control" placeholder="Contoh: Vario 125, NMAX, Beat" required>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Keluhan / Masalah Motor</label>
                    <textarea name="keluhan" class="form-control" rows="4" placeholder="Jelaskan keluhan motor disini (misal: Ganti Oli, Rem Bunyi)..." required></textarea>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="<?= base_url('index.php/dealer') ?>" class="btn btn-secondary">
                        &laquo; Batal & Kembali
                    </a>

                    <button type="submit" class="btn btn-primary">
                        💾 Simpan Antrian
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
