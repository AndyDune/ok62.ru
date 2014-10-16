<?php
/**
 * Dune Framework
 * 
 * Контейнер строки. Функции-обертки над стандартными.
 * Цель: Максимально сгладить переход на utf-8.
 * В перспекотве переход на php6.
 * Все строковые функции в проектах через этот класс.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Container.php                               |
 * | В библиотеке: Dune/String/Container.php           |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 0.94                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 * 
 * 
 *  0.94 (2009 июль 28)
 *  Добавлен ucfirst()
 * 
 *  0.93 (2009 апрель 28)
 *  Интерфейсы для методов tolower() и toupper().
 * 
 *  0.92 (2009 апрель 27)
 *  Интерфейс для метода setString().
 * 
 *  0.90 (2009 апрель 06)
 *  Реализует не все функции.
 * 
 *  0.91 (2009 апрель 13)
 *  Названия сетодлв: rpos -> posr, istr -> stri.
 * 
 */

interface Dune_String_Interface_Container
{
	
	/**
	 * Равенство строк.
	 *
	 * @param string $str Приводится к типу string.
	 * @param  $min Минимальное число символов в строке.
	 * @return boolean
	 */
	public function equal($str, $min = 0);
	
	/**
	 * Длина строки.
	 *
	 * @return integer
	 */
	public function len();
	
	
	/**
	 * Возвращает числовую позицию первого вхождения $string.
	 *
	 * @param string $string
	 * @param integer $offset
	 * @return mixed
	 */
	public function pos($string, $offset = 0);

	/**
	 * Возвращает числовую позицию последнего вхождения $string.
	 *
	 * Необязательный аргумент offset позволяет указать, с какого посчету символа строки haystack начинать поиск.
	 * Возвращается всегда позиция относительно начала строки haystack.
	 * 
	 * @param string $string
	 * @param integer $offset
	 * @return mixed
	 */
	public function posr($string, $offset = null);
	
	/**
	 * Возвращает часть строки haystack от первого вхождения needle до конца haystack.
     *
     * Если needle не найден, возвращает FALSE.
     * Если needle не строка, он конвертируется в integer и применяется как порядковое значение символа.
	 *
	 * @param unknown_type $string
	 * @return unknown
	 */
	public function str($string);

	/**
	 *  Метод str() без учёта регистра.
	 *
	 * @param unknown_type $string
	 * @return unknown
	 */
	public function stri($string);
	
	/**
	 * Возвращает часть строки.
	 * 
	 * Если start отрицательный, возвращаемая строка начинается со start'ового символа, считая от конца строки string.
	 * 
	 * Если length задан и положительный, возвращаемая строка будет содержать максимум length символов,
	 *  начиная со start (в зависимости от длины строки string. Если string меньше start, возвращается FALSE).
     *
     * Если length задан и негативный, то это количество символов будет пропущено,
     *  начиная с конца string (после вычисления стартовой позиции, когда start негативный). Если start задаёт позицию за пределами этого усечения, возвращается пустая строка.
	 *
	 * @param integer $start Если start отрицательный, возвращаемая строка начинается со start'ового символа, считая от конца строки string.
	 * @param integer $length
	 * @return string
	 */
	public function substr($start, $length = null);
	
	/**
	 * Установка обрабатываемой строки
	 *
	 * @param unknown_type $string
	 */
	public function setString($string);
	
	public function trim($charlist = '');
	public function trimr($charlist = '');
	public function triml($charlist = '');
	
	public function tolower();
	public function toupper();
	
	
	
	/**
	 *  Преобразует первый символ строки в верхний регистр
	 *
	 */
	public function ucfirst();
	
}

