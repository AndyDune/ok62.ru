<?php
/**
 * “ипограф. ќбработка текста.
 * 
 * ѕо большей части доработанный код:
 * 	"“ипограф" дл€ каждого
 *	јвтор: —елезнЄв ƒ. Ћ., info@webfilin.ru,  http://webfilin.ru/instruments/typograf
 * ¬ерси€: 1.0
 * ƒата: 17.01.2008
 * Ћицензи€: GNU Public License
 * 
 * ƒанный PHP-класс позвол€ет автоматически типографировать тексты на стороне сервера.
 * 
 * „то может типограф:
 * Ч правильно расставл€ть кавычки и тире;
 * Ч удал€ет Ђтабыї и повторы пробелов;
 * Ч удал€ет пробелы в начале и конце текста, а также пустые строки;
 * Ч удал€ет пробелы перед знаками пунктуации, перед знаком %;
 * Ч расстановка абзацев и переносов строк;
 * Ч ставит неразрывный пробел: 
 * Ч перед последним словом;
 * Ч после коротких слов;
 * Ч перед частицами: ли, ль, же, ж, бы, б;
 * Ч после знака є и І.
 * Ч замен€ет: 
 * Ч 10 C на 10 ∞— и 10 F на 10 ∞F;
 * Ч 2007г. на 2007 г.;
 * Ч три точки на троеточие;
 * Ч  в. м (км, дм, см, мм) на м?;
 * Ч  уб. м (км, дм, см, мм) на м?;
 * Ч √–јƒ(23) на 23∞;
 * Ч ƒё…ћ(15) на 15?;
 * Ч ≈¬–ќ() на И, ‘”Ќ“() на ?, ÷≈Ќ“() на ?;
 * Ч —“–¬() на ?, —“–Ќ() на ?, —“–Ћ() на ? —“–ѕ() на ?, ¬¬ќƒ() на ?;
 * Ч 12x18 на 12?18;
 * Ч http://example.ru на http://example.ru;
 * Ч (с) на ©, (r) на Щ, +/- на ±.
 * 
 * “ребовани€: PHP 5.* и библиотека iconv.
 * 
 * ----------------------------------------------------
 * | Ѕиблиотека: Dune                                  |
 * | ‘айл: Typograf.php                                |
 * | ¬ библиотеке: Dune/Data/Typograf.php              |
 * | јвтор: јндрей –ыжов (Dune) <dune@rznlf.ru>        |
 * | ¬ерси€: 1.00                                      |
 * | —айт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * ¬ерси€ 1.00 -> 1.01
 * 
 */



class Dune_Data_Typograf
{
    const TYPOGRAF_MODE_DEFAULT = 0; // &#8212; - спец. символы в виде кодов
    const TYPOGRAF_MODE_NAMES = 1; // &mdash; - спец. символы в виде имЄн
    const TYPOGRAF_MODE_OLD = 2; // &#151; - спец. символы в виде устарев. кодов, дл€ "гурманов"
    
    const ENC_UTF8 = 'utf-8';
    const ENC_WIN  = 'windows-1251';
    
        
	private $text; // “екст дл€ типографировани€
	private $tmode; // –ежим типографа
	
	public $br; // –астановка переносов строк,  true или false
	public $p; // –астановка абзацов,  true или false
	
	public $quot11; // ќткр. кавычка первого уровн€
	public $quot12; // «акр. кавычка первого уровн€
	public $quot21; // ќткр. кавычка второго уровн€
	public $quot22; // «акр. кавычка второго уровн€
	
	public $tire; // “ире
	public $tireinterval; // “ире в интервалах
	public $number; // «нак є
	public $sect; // «нак параграфа
	public $sup2; // —тепень квадрата
	public $sup3; // —тепень куба
	public $deg; // «нак градуса
	public $Prime; // «нак дюйма
	public $euro; // «нак евро
	public $times; // «нак умножени€
	public $plusmn; // ѕлюс-минус
	
	public $space; // Ќеразрывный пробел
	public $spaceAfterShortWord; // ѕробел после коротких слов,  true или false
	public $lengthShortWord; // ƒлина короткого слова
	public $spaceBeforeTire; // ѕробел перед тире,  true или false
	public $delTab;	// ”даление табов, если установлено false, табы замен€ютс€ на пробелы,  true или false
	public $replaceTab; // «амена табов на пробелы,  true или false
	public $spaceBeforeLastWord; // ѕробел перед последним словом,  true или false
	public $lengthLastWord; // ƒлина последнего слова
	public $spaceAfterNum; // ѕробел после є,  true или false
	
