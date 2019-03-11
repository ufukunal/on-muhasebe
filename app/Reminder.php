<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    static function FaturaHatirlatici()
    {
        $returnArray = [];
        if(Fatura::count() != 0){
            $list = Fatura::all();
            foreach ($list as $k => $v) {
                if($v['faturaTipi'] == 0){
                    //GELİR FATURASI
                    $c = Islem::where('type', ISLEM_TAHSILAT)->where('faturaId', $v['id'])->count();
                    $type = "Gelir Faturası";
                    $uri = route('islem.create', ['type' => ISLEM_TAHSILAT]);
                } else {
                    //GİDER FATURASI
                    $c = Islem::where('type', ISLEM_ODEME)->where('faturaId', $v['id'])->count();
                    $type = "Gider Faturası";
                    $uri = route('islem.create', ['type' => ISLEM_ODEME]);
                }
                if($c == 0){
                    $returnArray[$k]['name'] = $v['faturaNo']." - ".$type;
                    $returnArray[$k]['musteriId'] = $v['musteriId'];
                    $returnArray[$k]['fiyat'] = Fatura::getTotal($v['id']);
                    $returnArray[$k]['uri'] = $uri;
                }
            }
        }

        return $returnArray;
    }
}
