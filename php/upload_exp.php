<?php
set_time_limit(0);

// 全てのパラメータを正しい構造で受け取った時のみ実行
if (
	isset($_POST['SUBJECT'], $_POST['YEAR'], $_FILES['userfile']['error']) &&
	is_int($_FILES['userfile']['error'])
) {
	try {
		//とりあえずログを追加しておく
		addLogsArray($_POST);
		addLogsArray($_FILES);

		/* ファイルのチェック */
		switch ($_FILES['userfile']['error']) {
			case UPLOAD_ERR_OK:
				// エラー無し
				break;
			case UPLOAD_ERR_NO_FILE:
				// ファイル未選択
				throw new RuntimeException('File is not selected');
			case UPLOAD_ERR_INI_SIZE:
			case UPLOAD_ERR_FORM_SIZE:
				// 許可サイズを超過
				throw new RuntimeException('File is too large');
			default:
				throw new RuntimeException('Unknown error');
		}
		if (!chk_ext($_FILES['userfile']['name'])){
			// 拡張子が.javaではない
			throw new RuntimeException('Invalid filename: ' . $_FILES['userfile']['name']);
		}
		if (!preg_match('/\A(?!\.)[\w.-]++(?<!\.)\z/', $_FILES['userfile']['name'])) {
			// 無効なファイル名
			throw new RuntimeException('Invalid filename: ' . $_FILES['userfile']['name']);
		}
		if (!preg_match('/(?<!\.php)(?<!\.cgi)(?<!\.py)(?<!\.rb)\z/i', $_FILES['userfile']['name'])) {
			// トロイの木馬を弾くため、実行可能な拡張子は禁止する
			throw new RuntimeException(
				'This extension is forbidden for security reason: ' .
				$_FILES['userfile']['name']
			);
		}
		if ($_POST['SUBJECT'] == 'ExpI'){
			if (!preg_match('/\A\d{1}_\d{8}_report\w+.pdf\z/', $_FILES['userfile']['name'])){
				//ファイル名がYYYYMMDD_N_report.pdfでない場合エラー
				throw new RuntimeException('Invalid File Name: ' . $_FILES['userfile']['name']);
			}
		}else if ($_POST['SUBJECT'] == 'DM'){
			list($studentid, $type, $ex) = preg_split("/[._]/", $_FILES['userfile']['name']);
			//ファイル名がXXnnnnnn_report.pdfまたはXXnnnnnn_presentation.pptx，XXnnnnnn_presentation.pdfでない場合エラー
			if (!preg_match('/\A[A-Za-z]{2}\d{6}\z/', $studentid)){
				throw new RuntimeException('Invalid File Name: ' . $studentid . ' [' . $_FILES['userfile']['name'] . "]");
			}else if(!preg_match('/\Areport|presentation\z/', $type)){
				throw new RuntimeException('Invalid File Name: ' . $type . ' [' . $_FILES['userfile']['name'] . "]");
			}
		}

		$uploaddir = '/volume1/web/php/uploaded/' . $_POST['SUBJECT'] . '/' . $_POST['YEAR'] . "/";
		$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
		//$_POST['NUMBER']フォルダの作成（ない場合）
		if(!file_exists($uploaddir)){
			if(!mkdir($uploaddir, 0777, true)){
				throw new RuntimeException("Failed to create directory: " . $uploaddir);
			}
		}
		
		//既に同一ファイルがアップロードされている場合，バックアップフォルダに移動する．（名前を変更して）
		if(file_exists($uploadfile)){
			//backupフォルダの作成（ない場合）
			$backup = $uploaddir . "backup/";
			if(!file_exists($backup)){
				if(!mkdir($backup, 0777, true)){
					throw new RuntimeException("Failed to create directory: " . $uploaddir);
				}
			}
			rename($uploadfile, $backup . basename($uploadfile) . "_" . date('YmdHis') );
		}
		
		//ファイルの移動
		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
			chmod($uploadfile, 0644);
			$str = "提出が完了しました.\n" . date('Y/m/d H:i:s') . "\n" . $_FILES['userfile']['name'] . " \t" . basename($uploadfile) . "\n";
		} else {
		    $str = "提出に失敗しました\n" . date('Y/m/d H:i:s') . "\n" . $_FILES['userfile']['name'] . " \t" . basename($uploadfile) . "\n";
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

/* HTML特殊文字をエスケープする関数 */
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function chk_ext( $chk_name, $allow_exts=array( "pdf", "pptx" ) ) {
	//使用出来ない拡張子のチェック
	$ext_err = true;//エラーフラグは初期値 真
	$exts = preg_split( "/[.]/", $chk_name );// ファイル名を.で分割する。
	if( count( $exts ) < 2 ) return false;
	$ext = $exts[ count( $exts ) - 1 ];//.で分割した最後のブロックの文字列を取得する
	foreach(  $allow_exts as $val ) {
		if( !empty( $val ) ) {
			if( strcasecmp( $val, $ext ) == 0 ) {
				$ext_err = false;//エラーフラグ 偽に変更
				break;
			}
		}
	}
	$ret = !$ext_err;//戻り値はエラーフラグを反転
	return $ret;
}
?>