	public $spaceBeforeParticles; // ѕробел перед частицами - ли, же, бы.  true или false
	public $delRepeatSpace; // ”дал€ть повторы пробелов,  true или false
	public $delSpaceBeforePunctuation; // ”дал€ть пробел перед знаками препинани€,  true или false
	public $delSpaceBeforeProcent; // ”дал€ть пробел перед знаком процента,  true или false
	public $trim; // ”даление пробелов в начале и конце текста,  true или false
	
	public $doReplaceBefore; // ƒелать замену перед типографированием. true или false
	public $doReplaceAfter; // ƒелать замену после типографировани€. true или false
	
	public $findUrls; // »скать URL и замен€ть http://example.com на  <a href="http://example.com">http://example.com</a>,  true или false

	private $_isHTMLCode; // Ёто HTML-код

	function __construct() 
	{
		$this->tmode = self::TYPOGRAF_MODE_DEFAULT;
		
		$this->p = false;
		$this->br = false;
		
		$this->tmode = self::TYPOGRAF_MODE_DEFAULT;
		$this->quot11 = '&#171;';
		$this->quot12 = '&#187;';
		$this->quot21 = '&#8222;';
		$this->quot22 = '&#8220;';
		
		$this->tire           = '&#8212;';
		$this->tireinterval   = '&#8212;';
		$this->number         = '&#8470;';
		$this->hellip         = '&#8230;';
		$this->sect           = '&#167;';
		$this->sup2           = '&#178;';
		$this->sup3           = '&#179;';
		$this->deg            = '&#176;';
		$this->euro           = '&#8364;';
		$this->cent           = '&#162;';
		$this->pound          = '&#163;';
		$this->Prime          = '&#8243;';
		$this->times          = '&#215;';
		$this->plusmn         = '&#177;';
		
		$this->darr   = '&#8595;';
		$this->uarr   = '&#8593;';
		$this->larr   = '&#8592;';
		$this->rarr   = '&#8594;';
		$this->crarr  = '&#8629;';
		
		$this->space                  = '&#160;';
		$this->delRepeatSpace         = true;
		$this->delTab                 = false;
		$this->replaceTab             = true;
		$this->spaceBeforeParticles   = true;
		$this->spaceAfterShortWord    = true;
		$this->lengthShortWord        = 2;
		$this->spaceBeforeTire        = true;	
		$this->spaceBeforeLastWord    = true;
		$this->lengthLastWord         = 3;
		$this->delSpaceBeforePunctuation = true;
		$this->delSpaceBeforeProcent  = true;
		$this->spaceAfterNum          = true;
		$this->trim                   = true;
		
		$this->findUrls = false;
		
		$this->doReplaceBefore    = true;
		$this->doReplaceAfter     = true;
	}
	
	private function replaceBefore()
	{
		$before = array('(r)', '(c)', '(tm)', '+/-');
		$after  = array('Ѓ', '©', 'Щ', '±');
		
		$this->text = str_ireplace($before, $after, $this->text);
		
		return $this;
	}

