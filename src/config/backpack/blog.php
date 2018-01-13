<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Public Blog URL Prefix
  |--------------------------------------------------------------------------
  |
  | The prefix used for all frontend website routes.
  | Set to NULL if you wish to make it your main page.
  |
  */

  'route_prefix' => 'blog',

  /*
  |--------------------------------------------------------------------------
  | Article List Size
  |--------------------------------------------------------------------------
  |
  | How many articles to display per page.
  |
  */

  'list_size' => 10,

  /*
  |--------------------------------------------------------------------------
  | Auto-approve comments
  |--------------------------------------------------------------------------
  |
  | Should comments that pass Akismet spam inspection automatically be
  | approved to be displayed.
  |
  */

  'autoapprove' => true,

  /*
  |--------------------------------------------------------------------------
  | Comments are test
  |--------------------------------------------------------------------------
  |
  | Declares that you are submitting test comments to the akismet system.
  |
  */

  'akismetTest' => true

];
