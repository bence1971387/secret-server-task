<?php
if (!function_exists('output_secret_as')) {
  function output_secret_as($data, $format)
  {
    if ($data != null && $format != null) {
      switch ($format) {
        case 'application/json':

          echo json_encode($data);
          break;

        case 'application/xml':
          $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Secret/>');
          foreach ($data as $key => $value) {
            $xml->addChild($key, $value);
          }
          echo $xml->asXML();
      }
    }
  }
}
