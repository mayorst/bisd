<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?php echo gotoURL('home'); ?>"><img class="small-logo" alt="logo"src="<?php echo $config['path_logo'] ?>"/>BISD</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarItemList" aria-controls="navbarItemList" aria-expanded="false" aria-label="Toggle navigation" style="">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarItemList">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="<?php echo gotoURL('home'); ?>"><i class="fa fa-home" ></i> Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?=base_url('courses')?>"><i class="fa fa-lightbulb"></i> Courses</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><i class="fa fa-calendar-alt"></i> Events</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Training Centers</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <hr>
      </li>
      <li class="nav-item ">

        <?php  // uncomment on Deployment it removes log in when anchor tag on landing page// if (isset($_SESSION['user'])) {?> 
        <a class="nav-link" href="<?php echo gotoURL('Accounts'); ?>"><i class="fa fa-key"></i> LogIn</a>
        <?php // }?>
      </li>
    </ul>
  </div>
</nav>
<div data-tagDesc="navbar style is position:fixed so  I added this correct UI" style="height:  4rem;"></div>