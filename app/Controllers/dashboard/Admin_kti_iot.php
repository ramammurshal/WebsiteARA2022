<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\Model_Account;
use App\Models\Model_custom;
use App\Models\Model_Kti_iot;

class Admin_kti_iot extends BaseController
{
  public function __construct()
  {
    $this->session = session();
    $this->model_kti_iot = new Model_Kti_iot();
    $this->model_account = new Model_Account();
    $this->model_custom = new Model_custom();
  }

  public function list_abstrak()
  {
    if (!$this->session->get('is_admin')) {
      return redirect()->to('/Auth/login');
    }
    if (!$this->session->get('username')) {
      return redirect()->to('/Auth/login');
    }
    $data = [
      'lomba' => 'KTI Internet of Things',
      'nama' => 'Admin KTI IoT',
      'tahap' => 'Abstrak',
      'list_tim_abstrak' => $this->model_kti_iot->where('iot_status_konfirmasi_abstrak', 1)->findAll(),
      'terkonfirmasi' => $this->model_kti_iot->where('iot_status_konfirmasi_abstrak', 1)->countAllResults(),
      'belum_terkonfirmasi' => $this->model_kti_iot->where('iot_status_konfirmasi_abstrak', 0)->countAllResults(),
      'total_peserta' => $this->model_kti_iot->where('iot_status_konfirmasi_abstrak', 1)->countAllResults() + $this->model_kti_iot->where('iot_status_konfirmasi_abstrak', 0)->countAllResults()
    ];
    // dd($data);
    return view("dashboard/admin/kti_iot/list_abstrak", $data);
  }

  public function konfirmasi_abstrak()
  {
    if (!$this->session->get('is_admin')) {
      return redirect()->to('/Auth/login');
    }
    if (!$this->session->get('username')) {
      return redirect()->to('/Auth/login');
    }
    $data = [
      'lomba' => 'KTI Internet of Things',
      'nama' => 'Admin KTI IoT',
      'tahap' => 'Abstrak',
      'list_tim_abstrak' => $this->model_kti_iot->where('iot_status_konfirmasi_abstrak', 0)->findAll(),
      'terkonfirmasi' => $this->model_kti_iot->where('iot_status_konfirmasi_abstrak', 1)->countAllResults(),
      'belum_terkonfirmasi' => $this->model_kti_iot->where('iot_status_konfirmasi_abstrak', 0)->countAllResults(),
      'total_peserta' => $this->model_kti_iot->where('iot_status_konfirmasi_abstrak', 1)->countAllResults() + $this->model_kti_iot->where('iot_status_konfirmasi_abstrak', 0)->countAllResults()
    ];
    return view("dashboard/admin/kti_iot/konfirmasi_abstrak", $data);
  }

