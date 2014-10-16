<?php
abstract class Data_Edinstvo_Hypothec
{
    static public $hypothec = array();
    static public $prepared = false;
    static public $leftMenu = array();
    
    static public $programsMaster = array();
    static public $programsMasterAllow = array();
    
    /**
     * Масив-еакопитьель "хлебных крошек"
     *
     * @var array
     */
    static public $crumb = array();
// Цель кредитования
    static public function prepare()
    {
        if (!self::$prepared)
        {
        self::$hypothec['goalid'] = array(
                                'ALL'       => 'Любая',
                                'ROOM'      => 'Покупка комнаты',
                                'FLAT'      => 'Покупка квартиры',
                                'HOUSE'     => 'Покупка дома',
                                'LAND'      => 'Покупка земли',
                                'IMPROVE'   => 'Улучшение жилищных условий',
                                'REPAIR'    => 'Ремонт жилья',
                                'REFINANCE' => 'Перекредитование',
                                'NOPURPOSE' => 'Нецелевой кредит'
                                );
        
        // Рынок недвижимости
        self::$hypothec['marketid'] = array(
                                'ALL'      => 'Любой',
                                "FIRST"  => 'Первичный',
                                "SECOND" => 'Вторичный'
                                );              
        
        // Валюта кредита
        self::$hypothec['currencyid'] = array(
                                'ALL' => 'Любая',
                                'RUR' => 'RUR',
                                'USD' => 'USD',
                                'EUR' => 'EUR',
                                );

        // Валюта кредита по русски
        self::$hypothec['currencyid_rus'] = array(
                                'ALL' => 'Любая',
                                'RUR' => 'Рубли',
                                'USD' => 'Доллары США',
                                'EUR' => 'Евро',
                                );

        // Валюта кредита по русски
        self::$hypothec['currencyid_rus_rus'] = array(
                                'RUR' => 'Рубли',
                                'USD' => 'Доллары США',
                                'EUR' => 'Евро',
                                );
                                
        // Денежные единицы
        self::$hypothec['currency'] = array(
                                'RUR' => 'руб.',
                                'USD' => 'долл.',
                                'EUR' => 'евро',
                                'PERCENT' => '%'
                                );
        
                                
        // Тип ставки кредита
        self::$hypothec['typerateid'] = array(
                                'ALL'       => 'Любой',
                                'ABS'       => 'Абсолютная ставка',
                                'LIBOR'     => '%+LIBOR',
                                'MOSPRIME'  => '%+MOSPRIME за 3 месяца',
                                'CBRF'      => '%+ставка рефинансирования ЦБ РФ',
                                'TIBOR'     => '%+Euroyen TIBOR за 12 месяцев'
                                );
        
        
        // Обеспечение кредита
        self::$hypothec['loansecurityid'] = array(
                                             'ALL'      => 'Любое',
                                             'NEW'      => 'Приобретаемая недвижимость',
                                             'OWN'      => 'Имеющаяся недвижимость',
                                             'OTHER'    => 'Особые условия',
                                           );
        
        // Подтверждение дохода
        self::$hypothec['incconfirmid'] = array(
                                         'ALL'           => 'Любое',
                                         'OFFICIAL'      => 'Официальными документами',
                                         'UNOFFICIAL'    => 'Справкой по форме банка',
                                         'VERBAL'        => 'Устно работодателем',
                                         'NOTREQUIRED'   => 'Не требуется'
                                         );

                                         
        // Подтверждение дохода в ВИННЕРЕ
        // 'NOTREQUIRED','ANY','2NDFL','3NDFL','HISTORY','FREEFORM','BANKFORM','OTCH','VERBAL','WHATEVER'
        self::$hypothec['incconfirmid'] = array(
                                         'ANY'          => 'Любое',
                                         'NOTREQUIRED'  => 'Не требуется',                                         
                                         '2NDFL'        => '2-НДФЛ',
                                         '3NDFL'        => '3-НДФЛ',
                                         'HISTORY'      => 'Кредитная история',
                                         'FREEFORM'     => 'Справка в свободной форме',
                                         'BANKFORM'     => 'Справка по форме банка',
                                         'OTCH'         => 'Управленческая отчетность предпринимателя',
                                         'VERBAL'       => 'Устно работодателем',
                                         'WHATEVER'     => 'Другое'
                                         );
                                         
        // Виды кредитования по виннеру
        // 'NOLIMIT','VTOR','NOCITYALL','NOCITYVTOR','NOCITYNEW','HYP','PAWNSHOP','NEW','REFINANCING','IMPROVE'
        self::$hypothec['kinds'] = array(
                                         'NOLIMIT'      => 'Без ограничений',
                                         'VTOR'         => 'Вторичный рынок',
                                         'NOCITYALL'    => 'Загородная недвижимость(все)',
                                         'NOCITYVTOR'   => 'Загородная недвижимость(вторичный рынок)',
                                         'NOCITYNEW'    => 'Загородная недвижимость(первичный рынок)',
                                         'HYP'          => 'Коммерческая ипотека',
                                         'PAWNSHOP'     => 'Ломбардное кредитование',
                                         'NEW'          => 'Новостройки',
                                         'REFINANCING'  => 'Рефинансирование',
                                         'IMPROVE'      => 'Улучшение жилищных условий',
                                         'ROOM'         => 'Комната',
                                         'REMONT'       => 'Ремонт жилья',
                                         'EARTH'        => 'Земля',
                                         'NOAIM'        => 'Нецелевой кредт'
                                         );
                                         
                                         
        // Регистрация по месту получения кредита
        self::$hypothec['registration'] = array(
                                        'ALL'            => 'Не важно',
                                        'REQUIRED'       => 'Требуется',
                                        'NOTREQUIRED'    => 'Не требуется'
                                         );
        
        // Гражданство РФ
        self::$hypothec['nationality'] = array(
                                         'ALL'            => 'Не важно',
                                         'REQUIRED'       => 'Требуется',
                                         'NOTREQUIRED'    => 'Не требуется'
                                         );
        
        // Платежи
        self::$hypothec['paymenttypeid'] = array(
                                         'ALL'     => 'Любые',
                                         'ANNUIT'  => 'Аннуитетные',
                                         'DIFF'    => 'Дифференцированные',
                                         'OTHER'   => 'Особые условия',
                                         );
        
        // 'DAY', 'WEEK', 'MONTH', 'QUARTER','YEAR','ONCE'
        self::$hypothec['periodicity'] = array(
                                         'DAY'        => 'Ежедневный',
                                         'WEEK'       => 'Еженедельный',
                                         'MONTH'      => 'Ежемесячный',
                                         'QUARTER'    => 'Ежеквартальный',
                                         'YEAR'       => 'Ежегодный',
                                         'ONCE'       => 'Разовый'
                                         );
        self::$hypothec['soborrower'] = array(
                                         'YES'      => 'Допустимо',
                                         'NO'       => 'Не допустимо'
                                         );
        self::$hypothec['guarantor'] = array(
                                         0      => 'Не требутся',
                                         1      => 'Требуется (1 поручитель)',
                                         2      => 'Требуется',
                                         3      => 'Требуется',
                                         4      => 'Требуется',
                                         );
                                         
                                        
                                         
                                         
        self::$programsMasterAllow = array(
        'age' => 'Возраст заемщика',
        'registration' => 'Регистрация по месту получения кредита',
        'nationality' => 'Гражданство РФ',
        'sumcredit' => 'Сумма кредита',
        'creditperiod' => 'Срок кредита',
        'currencyid' => 'Валюта',
        'firstpayment' => 'Первоначальный взнос',
        'rate' => 'Ставка кредита',
        'paymenttypeid' => 'Платежи',
        'advrepay' => 'Досрочное погашение без санкций. Месяцы.',
        'approveperiod' => 'Срок рассмотрения заявки.',
        'bank_id' => 'Банк.',
        'kinds' => 'Банк.',
        'incconfirmid'=> 'Подтверждение дохода',
        'monthpay'=> 'Ежемесячный платеж '

        );
                                                 
/*        self::$programsMaster1 = array(
        1 => array(
                    'name' => 'Требования к заемщику',
                    'form' => array('age')
                ),
        
        2 => array(
                    'name' => 'Требования к заемщику',
                    'form' => array('registration', 'nationality')
                ),
        3 => array(
                    'name' => 'Размер кредита',
                    'form' => array('sumcredit')
                ),
                
        4 => array(
                    'name' => 'Условия кредита',
                    'form' => array('creditperiod', 'currencyid', 'firstpayment')
                ),
        5 => array(
                    'name' => 'Банк',
                    'form' => array('bank_id', 'kinds', 'incconfirmid')
                ),
                
        );
*/
        self::$programsMaster = array(
        1 => array(
                    'name' => 'Возраст заемщика',
                    'form' => array('age')
                ),
        2 => array(
                    'name' => 'Способ подтверждения доходов',
                    'form' => array('incconfirmid')
                ),
        
        3 => array(
                    'name' => 'Стоимость объекта, сумма первоначально взноса, валюта',
                    'form' => array('sumcredit', 'firstpayment', 'currencyid')
                ),
                
        4 => array(
                    'name' => 'Ежемесячный платеж',
                    'form' => array('monthpay')
                ),
        5 => array(
                    'name' => 'Требования к заемщику',
                    'form' => array( 'nationality', 'registration')
                ),
                
        );
        
        
        self::$leftMenu = array(
/*                                      array(
                                      'name' => 'Начало',
                                      'code' => ''
                                      ),
*/                                      array(
                                      'name' => 'Банки',
                                      'code' => 'ShowAllBanks'
                                      ),
                                      array(
                                      'name' => 'Ипотечные программы',
                                      'code' => 'ShowAllPrograms'
                                      ),
                                      array(
                                      'name' => 'Мастер подбора ипотечной программы',
                                      'code' => 'MasterForProgram'
                                      ),
                                      array(
                                      'name' => 'Поиск',
                                      'code' => 'SearchPrograms'
                                      ),
                                      array(
                                      'name' => 'Ипотечный брокер',
                                      'code' => 'Calculation'
                                      ),
                                      
/*                                      array(
                                      'name' => 'Статьи',
                                      'code' => 'Articles'
                                      ),
                                      array(
                                      'name' => 'Глоссарий',
                                      'code' => 'Glossary'
                                      ), */
                                      array(
                                      'name' => '<B>Льготная ипотека</B>',
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