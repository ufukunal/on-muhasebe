<?php

namespace App\Http\Controllers\front\fatura;

use App\FaturaIslem;
use App\Logger;
use App\Musteriler;
use App\Fatura;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class indexController extends Controller
{
    public function index()
    {
        return view('front.fatura.index');
    }

    public function create($type)
    {
        if($type == 0){
            return view('front.fatura.gelir.create');
        } else {
            return view('front.fatura.gider.create');
        }
    }

    public function store(Request $request)
    {
        $type = $request->route('type');
        $all = $request->except('_token');
        $islem = $all['islem'];
        unset($all['islem']);
        $all['faturaTipi'] = $type;
        $c = Fatura::where('faturaNo', $all['faturaNo'])->count();
        if($c == 0){
            $create = Fatura::create($all);
            if($create){
                if($type == FATURA_GELIR){
                    Logger::Insert("Gelir faturası eklendi.", "Fatura");
                } else {
                    Logger::Insert("Gider faturası eklendi.", "Fatura");
                }
                if(count($islem) != 0) {
                    foreach ($islem as $k => $v) {
                        $islemArray = [
                            'faturaId' => $create->id,
                            'kalemId' => $v['kalemId'],
                            'urunId' => $v['urunId'],
                            'miktar' => $v['gun_adet'],
                            'fiyat' => $v['tutar'],
                            'kdv' => $v['kdv'],
                            'araToplam' => $v['toplam_tutar'],
                            'kdvToplam' => $v['kdv_toplam'],
                            'genelToplam' => $v['genel_toplam'],
                            'text' => $v['text']
                        ];
                        FaturaIslem::create($islemArray);
                    }
                }
                return redirect()->back()->with('status', 'Fatura Eklendi.');
            } else {
                return redirect()->back()->with('status', 'Fatura Eklenemedi.');
            }
        } else {
            return redirect()->back()->with('error', 'Bu Fatura Mevcut!');
        }
    }

    public function edit($id)
    {
        $c = Fatura::where('id', $id)->count();
        if($c != 0){
            $data = Fatura::where('id', $id)->get();
            $dataIslem = FaturaIslem::where('faturaId', $id)->get();

            if($data[0]['faturaTipi'] == 0){
                return view('front.fatura.gelir.edit', ['data' => $data, 'dataIslem' => $dataIslem]);
                //gelir
            } else {
                return view('front.fatura.gider.edit', ['data' => $data, 'dataIslem' => $dataIslem]);
                //gider
            }
        } else {
            return redirect('/');
        }
    }

    public function update(Request $request)
    {
        $id = $request->route('id');
        $c = Fatura::where('id', $id)->count();
        if($c != 0){
            $all = $request->except('_token');
            $islem = $all['islem'];
            unset($all['islem']);

            $data = Fatura::where('id', $id)->get();

            if($data[0]['faturaTipi'] == FATURA_GELIR){
                Logger::Insert($data[0]['faturaNo']." numaralı gelir faturası düzenlendi.", "Fatura");
            } else {
                Logger::Insert($data[0]['faturaNo']." numaralı gider faturası düzenlendi.", "Fatura");
            }

            if(count($islem) != 0){

                FaturaIslem::where('faturaId', $id)->delete();

                foreach ($islem as $k => $v){
                    $islemArray = [
                        'faturaId' => $id,
                        'kalemId' => $v['kalemId'],
                        'urunId' => $v['urunId'],
                        'miktar' => $v['gun_adet'],
                        'fiyat' => $v['tutar'],
                        'kdv' => $v['kdv'],
                        'araToplam' => $v['toplam_tutar'],
                        'kdvToplam' => $v['kdv_toplam'],
                        'genelToplam' => $v['genel_toplam'],
                        'text' => $v['text']
                    ];
                    FaturaIslem::create($islemArray);
                }
            }


            $update = Fatura::where('id', $id)->update($all);
            return redirect()->back()->with('status', 'Düzenleme işlemi başarılı');

        } else {
            return redirect('/');
        }
    }

    public function delete($id)
    {
        $c = Fatura::where('id', $id)->count();
        if($c != 0) {
            $data = Fatura::where('id', $id)->get();
            Logger::Insert($data[0]['faturaNo']." numaralı fatura silindi.", "Fatura");
            Fatura::where('id',$id)->delete();
            FaturaIslem::where('faturaId',$id)->delete();
            return redirect()->back();
        } else {
            return redirect('/');
        }
    }

    public function data(Request $request)
    {
        $table = Fatura::query();
        $data = DataTables::of($table)
            ->addColumn('edit', function ($table){
                return '<a href="'.route('fatura.edit', ['id' => $table->id ]).'">Düzenle</a>';
            })
            ->addColumn('delete', function ($table){
                return '<a href="'.route('fatura.delete', ['id' => $table->id ]).'">Sil</a>';
            })
            ->addColumn('musteri', function ($table){
                return Musteriler::getPublicName($table->musteriId);
            })
            ->editColumn('faturaTipi', function ($table){
                if($table->faturaTipi == 0) { return "Gelir"; } else { return "Gider"; }
            })
            ->rawColumns(['edit', 'delete'])
            ->make(true);
        return $data;
    }

}
