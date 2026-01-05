<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dealer_model extends CI_Model {

    // 1. Fungsi ambil data SERVIS (untuk halaman antrian)
    public function get_data_servis()
    {
        return $this->db->get('tb_servis')->result_array();
    }

    // 2. Fungsi tambah data SERVIS (untuk form input)
    public function tambah_data($data)
    {
        $this->db->insert('tb_servis', $data);
    }

    // 3. Fungsi ambil data STOK MOTOR (Ini yang tadi hilang/error)
    public function get_data_motor()
    {
        return $this->db->get('tb_motor')->result_array();
    }
	// 4. Fungsi Ubah Status Servis (Update Database)
    public function update_status($id, $status_baru)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_servis', ['status' => $status_baru]);
    }

    // 5. Fungsi Hapus Data Servis
    public function hapus_servis($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tb_servis');
    }
    // 6. Fungsi Tambah Stok Motor
    public function insert_motor($data)
    {
        $this->db->insert('tb_motor', $data);
    }
	// 7. Ambil Data Penjualan (Untuk Laporan)
    public function get_data_penjualan()
    {
        // Kita join dengan tb_motor supaya tahu nama motornya apa
        $this->db->select('tb_penjualan.*, tb_motor.merk, tb_motor.tipe');
        $this->db->from('tb_penjualan');
        $this->db->join('tb_motor', 'tb_motor.id_motor = tb_penjualan.id_motor');
        return $this->db->get()->result_array();
    }

    // 8. Proses Transaksi (Simpan Jual & Kurangi Stok)
    public function simpan_penjualan($data_jual, $id_motor, $qty)
    {
        // A. Simpan data transaksi
        $this->db->insert('tb_penjualan', $data_jual);

        // B. Kurangi Stok Motor (Fitur Canggih)
        $this->db->set('stok', 'stok - ' . $qty, FALSE);
        $this->db->where('id_motor', $id_motor);
        $this->db->update('tb_motor');
    }
	// 9. Ambil 1 Data Motor berdasarkan ID (Untuk Edit)
    public function get_motor_by_id($id)
    {
        return $this->db->get_where('tb_motor', ['id_motor' => $id])->row_array();
    }

    // 10. Proses Update Data Motor
    public function update_motor($id, $data)
    {
        $this->db->where('id_motor', $id);
        $this->db->update('tb_motor', $data);
    }
	// 11. Fungsi Hapus Stok Motor
    public function hapus_motor($id)
    {
        $this->db->where('id_motor', $id);
        $this->db->delete('tb_motor');
    }
	// --- FITUR HAPUS PENJUALAN ---

    // A. Ambil 1 data penjualan (untuk tahu id_motor & jumlahnya)
    public function get_penjualan_by_id($id)
    {
        return $this->db->get_where('tb_penjualan', ['id_penjualan' => $id])->row_array();
    }

    // B. Kembalikan Stok (Saat transaksi dihapus/dibatalkan)
    public function kembalikan_stok($id_motor, $jumlah)
    {
        // Stok ditambah (+) karena barang batal terjual
        $this->db->set('stok', 'stok + ' . $jumlah, FALSE);
        $this->db->where('id_motor', $id_motor);
        $this->db->update('tb_motor');
    }

    // C. Hapus Data Penjualan
    public function hapus_penjualan($id)
    {
        $this->db->where('id_penjualan', $id);
        $this->db->delete('tb_penjualan');
    }

	// D. Kunci Transaksi (Agar tidak bisa dihapus lagi)
    public function kunci_transaksi($id)
    {
        $this->db->set('status', 'Selesai');
        $this->db->where('id_penjualan', $id);
        $this->db->update('tb_penjualan');
    }
}
