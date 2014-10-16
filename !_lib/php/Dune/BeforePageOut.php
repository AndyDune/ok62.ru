<?php
/**
 * Статический класс. Содержит методы для осущ. действий перед выводом стриницы.
 * 
 * Дейcтвия:
 * --------------------
 * 1) Регистрирует объект с присвоением ему ключа.
 *    При вызове метода обходит все оюъекты и вызывает метод doBeforePageOut()
 * 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: BeforePageOut.php                           |
 * | В библиотеке: Dune/BeforePageOut.php              |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.01                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 * 
 * 
 * История версий:
 * -----------------
 * Версия 1.00 -> 1.01
 * Указан интерфейс, реализуемый объектом
 *
 */
class Dune_BeforePageOut
{
    static private $objects = array();
    
    /**
     * Регистрация объекта с присвоением ему ключа.
     *
     * Можно не указывать ключ - объект будет зарегистрирован с ключём по умолчанию
     * 
     * @param string $key ключ для объекта.
     * @param object $object объект
     */
    static public function registerObject(Dune_Interface_BeforePageOut $object, $key = false)
    {
        if ($key === false)
            self::$objects[] = $object;
        else 
        {
             if (!is_string($key))
                $key = (string)$key;
             if (!key_exists($key, self::$objects))
             {
                self::$objects[$key] = $object;
             }
        }
    }

    /**
     * Выполнение действий.
     *
     */
    static public function make()
    {
        if (count(self::$objects) > 0)
        {
            foreach (self::$objects as $val)
            {
                $val->doBeforePageOut();
            }
        }
    }
    
    
}