<?php

namespace App\Security;

class SecurityHelper
{
  public static function generatePassword() {
    $newPassord = '';
    $arrayChars = array(
      array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0'),
      array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'),
      array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'),
      array('a', 'e', 'i', 'o', 'u'),
      array('B', 'C', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'V', 'W', 'X', 'Y', 'Z')
    );

    for ($i=0; $i < 8; $i++) {
      $charSet = array();
      if ($i < 2) {
        $charSet = $arrayChars[0];
      }
      elseif ($i < 4) {
        $charSet = $arrayChars[1];
      }
      elseif ($i < 6) {
        $charSet = $arrayChars[2];
      }
      elseif ($i < 7) {
        $charSet = $arrayChars[3];
      }
      else {
        $charSet = $arrayChars[4];
      }

      $newPassord .= $charSet[rand(0, (count($charSet) - 1))];
    }

    return $newPassord;
  }

  public static function EncryptPassword($pass) {
    $encodedPass = base64_encode($pass);

    $opciones = [
        'cost' => 12
    ];

    return password_hash($encodedPass, PASSWORD_BCRYPT, $opciones);
  }
}
