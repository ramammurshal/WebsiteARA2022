<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\Model_ctf;
use App\Models\Model_custom;
use App\Models\Model_Account;

class User_ctf extends BaseController
{
  public function __construct()
  {
    $this->session = session();
    $this->model_ctf = new Model_ctf();
    $this->model_custom = new Model_custom();
    $this->model_account = new Model_Account();
    
  }
  public function home()
  {
    $data["lomba"] = "Capture The Flag";
    $data['data'] = $this->model_custom->get_where('ctf', $this->session->get('keterangan'), '_nama_tim');
    //var_dump($data['data'][0]->ctf_nama_tim);
    $data["nama"] = $data['data'][0]->ctf_nama_tim;
    $data["juara"] = $data['data'][0]->ctf_juara; //all pw test juara: juara123
    return view('dashboard/user/ctf/home', $data);
  }

  public function team()
  {
    $data["lomba"] = "Capture The Flag";
    $data['data'] = $this->model_custom->get_where('ctf', $this->session->get('keterangan'), '_nama_tim');
    $data["nama"] = $data['data'][0]->ctf_nama_tim;
    return view('dashboard/user/ctf/team', $data);
  }
}
