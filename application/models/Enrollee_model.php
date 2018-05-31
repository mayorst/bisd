<?php

class Enrollee_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getEnrollees($cols = '*',$where = '1=1')
    {
        $rs = $this->db->SELECT($cols)->FROM('tbl_enrollee')
            ->WHERE($where)->get()->result_array();

        if (!empty($rs)) {
            return $rs;
        }
        return false;
    }


    public function createEnrollee($newEnrollee = array())
    {
        if ($newEnrollee) {
            if ($this->db->insert('tbl_enrollee', $newEnrollee, true)) {
                return $this->db->insert_id();
            }
        } else {
            return false;
        }
    }

    public function updateEnrollee($id, $data = '')
    {
        return $this->db->update('tbl_enrollee', $data, array('enrollee_id' => $id));
    }


    public function createAppliedCourse($crs = array())
    {
        if (!empty($crs)) {
            if ($this->db->insert('tbl_enrollee_courses', $crs, true)) {
                return $this->db->insert_id();
            }
        } else {
            return false;
        }
    }


}