	private function replaceAfter()
	{
		// «амена +- около чисел
		$this->text = preg_replace('/(?<=^| |\>|&nbsp;|&#160;)\+-(?=\d)/', $this->plusmn, $this->text);
		
		// «амена 3 точек на троеточие
		$this->text = preg_replace('/(^|[^.])\.{3}([^.]|$)/', '$1'.$this->hellip.'$2', $this->text);
		
		// √радусы ÷ельси€
		$this->text = preg_replace('/(\d+)( |\&\#160;|\&nbsp;)?(C|F)([\W \.,:\!\?"\]\)]|$)/',
		                           '$1'.$this->space.$this->deg.'$3$4', $this->text);
		
		// XXXX г.
		$this->text=preg_replace('/(^|\D)(\d{4})г( |\.|$)/', '$1$2'.$this->space.'г$3', $this->text);
		
		$m = '(км|м|дм|см|мм)';
		//  в. км м дм см мм
		$this->text = preg_replace('/(^|\D)(\d+)( |\&\#160;|\&nbsp;)?'.$m.'2(\D|$)/',
                                   '$1$2'.$this->space.'$4'.$this->sup2.'$5', $this->text);
 
		//  уб. км м дм см мм
		$this->text = preg_replace('/(^|\D)(\d+)( |\&\#160;|\&nbsp;)?'.$m.'3(\D|$)/',
		                           '$1$2'.$this->space.'$4'.$this->sup3.'$5', $this->text);

		// √–јƒ(n)
		$this->text = preg_replace('/√–јƒ\(([\d\.,]+?)\)/', '$1'.$this->deg, $this->text);
		
		// ƒё…ћ(n)
		$this->text = preg_replace('/ƒё…ћ\(([\d\.,]+?)\)/', '$1'.$this->Prime, $this->text);

		// «амена икса в числах на знак умножени€
		$this->text = preg_replace('/(?<=\d) ?x ?(?=\d)/', $this->times, $this->text);
		
		// «нак евро
		$this->text = str_replace('≈¬–ќ()', $this->euro, $this->text);

		// «нак фунта
		$this->text = str_replace('‘”Ќ“()', $this->pound, $this->text);

		// «нак цента
		$this->text = str_replace('÷≈Ќ“()', $this->cent, $this->text);
		
		// —трелка вверх
		$this->text = str_replace('—“–¬()', $this->uarr, $this->text);		
		
		// —трелка вниз
		$this->text = str_replace('—“–Ќ()', $this->darr, $this->text);		

		// —трелка влево
		$this->text = str_replace('—“–Ћ()', $this->larr, $this->text);		

		// —трелка вправо
		$this->text = str_replace('—“–ѕ()', $this->rarr, $this->text);		

		// —трелка ввод
		$this->text = str_replace('¬¬ќƒ()', $this->crarr, $this->text);		

		return $this;
	}

	public function setTMode($tmode = self::TYPOGRAF_MODE_DEFAULT)
	{
		if ($tmode == self::TYPOGRAF_MODE_DEFAULT)
		{
			$this->tmode = self::TYPOGRAF_MODE_DEFAULT;
			
			$this->quot11    = '&#171;';
			$this->quot12    = '&#187;';
			$this->quot21    = '&#8222;';
			$this->quot22    = '&#8220;';			

			$this->tire          = '&#8212;';
			$this->tireinterval  = '&#8212;';
			
			$this->space     = '&#160;';
			$this->hellip    = '&#8230;';

			$this->sect  = '&#167;';
			$this->sup2  = '&#178;';
			$this->sup3  = '&#179;';
			$this->deg   = '&#176;';
			
			$this->euro      = '&#8364;';
			$this->cent      = '&#162;';
			$this->pound     = '&#163;';
			$this->Prime     = '&#8243;';
			$this->times     = '&#215;';
			$this->plusmn    = '&#177;';
			
			$this->darr  = '&#8595;';
			$this->uarr  = '&#8593;';
			$this->larr  = '&#8592;';
			$this->rarr  = '&#8594;';
			$this->crarr = '&#8629;';			
		}
		else if ($tmode == self::TYPOGRAF_MODE_NAMES)
		{
			$this->tmode = self::TYPOGRAF_MODE_NAMES;
			
			$this->quot11    = '&laquo;';
			$this->quot12    = '&raquo;';
			$this->quot21    = '&bdquo;';
			$this->quot22    = '&ldquo;';			

			$this->tire          = '&mdash;';
			$this->tireinterval  = '&mdash;';
			
			$this->space  = '&nbsp;';
			$this->hellip = '&hellip;';

			$this->sect  = '&sect;';
			$this->sup2  = '&sup2;';
			$this->sup3  = '&sup3;';
			$this->deg   = '&deg;';
			
			$this->euro      = '&euro;';
			$this->cent      = '&cent;';
			$this->pound     = '&pound;';			
			$this->Prime     = '&Prime;';
			$this->times     = '&times;';
			$this->plusmn    = '&plusmn;';

			$this->darr  = '&darr;';
			$this->uarr  = '&uarr;';
			$this->larr  = '&larr;';
			$this->rarr  = '&rarr;';
			$this->crarr = '&crarr;';			
		}
		else
		{
			$tmode == self::TYPOGRAF_MODE_OLD;

			$this->quot11    = '&#171;';
			$this->quot12    = '&#187;';
			$this->quot21    = '&#132;';
			$this->quot22    = '&#147;';			

			$this->tire          = '&#151;';
			$this->tireinterval  = '&#151;';
			
			$this->space     = '&#160;';
			$this->hellip    = '&#133;';
			
			$this->sect      = '&#167;';
			$this->sup2      = '&#178;';
			$this->sup3      = '&#179;';
			$this->deg       = '&#176;';
			$this->euro      = '&#8364;';
			$this->cent      = '&#162;';
			$this->pound     = '&#163;';			
			$this->Prime     = '&#8243;';
			$this->times     = '&#215;';
			$this->plusmn    = '&#177;';
		
			$this->darr  = '&#8595;';
			$this->uarr  = '&#8593;';
			$this->larr  = '&#8592;';
			$this->rarr  = '&#8594;';
			$this->crarr = '&#8629;';			
		}
		
		return $this;
	}

