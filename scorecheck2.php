<!DOCTYPE html>
<!-- ==============================
    Project:        Metronic "Asentus" Frontend Freebie - Responsive HTML Template Based On Twitter Bootstrap 3.3.4
    Version:        1.0
    Author:         KeenThemes
    Primary use:    Corporate, Business Themes.
    Email:          support@keenthemes.com
    Follow:         http://www.twitter.com/keenthemes
    Like:           http://www.facebook.com/keenthemes
    Website:        http://www.keenthemes.com
    Premium:        Premium Metronic Admin Theme: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
================================== -->
<html lang="en" class="no-js">
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>HaseLab Lecture</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta content="" name="description"/>
        <meta content="" name="author"/>

        <!-- GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Hind:300,400,500,600,700" rel="stylesheet" type="text/css">
        <link href="vendor/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

        <!-- PAGE LEVEL PLUGIN STYLES -->
        <link href="css/animate.css" rel="stylesheet">
        <link href="vendor/swiper/css/swiper.min.css" rel="stylesheet" type="text/css"/>

        <!-- THEME STYLES -->
        <link href="css/layout.min.css" rel="stylesheet" type="text/css"/>

        <!-- Favicon -->
        <link rel="shortcut icon" href="favicon.ico"/>
        <style type="text/css">
        <!--
table {
	background-color: #ffffff;
	border-top:#ffffff 3px double;
	border-collapse: collapse;
	font-size: 11px;
	width: 100%;
	color:#333333;
} 
table th.t_top {
	border-bottom: #dcdddd 1px solid;
	background-color: #efefef;
	text-align: left;
	padding: 10px;
} 
table td.t_line01 {
	background-color: #fff;
	text-align: left;
	padding: 10px;
	vertical-align: top;
}
table td.t_line02 {
	background-color: #f7f8f8;
	text-align: left;
	padding: 10px;
	vertical-align: top;
}
        -->
        </style>
    </head>
    <!-- END HEAD -->

    <!-- BODY -->
    <body>

        <!--========== HEADER ==========-->
        <header class="header navbar-fixed-top">
            <!-- Navbar -->
            <nav class="navbar" role="navigation">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="menu-container">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="toggle-icon"></span>
                        </button>

                        <!-- Logo -->
                        <div class="logo">
                            <a class="logo-wrap" href="index.html">
                                <img class="logo-img logo-img-main" src="img/logo02.png" alt="HaseLab Logo">
                                <img class="logo-img logo-img-active" src="img/logo01.png" alt="HaseLab Logo">
                            </a>
                        </div>
                        <!-- End Logo -->
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse nav-collapse">
                        <div class="menu-container">
                            <ul class="navbar-nav navbar-nav-right">
                                <li class="nav-item"><a class="nav-item-child nav-item-hover active" href="http://haselab.fuis.u-fukui.ac.jp/">Home</a></li>
                                <li class="nav-item"><a class="nav-item-child nav-item-hover" href="http://haselab.fuis.u-fukui.ac.jp/about.html">About</a></li>
                                <li class="nav-item"><a class="nav-item-child nav-item-hover" href="http://haselab.fuis.u-fukui.ac.jp/equipment.html">Equipment</a></li>
                                <li class="nav-item"><a class="nav-item-child nav-item-hover" href="http://haselab.fuis.u-fukui.ac.jp/member.html">Member</a></li>
                                <li class="nav-item"><a class="nav-item-child nav-item-hover" href="http://haselab.fuis.u-fukui.ac.jp/publication.html">Publication</a></li>
                                <li class="nav-item"><a class="nav-item-child nav-item-hover" href="http://haselab.fuis.u-fukui.ac.jp/access.html">Access</a></li>
                                <li class="nav-item"><a class="nav-item-child nav-item-hover" href="http://hsgw-nas.fuis.u-fukui.ac.jp/lecture.html">Lecture</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Navbar Collapse -->
                </div>
            </nav>
            <!-- Navbar -->
        </header>
        <!--========== END HEADER ==========-->

        <!--========== PARALLAX ==========-->
        <div class="parallax-window" data-parallax="scroll" data-image-src="img/1920x1080/05.jpg">
            <div class="parallax-content container">
                <h1 class="carousel-title">Lecture</h1>
                <p>成績確認</p>
            </div>
        </div>
        <!--========== PARALLAX ==========-->


        <!--========== PAGE LAYOUT ==========-->
        <!-- Service -->
        <div class="bg-color-sky-light" data-auto-height="true">
            <div class="content-lg container">
	            <div class="row margin-b-40">
	            

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


		//$sql = "SELECT * FROM kadai WHERE SUBJECT = ? AND YEAR = ? AND STUDENT_ID = ?";
		$sql = "SELECT a.YEAR, a.SUBJECT, a.CLASS_NUM, b.STUDENT_ID, sum(a.SCORING * b.CORRECT) as SCORE FROM saiten as a LEFT JOIN saiten_result as b ON a.ID = b.SAITEN_ID WHERE b.STUDENT_ID = ? and a.YEAR = ? and a.SUBJECT = ? GROUP BY a.YEAR, a.SUBJECT, a.CLASS_NUM, b.STUDENT_ID ";

		// 2-2. プリペアドステートメントを準備
		$sth = $dbh->prepare($sql);

		// 3. 型を指定してパラメータにバインドする
		$sth->bindParam(1, $_POST['STUDENT_ID'], PDO::PARAM_STR);
		$sth->bindParam(2, $_POST['YEAR'], PDO::PARAM_STR);
		$sth->bindParam(3, $_POST['SUBJECT'], PDO::PARAM_STR);

		// SQL の実行
		$sth->execute();

		$i = 0;
		echo '<table><tr>';
		echo '<th class="t_top">授業回</th>';
		echo '<th class="t_top">学籍番号</th>';
		echo '<th class="t_top">得点</th></tr>';
		while($score = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
			//echo "第".$score['CLASS_NUM']."回：".$score['SCORE']."点\n";
			echo "<tr>";
			echo makeCol($i, $score['CLASS_NUM']);
			echo makeCol($i, $score['STUDENT_ID']);
			echo makeCol($i, $score['SCORE']);
			echo "</tr>";
			$i++;
		}
		echo "</table><br>";


		//$sql = "SELECT * FROM kadai WHERE SUBJECT = ? AND YEAR = ? AND STUDENT_ID = ?";
		$sql = "SELECT b.STUDENT_ID, a.CLASS_NUM, a.KADAI, a.NOTE, a.SCORING, b.CORRECT FROM saiten as a LEFT JOIN saiten_result as b ON a.ID = b.SAITEN_ID WHERE b.STUDENT_ID = ? and a.YEAR = ? and a.SUBJECT = ?";

		// 2-2. プリペアドステートメントを準備
		$sth = $dbh->prepare($sql);

		// 3. 型を指定してパラメータにバインドする
		$sth->bindParam(1, $_POST['STUDENT_ID'], PDO::PARAM_STR);
		$sth->bindParam(2, $_POST['YEAR'], PDO::PARAM_STR);
		$sth->bindParam(3, $_POST['SUBJECT'], PDO::PARAM_STR);

		// SQL の実行
		$sth->execute();

		$i = 0;
		echo '<table><tr><th class="t_top">学籍番号</th>';
		echo '<th class="t_top">授業回</th>';
		echo '<th class="t_top">課題番号</th>';
		echo '<th class="t_top">採点基準</th>';
		echo '<th class="t_top">配点</th>';
		echo '<th class="t_top">正否(1が正解)</th></tr>';
		while($score = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
			//echo "第".$score['CLASS_NUM']."回：".$score['SCORE']."点\n";
			echo "<tr>";
			echo makeCol($i, $score['STUDENT_ID']);
			echo makeCol($i, $score['CLASS_NUM']);
			echo makeCol($i, $score['KADAI']);
			echo makeCol($i, $score['NOTE']);
			echo makeCol($i, $score['SCORING']);
			echo makeCol($i, $score['CORRECT']);
			echo "</tr>";
			$i++;
		}
		echo "</table>";
    } catch (RuntimeException $e) {
    	$str = $e->getMessage();
    	addLogs($str);
        echo $e->getMessage();
    }
}else{
	echo("NG");
}

