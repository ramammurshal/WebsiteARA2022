<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_ctf extends Model
{
    // ...
    protected $table = 'ctf';
    protected $primaryKey = 'ctf_id';
    protected $allowedFields = [
        'ctf_nama_tim',
        'ctf_jumlah_anggota',
        'ctf_email_ketua',
        'ctf_nama_ketua',
        'ctf_nama_anggota_1',
        'ctf_nama_anggota_2',
        'ctf_suket_ketua',
        'ctf_suket_anggota_1',
        'ctf_suket_anggota_2',
        'ctf_krsm_ketua',
        'ctf_krsm_anggota_1',
        'ctf_krsm_anggota_2',
        'ctf_ig_ara_ketua',
        'ctf_ig_ara_anggota_1',
        'ctf_ig_ara_anggota_2',
        'ctf_ig_hmit_ketua',
        'ctf_ig_hmit_anggota_1',
        'ctf_ig_hmit_anggota_2',
        'ctf_intitusi',
        'ctf_contact',
        'ctf_status_final',
        'ctf_juara',
        'ctf_bukti_bayar',
        'ctf_status'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'ctf_date_created';
    protected $updatedField = 'ctf_date_updated';
}
