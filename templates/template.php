<?php

function print_if_set($field, $name, $leading_space = 0){
  if(isset($field[$name])){
    print str_repeat(' ', $leading_space) . "'$name' => '$field[$name]', \r\n";
  }
}
