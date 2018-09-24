<?php

function findexts ($filename) { 
  $filename = strtolower($filename) ; 
  $exts = mb_split("[/\\.]", $filename) ; 
  $n = count($exts)-1; 
  $exts = $exts[$n]; 
  return $exts; 
}

function findfilename ($filename) { 
  $filename = strtolower($filename) ; 
  $exts = mb_split("[/\\.]", $filename) ; 
  $exts = $exts[0]; 
  return $exts; 
}

function handleErrorMessage($field, $error_fields = null) {
  if(isset($error_fields)) {
    echo isset($error_fields[$field]) ? "<label class='error'>$error_fields[$field]</label>" : null;
  }
}