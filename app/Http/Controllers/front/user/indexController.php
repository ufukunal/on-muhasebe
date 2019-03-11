<?php

namespace App\Http\Controllers\front\user;

use App\FaturaIslem;
use App\User;
use App\Logger;
use App\UserPermission;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class indexController extends Controller
{
    public function index()
    {
        return view('front.user.index');
    }

    public function create()
    {
        return view('front.user.create');
    }

    public function store(Request $request)
    {
        $all = $request->except('_token');
        $c = User::where('email', $all['email'])->count();
        if($c == 0) {
            $permission = (isset($all['permission'])) ? $all['permission'] : [];
            unset($all['permission']);
            $all['password'] = md5($all['password']);
            $create = User::create($all);
            if ($create) {

                if(count($permission) != 0){
                    foreach ($permission as $k => $v) {
                        UserPermission::create(['userId' => $create->id, 'permissionId' => $v]);
                    }
                }

                Logger::Insert($all['name']." Kullanıcı eklendi.", "Kullanıcı");
                return redirect()->back()->with('status', 'Kullanıcı Başarı ile Eklendi.');
            } else {
                return redirect()->back()->with('status', 'Kullanıcı Eklenemedi.');
            }
        } else {
            return redirect()->back()->with('status', 'Kullanıcı e-posta mevcut');
        }
    }

    public function edit($id)
    {
        $c = User::where('id', $id)->count();
        if($c != 0) {
            $data = User::where('id', $id)->get();
            return view('front.user.edit',['data' => $data]);
        } else {
            return redirect('/');
        }
    }

    public function update(Request $request)
    {
        $id = $request->route('id');
        $c = User::where('id', $id)->count();
        if($c != 0) {
            $all = $request->except('_token');

            $emailControl = User::where('email', $all['email'])->where('id', '!=', $id)->count();
            if($emailControl!=0){return redirect()->back()->with('status','Email Mevcut');}
            if($all['password'] == "") {
                unset($all['password']);
            } else {
                $all['password'] = md5($all['password']);
            }

            $permission = (isset($all['permission'])) ? $all['permission'] : [];
            UserPermission::where('userId', $id)->delete();
            if(count($permission) != 0){
                foreach ($permission as $k => $v) {
                    UserPermission::create(['userId' => $id, 'permissionId' => $v]);
                }
            }
            unset($all['permission']);

            $data = User::where('id', $id)->get();

            $update = User::where('id', $id)->update($all);
            if($update){
                Logger::Insert($all['name']." Kullanıcı düzenlendi.", "Kullanıcı");
                return redirect()->back()->with('status', 'Kullanıcı Düzenlendi');
            } else {
                return redirect()->back()->with('status', 'Kullanıcı Düzenlenemedi');
            }
        } else {
            return redirect('/');
        }
    }

    public function delete($id)
    {
        $c = User::where('id', $id)->count();
        if($c != 0) {
            $data = User::where('id', $id)->get();
            User::where('id', $id)->delete();
            Logger::Insert($data[0]['name']." Kullanıcı silindi.", "Kullanıcı");
            return redirect()->back();
        } else {
            return redirect('/');
        }
    }

    public function data(Request $request)
    {
        $table = User::query();
        $data = DataTables::of($table)
            ->addColumn('edit', function ($table){
                return '<a href="'.route('user.edit', ['id' => $table->id ]).'">Düzenle</a>';
            })
            ->addColumn('delete', function ($table){
                return '<a href="'.route('user.delete', ['id' => $table->id ]).'">Sil</a>';
            })
            ->rawColumns(['edit', 'delete'])
            ->make(true);
        return $data;
    }
}
