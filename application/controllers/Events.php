<?php defined('BASEPATH') or exit('No direct script access allowed');

use \public_variables as pv;

class Events extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            if (!in_array($this->router->fetch_method(), $allowed)) {
                redirect('Home');
            }
        }

        $this->load->library('form_validation');
        $this->load->library('table');
        $this->load->model('Event_model');
    }

    public function index()
    {
        $this->view();
    }
    public function view()
    {
        $this->table->set_template(pv::UI_TABLE_TEMPLATE);
        $this->table->set_heading(array('Event ID', 'Name', 'Address', 'Time', 'End Time', 'Status', 'Action'));
        $query = $this->Event_model->getAll('event_id, name, address, time_start, time_end, stat');

        //for adding an update button
        if ($query) {
            $ctr = 0;
            foreach ($query as $rowArray) {
                if (is_array($rowArray)) {
                    //format the date time
                    $rowArray['time_start'] = date('Y-M-d h:i a',
                        human_to_unix($rowArray['time_start']));
                    $rowArray['time_end'] = date('Y-M-d h:i a',
                        human_to_unix($rowArray['time_end']));

                    // adds the update button
                    $btn = anchor("events/update/" . $rowArray['event_id'], "Update", "class='btn btn-primary'");
                    $addedColumn = array('btnUpdate' => $btn);
                    $rowArray = array_merge($rowArray, $addedColumn);
                    $query[$ctr] = $rowArray;
                    $ctr++;
                }
            }
        }

        $data['tblEvents'] = $this->table->generate($query);
        template::events('view_events', $data);
    }

// called in form validation to validate end Date
    public function dateIsBefore($ownDate, $start_date)
    {
        $result = isBefore($start_date, $ownDate);

        if ($result != 1) {
            $this->form_validation->set_message('dateIsBefore',
                'End Date must be after the Start Date.');
            return false;
        } else {
            return true;
        }
    }

