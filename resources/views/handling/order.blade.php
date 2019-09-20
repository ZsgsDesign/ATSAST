@extends('layouts.app')

@section('template')

<style>
card {
    display: block;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
    border-radius: 20px;
    transition: .2s ease-out .0s;
    color: #7a8e97;
    background: #fff;
    padding: 0;
    position: relative;
    border: 1px solid rgba(0, 0, 0, 0.15);
    margin-bottom: 2rem;
}
statistic{
    display: block;
}
card:hover {
    box-shadow: rgba(0, 0, 0, 0.15) 0px 0px 100px;
}
badge{
    display: inline-block;
    padding: 0.25rem 0.75em;
    font-weight: 700;
    line-height: 1.5;
    text-align: center;
    vertical-align: baseline;
    border-radius: 0.125rem;
    background-color: #f5f5f5;
    margin: 1rem;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
    transition: .2s ease-out .0s;
    color: #7a8e97;
    position: relative;
    border: 1px solid rgba(0, 0, 0, 0.15);
    cursor: pointer;
}
.atsast-empty{
    justify-content: center;
    align-items: center;
    height: 10rem;
}
/* 这是展示物品的通用card 样式 */
card.item-card {
    overflow: hidden;
}
card.item-card > div{
    padding: 0;
    text-align: center;
}
a.card-link{
    padding:0;
}
.mhs-item-img {
    object-fit: cover;
}
.mhs-button {
    border-radius: 5px;
    padding:0.3rem 0.3rem;
    line-height:2;
}
.mhs-button-count {
    font-size: larger;
    padding:0.3rem 0.3rem;
    line-height:2;
}
.mhs-item-text {
    margin: 0.1rem;
}
/* ======= */
/* 这是订单、购物车用的card 样式*/
card.order-card {
    margin-bottom: 0.5rem;
}
card.order-card > div {
    padding: 0;
}
.mhs-item-img-order {
    border-radius: 20px !important;
    max-width: 10rem;
    max-height: 10rem;
    object-fit: cover;
}
.mhs-button-cart {
    border-radius: 20px;
}
.mhs-item-img-detailed {
     border-radius: 20px !important;
     max-width: 20rem;
     max-height: 20rem;
     object-fit: cover;
 }
