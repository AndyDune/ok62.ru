<?php
abstract class Data_Edinstvo_Hypothec
{
    static public $hypothec = array();
    static public $prepared = false;
    static public $leftMenu = array();
    
    static public $programsMaster = array();
    static public $programsMasterAllow = array();
    
    /**
     * �����-����������� "������� ������"
     *
     * @var array
     */
    static public $crumb = array();
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

        // ������ ������� �� ������
        self::$hypothec['currencyid_rus'] = array(
                                'ALL' => '�����',
                                'RUR' => '�����',
                                'USD' => '������� ���',
                                'EUR' => '����',
                                );

        // ������ ������� �� ������
        self::$hypothec['currencyid_rus_rus'] = array(
                                'RUR' => '�����',
                                'USD' => '������� ���',
                                'EUR' => '����',
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

                                         
        // ������������� ������ � �������
        // 'NOTREQUIRED','ANY','2NDFL','3NDFL','HISTORY','FREEFORM','BANKFORM','OTCH','VERBAL','WHATEVER'
        self::$hypothec['incconfirmid'] = array(
                                         'ANY'          => '�����',
                                         'NOTREQUIRED'  => '�� ���������',                                         
                                         '2NDFL'        => '2-����',
                                         '3NDFL'        => '3-����',
                                         'HISTORY'      => '��������� �������',
                                         'FREEFORM'     => '������� � ��������� �����',
                                         'BANKFORM'     => '������� �� ����� �����',
                                         'OTCH'         => '�������������� ���������� ���������������',
                                         'VERBAL'       => '����� �������������',
                                         'WHATEVER'     => '������'
                                         );
                                         
        // ���� ������������ �� �������
        // 'NOLIMIT','VTOR','NOCITYALL','NOCITYVTOR','NOCITYNEW','HYP','PAWNSHOP','NEW','REFINANCING','IMPROVE'
        self::$hypothec['kinds'] = array(
                                         'NOLIMIT'      => '��� �����������',
                                         'VTOR'         => '��������� �����',
                                         'NOCITYALL'    => '���������� ������������(���)',
                                         'NOCITYVTOR'   => '���������� ������������(��������� �����)',
                                         'NOCITYNEW'    => '���������� ������������(��������� �����)',
                                         'HYP'          => '������������ �������',
                                         'PAWNSHOP'     => '���������� ������������',
                                         'NEW'          => '�����������',
                                         'REFINANCING'  => '����������������',
                                         'IMPROVE'      => '��������� �������� �������',
                                         'ROOM'         => '�������',
                                         'REMONT'       => '������ �����',
                                         'EARTH'        => '�����',
                                         'NOAIM'        => '��������� �����'
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
                                         'ALL'     => '�����',
                                         'ANNUIT'  => '�����������',
                                         'DIFF'    => '������������������',
                                         'OTHER'   => '������ �������',
                                         );
        
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
        self::$hypothec['guarantor'] = array(
                                         0      => '�� ��������',
                                         1      => '��������� (1 ����������)',
                                         2      => '���������',
                                         3      => '���������',
                                         4      => '���������',
                                         );
                                         
                                        
                                         
                                         
        self::$programsMasterAllow = array(
        'age' => '������� ��������',
        'registration' => '����������� �� ����� ��������� �������',
        'nationality' => '����������� ��',
        'sumcredit' => '����� �������',
        'creditperiod' => '���� �������',
        'currencyid' => '������',
        'firstpayment' => '�������������� �����',
        'rate' => '������ �������',
        'paymenttypeid' => '�������',
        'advrepay' => '��������� ��������� ��� �������. ������.',
        'approveperiod' => '���� ������������ ������.',
        'bank_id' => '����.',
        'kinds' => '����.',
        'incconfirmid'=> '������������� ������',
        'monthpay'=> '����������� ������ '

        );
                                                 
/*        self::$programsMaster1 = array(
        1 => array(
                    'name' => '���������� � ��������',
                    'form' => array('age')
                ),
        
        2 => array(
                    'name' => '���������� � ��������',
                    'form' => array('registration', 'nationality')
                ),
        3 => array(
                    'name' => '������ �������',
                    'form' => array('sumcredit')
                ),
                
        4 => array(
                    'name' => '������� �������',
                    'form' => array('creditperiod', 'currencyid', 'firstpayment')
                ),
        5 => array(
                    'name' => '����',
                    'form' => array('bank_id', 'kinds', 'incconfirmid')
                ),
                
        );
*/
        self::$programsMaster = array(
        1 => array(
                    'name' => '������� ��������',
                    'form' => array('age')
                ),
        2 => array(
                    'name' => '������ ������������� �������',
                    'form' => array('incconfirmid')
                ),
        
        3 => array(
                    'name' => '��������� �������, ����� ������������� ������, ������',
                    'form' => array('sumcredit', 'firstpayment', 'currencyid')
                ),
                
        4 => array(
                    'name' => '����������� ������',
                    'form' => array('monthpay')
                ),
        5 => array(
                    'name' => '���������� � ��������',
                    'form' => array( 'nationality', 'registration')
                ),
                
        );
        
        
        self::$leftMenu = array(
/*                                      array(
                                      'name' => '������',
                                      'code' => ''
                                      ),
*/                                      array(
                                      'name' => '�����',
                                      'code' => 'ShowAllBanks'
                                      ),
                                      array(
                                      'name' => '��������� ���������',
                                      'code' => 'ShowAllPrograms'
                                      ),
                                      array(
                                      'name' => '������ ������� ��������� ���������',
                                      'code' => 'MasterForProgram'
                                      ),
                                      array(
                                      'name' => '�����',
                                      'code' => 'SearchPrograms'
                                      ),
                                      array(
                                      'name' => '��������� ������',
                                      'code' => 'Calculation'
                                      ),
                                      
/*                                      array(
                                      'name' => '������',
                                      'code' => 'Articles'
                                      ),
                                      array(
                                      'name' => '���������',
                                      'code' => 'Glossary'
                                      ), */
                                      array(
                                      'name' => '<B>�������� �������</B>',
                                      'code' => 'Privilege'
                                      ),
                              

                                 );
            self::$prepared = true;
        }
    }
    
    static function getOneGlossary($id, $array)
    {
        $text = '';
        if (isset($array[$id]))
        {
            $text = '<a class="tt" href="/modules.php?name=Hypothec&op=Glossary#' . $id . '" title="' . $array[$id]['notice'] . '">(?)</a>';
        }
        return $text;
    }
    
}