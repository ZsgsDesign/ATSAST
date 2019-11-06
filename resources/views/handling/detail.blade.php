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
    card.mhs-card > div{
        text-align: center;
        padding: 1rem;
    }
    statistic{
        display: block;
    }
    avatar{
        display: block;
        position: relative;
        text-align: center;
        height: 4rem;
    }
    avatar > img{
        display: block;
        width:4rem;
        height:4rem;
        border-radius: 2000px;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
        border: 1px solid rgba(0, 0, 0, 0.15);
        top:0%;
        left:0;
        right:0;
        margin: auto;
    }
    .d{
        position: fixed;
        top: 5px;
    }
    .top-fc{
        position: relative;
        top: -1rem;
    }
</style>
<div class="container mundb-standard-container">
    <h3 class="mhs-title mb-3 mt-3">物品详情</h3>
    @if($item_info->scode==-1)
    <h5 class="mhs-title text-danger mb-3">抱歉，该物品已下架。</h5>
    @elseif($item_info->scode==-2)
    <h5 class="mhs-title text-danger mb-3">此物品已删除，您现在查看的是它的存档。</h5>
    @endif
    <div class="row">
        <div class="col-lg-4 col-sm-12 col-12 text-center">
            <figure class="figure">
                <img class="mhs-item-img-detailed flo" src="{{$ATSAST_DOMAIN.$item_info->pic}}">
                <figcaption class="figure-caption text-center">
                    @if($item_info->scode>-1)
                    @if($item_info->owner!=Auth::user()->id)
                    <div class="btn-group">
                        <small class="mt-2 mr-3">物品数量:</small>
                        <button id="minus{{$item_info->iid}}" type="button" class="btn btn-sm btn-primary mhs-button-count" disabled="disabled" onclick="minus({{$item_info->iid}},{{$item_info->count}})"><strong>-</strong></button>
                        <button id="count{{$item_info->iid}}" type="button" @if($item_info->count==0) disabled="disabled" @endif class="btn btn-sm btn-primary mhs-button-count">@if($item_info->count==0) 0 @else 1 @endif</button>
                        <button id="add{{$item_info->iid}}" type="button" @if($item_info->count<2) disabled="disabled" @endif class="btn btn-sm btn-primary mhs-button-count" onclick="add({{$item_info->iid}},{{$item_info->count}})"><strong>+</strong></button>
                    </div>
                    <br>
                    <button class="btn btn-raised btn-warning mhs-button-cart" @if($item_info->count==0) disabled="disabled" @endif onclick="addToCart({{$item_info->iid}})"><i class="MDI cart"></i>加入购物车</button>
                    <button type="button" class="btn btn-raised btn-danger mhs-button-cart" @if($item_info->count==0) disabled="disabled" @endif onclick="borrowImmediately({{$item_info->iid}})">立即借用</button>
                    @else
                    <br>
                    <p>这是您发布的物品</p>
                    <button type="button" class="btn btn-raised mhs-button-cart btn-primary" onclick="location.href='/handing/edit/{{$item_info->iid}}'">编辑</button>
                    <button type="button" class="btn btn-warning mhs-button-cart btn-raised" onclick="alert2({content:'您确定要下架「{{$item_info->name}}」吗？',title:'下架物品'},function(deny){if(!deny){removeItem({{$item_info->iid}})}})"><i class="MDI close-box"></i>下架</button>
                    @endif
                    @elseif($item_info->scode==-1)
                    <br>
                    <p>这是您发布的物品</p>
                    <button type="button" class="btn btn-raised mhs-button-cart btn-primary" onclick="location.href='/handing/edit/{{$item_info->iid}}'">编辑</button>
                    <button type="button" class="btn btn-success mhs-button-cart btn-raised" onclick="alert2({content:'您确定要上架「{{$item_info->name}}」吗？',title:'下架物品'},function(deny){if(!deny){restoreItem({{$item_info->iid}})}})"><i class="MDI check"></i>上架</button>
                    @endif
                </figcaption>
            </figure>
        </div>

        <div class="col-lg-8 col-sm-12 col-12">
            <h4 class="text-left text-dark"><strong>{{$item_info->name}}</strong></h4>
            <table class="table table-borderless table-hover">
                <tbody>
                <tr>
                    <th scope="row"><i class="MDI clock"></i>发布时间</th>
                    <td>{{$item_info->create_time}}</td>
                </tr>
                <tr>
                    <th scope="row">需要归还</th>
                    <td>{{$item_info->need_return}}</td>
                </tr>
                <tr>
                    <th scope="row">当前库存</th>
                    <td>{{$item_info->count}}</td>
                </tr>
                <tr>
                    <th scope="row">物品地点</th>
                    <td>{{$item_info->location}}</td>
                </tr>
                <tr>
                    <th scope="row">出借笔数</th>
                    <td>{{$item_info->order_count}}</td>
                </tr>
                <tr>
                    <th scope="row">简介</th>
                    <td>{{$item_info->dec}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<br>
<script>
    function removeItem(id) {
        $.ajax({
            type: 'POST',
            url: '/ajax/handling/removeItem',
            data: {
                iid:id,
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(ret){
                console.log(ret);
                alert("下架成功！","恭喜");
                setTimeout(function(){
                    window.location.reload();
                }, 1000);
            }, error: function(xhr, type){
                console.log(xhr);
                switch(xhr.status) {
                    case 422:
                        alert(xhr.responseJSON.errors[Object.keys(xhr.responseJSON.errors)[0]][0], xhr.responseJSON.message);
                        break;
                    case 429:
                        alert(`Submit too often, try ${xhr.getResponseHeader('Retry-After')} seconds later.`);
                        break;
                    default:
                        alert("Server Connection Error");
                }
                console.log('Ajax error while posting to removeItem!');
            }
        });
    }

    function restoreItem(id) {
        $.ajax({
            type: 'POST',
            url: '/ajax/handling/restoreItem',
            data: {
                iid:id,
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(ret){
                console.log(ret);
                alert("上架成功！","恭喜");
                setTimeout(function(){
                    window.location.reload();
                }, 1000);
            }, error: function(xhr, type){
                console.log(xhr);
                switch(xhr.status) {
                    case 422:
                        alert(xhr.responseJSON.errors[Object.keys(xhr.responseJSON.errors)[0]][0], xhr.responseJSON.message);
                        break;
                    case 429:
                        alert(`Submit too often, try ${xhr.getResponseHeader('Retry-After')} seconds later.`);
                        break;
                    default:
                        alert("Server Connection Error");
                }
                console.log('Ajax error while posting to restoreItem!');
            }
        });
    }

    function minus(i,max=9999) {
        var count = $('#count' + i).text();
        if(count>1)
            $('#count' + i).text(--count);
        if(count<=1){
            $('#minus' + i).attr('disabled',true); //防止减到1以下
        }
        if(count<max){
            $('#add' + i).attr('disabled',false);
        }
    }

    function add(i,max=9999) {
        var count = $('#count' + i).text();
        $('#count' + i).text(++count);
        $('#minus' + i).attr('disabled',false);
        if(count>=max||max===1){
            $('#add' + i).attr('disabled',true);
        }
    }

    function addToCart(id) {
        $.ajax({
            type: 'POST',
            url: '/ajax/handling/addToCart',
            data: {
                iid:id,
                count:$('#count' + id).text(),
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(ret){
                console.log(ret);
                alert("添加成功！","恭喜");
            }, error: function(xhr, type){
                console.log(xhr);
                switch(xhr.status) {
                    case 422:
                        alert(xhr.responseJSON.errors[Object.keys(xhr.responseJSON.errors)[0]][0], xhr.responseJSON.message);
                        break;
                    case 429:
                        alert(`Submit too often, try ${xhr.getResponseHeader('Retry-After')} seconds later.`);
                        break;
                    default:
                        alert("Server Connection Error");
                }
                console.log('Ajax error while posting to addToCart!');
            }
        });
    }

    function borrowImmediately(id) {
        location.href= "{{$ATSAST_DOMAIN.route('handling.orderCreate',null,false)}}?iid="+id+"&count=" + $('#count' + id).text();
    }
</script>
@endsection
