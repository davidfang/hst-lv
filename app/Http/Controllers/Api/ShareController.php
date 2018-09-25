<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Article;
use App\Model\Share;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//use App\Http\Controllers\Controller;

class ShareController extends Controller
{
    public function create(Request $request){
        $post = $request->post();
        $shareModel = new Share();
        $shareModel->uid = $post['uid'];
        $shareModel->content = $post['content'];
        $shareModel->img = $post['img'];
        $shareModel->url = $post['url'];
        $shareModel->title = $post['title'];
        $shareModel->platform = $post['platform'];
        $shareModel->type = $post['type'];
        $shareModel->code = $post['code'];
        $shareModel->message = $post['message'];
        $shareModel->other = $post['other'];
        $shareModel->save();
        switch ($post['type']){
            case '1':
                $other = json_decode($post['other']);
                Article::where('id',$other->id)->update(['click'=>DB::raw('click + 1')]);
            default:
                break;
        }
        return $this->success('提交成功');

    }
}
