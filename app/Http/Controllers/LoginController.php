<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use DB;
class LoginController extends Controller
{
    //注册
    public function reg()
    {

        return view('/login/reg');
    }

    /**
     * 执行注册
     * @param Request $request
     * @return bool|false|float|int|string
     */
    public function regdo(Request $request)
    {
        $data=$request->input();
        //var_dump($data);
        if(empty($data['uname']) || empty($data['pwd']) || empty($data['repwd']) || empty($data['email']) ){
            die('缺少参数');
        }
        unset($data['repwd']);
        //unset($data['code']);
        $data['create_time']=time();
        $data['pwd']=md5($data['pwd']);
        $res1=DB::table('user')->first();
        //dd($res1);
        if($data['uname'] ==$res1->uname){
            return json_encode(['msg'=>'注册成功','code'=>3]);
        }

        if($data['email'] ==$res1->email){
            return json_encode(['msg'=>'注册成功','code'=>2]);
        }
        $res=DB::table('user')->insert($data);
        //dd($res);

        if($res){
            return json_encode(['msg'=>'注册成功','code'=>1]);
        }

    }

    //登录
    public function login()
    {
        return view('/login/login');
    }

    //获取验证码
    public function logincode()
    {
        $code=new CodeController();
        $code->doimg();
        session(['code'=>$code->getCode()]);
    }

    //执行登录
    public function logindo(Request $request )
    {
        $data=$request->input();
       // dd(session('code'));
        if($data['uname']=='' || $data['pwd']==''){
            return ['code'=>2, 'msg'=>'任何选项都不得为空'];
        }
        $where = [
            'uname'=>$data['uname'],
        ];
        $res = DB::table('user')->where($where)->first();
        if(md5($data['pwd'])!=$res->pwd){
            return ['code'=>3,'msg'=>'密码错误'];
        }else if($data['uname']!=$res->uname){
            return ['code'=>4,'msg'=>'用户不存在'];
        }else if($data['code']!= session('code')){
            return ['code'=>5,'msg'=>'验证码不正确'];
        }else if($res){
            session(['uid'=>$res->uid]);
            return ['code'=>1,'msg'=>'登陆成功'];
        }
    }

    /**
     * 找回密码视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function forgot()
    {
        return view('/login/forgot');
    }

    //手机号验证码
    public function send()
    {
        $tel=request()->tel;
        //dd($tel);
        $code=rand(1000,9000);
        $host = "http://yzxtz.market.alicloudapi.com";
        $path = "/yzx/notifySms";
        $method = "POST";
        $appcode = "78477519dadc4eadbe0b0aa25e8eacd6";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = "phone=$tel&templateId=TP18040316&variable=num%3A$code%2Cmoney%3A888";
        $bodys = "";
        $url = $host . $path . "?" . $querys;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        //var_dump(curl_exec($curl));

        Redis::set('code',$code);
        return (curl_exec($curl));
    }

    /**
     * 找回密码
     * @return bool|false|float|int|string
     */
    public function forgotpwd()
    {
        $data=request()->input();
        //dd($data);
        $code=$data['code'];
        $res=DB::table('user')->first();
        //dd($res);
        if(empty($data['tel']) || empty($data['pwd']) || empty($data['repwd']) || empty($data['code'])){
            die('缺少参数');
        }

        if($data['tel'] != $res->tel){
            return json_encode(['msg'=>'该手机号不是用户当时注册的手机号','code'=>2]);
        }

        if($code != Redis::get('code')){
            return json_encode(['msg'=>'输入验证码不正确，请重新输入','code'=>3]);
        }

        $where=[
          'pwd'=>md5($data['pwd']),
        ];
        unset($data['repwd']);
        //unset($data['$code']);
        $info=DB::table('user')->where('uid',session('uid'))->update($where);
        //dd($info);
        if($info){
            return json_encode(['msg'=>'修改密码成功','code'=>1]);
        }

    }

    /**
     * 退出登录
     */
    public function logout()
    {
        session_start();
        request()->session()->forget('uid');
        echo "<script>
                var f=confirm(\"确定要退出吗？\");
                if(f == true){
                          location.href='/login/login';
                  }
                </script>";
    }

}