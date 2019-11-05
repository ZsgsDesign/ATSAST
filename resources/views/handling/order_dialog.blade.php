<style>
    <{include file="MHS.css" }>
    avatar{
        display: block;
        position: relative;
        text-align: center;
        height: 6rem;
    }
    avatar > img{
        display: block;
        width:6rem;
        height:6rem;
        border-radius: 2000px;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
        border: 1px solid rgba(0, 0, 0, 0.15);
        top:0%;
        left:0;
        right:0;
        margin: auto;
    }
    timeline {
        display: block;
        padding: 3em 2em 2em;
        position: relative;
        color: rgba(0, 0, 0, 0.7);
        border-left: 0.1rem solid rgba(0, 0, 0, 0.3);
    }
    timeline p {
        font-size: 1rem;
    }
    timeline::before {
        content: attr(date);
        position: absolute;
        left: 2rem;
        font-weight: bold;
        top: 1rem;
        display: block;
        font-family: 'Roboto', sans-serif;
        font-weight: 700;
        font-size: .785rem;
        line-height: 1rem;
    }
    timeline::after {
        width: 1rem;
        height: 1rem;
        display: block;
        top: 1rem;
        position: absolute;
        left: -0.55rem;
        border-radius: 10px;
        content: '';
        border: 0.1rem solid rgba(0, 0, 0, 0.3);
        background: white;
    }
    timeline:last-child {
        border-image-source: linear-gradient(rgba(0, 0, 0, 0.3) 60%, rgba(0, 0, 0, 0));
        border-image-slice: 1 0 0 100%;
        border-image-outset: 0;
        border-image-repeat: stretch;
        border-image-width: 0.1rem;
    }
    .time-line-card {
        padding: 1rem;
    }
    card.mhs-card > div{
        padding: 1rem;
    }
</style>