	private function quotes()
	{
		$quotes = array('&quot;', '&laquo;', '&raquo;', 'Ђ', 'ї', '&#171;', '&#187;', '&#147;', '&#132;', '&#8222;', '&#8220;');
		$this->text = str_replace($quotes, '"', $this->text);

		$this->text = preg_replace('/([^=]|\A)""(\.{2,4}[а-€ј-я\w\-]+|[а-€ј-я\w\-]+)/', '$1<typo:quot1>"$2', $this->text);
		$this->text = preg_replace('/([^=]|\A)"(\.{2,4}[а-€ј-я\w\-]+|[а-€ј-я\w\-]+)/', '$1<typo:quot1>$2', $this->text);
		
		$this->text = preg_replace('/([а-€ј-я\w\.\-]+)""([\n\.\?\!, \)][^>]{0,1})/', '$1"</typo:quot1>$2', $this->text);
		$this->text = preg_replace('/([а-€ј-я\w\.\-]+)"([\n\.\?\!, \)][^>]{0,1})/', '$1</typo:quot1>$2', $this->text);
		
		$this->text = preg_replace('/(<\/typo:quot1>[\.\?\!]{1,3})"([\n\.\?\!, \)][^>]{0,1})/', '$1</typo:quot1>$2', $this->text);
		$this->text = preg_replace('/(<typo:quot1>[а-€ј-я\w\.\- \n]*?)<typo:quot1>(.+?)<\/typo:quot1>/',
		                           '$1<typo:quot2>$2</typo:quot2>', $this->text);
		$this->text = preg_replace('/(<\/typo:quot2>.+?)<typo:quot1>(.+?)<\/typo:quot1>/',
		                           '$1<typo:quot2>$2</typo:quot2>', $this->text);
		$this->text = preg_replace('/(<typo:quot2>.+?<\/typo:quot2>)\.(.+?<typo:quot1>)/', '$1<\/typo:quot1>.$2', $this->text);
		$this->text = preg_replace('/(<typo:quot2>.+?<\/typo:quot2>)\.(?!<\/typo:quot1>)/', '$1</typo:quot1>.$2$3$4', $this->text);
		$this->text = preg_replace('/""/', '</typo:quot2></typo:quot1>', $this->text);
		$this->text = preg_replace('/(?<=<typo:quot2>)(.+?)<typo:quot1>(.+?)(?!<\/typo:quot2>)/', '$1<typo:quot2>$2', $this->text);
		$this->text = preg_replace('/"/', '</typo:quot1>', $this->text);
		
		$this->text = preg_replace('/(<[^>]+)<\/typo:quot\d>/', '$1"', $this->text);
		$this->text = preg_replace('/(<[^>]+)<\/typo:quot\d>/', '$1"', $this->text);
		$this->text = preg_replace('/(<[^>]+)<\/typo:quot\d>/', '$1"', $this->text);
		$this->text = preg_replace('/(<[^>]+)<\/typo:quot\d>/', '$1"', $this->text);
		$this->text = preg_replace('/(<[^>]+)<\/typo:quot\d>/', '$1"', $this->text);
		$this->text = preg_replace('/(<[^>]+)<\/typo:quot\d>/', '$1"', $this->text);
	
		$this->text = str_replace('<typo:quot1>', $this->quot11, $this->text);
		$this->text = str_replace('</typo:quot1>', $this->quot12, $this->text);
		$this->text = str_replace('<typo:quot2>', $this->quot21, $this->text);
		$this->text = str_replace('</typo:quot2>', $this->quot22, $this->text);
		
		return $this;
	}

