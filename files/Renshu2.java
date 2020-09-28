import java.util.HashMap;
import java.util.Map;

public class Renshu2 {
	public static void main(String[] args){
		String before = "����C���S����w�\���ŁC�n�C�J���Ȃ����񂩂������������A�x�b�N���C��˒[��c�����Ă�����w��ƃ}�u�_�`�錾�����킵�܂����D";
		String after = check(before);
		System.out.println(before);
		System.out.println(after);
	}

	// �p��W�͖{�v���O�������ɂP����Ηǂ��̂�static�ɂ���D
	// static�ɂ��Ȃ��ƁC�C���X�^���X���쐬����K�v������D
	// check()���Ń��[�J���ɂ���ƁC�Ăяo����邽�тɗp��W������ԁD
	private static HashMap<String, String> glossary = null;
	public static String check(String text){
		// �p��W�̏���������
		initGlossary();

		// �S�ẴL�[�o�����[�y�A�ɂ��Ēu�����������s����D
		for(Map.Entry<String, String> e : glossary.entrySet()){
			text.replace(e.getKey(), e.getValue());
		}
		return text;
	}

	// ���������ŗp���邽�߂����̃��\�b�h�Ȃ̂�private�ɂ��Ă���D
	private static void initGlossary(){
		// null�`�F�b�N���s�����Ƃł͂��߂̈��̂ݏ��������s���D
		if(glossary == null){
			glossary = new HashMap<String, String>();
			glossary.put("�A�x�b�N", "�J�b�v��");
			glossary.put("�`���x���o", "������");
			glossary.put("�`���x���O", "�G����");
			glossary.put("�o�C�r�[", "���Ⴀ��");
			glossary.put("���S", "JR");
			glossary.put("��˒[��c", "���q��");
			glossary.put("�����񂩂�", "�n���K�[");
			glossary.put("�}�u�_�`", "�Y�b�F");
			glossary.put("�n�C�J��", "�I�V����");
			glossary.put("���ς�", "�����L�[");
		}
	}
}
