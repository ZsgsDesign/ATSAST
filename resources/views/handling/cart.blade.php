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
<style>
    @media (max-width: 400px) {
        .mhs-item-img-order{
            max-width: 5rem !important;
            max-height: 5rem !important;
        }
    }
    @media (max-width: 576px) and (min-width: 401px) {
        .mhs-item-img-order{
            max-width: 7rem !important;
            max-height: 7rem !important;
        }
    }
</style>
<div class="container mundb-standard-container"> 
    <h2 class="mhs-title mb-3 mt-3">购物车</h2>
    <{if count($cart_items) == 0}>
    <h5 class="text-center text-info">这里空空如也，快去逛逛吧。</h5>
    <div class="row atsast-empty">
        <button type="button" class="btn btn-raised btn-info" onclick="location.href='<{$MHS_DOMAIN}>/'">返回首页</button>
    </div>
    <{else}>
    <div>
        <button type="button" class="btn btn-primary " onclick="document.querySelectorAll('.form-control').forEach(function(value){value.checked=true})">全选</button>
        <button type="button" class="btn btn-primary " onclick="document.querySelectorAll('.form-control').forEach(function(value){value.checked=false})">全不选</button>
        <button type="button" class="btn btn-warning " onclick="document.querySelectorAll('.form-control').forEach(function(value,index,arr){if(value.checked===true){addToCart_delete(value.getAttribute('iid'),false)} if(index+1 === arr.length){location.reload()}});">删除所选</button>
    </div>
    <{foreach $cart_items as $i => $item}>
    <card class="order-card mb-3">
            <div class="media">
                <div class="form-group ml-2 mr-2">
                    <div class="checkbox">
                        <label for="agreement<{$item['item_id']}>"><input class="form-control" type="checkbox" name="agreement" id="agreement<{$item['item_id']}>" iid="<{$item['item_id']}>" <{if $item['scode'] != 1}> disabled <{/if}>></label>
                    </div>
                </div>
                <img class="mhs-item-img-order" src="<{$MHS_DOMAIN}>/pic/<{$item['item_id']}>?size=400">
                <div class="media-body ml-3 mt-3">
                    <h5 class="text-left mundb-text-truncate-1 "><a href="<{$MHS_DOMAIN}>/item/detail/<{$item['item_id']}>"><{$item['name']}></a></h5>
                    <p class="text-left mundb-text-truncate-1 ">出借方：<a href="<{$MHS_DOMAIN}>/user/<{$item['owner']}>"><{$item['real_name']}></a></p>
                    <{if $item['scode'] == 1}>
                    <div class="btn-group">
                        <button id="minus<{$i}>" type="button" class="btn btn-sm btn-primary mhs-button-count" <{if $item['count'] < 2 }> disabled="disabled" <{/if}> onclick="minus(<{$i}>,<{$item['item_count']}>);addToCart(<{$item['item_id']}>,<{$i}>)">-</button>
                        <button id="count<{$i}>" type="button" class="btn btn-sm btn-primary mhs-button-count"><{$item['count']}></button>
                        <button id="add<{$i}>" type="button<{$i}>" class="btn btn-sm btn-primary mhs-button-count" onclick="add(<{$i}>,<{$item['item_count']}>);addToCart(<{$item['item_id']}>,<{$i}>)">+</button>
                    </div>
                    <{/if}>
                    <button type="button" class="btn btn-danger" onclick="addToCart_delete(<{$item['item_id']}>)">删除</button><!--此处的js代码若需要cid 使用<{$item['cid']}>即可 若需要 iid 使用 <{$item['item_id']}>-->
                    <{if $item['scode'] == -1}>
                    <p class="text-warning">该物品已下架</p>
                    <{else if $item['scode'] == 0}>
                    <p class="text-warning">该物品无库存</p>
                    <{/if}>
                </div>
            </div>
    </card>
    <{/foreach}>
    <br>
    <script>
    <{include file="MHS_Item.js" }>
    </script>
    <script>

        function addToCart_delete(id,reload=true) {
            $.post("<{$MHS_DOMAIN}>/ajax/AddToCart",{
                iid:id,
                count:-1,
            },function(result) {
                console.log(result);
                //result = JSON.parse(result);
                //console.log(result);
                //$.snackbar({content: result.desc,style:"toast text-center atsast-toast"});
            });
            if(reload){
                location.reload();
            }
        }

        let settlement=function(){
            NodeList.prototype.map=Array.prototype.map;
            function spliceFalse(arr){
                for(let i=0;i<arr.length;i++){
                    if(arr[i]==false){
                        arr.splice(i,1);
                        i--;
                    }
                }
            }
            let items=document.querySelectorAll('.form-control').map(function(val,index){
                if(val.checked===true){
                    return val.getAttribute('iid')
                }
                else{
                    return false;
                }
            });
            spliceFalse(items);
            if(items.length===0){
                $.snackbar({content: "请选择物品",style:"toast text-center atsast-toast"});
            }
            else{
                let args="?item[]="+items[0];
                for(let i=1;i<items.length;i++){
                    args+="&item[]="+items[i];
                }
                window.location.href="<{$MHS_DOMAIN}>/order/create/"+args;
            }
        }

    </script>
    <{/if}>
</div>

<button type="button" class="btn btn-success bmd-btn-fab mdui-fab-fixed active" onclick="settlement()"><i class="MDI check"></i></button>

@inlude('js.common.item');

@endsection