<?php
/**
 * Статический класс. Методы - фабрики для других классов.
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Factory.php                                 |
 * | В библиотеке: Dune/Factory.php                    |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.01                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 */
class Dune_Factory
{
    static $moduleClassFolder = 'default';
    
    /**
     * 
     *
     * @param string $name
     * @return Dune_Include_Abstract_Code
     */
    static function getModule($name)
    {
        return new $name;
    }
    
    
    
    
/////////////////////
////////////////////            Устаревшее не нужно  - в будущем - удалить.
////////////////////    
    /**
     * Массив содержим указатели на созданные фабрикой объекты.
     * Ключи - имена классов. 
     * Может использоваться модификатор - для создания нескольких экземпляров одного класса
     *
     * @var array
     */
    static $objectArray = array();
    /**
     * Метод возвращает указатель на класс.
     * Название класса указывается в первом параметре
     * 
     * Если такой объект указанного класса уже создан - возвращется его указатель (объект не создаётся)
     * 
     * Остальные параметры передаются конструктору создаваемого объекта
     * Максимальное чило параметров - 6 (включая имя класса)
     * 
     * В качестве 1-го параметра может быть передан массив, первый элемент которого (ключ 0) - имя класса
     *                                                      второй (ключ 1) - модификатор ключа в массиве $objectArray
     * Это позволяет создать несколько объектов с ограничением по числу реализаций
     * 
     * @return указатель на объект
     */
    static function singleObjectConstruct()
    {
        $numargs = func_num_args();
        if (!$numargs OR ($numargs > 6))
            throw new Exception('Предано неверное число параметров. Необходимо не более 6-ти и не менее 1-го');
        $args  = func_get_args();
        // Если передан массив - возможно сохдание следующего объекта уже созданного класса с модификатором указателя
        // Модификатор - строка, прибавляемая к имени класса
        if (is_array($args[0]))
        {
            $className = $args[0][0];
            $classKey = $args[0][0].$args[0][1];
        }
        else 
        {
            $className = $classKey = $args[0];
        }
        if (key_exists($classKey,self::$objectArray))
            return self::$objectArray[$classKey];
        // Передаём разное число параметров - метод не совсем красив - доработать
        switch ($numargs)
        {
            case 1:
                $object = new $className();
            break;
            case 2:
                $object = new $className($args[1]);
            break;
            case 3:
                $object = new $className($args[1],$args[2]);
            break;
            case 4:
                $object = new $className($args[1],$args[2],$args[3]);
            break;
            case 5:
                $object = new $className($args[1],$args[2],$args[3],$args[4]);
            break;                                                
            case 6:
                $object = new $className($args[1],$args[2],$args[3],$args[4],$args[5]);
            break;                                                
        }
        self::$objectArray[$classKey] = $object;
        return self::$objectArray[$classKey];
    }
    
    static function singleObjectDestruct()
    {
        $numargs = func_num_args();
        if (!$numargs OR ($numargs > 2))
            throw new Exception('Предано неверное число параметров. Необходимо не более 2-х и не менее 1-го');
        $args  = func_get_args();
        // Если передан массив - возможно сохдание следующего объекта уже созданного класса с модификатором указателя
        // Модификатор - строка, прибавляемая к имени класса
        if (is_array($args[0]))
        {
            $className = $args[0][0];
            $classKey = $args[0][0].$args[0][1];
        }
        else 
        {
            $className = $classKey = $args[0];
        }
        if (key_exists($classKey,self::$objectArray))
        {
            self::$objectArray[$classKey]->__destruct();
            unset(self::$objectArray[$classKey]);
            return true;
        }
        else 
        {
            if ($numargs > 1)
            {
                throw new Exception('Невозможно разрушить объект. Имя класса: '.$className.', Имя ключа для класса: '.$classKey);
            }
            else 
            {
                return false;
            }
        }
    }
}