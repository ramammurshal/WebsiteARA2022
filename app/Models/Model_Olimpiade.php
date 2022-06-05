<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Olimpiade extends Model
{
    // ...
    protected $table = 'olimpiade';
    protected $primaryKey = 'olim_id';
    protected $allowedFields = ['olim_nama_tim', 'olim_jumlah_anggota', 'olim_email_ketua', 'olim_nama_ketua', 'olim_nama_anggota_1', 'olim_nama_anggota_2', 'olim_suket_ketua', 'olim_suket_anggota_1', 'olim_suket_anggota_2', 'olim_contact', 'olim_ig_ara_ketua', 'olim_ig_ara_anggota_1', 'olim_ig_ara_anggota_2', 'olim_ig_hmit_ketua', 'olim_ig_hmit_anggota_1', 'olim_ig_hmit_anggota_2', 'olim_institusi', 'olim_status', 'olim_juara', 'olim_status_final', 'olim_pembayaran'];
    protected $useTimestamps = true;
    protected $createdField = 'olim_date_created';
    protected $updatedField = 'olim_date_updated';
}
