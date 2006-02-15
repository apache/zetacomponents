<?php
return array (
  'settings' => 
  array (
    'site' => 
    array (
      'title' => 'Example site',
    ),
    'db' => 
    array (
      'host' => 'localhost',
      'user' => 'root',
      'password' => 42,
      'connection_retries' => 'five',
    ),
  ),
  'comments' => 
  array (
    'site' => 
    array (
      '#' => ' Settings for the site itself',
    ),
    'db' => 
    array (
      '#' => ' Database settings used for all connections',
      'password' => ' Storing passwords in INI files is not a good idea,
 is it?',
    ),
  ),
);
?>
