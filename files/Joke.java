
public class Joke {
	private JokeListener jl;
	public Joke(JokeListener jl){
		this.jl = jl;
	}

	public int play(){
		final int wait = (int)((Math.random()*3)+2);
		Thread thread = new Thread(new Runnable(){
			@Override
			public void run() {
				String[] jokes = {"フトンがフットンだ",
								  "あったかい飲み物はあったかい？",
								  "馬が埋まる",
								  "有名クラブで，you make love.",
								  "南海放送って，なんか違法そう",
								  "ですます口調で済ます区長",
								  "妄想男子テルにもう相談してる",
								  "私達から，渡した力",
								  "でかいケツで解決"};
				String joke = jokes[(int)(Math.random()*jokes.length)];
				try{
					Thread.sleep(wait*1000);
					jl.jokePlayed(joke);
				}catch(Exception e){
					e.printStackTrace();
				}
			}
		});
		thread.start();
		return wait;
	}
}
