@extends('layouts.app')

@section('template')

<style>
paper-card {
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
paper-card:hover {
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
paper-card.item-card {
    overflow: hidden;
}
paper-card.item-card > div{
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
paper-card.order-card {
    margin-bottom: 0.5rem;
}
paper-card.order-card > div {
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
    paper-card {
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

    <paper-card>
        <div class="card-body row">
            <div class="col-md-3 col-sm-12 col-12 text-center" >
                <label for="image" style="cursor: pointer">
                    <div class="bg-light mb-4">
                        <img class="mhs-img-detail rounded float-middle broder" id="pic_preview" src="{{$ATSAST_DOMAIN}}/static/img/-1.png">
                    </div>
                    <small>点击选择或直接拖入图片</small>
                </label>
                <input type="file" id="image" name="image" style="display: none" onchange="selectImg(this.files[0])" accept="image/png,image/jpeg"/>
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
    </paper-card>
</div>

<script>
    window.addEventListener("load",function() {
        window.addEventListener('dragover',(e) => {
            e.preventDefault();
        },false);
        window.addEventListener('drop',(e) => {
            e.preventDefault();
            selectImg(e.dataTransfer.files[0]);
        },false);
    });

    var pic;
    //image preview
    function selectImg(file){
        pic = file;
        var filename = pic.name;
        if(pic.type != 'image/png' && pic.type != 'image/jpeg'){
            $('label[for="image"] small').text('只允许上传jpg和png类型的图片文件');
            $('label[for="image"] small').removeClass('text-success').addClass('text-danger');
        }else{
            $('label[for="image"] small').text(filename);
            $('label[for="image"] small').removeClass('text-danger').addClass('text-success');
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => {
                $('label[for="image"] img').attr('src',reader.result).slideDown();
            }
        }
    }

    function publishItem() {
        var data = new FormData();
        data.set('name',$('#item_name').val());
        data.set('count',$('#number').val());
        data.set('dec',$('#desc').val());
        data.set('pic',pic);
        data.set('location', $('#location').val())
        data.set('need_return', $('#need_return').val())

        $.ajax({
            type: 'POST',
            url: '{{$ATSAST_DOMAIN}}/ajax/handling/publishItem',
            data: data,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(ret){
                if(ret.ret == 200){
                    console.log(ret);
                    alert("发布成功！","恭喜");
                    setTimeout(function(){
                        window.location.href="{{$ATSAST_DOMAIN}}/handling/detail/" + ret.data;
                    }, 1000);
                }else{
                    alert(JSON.stringify(ret),"不恭喜");
                }

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
