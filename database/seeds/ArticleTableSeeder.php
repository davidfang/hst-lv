<?php

use Illuminate\Database\Seeder;

class ArticleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('article')->delete();
        
        \DB::table('article')->insert(array (
            0 => 
            array (
                'id' => 1,
                'slug' => '新手攻略-功能介绍',
                'title' => '功能介绍',
            'body' => '<p></p><div yne-bulb-block="paragraph">花手领券是淘宝商家第三方合作伙伴之一，一个独立的app,内含200万产品隐藏优惠券，领券后直接跳转淘宝下单，<span style="color: rgb(194, 79, 74);">所有商品都享受淘宝购物保障！</span></div><div yne-bulb-block="paragraph">①花手领券并不是通过分享商品淘口令来赚佣金，而是你用自己的邀请码推广给用户下载安装花手领券APP！</div><div yne-bulb-block="paragraph">②以后用户淘宝购物可以自己把手淘看中的商品，在花手领券里搜索领券了！</div><div yne-bulb-block="paragraph">③这就是躺赚，你都不用动一根手指头，你都不知道用户是什么时候买的，你就可以赚到佣金奖励了！</div><div yne-bulb-block="paragraph">最重要的是，用户在花手领券不止可以领淘宝优惠券，而且还能领到淘宝店铺推广佣金，所以花手领券的用户黏着度非常高！</div>',
                'category_id' => 1,
                'view' => NULL,
                'thumbnail' => 'images/timg.jpeg',
                'images' => '["images\\/timg3.jpeg","images\\/80e4132732644cb3def1e4d84f56919e.jpeg","images\\/a3b98c6491fa290403fd28d9b28f8584.jpeg","images\\/9cdf1d7ef2bc35eab5dd2bdf61420e99.jpeg","images\\/32cc7da67f799f19c4dc620dbf6eef53.jpeg"]',
                'sort' => 0,
                'status' => '1',
                'click' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-08-09 02:34:46',
                'updated_at' => '2018-08-21 05:54:17',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'slug' => NULL,
                'title' => '行动',
                'body' => '行动是打败焦虑的最好办法。当你不知道该做什么的时候，就把手头上的每件小事都做好。',
                'category_id' => 6,
                'view' => NULL,
                'thumbnail' => 'images/e5c4e324618aa35fa545f3cdd6c58503.jpg',
                'images' => '["images\\/5973d5d5c069b1b642c9d179359c577d.jpg","images\\/dd82be8431e85b6a781b21b900b274a2.jpg","images\\/fd26b14ec430a8e3ccbaf6f801f6d1dd.jpg","images\\/68b0d8f08d67621949bf170590695d3b.jpg","images\\/8c0d78f020e4dca93b775932ae8f25b0.jpg"]',
                'sort' => 0,
                'status' => '1',
                'click' => 1006,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-08-10 03:06:26',
                'updated_at' => '2018-08-13 09:37:52',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'slug' => NULL,
                'title' => '成功',
                'body' => '成功不是站起来才有的，而是从决定去做的那一刻起，持续累积而成。',
                'category_id' => 5,
                'view' => NULL,
                'thumbnail' => 'images/be138e98e1b1b1634f57e2e9cde3d019.jpg',
                'images' => NULL,
                'sort' => 0,
                'status' => '1',
                'click' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-08-10 03:09:23',
                'updated_at' => '2018-08-10 08:23:29',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'slug' => '如何搜索优惠券',
                'title' => '如何搜索优惠券',
                'body' => '如何搜索优惠券如何搜索优惠券',
                'category_id' => 1,
                'view' => 'lingquanzhinan',
                'thumbnail' => NULL,
                'images' => NULL,
                'sort' => 0,
                'status' => '1',
                'click' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-08-12 04:16:34',
                'updated_at' => '2018-08-21 05:37:27',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'slug' => '如何邀请好友注册',
                'title' => '如何邀请好友注册？',
                'body' => '<p>用户登录后进入【我的】页面，可以看到自己的邀请码，点击旁边的【复制】按钮，可以复制您的邀请码，然后可以发送给好友，他下载好APP注册时只要填写您的邀请码，他就是您的（直接）粉丝了，以后他通过本APP领取优惠券在淘宝天猫购物都会产生相应的佣金。您推荐的用户达到超级会员资格后，他推荐的用户（即您的推荐粉丝）产生的消费您也会收到一定比例的佣金。</p><p><br></p>',
                'category_id' => 1,
                'view' => NULL,
                'thumbnail' => NULL,
                'images' => NULL,
                'sort' => 0,
                'status' => '1',
                'click' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-08-12 04:17:30',
                'updated_at' => '2018-08-21 06:05:23',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'slug' => '收益与提现说明',
                'title' => '收益与提现说明',
                'body' => '收益与提现说明收益与提现说明',
                'category_id' => 0,
                'view' => NULL,
                'thumbnail' => NULL,
                'images' => NULL,
                'sort' => 0,
                'status' => '0',
                'click' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-08-12 04:18:09',
                'updated_at' => '2018-08-21 06:22:12',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'slug' => '佣金与订单说明',
                'title' => '佣金与订单说明',
                'body' => '佣金与订单说明佣金与订单说明',
                'category_id' => 1,
                'view' => NULL,
                'thumbnail' => NULL,
                'images' => NULL,
                'sort' => 0,
                'status' => '1',
                'click' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-08-12 04:19:07',
                'updated_at' => '2018-08-12 04:19:07',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'slug' => '个人中心粉丝说明',
                'title' => '个人中心粉丝说明',
                'body' => '<p>您推荐的用户即是您的粉丝，粉丝分为直属粉丝和推荐粉丝。</p><p>直属粉丝：通过您的邀请码注册的用户，他的消费时自己会获得大部分佣金，您也会获得小部分佣金；</p><p>推荐粉丝：通过您的粉丝的邀请码注册的用户就是您的推荐粉丝。推荐粉丝消费时自己会获得大部分佣金，您的粉丝会获得小部分佣金，如果您升级为超级会员后，您也会获得小部分佣金。</p><p>特殊说明：</p><ol><li>以上只是佣金分配规则，您和您的粉丝以及您 粉丝的粉丝都不会在我们平台花一分钱，只需要在淘宝天猫购物时将商品标题复制过来在APP里搜索，领券去淘宝购买，所有商品质量和售后都是在淘宝完成。<br></li><li>普通会员只可以获得直属粉丝的部分佣金，超级会员还可以获得推荐粉丝的部分佣金，成为运营商，可以获得您下属所有人消费时的部分佣金。</li></ol><p><br></p>',
                'category_id' => 1,
                'view' => NULL,
                'thumbnail' => NULL,
                'images' => NULL,
                'sort' => 0,
                'status' => '1',
                'click' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-08-12 04:20:09',
                'updated_at' => '2018-08-21 06:20:55',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'slug' => '怎么邀请注册？',
                'title' => '怎么邀请注册？',
                'body' => '<p></p><p></p><p>&nbsp; &nbsp; &nbsp;点击【我的】页面，复制您的邀请码信息，分享好友，好友下载后点击注册填写您发的邀请码即可完成注册，并成为你的粉丝，您可获得相应推广佣金。</p><p><br></p>',
                'category_id' => 2,
                'view' => NULL,
                'thumbnail' => NULL,
                'images' => NULL,
                'sort' => 0,
                'status' => '1',
                'click' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-08-12 10:00:34',
                'updated_at' => '2018-08-21 04:51:20',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'slug' => '联系客服',
                'title' => '联系客服',
                'body' => '<p></p><p></p><p style="text-align: center;"><img src="data:image/png;base64,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" style="max-width:100%;"><br></p><p style="text-align: center;">花手领券客服群二维码</p><p style="text-align: center;">服务时间：周一到周六&nbsp; 9:00 --18:00</p><p><br></p>',
                'category_id' => 3,
                'view' => NULL,
                'thumbnail' => NULL,
                'images' => NULL,
                'sort' => 0,
                'status' => '1',
                'click' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-08-12 10:06:23',
                'updated_at' => '2018-08-21 04:38:32',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'slug' => '新版APP上线了',
                'title' => '新版APP上线了',
                'body' => '<p></p><p>最新版的APP上线了，欢迎大家下载使用😀</p>',
                'category_id' => 4,
                'view' => NULL,
                'thumbnail' => NULL,
                'images' => NULL,
                'sort' => 0,
                'status' => '1',
                'click' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-08-13 10:00:18',
                'updated_at' => '2018-08-13 10:00:18',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'slug' => '用户条款',
                'title' => '用户注册协议',
            'body' => '<p></p><p></p><p>为了确保您充分了解作为花手领券APP（以下简称“花手领券”或“我们”）网站和手机APP的注册用户（以下简称“用户”或“您”）所享有的权利以及我们对您承担的责任，花手领券特制定本《用户协议》（以下简称“本协议”或“本使用条款”）。加入和使用花手领券表明您已经阅读并同意本使用条款，您的用户活动会遵从本使用条款。您对本使用协议不认同的，可以选择不加入和使用本花手领券。</p><p>本协议由您与[上海闻息企业发展有限公司]共同缔结，具有合同效力。本协议中协议双方合称协议方，上海闻息企业发展有限公司在协议中亦称为“花手领券”。</p><p>一、协议内容及签署</p><p>1、本协议内容包括协议正文及所有花手领券已经发布的或将来可能发布的各类规则，包括但不仅限于网站公告及帮助在内的官方声明。所有规则为本协议不可分割的组成部分，与协议正文具有同等法律效力。除另行明确声明外，任何花手领券及其关联公司提供的服务均受本协议约束。但法律法规另有强制性规定的，依其规定。 <br>2、您在注册花手领券账户时点击提交“我已阅读并且同意花手领券的使用协议” 即视为您接受本协议及各类规则，并同意受其约束。您应当在使用花手领券服务之前认真阅读全部协议内容并确保完全理解协议内容，如您对协议有任何疑问的，应向花手领券咨询。但无论您事实上是否在使用花手领券服务之前认真阅读了本协议内容，只要您注册、正在或者继续使用花手领券服务，则视为接受本协议，届时您不应以未阅读本协议的内容或者未获得花手领券对您问询的解答等理由，主张本协议无效，或要求撤销本协议。<br>3、您承诺接受并遵守本协议的约定。如果您不同意本协议的约定，您不应当注册成为花手领券的用户，若您正在注册或正在使用花手领券服务，您应立即停止注册程序或停止使用花手领券服务。 <br>4、花手领券有权根据需要不时地制订、修改本协议及/或各类规则，并以网站公示的方式进行公告，不再单独通知您。变更后的协议和规则一经在网站公布后，立即自动生效，且自动有效代替原来的协议和规则。花手领券的最新的协议和规则以及网站公告可供您随时登陆查阅，您也应当经常性的登陆查阅最新的协议和规则以及网站公告以了解花手领券最新动态。如您不同意相关变更，应当立即停止使用花手领券服务。您继续使用服务的，即表示您接受经修订的协议和规则。</p><p>二、用户及账户管理</p><p>1、申请资格 <br>您应当是具备完全民事权利能力和完全民事行为能力的自然人、法人或其他组织。若您不具备前述主体资格，则您及您的监护人应承担因此而导致的一切后果，且花手领券有权注销（永久冻结）您的花手领券账户，并向您及您的监护人索偿或者追偿。若您不具备前述主体资格，则需要监护人同意您方可注册成为花手领券用户，否则您和您的监护人应承担因此而导致的一切后果，且花手领券有权注销（永久冻结）您的花手领券账户，并向您及您的监护人索偿或者追偿。 <br>花手领券并无能力对您和／或您的监护人的民事权利能力和民事行为能力进行实质性审查，因此一旦您进行了注册，花手领券可以视为您具备完全民事权利能力和完全民事行为能力。 <br>2、账户 <br>在您签署本协议，完成用户注册程序或以其他花手领券允许的方式实际使用花手领券服务时，花手领券会向您提供唯一编号的花手领券账户（以下亦称账户）。 <br>您可以对账户设置用户名和密码，通过该用户名密码或与该用户名密码关联的其它用户名密码登陆花手领券平台。您设置的用户名不得侵犯或涉嫌侵犯他人合法权益。若您提供任何违法、不道德或花手领券认为不适合在花手领券上展示的资料；或者花手领券有理由怀疑您的资料属于程序或恶意操作，花手领券有权暂停或终止您的帐号，并拒绝您于现在和未来使用本服务之全部或任何部分。 <br>您应对您的账户（用户名）和密码的安全，以及对通过您的账户（用户名）和密码实施的行为负责。除非经过正当法律程序，且征得花手领券的同意，否则，账户（用户名）和密码不得以任何方式转让、赠与或继承。如果发现任何人不当使用您的账户或有任何其他可能危及您的账户安全的情形时，您应当立即以有效方式通知花手领券，要求花手领券暂停相关服务。您理解花手领券对您的请求采取行动需要合理时间，花手领券对在采取行动前已经产生的后果（包括但不限于您的任何损失）不承担任何责任，但花手领券未能在合理时间内采取行动的情况除外。您确认并认可您在注册、使用花手领券服务过程中提供、形成的数据等相关信息的所有权及其他相关权利属于花手领券，花手领券有权使用上述信息。 <br>3、用户 <br>当您按照注册页面提示填写信息、阅读并同意本协议并完成全部注册程序后或以其他花手领券允许的方式实际使用花手领券服务时，您即成为花手领券用户（亦称“用户”）。 <br>在您在注册时，应当按照法律法规要求，或注册页面的提示提供，并及时更新您准确的个人资料，并保证资料真实、及时、完整和准确。如有合理理由怀疑您提供的资料错误、不实、过时或不完整的，花手领券有权向您发出询问及/或要求改正的通知，若您未能在花手领券要求的合理期限内回复花手领券的询问及/或完成改正，花手领券有权做出删除相应资料并暂时停止账户的处理，直至终止对您提供部分或全部花手领券服务，花手领券对此不承担任何责任，您将承担因此产生的任何成本或支出。 <br>您应当准确填写并及时更新您提供的联系电话、联系地址、邮政编码、电子邮件地址等联系方式，以便花手领券或其他用户在需要时与您进行有效联系，因通过这些联系方式无法与您取得联系，导致您在使用花手领券服务过程中产生任何损失或增加费用的，应由您完全独自承担，花手领券对此不予承担。 <br>花手领券无须对任何您的任何登记资料的真实性、正确性、完整性、适用性及/或是否为最新资料承担任何包括但不限于鉴别、核实的责任。<br>[您在使用花手领券服务过程中，所产生的应纳税费，以及一切硬件、软件、服务、账户维持及其它方面的费用，均由您独自承担。您同意花手领券有权从您相关账户中优先扣除上述费用。] <br>对于被花手领券账户冻结或者暂时停止帐户的用户，花手领券将不再提供用户连锁项目下的服务。</p><p>三、[花手领券服务]</p><p>1.花手领券将向您呈现第三方优惠券、交易、广告和其他优惠（以下统称“要约”）。要约是由第三方（以下统称“卖方”）提供的产品和服务。用户选择接受要约，则视为与卖方达成交易。 花手领券并非交易相关方，因此不对用户和卖方之间的交易承担任何责任。花手领券不负责履行任何要约。<br>在用户购买产品或服务或以任何其他方式接受要约之前，请阅读要约的整个描述，包括卖方网站上规定的附属细则和任何额外的条款和条件。用户须基于卖方说明，自行了解所要购买的产品或服务。要约的条款和条件，包括退款和取消交易政策，均按照卖方的政策执行。卖方政策不受花手领券约束。 在任何情况下，花手领券不对用户与卖方之间的交易负责。有关要约或用户与卖方之间交易的问题，请直接与卖方联系。<br>2.[花手领券为用户免费提供在线优惠券服务]。[对于在线优惠券的赎回、错误/疏忽或过期等情形，花手领券不承担任何责任，用户应自行确保卖方结帐过程中是否有折扣、特价或免费赠予等情形]。网站和论坛上的所有要约和推广内容如有变更，恕不另行通知。花手领券无法控制卖方提供的任何优惠券或其他要约的合法性、任何卖方按照要约完成销售的能力、以及卖方所提供商品的质量。花手领券无法控制卖方是否会遵守网站和论坛上所示的要约，也无法保证网站信息的准确性和完整性。 对于用户就网站和论坛、或网站和论坛上的信息使用与卖方发生的任何争议，用户同意放弃提出索赔、要求、诉讼、损害赔偿（直和间接）、损失赔偿、成本赔偿、或已知和未知或已披露和未披露费用赔偿的权利，并免除花手领券就此所承担的责任。</p><p>四、花手领券服务使用规范及处理规定</p><p>在使用花手领券服务过程中，您承诺遵守下列使用规范： <br>1、用户承诺其注册信息的正确性。 <br>2、如果用户提供给花手领券的资料有变更，请及时通知花手领券做出相应的修改。 <br>3、用户不得出现恶意注册恶意点击等行为。 <br>4、在使用花手领券服务过程中实施的所有行为均遵守国家法律、法规等规范性文件及花手领券各项规则的规定和要求，不违背社会公共利益或公共道德，不损害他人的合法权益，不违反本协议及相关规则。 您如果违反前述承诺，产生任何法律后果的，您应以自己独自承担所有的法律责任，并确保花手领券免于因此产生任何损失。如花手领券因此承担相应责任或者赔偿相关损失，则您承诺花手领券可以向您追偿，相关责任或损失由您最终承担。任何用户不得发布或以其它方式传送包括但不限于含有下列内容之一的信息：<br>* 反对我国宪法、法律法规所规定的；<br>* 危害国家安全，泄露国家秘密，颠覆国家政权，破坏国家统一的；<br>* 损害国家荣誉和利益的；<br>* 煽动民族仇恨、民族歧视、破坏民族团结的；<br>* 破坏国家宗教政策，宣扬邪教和封建迷信的；<br>* 散布谣言，扰乱社会秩序，破坏社会稳定的；<br>* 散布淫秽、色情、赌博、暴力、凶杀、恐怖、吸毒或者教唆犯罪的；<br>* 侮辱或者诽谤他人，侵害他人合法权利的；<br>* 含有虚假、诈骗、有害、胁迫、侵害他人隐私、骚扰、侵害、中伤、粗俗、猥亵、或其它道德上令人反感的内容；<br>* 含有中国法律、法规、规章、条例以及任何具有法律效力之规范所限制或禁止的其它内容的；<br>* 含有花手领券认为不适合展示的内容。 <br>5、在与其他用户交易过程中，遵守诚实信用原则，不采取不正当竞争行为，不扰乱网上交易的正常秩序，不从事与网上交易无关的行为。 <br>6、不以虚构或歪曲事实的方式不当评价其他用户，不采取不正当方式制造或提高自身的信用度，不采取不正当方式制造或提高（降低）其他用户的信用度。<br>7、不对花手领券平台上的任何数据作商业性利用，包括但不限于在未经花手领券事先书面同意的情况下，以复制、传播等任何方式使用花手领券站上展示的资料。 <br>8、花手领券禁止用户在花手领券的合作商城内进行任何形式的推广。 <br>9、您不得使用任何装置、软件或例行程序干预或试图干预花手领券平台的正常运作或正在花手领券上进行的任何交易、活动。您不得采取任何将导致不合理的庞大数据负载加诸花手领券网络设备的行动，否则花手领券将追究您的相关责任，包括但不限于列入花手领券黑名单账户、冻结账户或者注销账户等。如造成花手领券损失或者承担相应法律责任的，花手领券有权要求您赔偿并最终承担相应的责任。<br>10、您了解并同意花手领券有权作如下处理： <br>（1）花手领券有权对您是否违反上述承诺做出单方认定，并根据单方认定结果适用规则予以处理，这无须征得您的同意。 <br>（2）对于您涉嫌违反承诺的行为对任意第三方造成损害的，您均应当以自己的名义独立承担所有的法律责任，并应确保花手领券免于因此产生损失或增加费用。如花手领券因此承担相应责任或者赔偿相关损失，则您承诺花手领券可以向您追偿，相关责任或损失由您最终承担，相关损失包括合理的律师费用、相关机构的查询费用等。 <br>（3）对于您在花手领券上发布的涉嫌违法或涉嫌侵犯他人合法权利或违反本协议和/或规则的信息，花手领券有权予以删除，且按照规则的规定进行处罚。 <br>（4）对于您在花手领券上实施的行为，包括您未在花手领券上实施但已经对花手领券及其用户产生影响的行为，花手领券有权单方认定您行为的性质及是否构成对本协议和/或规则的违反，并据此作出相应处罚。您应自行保存与您行为有关的全部证据，并应对无法提供充要证据而承担的不利后果。 <br>（5）花手领券并无能力对您的相关注册、登记资料进行实质性审查，因此一旦因您的注册、登记资料的问题导致的相关后果应全部由您自己承担，花手领券对此不承担责任。如果根据法律法规要求花手领券先行承担了相关责任，那么您承诺花手领券有权向您追偿，由您最终承担上述责任。 <br>（6）如您涉嫌违反有关法律或者本协议之规定，使花手领券遭受任何损失，或受到任何第三方的索赔，或受到任何行政管理部门的处罚，您应当赔偿花手领券因此造成的损失及（或）发生的费用，包括合理的律师费用、相关机构的查询费用等。 <br>（7）花手领券上展示的资料（包括但不限于文字、图表、标识、图像、数字下载和数据编辑）均为花手领券或其内容提供者的财产或者权利；花手领券上所有内容的汇编是属于花手领券的著作权；花手领券上所有软件都是花手领券或其关联公司或其软件供应商的财产或者权利，上述知识产权均受法律保护。如您侵犯上述权利，花手领券有权根据规则对您进行处理并追究您的法律责任。 <br>（8）经国家行政或司法机关的生效法律文书确认您存在违法或侵权行为，或者花手领券根据自身的判断，认为您的行为涉嫌违反本协议和/或规则的条款或涉嫌违反法律法规的规定的，则花手领券有权在花手领券上公示您的该等涉嫌违法或违约行为及花手领券已对您采取的措施。</p><p>五、特别授权</p><p>您完全理解并不可撤销地授予花手领券及其关联公司下列权利： <br>1、一旦您违反本协议，或与花手领券签订的其他协议的约定，花手领券有权以任何方式通知花手领券关联公司或其合作组织，要求其对您的权益采取限制措施，包括但不限于要求花手领券及关联公司中止、终止对您提供部分或全部服务，且在其经营或实际控制的任何网站公示您的违约情况。<br>2、一旦您向花手领券或其关联公司或其合作组织作出任何形式的承诺，且相关公司或组织已确认您违反了该承诺，则花手领券有权立即按您的承诺或协议约定的方式对您的账户采取限制措施，包括中止或终止向您提供服务，并公示相关公司确认的您的违约情况。您了解并同意，除非法律法规另有明确要求，花手领券无须就相关确认与您核对事实，或另行征得您的同意，且花手领券无须就此限制措施或公示行为向您承担任何的责任。 <br>3、对于您在注册、登记或者交易中记录的资料及数据信息，您理解并同意授予花手领券及其关联公司或其合作组织独家的、永久的、免费的全球范围内使用并许可他人使用的权利。</p><p>六、责任范围和责任限制</p><p>1、花手领券仅对自身提供的服务承担责任。 花手领券对于第三方向用户提供的服务和产品不提供保证也不承担任何责任。 <br>2、您了解花手领券上的信息系第三方或者其他用户自行发布，且可能存在风险和瑕疵。花手领券仅作为您获取物品或服务信息、物色交易对象、就物品和/或服务的交易进行协商及开展交易的场所，但花手领券无法控制交易所涉及的物品的质量、安全或合法性，商贸信息的真实性或准确性，以及交易各方履行其在贸易协议中各项义务的能力。您应自行谨慎判断确定相关物品及/或信息的真实性、合法性和有效性，并自行承担相关风险。 <br>3、除非法律法规明确要求，或出现以下情况，否则，花手领券没有义务对所有用户的注册数据、商品（服务）信息、交易行为以及与交易有关的其它事项进行事先审查： <br>a)花手领券有合理的理由认为特定用户及具体交易事项可能存在重大违法或违约情形。 <br>b)花手领券有合理的理由认为用户在花手领券的行为涉嫌违法或不当。 <br>4、花手领券上的商品价格、数量、是否有货等商品信息随时有可能发生变动，花手领券不就此作出特别通知。您知悉并理解由于网站上商品信息数量极其庞大，虽然花手领券会尽合理的最大努力保证您所浏览的商品信息的准确性、迅捷性，但由于众所周知的互联网技术因素等客观原因，花手领券显示的信息可能存在一定的滞后性和差错，由此给您带来的不便或产生相应问题，花手领券不承担责任。 <br>5、您理解并同意，花手领券不对因下述任一情况而导致您的任何损害赔偿承担责任，包括但不限于利润、商誉、使用、数据等方面的损失或其它无形损失的损害赔偿 (无论花手领券是否已被告知该损害赔偿的可能性)：<br>a)第三方未经批准的使用您的账户或更改您的数据；您的传输或数据遭到未获授权的存取或变更。<br>b)任何第三方在本服务中所作之声明或行为； 任何非因花手领券的原因而引起的与花手领券服务有关的其它损失。<br>您理解并同意，花手领券及其关联公司并非司法机构，花手领券及其关联公司无法保证您和第三方的争议处理结果符合您的期望，也不对争议调处结论承担任何责任。如您因此遭受损失，您同意自行通过法律途径向受益人或者其他相关人员索偿。 <br>6、您了解并同意，花手领券不对因下述任一情况而导致您的任何损害赔偿承担责任，包括但不限于利润、商誉、使用、数据等方面的损失或其它无形损失的损害赔偿 (无论花手领券是否已被告知该等损害赔偿的可能性)： <br>a) 您对花手领券服务的误解。 <br>b) 第三方未经批准的使用您的账户或更改您的数据。 <br>c) 任何非因花手领券的原因而引起的与花手领券服务有关的其它损失。 <br>7、不论在何种情况下，花手领券均不对由于起义、骚乱、火灾、罢工、暴乱、洪水、风暴、爆炸、战争、政府行为、司法行政机关的命令，以及其它非因花手领券的原因而造成的不能服务或延迟服务承担责任。</p><p>七、协议终止</p><p>1、您同意，花手领券有权依据本协议决定中止、终止向您提供部分或全部花手领券平台服务，暂时冻结或永久冻结（注销）您的账户，且无须为此向您或任何第三方承担任何责任，但本协议或法律法规另有明确要求的除外。 <br>2、出现以下情况时，花手领券有权直接以注销账户的方式终止本协议：<br>a) 您提供的电子邮箱不存在或无法接收电子邮件，且没有其他方式可以与您进行联系，或花手领券以其它联系方式通知您更改电子邮件信息，而您在花手领券通知后七个工作日内仍未更改为有效的电子邮箱的；<br>b) 用户超过两年无登陆记录；<br>c) 您注册信息中的主要内容不真实或不准确或不及时或不完整； <br>d) 花手领券终止向您提供服务后，您涉嫌再一次直接或间接或以他人名义注册为花手领券用户的；<br>e)本协议（含规则）变更时，您明示并通知花手领券不愿接受新的服务协议的； <br>f)其它花手领券认为应当终止服务的情况。 <br>3、您有权向花手领券要求注销您的账户，经花手领券审核同意的，花手领券注销（永久冻结）您的账户，届时，您与花手领券基于本协议的合同关系即终止。<br>4、您的账户被注销（永久冻结）后，花手领券没有义务为您保留或向您披露您账户中的任何信息，也没有义务向您或第三方转发任何您未曾阅读或发送过的信息。 <br>5、您同意，您与花手领券的合同关系终止后，花手领券及其关联公司或者其合作组织仍享有下列权利 <br>a)继续保存并使用您的注册、登记信息、数据及您使用花手领券服务期间的所有交易数据。 <br>b)您在使用花手领券服务期间存在违法行为或违反本协议和/或规则的行为的，花手领券仍可依据本协议向您主张权利。</p><p>八、隐私权政策</p><p>1、花手领券对希望成为用户的用户没有任何限制，但18岁以下的用户使用花手领券服务必须取得监护人的同意； <br>2、一个帐号仅限一个用户使用，用户必须向花手领券提供真实确实的信息，对于由于资料提供不正确导致任何不良后果的，花手领券不承担责任； <br>3、用户资料修改后必须及时通知花手领券做出相应变更； <br>4、花手领券及其关联公司承诺不向其它第三方机构透露用户涉及隐私的信息；<br>5、您理解并同意花手领券可能会与第三方合作向用户提供相关的网络服务，在此情况下，如该第三方同意承担与本站同等的保护用户隐私的责任，则本站可将用户的注册资料等提供给该第三方； <br>6、用户必须遵守花手领券（及合作组织）的使用条款及隐私政策。</p><p>九、法律适用、管辖与其他</p><p>1、本协议之效力、解释、变更、执行与争议解决均适用中华人民共和国法律，如无相关法律规定的，则应参照通用国际商业惯例和（或）行业惯例。 <br>2、因本协议产生之争议，应依照中华人民共和国法律予以处理。双方对于争议协商不成的，应当提交上海闻息企业发展有限公司企业所在地人民法院诉讼解决。</p><p>十、条款可分割性</p><p>本协议的任何条款（或条款部分内容）被认定为无效、非法或不可执行的，该条款仅在该禁止和不可执行的范围内无效，而不会致使本条款的其余部分或本协议的其余条款失效。在适用法律允许的前提下，本协议各方特此同意放弃导致本协议条款在任何方面无效、非法或不可执行的法律条款。</p><p>花手领券在此声明，您通过本软件参加的任何商业活动，与Apple Inc.无关。</p><p><br></p>',
                'category_id' => 0,
                'view' => NULL,
                'thumbnail' => NULL,
                'images' => NULL,
                'sort' => 0,
                'status' => '1',
                'click' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-08-21 04:04:53',
                'updated_at' => '2018-08-21 04:36:32',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'slug' => '怎么分享优惠券？',
                'title' => '怎么分享优惠券？',
                'body' => '<p></p><p>点击产品详情页，点击分享佣金，进入分享页，你可以直接复制淘口令给好友，也可以发送商品二维码海报给好友，只要用户购买您分享的产品，即可获得相应的佣金奖励。<br></p>',
                'category_id' => 2,
                'view' => NULL,
                'thumbnail' => NULL,
                'images' => NULL,
                'sort' => 0,
                'status' => '0',
                'click' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-08-21 04:53:00',
                'updated_at' => '2018-08-21 04:53:00',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'slug' => '如何提现？',
                'title' => '如何提现？',
                'body' => '<p></p><p>可提现余额大于1元可以提现，提现前绑定您的支付宝账号以及实名信息，即可提交提现申请，500元以下的提现金额，2小时内到账；500元以上的提现金额，后台系统需要审核，48小时后到账。<br></p>',
                'category_id' => 2,
                'view' => NULL,
                'thumbnail' => NULL,
                'images' => NULL,
                'sort' => 0,
                'status' => '0',
                'click' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-08-21 04:55:09',
                'updated_at' => '2018-08-21 04:55:09',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'slug' => '同一商品优惠券可以领多少次？',
                'title' => '同一商品优惠券可以领多少次？',
                'body' => '<p></p><p>这个是商家设置的，有些同一淘宝账号只能领一次，有些可以领多次。<br></p>',
                'category_id' => 2,
                'view' => NULL,
                'thumbnail' => NULL,
                'images' => NULL,
                'sort' => 0,
                'status' => '1',
                'click' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-08-21 04:56:13',
                'updated_at' => '2018-08-21 04:56:13',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'slug' => '为什么领券提示优惠券已失效？',
                'title' => '为什么领券提示优惠券已失效？',
                'body' => '<p></p><p>原因有二个：1）优惠券已被领完； 2）商家已取消宝贝优惠券。<br></p>',
                'category_id' => 2,
                'view' => NULL,
                'thumbnail' => NULL,
                'images' => NULL,
                'sort' => 0,
                'status' => '1',
                'click' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-08-21 04:57:05',
                'updated_at' => '2018-08-21 04:57:05',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'slug' => '什么时候可以提现？',
                'title' => '什么时候可以提现？',
                'body' => '<p></p><p>每个月25号已结算的佣金收入，可以提现到支付宝账号，最低一元起提现。剩余的角分可累计到下个月<br></p>',
                'category_id' => 2,
                'view' => NULL,
                'thumbnail' => NULL,
                'images' => NULL,
                'sort' => 0,
                'status' => '1',
                'click' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-08-21 04:59:04',
                'updated_at' => '2018-08-21 04:59:04',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'slug' => '为什么下单后没有佣金？',
                'title' => '为什么下单后没有佣金？',
            'body' => '<p></p><p>1）买家使用了农村淘宝APP，一淘，集分宝 ，返利网&nbsp;<br>2）买家使用了收藏夹或加入了购物车后，再购买5)买家使用了支付宝红包，淘金币等&nbsp;<br>3)买家手机或被安装了一些流氓软件，劫持了PID<br>4)买家网络所使用的DNS被污染，劫持了PID&nbsp;<br>5)买家所在地区宽带服务运营商劫持了PID&nbsp;<br>6）商家联系买家 拍另外一个没佣金链接&nbsp;<br>7）买家切换了别的旺旺下单或找别的淘客转化了链接<br>8）淘宝数据同步到花生日记需要15分钟左右，即可查看到订单和佣金<br></p>',
            'category_id' => 0,
            'view' => NULL,
            'thumbnail' => NULL,
            'images' => NULL,
            'sort' => 0,
            'status' => '1',
            'click' => 0,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => '2018-08-21 05:00:05',
            'updated_at' => '2018-08-21 05:00:05',
            'deleted_at' => NULL,
        ),
        18 => 
        array (
            'id' => 19,
            'slug' => '已确认收货的订单失效了？',
            'title' => '已确认收货的订单失效了？',
            'body' => '<p></p><p>这种是维权订单，是确认收货之后去申请售后进行退款了，属失效订单<br></p>',
            'category_id' => 2,
            'view' => NULL,
            'thumbnail' => NULL,
            'images' => NULL,
            'sort' => 0,
            'status' => '1',
            'click' => 0,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => '2018-08-21 05:01:24',
            'updated_at' => '2018-08-21 05:01:24',
            'deleted_at' => NULL,
        ),
        19 => 
        array (
            'id' => 20,
            'slug' => '有订单笔数却没有佣金显示？',
            'title' => '有订单笔数却没有佣金显示？',
            'body' => '<p></p><p></p><p>这些订单为失效订单，APP在统计订单时是包含了失效订单。<br></p><p><br></p>',
            'category_id' => 2,
            'view' => NULL,
            'thumbnail' => NULL,
            'images' => NULL,
            'sort' => 0,
            'status' => '1',
            'click' => 0,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => '2018-08-21 05:02:25',
            'updated_at' => '2018-08-21 05:03:17',
            'deleted_at' => NULL,
        ),
        20 => 
        array (
            'id' => 21,
            'slug' => '领券后多买的件数有佣金吗？',
            'title' => '领券后多买的件数有佣金吗？',
            'body' => '<p></p><p>只要通过花生日记链接购买的商品，佣金是可以叠加的<br></p>',
            'category_id' => 2,
            'view' => NULL,
            'thumbnail' => NULL,
            'images' => NULL,
            'sort' => 0,
            'status' => '0',
            'click' => 0,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => '2018-08-21 05:04:04',
            'updated_at' => '2018-08-21 05:04:04',
            'deleted_at' => NULL,
        ),
        21 => 
        array (
            'id' => 22,
            'slug' => '（预估佣金）显示的和点进去创建分享后显示的佣金不一样？',
            'title' => '（预估佣金）显示的和点进去创建分享后显示的佣金不一样？',
            'body' => '<p></p><p>商品列表显示的预估佣金是采集淘宝的数据，每半小时更新一次，有延迟。而分享时看到的佣金收益是接口实时查询的，实际佣金以这个为准。<br></p>',
            'category_id' => 2,
            'view' => NULL,
            'thumbnail' => NULL,
            'images' => NULL,
            'sort' => 0,
            'status' => '0',
            'click' => 0,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => '2018-08-21 05:05:23',
            'updated_at' => '2018-08-21 05:05:23',
            'deleted_at' => NULL,
        ),
        22 => 
        array (
            'id' => 23,
            'slug' => '进入淘宝领券页面，不能领券，显示“系统休息中”',
            'title' => '进入淘宝领券页面，不能领券，显示“系统休息中”',
            'body' => '<p></p><p>这是手机淘宝的问题，请退出淘宝重新登录或重新下载，过一段时间后再试<br></p>',
            'category_id' => 2,
            'view' => NULL,
            'thumbnail' => NULL,
            'images' => NULL,
            'sort' => 0,
            'status' => '1',
            'click' => 0,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => '2018-08-21 05:06:48',
            'updated_at' => '2018-08-21 05:06:48',
            'deleted_at' => NULL,
        ),
    ));
        
        
    }
}