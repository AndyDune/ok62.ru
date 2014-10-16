<?php
/**
 * Dune Framework
 * 
 * ������� ������� ��� �������-������� ����������� ������� ������ �� ��������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Factory.php                                 |
 * | � ����������: Dune/String/Factory.php             |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 0.05                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 *  0.05 (2009 ��� 14)
 *  ����� ����� getStringTransform()
 * 
 *  0.04 (2009 ������ 27)
 *  ����� ������-������� ��� �������� ������.
 *  ���������� �� ������������ ��������� ������� �� ������ Dune_Parameters.
 * 
 */

abstract class Dune_String_Factory
{
    static $multiByte = null;
    static $multiByteCharset = 'UTF-8';
    
    /**
     * ���������� ������-��������� ������ � ��������� ������ � ���.
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
     * ���������� ������ ����������������� ������.
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