  public function verify_konfirmasi_abstrak($id, $status)
  {
    if (!$this->session->get('is_admin')) {
      return redirect()->to('/Auth/login');
    }
    if (!$this->session->get('username')) {
      return redirect()->to('/Auth/login');
    }
    // $id = $this->request->getVar('id');
    // $status = $this->request->getVar('status');
    $tim = $this->model_kti_iot->where('iot_id', $id)->first();
    // Untuk men-delete file, relatif terhadap folder public
    // unlink('backend/121079.jpg');
    // Jika di accept
    helper('text');
    if ($status) {
      $password = random_string('alnum', 16);
      $name = random_string('alnum', 8);

      if ($this->model_custom->is_pass_same($password)) {
        return redirect()->to('dashboard/Admin_kti_iot/verify_konfirmasi_abstrak/' . $id . '/1');
      } else {
        $data_status = [
          'iot_id' => $tim['iot_id'],
          'iot_status_konfirmasi_abstrak' => 1
        ];
        $this->model_kti_iot->save($data_status);
        $data = [
          'account_table'       => 'kti_iot',
          'account_keterangan'  => $tim['iot_nama_tim'],
          'account_username'    => 'kti_iot' . $name . '_' . $tim['iot_nama_tim'],
          'account_password'    => password_hash($password, PASSWORD_DEFAULT)
        ];
        $this->model_account->save($data);
        $subject = "[Accepted] Internet of Things (IOT)";
        $message = "Dear {$tim['iot_nama_tim']} from {$tim['iot_institusi']} ,<br>
                  <br>
                  Thank you for registering for our competition, \"Internet of Things (IOT).\"<br>
                  <br>
                  This is your account username and password <br>
                  <br>
                  Username : {$data['account_username']}<br>
                  Password : {$password}<br>
                  <br>
                  --<br>
                  Best regards,<br>
                  <br>
                  A Renewal Agents 2022";
        $this->sendemail($tim['iot_email_ketua'], $subject, $message);
        $this->session->setFlashdata('msg', 'berhasil menerima peserta');
      }
    } else {
      // Tampung nama file
      $ktm_path = 'uploads/kti_iot/ktm/';
      $ig_follow_path = 'uploads/kti_iot/ig/follow/';
      $ig_share_path = 'uploads/kti_iot/ig/share/';
      $abstrak_path = 'uploads/kti_iot/abstrak/';

      // Delete ktm
      $this->delete_file($ktm_path, $tim['iot_suket_ketua']);
      $this->delete_file($ktm_path, $tim['iot_suket_anggota_1']);
      $this->delete_file($ktm_path, $tim['iot_suket_anggota_2']);

      // Delete ig
      $this->delete_file($ig_follow_path, $tim['iot_ig_ara_ketua']);
      $this->delete_file($ig_follow_path, $tim['iot_ig_ara_anggota_1']);
      $this->delete_file($ig_follow_path, $tim['iot_ig_ara_anggota_2']);

      $this->delete_file($ig_share_path, $tim['iot_story_ketua']);
      $this->delete_file($ig_share_path, $tim['iot_story_anggota_1']);
      $this->delete_file($ig_share_path, $tim['iot_story_anggota_2']);

      // Delete abstrak
      $this->delete_file($abstrak_path, $tim['iot_abstrak']);

      // Delete field di db
      $this->model_kti_iot->where('iot_id', $tim['iot_id'])->delete();
      $subject = "[Rejected] Internet of Things (IOT)";
      $message = "Dear {$tim['iot_nama_tim']} from {$tim['iot_institusi']} ,<br>
                  <br>
                  Thank you for registering for our event, \"Internet of Things (IOT).\"<br>
                  <br>
                  unfortunately your requirement is not enough, so please register again in the form <br>
                  <br>
                  <br>
                  --<br>
                  Best regards,<br>
                  <br>
                  A Renewal Agents 2022";
      $this->sendemail($tim['iot_email_ketua'], $subject, $message);
      $this->session->setFlashdata('msg', 'berhasil menolak peserta');
    }
    return redirect()->to('dashboard/Admin_kti_iot/konfirmasi_abstrak');
  }

  public function delete_file($path, $filename)
  {
    if (!empty($filename))
      unlink($path . $filename);
    return;
  }

  public function list_fullpaper()
  {
    if (!$this->session->get('is_admin')) {
      return redirect()->to('/Auth/login');
    }
    if (!$this->session->get('username')) {
      return redirect()->to('/Auth/login');
    }
    $data = [
      'lomba' => 'KTI Internet of Things',
      'nama' => 'Admin KTI IoT',
      'tahap' => 'Full Paper',
      'list_tim_full_paper' => $this->model_kti_iot->where('iot_status_konfirmasi_full_paper', 1)->findAll(),
      'terkonfirmasi' => $this->model_kti_iot->where('iot_status_konfirmasi_full_paper', 1)->countAllResults(),
      'belum_terkonfirmasi' => 0,
      // 'belum_terkonfirmasi' => $this->model_kti_iot->where('iot_status_konfirmasi_full_paper', 0)->countAllResults(),
      'total_peserta' => $this->model_kti_iot->where('iot_status_konfirmasi_full_paper', 1)->countAllResults(),
      // 'total_peserta' => $this->model_kti_iot->where('iot_status_konfirmasi_full_paper', 1)->countAllResults() + $this->model_kti_iot->where('iot_status_konfirmasi_full_paper', 0)->countAllResults()
    ];
    return view("dashboard/admin/kti_iot/list_fullpaper", $data);
  }

