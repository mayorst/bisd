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
                    template::events('create_venue', $data);
                } else {
                    prompt::error("Venue ID doesn't exist");
                    redirect('events/view_venue');
                }
            }
        }
    }

}
