<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   public function index(){
         $data =array(
        "title"                 =>"Data User",
        "menuAdminUser"         =>"active",
        "user"                  => User::with('instansiRel')->orderBy('role', 'asc')->get(),
        );
    return view('admin/user/index',$data);
   }

      public function create(){
         $data =array(
        "title"                 =>"Tambah Data User",
        "menuAdminUser"         =>"active",
        "instansi"              => Instansi::where('status', 1)->get(),
    );
    return view('admin/user/create',$data);
   }

      public function store(Request $request){
         $request->validate([
            'nama'      =>'required',
            'email'     =>'required|unique:users,email',
            'instansi'  =>'required',
            'role'      =>'required',
            'password'  =>'required|confirmed|min:8',
         ],[
            'nama.required'      =>'Nama Tidak Boleh Kosong',
            'email.required'     =>'Email Tidak Boleh Kosong',
            'email.unique'       =>'Email Sudah Ada',
            'instansi.required'  =>'Instansi Harus Dipilih',
            'role.required'      =>'Role Harus Dipilih',
            'password.required'  =>'Password Tidak Boleh Kosong',
            'password.confirmed' =>'Password Konfirmasi Tidak Sama',
            'password.min'       =>'Password Minimal 8 Karakter',
         ]);

         $user = new user;
         $user->nama       =$request->nama;
         $user->email      =$request->email;
         $user->instansi   =$request->instansi;
         $user->role       =$request->role;
         $user->password   =Hash::make($request->password);
         $user->save();

         return redirect()->route('user')->with('success','Data Berhasil Ditambahkan');

       }

       public function edit($id){
         $data =array(
        "title"                 =>"Edit Data User",
        "menuAdminUser"         =>"active",
        "user"                  =>user::findOrFail($id),
        "instansi"              => Instansi::where('status', 1)->get(),
    );
    return view('admin/user/edit',$data);

    }
    
      public function update(Request $request,$id){
         $request->validate([
            'nama'      =>'required',
            'email'     =>'required|unique:users,email,'.$id,
            'instansi'  =>'required',
            'role'      =>'required',
            'password'  =>'nullable|confirmed|min:8',


         ],[
            'nama.required'      =>'Nama Tidak Boleh Kosong',
            'email.required'     =>'Email Tidak Boleh Kosong',
            'email.unique'       =>'Email Sudah Ada',
            'instansi.required'  =>'Instansi Harus Dipilih',
            'role.required'      =>'Role Harus Dipilih',
         ]);


         $user = user::findOrFail($id) ;
         $user->nama       =$request->nama;
         $user->email      =$request->email;
         $user->instansi   =$request->instansi;
         $user->role       =$request->role;
        if ($request->filled('password')){
        $user->password   =Hash::make($request->password);}
         $user->save();

         return redirect()->route('user')->with('success','Data Berhasil Diedit');
      }

      public function destroy($id){
       $user = user::findOrFail($id) ;
       $user->delete();
       return redirect()->route('user')->with('success','Data Berhasil Dihapus');
      }

}