  // public function konfirmasi_fullpaper()
  // {
  //   if (!$this->session->get('is_admin')) {
  //     return redirect()->to('/Auth/login');
  //   }
  //   if (!$this->session->get('username')) {
  //     return redirect()->to('/Auth/login');
  //   }
  //   $data = [
  //     'lomba' => 'KTI Internet of Things',
  //     'nama' => 'Admin KTI IoT',
  //     'tahap' => 'Full Paper',
  //     // Cari daftar tim yang sudah upload bukti bayar full paper
  //     'list_tim_full_paper' => $this->model_kti_iot->where([
  //       'iot_status_konfirmasi_full_paper' => 0,
  //       'iot_pembayaran_full_paper is NOT NULL' => null
  //     ])->findAll(),
  //     'terkonfirmasi' => $this->model_kti_iot->where('iot_status_konfirmasi_full_paper', 1)->countAllResults(),
  //     'belum_terkonfirmasi' => $this->model_kti_iot->where('iot_status_konfirmasi_full_paper', 0)->countAllResults(),
  //     'total_peserta' => $this->model_kti_iot->where('iot_status_konfirmasi_full_paper', 1)->countAllResults() + $this->model_kti_iot->where('iot_status_konfirmasi_full_paper', 0)->countAllResults()
  //   ];
  //   return view("dashboard/admin/kti_iot/konfirmasi_fullpaper", $data);
  // }

  // public function verify_konfirmasi_full_paper($id, $status)
  // {
  //   if (!$this->session->get('is_admin')) {
  //     return redirect()->to('/Auth/login');
  //   }
  //   if (!$this->session->get('username')) {
  //     return redirect()->to('/Auth/login');
  //   }
  //   // $id = $this->request->getVar('id');
  //   // $status = $this->request->getVar('status');
  //   $tim = $this->model_kti_iot->where('iot_id', $id)->first();
  //   // Jika di Terima
  //   if ($status) {
  //     $data = [
  //       'iot_id' => $tim['iot_id'],
  //       'iot_status_konfirmasi_full_paper' => 1
  //     ];
  //     $this->model_kti_iot->save($data);
  //     $subject = "[Accepted] Internet of Things (IOT)";
  //     $message = "Dear {$tim['iot_nama_tim']} from {$tim['iot_institusi']} ,<br>
  //                 <br>
  //                 Thank you for participating for our event, \"Internet of Things (IOT).\"<br>
  //                 <br>
  //                 your payment to follow the full paper stage has been received. Then you can input your full paper in your dashboard. <br>
  //                 <br>
  //                 <br>
  //                 --<br>
  //                 Best regards,<br>
  //                 <br>
  //                 A Renewal Agents 2022";
  //     $this->sendemail($tim['iot_email_ketua'], $subject, $message);
  //     $this->session->setFlashdata('msg', 'berhasil menerima peserta');
  //   } else {
  //     //Jika ditolak, delete file bayar full paper
  //     $path = 'uploads/kti_iot/bukti_bayar/full_paper/';
  //     $this->delete_file($path, $tim['iot_pembayaran_full_paper']);
  //     $data = [
  //       'iot_id' => $tim['iot_id'],
  //       'iot_pembayaran_full_paper' => null,
  //       'iot_status_konfirmasi_full_paper' => null
  //     ];
  //     $this->model_kti_iot->save($data);

  //     $subject = "[Rejected] Internet of Things (IOT)";
  //     $message = "Dear {$tim['iot_nama_tim']} from {$tim['iot_institusi']} ,<br>
  //                 <br>
  //                 Thank you for participating for our event, \"Internet of Things (IOT).\"<br>
  //                 <br>
  //                 unfortunately your payment requirement is invalid, so please input again in your dahsboard <br>
  //                 <br>
  //                 <br>
  //                 --<br>
  //                 Best regards,<br>
  //                 <br>
  //                 A Renewal Agents 2022";
  //     $this->sendemail($tim['iot_email_ketua'], $subject, $message);
  //     $this->session->setFlashdata('msg', 'berhasil menolak peserta');
  //   }
  //   return redirect()->to('dashboard/Admin_kti_iot/konfirmasi_fullpaper');
  // }

  public function list_final()
  {
    if (!$this->session->get('is_admin')) {
      return redirect()->to('/Auth/login');
    }
    if (!$this->session->get('username')) {
      return redirect()->to('/Auth/login');
    }
    $data = [
      'lomba' => 'KTI Internet of Things',
      'nama' => 'Admin KTI IoT',
      'tahap' => 'Final',
      'list_tim_final' => $this->model_kti_iot->where('iot_status_konfirmasi_final', 1)->findAll(),
      'terkonfirmasi' => $this->model_kti_iot->where('iot_status_konfirmasi_final', 1)->countAllResults(),
      'belum_terkonfirmasi' => 0,
      // 'belum_terkonfirmasi' => $this->model_kti_iot->where('iot_status_konfirmasi_final', 0)->countAllResults(),
      'total_peserta' => $this->model_kti_iot->where('iot_status_konfirmasi_final', 1)->countAllResults(),
      // 'total_peserta' => $this->model_kti_iot->where('iot_status_konfirmasi_final', 1)->countAllResults() + $this->model_kti_iot->where('iot_status_konfirmasi_final', 0)->countAllResults()
    ];
    return view("dashboard/admin/kti_iot/list_final", $data);
  }

