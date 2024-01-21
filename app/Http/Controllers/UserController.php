<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\ImageUpload;
use App\Models\Seller_status;
use App\Models\User;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\View\View;



class UserController extends Controller
{

    public function image(Request $request , string $id)
    {
        /*in code kheily khafane*/
        /*User::create($request->validated());*/

        User::find($id)->addMediaFromRequest('image')->toMediaCollection();
        $media = User::find($id)->getMedia();

        return response()->json([
            'status'=>'success',
            'media'=>$media,
        ],200);
    }

    public  function filter(Request $request)
    {

            $min_age = $request->filterAgeMin;
            $max_age = $request->filterAgeMax;
            $min_orders=$request->filterOrderCountMin;
            $max_orders=$request->filterOrderCountMax;
            $orders_status=$request->filterOrderStatus;
            $price_min=$request->filterOrderTotalPriceMin;
            $price_max=$request->filterOrderTotalPriceMax;
            $factor=$request->filterFactorStatus;


            $usersQuery = QueryBuilder::for(User::class)
                ->allowedFilters(['email', 'first_name', 'last_name', 'user_name', 'phone_number', 'gender', 'post_code'])
                ->with('orders')
                ->withCount('orders')
                ->withExists('orders')
                ->when($min_age, function ($query) use ($min_age) {
                    return $query->where('age', '>=', $min_age);
                })
                ->when($max_age, function ($query) use ($max_age) {
                    $query->where('age', '<=', $max_age);
                });
            if (!is_null($min_orders)) {
                $usersQuery->havingRaw('orders_count >= ?', [$min_orders]);
            }
            if (!is_null($max_orders)) {
                $usersQuery->havingRaw('orders_count <= ?', [$max_orders]);
            }
            if (!is_null($orders_status)){
                $usersQuery->havingRaw('orders_exists = ?', [$orders_status]);
            }
            if (!is_null($price_min)){
                $usersQuery->whereHas('orders', function ($query) use ($price_min) {
                        $query->where('total_price', '>=', $price_min);
                });
            }
            if (!is_null($price_max)){
                $usersQuery->whereHas('orders', function ($query) use ($price_max) {
                    $query->where('total_price', '<=', $price_max);
                });
            }
            $users = $usersQuery->get();

            return response()->json([
                'users'=>$users
            ],200);
        }

    public function  sellers_notaccepted()
    {
        $statuses=Seller_status::all();

        $users=User::all();

        return response()->json([
            'statuses'=>$statuses,
            'users'=>$users
        ],200);
    }
    public function accept_seller(string $id)
    {
        Seller_status::where('user_id' , $id)->update([
            'status'=>'accepted'
        ]);
        return response()->json([
            'statuses'=>'seleer sccepted',
        ],200);
    }
    public function sellers_index()
    {
        $statuses=Seller_status::all();

        $users=User::all();

        return response()->json([
            'statuses'=>$statuses,
            'users'=>$users
        ],200);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users=User::all();

        return response()->json([
            'users'=>$users
        ],200);
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

        return response()->json([
            'statuses'=>'user has been create',
        ],200);

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
    public function edit($id)
    {
        $user=User::find($id);
            $user->save();
        return response()->json([
            'users'=>$user
        ],200);

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

        return response()->json([
            'statuses'=>'user has been updated',
        ],200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $User=User::find($id);
        $User->delete();
        return response()->json([
            'statuses'=>'success',
        ],200);
    }
}
