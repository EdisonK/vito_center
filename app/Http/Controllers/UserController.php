<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Models\User;
use Illuminate\Http\Request;
use Cache;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{
    public function test()
    {
        return $this->success('123');
    }

    /*
     * 用户注册
     * author vito
     * */
    public function registerUser(StoreUser $storeUser)
    {
        $check_user = User::where('username',trim($storeUser->username))->first();
        if($check_user){
            return $this->fail("用户名已存在！");
        }
        //是否验证手机号码是正常使用，且是本人的，暂时还没有，可以以后补充
        $create_at = date("Y-m-d H:i:s");
        $rand_code = random_int(1000,9999);
        $user = User::create([
            'name' => trim($storeUser->name),
            'username' => trim($storeUser->username),
            'password' => md5(md5(trim($storeUser->password)).$rand_code),
            'rand_code' => $rand_code,
            'email' => trim($storeUser->email),
            'phone' => trim($storeUser->phone),
            'create_at' => $create_at,
            'from' => 1
        ]);
        if($user){
            return $this->success("注册成功！");
        }else{
            return $this->fail('注册失败！');
        }

    }

    /*
     * 检测该用户名是否存在
     * author vito
     *
     * */
    public function checkUsername(Request $request)
    {
        $username = trim($request->username);
        $check_user = User::where('username',$username)->first();
        if($check_user){
            return $this->fail("用户名已存在！");
        }else{
            return $this->success("该用户名可用！");
        }
    }

    /*
     * 用户登录
     * author vito
     * */
    public function login(Request $request)
    {
        $username = trim($request->username);
        $password = trim($request->password);
        $check_user = User::where('username',$username)->first();
        if(!$check_user){
            return $this->fail("用户名不存在，请检查后重新输入！");
        }
        $rand_code = $check_user->rand_code;
        if($check_user->password == md5(md5($password).$rand_code)){
            $token = 'user'.Uuid::uuid1()->toString();
            Cache::put($token,[
                'user_id' => $check_user->id,
                'expired_at' => 120
            ],120);
            $arr = [
                'token' => $token
            ];
            return $this->successWithData($arr,"登录成功！");
        }else{
            return $this->fail("密码不正确，请重新输入！");
        }
    }


}
