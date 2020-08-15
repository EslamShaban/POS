<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
   
    public function __construct(){
        $this->middleware(['permission:read-users'])->only('index');
        $this->middleware(['permission:create-users'])->only('create');
        $this->middleware(['permission:update-users'])->only('edit');
        $this->middleware(['permission:delete-users'])->only('destroy');
    }

    public function index(Request $request)
    {
        $users = User::whereRoleIS('admin')->where(function($q) use($request){
            return $q->when($request->search,function($query) use($request){

                return $query->where('f_name', 'like', '%' . $request->search . '%')
                             ->orWhere('l_name', 'like', '%' . $request->search . '%');
    
            });
        })->latest()->paginate(5);
        return view('dashboard.users.index', compact('users'));
    }

   
    public function create()
    {
        return view('dashboard.users.create');
    }

    
    public function store(Request $request)
    {
        
        $request->validate([
            'f_name'=>'required',
            'l_name'=>'required',
            'email'=>'required|unique:users',
            'image'=>'image',
            'password'=>'required|confirmed',
            'permissions'=>'required|min:1'
        ]);

        $request_data = $request->except(['password', 'password_confirmation', 'permissions', 'image']);
        $request_data['password'] = bcrypt($request->password);

        if($request->image){

            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/users_image/' . $request->image->hashName()));  
            
            $request_data['image'] =  $request->image->hashName();
        }

        

        $user = User::create($request_data);

        $user->attachRole('admin');
        
        $user->syncPermissions($request->permissions);

        
        return redirect()->route('dashboard.users.index');
    }


    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }

 
    public function update(Request $request, User $user)
    {
        $request->validate([
            'f_name'=>'required',
            'l_name'=>'required',
            'email'=>'required|unique:users,email,'. $user->id,
            'image'=>'image',
            'permissions'=>'required|min:1'
        ]);

        $request_data = $request->except(['permissions', 'image']);

 

        if($request->image){

            if($user->image != 'default.png'){

                File::delete('uploads/users_image/' . $user->image);
            }

            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/users_image/' . $request->image->hashName()));  
            
            $request_data['image'] =  $request->image->hashName();
        }

        $user->update($request_data);
        
        $user->syncPermissions($request->permissions);

        
        return redirect()->route('dashboard.users.index');
    }


    public function destroy(User $user)
    {
        if($user->image != 'default.png'){

            File::delete('uploads/users_image/' . $user->image);
        }
    
        $user->delete();

        return redirect()->route('dashboard.users.index');
    }
}
