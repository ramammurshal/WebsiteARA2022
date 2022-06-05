<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Kti_iot extends Model
{
    protected $table = 'kti_iot';
    protected $primaryKey = 'iot_id';
    protected $allowedFields = ['iot_nama_tim', 'iot_jumlah_anggota', 'iot_email_ketua', 'iot_nama_ketua', 'iot_nama_anggota_1', 'iot_nama_anggota_2', 'iot_suket_ketua', 'iot_suket_anggota_1', 'iot_suket_anggota_2', 'iot_krsm_ketua', 'iot_krsm_anggota_1', 'iot_krsm_anggota_2', 'iot_contact', 'iot_institusi', 'iot_story_ketua', 'iot_story_anggota_1', 'iot_story_anggota_2', 'iot_ig_ara_ketua', 'iot_ig_ara_anggota_1', 'iot_ig_ara_anggota_2', 'iot_ig_hmit_ketua', 'iot_ig_hmit_anggota_1', 'iot_ig_hmit_anggota_2', 'iot_abstrak', 'iot_kti_paper', 'iot_status_penyisihan', 'iot_status_final', 'iot_juara', 'iot_pembayaran_full_paper', 'iot_pembayaran_final', 'iot_status_konfirmasi_abstrak', 'iot_status_konfirmasi_full_paper', 'iot_status_konfirmasi_final'];
    protected $useTimestamps = true;
    protected $nama_tim = 'iot_nama_tim';
    protected $nama_ketua = 'iot_nama_ketua';
    protected $nama_anggota_1 = 'iot_nama_anggota_1';
    protected $nama_anggota_2 = 'iot_nama_anggota_2';
    protected $abstrak = 'iot_abstrak';
    protected $full_paper = 'iot_kti_paper';
    protected $createdField = 'iot_date_created';
    protected $final = 'iot_status_final';
    protected $updatedField = 'iot_date_updated';
}
