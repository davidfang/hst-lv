<?php

namespace App\Http\Controllers;

use App\Model\Notices;
use Illuminate\Http\Request;

class NoticesController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Notices $notices,Request $request)
    {
        if($request->get('appName')){
            $notices->body = str_replace(config('app.name'),$request->get('appName'),$notices->body);
        }
        if (empty($notices->view)) {
            return view('notice-detail', ['notice' => $notices]);
        } else {
            return view($notices->view, ['notice' => $notices]);
        }
    }
}
