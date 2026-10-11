<?php
// Fungsi untuk membalik urutan karakter pada sebuah string.
// Karakter multibyte (UTF-8) tetap utuh, tidak dipecah per byte.
function reverse_string($string) {
  if (!is_string($string) || $string === '') {
    return $string;
  }

  $characters = preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY);
  if ($characters === false) {
    $characters = str_split($string);
  }

  $reversed = '';
  for ($i = count($characters) - 1; $i >= 0; $i--) {
    $reversed .= $characters[$i];
  }

  return $reversed;
}
?>
