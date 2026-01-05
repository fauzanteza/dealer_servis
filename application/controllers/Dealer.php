<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Ini adalah "Kamus" untuk VS Code supaya tidak error merah
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property Dealer_model $Dealer_model
 */
class Dealer extends CI_Controller {

    // -------------------------------------------------------------------------
    // 1. BAGIAN PENTING: CONSTRUCTOR
    // Disini tempat kita me-load Model & Library agar bisa dipakai di semua fungsi
    // -------------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();
        // Memanggil Model agar dikenali oleh Controller
        $this->load->model('Dealer_model');
        // Mengaktifkan helper URL (opsional jika belum di autoload)
        $this->load->helper('url');
    }

    // -------------------------------------------------------------------------
    // 2. HALAMAN UTAMA (Dashboard / Daftar Servis)
    // -------------------------------------------------------------------------
    public function index()
    {
        // Ambil data dari Model
        $data['antrian'] = $this->Dealer_model->get_data_servis();

        // Tampilkan menggunakan Template (Header, Sidebar, Konten, Footer)
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('dealer_view', $data); // Konten Tengah (Tabel)
        $this->load->view('templates/footer');
    }

    // -------------------------------------------------------------------------
    // 3. HALAMAN FORM TAMBAH
    // -------------------------------------------------------------------------
    public function tambah()
    {
        // Tampilkan Form Tambah dengan Template
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('tambah_view');        // Konten Tengah (Form)
        $this->load->view('templates/footer');
    }

    // -------------------------------------------------------------------------
    // 4. PROSES SIMPAN DATA (Aksi dari Form)
    // -------------------------------------------------------------------------
    public function simpan()
    {
        // Tangkap data dari inputan form
        $data = array(
            'nama_pelanggan' => $this->input->post('nama'),
            'jenis_motor'    => $this->input->post('motor'),
            'keluhan'        => $this->input->post('keluhan'),
            'status'         => 'Menunggu'
        );

        // Kirim ke Model untuk disimpan ke Database
        $this->Dealer_model->tambah_data($data);

        // Kembali ke halaman utama
        redirect('dealer');
    }
	// -------------------------------------------------------------------------
    // 5. HALAMAN STOK MOTOR
    // -------------------------------------------------------------------------
    public function motor()
    {
        // 1. Ambil data motor dari Model
        $data['stok_motor'] = $this->Dealer_model->get_data_motor();

        // 2. Tampilkan View dengan Template
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('motor_view', $data); // Kita akan buat file ini setelah ini
        $this->load->view('templates/footer');
    }
	// -------------------------------------------------------------------------
    // 6. AKSI TOMBOL SERVIS (Proses, Selesai, Hapus)
    // -------------------------------------------------------------------------

    // Ubah status jadi 'Diproses'
    public function proses_servis($id)
    {
        $this->Dealer_model->update_status($id, 'Diproses');
        redirect('dealer');
    }

    // Ubah status jadi 'Selesai'
    public function selesai_servis($id)
    {
        $this->Dealer_model->update_status($id, 'Selesai');
        redirect('dealer');
    }

    // Hapus data antrian
    public function hapus_servis($id)
    {
        $this->Dealer_model->hapus_servis($id);
        redirect('dealer');
    }
	// -------------------------------------------------------------------------
    // FUNGSI KHUSUS MENU "ANTRIAN SERVIS"
    // -------------------------------------------------------------------------
    public function servis()
    {
        // Kita pakai logika yang sama dengan index()
        $data['antrian'] = $this->Dealer_model->get_data_servis();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('dealer_view', $data); // Tampilkan tabel antrian
        $this->load->view('templates/footer');
    }
	// -------------------------------------------------------------------------
    // 7. FITUR TAMBAH MOTOR BARU
    // -------------------------------------------------------------------------
    
    // Menampilkan Form Tambah Motor
    public function tambah_motor()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('tambah_motor_view'); // Kita buat view ini sebentar lagi
        $this->load->view('templates/footer');
    }

    // Proses Simpan Data Motor
    public function simpan_motor()
    {
        $data = array(
            'merk'  => $this->input->post('merk'),
            'tipe'  => $this->input->post('tipe'),
            'warna' => $this->input->post('warna'),
            'harga' => $this->input->post('harga'),
            'stok'  => $this->input->post('stok')
        );

        $this->Dealer_model->insert_motor($data);
        redirect('dealer/motor');
    }
	// -------------------------------------------------------------------------
    // 8. FITUR TRANSAKSI PENJUALAN
    // -------------------------------------------------------------------------
    
    // Halaman Riwayat Penjualan
    public function penjualan()
    {
        $data['transaksi'] = $this->Dealer_model->get_data_penjualan();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('penjualan_view', $data); // Kita buat ini nanti
        $this->load->view('templates/footer');
    }

    // Halaman Form Transaksi Baru
    public function tambah_penjualan()
    {
        // Kita butuh data motor untuk dipilih di dropdown
        $data['motor'] = $this->Dealer_model->get_data_motor();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('tambah_penjualan_view', $data); // Kita buat ini nanti
        $this->load->view('templates/footer');
    }

    // Proses Simpan Transaksi (Update Validasi Stok)
    public function proses_beli()
    {
        $id_motor = $this->input->post('id_motor');
        $jumlah   = $this->input->post('jumlah');

        // 1. Ambil data motor untuk cek stok di database (Validasi Server)
        $motor = $this->Dealer_model->get_motor_by_id($id_motor);

        // Jika jumlah beli lebih besar dari stok database -> BATALKAN
        if ($jumlah > $motor['stok']) {
            echo "<script>
                alert('Transaksi Gagal! Stok tidak mencukupi.');
                window.location.href='" . base_url('index.php/dealer/tambah_penjualan') . "';
            </script>";
            return; // Berhenti disini
        }

        // 2. Jika aman, lanjut simpan
        $data = array(
            'nama_pembeli' => $this->input->post('nama_pembeli'),
            'id_motor'     => $id_motor,
            'tanggal'      => date('Y-m-d'),
            'jumlah_beli'  => $jumlah,
            'total_harga'  => $this->input->post('total_bayar')
        );

        $this->Dealer_model->simpan_penjualan($data, $id_motor, $jumlah);
        redirect('dealer/penjualan');
		
    }
	// -------------------------------------------------------------------------
    // 9. FITUR EDIT DATA MOTOR
    // -------------------------------------------------------------------------

    // Menampilkan Form Edit (Terisi Data Lama)
    public function edit_motor($id)
    {
        // Ambil data motor lama berdasarkan ID
        $data['motor'] = $this->Dealer_model->get_motor_by_id($id);

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('edit_motor_view', $data); // Kita buat view ini sebentar lagi
        $this->load->view('templates/footer');
    }

    // Proses Simpan Perubahan
    public function update_motor()
    {
        $id = $this->input->post('id_motor'); // Ambil ID yang disembunyikan

        $data = array(
            'merk'  => $this->input->post('merk'),
            'tipe'  => $this->input->post('tipe'),
            'warna' => $this->input->post('warna'),
            'harga' => $this->input->post('harga'),
            'stok'  => $this->input->post('stok')
        );

        $this->Dealer_model->update_motor($id, $data);
        redirect('dealer/motor');
    }
	// -------------------------------------------------------------------------
    // 10. FITUR HAPUS MOTOR
    // -------------------------------------------------------------------------
// Hapus Transaksi & Kembalikan Stok
    public function hapus_penjualan($id)
    {
        // 1. Ambil data transaksi dulu sebelum dihapus
        $transaksi = $this->Dealer_model->get_penjualan_by_id($id);

        if ($transaksi) {
            // 2. Kembalikan stok motor (Restock)
            $this->Dealer_model->kembalikan_stok($transaksi['id_motor'], $transaksi['jumlah_beli']);

            // 3. Baru hapus data transaksinya
            $this->Dealer_model->hapus_penjualan($id);
        }

        redirect('dealer/penjualan');
    }

	// Aksi untuk Mengunci Transaksi (Simpan Permanen)
    public function kunci_transaksi($id)
    {
        $this->Dealer_model->kunci_transaksi($id);
        // Redirect kembali ke halaman penjualan
        redirect('dealer/penjualan');
    }
}
