<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use DateTime;
use DateTimeZone;

class Secret extends BaseController
{
  private $secretModel;
  public function __construct()
  {
    helper(['form', 'url', 'date', 'output_secret_as']);
    $this->secretModel = model('Secret', false);
  }
  public function addSecret()
  {

    //user input post rules
    $rules = [
      'secret' => 'required',
      'expireAfterViews' => 'required|greater_than[0]',
      'expireAfter' => 'required|greater_than_equal_to[0]',
    ];


    //if input is valid, it will be sent to the model, else set status code to 405 "Invalid input" error.
    if ($this->validate($rules)) {
      //user input hash will be generated in Secret model.
      $time = new Time('now');
      $now = $time->getTimeStamp();
      $minutes = $this->request->getPost('expireAfter');
      $data = [
        'secretText' => $this->request->getPost('secret'),
        'createdAt' => date(DATE_ATOM, $now),
        'expiresAt' => date(DATE_ATOM, $now + 60 * $minutes),
        'remainingViews' => $this->request->getPost('expireAfterViews'),
      ];
      $data = $this->secretModel->addSecret($data);

      $this->outputData($data);

      $this->response->setStatusCode(200, 'successful operation');
    } else {
      $this->response->setStatusCode(405, 'Invalid input');
    }
  }
  public function getSecret($hash)
  {
    $data = $this->secretModel->getSecret($hash);
    if ($data != null) {
      $this->outputData($data);
    } else {
      $this->response->setStatusCode(404, 'Secret Not found');
    }
  }
  public function outputData($data)
  {
    $header = $this->request->getHeaderLine('Accept');
    if (str_contains($header, 'application/xml')) {
      $this->response->setHeader('Content-type', 'application/xml');
      output_secret_as($data, "application/xml");
    } else if (str_contains($header, 'application/json')) {
      $this->response->setHeader('Content-type', 'application/json');
      output_secret_as($data, "application/json");
    }
  }
  public function index()
  {
    return view('/secret/form');
  }
}
