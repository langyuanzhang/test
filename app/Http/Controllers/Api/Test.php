<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Test extends Controller
{

    // 测试
    public function test(Request $request)
    {
        $user = new User();
        $res  = $user->get();
        \Log::info("哈哈哈", [1, 2, 3]);
        return response()->json(['code' => 1, 'msg' => '成功', 'data' => $res]);
    }

    /**
     * 授权验证
     *
     * @param Request $request
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

    }

    /**
     * jwt测试
     */
    public function jwt()
    {
        $key     = "example_key";
        $payload = array(
            "iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => 1356999524,
            "nbf" => 1357000000
        );
        $jwt     = JWT::encode($payload, $key);
        return response()->json(['code' => 1, 'msg' => '成功', 'data' => $jwt]);
    }


    /**
     * 测试查询构造器
     */
    public function db(Request $request)
    {
//        dd($request->input());

//        $users = DB::table('users')->select('name')->distinct()->get();

//        $users = DB::table('users')
//            ->select('name', 'price')
//            ->groupBy(['name', 'price'])
//            ->get();

//        $users = DB::table('users')
//            ->leftJoin('orders','users.id','=','orders.user_id')
//            ->select('users.*','orders.no','orders.id AS oid')
//            ->get();

//        $users = DB::table('users')
//            ->crossJoin('orders')
//            ->select('users.*','orders.no','orders.id AS oid')
//            ->get();

//        $users = DB::table('users')
//            ->leftJoin('orders',function ($join){
//                $join->on('users.id','=','orders.user_id')
//                    ->where('price','>',1);
//            })
//            ->select('users.*','orders.no','orders.id AS oid','orders.price')
//            ->get();


//        $sql = DB::table('orders')->where('price','>',1);
//        $users = DB::table('users')->leftJoinSub($sql,'orders_posts',function ($join){
//            $join->on('users.id','=','orders_posts.user_id');
//        })
//        ->select('users.*','orders_posts.no','orders_posts.id AS oid','orders_posts.price')
//        ->get();

//        $users = DB::table('orders')->where('price','>',1)
//            ->orWhere('id',2)->get();

//        $users = DB::table('orders')->where('price','>',2)
//            ->orWhere(function ($query){
//                $query->where('id',2)->where('user_id',1);
//            })->get();

//        $users = DB::table('orders')
//            ->whereBetween('price', [2, 3])
//            ->get();

//        $where = [];
//        if (2 > 1) {
//            $where[] = ['price', '>', 1];
//        }
//        if (3 > 2) {
//            $where[] = ['user_id', '>', 1];
//        }
//        $where[] = ['created_at', '>', '2020-06-15 14:45:56'];
//        $users   = DB::table('orders')
//            ->where($where)
//            ->get();


//        $users = DB::table('orders')
//            ->whereColumn([
//                ['updated_at', '>', 'created_at'],
//            ])->get();


//        $users = DB::table('users')
//            ->whereExists(function ($query) {
//                $query->from('orders')
//                    ->whereRaw('orders.user_id = users.id');
//            })
//            ->select('users.*')
//            ->get();


//        $users = User::where(function ($query) {
//            $query->select('price')
//                ->from('orders')
//                ->whereColumn('user_id', 'users.id')
//                ->limit(1);
//        }, 1)->get();


//        $users = DB::table('users')
//            ->orderBy('name', 'desc')
//            ->get();

//        $users = DB::table('users')
//            ->latest()
//            ->first();

//        $users = DB::table('users')->inRandomOrder()->get();

//        $users = DB::table('users')->skip(2)->take(3)->get();


//        $sortBy = null;
//        $users = DB::table('users')
//            ->when($sortBy,function ($query){
//                return $query->orderBy('id');
//            },function ($query){
//                return $query->orderBy('name');
//            })->get();

//        $users = DB::table('orders')->insert([
//            ['no' => '123', 'price' => 0],
//            ['no' => '123', 'price' => 0],
//            ['no' => '321', 'price' => 1],
//        ]);

//        $users = DB::table('orders')->insertGetId(
//            ['no'=>'123']
//        );

//        $users = DB::table('users')->lockForUpdate()->get();


//        DB::beginTransaction();
//        DB::rollBack();
//        DB::commit();

//        DB::transaction(function (){
//            DB::table('users')->update(['votes' => 1]);
//        },3);

//        $users = DB::table('users')->paginate(2);

//        $users = User::all();

//        $users = User::orderBy('name','desc')->offset(0)->limit(2) ->get();

//        $user_first = User::first();
//        $users = $user_first->fresh();

//        $user_first = User::first();
//        $user_first->name = 1;
//        $users = $user_first->refresh();

//        $all = User::all();
//        $user = $all->reject(function ($user){
//            return $user->id == 1;
//        });

//        $users = User::chunk(2,function ($all){
//            foreach ($all as $user){
//                $user->name=1;
//            }
//        });

//        $users = User::cursor()->filter(function ($user){
//            return $user->id > 1;
//        });
//        foreach ($users as $user){
//            print_r($user->name);
//        }



//        $users = User::addSelect([
//                'last_order'=> Order::select('no')->whereColumn('user_id','users.id')->limit(1)
//        ])->toSql();

//        $users = User::where('id', '>', 100)->firstOr(function () {
//            // ...
//            return 1;
//        });

        $users = User::where('id', '>', 100)
            ->firstOr(['id', 'name'], function () {
                // ...
                return 1;
            });

        return response()->json(['code' => 1, 'msg' => '成功', 'data' => $users]);
    }

    /**
     * 测试laravel-permission
     */
    public function per()
    {
//        $role = Role::create(['name' => 'writer']);
//        $permission = Permission::create(['name' => 'edit articles']);
//        $res = $role->givePermissionTo($permission);

        $user = User::find(1);
        $res = $user->assignRole('writer');
//        dd($res);
//        $users = User::role('writer')->get();
        return response()->json(['code' => 1, 'msg' => '成功', 'data' => $res]);
    }


}
