<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class NavbarsController extends Controller
{
    /**
     * 添加导航栏
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function add()
    {
        return view('/navbars/add');
    }

    /**
     * 执行添加导航栏
     * @return bool|false|float|int|string
     */
    public function doAdd()
    {
        $data=request()->input();
        //dd($data);
        if(empty($data['nav_name'])){
            return json_encode(['msg'=>'缺少参数','code'=>2]);
        }
        //$data['create_time']=time();
        $res=DB::table('navbars')->insert($data);
        //dd($res);
        if($res){
            return json_encode(['msg'=>'添加导航栏成功','code'=>1]);
        }else{
            return json_encode(['msg'=>'添加导航栏失败','code'=>0]);
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
        $query=request()->nav_name;
        if (empty($query)){
            $where = [
                'status' => 1
            ];
        }else{
            $where = [
                ['status' ,'=' , 1] ,
                ['nav_name','like',"%$query%"]
            ];
        }
        $res=DB::table('navbars')->where($where)->orderby('weight','desc')->paginate($pageSize);
        //dd($res);
        return view('/navbars/list',['res'=>$res,'query'=>$query]);
    }


    /**
     * 删除
     */
    public function del()
    {
        $nav_id=request()->post();
        $res=DB::table('navbars')->where('nav_id',$nav_id)->delete();
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
        $nav_id=request()->id;
        //dd($n_id);
        $res=DB::table('navbars')->where('nav_id',$nav_id)->first();
        //dd($res);

        return view('/navbars/update',['res'=>$res]);
    }


    /**
     * 执行修改
     */
    public function doupdate()
    {
        $nav_id=request()->nav_id;
        //dd($n_id);
        $data=request()->input();

        $res=DB::table('navbars')->where('nav_id','=',$nav_id)->update($data);
//        dd($res);
        if($res){
            return json_encode(['msg'=>'修改成功','code'=>1]);
        }else{
            return json_encode(['msg'=>'修改失败','code'=>0]);
        }
    }
}
