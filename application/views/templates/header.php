<?php
    defined('BASEPATH') or exit('No direct script access allowed');
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <title><?=testVar($page_title,'BISD')?></title>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?=$config['path_logo']?>">



    <link rel="stylesheet" type="text/css" href="<?php echo $config['path_fontAwesome']; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['path_bootstrap_theme']; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['path_custom_theme']; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['path_global_css']; ?>">
    <!-- Scripts -->
    <script type="text/javascript" src="<?php echo $config['path_jquery']; ?>"></script>
    <script type="text/javascript" src="<?php echo $config['path_bootstrap_js']; ?>"></script>
    <script type="text/javascript" src="<?php echo $config['path_global_js']; ?>"></script>
    <!-- Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  </head>

  <body>
