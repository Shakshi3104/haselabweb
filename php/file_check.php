<?php
set_time_limit(0);

// 全てのパラメータを正しい構造で受け取った時のみ実行
if (
	isset($_POST['NUMBER']) &&
	is_string($_POST['NUMBER'])
) {
	try {
		//とりあえずログを追加しておく
		addLogsArray($_POST);

		if (!preg_match('/\Afi1\d{5}\z/', $_POST['NUMBER']) && !preg_match('/\Ahb1\d{5}\z/', $_POST['NUMBER'])){
			//学籍番号がfi1XXXXXまたはhb1XXXXXでない場合エラー
			throw new RuntimeException('Invalid User Number: ' . $_POST['NUMBER']);
		}

		$uploaddir = '/volume1/web/php/uploaded/' . $_POST['SUBJECT'] . '/' . $_POST['YEAR'] . "/" . $_POST['NUMBER'] . "/";
		
		echo "【提出済みファイル一覧】\r\n";
		$flag = false;
		foreach(glob($uploaddir . '*') as $file){
			if(is_file($file)){
				echo basename($file) . "\r\n";
				$flag = true;
			}
		}
		if(!$flag){
			echo "なし";
		}
		
	    addLogs(str_replace("\t", " ", str_replace("\n"," ",$str)));
	    echo $str;
    } catch (RuntimeException $e) {
    	$str = $e->getMessage();
    	addLogs($str);
        echo $e->getMessage();
    }

}

function addLogs($data){
	date_default_timezone_set('UTC');
	$uploaddir = '/volume1/web/php/uploaded/log/';
	
	//フォルダの作成（ない場合）
	try{
		if(!file_exists($uploaddir)){
			if(!mkdir($uploaddir, 0777, true)){
				throw new RuntimeException("Failed to create directory: " . $uploaddir);
			}
		}
		$str = 'echo "' . date('Y/m/d H:i:s') . " \t " . $data . '" >> ' . $uploaddir . 'log.txt';
		shell_exec($str);
	}catch (RuntimeException $e){
		echo $e->getMessage();
	}
}
function addLogsArray($data){
	date_default_timezone_set('UTC');
	$uploaddir = '/volume1/web/php/uploaded/log/';
	
	//フォルダの作成（ない場合）
	try{
		if(!file_exists($uploaddir)){
			if(!mkdir($uploaddir, 0777, true)){
				throw new RuntimeException("Failed to create directory: " . $uploaddir);
			}
		}
		$str = 'echo "' . date('Y/m/d H:i:s') . " \t " . http_build_query($data) . '" >> ' . $uploaddir . 'log.txt';
		shell_exec($str);
	}catch (RuntimeException $e){
		echo $e->getMessage();
	}
}