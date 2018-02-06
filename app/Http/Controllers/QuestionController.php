<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function storeCategory(Request $request)
    {
        $this->validate($request,[
            'category' => 'required|String',
            'fid' => 'required|Integer',
            'product_id' => 'required|Integer'
        ]);
        $category = trim($request->category);
        $fid = trim($request->fid);
        $product_id = trim($request->product_id);

        $check_category = Category::where('category',$category)->where('fid',$fid)->where('product_id',$product_id)->first();
        if($check_category){
            return $this->success('该产品的该类别已经存在,不能重复添加');
        }
        $category = Category::create([
            'category' => $category,
            'fid' => $fid,
            'product_id' => $product_id
        ]);
        if($category){
            return $this->success('添加成功！');
        }else{
            return $this->fail('添加失败！');
        }
    }

    public function getCategoryTree(Request $request)
    {
        $product_id = $request->product_id;
        if(!is_numeric($product_id)){
            return $this->fail('请输入正确的产品id！');
        }
        $categoryList1 = Category::where('product_id',1)->get()->toArray();
        $arr = [];
        foreach ($categoryList1 as $key => $val){
            $arr[$key+1] = $val;
        }
        $tree = $this->generateTree($arr);
        return $this->successWithData($tree,'获取问题类别树成功！');

    }

    public function generateTree($items){
        $tree = array();
        foreach($items as $item){
            if(isset($items[$item['fid']])){
            $items[$item['fid']]['children'][] = &$items[$item['id']];
            }else{
                $tree[] = &$items[$item['id']];
            }
        }
        return $tree;
    }

    /*
     * 获取当前问题类型下面的问题及解决方法
     * author edison
     *
     * */
    public function getQuestionAndAnswer(Request $request)
    {
        $this->validate($request,[
            'category_id' => 'required|Integer'
        ]);
        $category_id = trim($request->category_id);
//        这个地方需要一个递归获取所有的子category_id
        $arr = $this->getTreeIds($category_id);
        $questions = Question::whereIn('category_id',$arr)->orderBy('z_index','desc')->get();
        return $this->successWithData($questions,'获取成功！');
    }

//递归获取树结构的ids
    public function getTreeIds($category_id)
    {
        static $arr = [];
        $arr[] = (int)$category_id;
        $categorys = Category::where('fid',$category_id)->get();
        if(!$categorys){
            return false;
        }
        foreach ($categorys as $key => $val){
            $cid = $val->id;
            $this->getTreeIds($cid);
        }
        return $arr;
    }
    /*
     * 创建问题和解决方案
     * author edison
     *
     * */
    public function storeQuestion(StoreQuestionRequest $storeQuestionRequest)
    {
        $create_time = date('Y-m-d H:i:s');
        $question = Question::create([
            'category_id' => trim($storeQuestionRequest->category_id),
            'title' => trim($storeQuestionRequest->title),
            'answer' => trim($storeQuestionRequest->answer)?trim($storeQuestionRequest->answer):null,
            'logo' => trim($storeQuestionRequest->logo)?trim($storeQuestionRequest->logo):null,
            'vedio_url' => trim($storeQuestionRequest->logo)?trim($storeQuestionRequest->logo):null,
            'is_show' => trim($storeQuestionRequest->is_show),
            'z_index' => trim($storeQuestionRequest->z_index)?trim($storeQuestionRequest->z_index):0,
            'create_time' => $create_time
        ]);
        if($question){
            return $this->success('创建成功！');
        }else{
            return $this->fail('创建失败！');
        }
    }

    /*
     * 获取常见问题列表
     * author edison
     *
     * */
    public function getCommQuestion(Request $request)
    {
        $query = Question::where('is_comm',1);
        if($keywords = trim($request->keywords)){
            $query->where('title','like',"%$keywords%");
        }
        $questions = $query->get();
        return $this->successWithData($questions,'获取常见问题列表成功！');

    }
    /*
     * 更新页面的浏览次数
     * author edison
     * */
    public function updateViews(Request $request)
    {
        $this->validate($request,[
            'id' => 'required|Integer'
        ]);
        $id = trim($request->id);
        $question = Question::find($id);
        $question->views = $question->views + 1;
        $bool =  $question->save();
        if($bool){
            return $this->success("更新成功！");

        }else{
            return $this->fail("更新失败！");
        }

    }
    /*
     * 更新问题是否解决的次数
     * author edison
     * */
    public function updateSolveNum(Request $request)
    {
        $this->validate($request,[
            'id' => 'required|Integer',
            'action' => 'required|String'

        ]);
        $action = trim($request->action);
        if($action != 'good' && $action != 'bad'){
            return $this->fail('更新失败，action参数错误');
        }
        $id = trim($request->id);
        $question = Question::find($id);
         if($action == 'good'){
             $question->good = $question->good + 1;
         }else{
             $question->bad = $question->bad + 1;
         }
        $bool =  $question->save();
        if($bool){
            return $this->success("更新成功！");

        }else{
            return $this->fail("更新失败！");
        }

    }
}
