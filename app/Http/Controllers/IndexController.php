<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
class IndexController extends Controller
{
    //前台首页
    public function index()
    {
        //获取数据
        $person=Redis::get('person_index');
        //dd($person);
        $persons=unserialize($person);
        //dd($persons);
        // 去除缓存里数组里的单个值
        $nav=$persons['nav'];
        $rmap=$persons['rmap'];
        $subfielde=$persons['subfielde'];
        $subfield=$persons['subfield'];
        $subfields=$persons['subfields'];
        $course=$persons['course'];

        //判断是否为空 如果为空走数据库
        if(empty($person)){
            //走数据库
            $nav=DB::table('navbar')->orderby('weight','desc')->get()->toArray();
            $rmap=DB::table('map')->orderby('weight','desc')->where('status',1)->get()->toArray();
            //dd($column);
            $subfielde=DB::table('subfield')->paginate(2);
            $subfield=DB::table('subfield')->orderby('create_time','desc')->get()->toArray();
            $subfields=DB::table('subfield')->orderby('create_time','desc')->paginate(2);
            $course=DB::table('course')->orderby('create_time','desc')->get()->toArray();
        }
            $data=[
                'nav'=>$nav,
                'rmap'=>$rmap,
                'subfielde'=>$subfielde,
                'subfield'=>$subfield,
                'subfields'=>$subfields,
                'course'=>$course
            ];
            $data=serialize($data);
            //dd($data);
            Redis::setex('person_index',600,$data);
            //echo Redis::get('person_index');die;


        return view('/index/index',compact('nav','rmap','subfield','subfielde','subfields','course'));
    }

    //关于我们
    public function about()
    {
        //获取数据
        $about=Redis::get('person_about');
        //dd($about);
        $persons=unserialize($about);
        //dd($persons);
        // 去除缓存里数组里的单个值
        $nav=$persons['nav'];
        $subfield=$persons['subfield'];
        $info=$persons['info'];

        if(empty($about)) {
            //走数据库
            $nav = DB::table('navbar')->orderby('weight', 'desc')->get()->toArray();
            $subfield = DB::table('subfield')->orderby('create_time', 'desc')->get()->toArray();
            $info = DB::table('column')
                ->join('subfield', 'column.c_id', '=', 'subfield.c_id')
                ->paginate(2);
        }

        $data=[
            'nav'=>$nav,
            'subfield'=>$subfield,
            'info'=>$info
        ];
        $data=serialize($data);
        //dd($data);
        Redis::setex('person_about',600,$data);
        //Redis::del('person_about');
        return view('/index/about',['nav'=>$nav,'subfield'=>$subfield,'info'=>$info]);
    }

    //新闻
    public function news()
    {
        //获取数据
        $news=Redis::get('person_news');
        //dd($news);
        $persons=unserialize($news);
        //dd($persons);
        // 去除缓存里数组里的单个值
        $nav=$persons['nav'];
        $subfield=$persons['subfield'];
        $info=$persons['info'];

        if(empty($news)){
            //走数据库
            $nav=DB::table('navbar')->orderby('weight','desc')->get()->toArray();
            $subfield=DB::table('subfield')->orderby('create_time','desc')->paginate(3);
            $info=DB::table('column')
                ->join('subfield','column.c_id','=','subfield.c_id')
                ->paginate(2);
        }

        $data=[
            'nav'=>$nav,
            'subfield'=>$subfield,
            'info'=>$info
        ];
        $data=serialize($data);
        //dd($data);
        Redis::setex('person_news',600,$data);
        //Redis::del('person_news');
        return view('/index/news',['nav'=>$nav,'subfield'=>$subfield,'info'=>$info]);
    }

    /**
     * 详情
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function shownews()
    {
        //获取数据
        $shownews=Redis::get('person_shownews');
        //dd($shownews);
        $persons=unserialize($shownews);
        //dd($persons);

        // 去除缓存里数组里的单个值
        $nav=$persons['nav'];
        $subfield=$persons['subfield'];
        $info=$persons['info'];

        if(empty($shownews)){
            $nav=DB::table('navbar')->orderby('weight','desc')->get()->toArray();
            $subfield=DB::table('subfield')->paginate(4);
            $info=DB::table('column')
                ->join('subfield','column.c_id','=','subfield.c_id')
                ->paginate(2);
        }

        $data=[
            'nav'=>$nav,
            'subfield'=>$subfield,
            'info'=>$info
        ];
        $data=serialize($data);
        //dd($data);
        Redis::setex('person_shownews',600,$data);

        return view('/index/shownews',['nav'=>$nav,'subfield'=>$subfield,'info'=>$info]);
    }
}