	private function dashes()
	{
		$tires = array('&mdash;', '&ndash;', '&#8211;', '&#8212;');
		$this->text = str_replace($tires, 'Ч', $this->text);

		$pre = '(€нварь|февраль|март|апрель|июнь|июль|август|сент€брь|окт€брь|но€брь|декабрь)';
		$this->text = preg_replace('/' . $pre . ' ?(-|Ч) ?' . $pre . '/i', '$1Ч$3', $this->text);
		
		$pre = '(понедельник|вторник|среда|четверг|п€тница|суббота|воскресенье)';
		$this->text = preg_replace('/' . $pre . ' ?(-|Ч) ?' . $pre . '/i', '$1Ч$3', $this->text);		

		$this->text = preg_replace('/(^|\n|>) ?(-|Ч) /', '$1Ч ', $this->text);
		
		$this->text = preg_replace('/(^|[^\d\-])(\d{1,4}) ?(Ч|-) ?(\d{1,4})([^\d\-\=]|$)/',
		                           '$1$2' . $this->tireinterval . '$4$5', $this->text);
		
		$this->text = preg_replace('/ -(?= )/', $this->space.$this->tire, $this->text);
		$this->text = preg_replace('/(?<=&nbsp;|&#160;)-(?= )/', $this->tire, $this->text);

		$this->text = preg_replace('/ Ч(?= )/', $this->space . $this->tire, $this->text);
		$this->text = preg_replace('/(?<=&nbsp;|&#160;)Ч(?= )/', $this->tire, $this->text);
		
		return;
	}
	
	private function pbr()
	{
		$n = strpos($this->text, "\n");
		
		if ($this->_isHTMLCode)
			return;
		
		if ($n !== false)
		{
			if ($this->br)
			{
				if (!$this->p)	
				    $this->text = str_replace("\n", "<br />\n", $this->text);
				else
				{
					$this->text = preg_replace('/^([^\n].*?)(?=\n\n)/s', '<p>$1</p>', $this->text);
					$this->text = preg_replace('/(?<=\n\n)([^\n\<].*?)(?=\n\n)/s', '<p>$1</p>', $this->text);
					$this->text = preg_replace('/(?<=\n\n)([^\n\<].*?)$/s', '<p>$1</p>', $this->text);

					$this->text = preg_replace('/([^\n])\n([^\n])/', "$1<br />\n$2", $this->text);
				}
			}
			else
			{
				if ($this->p)
				{
					$this->text = preg_replace('/^([^\n].*?)(?=\n\n)/s', '<p>$1</p>', $this->text);
					$this->text = preg_replace('/(?<=\n\n)([^\n].*?)(?=\n\n)/s', '<p>$1</p>', $this->text);
					$this->text = preg_replace('/(?<=\n\n)([^\n].*?)$/s', '<p>$1</p>', $this->text);
				}
			}
		}
		else
		{
			if ($this->p)	
			     $this->text = '<p>' . $this->text . '</p>';
		}
		
		return;
	}
	
	private function delpbr()
	{
		$tags = array('<br />', '<p>', '</p>');
		
		$this->text = str_replace($tags, '', $this->text);
		
		return;
	}
	
