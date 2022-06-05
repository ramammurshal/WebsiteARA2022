<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\Model_Kti_iot;

class User_kti_iot extends BaseController
{
  public function __construct()
  {
    $this->session = session();
    $this->model_kti_iot = new Model_Kti_iot();
  }

  // Memindahkan dan men-generate nama random file
  private function moveFile($path, $file)
  {
    if (!empty($file)) {
      $renamed = $file->getRandomName();
      $file->move($path, $renamed);
      return $renamed;
    }
    // File tidak ada
    return null;
  }
  private function moveFileCustom($path, $file, $filename)
  {
    if (!empty($file)) {
      // $renamed = $file->getRandomName();
      $file->move($path, $filename);
      return $filename;
    }
    // File tidak ada
    return null;
  }

  public function home()
  {
    if (!$this->session->has('username')) {
      return redirect()->to('/Auth/login');
    }
    if ($this->session->get('is_admin') == true) {
      return redirect()->to('/Auth/login');
    }
    $nama_tim = $this->session->get('keterangan');
    $tim = $this->model_kti_iot->where($this->model_kti_iot->nama_tim, $nama_tim)->first();
    $data = [
      'active' => 'home',
      'institusi' => $tim['iot_institusi'],
      'lomba' => 'KTI Internet of Things',
      'nama' => $tim['iot_nama_tim'],
      'ketua' => $tim[$this->model_kti_iot->nama_ketua],
      'anggota_1' => $tim[$this->model_kti_iot->nama_anggota_1],
      'anggota_2' => $tim[$this->model_kti_iot->nama_anggota_2],
      'status_konfirmasi_abstrak' => $tim['iot_status_konfirmasi_abstrak'],
      'status_penyisihan' => $tim['iot_status_penyisihan'],
      'status_final' => $tim['iot_status_final'],
      'id' => $tim["iot_id"],
    ];
    return view('dashboard/user/kti_iot/home', $data);
  }

  public function abstrak()
  {
    if (!$this->session->has('username')) {
      return redirect()->to('/Auth/login');
    }
    if ($this->session->get('is_admin') == true) {
      return redirect()->to('/Auth/login');
    }
    $nama_tim = $this->session->get('keterangan');
    $tim = $this->model_kti_iot->where($this->model_kti_iot->nama_tim, $nama_tim)->first();
    $data = [
      'active' => 'abstrak',
      'lomba' => 'KTI Internet of Things',
      'nama' => $tim['iot_nama_tim'],
      'ketua' => $tim[$this->model_kti_iot->nama_ketua],
      'anggota_1' => $tim[$this->model_kti_iot->nama_anggota_1],
      'anggota_2' => $tim[$this->model_kti_iot->nama_anggota_2],
      'abstrak' => $tim[$this->model_kti_iot->abstrak],
      'status_konfirmasi_abstrak' => $tim['iot_status_konfirmasi_abstrak'],
      'status_penyisihan' => $tim['iot_status_penyisihan'],
      'status_final' => $tim['iot_status_final'],
    ];
    return view('dashboard/user/kti_iot/abstrak', $data);
  }

  public function verify_abstrak()
  {
    if (!$this->session->has('username')) {
      return redirect()->to('/Auth/login');
    }
    if ($this->session->get('is_admin') == true) {
      return redirect()->to('/Auth/login');
    }
    $nama_tim = $this->session->get('keterangan');
    $tim = $this->model_kti_iot->where($this->model_kti_iot->nama_tim, $nama_tim)->first();
    // Ambil file abstrak
    $abstrak_file = $this->request->getFile('abstrak');
    // Define path
    $abstrak_path = 'uploads/kti_iot/abstrak';
    $abstrak_file_name = 'Abstrak_' . $tim['iot_id'] . '_' . $tim['iot_nama_tim'] . '.' . $abstrak_file->guessExtension();
    $renamed_abstrak_file = $this->moveFileCustom($abstrak_path, $abstrak_file, $abstrak_file_name);
    $data = [
      'iot_id' => $tim['iot_id'],
      'iot_abstrak' => $renamed_abstrak_file,
    ];
    if (!$this->model_kti_iot->save($data)) {
      return redirect()->to('dashboard/user_kti_iot/abstrak')->withInput();
    }

    return redirect()->to('dashboard/user_kti_iot/abstrak')->withInput();
  }

  public function full_paper()
  {
    if (!$this->session->has('username')) {
      return redirect()->to('/Auth/login');
    }
    if ($this->session->get('is_admin') == true) {
      return redirect()->to('/Auth/login');
    }
    $nama_tim = $this->session->get('keterangan');
    $tim = $this->model_kti_iot->where($this->model_kti_iot->nama_tim, $nama_tim)->first();
    $data = [
      'active' => 'full_paper',
      'lomba' => 'KTI Internet of Things',
      'nama' => $tim['iot_nama_tim'],
      'ketua' => $tim[$this->model_kti_iot->nama_ketua],
      'anggota_1' => $tim[$this->model_kti_iot->nama_anggota_1],
      'anggota_2' => $tim[$this->model_kti_iot->nama_anggota_2],
      'full_paper' => $tim[$this->model_kti_iot->full_paper],
      'status_konfirmasi_abstrak' => $tim['iot_status_konfirmasi_abstrak'],
      'status_penyisihan' => $tim['iot_status_penyisihan'],
      'status_final' => $tim['iot_status_final'],
      'status_bayar_full_paper' => $tim['iot_status_konfirmasi_full_paper'],
      'pembayaran_full_paper' => $tim['iot_pembayaran_full_paper']
    ];
    // Jika tidak lolos final (asal akses)
    // if (!$data['status_konfirmasi_abstrak'])
    //   return redirect()->to('dashboard/user_kti_iot/home');

    if ($data['status_penyisihan']) {
      // Belom bayar
      // if (!$data['status_bayar_full_paper'])
      //   return view('dashboard/user/kti_iot/bayar_full_paper', $data);
      return view('dashboard/user/kti_iot/full_paper', $data);
    }
    // Belum full paper
    return view('dashboard/user/kti_iot/belum_full_paper', $data);
  }

