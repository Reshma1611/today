<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades;


class loginController extends Controller
{
    public function index(Request $request)
    {
        return view("image");
    }
    public function save(Request $request)
    {
         
        $validatedData = $request->validate([
         'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
 
        ]);
 
        $name = $request->file('image')->getClientOriginalName();
 
        $path = $request->file('image')->store('public/images');
 
 
        $save = new ;
 
        $save->name = $name;
        $save->path = $path;
 
        $save->save();
 
        return redirect('upload-image')->with('status', 'Image Has been uploaded');
 
    }
    public function checkAuth(Request $re)
    {
        $a = DB::table('reashma')->where([['email1',$re->input('email')],['pwd',$re->input('password')]])->count();
        if($a == 1)
        {
            $re->session()->put('email',$re->input('email'));

            return view('home');
        }
        echo "Wrong credential";
        return view('login');
        
    }
    public function register(Request $re)
    {
        try
        {
            $a = DB::table('reashma')->insert([
                'email1'=>$re->input('email'),
                'pwd'=>$re->input('password'),
                'gender'=>$re->input('gender'),
            ]);
            if($a == 1)
            {
                return view('login');
            }
        }
        catch(Throwable $e)
        {
            return view('login');
        }
        
        
        
    }
}
