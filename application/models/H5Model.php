<?php

class H5Model extends CI_Model
{
    //每日一签表
    private $tableName = 'every_day';

    /**
     * 获取所有鸡汤信息
     * @return mixed
     */
    public function getEveryDay()
    {
        $res = $this->db->get($this->tableName)->result();
        return $res;
    }

    /**
     * 添加鸡汤
     * @param $data
     * @return int
     */
    public function addEvery($data)
    {
        return !empty($data) && $this->db->insert($this->tableName, $data) ? $this->db->insert_id() : 0;
    }
}