.mhs-item-img-review {
    border-radius: 20px !important;
    max-width: 5rem;
    max-height: 5rem;
    object-fit: cover;
}
/* 来自mdui 的FAB */
.mdui-fab-fixed{
    position: fixed !important;
}
@media (min-width: 1px) {
    .mdui-fab-fixed{
        position: fixed !important;
        right: 16px;
        bottom: 16px;
    }
}
@media (min-width: 1024px) {
    .mdui-fab-fixed{
        position: fixed !important;
        right: 24px;
        bottom: 24px;
    }
}
</style>
<div class="container mundb-standard-container">
    <h2 class="mhs-title mb-3 mt-5">我的订单<small><{if $info_count > 0}><span class="badge badge-secondary"><{$info_count}></span><{/if}></small></h2>
    <{if $info_count > 0}>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        你有<{$info_count}>条新信息  <a href="JavaScript:$.post('<{$MHS_DOMAIN}>/ajax/clearchecked',{type:'A',function(){$.post('<{$MHS_DOMAIN}>/ajax/clearchecked',{type:'B'},function(){location.reload()})}})" class="alert-link">全部标记为已读</a>
    </div>
    <{/if}>
    <{if !empty($orders)}>
    <table class="table col-12 table-hover table">
        <thead>
        <tr class="row">
            <th class="col-lg-4 col-md-4 col-6" scope="col">订单号 <i class="MDI arrow-up-bold"></i></th>
            <th class="col-lg-4 col-md-5 col-6" scope="col">物品名称</th>
            <th class="col-lg-1 d-none d-lg-block" scope="col">数量</th>
            <th class="col-lg-1 d-none d-lg-block" scope="col">对方</th>
            <th class="col-lg-2 col-md-3 d-none d-md-block" scope="col">创建时间</th>
        </tr>
        </thead>
        <tbody>
        <{foreach $orders as $key => $r}>
        <{if in_array($r['oid'],$typeA)}>
        <tr class="row alert-success">
            <{else if in_array($r['oid'],$typeB)}>
        <tr class="row alert-warning">
            <{else}>
        <tr class="row">
            <{/if}>
            <td class="col-lg-4 col-md-4 col-6" scope="row">
                <{if $r['renter_id'] == $userinfo['uid']}><span class="badge badge-pill badge-light">借用</span><{else}><span class="badge badge-pill badge-dark">出借</span><{/if}>
                <{if $r['renter_id'] == $userinfo['uid']}>
                <{if $r['scode'] == 1}>
                <span class="badge badge-info">等待取用</span>
                <{else if $r['scode'] == 2}>
                <span class="badge badge-primary">等待归还</span>
                <{else if $r['scode'] == 3}>
                <{if !strlen($r['renter_review'])}>
                <span class="badge badge-info">等待评价</span>
                <{else}>
                <span class="badge badge-info">等待对方评价</span>
                <{/if}>
                <{else if $r['scode'] == 4}>
                <span class="badge badge-success">订单完成</span>
                <{else if $r['scode'] == 5}>
                <span class="badge badge-secondary">订单取消</span>
                <{else if $r['scode'] == 6}>
                <span class="badge badge-warning">您已超时未归还</span>
                <{/if}>
                <{else}>
                <{if $r['scode'] == 1}>
                <span class="badge badge-info">等待对方取用</span>
                <{else if $r['scode'] == 2}>
                <span class="badge badge-primary">等待对方归还</span>
                <{else if $r['scode'] == 3}>
                <{if !strlen($r['owner_review'])}>
                <span class="badge badge-info">等待评价</span>
                <{else}>
                <span class="badge badge-info">等待对方评价</span>
                <{/if}>
                <{else if $r['scode'] == 4}>
                <span class="badge badge-success">订单完成</span>
                <{else if $r['scode'] == 5}>
                <span class="badge badge-secondary">订单取消</span>
                <{else if $r['scode'] == 6}>
                <span class="badge badge-warning">对方超时未归还</span>
                <{/if}>
                <{/if}>
                <a href="<{$MHS_DOMAIN}>/order/view/<{$r['oid']}>"><{$r['oid']}></a>
                <button type="button" class="btn btn-sm btn-info dropdown-toggle mt-0 mb-0 float-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    操作
                </button>
                <div class="dropdown-menu">
                    <{if $r['renter_id'] == $userinfo['uid'] && $r['scode'] == 1}>
                    <a class="dropdown-item text-primary" href="JavaScript:oid=<{$r['oid']}>;$('#Confirm').modal('show');">确认取用</a>
                    <a class="dropdown-item text-danger" href="JavaScript:oid=<{$r['oid']}>;$('#Cancel').modal('show');">取消订单</a>
                    <{else if $r['renter_id'] != $userinfo['uid'] && $r['scode'] == 2}>
                    <a class="dropdown-item text-primary" href="JavaScript:oid=<{$r['oid']}>;$('#Return').modal('show');">确认归还</a>
                    <{else if $r['renter_id'] != $userinfo['uid'] && $r['scode'] == 6}>
                    <a class="dropdown-item text-primary" href="JavaScript:oid=<{$r['oid']}>;$('#Return').modal('show');">确认归还</a>
                    <{else if $r['scode'] == 3 && $r['renter_id'] == $userinfo['uid'] && !strlen($r['renter_review'])}>
                    <a class="dropdown-item text-primary" href="JavaScript:oid=<{$r['oid']}>;$('#Review').modal('show');">写评价</a>
                    <{else if $r['scode'] == 3 && $r['renter_id'] != $userinfo['uid'] && !strlen($r['owner_review'])}>
                    <a class="dropdown-item text-primary" href="JavaScript:oid=<{$r['oid']}>;$('#Review').modal('show');">写评价</a>
                    <{else}>
                    <a class="dropdown-item disabled" href="#" disabled="true">没有可用的操作</a>
                    <{/if}>
                </div>
            </td>
            <td class="col-lg-4 col-md-5 col-6"><a href="<{$MHS_DOMAIN}>/item/detail/<{$r['iid']}>"><{$r['name']}></a></td>
            <td class="col-lg-1 d-none d-lg-block"><{$r['count']}></td>
            <td class="col-lg-1 d-none d-lg-block"><{if $r['renter_id'] == $userinfo['uid']}>
                <{$r['real_name']}>
                <{else}>
                <{$r['renter_real_name']}><{/if}>
            </td>
            <td class="col-lg-2 col-md-3 d-none d-md-block"><{$r['create_time']}></td>
        </tr>
        <{/foreach}>
        </tbody>
    </table>
    <{if $pager !==null }>
    <ul class="pagination justify-content-center">
        <li style="display:inherit" class="page-item <{if $pager['current_page'] == $pager['prev_page']}> disabled <{/if}>">
            <a class="page-link" href="<{$MHS_DOMAIN}>/orders/?page=<{$pager['prev_page']}>" tabindex="-1"  aria-disabled="true" >首页</a>
            <a class="page-link" href="<{$MHS_DOMAIN}>/orders/?page=<{$pager['prev_page']}>" tabindex="-1"  aria-disabled="true" >上一页</a>
        </li>
        <{foreach $pager["all_pages"] as $i}>
            <li class="page-item <{if $i == $pager['current_page']}> active <{/if}> "><a class="page-link" href="<{$MHS_DOMAIN}>/orders/?page=<{$i}>"><{$i}></a></li>
        <{/foreach}>
        <li class="page-item <{if $pager['current_page'] == $pager['next_page']}> disabled <{/if}>">
            <a class="page-link" href="<{$MHS_DOMAIN}>/orders/?page=<{$pager['next_page']}>">下一页</a>
        </li>
    </ul>
    <{/if}>
    <{else}>
    <div class="text-center">
        <p class="text-primary mt-5 mb-3">这里空空如也，快去借吧～</p>
        <button type="button" class="btn btn-raised btn-info" onclick="location.href='<{$MHS_DOMAIN}>/'">返回首页</button>
    </div>
    <{/if}>
</div>

<{include file="order_dialog.html" }>

<script>
    let oid = -1;
    function confirm(){
        $.post("<{$MHS_DOMAIN}>/ajax/OperateOrder",{oid:oid,operation:'confirm'},function(data,status){
            console.log(data,status);
            location.href = "<{$MHS_DOMAIN}>/order/view/"+oid;
        });
    }
    function cancel(){
        $.post("<{$MHS_DOMAIN}>/ajax/OperateOrder",{oid:oid,operation:'cancel'},function(data,status){
            console.log(data,status);
            location.href = "<{$MHS_DOMAIN}>/order/view/"+oid;
        });
    }
    function _return(){
        $.post("<{$MHS_DOMAIN}>/ajax/OperateOrder",{oid:oid,operation:'return'},function(data,status){
            console.log(data,status);
            location.href = "<{$MHS_DOMAIN}>/order/view/"+oid;
        });
    }
    function review(comment,text){
        console.log(comment);
        console.log(text);
        $.post("<{$MHS_DOMAIN}>/ajax/ReviewOrder",{oid:oid,review:comment,content:text},function(data,status){
            console.log(data,status);
            location.href = "<{$MHS_DOMAIN}>/order/view/"+oid;
        });
    }
</script>
@inlude('js.common.item');


@endsection