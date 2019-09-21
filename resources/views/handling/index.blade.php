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
  h5{
      margin-bottom:0.25rem;
  }
  .form-control:disabled, .form-control[disabled]{
      background-color: transparent;
  }
  input{
      height: calc(2.4375rem + 2px);
  }
  .mhs-title{
      color: #7a8e97;
      text-align:center;
  }
</style>
<div class="container mundb-standard-container">
    <h5 class="mhs-title mt-3"><i class="MDI gift"></i> SAST 物品借还系统</h5>
    @if(Auth::user()->vip)
    <br>
    <div class="input-group text-center">
        <div class="input-group-btn" style="margin:0 auto">
            <button type="button" class="btn btn-raised btn-info" aria-label="Left Align" onclick="window.location.href='/handling/publish'">发布物品</button>
        </div>
    </div>
    @endif
    <br>
    <div class="row">
        @foreach($list as $l)
        <div class="col-lg-3 col-md-4 col-6">
            <card class="item-card mb-3">
                <div>
                    <a class="card-link" href="/handling/detail/{{$l->iid}}"><img class="card-img-top mhs-item-img" src="{{$l->pic}}"></a>
                </div>
                <div class="card-body">
                    <h5 class="card-title mhs-item-text mundb-text-truncate-1">{{$l->name}}</h5>
                    @if($l->owner!=Auth::user()->id)
                    <button id="minus{{$l->iid}}" type="button" class="btn btn-sm btn-primary mhs-button-count" disabled="disabled" onclick="minus({{$l->iid}},{{$l->count}})"><strong>-</strong></button>
                    <button id="count{{$l->iid}}" type="button" @if($l->count==0) disabled="disabled" @endif class="btn btn-sm btn-primary mhs-button-count">@if($l->count==0) 0 @else 1 @endif</button>
                    <button id="add{{$l->iid}}" type="button" @if($l->count<2) disabled="disabled" @endif class="btn btn-sm btn-primary mhs-button-count" onclick="add({{$l->iid}},{{$l->count}})"><strong>+</strong></button>
                    <button class="btn btn-primary mhs-button" @if($l->count==0) disabled="disabled" @endif onclick="addToCart({{$l->iid}})"><i class="MDI cart"></i></button>
                    <button class="btn btn-primary mhs-button" @if($l->count==0) disabled="disabled" @endif onclick="borrowImmediately({{$l->iid}})">立即借</button>
                    @else
                    <button type="button" class="btn btn-primary mhs-button" onclick="location.href='/handing/edit/{{$l->iid}}'">编辑</button>
                    <button type="button" class="btn btn-warning mhs-button" onclick="alert2({content:'您确定要下架「{{$l->name}}」吗？',title:'下架物品'},function(deny){if(!deny){removeItem({{$l->iid}})}})"><i class="MDI close-box"></i>下架</button>
                    @endif
                    <div class="row">
                        <div class="col-6">
                            <small>{{$l->location}}</small>
                        </div>
                        <div class="col-6">
                            <small>{{$l->order_count}}笔借用</small>
                        </div>
                    </div>
                </div>
            </card>
        </div>
        @endforeach
    </div>
    <br>
    <br>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            {{ $paginator->links() }}
        </ul>
    </nav>
</div>
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
        window.location.href="/order/create/?iid="+id+"&count="+$('#count' + id).text().trim();
    }
    
</script>
@endsection