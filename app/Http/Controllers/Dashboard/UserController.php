<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:create_users'])->only(['create','store']);
        $this->middleware(['permission:update_users'])->only(['edit','update']);
        $this->middleware(['permission:read_users'])->only('index');
        $this->middleware(['permission:delete_users'])->only('destroy');
    }

    public function index(Request $request)
    {

        $users = User::whereRoleIs('admin')->when($request->search,function($q) use ($request){
            return $q->where('first_name','like','%'.$request->search.'%')
            ->orWhere('last_name','like','%'.$request->search.'%');
        })->latest()->paginate(5);
        return view('dashboard.users.index',compact('users'));
    }

    public function create()
    {
        return view('dashboard.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email',
            'image' => 'image',
            'password' => 'required|confirmed',
        ]);

        $user_data =$request->except(['password','password_confirmation','permissions','image']);

        $user_data['password'] = bcrypt($request->password);

        // Image::make($request->image)->resize(300, null, function ($constraint) {
        //     $constraint->aspectRatio();
        // })->save(public_path('uploads/user_images/' . $request->image->hashName()));

        // $user_data['image'] = $request->image->hashName();

        $user = User::create($user_data);

        $user->attachRole('admin');
        $user->syncPermissions($request->permissions);

        return redirect()->route('dashboard.users.index')->with([
            'success' => __('site.user_added_seccessfully'),
        ]);
    }

    public function edit(User $user)
    {
        return view('dashboard.users.edit',compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
        ]);

        $user_data =$request->except(['permissions']);

        $user->update($user_data);

        $user->syncPermissions($request->permissions);

        return redirect()->route('dashboard.users.index')->with([
            'success' => __('site.user_updated_seccessfully'),
        ]);
    }

    public function destroy(User $user)
    {
        // if ($user->image != 'default.png') {
        //     Storage::delete('uploads/user_images/' . $user->image);
        // }
        // dd($user->image,Storage::delete('uploads/user_images/' . $user->image));
        // if ($user->image != 'default.png') {
        //     Storage::delete(public_path('uploads/user_images/' . $user->image));
        // }
        $user->delete();
        return redirect()->route('dashboard.users.index')->with([
            'success' => __('site.user_deleted_seccessfully'),
        ]);
    }
}
