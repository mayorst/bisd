<?php

class PublicMessage_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
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

    public function update($id,$data)
    {
        return $this->db->update('tbl_public_message', $data, array('pmess_id' => $id));
    }

}
