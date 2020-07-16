<?php

namespace DevWeb\Model;

class File
{
  private static $acceptImgsTypes = [
    'image/jpg',
    'image/jpeg',
    'image/png',
    'image/gif'
  ];

  public static function validImg($img, $maxSize = 300){
    if(in_array($img['type'], self::$acceptImgsTypes)){
      $size = intval($img['size'] / 1024); // Converte de Bytes para Kb o tamanho da imagem e verifica seu tamanho arredondado
      return $size < $maxSize; 
    }

    return false;
}

  public static function uploadFile($file){
    $fileFormat = explode('/', $file['type']);
    $imgName = uniqid() . '.' . $fileFormat[count($fileFormat) - 1];

    if(move_uploaded_file($file['tmp_name'], BASE_DIR . '/public/images/uploads/' . $imgName))
      return $imgName;
      
    return false;
  }

  /**
   * @param string $file Uma string contendo o nome do arquivo
   * @return void
   */

  public static function deleteFile($file){
    unlink(BASE_DIR . '/public/images/uploads/' . $file);
  }
}

// EOF
