<?php

namespace App\Http\Controllers\Api;

use App\Model\GoodsShare;
use App\Http\Resources\GoodsShare as GoodsShareResource;
use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;

class GoodsShareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $goods = GoodsShare::where([
            ['is_recommend',1],
            ['status',1]
        ])->simplePaginate(20);
        return $this->success(GoodsShareResource::collection($goods));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\GoodsShare  $goodsShare
     * @return \Illuminate\Http\Response
     */
    public function show(GoodsShare $goodsShare)
    {
        //
        return $this->success(new GoodsShareResource($goodsShare));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\GoodsShare  $goodsShare
     * @return \Illuminate\Http\Response
     */
    public function edit(GoodsShare $goodsShare)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\GoodsShare  $goodsShare
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GoodsShare $goodsShare)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\GoodsShare  $goodsShare
     * @return \Illuminate\Http\Response
     */
    public function destroy(GoodsShare $goodsShare)
    {
        //
    }
}
