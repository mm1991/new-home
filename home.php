<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends  CI_Controller {
 	function __construct()
 	{
 		parent::__construct();		
 	}
 	
	function index()
	{
		$this->load->view('login_view');
	}
	
	function checklogin()
	{
		$this->load->model('test_model');
		$re = $this->test_model->user_select_in( $this->input->post('username'),'*');
		var_dump($re);
		if($re)
		{
			if( $this->input->post('pwd')==$re[0]->password)
			{
				$this->load->library('session');
				$arr = array('username'=>$re[0]->username);
				$this->session->set_userdata($arr);
				header('Location:/CI/index.php/home/shouye');
			}
			else
			{
				echo "<script>alert('密码错误，请重新输入！');history.back();</script>";
			}
		}
		else
		{
			echo "<script>alert('用户名不存在，请重新输入！');history.back();</script>";
		}
	}

	function loginout()
	{
		$this->load->library('session');
		$this->session->unset_userdata('username');
		echo "<script>alert('注销成功！');window.location.href='/CI/index.php/home/index';</script>";
	}
	
 	function shouye()
 	{
 		$this->load->model('test_model');
 		$this->load->library('session');
 		if($this->session->userdata('username'))
 		{
			$date['username'] = $this->session->userdata('username');
 		}
 		else
 		{
 			echo "<script>alert('您尚未登录！');window.location.href='/CI/index.php/home/index';</script>";
 		}
 		$get_title = $this->input->get('title');
 		if(isset($get_title))
		{ 
			$_title = $this->input->get('title');
			$re_count = $this->test_model->user_count_like($_title);
		}
		else
		{
			$re_count = $this->test_model->user_count('news');
		}
		/*$pagesize = 5; //
   		$count = ceil($re_count/$pagesize);//求出一共有多少页
   		$pages = $count; //显示最后一页
   		$init = 1;
   		$page_len = 7;
   		$max_p = $count; 
		if(empty($_GET["page"]) || $_GET["page"]<0){
       		$page = 1;
   		}else{
       		$page = $_GET["page"];
   		}
    	$off = ($page-1)*$pagesize; //求出数据库查询的第一个数据
    	$get_title = $this->input->get('title');
		if(isset($get_title))
		{ 
			$date['sql'] = $this->test_model->user_limit_like($pagesize,$off,$_title);					
		}
		else{
			$date['sql'] = $this->test_model->user_limit($pagesize,$off);
		}
 		$this->load->view('shouye_view',$date);
 		
 		if(!isset($key)) $key = '';
		if(!isset($_GET['title'])){
    		$page_len = ($page_len%2)?$page_len:$page_len+1;//如果余为1则为真，为0则为假
    		$pageoffset = ($page_len-1)/2;//页码偏移量 
    	if($page!=1){
        	$key.="<a href=\"".$_SERVER['PHP_SELF']."?page=1"."\">第一页&nbsp;</a>";
        	$key.="<a href=\"".$_SERVER['PHP_SELF']."?page=".($page-1)."\">上一页&nbsp;</a>";
    	}else{
        	$key.="";
        	$key.="";
    	}
    	if($pages>$page_len){
        	if($page<=$pageoffset){
            	$init = 1;
            	$max_p = $page_len;
        	}else{
            	if($page+$pageoffset>=$pages+1){
                	$init = $pages - $page_len+1;
            	}else{
                	$init = $page-$pageoffset;
                	$max_p = $page + $pageoffset;
            	}
        	}
    	}
    	for($i=$init;$i<=$max_p;$i++){
        	if($i==$page){
            	$key.="[&nbsp;".$i."&nbsp;]";
        	}else{
            	$key.="<a href=\"".$_SERVER['PHP_SELF']."?page=".$i."\">$i</a>";
        	}
    	}	
    	if($page!=($max_p)){
        	$key.="<a href=\"".$_SERVER['PHP_SELF']."?page=".($page+1)."\">&nbsp;下一页</a>";
        	$key.="<a href=\"".$_SERVER['PHP_SELF']."?page=".$pages."\">&nbsp;最后一页</a>"; 
    	}else{
			$key.="";
        	$key.=""; 
    	}
	}
	else {
		$page_len = ($page_len%2)?$page_len:$page_len+1;//如果余为1则为真，为0则为假
    	$pageoffset = ($page_len-1)/2;//页码偏移量 
    	if($page!=1){
        	$key.="<a href=\"".$_SERVER['PHP_SELF']."?title=$_title&page=1"."\">第一页&nbsp;</a>";
        	$key.="<a href=\"".$_SERVER['PHP_SELF']."?title=$_title&page=".($page-1)."\">上一页&nbsp;</a>";
    	}else{
        	$key.="";
        	$key.="";
    	}
    	if($pages>$page_len){
        	if($page<=$pageoffset){
            	$init = 1;
            	$max_p = $page_len;
        	}else{
            	if($page+$pageoffset>=$pages+1){
                	$init = $pages - $page_len+1;
            	}else{
                	$init = $page-$pageoffset;
                	$max_p = $page + $pageoffset;
            	}
        	}
    	}
    	for($i=$init;$i<=$max_p;$i++){
        	if($i==$page){
            	$key.="[&nbsp;".$i."&nbsp;]";
        	}else{
            	$key.="<a href=\"".$_SERVER['PHP_SELF']."?title=$_title&page=".$i."\">$i</a>";
        	}
    	}	
    	if($page>=($max_p)){
			$key.="";
        	$key.=""; 
    	}
		else {
        	$key.="<a href=\"".$_SERVER['PHP_SELF']."?title=$_title&page=".($page+1)."\">&nbsp;下一页</a>";
        	$key.="<a href=\"".$_SERVER['PHP_SELF']."?title=$_title&page=".$pages."\">&nbsp;最后一页</a>"; 
    	}
	}
	$date['key'] = $key;
	$date['count'] = $count;
	$this->load->view('page',$date);*/
 	}
 	function addnews_view()
 	{
 		$this->load->library('session');
 	 	if($this->session->userdata('username'))
 		{
			$date['username'] = $this->session->userdata('username');
 		}
 		else
 		{
 			echo "<script>alert('您尚未登录！');window.location.href='/CI/index.php/home/index';</script>";
 		}
 		$this->load->view('fabu',$date);
 	}
 	function addnews()
 	{
 		date_default_timezone_set('PRC');
		$title = $this->input->post('title');
		$news = $this->input->post('news');
		if(empty($title))
		{
			echo "<script>alert('新闻标题不得为空！');history.back();</script>";
			exit;
		}
		if(empty($news))
		{
			echo "<script>alert('新闻内容不得为空');history.back();</script>";
			exit;
		}
		$datetime = date("y-m-d G:i:s");
		$this->load->model('test_model');
		$arr=array('title'=>$title,'news'=>$news,'datetime'=>$datetime);
		$result_insert = $this->test_model->user_insert($arr);
		
	    if($result_insert==true) {
	      	echo "<script>alert('新闻发布成功！');window.location.href='/CI/index.php/home/shouye';</script>";
	     }
		else {
			mysql_error() . "<br>不能发布新的新闻";
		}
		mysql_close();	
	 }
	 function edit_view()
	 {
	 	$id=$_GET['id'];
	 	$this->load->model('test_model');
	 	$date['sel'] = $this->test_model->user_select($id);
	 	$this->load->library('session');
	  	if($this->session->userdata('username'))
 		{
			$date['username'] = $this->session->userdata('username');
 		}
 		else
 		{
 			echo "<script>alert('您尚未登录！');window.location.href='/CI/index.php/home/index';</script>";
 		}
		$this->load->view('edit_view',$date);
	 }
	 function edit()
	 {
	 	date_default_timezone_set('PRC'); 
		$title = $this->input->post('title');
		$news = $this->input->post('news');
		$id = $this->input->post('id');
		echo $title.$news.$id;
		if(empty($title))
		{
			echo "<script>alert('新闻标题不得为空！');history.back();</script>";
			exit;
		}
		if(empty($news))
		{
			echo "<script>alert('新闻内容不得为空');history.back();</script>";
			exit;
		}
		$datetime = date("y-m-d  G:i:s");
		$this->load->model('test_model');
		$arr=array('title'=>$title,'news'=>$news,'datetime'=>$datetime);
		$result_update = $this->test_model->user_update($id,$arr);
  	    if($result_update == true) {
      		echo "<script>alert('新闻编辑成功！');window.location.href='/CI/index.php/home/shouye';</script>";
    	 }
  		else {
			mysql_error() . "<br>不能编辑此新闻";
		}
		mysql_close();
	 }
	 function delete()
	 {
		$id = $this->input->get('id');
		$this->load->model('test_model');
   		$result_delete = $this->test_model->user_delete($id);
   		if($result_delete==true) {
      		echo "<script>alert('新闻删除成功！');window.location.href='/CI/index.php/home/shouye';</script>";
    	 }
		else{
			mysql_error() . "<br>不能删除此新闻";
		}
		mysql_close();
	 }
	 function browse()
	 {
	 	$this->load->library('session');
	  	if($this->session->userdata('username'))
 		{
			$date['username'] = $this->session->userdata('username');
 		}
 		else
 		{
 			echo "<script>alert('您尚未登录！');window.location.href='/CI/index.php/home/index';</script>";
 		}
		$id = $this->input->get('id');
		$this->load->model('test_model');
	 	$date['sel'] = $this->test_model->user_select($id);
		$this->load->view('browse_view',$date);
	 }
}