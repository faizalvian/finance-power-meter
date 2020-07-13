<?php    
class M_device extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }

    function getAllDevices()
    {
        $query = $this->db->query('SELECT dev, dev_loc FROM devices ORDER BY dev ASC');
        return $query->result();
    }
}