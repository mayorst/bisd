<?php

class Course_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getCategories($columns = 'categ_name',$where='1=1')
    {
        $rs = $this->db->SELECT($columns)->FROM('tbl_course_category')
        ->WHERE($where)->get()->result_array();

        if (!empty($rs)) {
            return $rs;
        }

        return false;
    }

    public function getCourse($id = '')
    {
        if ($id) {
            $rs = $this->db->SELECT('*')->FROM('tbl_course')
                ->WHERE('course_id = ', $id)->get()->result_array();

            if (!empty($rs)) {
                return $rs[0];
            }
        }

        return false;
    }
    public function getCourses($cols = '*',$where = '1=1')
    {
        $rs = $this->db->SELECT($cols)->FROM('courses')
            ->WHERE($where)->get()->result_array();

        if (!empty($rs)) {
            return $rs;
        }
        return false;
    }

    /**
     * get the Prereq or the Course/s who require the prereq.
     * @param  string $col       column to select on the table
     * @param  string $course_id [description]
     * @param  string $whereCol  if 'req_by' returns array of prereq, if 'course_id' returns the courses who require this course
     * @return array            array or false if null;
     */
    public function getCourse_prereq($col = "*", $course_id = '', $whereCol = 'req_by')
    {
        $rs = $this->db->SELECT($col)->FROM('course_prereq')
            ->WHERE($whereCol . '=' . $course_id)
            ->get()->result_array();

        if (!empty($rs)) {
            return $rs;
        }

        return false;
    }

    public function createCourse($newCourse = array())
    {
        if ($newCourse) {
            if ($this->db->insert('tbl_course', $newCourse, true)) {
                return $this->db->insert_id();
            }
        } else {
            return false;
        }
    }

    public function createCategory($categ = array())
    {
        if (!empty($categ)) {
            if ($this->db->insert('tbl_course_category', $categ, true)) {
                return $this->db->insert_id();
            }
        } else {
            return false;
        }
    }

    public function updateCourse($id, $data = '')
    {
        return $this->db->update('tbl_course', $data, array('course_id' => $id));
    }

    public function createPrereq($course_id, $prereq)
    {

        $this->db->delete('tbl_course_prereq', array('course_id' => $course_id));
        if (!empty($prereq)) {

            $arr = array();
            $ctr = 0;
            foreach ($prereq as $req) {
                $newArray['course_id'] = $course_id;
                $newArray['prereq_id'] = $req;
                $arr[$ctr++] = $newArray;
            }
            return $this->db->insert_batch('tbl_course_prereq', $arr);
        } else {
            return false;
        }
    }



}
