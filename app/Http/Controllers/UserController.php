<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Seller_status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;


class UserController extends Controller
{
    public function  sellers_notaccepted(): view
    {
        $statuses=Seller_status::all();

        $users=User::all();

        return view('first_project.users.notacceptedsellersData' , ['users'=>$users , 'statuses'=>$statuses]);
    }
    public function accept_seller(string $id)
    {
        Seller_status::where('user_id' , $id)->update([
            'status'=>'accepted'
        ]);
        return redirect()->route('sellers.list');
    }
    public function sellers_list(): view
    {
        $statuses=Seller_status::all();

        $users=User::all();

        return view('first_project.users.sellersData' , ['users'=>$users , 'statuses'=>$statuses]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): view
    {
        $users=User::all();

        return view('first_project.users.usersData', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): view
    {
        return view('first_project.users.addUser');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {

        $User= new User;
        $User->first_name = $request->first_name;
        $User->email=$request->email;
        $User->last_name = $request->last_name;
        $User->user_name = $request->user_name;
        $User->phone_number = $request->phone_number;
        $User->age= $request->age;
        $User->gender = $request->gender;
        $User->post_code = $request->postal_code;
        $User->Province = $request->Province;
        $User->city = $request->city;
        $User->address = $request->address;
        $User->password = md5($request->password);
        $User->save();

        return redirect()->route('users.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): view
    {
        $user=User::find($id);
            $user->save();
        return view('first_project.users.editUser', ['user' => $user]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {

        $user=User::find($id);
             $user->first_name = $request->first_name;
              $user->email=$request->email;
             $user->last_name = $request->last_name;
             $user->user_name = $request->user_name;
           $user-> phone_number = $request->phone_number;
            $user->age = $request->age;
            $user->gender = $request->gender;
            $user->post_code = $request->post_code;
            $user->province = $request->province;
            $user->city = $request->city;
            $user->address = $request->address;
        $user->save();

            return redirect()->route('users.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $User=User::find($id);
        $User->delete();
        return back();
    }
}
