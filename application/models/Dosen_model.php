<?php
class Dosen_model extends CI_Model
{
    public function getDosen($id = null)
    {
        if ($id === null) {
            return $this->db->get('dosen')->result_array();
        } else {
            return $this->db->get_where('dosen', ['id' => $id])->result_array();
        }
    }

    public function deleteDosen($id)
    {
        $this->db->delete('dosen', ['id' => $id]);
        return $this->db->affected_rows();
    }
    public function createDosen($data)
    {
        
        $this->db->insert('dosen', $data);
        return $this->db->affected_rows();
    }
    public function updateDosen($data, $id)
    {
        $this->db->update('dosen', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}