function makeCol($i, $str){
	$res = '<td class="t_line0' . ($i%2+1) . '">';
	$res .= $str . "</td>";
	return $res;
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

	            </div>
                <!--// end row -->
            </div>
        </div>
        <!-- End Service -->


        <!--========== FOOTER ==========-->
        <footer class="footer">
            <!-- Copyright -->
            <div class="content container">
                <div class="row">
                    <div class="col-xs-6">
                        <img class="footer-logo" src="img/logo02.png" alt="HaseLab Logo">
                    </div>
                    <div class="col-xs-6 text-right">
                        <p class="margin-b-0">&copy; 2017 Tatsuhito Hasegawa.</p>
                    </div>
                </div>
                <!--// end row -->
            </div>
            <!-- End Copyright -->
        </footer>
        <!--========== END FOOTER ==========-->

        <!-- Back To Top -->
        <a href="javascript:void(0);" class="js-back-to-top back-to-top">Top</a>

        <!-- JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
        <!-- CORE PLUGINS -->
        <script src="vendor/jquery.min.js" type="text/javascript"></script>
        <script src="vendor/jquery-migrate.min.js" type="text/javascript"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

        <!-- PAGE LEVEL PLUGINS -->
        <script src="vendor/jquery.easing.js" type="text/javascript"></script>
        <script src="vendor/jquery.back-to-top.js" type="text/javascript"></script>
        <script src="vendor/jquery.smooth-scroll.js" type="text/javascript"></script>
        <script src="vendor/jquery.wow.min.js" type="text/javascript"></script>
        <script src="vendor/jquery.parallax.min.js" type="text/javascript"></script>
        <script src="vendor/swiper/js/swiper.jquery.min.js" type="text/javascript"></script>

        <!-- PAGE LEVEL SCRIPTS -->
        <script src="js/layout.min.js" type="text/javascript"></script>
        <script src="js/components/swiper.min.js" type="text/javascript"></script>
        <script src="js/components/wow.min.js" type="text/javascript"></script>

    </body>
    <!-- END BODY -->
</html>



