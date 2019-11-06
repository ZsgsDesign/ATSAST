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
    <h2 class="mhs-title mb-3 mt-5">我的订单</h2>
    @if(!empty($orders))
    <table class="table col-12 table-hover table">
        <thead>
        <tr class="row">
            <th class="col-lg-3 col-md-4 col-6" scope="col">订单号 <i class="MDI arrow-up-bold"></i></th>
            <th class="col-lg-3 col-md-2 col-6" scope="col">物品名称</th>
            <th class="col-lg-1 d-none d-lg-block" scope="col">数量</th>
            <th class="col-lg-1 d-none d-lg-block" scope="col">对方</th>
            <th class="col-lg-2 col-md-3 d-none d-md-block" scope="col">创建时间</th>
            <th class="col-lg-2 col-md-3 d-none d-md-block" scope="col">归还时间</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $key => $r)
        <tr class="row">
            <td class="col-lg-3 col-md-4 col-6" scope="row">
                @if($r->renter_id == Auth::user()->id)<span class="badge badge-pill badge-light">借用</span>@else<span class="badge badge-pill badge-dark">出借</span>@endif
                @if($r->renter_id == Auth::user()->id)
                @if($r->scode == 0)
                <span class="badge badge-primary">订单已取消</span>
                @elseif($r->scode == 1)
                <span class="badge badge-info">等待取用</span>
                @elseif($r->scode == 2)
                <span class="badge badge-warning">等待归还</span>
                @elseif($r->scode == 3)
                <span class="badge badge-success">订单完成</span>
                @endif
                @else
                @if($r->scode == 0)
                <span class="badge badge-primary">订单已取消</span>
                @elseif($r->scode == 1)
                <span class="badge badge-info">等待对方取用</span>
                @elseif($r->scode == 2)
                <span class="badge badge-warning">等待对方归还</span>
                @elseif($r->scode == 3)
                <span class="badge badge-success">订单完成</span>
                @endif
                @endif
                <a href="{{$ATSAST_DOMAIN}}/handling/order/view/{{$r->oid}}">{{$r->oid}}</a>
                <button type="button" class="btn btn-sm btn-info dropdown-toggle mt-0 mb-0 float-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    操作
                </button>
                <div class="dropdown-menu">
                    @if($r->renter_id == Auth::user()->id && $r->scode == 1)
                    <a class="dropdown-item text-primary" href="JavaScript:confirm_({{$r->oid}});">确认取用</a>
                    <a class="dropdown-item text-danger" href="JavaScript:cancel_({{$r->oid}});">取消订单</a>
                    @elseif($r->renter_id != Auth::user()->id && $r->scode == 2)
                    <a class="dropdown-item text-primary" href="JavaScript:return_({{$r->oid}});">确认归还</a>
                    @else
                    <a class="dropdown-item disabled" href="#" disabled="true">没有可用的操作</a>
                    @endif
                </div>
            </td>
            <td class="col-lg-3 col-md-2 col-6"><a href="{{$ATSAST_DOMAIN}}/handling/detail/{{$r->iid}}">{{$r->name}}</a></td>
            <td class="col-lg-1 d-none d-lg-block">{{$r->count}}</td>
            <td class="col-lg-1 d-none d-lg-block">@if($r->renter_id == Auth::user()->id)
                {{$r->real_name}}
                @else
                {{$r->renter_real_name}}
                @endif
            </td>
            <td class="col-lg-2 col-md-3 d-none d-md-block">{{$r->create_time}}</td>
            <td class="col-lg-2 col-md-3 d-none d-md-block">{{$r->return_time}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            {{ $paginator->links() }}
        </ul>
    </nav>
    @else
    <div class="text-center">
        <p class="text-primary mt-5 mb-3">这里空空如也，快去借吧～</p>
        <button type="button" class="btn btn-raised btn-info" onclick="location.href='/handling/'">返回首页</button>
    </div>
    @endif
</div>

<script>
    function cancel_(oid){
        confirm({content:'您确定要取消该笔借用吗？',title:'取消订单'},function(deny){if(!deny){operate(oid,'cancel')}});
    }
    function confirm_(oid){
        confirm({content:'您确定取得物品了吗？',title:'确认取用'},function(deny){if(!deny){operate(oid,'confirm')}});
    }
    function return_(oid){
        confirm({content:'您确定对方归还了物品吗？',title:'确认归还'},function(deny){if(!deny){operate(oid,'return')}});
    }
    function operate(oid,operation){
        $.ajax({
            type: 'POST',
            url: '/ajax/handling/operateOrder',
            data: {
                oid:oid,
                operation:operation
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(ret){
                console.log(ret);
                window.location.reload();
            }, error: function(xhr, type){
                console.log(xhr);
                switch(xhr.status) {
                    case 422:
                        alert(xhr.responseJSON.errors[Object.keys(xhr.responseJSON.errors)[0]][0], xhr.responseJSON.message);
                        break;
                    case 429:
                        alert(`您的操作过于频繁，请 ${xhr.getResponseHeader('Retry-After')} 秒后再试。`);
                        break;
                    default:
                        alert("Server Connection Error");
                }
            }
        });
    }
</script>

@endsection
