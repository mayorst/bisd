<?php

class PublicMessage_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll($cols = '*', $where = '1=1', $limit = '', $offset = '')
    {
        if (!$where)
        {
            $where = '1=1';
        }

        $rs = $this->db->SELECT($cols)->FROM('tbl_public_message')
            ->WHERE($where)
            ->order_by('date_publish DESC')
            ->limit($limit, $offset)
            ->get()->result_array();

        if ($rs)
        {
            return $rs;
        }
        else
        {
            return false;
        }
    }

    public function create($data)
    {
        if ($data)
        {
            return $this->db->insert('tbl_public_message', $data, true);
        }
        else
        {
            return false;
        }
    }

    public function update($id, $data)
    {
        return $this->db->update('tbl_public_message', $data, array('pmess_id' => $id));
    }

}
