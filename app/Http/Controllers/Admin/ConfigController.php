<?php

namespace App\Http\Controllers\Admin;

use App\Model\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;


class ConfigController extends Controller
{
//    将网站配置数据表中的网站配置写入webconfig中
    public function putContent(){
//        1 将网站配置数据表中的网站配置数据
        $content=Config::pluck('conf_content','conf_name')->all();

//        准备要写入的内容
        $str='<?php return'.var_export($content,true).';';
//        将内容写入webconfig.php文件
        file_put_contents(config_path().'/webconfig.php',$str);
    }
//    批量修改网站配置项
    public function changecontent(Request $request){
        $input=$request->except('_token');

        DB::beginTransaction();

        try{
            foreach($input['conf_id'] as $k=>$v){
                DB::table('config')->where('conf_id',$v)
                    ->update(['conf_content'=>$input['conf_content'][$k]]);
            }
            DB::commit();
            $this_>$this->putContent();
            return redirect('/admin/config');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error'=>$e->getMessage()]);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //提取数据
        $conf=Config::get();
//        格式化返回数据
        foreach($conf as $v){
            switch ($v->field_type){
                case 'input':
                    $v->conf_contents = '<input type="text" name="conf_content[]" value="'.$v->conf_content.'" class="layui-input">';
                    break;
                case 'textarea':
                    $v->conf_contents='<textarea name="conf_content[]"  class="layui-textarea">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
//                    分割conf_value值
                    $str='';
                    $arr=explode(',',$v->field_value);
                    foreach ($arr as $n){
                        $a=explode('|',$n);
                        if($v->conf_content==$a[0]){
                            $str.='<input type="radio" name="conf_content[]" value="'.$a[0].'" title="'.$a[1].'" checked>'.$a[1].'&nbsp;&nbsp;';
                        }else{
                            $str.='<input type="radio" name="conf_content[]" value="'.$a[0].'" title="'.$a[1].'" >'.$a[1].'&nbsp;&nbsp;';
                        }
                    }
                    $v->conf_contents=$str;
                    break;
            }

        }
        return view('admin.config.list',compact('conf'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //网站配置添加页面

        return view('admin.config.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 执行添加
        $input=$request->except('_token');
        $res=Config::create($input);
        if($res){
            $this_>$this->putContent();
            return redirect('admin/config');
        }else{
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
