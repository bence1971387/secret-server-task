<?php

namespace App\Models;

use CodeIgniter\Model;

class Secret extends Model
{
  protected $DBGroup              = 'default';
  protected $table                = 'secret';
  protected $primaryKey           = 'hash';
  protected $useAutoIncrement     = false;
  protected $insertID             = 0;
  protected $returnType           = 'array';
  protected $useSoftDeletes       = false;
  protected $protectFields        = true;
  protected $allowedFields        = ['hash', 'secretText', 'createdAt', 'expiresAt', 'remainingViews'];

  // Dates
  protected $useTimestamps        = false;
  protected $dateFormat           = 'datetime';
  protected $createdField         = '';
  protected $updatedField         = '';
  protected $deletedField         = '';

  // Validation
  protected $validationRules      = [];
  protected $validationMessages   = [];
  protected $skipValidation       = false;
  protected $cleanValidationRules = true;

  // Callbacks
  protected $allowCallbacks       = true;
  protected $beforeInsert         = [];
  protected $afterInsert          = [];
  protected $beforeUpdate         = [];
  protected $afterUpdate          = [];
  protected $beforeFind           = [];
  protected $afterFind            = [];
  protected $beforeDelete         = [];
  protected $afterDelete          = [];

  public function addSecret($data)
  {
    $salt = bin2hex(random_bytes(6));
    $today = date("m.d.y.h.i.s");
    $hash = hash('sha1', $today . $salt);

    $data['hash'] = $hash;



    $this->insert($data);
    return $data;
  }
  public function getSecret($hash)
  {

    $data = $this->find($hash);

    if ($data != null && $data['remainingViews'] > 0) {



      $remainingViews = $data['remainingViews'] -= 1;


      $this->db->query("UPDATE secret SET remainingViews=$remainingViews WHERE hash='$hash'");
      if ($data['createdAt'] != $data['expiresAt']) {
        if (now() > strtotime($data['expiresAt'])) {
          return null;
        } else {
          return $data;
        }
      } else {
        return $data;
      }
    }
  }
  //check reminingViews number for the record and return bool, also reduce remainingViews by 1.
  public function isSecretViewable($data)
  {
    if ($data != null && $data['remainingViews'] > 0) {
      return true;
    } else {
      return false;
    }
  }
  //check time if record is expired and return as a bool.
  public function isSecretAvailable($data)
  {
    if ($data != null && $data['createdAt'] != $data['expiresAt']) {
      if (now() > strtotime($data['expiresAt'])) {
        return false;
      } else {
        return true;
      }
    } else {
      return true;
    }
  }
}
