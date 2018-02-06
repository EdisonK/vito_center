<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAdmin;
use Ramsey\Uuid\Uuid;
use Cache;

class AdminUserController extends Controller
{

    /*
     * 管理员用户注册
     * author vito
     * */
    public function registerAdmin(StoreAdmin $storeAdmin)
    {
        $check_user = AdminUser::where('username',trim($storeAdmin->username))->first();
        if($check_user){
            return $this->fail("用户名已存在！");
        }
        //是否验证手机号码是正常使用，且是本人的，暂时还没有，可以以后补充
        $create_at = date("Y-m-d H:i:s");
        $rand_code = random_int(1000,9999);
        $admin_user = AdminUser::create([
            'name' => trim($storeAdmin->name),
            'username' => trim($storeAdmin->username),
            'password' => md5(md5(trim($storeAdmin->password)).$rand_code),
            'rand_code' => $rand_code,
            'email' => trim($storeAdmin->email),
            'phone' => trim($storeAdmin->phone),
            'create_at' => $create_at,
            'from' => 1
        ]);
        if($admin_user){
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
    public function checkAdmin(Request $request)
    {
        $username = trim($request->username);
        $check_user = AdminUser::where('username',$username)->first();
        if($check_user){
            return $this->fail("用户名已存在！");
        }else{
            return $this->success("该用户名可用！");
        }
    }

    /*
    * 管理员登录
    * author vito
    * */
    public function adminLogin(Request $request)
    {
        $username = trim($request->username);
        $password = trim($request->password);
        $check_user = AdminUser::where('username',$username)->first();
        if(!$check_user){
            return $this->fail("用户名不存在，请检查后重新输入！");
        }
        $rand_code = $check_user->rand_code;
        if($check_user->password == md5(md5($password).$rand_code)){
            $token = 'admin'.Uuid::uuid1()->toString();
            Cache::put($token,[
                'admin_id' => $check_user->id,
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
