<?php

class Module_Map_HitDistrictPlus extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

   $this->setResult('district', null);
   $this->setResult('success', false);
   $this->setResult('message', 'Самое начало');

			$xPoint = $this->x;
			$yPoint = $this->y;
			// Сразу отсеиваем то, что не в Рязани
			if (   $yPoint < 39.47662353515625 
			    or $xPoint < 54.493972369468295
			    
			    or $yPoint > 40.01220703125
			    or $xPoint > 54.730964378350336
			     )
			
			{
			    $this->setResult('message', 'За пределпми Рязани.');
			    return;
			}

try {
			
foreach (Special_Vtor_Districts::$listContour as $id => $xy)
{
    $total = count($xy);
    if ($total < 2 )
        continue;
//    echo '0';
			
//  $xNull = 40.89111328125;
//	$yNull = 55.49130362820422;
	
    $yNull = 40.89111328125;
	$xNull = 55.49130362820422;
	
	$counterCrossing = 0;
			
			// Пробегаем массив области
			$aPoint = $bPoint = $cPoint = $dPoint = null;
			$d0 = $d1 = $d2 = null;
			
			$xCrossingPoint = $yCrossingPoint = null;
            $total_minus = $total - 1;
		    for($i = 0; $i < $total_minus; $i++){
		        
		        $ip = $i + 1;
				$aPoint = $xy[$i][1];
				$bPoint = $xy[$i][0];
         	    $cPoint = $xy[$ip][1];
 		        $dPoint = $xy[$ip][0];

				$aPoint = $xy[$i][0];
				$bPoint = $xy[$i][1];
        	    $cPoint = $xy[$ip][0];
		        $dPoint = $xy[$ip][1];
 		        
 		        
				$d0 = ($yNull - $yPoint) * ($cPoint - $aPoint) - ($xNull - $xPoint) * ($dPoint - $bPoint);
				$d1 = ($xNull * $yPoint - $xPoint * $yNull) * ($cPoint - $aPoint) - ($cPoint * $bPoint - $aPoint * $dPoint) * ($xNull - $xPoint);
				$d2 = ($yNull - $yPoint) * ($cPoint * $bPoint - $aPoint * $dPoint) - ($dPoint - $bPoint) * ($xNull * $yPoint - $xPoint * $yNull);
				if($d0 == 0)
				 {
				     continue; //alert ('Кризисная ситуация!');
				 }
				else {
					$xCrossingPoint = abs($d1 / $d0);
					$yCrossingPoint = abs($d2 / $d0);
					
					
//					$crossPoint = new GLatLng(yCrossingPoint, xCrossingPoint);
//					map.addOverlay(createMarker(crossPoint));
				//	debugger;
					
				$aPoint = $xy[$i][0];
				$bPoint = $xy[$i][1];
        	    $cPoint = $xy[$ip][0];
		        $dPoint = $xy[$ip][1];
				
				$raz = $cPoint - $aPoint;
				    if ($raz == 0)
				        $raz = 0.0000001;
				    
				        
					$k = -($bPoint - $dPoint) / ($raz);
					if ($k < 0) { 
						if (($aPoint < $cPoint))
						{
							if (($xCrossingPoint < $cPoint) && ($xCrossingPoint > $aPoint) 
							                                && ($yCrossingPoint < $bPoint) 
							                                && ($yCrossingPoint > $dPoint)  
							                                && ($xCrossingPoint > $xPoint)
							                                && ($xCrossingPoint < $xNull) 
							                                && ($yCrossingPoint > $yPoint) 
							                                && ($yCrossingPoint < $yNull))
							{
								$counterCrossing++;
							}
						}
						else
						{
							if (($xCrossingPoint > $cPoint) && ($xCrossingPoint < $aPoint) 
							                                && ($yCrossingPoint > $bPoint) 
							                                && ($yCrossingPoint < $dPoint) 
							                                && ($xCrossingPoint > $xPoint)
							                                && ($xCrossingPoint < $xNull) 
							                                && ($yCrossingPoint > $yPoint) 
							                                && ($yCrossingPoint < $yNull))
						    {
						      $counterCrossing++;
							}
						}
					}
					else
					{
						if (($aPoint < $cPoint) && ($xCrossingPoint > $xPoint)
						                        && ($xCrossingPoint < $xNull) 
						                        && ($yCrossingPoint > $yPoint) 
						                        && ($yCrossingPoint < $yNull))
						 {
							if (($xCrossingPoint < $cPoint) && ($xCrossingPoint > $aPoint) 
							                                && ($yCrossingPoint > $bPoint) 
							                                && ($yCrossingPoint < $dPoint) 
							                                && ($xCrossingPoint > $xPoint)
							                                && ($xCrossingPoint < $xNull) 
							                                && ($yCrossingPoint > $yPoint) 
							                                && ($yCrossingPoint < $yNull))
							{
						      $counterCrossing++;
							}
						}
						else
						{
							if (($xCrossingPoint > $cPoint) && ($xCrossingPoint < $aPoint) 
							                                && ($yCrossingPoint < $bPoint) 
							                                && ($yCrossingPoint > $dPoint)
							                                && ($xCrossingPoint > $xPoint)
							                                && ($xCrossingPoint < $xNull) 
							                                && ($yCrossingPoint > $yPoint) 
							                                && ($yCrossingPoint < $yNull))
							{
						      $counterCrossing++;
							}
						}
					}
				
				}
			}
//			echo '-', $counterCrossing, '-'; 
	        if ($counterCrossing % 2 == 1)
	        {
			    $good = true; //alert("Попал!!!");
			    $this->setResult('district', $id);
			    $this->setResult('success', true);
			    throw new Dune_Exception_Control('Нашли', $id);
	        }
			else
			{
				$good = false;  //alert("Мимо))");
			}
}

$this->setResult('message', 'Не нашли');
}
catch (Dune_Exception_Control $e)
{
    $this->setResult('message', 'Нашли');
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    