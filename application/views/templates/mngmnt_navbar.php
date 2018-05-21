<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?php echo base_url('home'); ?>"><img class="small-logo" alt="logo"src="<?php echo $config['path_logo'] ?>"/>BISD</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarItemList" aria-controls="navbarItemList" aria-expanded="false" aria-label="Toggle navigation" style="">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarItemList">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('management'); ?>"><i class="fa fa-home" ></i> Main <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('management/course'); ?>"><i class="fa fa-lightbulb" ></i> Courses </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('events/view'); ?>"><i class="fa fa-calendar" ></i> Events </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <hr>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <?=isset($_SESSION['user']['first_name']) ? $_SESSION['user']['first_name'] : 'User'?>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="<?=base_url('accounts/view')?>"><i class="fa fa-eye"></i> View Account</a>
            <a class="dropdown-item" href="<?=base_url('accounts/update/' . $_SESSION['user']['member_id'])?>"><i class="fa fa-edit"></i> Edit Account</a>
            <?php if ($_SESSION['user']['_position'] === public_variables::ACCOUNT_POSITION['admin'])
{
    ?>
            <a class="dropdown-item" href="<?=base_url('accounts/manage')?>"><i class="fa fa-cog"></i> Manage Accounts</a>
            <?php }?>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" onclick="modalYesNo('Logout','Are you sure you want to logout?','<?php echo base_url('Accounts/logout'); ?>','')">
            <i class="fa fa-key"></i> Logout</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <div data-tagDesc="navbar style is position:fixed so  I added this correct UI" style="height:  4rem;"></div>
