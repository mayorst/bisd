

  
    <div class="hero-image">
        <img src="<?=PATH_IMAGES . 'img1.jpg'?>">
  <div class="hero-text">
    
    <h1 class="display-3">Welcome to BISD!</h1>
    <p class="lead"><font color="white">Benitez Institute for Sustainable Development</font></p>
    <hr class="my-4">
    <p>Learn Education for Sustainability. Start your course now!</p>
    <p class="lead">
      <a class="btn btn-primary btn-lg" href="<?=base_url('courses')?>" role="button"><i class="fa fa-lightbulb"></i> View Courses</a>
    </p>
    <br>
  </div>
  <br><br><br>
 
  <div class="container">
    <!--info of BISD-->
    <article>
      <div class="row">
        <div class="col-sm-8">
          <section>
            <h3> What is BISD? </h3>
            <ul class="whats-bisd list-unstyled">
              <li>
                <br>
                <p>A <strong>SYSTEM</strong> of learning developing promoting sustainable development theories, sustainble development theories, technologies and practices.
                </p>
              </li>
              <li>
                <p><strong>BUILDS ON</strong> the wealth of learnings experiences “community gardens” of PRRM.
                </p>
              </li>
              <li>
                <p><strong>DISTINCT</strong> in its integration of:
                  <ul>
                    <li> a critical school challenging the mainstream</li>
                    <li> action-based learning linked to local rural movements </li>
                    <li> advocacy for the legitimacy of alternative/ </li>non-traditional education
                  </ul>
                </p>
              </li>
              <li>
                <p><strong>FOUNDED</strong> on the principles of:
                  <ul>
                    <li> a co-determination of the learning agenda </li>
                    <li> context-content-method framework </li>
                    <li> integration of theory and practice of sustainable development </li>
                  </ul>
                </p>
              </li> 
            </ul>
          </section>
        </div>
        <div class="col-sm-4">
          <section class="upcoming-events">
            <h3>Upcoming Events</h3>
            <div class="list">
              <?php
                  create_upcomingEvents($upcomingEvents);
              ?>
            </div>
          </section>
        </div>
      </div>
      <section>
        <blockquote>
          <div class="row">
            <div class="col-md-6">
              <div class="vcenter">
                <p class="quote"><i class="fa fa-quote-left"></i> PRRM is right on target to focus on education for sustainability…. We have yet to learn our way out of our unsustainable condition.... <i class="fa fa-quote-right"></i>
                </p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="vcenter">
                <img class="round-img responsive-img h-benitez-img" alt="Helena-Benitez" src="<?=PATH_IMAGES . 'Helena-Benitez.jpg'?>" />
                <p>PRRM Chair Emeritus Helena Benitez (1914-2016)</p>
              </div>
            </div>
          </div>
        </blockquote>
      </section>
      <section>
        <p>The Benitez Institute for Sustainable Development (BISD), since its establishment in 2002, has served as the main training, research and technical assistance arm of the Movement. It has a set of faculty drawn from among PRRM’s Board of Trustees, chapter members, staff and partner people’s organizations (POs), as well as from other training institutes, NGOs and POs.</p>
        <p>In other words, it operates as a community of knowledge, rather than as a single, isolated institution. This is to ensure that it is able to draw from the widest possible source of “exemplary practices” in sustainable development for sharing through its training programs and publications.
        </p>
        <p>
          A vital aspect of the BISD curriculum is the optimization of community projects implemented by the local organizations and/or advocates-practitioners. These will serve as demonstration and training sites in which learning may more effectively take place in complementation with classroom discourses.
        </p>
      </section>
      <section>
        <div class="learningCenter-ph">
          <h3>Local Community Learning Center and Thrust</h3>
          <img class="responsive-img" src="<?=PATH_IMAGES . 'local_community_learning_centers.jpg'?>" />
        </div>
      </section>
    </article>
  </div>
</div>


<?php
    /**
     * Element Creator
     * -----------------------------
     */
    function create_upcomingEvents($upcomingEvents)
    {
        if (testVar($upcomingEvents)) {
            foreach ($upcomingEvents as $key => $value) {

                $img = get_resc($value['ev_img_path']);

                $name = $value['name'];

                $unix_startTime = human_to_unix($value['time_start']);
                $date = date('M d, Y h:i a', $unix_startTime);
                $desc = $value['description'];

            ?>

<div class="card">
  <div class="img_container">
    <img src="<?=$img?>">
  </div>
  <h5><?=$name?></h5>
  <span><?=$date?></span>
  <p>
    <?=$desc?>
  </p>
</div>

<?php
    }
        } else {
            echo '<div class="text-center">NO UPCOMING EVENTS</div>';
        }
    }

?>