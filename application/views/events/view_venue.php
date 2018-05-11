<div class="page-body">
    <div class="mngmnt-heading">Venue List</div>
    <div class="container align-center">
        <div class="container">
            <div class="pt-2 pb-2 align-right">
                <a class="btn btn-outline-primary" href="<?=base_url('events/create_venue')?>">Create Venues</a>
            </div>
            <div class="row">
                <?php
                    if (isset($venueList) && count($venueList) > 0) {
                        foreach ($venueList as $key => $value) {
                            venue_card($value);
                        }
                    } else {
                        echo '<div style="
                        margin: auto;">

                            NO VENUE YET
                            </div>';
                    }
                ?>
            </div>
        </div>
    </div>
    </div>
    <?php

        function venue_card($data)
        {
        ?>
        <div class="card-deck border-primary mb-3 mx-auto col-md-6">
            <div class="card p-3 text-center">
                <div class="card-header">Venue ID:
                    <?=$data['venue_id']?>
                </div>
                <div class="card-block">
                    <h4 class="card-title"><?=$data['venue_name']?></h4>
                    <div class="card-text">
                        <?=newLine_to_pTag($data['venue_description']);?>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a class="btn btn-outline-primary" href="<?=base_url('events/update_venue/' . $data['venue_id'])?>">Update</a>
                </div>
            </div>
        </div>
        <?php }?>
