<?php

namespace App\Http\Controllers\front\islem;

use App\Fatura;
use App\Logger;
use App\Islem;
use App\Musteriler;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class indexController extends Controller
{
    public function index()
    {
        return view('front.islem.index');
    }

    public function create($type)
    {
        if($type == 0){
            //Ödeme
            return view('front.islem.odeme.create');
        } else {
            //Tahsilat
            return view('front.islem.tahsilat.create');
        }
    }

    public function store(Request $request)
    {
        $all = $request->except('_token');
        $type = $request->route('type');
        $all['type'] = $type;
        $create = Islem::create($all);
        if($create){
            if($type == ISLEM_ODEME) {
                Logger::Insert("Ödeme yapıldı", "İşlem");
            } else {
                Logger::Insert("Tahsilat yapıldı", "İşlem");
            }
            return redirect()->back()->with('status', 'İşleminiz Eklendi.');
        } else {
            return redirect()->back()->with('status', 'İşleminiz Eklenemedi.');
        }

    }

    public function edit($id)
    {
        $c = Islem::where('id', $id)->count();
        if($c != 0){
            $w = Islem::where('id', $id)->get();
            if($w[0]['type'] == 0){
                return view('front.islem.odeme.edit', ['data' => $w]);
            } else {
                return view('front.islem.tahsilat.edit', ['data' => $w]);
            }
        } else {
            return redirect('/');
        }
    }

    public function update(Request $request)
    {
        $id = $request->route('id');
        $all = $request->except('_token');
        $c = Islem::where('id', $id)->count();
        if($c != 0){
            Islem::where('id', $id)->update($all);
            $data = Islem::where('id', $id)->get();
            if($data[0]['type'] == ISLEM_ODEME){
                Logger::Insert("Ödeme düzenlendi", "İşlem");
            } else {
                Logger::Insert("Tahsilat düzenlendi", "İşlem");
            }
            return redirect()->back()->with('status', 'İşlem Düzenlendi');
        } else {
            return redirect('/');
        }
    }

    public function data(Request $request)
    {
        $table = Islem::query();
        $data = DataTables::of($table)
            ->addColumn('edit', function ($table){
                return '<a href="'.route('islem.edit', ['id' => $table->id ]).'">Düzenle</a>';
            })
            ->addColumn('delete', function ($table){
                return '<a href="'.route('islem.delete', ['id' => $table->id ]).'">Sil</a>';
            })
            ->addColumn('faturaNo', function ($table){
                return Fatura::getNo($table->faturaId);
            })
            ->addColumn('musteri', function ($table){
                return Musteriler::getPublicName($table->musteriId);
            })
            ->addColumn('fiyat', function ($table){
                return $table->fiyat;
            })
            ->editColumn('type', function ($table){
                if($table->type == 0) { return "Ödeme"; } else { return "Tahsilat"; }
            })
            ->rawColumns(['edit', 'delete'])
            ->make(true);
        return $data;
    }

    public function delete($id)
    {
        $c = Islem::where('id', $id)->count();
        if($c != 0){
            $data = Islem::where('id', $id)->get();
            Islem::where('id', $id)->delete();
            if($data[0]['type'] == ISLEM_ODEME){
                Logger::Insert("Ödeme silindi", "İşlem");
            } else {
                Logger::Insert("Tahsilat silindi", "İşlem");
            }
            return redirect()->back()->with('status','Silme işlemi başarılı');
        }
    }
}
