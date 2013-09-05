<?php

function print_if_set($field, $name){
  if(isset($field[$name])){
    print "      '$name' => '$field[$name]', \r\n";
  }
}
