<?php

namespace App\Http\Controllers\front\musteriler;

use App\FaturaIslem;
use App\Helper\fileUpload;
use App\Logger;
use App\Musteriler;
use App\Rapor;
use App\Islem;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class indexController extends Controller
{
    public function index()
    {
        return view('front.musteriler.index');
    }

    public function create()
    {
        return view('front.musteriler.create');
    }

    public function store(Request $request)
    {
        $all = $request->except('_token');
        $all['photo'] = fileUpload::newUpload(rand(1,9000), 'musteriler', $request->file(('photo')), 0);

        $create = Musteriler::create($all);
        if ($create) {
            Logger::Insert($all['ad']." müşterisi eklendi.", "Müşteriler");
            return redirect()->back()->with('status', 'Müşteri Başarı ile Eklendi.');
        } else {
            return redirect()->back()->with('status', 'Müşteri Eklenemedi.');
        }
    }

    public function edit($id)
    {
        $c = Musteriler::where('id', $id)->count();
        if($c != 0) {
            $data = Musteriler::where('id', $id)->get();
            return view('front.musteriler.edit',['data' => $data]);
        } else {
            return redirect('/');
        }
    }

    public function update(Request $request)
    {
        $id = $request->route('id');
        $c = Musteriler::where('id', $id)->count();
        if($c != 0) {
            $all = $request->except('_token');
            $data = Musteriler::where('id', $id)->get();
            $all['photo'] = fileUpload::changeUpload(rand(1,90000), "musteriler", $request->file('photo'),0, $data, "photo");
            $update = Musteriler::where('id', $id)->update($all);
            if($update){
                Logger::Insert($all['ad']." müşterisi düzenlendi.", "Müşteriler");
                return redirect()->back()->with('status', 'Müşteri Düzenlendi');
            } else {
                return redirect()->back()->with('status', 'Müşteri Düzenlenemedi');
            }
        } else {
            return redirect('/');
        }
    }
    public function delete($id)
    {
        $c = Musteriler::where('id', $id)->count();
        if($c != 0) {
            $data = Musteriler::where('id', $id)->get();
            fileUpload::directoryDelete($data[0]['photo']);
            Logger::Insert($data[0]['ad']." müşterisi silindi.", "Müşteriler");
            Musteriler::where('id', $id)->delete();
            return redirect()->back();

        } else {
            return redirect('/');
        }
    }

    public function data(Request $request)
    {
        $table = Musteriler::query();
        $data = DataTables::of($table)
            ->addColumn('edit', function ($table){
                return '<a href="'.route('musteriler.edit', ['id' => $table->id ]).'">Düzenle</a>';
            })
            ->addColumn('delete', function ($table){
                return '<a href="'.route('musteriler.delete', ['id' => $table->id ]).'">Sil</a>';
            })
            ->addColumn('publicname', function ($table){
                return Musteriler::getPublicName($table->id);
            })
            ->addColumn('bakiye',function ($table){
                $bakiye = Rapor::getMusteriBakiye($table->id);
                if($bakiye < 0){
                    return '<span style="color:red"> '.$bakiye.'</span>';
                } elseif($bakiye > 0){
                    return '<span style="color:green"> +'.$bakiye.'</span>';
                } else {
                    return $bakiye;
                }
            })
            ->editColumn('musteriTipi', function ($table){
                if($table->musteriTipi == 0) {
                    return "Bireysel";
                } else {
                    return "Kurumsal";
                }
            })
            ->addColumn('extre', function ($table){
                return '<a href="'.route('musteriler.extre', ['id' => $table->id ]).'">Extre</a>';
            })
            ->rawColumns(['edit', 'delete', 'bakiye', 'extre'])
            ->make(true);
        return $data;
    }

    public function extre($id)
    {
        $c = Musteriler::where('id', $id)->count();
        if($c != 0){
            $data = Musteriler::where('id', $id)->get();

            $faturaTablo = FaturaIslem::leftJoin('faturas', 'fatura_islems.faturaId', '=', 'faturas.id')
                ->where('faturas.musteriId', $id)
                ->groupBy('faturas.id')
                ->orderBy('faturas.faturaTarih', 'desc')
                ->select(['faturas.id as id','faturas.faturaTipi as type',DB::raw('"fatura" as uType'),DB::raw('SUM(genelToplam) as fiyat'),'faturas.faturaTarih as tarih']);


            $islemTablo = Islem::where('musteriId', $id)
                ->orderBy('tarih', 'desc')
                ->select(['id','type',DB::raw('"islem" as uType'),'fiyat', 'tarih']);

            $viewData = $faturaTablo->union($islemTablo)
                ->orderBy('tarih','desc')
                ->get();



            return view('front.musteriler.extre',['data' => $data, 'viewData' => $viewData]);
        }
    }
}
