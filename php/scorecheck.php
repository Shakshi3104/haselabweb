<?php
set_time_limit(0);

// 全てのパラメータを正しい構造で受け取った時のみ実行
if (
	isset($_POST['SUBJECT'], $_POST['YEAR'], $_POST['STUDENT_ID'])
) {
	try {
		//とりあえずログを追加しておく
		addLogsArray($_POST);
		addLogsArray($_FILES);

		if (!preg_match('/\Afi1\d{5}\z/', $_POST['STUDENT_ID']) && !preg_match('/\Ahb1\d{5}\z/', $_POST['STUDENT_ID'])){
			//学籍番号がfi1XXXXXまたはhb1XXXXXでない場合エラー
			throw new RuntimeException('Invalid User Number: ' . $_POST['STUDENT_ID']);
		}
		
		//$mysqli = new mysqli("hsgw-nas.fuis.u-fukui.ac.jp:3307", "HS_ADDER", "ADDMAN", "ProgramingIV");
		//$mysqli = new mysqli("hsgw-nas.fuis.u-fukui.ac.jp:3307", "test", "test", "ProgramingIV");
		//$mysqli->set_charset('utf8');
		
		
		// 1. 文字エンコーディングを指定して DB に接続する
		$dbh = new PDO('mysql:host=hsgw-nas.fuis.u-fukui.ac.jp:3307;dbname=ProgramingIV;charset=utf8', 'HS_ADDER', 'ADDMAN');

		// 2-1. 静的プレースホルダを用いるようにエミュレーションを無効化
		$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

		// エラー時に例外を発生させる（任意）
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "SELECT * FROM kadai WHERE SUBJECT = ? AND YEAR = ? AND STUDENT_ID = ?";

		// 2-2. プリペアドステートメントを準備
		$sth = $dbh->prepare($sql);

		// 3. 型を指定してパラメータにバインドする
		$sth->bindParam(1, $_POST['SUBJECT'], PDO::PARAM_STR);
		$sth->bindParam(2, $_POST['YEAR'], PDO::PARAM_STR);
		$sth->bindParam(3, $_POST['STUDENT_ID'], PDO::PARAM_STR);

		// SQL の実行
		$sth->execute();

		echo $_POST['STUDENT_ID']."\n";
		while($score = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
			echo "第".$score['CLASS_NUM']."回：".$score['SCORE']."点\n";
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

function chk_ext( $chk_name, $allow_exts=array( "java") ) {
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


