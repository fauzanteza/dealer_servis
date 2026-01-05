<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-success text-white">
            <h6 class="m-0 font-weight-bold">📝 Form Transaksi Penjualan Motor</h6>
        </div>
        <div class="card-body">
            
            <form action="<?= base_url('index.php/dealer/proses_beli') ?>" method="post" id="formTransaksi">
                
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
                    <select name="id_motor" id="pilih_motor" class="form-control" required onchange="hitungTotal()">
                        <option value="" data-harga="0" data-stok="0">-- Pilih Motor --</option>
                        
                        <?php foreach($motor as $mtr): ?>
                            <?php if($mtr['stok'] > 0): ?>
                                <option value="<?= $mtr['id_motor'] ?>" 
                                        data-harga="<?= $mtr['harga'] ?>" 
                                        data-stok="<?= $mtr['stok'] ?>">
                                    <?= $mtr['merk'] ?> - <?= $mtr['tipe'] ?> (Stok: <?= $mtr['stok'] ?>)
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted" id="info_stok">* Stok tersedia: -</small>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Jumlah Beli</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" value="1" min="1" required oninput="hitungTotal()">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Total Bayar (Rp)</label>
                        <input type="number" name="total_bayar" id="total" class="form-control" readonly>
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

<script>
function hitungTotal() {
    // 1. Ambil elemen-elemen
    var dropdown = document.getElementById('pilih_motor');
    var inputJumlah = document.getElementById('jumlah');
    var inputTotal = document.getElementById('total');
    var infoStok = document.getElementById('info_stok');

    // 2. Ambil data dari opsi yang dipilih (Harga & Stok)
    var selectedOption = dropdown.options[dropdown.selectedIndex];
    var harga = selectedOption.getAttribute('data-harga');
    var stokTersedia = parseInt(selectedOption.getAttribute('data-stok'));
    var jumlahBeli = parseInt(inputJumlah.value);

    // 3. Validasi Stok (Mencegah beli melebihi stok)
    if (stokTersedia > 0) {
        // Update teks info stok
        infoStok.innerHTML = "* Stok tersedia: <b>" + stokTersedia + " Unit</b>";
        
        // Paksa input jumlah tidak boleh lebih dari stok
        inputJumlah.setAttribute('max', stokTersedia);

        if (jumlahBeli > stokTersedia) {
            alert("Maaf, jumlah pembelian melebihi stok yang tersedia (" + stokTersedia + " unit)!");
            inputJumlah.value = stokTersedia; // Reset ke maksimal stok
            jumlahBeli = stokTersedia;
        }
    } else {
        infoStok.innerHTML = "* Pilih motor terlebih dahulu.";
    }

    // 4. Hitung Total Bayar
    var total = harga * jumlahBeli;
    inputTotal.value = total;
}
</script>
