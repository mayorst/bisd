<?php

class Event_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll($cols = '*', $where = '1=1')
    {

        $rs = $this->db->SELECT($cols)->FROM('events')
            ->WHERE($where)
            ->get()->result_array();

        if ($rs) {
            return $rs;
        } else {
            return false;
        }

    }

    public function getAllVenue($cols = '*', $where = '1=1')
    {

        $rs = $this->db->SELECT($cols)->FROM('tbl_venue')
            ->WHERE($where)
            ->get()->result_array();
        //gets the image paths of the venue
        foreach ($rs as $key => $value) {

            $imgs = $this->db->SELECT('img_path')->FROM('tbl_venue_img')
                ->WHERE('venue_id', $value['venue_id'])
                ->get()->result_array();
            if (count($imgs) > 0) {
                $arr = array_kvp($imgs, 0, 'img_path');
                $rs[$key]['img_path'] = $arr;
            }
        }

        if ($rs) {
            return $rs;
        } else {
            return false;
        }
    }

    public function createVenue($newVenue)
    {
        if (count($newVenue) > 0) {
            if (isset($newVenue['img_path'])) {
                $img = $newVenue['img_path'];
                unset($newVenue['img_path']);
            }

            if ($this->db->insert('tbl_venue', $newVenue, true)) {
                $newId = $this->db->insert_id();
                if (isset($img)) {
                    $this->saveVenueImg($newId, $img);
                }

                return $newId;
            }
        } else {
            return false;
        }
    }

    public function saveVenueImg($id, $imgs)
    {
        // saves the filename of the uploaded file
        if (isset($imgs)) {
            $this->db->delete('tbl_venue_img', array('venue_id' => $id));
            if (is_array($imgs)) {
                $venueImg = array();
                foreach ($imgs as $key => $value) {
                    $venueImg['venue_id'] = $id;
                    $venueImg['img_path'] = $value;
                }
                $this->db->insert_batch('tbl_venue_img', $venueImg, true);
            } else {
                $venueImg = array('venue_id' => $id, 'img_path' => $imgs);
                $this->db->insert('tbl_venue_img', $venueImg, true);
            }
        }
    }

    public function updateVenue($id, $venue)
    {
        $img = $venue['img_path'];
        unset($venue['img_path']);

        if ($this->db->update('tbl_venue', $venue, array('venue_id' => $id))) {
            if (isset($img)) {
                $this->saveVenueImg($id, $img);
            }
            return true;
        }
        return false;
    }

}
