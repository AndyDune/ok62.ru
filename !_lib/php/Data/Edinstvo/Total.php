<?php
abstract class Data_Edinstvo_Hypothec
{
    static public $hypothec = array();
    static public $prepared = false;
    static public $leftMenu = array();
    
// ���� ������������
    static public function prepare()
    {
        if (!self::$prepared)
        {
        self::$hypothec['goalid'] = array(
                                'ALL'       => '�����',
                                'ROOM'      => '������� �������',
                                'FLAT'      => '������� ��������',
                                'HOUSE'     => '������� ����',
                                'LAND'      => '������� �����',
                                'IMPROVE'   => '��������� �������� �������',
                                'REPAIR'    => '������ �����',
                                'REFINANCE' => '����������������',
                                'NOPURPOSE' => '��������� ������'
                                );
        
        // ����� ������������
        self::$hypothec['marketid'] = array(
                                'ALL'      => '�����',
                                "FIRST"  => '���������',
                                "SECOND" => '���������'
                                );              
        
        // ������ �������
        self::$hypothec['currencyid'] = array(
                                'ALL' => '�����',
                                'RUR' => 'RUR',
                                'USD' => 'USD',
                                'EUR' => 'EUR',
                                );
                            
        // �������� �������
        self::$hypothec['currency'] = array(
                                'RUR' => '���.',
                                'USD' => '����.',
                                'EUR' => '����',
                                'PERCENT' => '%'
                                );
        
                                
        // ��� ������ �������
        self::$hypothec['typerateid'] = array(
                                'ALL'       => '�����',
                                'ABS'       => '���������� ������',
                                'LIBOR'     => '%+LIBOR',
                                'MOSPRIME'  => '%+MOSPRIME �� 3 ������',
                                'CBRF'      => '%+������ ���������������� �� ��',
                                'TIBOR'     => '%+Euroyen TIBOR �� 12 �������'
                                );
        
        
        // ����������� �������
        self::$hypothec['loansecurityid'] = array(
                                             'ALL'      => '�����',
                                             'NEW'      => '������������� ������������',
                                             'OWN'      => '��������� ������������',
                                             'OTHER'    => '������ �������',
                                           );
        
        // ������������� ������
        self::$hypothec['incconfirmid'] = array(
                                         'ALL'           => '�����',
                                         'OFFICIAL'      => '������������ �����������',
                                         'UNOFFICIAL'    => '�������� �� ����� �����',
                                         'VERBAL'        => '����� �������������',
                                         'NOTREQUIRED'   => '�� ���������'
                                         );
        
        // ����������� �� ����� ��������� �������
        self::$hypothec['registration'] = array(
                                        'ALL'            => '�� �����',
                                        'REQUIRED'       => '���������',
                                        'NOTREQUIRED'    => '�� ���������'
                                         );
        
        // ����������� ��
        self::$hypothec['nationality'] = array(
                                         'ALL'            => '�� �����',
                                         'REQUIRED'       => '���������',
                                         'NOTREQUIRED'    => '�� ���������'
                                         );
        
        // �������
        self::$hypothec['paymenttypeid'] = array(
                                         'ALL'       => '�����',
                                         'ANNUIT'    => '�����������',
                                         'DIFF'    => '������������������',
                                         'OTHER'    => '������ �������',
                                         );
        
        // �������
        // 'DAY', 'WEEK', 'MONTH', 'QUARTER','YEAR','ONCE'
        self::$hypothec['periodicity'] = array(
                                         'DAY'        => '����������',
                                         'WEEK'       => '������������',
                                         'MONTH'      => '�����������',
                                         'QUARTER'    => '��������������',
                                         'YEAR'       => '���������',
                                         'ONCE'       => '�������'
                                         );
        self::$hypothec['soborrower'] = array(
                                         'YES'      => '���������',
                                         'NO'       => '�� ���������'
                                         );
        
        self::$leftMenu = array(
                                      array(
                                      'name' => '������',
                                      'code' => 'main'
                                      ),
                                      array(
                                      'name' => '��������� �����',
                                      'code' => 'ShowAllBanks'
                                      ),
                                      array(
                                      'name' => '��������� ���������',
                                      'code' => 'ShowAllPrograms'
                                      ),
                                      
                                      array(
                                      'name' => '������',
                                      'code' => 'articles'
                                      )
                              

                                 );
            self::$prepared = true;
        }
    }
}