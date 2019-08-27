<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class NavbarController extends Controller
{
    /**
     * 添加导航栏
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function add()
    {
        return view('/navbar/add');
    }

    /**
     * 执行添加导航栏
     * @return bool|false|float|int|string
     */
    public function doAdd()
    {
        $data=request()->input();
        //dd($data);
        if(empty($data['n_name']) || empty($data['weight']) ||empty($data['status']) ){
            return json_encode(['msg'=>'缺少参数','code'=>2]);
        }
        $data['create_time']=time();
        $res=DB::table('navbar')->insert($data);
        //dd($res);
        if($res){
            return json_encode(['msg'=>'添加导航栏成功','code'=>1]);
        }

    }

    /**
     * 导航栏展示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function list()
    {
        $page=request()->page??1;
        $pageSize=2;
        $query=request()->n_name;
        if (empty($query)){
            $where = [
                'status' => 1
            ];
        }else{
            $where = [
                ['status' ,'=' , 1] ,
                ['n_name','like',"%$query%"]
            ];
        }
        $res=DB::table('navbar')->where($where)->orderby('weight','desc')->paginate($pageSize);
        //dd($res);
        return view('/navbar/list',['res'=>$res,'query'=>$query]);
    }


    /**
     * 删除
     */
    public function del()
    {
        $n_id=request()->post();
        $res=DB::table('navbar')->where('n_id',$n_id)->delete();
        // dd($res);
        if($res){
            echo json_encode(['msg'=>'删除成功','code'=>1]);
        }else{
            echo json_encode(['msg'=>'删除失败','code'=>0]);
        }
    }

    /**
     * 修改
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function update()
    {
        $n_id=request()->id;
        //dd($n_id);
        $res=DB::table('navbar')->where('n_id',$n_id)->first();
        //dd($res);

        return view('/navbar/update',['res'=>$res]);
    }


    /**
     * 执行修改
     */
    public function doupdate()
    {
        $n_id=request()->n_id;
        //dd($n_id);
        $data=request()->input();
//        $info=DB::table('navbar')->where('n_id','=',$n_id)->first();
//        dd($info);
//        if($data['n_name'] || $data['weight'] ||$data['status'] ){
//            return json_encode(['msg'=>'缺少参数','code'=>2]);
//        }
        $res=DB::table('navbar')->where('n_id','=',$n_id)->update($data);
//        dd($res);
        if($res){
            echo json_encode(['msg'=>'修改成功','code'=>1]);
        }else{
            echo json_encode(['msg'=>'修改失败','code'=>0]);
        }
    }
}
