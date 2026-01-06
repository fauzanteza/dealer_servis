<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Ini adalah "Kamus" untuk VS Code supaya tidak error merah
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property Dealer_model $Dealer_model
 */
class Dealer extends CI_Controller
{

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
            'jenis_motor' => $this->input->post('motor'),
            'keluhan' => $this->input->post('keluhan'),
            'status' => 'Menunggu'
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
        // Upload Gambar
        $foto = $this->_upload_gambar();

        $data = array(
            'merk' => $this->input->post('merk'),
            'tipe' => $this->input->post('tipe'),
            'warna' => $this->input->post('warna'),
            'harga' => $this->input->post('harga'),
            'stok' => $this->input->post('stok'),
            'foto' => $foto
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
        $jumlah = $this->input->post('jumlah');

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
            'id_motor' => $id_motor,
            'tanggal' => date('Y-m-d'),
            'jumlah_beli' => $jumlah,
            'total_harga' => $this->input->post('total_bayar')
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
            'merk' => $this->input->post('merk'),
            'tipe' => $this->input->post('tipe'),
            'warna' => $this->input->post('warna'),
            'harga' => $this->input->post('harga'),
            'stok' => $this->input->post('stok')
        );

        // Cek jika ada gambar baru yang diupload
        if (!empty($_FILES['foto']['name'])) {
            $foto_baru = $this->_upload_gambar();
            if ($foto_baru) {
                // Hapus gambar lama
                $motor_lama = $this->Dealer_model->get_motor_by_id($id);
                if ($motor_lama['foto'] && file_exists('./uploads/motor/' . $motor_lama['foto'])) {
                    unlink('./uploads/motor/' . $motor_lama['foto']);
                }

                $data['foto'] = $foto_baru;
            }
        }

        $this->Dealer_model->update_motor($id, $data);
        redirect('dealer/motor');
    }
    // -------------------------------------------------------------------------
    // 10. FITUR HAPUS MOTOR
    // -------------------------------------------------------------------------
    public function hapus_motor($id)
    {
        // Ambil data motor untuk dapat nama file gambar
        $motor = $this->Dealer_model->get_motor_by_id($id);

        if ($motor['foto'] && file_exists('./uploads/motor/' . $motor['foto'])) {
            unlink('./uploads/motor/' . $motor['foto']);
        }

        $this->Dealer_model->hapus_motor($id);
        redirect('dealer/motor');
    }

    // -------------------------------------------------------------------------
    // 11. HELPER UPLOAD GAMBAR
    // -------------------------------------------------------------------------
    private function _upload_gambar()
    {
        $config['upload_path'] = './uploads/motor/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['file_name'] = 'motor_' . time(); // Nama file unik
        $config['max_size'] = 2048; // 2MB

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto')) {
            return $this->upload->data('file_name');
        }

        return null; // Jika gagal atau tidak ada file
    }

    // -------------------------------------------------------------------------
    // 13. SEED DATA SAMPLE V2 (FIX)
    // -------------------------------------------------------------------------
    public function seed_data()
    {
        // Load database manual just in case
        $this->load->database();

        $data = array(
            array(
                'merk' => 'Kawasaki',
                'tipe' => 'Ninja ZX-25R',
                'warna' => 'Hijau',
                'harga' => 105000000,
                'stok' => 3,
                'foto' => 'kawasaki_ninja.jpg'
            ),
            array(
                'merk' => 'Yamaha',
                'tipe' => 'NMAX 155 Connected',
                'warna' => 'Merah',
                'harga' => 32500000,
                'stok' => 5,
                'foto' => 'yamaha_nmax.jpg'
            ),
            array(
                'merk' => 'Honda',
                'tipe' => 'BeAT Street',
                'warna' => 'Silver',
                'harga' => 18500000,
                'stok' => 10,
                'foto' => 'honda_beat.jpg'
            ),
            array(
                'merk' => 'Honda',
                'tipe' => 'Vario 160 ABS',
                'warna' => 'Hitam Matte',
                'harga' => 29500000,
                'stok' => 7,
                'foto' => 'honda_vario.png'
            )
        );

        // Gunakan loop insert biasa untuk menghindari masalah driver
        foreach ($data as $row) {
            $this->db->insert('tb_motor', $row);
        }

        echo "Berhasil menambahkan 4 data motor sampel (V2)! <a href='" . base_url('index.php/dealer/motor') . "'>Lihat Data</a>";
    }

    // -------------------------------------------------------------------------
    // FITUR HAPUS DAN KUNCI TRANSAKSI
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
    // -------------------------------------------------------------------------
    // 14. EMERGENCY FIX DATABASE
    // -------------------------------------------------------------------------
    public function repair_db()
    {
        $this->load->database();

        // Cek apakah kolom sudah ada?
        $fields = $this->db->list_fields('tb_motor');
        if (in_array('foto', $fields)) {
            echo "Kolom 'foto' SUDAH ADA. Tidak perlu perbaikan.";
            echo "<br><a href='" . base_url('index.php/dealer/motor') . "'>Kembali ke Data Motor</a>";
            return;
        }

        // Kalau belum ada, kita tambahkan via SQL manual biar robust
        $query = "ALTER TABLE tb_motor ADD COLUMN foto VARCHAR(255) AFTER stok";

        if ($this->db->query($query)) {
            echo "Berhasil memperbaiki database! Kolom 'foto' telah ditambahkan.";
            echo "<br><a href='" . base_url('index.php/dealer/motor') . "'>Kembali ke Data Motor</a>";
        } else {
            echo "Gagal memperbaiki database. Error: " . $this->db->error()['message'];
        }
    }
    // -------------------------------------------------------------------------
    // 15. EMERGENCY FIX IMAGES (LINKING DATA)
    // -------------------------------------------------------------------------
    public function update_images_db()
    {
        $this->load->database();

        // 1. Update Ninja
        $this->db->where("tipe LIKE '%Ninja%'");
        $this->db->update('tb_motor', ['foto' => 'kawasaki_ninja.jpg']);

        // 2. Update NMAX
        $this->db->where("tipe LIKE '%NMAX%'");
        $this->db->update('tb_motor', ['foto' => 'yamaha_nmax.jpg']);

        // 3. Update Beat
        $this->db->where("tipe LIKE '%BeAT%'");
        $this->db->update('tb_motor', ['foto' => 'honda_beat.jpg']);

        // 4. Update Vario
        $this->db->where("tipe LIKE '%Vario%'");
        $this->db->update('tb_motor', ['foto' => 'honda_vario.png']);

        echo "Berhasil menghubungkan foto dengan data motor! <br><a href='" . base_url('index.php/dealer/motor') . "'>Kembali ke Data Motor</a>";
    }
}
