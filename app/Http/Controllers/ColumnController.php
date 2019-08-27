<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class ColumnController extends Controller
{
    /**
     * 栏目添加
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function add()
    {
        $info=DB::table('navbar')->get()->toArray();
        //dd($info);
        return view('/column/add',['info'=>$info]);
    }

    /**
     * 执行栏目添加
     * @return bool|false|float|int|string
     */
    public function doadd()
    {
        $data=request()->input();
        //dd($data);
        if(empty($data['c_name']) || empty($data['n_id'])){
            return json_encode(['msg'=>'缺少参数','code'=>0]);
        }
        $data['create_time']=time();
        $res=DB::table('column')->insert($data);
        //dd($res);
        if($res){
            return json_encode(['msg'=>'添加栏目成功','code'=>1]);
        }else{
            return json_encode(['msg'=>'添加栏目失败','code'=>2]);
        }
    }

    /**
     * 栏目展示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function list()
    {
        $page=request()->page??1;
        $pageSize=2;
        $query=request()->c_name;
        if (empty($query)){
            $where = [
                'column.status' => 1
            ];
        }else{
            $where = [
                ['column.status' ,'=' , 1] ,
                ['c_name','like',"%$query%"]
            ];
        }
        $res=DB::table('column')
            ->join('navbar','column.n_id','=','navbar.n_id')
            ->where($where)
            ->paginate($pageSize);
//            ->toArray();
        //dd($res);
        return view('/column/list',['res'=>$res,'query'=>$query]);
    }

    /**
     * 删除栏目
     * @return bool|false|float|int|string
     */
    public function del()
    {
        $id=request()->c_id;
        //dd($id);
        $res=DB::table('column')->where('c_id',$id)->update(['status'=>2]);
        //dd($res);
        if($res){
            return json_encode(['msg'=>'删除栏目成功','code'=>1]);
        }else{
            return json_encode(['msg'=>'删除栏目失败','code'=>2]);
        }
    }

    /**
     * 修改栏目
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function update()
    {
        $id=request()->id;
        $info=DB::table('navbar')->get()->toArray();
        $res=DB::table('column')
            ->join('navbar','column.n_id','=','navbar.n_id')
            ->where('column.c_id',$id)
            ->first();
        //dd($res);
        return view('/column/update',['info'=>$info,'res'=>$res]);
    }

    /**
     * 执行修改栏目
     * @return bool|false|float|int|string
     */
    public function doupdate()
    {
        $id=request()->c_id;
        $data=request()->input();
        $res=DB::table('column')->where('c_id',$id)->update($data);
        if($res){
            return json_encode(['msg'=>'修改栏目成功','code'=>1]);
        }else{
            return json_encode(['msg'=>'修改栏目失败','code'=>2]);
        }
    }
}
