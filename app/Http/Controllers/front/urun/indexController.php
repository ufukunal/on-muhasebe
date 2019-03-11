<?php

namespace App\Http\Controllers\front\urun;

use App\FaturaIslem;
use App\Urun;
use App\Logger;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class indexController extends Controller
{
    public function index()
    {
        return view('front.urun.index');
    }

    public function create()
    {
        return view('front.urun.create');
    }

    public function store(Request $request)
    {
        $all = $request->except('_token');

        $create = Urun::create($all);
        if ($create) {
            Logger::Insert($all['urunAdi']." Ürün eklendi.", "Ürün");
            return redirect()->back()->with('status', 'Ürün Başarı ile Eklendi.');
        } else {
            return redirect()->back()->with('status', 'Ürün Eklenemedi.');
        }
    }

    public function edit($id)
    {
        $c = Urun::where('id', $id)->count();
        if($c != 0) {
            $data = Urun::where('id', $id)->get();
            return view('front.urun.edit',['data' => $data]);
        } else {
            return redirect('/');
        }
    }

    public function update(Request $request)
    {
        $id = $request->route('id');
        $c = Urun::where('id', $id)->count();
        if($c != 0) {
            $all = $request->except('_token');
            $data = Urun::where('id', $id)->get();

            $update = Urun::where('id', $id)->update($all);
            if($update){
                Logger::Insert($all['urunAdi']." Ürün düzenlendi.", "Ürün");
                return redirect()->back()->with('status', 'Ürün Düzenlendi');
            } else {
                return redirect()->back()->with('status', 'Ürün Düzenlenemedi');
            }
        } else {
            return redirect('/');
        }
    }
    public function delete($id)
    {
        $c = Urun::where('id', $id)->count();
        if($c != 0) {
            $data = Urun::where('id', $id)->get();
            Urun::where('id', $id)->delete();
            Logger::Insert($data[0]['urunAdi']." Ürün silindi.", "Ürün");
            return redirect()->back();
        } else {
            return redirect('/');
        }
    }

    public function data(Request $request)
    {
        $table = Urun::query();
        $data = DataTables::of($table)
            ->addColumn('edit', function ($table){
                return '<a href="'.route('urun.edit', ['id' => $table->id ]).'">Düzenle</a>';
            })
            ->addColumn('delete', function ($table){
                return '<a href="'.route('urun.delete', ['id' => $table->id ]).'">Sil</a>';
            })
            ->addColumn('stok', function ($table){
                $girdi = FaturaIslem::leftJoin('faturas', 'fatura_islems.faturaId', 'faturas.id')
                    ->where('fatura_islems.urunId', $table->id)
                    ->where('faturas.faturaTipi', FATURA_GIDER)
                    ->sum('fatura_islems.miktar');

                $cikti = FaturaIslem::leftJoin('faturas', 'fatura_islems.faturaId', 'faturas.id')
                    ->where('fatura_islems.urunId', $table->id)
                    ->where('faturas.faturaTipi', FATURA_GELIR)
                    ->sum('fatura_islems.miktar');

                return $girdi - $cikti;
            })
            ->rawColumns(['edit', 'delete'])
            ->make(true);
        return $data;
    }
}