	private function spaces()
	{
		$this->text = str_replace("\r", '', $this->text);
		
		if ($this->delTab)
			$this->text=str_replace("\t", '', $this->text);
		else if ($this->replaceTab)
		    $this->text=str_replace("\t", ' ', $this->text);

		if ($this->trim)
		{
			$this->text = trim($this->text);
		}

		$this->text = str_replace('&nbsp;', ' ', $this->text);
		$this->text = str_replace('&#160;', ' ', $this->text);
				
		if ($this->delRepeatSpace)
		{
			$this->text = preg_replace('/ {2,}/', ' ', $this->text);
			$this->text = preg_replace("/\n {1,}/m", "\n", $this->text);
			$this->text = preg_replace("/\n{3,}/m", "\n\n", $this->text);
		}
	
		if ($this->delSpaceBeforePunctuation)
		{
			$before = array('!', ';', ',', '?', '.', ')',);
			$after = array();
			foreach($before as $i)
				$after[]='/ \\'.$i.'/';
				
			$this->text = preg_replace($after, $before, $this->text);
			$this->text = preg_replace('/\( /', '(', $this->text);
		}
		
		if ($this->spaceBeforeParticles)
		{
			$this->text = preg_replace('/ (ли|ль|же|ж|бы|б)(?![а-€ј-я])/', $this->space . '$1', $this->text);
		}
		
		if ($this->spaceAfterShortWord and $this->lengthShortWord>0)
		{
			$this->text = preg_replace('/( [а-€ј-я\w]{1,'.$this->lengthShortWord.'}) /', '$1'.$this->space, $this->text);		
		}
		
		if ($this->spaceBeforeLastWord and $this->lengthLastWord>0)
		{
			$this->text = preg_replace('/ ([а-€ј-я\w]{1,'.$this->lengthLastWord.'})(?=\.|\?|:|\!|,)/', $this->space.'$1', $this->text);		
		}	
			
		if ($this->spaceAfterNum)
		{
			$this->text = preg_replace('/(є|&#8470;)(?=\d)/', $this->number.$this->space, $this->text);
			$this->text = preg_replace('/(І|&#167;|&sect;)(?=\d)/', $this->sect.$this->space, $this->text);			
		}
		
		if ($this->delSpaceBeforeProcent)
		{
			$this->text = preg_replace('/( |&nbsp;|&#160;)%/', '%', $this->text);		
		}
		
		return;
	}

	/**
	 * ќбрабатывает текст.
	 *
	 * @param string $text строка дл€ обработки
	 * @param integer $tmode используЄте константы класса
	 * @param  string $coding кодировка текста источника и результата
	 * @return string обработанный текст
	 */
	public function execute($text, $tmode = self::TYPOGRAF_MODE_DEFAULT, $coding = 'windows-1251')
	{
		if (empty($text))	
		    return '';
		
		$this->text = $text;
		$this->setTMode($tmode);
		
		if ($coding != 'windows-1251')
			$this->text = iconv($coding, 'windows-1251', $this->text);

		$b = strpos($this->text, '<');
		$e = strpos($this->text, '>');
		if (($b !== false) and ($e !== false))
			$this->_isHTMLCode = true;
		else
		    $this->_isHTMLCode = false;
		
		if ($this->doReplaceBefore)
			$this->replaceBefore();
		
		$this->spaces();
		$this->quotes();
		$this->dashes();

		if ($this->findUrls)
		    $this->setUrls();

		$this->pbr();
		
		$this->replaceWindowsCodes();

		if ($this->doReplaceAfter)
			$this->replaceAfter();
		
		if ($coding != 'windows-1251')
			$this->text = iconv('windows-1251', $coding, $this->text);
		
		return $this->text;
	}
	
	private function replaceWindowsCodes()
	{
		$after = array('&#167;', '&#169;', '&#174;', '&#8482;', '&#176;', '&#171;', '&#183;',
				       '&#187;', '&#133;', '&#8216;', '&#8217;', '&#8220;', '&#8221;', '&#164;', '&#166;',
				       '&#8222;', '&#8226;', '&#8211;', $this->plusmn, $this->tire, $this->number, '&#8240;',
				       '&#8364;', '&#182;', '&#172;');

		$before = array('І', '©',  'Ѓ', 'Щ',  '∞', 'Ђ', 'Ј',
			            'ї', 'Е', 'С', 'Т', 'У', 'Ф', '§', '¶',
			            'Д', 'Х', 'Ц', '±', 'Ч', 'є', 'Й',
			            'И', 'ґ', 'ђ');

		$this->text = str_replace($before, $after, $this->text);
		
		return;
	}
	
	private function setUrls()
	{
		if ($this->_isHTMLCode)
		    return;
		
		$prefix = '(http|https|ftp|telnet|news|gopher|file|wais)://';
		$pureUrl = '([[:alnum:]/\n+-=%&:_.~?]+[#[:alnum:]+]*)';
		$this->text = eregi_replace($prefix.$pureUrl, '<a href="\\1://\\2">\\1://\\2</a>', $this->text); 
		
		return;
	}
}