<nav class="navbar navbar-expand-md navbar-light bg-light">
  <a class="navbar-brand" href="<?php echo gotoURL('home'); ?>"><img class="small-logo" alt="logo"src="<?php echo $config['path_logo'] ?>"/>BISD</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarItemList" aria-controls="navbarItemList" aria-expanded="false" aria-label="Toggle navigation" style="">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarItemList">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="<?php echo gotoURL('home'); ?>"><i class="fa fa-home" ></i> Home <span class="sr-only">(current)</span></a>
      </li>
     <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle " data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
           <i class="fa fa-lightbulb"></i> Courses
          </a>
          <div class="dropdown-menu dropdown-menu-left">
            <a class="dropdown-item" href="<?=base_url('courses')?>"> All Courses</a>
            <?php
              foreach ($navbar_courseCategs as $key => $value) {
                format_course_dropdown($value['categ_name']);
              }
            ?>
    
            <!-- <div class="dropdown-divider"></div> -->

           </div>
        </li>
      <li class="nav-item">
        <a class="nav-link" href="<?=base_url('events')?>"><i class="fa fa-calendar"></i> Events</a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" href="#">Training Centers</a>
      </li> -->
    </ul>
    <ul class="navbar-nav ml-auto vcenter-tbl-parent">
      <li class="nav-item">
        <hr>
      </li>
    <li class="nav-item vcenter-tbl">
        <?php  // uncomment on Deployment it removes log in on anchor tag on landing page
        if (isset($_SESSION['user'])) {?> 
        <a class="nav-link " href="<?php echo gotoURL('Accounts'); ?>"><i class="fa fa-key"></i> LogIn</a>
        <?php  }?>
      </li>
      <li class="nav-item">
        <div class="prrm-img img_container">
        <a href="http://www.prrm.org">
          <img   class="" src="<?=$config['path_prrm_logo']?>">
        </a>
      </div>
    </li>
    </ul>
  </div>
</nav>
<div data-tagDesc="navbar style is position:fixed so  I added this correct UI" style="height:  4rem;"></div>

<?php 
  function format_course_dropdown($courseCateg){
    $id = str_replace(' ','',$courseCateg);
    echo ' <a class="dropdown-item" href="'.base_url('courses/#'.$id).'"> '.$courseCateg.'</a>';
  }


?>
