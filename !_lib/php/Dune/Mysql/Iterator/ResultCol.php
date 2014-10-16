<?php
/**
 * Ğåçóëüòàò âûïîëíåíèÿ çàïğîñà (èòåğàòîğ).
 * Èòåğàòîğ ñ ìàññîâîì ïî îäíîìó ñòîëáöó â ğåçóëüòàòå çàïğîñà.
 * 
 * -------------------------------------------------------
 * | Áèáëèîòåêà: Dune                                     |
 * | Ôàéë: ResultCol.php                                  |
 * | Â áèáëèîòåêå: Dune/Mysql/Iterator/ResultCol.php     |
 * | Àâòîğ: Àíäğåé Ğûæîâ (Dune) <dune@rznlf.ru>           |
 * | Âåğñèÿ: 1.00                                         |
 * | Ñàéò: www.rznlf.ru                                   |
 * -------------------------------------------------------
 *
 */

class Dune_Mysqli_Iterator_ResultCol extends Dune_Mysql_Iterator_Parent_Result
{
    protected function getEl()
    {
        $r = mysql_fetch_row($this->result);
        return $r[0];
    }
}
