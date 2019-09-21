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
    card {
        display: block;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
        border-radius: 4px;
        transition: .2s ease-out .0s;
        color: #7a8e97;
        background: #fff;
        padding: 1rem;
        position: relative;
        border: 1px solid rgba(0, 0, 0, 0.15);
        margin-bottom: 2rem;
    }

    .mhs-img-detail {
        max-width: 15rem;
        max-height: 15rem;
        object-fit: cover;
    }
    #delete-btn{
        margin-right: 20px;
    }
    @media all and (max-width:1200px) and (min-width:992px){
        .responsive>div{
            min-width: 600px;
            float: right;
        }
        .responsive-text{
            padding: 0 !important;
            width: 15rem;
        }
    }
    @media all and (max-width:992px) and (min-width:768px){
        .responsive>div{
            width: 300px;
            float: right;
        }
        .responsive-text{
            padding: 0 !important;
            width: 15rem;
        }
    }
    
</style>

<div class="container mundb-standard-container">
    <h3 class="mhs-title mb-5 mt-5">发布物品</h3>
    <div id="info">  
    </div>
    <card>
        <div class="card-body row">
            <div class="col-md-3 col-sm-12 col-12 text-center" >
                <div class="bg-light mb-4">
                    <img class="mhs-img-detail rounded float-middle broder" id="pic_preview" src="/static/img/-1.png">
                </div>
            </div>
            <div class="responsive col-md-9 col-sm-12 col-12">
                <div class="form-group">
                    <label for="item_name" class="bmd-label-floating">物品名称</label>
                    <input type="text" id="item_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="location" class="bmd-label-floating">物品位置</label>
                    <input type="text"  id="location" class="form-control">
                </div>
                <div class="form-group">
                    <label for="number" class="bmd-label-floating">物品数量</label>
                    <input type="number" id="number" class="form-control" min="1">
                </div>
                <div class="form-group">
                    <label for="desc" class="bmd-label-floating">物品介绍</label>
                    <textarea class="form-control" id="desc" rows="10"></textarea>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" id="need_return"> 需要归还
                    </label>
                </div>
            </div>
        </div>
        <div class="text-right">
            <button class="btn btn-outline-primary" onclick="publishItem()">发布物品</button>
        </div>
    </card>
    <div class="modal fade" id="update-itempic-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-alert" role="document">
            <div class="modal-content sm-modal">
                <div class="modal-header">
                    <h5 class="modal-title">上传图片</h5>
                </div>
                <div class="modal-body">
                    <div class="container-fluid text-center">
                        <itempic-section>
                            <img id="itempic-preview" src="/static/img/-1.png" alt="itempic">
                        </itempic-section>
                        <br />
                        <input type="file" style="display:none" id="itempic-file" accept=".jpg,.png,.jpeg,.gif">
                        <label for="itempic-file" id="choose-itempic" class="btn btn-primary" role="button"><i class="MDI upload"></i> 选择图片</label>
                    </div>
                    <div id="itempic-error-tip" style="opacity:0" class="text-center">
                        <small id="tip-text" class="text-danger font-weight-bold">选择图片</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="itempic-submit" type="button" class="btn btn-danger">上传</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    function publishItem() {
        var name = $('#item_name').val();
        var count = $('#number').val();
        var dec = $('#desc').val();
        var pic = "/static/img/-1.png";
        var location = $('#location').val();
        var need_return = $('#need_return').val();
        $.ajax({
            type: 'POST',
            url: '/ajax/handling/publishItem',
            data: {
                name: name,
                count: count,
                dec: dec,
                pic: pic,
                location: location,
                need_return: need_return,
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(ret){
                console.log(ret);
                alert("发布成功！","恭喜");
                setTimeout(function(){
                    window.location.href="/handling/detail/" + ret.data;
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
                console.log('Ajax error while posting to publishItem!');
            }
        });
    }

</script>

@endsection