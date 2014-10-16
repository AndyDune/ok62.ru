<?php
/**
 * 
 * 
 */
abstract class Special_Vtor_Types
{
    
    static public $typesToRequest = array(
                                        1 => array('id' => 1,
                                                   'code'=>'room',
                                                   'name'   => '��������',
                                                   'nameTo' => '��������',
                                                   'nameOf' => '��������',
                                                   ),
                                        2 => array('id' => 2,
                                                   'code'=>'house',
                                                   'name'   => '���',
                                                   'nameTo' => '���',
                                                   'nameOf' => '����',
                                                   ),
                                                   
                                        3 => array('id' => 3,
                                                   'code'=>'garage',
                                                   'name'   => '�����',
                                                   'nameTo' => '�����',
                                                   'nameOf' => '������',
                                                   ),
                                        4 => array('id' => 4,
                                                   'code'=>'nolife',
                                                   'name'   => '������������ ������������',
                                                   'nameTo' => '������������ ������������',
                                                   'nameOf' => '������������ ������������',
                                                   ),
                                        5 => array('id' => 5,
                                                   'code'=>'pantry',
                                                   'name'   => '�������� ���������',
                                                   'nameTo' => '�������� ���������',
                                                   'nameOf' => '��������� ���������',
                                                   ),
                                        6 => array('id' => 6,
                                                   'code'=>'land',
                                                   'name'   => '��������� �������',
                                                   'nameTo' => '��������� �������',
                                                   'nameOf' => '���������� �������',
                                                   ),
                                        7 => array('id' => 7,
                                                   'code'=>'cottage',
                                                   'name'   => '�������',
                                                   'nameTo' => '�������',
                                                   'nameOf' => '��������',
                                                   ),
                                     );
    
    static public function getTypeCode($id)
    {
        if (isset(self::$typesToRequest[$id]))
            return self::$typesToRequest[$id]['code'];
        else 
            return null;
    }
                                     
}