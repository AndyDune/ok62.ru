<?php
class Dune_Exception_Mysqli extends Exception
{
    protected $error = '';
    protected $db = NULL;
    
    public function getError()
    {
        $this->db = Dune_MysqliSystem::getInstance();
        return mysqli_error($this->db);
    }
    public function getErrno()
    {
        $this->db = Dune_MysqliSystem::getInstance();
        return $this->db->errno;
    }
    
}