// called in form validation to validate end time
    public function timeIsBefore($ownTime, $start_time)
    {
        $result = isBefore($ownTime, $start_time);

        if ($result != 1) {
            $this->form_validation->set_message('timeIsBefore',
                'End Time must be after the Start Time.');
            return false;
        } else {
            return true;
        }
    }

    public function create()
    {
        if ($_POST) {
            unset($_POST['submit']);

            $this->form_validation->load_config_rule('event');

            if (testVar($_POST['addressChoice'])) {
                if ($_POST['addressChoice'] == 'venue') {
                    $this->form_validation->unset_rule('address', 'event');
                }
            }

            if ($this->form_validation->run('event')) {
                $_POST['time_start'] = $_POST['start_date'] . ' ' . $_POST['start_time'];
                $_POST['time_end'] = $_POST['end_date'] . ' ' . $_POST['end_time'];

                if (isBefore($_POST['time_start'], $_POST['time_end']) != 1) {
                    prompt::error("Event Start Date must be before End Date.");
                    $data['formValues'] = $_POST;
                } else if ($_POST['addressChoice'] == 'venue' && empty($_POST['venue'])) {
                    prompt::error("You must specify the event venue.");
                    $data['formValues'] = $_POST;
                } else {

                    $imgUp = imageUploader();
                    if ($imgUp->do_upload('ev_img_path')) {
                        $_POST['ev_img_path'] = $imgUp->db_img_path();
                    }

                    $whListKey = array(
                        'event_id', 'name', 'time_start', 'time_end', 'address', 'venue', 'description', 'ev_img_path', 'stat',
                    );

                    $newEvent = whList($_POST, $whListKey);
                    $newEvent = str_start_case($newEvent, array('ev_img_path', 'event_id'));

                    if ($this->Event_model->create($newEvent)) {
                        $img_error = $imgUp->display_errors(' ', ' ');
                        if ($img_error) {
                            prompt::error($img_error);
                        }

                        prompt::success("The Event was successfully set.");
                        redirect('events/view');
                    }
                }
            }
        }

        $venues = $this->Event_model->getAllVenue('venue_id, venue_name');
        $venues = array_kvp($venues, 'venue_id', 'venue_name');
        $data['formValues']['venueSelect'] = $venues;

        template::events('create_events', $data);
    }

    public function update($id = '')
    {
        if (!$id) {
            redirect('events/view');
        }

        if ($_POST) {
            unset($_POST['submit']);

            $this->form_validation->load_config_rule('event');

            if (testVar($_POST['addressChoice'])) {
                if ($_POST['addressChoice'] == 'venue') {
                    $this->form_validation->unset_rule('address', 'event');
                }
            }

            if ($this->form_validation->run('event')) {
                $_POST['time_start'] = $_POST['start_date'] . ' ' . $_POST['start_time'];
                $_POST['time_end'] = $_POST['end_date'] . ' ' . $_POST['end_time'];

                if (isBefore($_POST['time_start'], $_POST['time_end']) != 1) {
                    prompt::error("Event Start Date must not be before End Date.");
                    $data['formValues'] = $_POST;
                } else if ($_POST['addressChoice'] == 'venue' && empty($_POST['venue'])) {
                    prompt::error("You must specify the event venue.");
                    $data['formValues'] = $_POST;
                } else {

                    $imgUp = imageUploader();
                    if ($imgUp->do_upload('ev_img_path')) {
                        $_POST['ev_img_path'] = $imgUp->db_img_path();
                    }

                    $whListKey = array(
                        'event_id', 'name', 'time_start', 'time_end', 'address', 'venue', 'description', 'ev_img_path', 'stat',
                    );

                    $newEvent = whList($_POST, $whListKey);
                    $newEvent = str_start_case($newEvent, array('ev_img_path', 'event_id'));

                    if ($this->Event_model->update($id, $newEvent)) {
                        $img_error = $imgUp->display_errors(' ', ' ');
                        if ($img_error) {
                            prompt::error($img_error);
                        }

                        prompt::success("The Event was successfully set.");
                        redirect('events/view');
                    }
                }
            }
        }

        $event = $this->Event_model->getAll('', "event_id = '$id'")[0];

        $start_dt = human_to_unix($event['time_start']);
        $end_dt = human_to_unix($event['time_end']);

        $event['start_date'] = date('Y-m-d', $start_dt);
        $event['start_time'] = date('H:i', $start_dt);
        $event['end_date'] = date('Y-m-d', $end_dt);
        $event['end_time'] = date('H:i', $end_dt);
        $data['formValues'] = $event;

        if (!file_exists(RESRC_PATH . $event['ev_img_path'])) {
            $data['formValues']['ev_img_path'] = '';
        }

        if (!$event['venue']) {
            $data['formValues']['addressChoice'] = 'custom';
        }

        $venues = $this->Event_model->getAllVenue('venue_id, venue_name');
        $venues = array_kvp($venues, 'venue_id', 'venue_name');
        $data['formValues']['venueSelect'] = $venues;

        template::events('update_events', $data);
    }

    public function view_venue()
    {

        $venues = $this->Event_model->getAllVenue();

        $data['venueList'] = is_array($venues) ? $venues : array();
        template::events('view_venue', $data);
    }
    public function create_venue()
    {

        if ($_POST) {

            unset($_POST['submit'], $_POST['img_path']);
            $newVenue = $_POST;

            if ($this->form_validation->run('venue')) {

                $imgUp = imageUploader();
                if ($imgUp->do_upload('img_path')) {
                    $newVenue['img_path'] = $imgUp->db_img_path();
                }

                if ($this->Event_model->createVenue($newVenue)) {
                    prompt::success($imgUp->display_errors() . 'The Venue was successfully added. ');
                    redirect('events/view_venue');
                }

            }

        }
        template::events('create_venue');
    }
    public function update_venue($id = '')
    {
        if (empty($id)) {
            $this->view_venue();
        }

        if ($_POST) {
            unset($_POST['submit']);

            if ($this->form_validation->run('venue')) {

                $imgUp = imageUploader();
                if ($imgUp->do_upload('img_path')) {
                    $_POST['img_path'] = $imgUp->db_img_path();
                }

                if ($this->Event_model->updateVenue($id, $_POST)) {
                    prompt::success($imgUp->display_errors() . "Successfully Saved.");
                    redirect('events/view_venue');
                }
            }

        } else {

            if (!empty($id)) {
                if ($venue = $this->Event_model->getAllVenue('', 'venue_id = \'' . $id . '\'')) {

                    $venue[0]['title'] = 'Update Venue';
                    $venue[0]['submitStr'] = 'Update Venue';

                    $data['formUpdate'] = $venue[0];
                    template::events('update_venue', $data);
                } else {
                    prompt::error("Venue ID doesn't exist");
                    redirect('events/view_venue');
                }
            }
        }
    }

}
