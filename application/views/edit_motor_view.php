<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-warning text-dark">
            <h6 class="m-0 font-weight-bold">✏️ Edit Data Stok Motor</h6>
        </div>
        <div class="card-body">
            
            <form action="<?= base_url('index.php/dealer/update_motor') ?>" method="post">
                
                <input type="hidden" name="id_motor" value="<?= $motor['id_motor'] ?>">

                <div class="mb-3">
                    <label>Merk Motor</label>
                    <select name="merk" class="form-control">
                        <option value="Honda" <?= ($motor['merk'] == 'Honda') ? 'selected' : '' ?>>Honda</option>
                        <option value="Yamaha" <?= ($motor['merk'] == 'Yamaha') ? 'selected' : '' ?>>Yamaha</option>
                        <option value="Suzuki" <?= ($motor['merk'] == 'Suzuki') ? 'selected' : '' ?>>Suzuki</option>
                        <option value="Kawasaki" <?= ($motor['merk'] == 'Kawasaki') ? 'selected' : '' ?>>Kawasaki</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Tipe Motor</label>
                    <input type="text" name="tipe" class="form-control" value="<?= $motor['tipe'] ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Warna</label>
                        <input type="text" name="warna" class="form-control" value="<?= $motor['warna'] ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" value="<?= $motor['harga'] ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Stok Saat Ini</label>
                        <input type="number" name="stok" class="form-control" value="<?= $motor['stok'] ?>" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?= base_url('index.php/dealer/motor') ?>" class="btn btn-secondary">Batal</a>

            </form>
        </div>
    </div>
</div>
