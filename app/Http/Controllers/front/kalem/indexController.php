<?php

namespace App\Http\Controllers\front\kalem;


use App\Kalem;
use App\Logger;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class indexController extends Controller
{
    public function index()
    {
        return view('front.kalem.index');
    }

    public function create()
    {
        return view('front.kalem.create');
    }

    public function store(Request $request)
    {
        $all = $request->except('_token');

        $create = Kalem::create($all);
        if ($create) {
            Logger::Insert($all['ad']." kalemi eklendi.", "Kalem");
            return redirect()->back()->with('status', 'Kalem Başarı ile Eklendi.');
        } else {
            return redirect()->back()->with('status', 'Kalem Eklenemedi.');
        }
    }

    public function edit($id)
    {
        $c = Kalem::where('id', $id)->count();
        if($c != 0) {
            $data = Kalem::where('id', $id)->get();
            return view('front.kalem.edit',['data' => $data]);
        } else {
            return redirect('/');
        }
    }

    public function update(Request $request)
    {
        $id = $request->route('id');
        $c = Kalem::where('id', $id)->count();
        if($c != 0) {
            $all = $request->except('_token');
            $data = Kalem::where('id', $id)->get();

            $update = Kalem::where('id', $id)->update($all);
            if($update){
                Logger::Insert($all['ad']." kalemi düzenlendi.", "Kalem");
                return redirect()->back()->with('status', 'Kalem Düzenlendi');
            } else {
                return redirect()->back()->with('status', 'Kalem Düzenlenemedi');
            }
        } else {
            return redirect('/');
        }
    }
    public function delete($id)
    {
        $c = Kalem::where('id', $id)->count();
        if($c != 0) {
            $data = Kalem::where('id', $id)->get();
            Kalem::where('id', $id)->delete();
            Logger::Insert($data[0]['ad']." kalemi silindi.", "Kalem");
            return redirect()->back();
        } else {
            return redirect('/');
        }
    }

    public function data(Request $request)
    {
        $table = Kalem::query();
        $data = DataTables::of($table)
            ->addColumn('edit', function ($table){
                return '<a href="'.route('kalem.edit', ['id' => $table->id ]).'">Düzenle</a>';
            })
            ->addColumn('delete', function ($table){
                return '<a href="'.route('kalem.delete', ['id' => $table->id ]).'">Sil</a>';
            })
            ->editColumn('kalemTipi', function ($table){
                if($table->kalemTipi == 0) {
                    return "Gelir";
                } else {
                    return "Gider";
                }
            })
            ->rawColumns(['edit', 'delete'])
            ->make(true);
        return $data;
    }
}
