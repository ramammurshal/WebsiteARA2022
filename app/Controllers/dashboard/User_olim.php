<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\Model_Olimpiade;

class User_olim extends BaseController
{
  public function __construct()
  {
    $this->session = session();
    $this->model_olim = new Model_Olimpiade();
  }
  public function home()
  {
    $tim = $this->model_olim->where('olim_nama_tim', $this->session->get('keterangan'))->first();
    $data = [
      'lomba' => 'Olimpiade',
      'nama' => $tim['olim_nama_tim'],
      'ketua' => $tim['olim_nama_ketua'],
      'anggota_1' => $tim['olim_nama_anggota_1'],
      'anggota_2' => $tim['olim_nama_anggota_2'],
      'uname' => $tim['olim_uname_lomba'],
      'passw' => $tim['olim_passw_lomba'],
      'juara' => $tim['olim_juara'], //all pw test juara: juara123
    ];
    return view('dashboard/user/olimpiade/home', $data);
  }

  public function team()
  {
    $tim = $this->model_olim->where('olim_nama_tim', $this->session->get('keterangan'))->first();
    $data = [
      'lomba' => 'Olimpiade',
      'nama' => $tim['olim_nama_tim'],
      'ketua' => $tim['olim_nama_ketua'],
      'institusi' => $tim['olim_institusi'],
      'anggota_1' => $tim['olim_nama_anggota_1'],
      'anggota_2' => $tim['olim_nama_anggota_2'],
      "id" => $tim["olim_id"],
    ];
    return view('dashboard/user/olimpiade/team', $data);
  }
}
