<?php

class Enrollee_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getEnrollees($cols = '*', $where = '1=1', $limit = '', $order = '')
    {
        $rs = $this->db->SELECT($cols)->FROM('enrollees')
            ->WHERE($where)
            ->LIMIT($limit)
            ->ORDER_BY($order)
            ->get()->result_array();

        if (!empty($rs))
        {
            return $rs;
        }
        return false;
    }

    public function createEnrollee($newEnrollee = array())
    {
        if ($newEnrollee)
        {
            if ($this->db->insert('tbl_enrollee', $newEnrollee, true))
            {
                return $this->db->insert_id();
            }
        }
        else
        {
            return false;
        }
    }

    public function updateEnrollee($id, $data = '')
    {
        return $this->db->update('tbl_enrollee', $data, array('enrollee_id' => $id));
    }

    public function createAppliedCourse($crs = array())
    {
        if (!empty($crs))
        {
            if ($this->db->insert('tbl_enrollee_courses', $crs, true))
            {
                return $this->db->insert_id();
            }
        }
        else
        {
            return false;
        }
    }

    public function sumOfEnrollees($from='NOW()',$to='NOW()',$cols='')
    {
        if(!$cols){
            $cols = 'course_id, course_name, course_abbr';
        }

        $qry = "SELECT * FROM 
        (
        SELECT $cols,
        (
        SELECT COUNT(ic.course_id)
        FROM inquired_courses ic
        where ic.course_id = crs.course_id 
        AND date_applied BETWEEN '$from' AND '$to'
        ) as \"no_of_enrollees\"

        FROM
        courses crs
        ) sum_of_enrollees
        where no_of_enrollees > 0";

        $result = $this->db->query($qry)->result_array();

        return $result;
    }

}
