<?php

class Account_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function checkUser($user = array())
    {
        if (isset($user)) {
            $rs = $this->db->SELECT('*')->from('tbl_member')
                ->WHERE('username', $user['username'])
                ->get()->result_array();
            if (count($rs) > 0) {
                if (password_verify($user['password'], $rs[0]['_password'])) {
                    return $rs[0];
                }
            } else {
                return false;
            }
        }
    }

    public function getUser($userid = '')
    {
        if (isset($userid)) {
            return $this->getMember('', "member_id = '" . $userid . "' ");
        }

    }

    public function getMember($cols = "*", $where = "1=1")
    {

        $rs = $this->db->SELECT($cols)->from('tbl_member')
            ->WHERE($where)
            ->ORDER_BY('_status ASC, CONCAT(last_name,first_name,middle_name) ASC')
            ->get()->result_array();
        if (count($rs) > 0) {
            return $rs[0];
        } else {
            return false;
        }

        // echo $this->db->last_query();
    }

    public function getTempUser($cols = '*', $where = '1=1')
    {

        $rs = $this->db->SELECT($cols)->from('tbl_temp_member')
            ->WHERE($where)
            ->get()->result_array();
        if (count($rs) > 0) {
            return $rs[0];
        } else {
            return false;
        }

    }

    public function deleteTempMember($id)
    {
        return $this->db->delete('tbl_temp_member', array('temp_member_id' => $id));
    }

    public function isUsernameUnique($username, $usernameHolder = '')
    {
        $rs = $this->db->SELECT('username')
            ->from('tbl_member')
            ->WHERE('username = ', "'$username'", false)
            ->WHERE('member_id !=', "'$usernameHolder'", false)
            ->get()->result_array();

        $temprs = $this->db->SELECT('username')
            ->from('tbl_temp_member')
            ->WHERE('username = ', "'$username'", false)
            ->get()->result_array();

        if (count($rs) == 0 && count($temprs) == 0) {
            return true;
        } else {
            return false;
        }

    }

    public function isEmailUnique($email = '', $id = '')
    {
        $rs = $this->db->SELECT('email')
            ->from('tbl_member')
            ->WHERE('email = ', "'$email'", false)
            ->WHERE('member_id != ', "'$id'", false)
            ->get()->result_array();

        $temprs = $this->db->SELECT('email')
            ->from('tbl_temp_member')
            ->WHERE('email = ', "'$email'", false)
            ->get()->result_array();
        if (count($rs) == 0 && count($temprs) == 0) {
            return true;
        } else {
            return false;
        }
    }

/**
 * adds a new member to the database
 * @param array   $user a key/value pair. The column name and value
 */
    public function addMember($newUser = array())
    {
        if ($newUser) {
            return $this->db->insert('tbl_member', $newUser, true);
        } else {
            return false;
        }
    }

/**
 * adds a temporary member to the database
 * @param array   $user a key/value pair. The column name and value
 */
    public function addTempMember($newUser = array())
    {
        if (isset($newUser)) {
            if ($this->db->insert('tbl_temp_member', $newUser, true)) {
                return $this->db->insert_id();
            }
        } else {
            return false;
        }
    }

/**
 * get the number of the member ID with format 2018-1001.
 * @param  string $id [UserID]
 * @return int     [the digit without the year]
 */
    public function getUserNo($id = '')
    {
        if (($pos = strpos($id, '-')) !== false) {
            return substr($id, $pos + 1);
        }
        return false;
    }

    public function lastUserNo()
    {
        $lastID = $this->lastUserID();
        if ($lastID) {
            return $this->getUserNo($lastID);
        }
        return null;
    }

    public function lastUserID()
    {
        $arr = $this->db->SELECT('member_id AS "lastID"')
            ->from('tbl_member')
            ->ORDER_BY('LENGTH(member_id) DESC, member_id DESC')
            ->LIMIT(1)
            ->get()->result_array();
        if ($arr) {
            return $arr[0]['lastID'];
        } else {
            return date("Y") . '-1000';
        }
    }

/**
 * returns the next ID for the member
 * @return string
 */
    public function getNextUserID()
    {
        $lastID = $this->lastUserID();
        $year = substr($lastID, 0, (strpos($lastID, '-') ?: +1));
        if ($year >= date("Y")) {
            return $year . '-' . ($this->getUserNo($lastID) + 1);
        } else {
            return ($year + 1) . '-1001';
        }
    }

    public function updateMember($id, $data = '')
    {
        return $this->db->update('tbl_member', $data, array('member_id' => $id));
    }

    public function getAll()
    {
        $rs = $this->db->SELECT('
            member_id
            ,CONCAT(last_name,\', \',first_name,\' \',middle_name) as "Name"
            ,username
            ,birthdate
            ,contact_number
            ,email
            ,_position
            ,_status ')
            ->from('tbl_member')->get()->result_array();

        return $rs;

    }

}
