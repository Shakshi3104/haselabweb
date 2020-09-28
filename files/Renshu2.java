import java.util.HashMap;
import java.util.Map;

public class Renshu2 {
	public static void main(String[] args){
		String before = "昨日，国鉄福井駅構内で，ハイカラなえもんかけを所持したアベックが，井戸端会議をしていた主婦らとマブダチ宣言を交わしました．";
		String after = check(before);
		System.out.println(before);
		System.out.println(after);
	}

	// 用語集は本プログラム中に１つあれば良いのでstaticにする．
	// staticにしないと，インスタンスを作成する必要がある．
	// check()内でローカルにすると，呼び出されるたびに用語集を作る手間．
	private static HashMap<String, String> glossary = null;
	public static String check(String text){
		// 用語集の初期化処理
		initGlossary();

		// 全てのキーバリューペアについて置換処理を実行する．
		for(Map.Entry<String, String> e : glossary.entrySet()){
			text.replace(e.getKey(), e.getValue());
		}
		return text;
	}

	// 内部処理で用いるためだけのメソッドなのでprivateにしている．
	private static void initGlossary(){
		// nullチェックを行うことではじめの一回のみ初期化を行う．
		if(glossary == null){
			glossary = new HashMap<String, String>();
			glossary.put("アベック", "カップル");
			glossary.put("チョベリバ", "激おこ");
			glossary.put("チョベリグ", "エモい");
			glossary.put("バイビー", "じゃあね");
			glossary.put("国鉄", "JR");
			glossary.put("井戸端会議", "女子会");
			glossary.put("えもんかけ", "ハンガー");
			glossary.put("マブダチ", "ズッ友");
			glossary.put("ハイカラ", "オシャン");
			glossary.put("つっぱり", "ヤンキー");
		}
	}
}
