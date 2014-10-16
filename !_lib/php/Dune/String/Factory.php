<?php
/**
 * Dune Framework
 * 
 * Факрика классов для классов-оберток стандартных функций работы со строками.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Factory.php                                 |
 * | В библиотеке: Dune/String/Factory.php             |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 0.05                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 *
 *  0.05 (2009 май 14)
 *  Новый метод getStringTransform()
 * 
 *  0.04 (2009 апрель 27)
 *  Вызов метода-фабрики без передачи строки.
 *  Информация об используемой кодировке берется из класса Dune_Parameters.
 * 
 */

abstract class Dune_String_Factory
{
    static $multiByte = null;
    static $multiByteCharset = 'UTF-8';
    
    /**
     * Возвращает объект-контейнер строки с функциями работа с ней.
     *
     * @var string $string
     * @var boolean $multi_byte
     * @return Dune_String_Interface_Container
     */
    static function getStringContainer($string = '', $multi_byte = null)
    {
        if (is_null($multi_byte))
            $mb = Dune_Parameters::$multiByte;
        else 
            $mb = $multi_byte;
        if ($mb)
            return new Dune_String_ContainerMB($string, self::$multiByteCharset);
        else 
            return new Dune_String_Container($string);
    }

    /**
     * Возвращает объект трансформирования строки.
     *
     * @var string $string
     * @var boolean $multi_byte
     * @return Dune_String_Transform
     */
    static function getStringTransform($string = '', $multi_byte = null)
    {
        if (is_null($multi_byte))
            $mb = Dune_Parameters::$multiByte;
        else 
            $mb = $multi_byte;
        if ($mb)
            return new Dune_String_TransformMB($string, self::$multiByteCharset);
        else 
            return new Dune_String_Transform($string);

    }

}