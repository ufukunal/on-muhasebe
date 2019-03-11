<?php

namespace App\Http\Controllers\front\banka;

use App\Banka;
use App\Logger;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class indexController extends Controller
{
    public function index()
    {
        return view('front.banka.index');
    }

    public function create()
    {
        return view('front.banka.create');
    }

    public function store(Request $request)
    {
        $all = $request->except('_token');

        $create = Banka::create($all);
        if ($create) {
            Logger::Insert("Yeni Banka Eklendi", "Banka");
            return redirect()->back()->with('status', 'Banka Başarı ile Eklendi.');
        } else {
            return redirect()->back()->with('status', 'Banka Eklenemedi.');
        }
    }

    public function edit($id)
    {
        $c = Banka::where('id', $id)->count();
        if($c != 0) {
            $data = Banka::where('id', $id)->get();
            return view('front.banka.edit',['data' => $data]);
        } else {
            return redirect('/');
        }
    }

    public function update(Request $request)
    {
        $id = $request->route('id');
        $c = Banka::where('id', $id)->count();
        if($c != 0) {
            $all = $request->except('_token');
            $data = Banka::where('id', $id)->get();

            $update = Banka::where('id', $id)->update($all);
            if($update){
                Logger::Insert([$data[0]['ad']." banka hesabı düzenlendi"], "Banka");
                return redirect()->back()->with('status', 'Banka Düzenlendi');
            } else {
                return redirect()->back()->with('status', 'Banka Düzenlenemedi');
            }
        } else {
            return redirect('/');
        }
    }
    public function delete($id)
    {
        $c = Banka::where('id', $id)->count();
        if($c != 0) {
            $data = Banka::where('id', $id)->get();
            Banka::where('id', $id)->delete();
            Logger::Insert([$data[0]['ad']." banka hesabı silindi"], "Banka");
            return redirect()->back();
        } else {
            return redirect('/');
        }
    }

    public function data(Request $request)
    {
        $table = Banka::query();
        $data = DataTables::of($table)
            ->addColumn('edit', function ($table){
                return '<a href="'.route('banka.edit', ['id' => $table->id ]).'">Düzenle</a>';
            })
            ->addColumn('delete', function ($table){
                return '<a href="'.route('banka.delete', ['id' => $table->id ]).'">Sil</a>';
            })
            ->rawColumns(['edit', 'delete'])
            ->make(true);
        return $data;
    }
}