  // Pembayaran full paper
  // public function payment_full_paper()
  // {
  //   if (!$this->session->has('username')) {
  //     return redirect()->to('/Auth/login');
  //   }
  //   if ($this->session->get('is_admin') == true) {
  //     return redirect()->to('/Auth/login');
  //   }
  //   $bukti_bayar = $this->request->getFile('bukti_bayar');
  //   $bayar_path = 'uploads/kti_iot/bukti_bayar/full_paper';
  //   $renamed_bukti_bayar = $this->moveFile($bayar_path, $bukti_bayar);
  //   $nama_tim = $this->session->get('keterangan');
  //   $tim = $this->model_kti_iot->where($this->model_kti_iot->nama_tim, $nama_tim)->first();
  //   $data = [
  //     'iot_id' => $tim['iot_id'],
  //     'iot_pembayaran_full_paper' => $renamed_bukti_bayar,
  //     'iot_status_konfirmasi_full_paper' => 0,
  //   ];
  //   $this->model_kti_iot->save($data);
  //   return redirect()->to('dashboard/user_kti_iot/full_paper');
  // }

  // verifikasi input file full paper
  public function verify_full_paper()
  {
    if (!$this->session->has('username')) {
      return redirect()->to('/Auth/login');
    }
    if ($this->session->get('is_admin') == true) {
      return redirect()->to('/Auth/login');
    }
    $nama_tim = $this->session->get('keterangan');
    $tim = $this->model_kti_iot->where($this->model_kti_iot->nama_tim, $nama_tim)->first();
    // Ambil file abstrak
    $full_paper_file = $this->request->getFile('full_paper');
    // Define path
    $full_paper_path = 'uploads/kti_iot/full_paper';
    $full_paper_file_name = 'KTI_' . $tim['iot_id'] . '_' . $tim['iot_nama_tim'] . '.' . $full_paper_file->guessExtension();
    $renamed_full_paper = $this->moveFileCustom($full_paper_path, $full_paper_file, $full_paper_file_name);
    $data = [
      'iot_id' => $tim['iot_id'],
      'iot_kti_paper' => $renamed_full_paper,
    ];
    $this->model_kti_iot->save($data);

    return redirect()->to('dashboard/user_kti_iot/full_paper')->withInput();
  }

  public function final()
  {
    if (!$this->session->has('username')) {
      return redirect()->to('/Auth/login');
    }
    if ($this->session->get('is_admin') == true) {
      return redirect()->to('/Auth/login');
    }
    $nama_tim = $this->session->get('keterangan');
    $tim = $this->model_kti_iot->where($this->model_kti_iot->nama_tim, $nama_tim)->first();
    $data = [
      'active' => 'final',
      'lomba' => 'KTI Internet of Things',
      'nama' => $tim['iot_nama_tim'],
      'ketua' => $tim[$this->model_kti_iot->nama_ketua],
      'anggota_1' => $tim[$this->model_kti_iot->nama_anggota_1],
      'anggota_2' => $tim[$this->model_kti_iot->nama_anggota_2],
      'status_konfirmasi_abstrak' => $tim['iot_status_konfirmasi_abstrak'],
      'status_penyisihan' => $tim['iot_status_penyisihan'],
      'status_final' => $tim['iot_status_final'],
      'juara' => $tim['iot_juara'], //all pw test juara: juara123
      'pembayaran_final' => $tim['iot_pembayaran_final'],
      'status_bayar_final' => $tim['iot_status_konfirmasi_final']
    ];
    // Jika asal akses
    // if (!$data['status_konfirmasi_abstrak'] || !$data['status_penyisihan'])
    //   return redirect()->to('dashboard/user_kti_iot/home');

    // Cek apakah lulus final atau tidak
    if ($data['status_final']) {
      // Cek jika belum bayar
      // if (!$data['status_bayar_final'])
      //   return view('dashboard/user/kti_iot/bayar_final', $data);
      return view('dashboard/user/kti_iot/final', $data);
    } else
      return view('dashboard/user/kti_iot/belum_final', $data);
  }

  // Pembayaran final
  // public function payment_final()
  // {
  //   if (!$this->session->has('username')) {
  //     return redirect()->to('/Auth/login');
  //   }
  //   if ($this->session->get('is_admin') == true) {
  //     return redirect()->to('/Auth/login');
  //   }
  //   $bukti_bayar = $this->request->getFile('bukti_bayar');
  //   $bayar_path = 'uploads/kti_iot/bukti_bayar/final';
  //   $renamed_bukti_bayar = $this->moveFile($bayar_path, $bukti_bayar);
  //   $nama_tim = $this->session->get('keterangan');
  //   $tim = $this->model_kti_iot->where($this->model_kti_iot->nama_tim, $nama_tim)->first();
  //   $data = [
  //     'iot_id' => $tim['iot_id'],
  //     'iot_pembayaran_final' => $renamed_bukti_bayar,
  //     'iot_status_konfirmasi_final' => 0
  //   ];
  //   $this->model_kti_iot->save($data);
  //   return redirect()->to('dashboard/user_kti_iot/final');
  // }
}
