<?php
set_time_limit(0);

// 全てのパラメータを正しい構造で受け取った時のみ実行
if (
	isset($_POST['SUBJECT'], $_POST['YEAR'], $_POST['STUDENT_ID'], $_POST['PASSWORD'], $_POST['CLASS_NUM']) &&
	isset($_POST['KADAI1_1'], $_POST['KADAI1_2'], $_POST['KADAI2_1'], $_POST['KADAI2_2'], $_POST['KADAI2_3']) &&
	isset($_POST['KADAI3'], $_POST['KADAI4'])
) {
	try {
		//とりあえずログを追加しておく
		addLogsArray($_POST);
		addLogsArray($_FILES);

		if (!preg_match('/\Afi1\d{5}\z/', $_POST['STUDENT_ID']) && !preg_match('/\Ahb1\d{5}\z/', $_POST['STUDENT_ID'])){
			//学籍番号がfi1XXXXXまたはhb1XXXXXでない場合エラー
			throw new RuntimeException('Invalid User Number: ' . $_POST['STUDENT_ID']);
		}
		
		$mysqli = new mysqli("hsgw-nas.fuis.u-fukui.ac.jp:3307", "HS_ADDER", "ADDMAN", "ProgramingIV");
		//$mysqli = new mysqli("hsgw-nas.fuis.u-fukui.ac.jp:3307", "test", "test", "ProgramingIV");
		$mysqli->set_charset('utf8');
		
		$array = array('KADAI1_1', 'KADAI1_2', 'KADAI2_1', 'KADAI2_2', 'KADAI2_3', 'KADAI3', 'KADAI4');
		$date = new DateTime();
		$nowdt = $date->format('Y-m-d H:i:s');
		$stmt = $mysqli->prepare("INSERT INTO submitted(SUBJECT, YEAR, CLASS_NUM, STUDENT_ID, PASSWORD, KADAI_NUM, ANSWER, SUBMITTED_DT) VALUES (?, ?, ?, ?, ?, ?, ?, cast(? as datetime))");
		$stmt->bind_param('siississ', $subject, $year, $classnum, $studentid, $password, $kadainum, $answer, $dt);
		for ($i=0; $i<count($array); $i++){
			$subject = $_POST['SUBJECT'];
			$year = $_POST['YEAR'];
			$classnum = $_POST['CLASS_NUM'];
			$studentid = $_POST['STUDENT_ID'];
			$password = $_POST['PASSWORD'];
			$kadainum = $i;
			$answer = $_POST[$array[$i]];
			$dt = $nowdt;
			$stmt->execute();
			echo($stmt->affected_rows);
		}
    } catch (RuntimeException $e) {
    	$str = $e->getMessage();
    	addLogs($str);
        echo $e->getMessage();
    }
}else{
	echo("NG");
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

function chk_ext( $chk_name, $allow_exts=array( "java" ) ) {
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


