<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Stok Motor</h6>
        </div>
        <div class="card-body">

            <form action="<?= base_url('index.php/dealer/simpan_motor') ?>" method="post">

                <div class="mb-3">
                    <label>Merk Motor</label>
                    <select name="merk" class="form-control">
                        <option value="Honda">Honda</option>
                        <option value="Yamaha">Yamaha</option>
                        <option value="Suzuki">Suzuki</option>
                        <option value="Kawasaki">Kawasaki</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Tipe Motor</label>
                    <input type="text" name="tipe" class="form-control" placeholder="Contoh: PCX 160" required>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Warna</label>
                        <input type="text" name="warna" class="form-control" placeholder="Contoh: Merah Matte" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" placeholder="32000000" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Stok Awal</label>
                        <input type="number" name="stok" class="form-control" value="1" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Data</button>
                <a href="<?= base_url('index.php/dealer/motor') ?>" class="btn btn-secondary">Batal</a>

            </form>
        </div>
    </div>
</div>