  // public function konfirmasi_final()
  // {
  //   if (!$this->session->get('is_admin')) {
  //     return redirect()->to('/Auth/login');
  //   }
  //   if (!$this->session->get('username')) {
  //     return redirect()->to('/Auth/login');
  //   }
  //   $data = [
  //     'lomba' => 'KTI Internet of Things',
  //     'nama' => 'Admin KTI IoT',
  //     'tahap' => 'Final',
  //     'list_tim_full_paper' => $this->model_kti_iot->where([
  //       'iot_status_konfirmasi_final' => 0,
  //       'iot_pembayaran_final IS NOT NULL' => null
  //     ])->findAll(),
  //     'terkonfirmasi' => $this->model_kti_iot->where('iot_status_konfirmasi_final', 1)->countAllResults(),
  //     'belum_terkonfirmasi' => $this->model_kti_iot->where('iot_status_konfirmasi_final', 0)->countAllResults(),
  //     'total_peserta' => $this->model_kti_iot->where('iot_status_konfirmasi_final', 1)->countAllResults() + $this->model_kti_iot->where('iot_status_konfirmasi_final', 0)->countAllResults()
  //   ];
  //   return view("dashboard/admin/kti_iot/konfirmasi_final", $data);
  // }

  // public function verify_konfirmasi_final($id, $status)
  // {
  //   if (!$this->session->get('is_admin')) {
  //     return redirect()->to('/Auth/login');
  //   }
  //   if (!$this->session->get('username')) {
  //     return redirect()->to('/Auth/login');
  //   }
  //   // $id = $this->request->getVar('id');
  //   // $status = $this->request->getVar('status');
  //   $tim = $this->model_kti_iot->where('iot_id', $id)->first();
  //   // Jika di Terima
  //   if ($status) {
  //     $data = [
  //       'iot_id' => $tim['iot_id'],
  //       'iot_status_konfirmasi_final' => 1
  //     ];
  //     $this->model_kti_iot->save($data);

  //     $subject = "[Accepted] Internet of Things (IOT)";
  //     $message = "Dear {$tim['iot_nama_tim']} from {$tim['iot_institusi']} ,<br>
  //                 <br>
  //                 Thank you for participating for our event, \"Internet of Things (IOT).\"<br>
  //                 <br>
  //                 your payment to follow the final stage has been received. Lets prepare your group to be the champion! <br>
  //                 <br>
  //                 <br>
  //                 --<br>
  //                 Best regards,<br>
  //                 <br>
  //                 A Renewal Agents 2022";
  //     $this->sendemail($tim['iot_email_ketua'], $subject, $message);
  //     $this->session->setFlashdata('msg', 'berhasil menerima peserta');
  //   } else {
  //     //Jika ditolak, delete file bayar final
  //     $path = 'uploads/kti_iot/bukti_bayar/final/';
  //     $this->delete_file($path, $tim['iot_pembayaran_final']);
  //     $data = [
  //       'iot_id' => $tim['iot_id'],
  //       'iot_pembayaran_final' => null,
  //       'iot_status_konfirmasi_final' => null
  //     ];
  //     $this->model_kti_iot->save($data);

  //     $subject = "[Rejected] Internet of Things (IOT)";
  //     $message = "Dear {$tim['iot_nama_tim']} from {$tim['iot_institusi']} ,<br>
  //                 <br>
  //                 Thank you for participating for our event, \"Internet of Things (IOT).\"<br>
  //                 <br>
  //                 unfortunately your payment requirement is invalid, so please input again in your dahsboard <br>
  //                 <br>
  //                 <br>
  //                 --<br>
  //                 Best regards,<br>
  //                 <br>
  //                 A Renewal Agents 2022";
  //     $this->sendemail($tim['iot_email_ketua'], $subject, $message);
  //     $this->session->setFlashdata('msg', 'berhasil menolak peserta');
  //   }
  //   return redirect()->to('dashboard/Admin_kti_iot/konfirmasi_final');
  // }
}
