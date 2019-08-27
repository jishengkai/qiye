<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class SubfieldController extends Controller
{
    /**
     * 分栏添加
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function add()
    {
        $info=DB::table('column')->get()->toArray();
        //dd($info);
        return view('/subfield/add',['info'=>$info]);
    }

    /**
     * 分栏执行添加
     * @return bool|false|float|int|string
     */
    public function doadd()
    {
        $data=request()->input();
        //dd($data);
        if(empty($data['s_name']) || empty($data['c_id']) || empty($data['status']) || empty($data['desc']) ){
            return json_encode(['msg'=>'缺少参数','code'=>0]);
        }
        $data['create_time']=time();
        $res=DB::table('subfield')->insert($data);
        //dd($res);
        if($res){
            return json_encode(['msg'=>'添加分栏成功','code'=>1]);
        }else{
            return json_encode(['msg'=>'添加分栏失败','code'=>2]);
        }

    }

    /**
     * 分栏展示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function list()
    {
        $page=request()->page??1;
        $pageSize=2;
        $query=request()->s_name;
        if (empty($query)){
            $where = [
                'subfield.status' => 1
            ];
        }else{
            $where = [
                ['subfield.status' ,'=' , 1] ,
                ['s_name','like',"%$query%"]
            ];
        }

        $res=DB::table('subfield')
            ->join('column','subfield.c_id','=','column.c_id')
            ->where($where)
            ->paginate($pageSize);
          //  ->toArray();
        //dd($res);
        return view('/subfield/list',['res'=>$res,'query'=>$query]);
    }

    /**
     * 删除
     * @return bool|false|float|int|string
     */
    public function del()
    {
        $id=request()->s_id;
        //dd($id);
        $res=DB::table('subfield')->where('s_id',$id)->update(['status'=>2]);
        //dd($res);
        if($res){
            return json_encode(['msg'=>'删除分栏成功','code'=>1]);
        }else{
            return json_encode(['msg'=>'删除分栏失败','code'=>2]);
        }
    }

    /**
     * 分栏修改
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function update()
    {
        $id=request()->id;
        //dd($id);
        $info=DB::table('column')->get()->toArray();
        $res=DB::table('subfield')
            ->join('column','subfield.c_id','=','column.c_id')
            ->where('subfield.s_id',$id)
            ->first();
        //dd($res);
        return view('/subfield/update',['info'=>$info,'res'=>$res]);

    }

    /**
     * 执行分栏修改
     * @return bool|false|float|int|string
     */
    public function doupdate()
    {
        $id=request()->s_id;
        $data=request()->input();
        $res=DB::table('subfield')->where('s_id',$id)->update($data);
        if($res){
            return json_encode(['msg'=>'修改分栏成功','code'=>1]);
        }else{
            return json_encode(['msg'=>'修改分栏失败','code'=>2]);
        }
    }
}
