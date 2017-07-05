<?php

class Tool extends CI_Controller
{
    /**
     * 上传文章图片
     *
     * @return void
     */
    public function imageUpload(){

        $upload_path = '';
        $config['upload_path']= $upload_path . 'tmp';
        $config['allowed_types']='*';

        $imageSuffix = 'jpg';
        $config['file_name']=date('Ym/d/His', TIMESTAMP).mt_rand(0,9).mt_rand(0,9).mt_rand(0,9).mt_rand(0,9).mt_rand(0,9).mt_rand(0,9).'.'.$imageSuffix;

        $this->load->library('upload',$config);
        if(!$this->upload->do_upload('userfile')){
            $error=array('error'=>$this->upload->display_errors());
            exitJson(false, array('msg' => '上传失败'));
        }else{
            $result=array('upload_data'=>$this->upload->data());
            exitJson(true, array('msg' => '上传成功','pic' => $result['upload_data']['full_path']));
        }
    }
}