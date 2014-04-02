<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	function index()
	{
		$this->load->view('login_view');
	}
	function checklogin()
	{
		$this->load->model('test_model');
		$re = $this->test_model->user_select($_POST['username'],'*');
		var_dump($re);
		if($re)
		{
			if($_POST['pwd']==$re[0]->password)
			{
				echo '密码正确';
				$this->load->library('session');
				$arr = array('uid'=>$re[0]->uid);
				$this->session->set_userdata($arr);
				echo '<br />';
				echo $this->session->userdata('uid');
			}
			else
			{
				echo '密码错误';
			}
		}
		else
		{
			echo '用户不存在';
		}
	}
	function checksession()
	{
		$this->load->library('session');
		if($this->session->userdata('uid'))
		{
			echo '一集登录';
		}
		else 
		{
			echo '没有登录';
		}
	}
	function loginout()
	{
		$this->load->library('session');
		$this->session->unset_userdata('uid');
	}
}