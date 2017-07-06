<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class H5Main extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        ll('H5Model');
    }

    /**
     * 返回 h5 index.php 页面活动首页
     */
    public function index()
    {
        $this->load->view('m/index.php');
    }


    /**
     * 查找所有的鸡汤信息
     */
    public function find()
    {
        $data = $this->H5Model->getStudent();
        p($data);
    }


    /**
     * 保存用户添加的鸡汤
     */
    public function add()
    {

        $content = trim($this->input->get_post('content'));
        $pic = trim($this->input->get_post('pic'));
        $title = trim($this->input->get_post('title'));

        $nowTime = TIMESTAMP;
        $data = array(
            'content' => $content,
            'pic' => $pic,
            'title' => $title,
            'created_at' => $nowTime,
            'updated_at' => $nowTime,
        );

        if (empty($content)) {
            exitJson(false, array('msg' => '必须选内容不能为空'));
        }

        if (empty($pic)) {
            exitJson(false, array('msg' => '图片不能为空'));
        }

        $result = $this->H5Model->addEvery($data);

        if ($result) {
            exitJson(true, array('msg' => '添加成功'));
        }

        exitJson(false, array('msg' => '添加失败'));
    }
}