<?php
abstract class Data_Edinstvo_Hypothec
{
    static public $hypothec = array();
    static public $prepared = false;
    static public $leftMenu = array();
    
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
                                         'ALL'       => 'Любые',
                                         'ANNUIT'    => 'Аннуитетные',
                                         'DIFF'    => 'Дифференцированные',
                                         'OTHER'    => 'Особые условия',
                                         );
        
        // Платежи
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
        
        self::$leftMenu = array(
                                      array(
                                      'name' => 'Начало',
                                      'code' => 'main'
                                      ),
                                      array(
                                      'name' => 'Ипотечные банки',
                                      'code' => 'ShowAllBanks'
                                      ),
                                      array(
                                      'name' => 'Ипотечные программы',
                                      'code' => 'ShowAllPrograms'
                                      ),
                                      
                                      array(
                                      'name' => 'Статьи',
                                      'code' => 'articles'
                                      )
                              

                                 );
            self::$prepared = true;
        }
    }
}