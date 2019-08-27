<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class RmapController extends Controller
{
    public function add()
    {
        return view("/rmap/add");
    }

    /**
     * 执行添加
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\think\response\Redirect
     */
    public function doadd()
    {
        $data=request()->all();
        //dd($data);
        if(empty($data['m_name']) ){
            return json_encode(['msg'=>'缺少参数','code'=>2]);
        }
        //上传图片
        if(request()->hasFile('img')){
            $res=$this->uploads('img');
            //dd($res);
            if($res){
                $data['img']=$res['imgurl'];
            }
        }
        //dd($res);
        $info=DB::table('map')->insert($data);
        //dd($info);
        if($info) {
            return redirect('/rmap/list');
        }

    }

    //上传图片
    public function uploads($file)
    {
        //验证文件是否上传成功
        if(request()->file($file)->isValid()){
            $photo=request()->file($file);
             //dd($photo);
            $store_result = $photo->store(date('Ymd'));
//             $store_result = $photo->storeAs('update', 'test.jpg');
            return ['code'=>1,'imgurl'=>$store_result];
        }else{
            return ['code'=>0,'message'=>'文件上传失败'];
        }
    }

    /**
     * 轮播图展示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function list()
    {
        $page=request()->page??1;
        $pageSize=2;
        $query=request()->m_name;
        if (empty($query)){
            $where = [
                'status' => 1
            ];
        }else{
            $where = [
                ['status' ,'=' , 1] ,
                ['m_name','like',"%$query%"]
            ];
        }
        $res=DB::table('map')->where($where)->orderby('weight','desc')->paginate($pageSize);
        //dd($res);
        return view('/rmap/list',['res'=>$res,'query'=>$query]);
    }

    /**
     * 轮播图删除
     * @return bool|false|float|int|string
     */
    public function del()
    {
        $id=request()->m_id;
        //dd($id);
        $res=DB::table('map')->where('m_id',$id)->update(['status'=>2]);
        //dd($res);
        if($res){
            return json_encode(['msg'=>'删除成功','code'=>1]);
        }else{
            return json_encode(['msg'=>'删除失败','code'=>0]);
        }
    }

}
