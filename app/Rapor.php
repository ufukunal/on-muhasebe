<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rapor extends Model
{
    static function getOdeme()
    {
        return Islem::where('type', 0)->sum('fiyat');
    }

    static function getTahsilat()
    {
        return Islem::where('type', 1)->sum('fiyat');
    }

    static function getMusteriOdeme($id)
    {
        $fatura = FaturaIslem::leftJoin('faturas', 'fatura_islems.faturaId', '=', 'faturas.id')
            ->where('faturas.musteriId', $id)
            ->where('faturas.faturaTipi', FATURA_GIDER)
            ->sum('fatura_islems.genelToplam');

        $islem = Islem::where('musteriId', $id)->where('type', ISLEM_ODEME)->sum('fiyat');
        return $fatura - $islem;
    }

    static function getMusteriTahsilat($id)
    {
        $fatura = FaturaIslem::leftJoin('faturas', 'fatura_islems.faturaId', '=', 'faturas.id')
            ->where('faturas.musteriId', $id)
            ->where('faturas.faturaTipi', FATURA_GELIR)
            ->sum('fatura_islems.genelToplam');

        $islem = Islem::where('musteriId', $id)->where('type', ISLEM_TAHSILAT)->sum('fiyat');
        return $fatura - $islem;
    }

    static function getMusteriBakiye($id)
    {
        return self::getMusteriOdeme($id) - self::getMusteriTahsilat($id);
    }
}
