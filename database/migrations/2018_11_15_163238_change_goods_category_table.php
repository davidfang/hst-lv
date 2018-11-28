<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeGoodsCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('goods_category',function (Blueprint $table){


            $table->integer('collected_total')->nullable()->default(200)->comment('采集商品数量');
            $table->integer('start_coupon_rate')->nullable()->default(5)->comment('优惠券起始金额');
            $table->integer('volume')->nullable()->default(50)->comment('30天销量下限');


            $table->integer('start_dsr')->nullable()->comment('店铺dsr评分，筛选高于等于当前设置的店铺dsr评分的商品0-50000之间');
            $table->integer('page_size')->nullable()->default(100)->comment('页大小，默认20，1~100');
            $table->integer('page_no')->nullable()->default(1)->comment('第几页，默认：１');
            $table->enum('platform',['1','2'])->nullable()->default('1')->comment('链接形式：1：PC，2：无线，默认：１');
            $table->integer('end_tk_rate')->nullable()->comment('淘客佣金比率上限，如：1234表示12.34%');
            $table->integer('start_tk_rate')->nullable()->comment('淘客佣金比率下限，如：1234表示12.34%');
            $table->integer('end_price')->nullable()->comment('折扣价范围上限，单位：元');
            $table->integer('start_price')->nullable()->comment('折扣价范围下限，单位：元');
            $table->enum('is_overseas',['false','true'])->nullable()->default('false')->comment('是否海外商品，设置为true表示该商品是属于海外商品，设置为false或不设置表示不判断这个属性');
            $table->enum('is_tmall',['false','true'])->nullable()->default('false')->comment('是否商城商品，设置为true表示该商品是属于淘宝商城商品，设置为false或不设置表示不判断这个属性');
            $table->enum('sort',['total_sales_des','total_sales_asc','tk_rate_des','tk_rate_asc','tk_total_sales_des','tk_total_sales_asc','tk_total_commi_des','tk_total_commi_asc','price_des','price_asc'])->nullable()->comment('排序_des（降序），排序_asc（升序），销量（total_sales），淘客佣金比率（tk_rate）， 累计推广量（tk_total_sales），总支出佣金（tk_total_commi），价格（price）');
            $table->string('itemloc')->nullable()->comment('所在地');
            $table->string('cat')->nullable()->comment('后台类目ID，用,分割，最大10个，该ID可以通过taobao.itemcats.get接口获取到');
            $table->string('q')->nullable()->comment('查询词');
            $table->string('material_id')->nullable()->comment('官方的物料Id(详细物料id见：https://tbk.bbs.taobao.com/detail.html?appId=45301&postId=8576096)，不传时默认为2836');
            $table->enum('has_coupon',['false','true'])->nullable()->default('true')->comment('是否有优惠券，设置为true表示该商品有优惠券，设置为false或不设置表示不判断这个属性');
            $table->string('ip')->nullable()->comment('ip参数影响邮费获取，如果不传或者传入不准确，邮费无法精准提供');
            $table->integer('adzone_id')->nullable()->comment('mm_xxx_xxx_xxx的第三位');
            $table->enum('need_free_shipment',['false','true'])->nullable()->default('false')->comment('是否包邮，true表示包邮，空或false表示不限');
            $table->enum('need_prepay',['false','true'])->nullable()->default('false')->comment('是否加入消费者保障，true表示加入，空或false表示不限');
            $table->enum('include_pay_rate_30',['false','true'])->nullable()->default('true')->comment('成交转化是否高于行业均值');
            $table->enum('include_good_rate',['false','true'])->nullable()->default('true')->comment('好评率是否高于行业均值');
            $table->enum('include_rfd_rate',['false','true'])->nullable()->default('true')->comment('退款率是否低于行业均值');
            $table->enum('npx_level',['1','2','3'])->nullable()->default('1')->comment('牛皮癣程度，取值：1:不限，2:无，3:轻微');
            $table->integer('end_ka_tk_rate')->nullable()->comment('KA媒体淘客佣金比率上限，如：1234表示12.34%');
            $table->integer('start_ka_tk_rate')->nullable()->comment('KA媒体淘客佣金比率下限，如：1234表示12.34%');
            $table->string('device_encrypt')->nullable()->comment('设备号加密类型：MD5');
            $table->string('device_value')->nullable()->comment('设备号加密后的值');
            $table->string('device_type')->nullable()->comment('设备号类型：IMEI，或者IDFA，或者UTDID');
        });
        $table_prefix = DB::getTablePrefix();
        DB::statement("ALTER TABLE `" . $table_prefix . "goods_category` CHANGE `sort` `sort` SET('total_sales_des','total_sales_asc','tk_rate_des','tk_rate_asc','tk_total_sales_des','tk_total_sales_asc','tk_total_commi_des','tk_total_commi_asc','price_des','price_asc');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('goods_category',function (Blueprint $table){
            $table->dropColumn(['start_dsr','page_size','page_no','platform','end_tk_rate','start_tk_rate','end_price','start_price','is_overseas','is_tmall','sort','itemloc','cat','q','material_id','has_coupon','ip','adzone_id','need_free_shipment','need_prepay','include_pay_rate_30','include_good_rate','include_rfd_rate','npx_level','end_ka_tk_rate','start_ka_tk_rate','device_encrypt','device_value','device_type']);
        });
    }
}