<div class="container mundb-standard-container">
    <h3 class="mhs-title mb-3 mt-3">订单详情
        <small>
        <{if $order['renter_id'] == $userinfo['uid']}><span class="badge badge-pill badge-light">借用</span><{else}><span class="badge badge-pill badge-dark">出借</span><{/if}>
        <{if $order['renter_id'] == $userinfo['uid']}>
            <{if $order['scode'] == 1}><span class="badge badge-info">等待取用</span><{else if $order['scode'] == 2}><span class="badge badge-info">等待归还</span><{else if $order['scode'] == 3}><span class="badge badge-info">等待评价</span><{else if $order['scode'] == 4}><span class="badge badge-success">订单完成</span><{else if $order['scode'] == 5}><span class="badge badge-secondary">订单取消</span><{else if $order['scode'] == 6}><span class="badge badge-warning">您已超时未归还</span><{/if}>
        <{else}>
            <{if $order['scode'] == 1}><span class="badge badge-info">等待对方取用</span><{else if $order['scode'] == 2}><span class="badge badge-info">等待对方归还</span><{else if $order['scode'] == 3}><span class="badge badge-info">等待评价</span><{else if $order['scode'] == 4}><span class="badge badge-success">订单完成</span><{else if $order['scode'] == 5}><span class="badge badge-secondary">订单取消</span><{else if $order['scode'] == 6}><span class="badge badge-warning">对方超时未归还</span><{/if}>
        <{/if}>
        </small>
    </h3>
    <{if $order['scode'] == 1}>
    <div class="jumbotron alert-info">
        <{if $order['renter_id'] == $userinfo['uid']}>
            <h1><strong>等待取用</strong></h1>
            <p class="lead">订单已生成，请到指定地点或与出借方联系以取得物品，取得后点击「确认取用」后开始计算归还时间。<br><strong>请在当天完成确认取用，否则订单将强制取消。</strong></p> <!-- TODO 1天未确认取用强制取消 -->
            <button class="btn btn-lg btn-success" data-toggle="modal" data-target="#Confirm">确认取用</button>
            <button class="btn btn-lg btn-warning" data-toggle="modal" data-target="#Cancel">取消订单</button>
        <{else}>
            <h1><strong>等待对方取用</strong></h1>
            <p class="lead">订单已生成，在借用方取得物品并「确认取用」后开始计算归还时间。</p>
        <{/if}>
    </div>
    <{else if $order['scode'] == 2}>
    <div class="jumbotron alert-primary">
        <{if $order['renter_id'] == $userinfo['uid']}>
            <h1><strong>等待归还</strong></h1>
            <p class="lead">已确认取得物品，请在 「<{$order['due_time']}>」前归还物品，并提醒出借方「确认归还」。</p>
        <{else}>
            <h1><strong>等待对方归还</strong></h1>
            <p class="lead">对方已确认取得物品，物品将在 「<{$order['due_time']}>」 前归还，请在借用方归还后点击「确认归还」。</p>
            <button class="btn btn-lg btn-warning" data-toggle="modal" data-target="#Return">确认归还</button>
        <{/if}>
    </div>
    <{else if $order['scode'] == 5}>
    <div class="jumbotron alert-secondary">
        <h1><strong>订单已取消</strong></h1>
        <p class="lead">该订单已被取消。</p>
    </div>
    <{else if $order['scode'] == 6}>
    <div class="jumbotron alert-danger">
        <h1><strong>订单已逾期</strong></h1>
        <{if $order['renter_id'] == $userinfo['uid']}>
        <p class="lead">该订单已逾期，请尽快归还物品，并提醒出借方「确认归还」，以免扣除更多的信用分。</p>
        <{else}>
        <p class="lead">该订单已逾期，请提醒借用方尽快归还物品。<br><strong>如已收到物品，请点击「确认归还」。</strong></p>
        <button class="btn btn-lg btn-warning" data-toggle="modal" data-target="#Return">确认归还</button>
        <{/if}>
    </div>
    <{else if $order['scode'] == 4}>
    <div class="jumbotron alert-success">
        <h1><strong>订单已完成</strong></h1>
        <p class="lead">
            <br/>
            <span style="font-size:30px;font-weight:bold">TA&nbsp;</span>给了您一个
            <{if $userinfo['uid'] == $order['renter_id']}>
                    <{if $order['owner_review'] == -1}>
                        <strong>差评👎</strong>
                    <{else if $order['owner_review'] == 0}>
                        <strong>中评🤔</strong>
                    <{else if $order['owner_review'] == 1}>
                        <strong>好评👍</strong>
                    <{/if}>
            <{else}>
                <{if $order['renter_review'] == -1}>
                    <strong>差评👎</strong>
                <{else if $order['renter_review'] == 0}>
                    <strong>中评🤔</strong>
                <{else if $order['renter_review'] == 1}>
                    <strong>好评👍</strong>
                <{/if}>
            <{/if}>
        </p>
        <p class="lead">该订单已完成，感谢您的使用。</p>
    </div>
    <{else if $order['scode'] == 3}>
    <div class="jumbotron alert-info">
        <{if $order['renter_id'] == $userinfo['uid']}>
            <{if !strlen($order['renter_review'])}>
                    <h1><strong>订单等待您的评价</strong></h1>
                    <p class="lead">物品已归还，请您对本次借用进行评价。</p>
                    <button class="btn btn-lg btn-success" data-toggle="modal" data-target="#Review">写评价</button>
            <{else}>
                    <h1><strong>订单等待出借方的评价</strong></h1>
                    <p class="lead">物品已归还，请等待对方完成评价。</p>
            <{/if}>
        <{else}>
            <{if !strlen($order['owner_review'])}>
                    <h1><strong>订单等待您的评价</strong></h1>
                    <p class="lead">物品已归还，请您对本次借用进行评价。</p>
                    <button class="btn btn-lg btn-success" data-toggle="modal" data-target="#Review">写评价</button>
            <{else}>
                    <h1><strong>订单等待借用方的评价</strong></h1>
                    <p class="lead">物品已归还，请等待对方完成评价。</p>
            <{/if}>
        <{/if}>
    </div>
    <{/if}>
    <{if $order['scode'] == 4}>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <card class="p-3">
                <div class="media">
                    <{if $order['renter_id'] == $userinfo['uid']}>
                    <avatar class="mr-3 align-self-start"><img src="<{$order['renter_avatar']}>"></avatar>
                    <{else}>
                    <avatar class="mr-3 align-self-start"><img src="<{$order['avatar']}>"></avatar>
                    <{/if}>
                    <div class="media-body">
                        <{if $order['renter_id'] == $userinfo['uid']}>
                        <{if $order['renter_review'] == '-1'}><h5 class="mt-0 text-warning">我的评价：差评</h5><{else if $order['renter_review'] == '0'}><h5 class="mt-0 text-dark">我的评价：中评</h5><{else}><h5 class="mt-0 text-success">我的评价：好评</h5><{/if}>
                        <{$order['renter_review_content']}>
                        <{else}>
                        <{if $order['owner_review'] == '-1'}><h5 class="mt-0 text-warning">我的评价：差评</h5><{else if $order['owner_review'] == '0'}><h5 class="mt-0 text-dark">我的评价：中评</h5><{else}><h5 class="mt-0 text-success">我的评价：好评</h5><{/if}>
                        <{$order['owner_review_content']}>
                        <{/if}>
                    </div>
                </div>
            </card>
        </div>
        <div class="col-md-6 col-sm-12">
            <card class="p-3">
                <div class="media">
                    <{if $order['renter_id'] != $userinfo['uid']}>
                    <avatar class="mr-3 align-self-start"><img src="<{$order['renter_avatar']}>"></avatar>
                    <{else}>
                    <avatar class="mr-3 align-self-start"><img src="<{$order['avatar']}>"></avatar>
                    <{/if}>
                    <div class="media-body">
                        <{if $order['renter_id'] != $userinfo['uid']}>
                        <{if $order['renter_review'] == '-1'}><h5 class="mt-0 text-warning">对方评价：差评</h5><{else if $order['renter_review'] == '0'}><h5 class="mt-0 text-dark">对方评价：中评</h5><{else}><h5 class="mt-0 text-success">对方评价：好评</h5><{/if}>
                        <{$order['renter_review_content']}>
                        <{else}>
                        <{if $order['owner_review'] == '-1'}><h5 class="mt-0 text-warning">对方评价：差评</h5><{else if $order['owner_review'] == '0'}><h5 class="mt-0 text-dark">对方评价：中评</h5><{else}><h5 class="mt-0 text-success">对方评价：好评</h5><{/if}>
                        <{$order['owner_review_content']}>
                        <{/if}>
                    </div>
                </div>
            </card>
        </div>
    </div>
    <{else if $order['scode'] == 3 }>
    <{if ($order['renter_id'] == $userinfo['uid'] && strlen($order['renter_review'])) || ($order['renter_id'] != $userinfo['uid'] && strlen($order['owner_review'])) }>
    <card class="p-3">
        <div class="media">
            <{if $order['renter_id'] == $userinfo['uid']}>
            <avatar class="mr-3 align-self-start"><img src="<{$order['renter_avatar']}>"></avatar>
            <{else}>
            <avatar class="mr-3 align-self-start"><img src="<{$order['avatar']}>"></avatar>
            <{/if}>
            <div class="media-body">
                <{if $order['renter_id'] == $userinfo['uid']}>
                <{if $order['renter_review'] == '-1'}><h5 class="mt-0 text-warning">我的评价：差评</h5><{else if $order['renter_review'] == '0'}><h5 class="mt-0 text-dark">我的评价：中评</h5><{else}><h5 class="mt-0 text-success">我的评价：好评</h5><{/if}>
                <{$order['renter_review_content']}>
                <{else}>
                <{if $order['owner_review'] == '-1'}><h5 class="mt-0 text-warning">我的评价：差评</h5><{else if $order['owner_review'] == '0'}><h5 class="mt-0 text-dark">我的评价：中评</h5><{else}><h5 class="mt-0 text-success">我的评价：好评</h5><{/if}>
                <{$order['owner_review_content']}>
                <{/if}>
            </div>
        </div>
    </card>
    <{/if}>
    <{/if}>
    <card class="time-line-card">
        <!--timeline待order表增加return_time字段后再增加一个成功归还-->
        <{if $order['scode'] == 6}>
        <timeline date="<{$order['due_time']}>">
            <h3>已逾期</h3>
            <{if $order['renter_id'] == $userinfo['uid'] }>
            <p>该订单已逾期，请尽快归还物品，并提醒出借方「确认归还」，以免扣除更多的信用分。</p>
            <{else}>
            <p>订单已逾期，请提醒借用方尽快归还物品。<strong>如已收到物品，请点击「确认归还」。</strong></p>
            <{/if}>
        </timeline>
        <{else if $order['scode'] == 5}>
        <timeline date="<{$order['return_time']}>">
            <h3>已取消</h3>
            <p>订单已被取消，感谢您的使用。</p>
        </timeline>
        <{else if $order['scode'] == 4}>
        <timeline date="<{date('Y-m-d H:i:s',strtotime('now'))}>">
            <h3>已完成</h3>
            <p>物品已于「<{$order['return_time']}>」归还，感谢您的使用。</p>
        </timeline>
        <{/if}>
        <{if $order['scode'] == 3 || $order['scode'] == 4}>
        <timeline date="<{$order['return_time']}>">
            <h3>已归还</h3>
            <p>订单正在等待双方完成互评。</p>
        </timeline>
        <{/if}>
        <{if $order['scode'] > 1 && $order['scode'] != 5}>
        <timeline date="<{$order['rent_time']}>">
            <h3>等待归还</h3>
            <{if $order['renter_id'] == $userinfo['uid'] }>
            <p>已确认取得物品，请在 「<{$order['due_time']}>」 前归还物品，并提醒出借方「确认归还」。</p>
            <{else}>
            <p>对方已确认取得物品，物品将在 「<{$order['due_time']}>」 前归还，请在借用方归还后点击「确认归还」。</p>
            <{/if}>
        </timeline>
        <{/if}>
        <timeline date="<{$order['create_time']}>">
            <h3>等待取用</h3>
            <{if $order['renter_id'] == $userinfo['uid'] }>
            <p>订单已生成，请到指定地点或与出借方联系以取得物品，取得后点击「确认取用」后开始计算归还时间。<strong>请在当天完成确认取用，否则订单将强制取消。</strong></p>
            <{else}>
            <p>订单已生成，等待对方取得物品并在「确认取用」后开始计算归还时间。</p>
            <{/if}>
        </timeline>
    </card>

    <card class="order-card p-3">
        <div class="media">
            <img class="mhs-item-img-order" src="<{$MHS_DOMAIN}>/pic/<{$order['iid']}>?size=400">
            <div class="media-body ml-3 mt-3">
                <h4><a href="<{$MHS_DOMAIN}>/item/detail/<{$order['iid']}>"><{$order['name']}></a></h4>
            </div>
        </div>
        <table class="table table-borderless table-hover">
            <tbody>
            <tr>
                <th scope="row">订单编号</th>
                <td id="oid"><{$order['oid']}></td>
            </tr>
            <tr>
                <th scope="row"><i class="MDI clock"></i>创建时间</th>
                <td><{$order['create_time']}></td>
            </tr>
            <tr>
                <th scope="row">出借方</th>
                <td><{$order['real_name']}></td>
            </tr>
            <tr>
                <th scope="row">借用方</th>
                <td><{$order['renter_real_name']}></td>
            </tr>
            <tr>
                <th scope="row">借用时限</th>
                <td><{$order['limit_time']}>天</td>
            </tr>
            <tr>
                <th scope="row">物品地点</th>
                <td><strong><{$order['location']}></strong></td>
            </tr>
            </tbody>
        </table>
    </card>
</div>
<{include file="order_dialog.html" }>

<script>
    function confirm(){
        let oid=document.querySelector('#oid').innerText;
        $.post("<{$MHS_DOMAIN}>/ajax/OperateOrder",{oid:oid,operation:'confirm'},function(data,status){
            console.log(data,status);
            window.location.reload();
        });
    }
    function cancel(){
        let oid=document.querySelector('#oid').innerText;
        $.post("<{$MHS_DOMAIN}>/ajax/OperateOrder",{oid:oid,operation:'cancel'},function(data,status){
            console.log(data,status);
            window.location.reload();
        });
    }
    function _return(){
        let oid=document.querySelector('#oid').innerText;
        $.post("<{$MHS_DOMAIN}>/ajax/OperateOrder",{oid:oid,operation:'return'},function(data,status){
            console.log(data,status);
            window.location.reload();
        });
    }
    function review(comment,text){
        let oid=document.querySelector('#oid').innerText;
        console.log(comment);
        console.log(text);
        $.post("<{$MHS_DOMAIN}>/ajax/ReviewOrder",{oid:oid,review:comment,content:text},function(data,status){
            console.log(data,status);
            window.location.reload();
        });
    }
</script>