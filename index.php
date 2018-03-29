<?php
require 'init.php';

onedrive::$client_id = config('client_id');
onedrive::$client_secret = config('client_secret');
onedrive::$redirect_uri = config('redirect_uri');

onedrive::$app_url = config('app_url');

if( empty(onedrive::$app_url) ){
	route::any('/install',function(){
			$authorize_url = onedrive::authorize_url();
			if (empty($_REQUEST['code'])) {
				return view::load('auth')->with('authorize_url',$authorize_url);
			}
			$data = onedrive::authorize($_REQUEST['code']);
			if(empty($data['access_token'])){
				return view::load('auth')->with('authorize_url',$authorize_url)
							->with('error','��֤ʧ��');
			}
			$app_url = onedrive::get_app_url($data['access_token']);
			if(empty($app_url)){
				return view::load('auth')->with('authorize_url',$authorize_url)
							->with('error','��ȡapp url ʧ��');
			}
			config('refresh_token', $data['refresh_token']);
			config('app_url', $app_url);
			view::direct('/');
	});
	if((route::$runed) == false){
		view::direct('?/install');
	}
}



route::get('{path:#all}',function(){
	//��ȡ·�����ļ���
	$paths = explode('/', $_GET['path']);
	if(substr($_SERVER['REQUEST_URI'], -1) != '/'){
		$name = urldecode(array_pop($paths));
	}
	$path = '/'.implode('/', $paths).'/';
	$path = str_replace('//','/',$path);

	//�Ƿ��л���
	list($time, $items) = cache('dir_'.$path);
	//����ʧЧ������ץȡ
	if( is_null($items) || (TIME - $time) > config('cache_expire_time') ){
		$items = onedrive::dir($path);
		if(is_array($items)){
			$time = TIME;
			cache('dir_'.$path, $items);
		}
	}
	//���
	if(!empty($name)){//file
		if(in_array($_GET['thumbnails'],['large','medium','small'])){
			list($time, $item) = cache('thumbnails_'.$path.$name);
			if(empty($item[$_GET['thumbnails']]) ||  (TIME - $time) > config('cache_expire_time') ){
				$item = onedrive::thumbnails($path.$name);
				if(!empty($items)){
					cache('thumbnails_'.$path.$name, $item);
				}
			}
			$url = $item[$_GET['thumbnails']]['url'];
		}else{
			$url = $items[$name]['downloadUrl'];
		}
		header('Location: '.$url);
	}else{//dir
		
		view::load('list')->with('path',$path)->with('items', $items)->show();
	}
	
	//��̨ˢ�»���
	if((TIME - $time) > config('cache_refresh_time')){
		fastcgi_finish_request();
		$items = onedrive::dir($path);
		if(is_array($items)){
			cache('dir_'.$path, $items);
		}
	}
});
