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
/* 来自mudi 的FAB */
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
                    <img class="mhs-img-detail rounded float-middle broder" id="pic_preview" src="<{$MHS_DOMAIN}>/pic/<{$iid}>">
                </div>
                <div class="p-5 text-center responsive-text">
                    <label class="text-primary">
                        拖动图片到页面或点击这里选择图片
                        <input type="file" class="sr-only" id="pic_upload" accept="image/*" ref="input" onchange="SelectedImg(this.files[0])">
                    </label>
                </div>
            </div>
            <div class="responsive col-md-9 col-sm-12 col-12">
                <div class="form-group">
                    <label for="item_name" class="bmd-label-floating">物品名称</label>
                    <input type="text" id="item_name" class="form-control" value="<{$item_info['name']}>">
                    <span class="bmd-help">物品名称包含关键词可以更好地被搜索到哦。</span>
                </div>
                <div class="form-group">
                    <label for="number" class="bmd-label-floating">借用时限(天)</label>
                    <input type="number" id="time_limit" placeholder="物品应于多少天内归还" class="form-control" min="1" value="<{$item_info['limit_time']}>">
                    <span class="bmd-help">该物品在"确认借用"后要求在规定天数内归还。</span>
                </div>
                <div class="form-group">
                    <label for="credit_required" class="bmd-label-floating">最低信用</label>
                    <select class="form-control" id="credit_required">
                        <option <{if $item_info['credit_limit'] == 0  }> selected <{/if}> >无</option>
                        <option <{if $item_info['credit_limit'] == 80 }> selected <{/if}> >信用良好</option>
                        <option <{if $item_info['credit_limit'] == 100}> selected <{/if}> >信用优秀</option>
                        <option <{if $item_info['credit_limit'] == 120}> selected <{/if}> >信用极佳</option>
                    </select>
                    <span class="bmd-help">信用分低于该等级的用户将不能借用该物品。</span>
                </div>
                <div class="form-group">
                    <label for="location" class="bmd-label-floating">物品位置</label>
                    <input type="text"  id="location" class="form-control" value="<{$item_info['location']}>">
                </div>
                <div class="form-group">
                    <label for="number" class="bmd-label-floating">物品数量</label>
                    <input type="number" id="number" class="form-control" min="1" value="<{$item_info['count']}>">
                </div>
                <div class="form-group">
                    <label for="desc" class="bmd-label-floating">物品介绍</label>
                    <textarea class="form-control" id="desc" rows="10"><{$item_info['desc']}></textarea>
                </div>
            </div>
        </div>
        <div class="text-right">
            <{if $iid != -1}>
                <button id="delete-btn" class="btn btn-outline-danger" onclick="deleteItem(<{$iid}>)">彻底删除</button>
                <!--TODO这边需要加个确认框-->
            <{/if}>
            <button class="btn btn-outline-primary" onclick="publish()">发布物品</button>
        </div>
    </card>
</div>

<!-- https://github.com/fengyuanchen/compressorjs/ -->
<script src="https://cdn.jsdelivr.net/npm/compressorjs@1.0.5/dist/compressor.min.js"></script>

<link rel="stylesheet" href="https://inacho.github.io/bootstrap-markdown-editor/dist/css/bootstrap-markdown-editor.css">
<!-- TODO 这个markdown editor 之后还要优化 -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.3.0/ace.js"></script>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<script>
    const formData = new FormData();

    document.addEventListener('DOMContentLoaded', function(){ // 在 DOM 完全加载完后执行
        window.addEventListener('dragover',(e) => {
            e.preventDefault();
        },false);
        window.addEventListener('drop',(e) => {
            e.preventDefault();
            SelectedImg(e.dataTransfer.files[0]);
        },false);
        $.getScript('https://inacho.github.io/bootstrap-markdown-editor/dist/js/bootstrap-markdown-editor.js',function(){
            $('#desc').markdownEditor({
                preview: true,
                onPreview: function (content, callback) {
                    callback( marked(content) );
                }
            });
        });

    });
    
    function SelectedImg(file){
        new Compressor(file, { //使用compressor.js压缩图片
            strict: true,
            checkOrientation: true,
            maxWidth: 3000,
            maxHeight: 3000,
            quality: 0.8,
            success(result) {
                $('#pic_preview').attr('src', URL.createObjectURL(result));
                formData.set('pic', result, result.name); //设置本地压缩后的图片
            },
            error(err) {
                console.log(err.message);
            },
        });
    };
    
    function publish() {
        //使用Ajax提交，实时返回结果。
        var timelimit_ = parseInt($("#time_limit").val());
        var options=$("#credit_required option:selected").index();
        if (options == 1)
            options = 80;
        else if (options == 2)
            options = 100;
        else if (options == 3)
            options = 120;

        formData.set('iid',"<{$iid}>"); //用于编辑物品
        formData.set('name',$("#item_name").val());
        formData.set('timeLimit',isNaN(timelimit_) ? 0 : timelimit_);
        formData.set('location',$("#location").val());
        formData.set('creditRequired',options);
        formData.set('number',$("#number").val());
        formData.set('desc',$("#desc").val());

        //https://blog.csdn.net/maxsky/article/details/80629766
        //jQuery 提交 FormData 对象，前方有坑
        $.ajax({ // $.post，告辞
            type: 'post',
            contentType: false, // 关关关！必须得 false
                                // 这个不关会扔一个默认值 application/x-www-form-urlencoded 过去，后端拿不到数据的！
                                // 而且你甚至不能传个字符串 'multipart/form-data'，后端一样拿不到数据！
            processData: false, // 关关关！重点
            url: '<{$MHS_DOMAIN}>/ajax/PublishItem',
            data: formData,
            success: function (result) {
                $('#info').html("");
                console.log(result); //显示bug
                result=JSON.parse(result);
                console.log(result);
                if(result.ret==200){
                    $('#info').append(
                        "    <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">\n" +
                        "        <strong>"+ result.desc + "</strong>\n" +
                        "        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
                        "            <span aria-hidden=\"true\">&times;</span>\n" +
                        "        </button>\n" +
                        "    </div>");
                    setTimeout(function(){
                        location.href="<{$MHS_DOMAIN}>/item/detail/"+result.data.itemid;
                    },1000);
                }
                else {
                    $('#info').append(
                        "    <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" +
                        "        <strong>"+ result.desc + "</strong>\n" +
                        "        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
                        "            <span aria-hidden=\"true\">&times;</span>\n" +
                        "        </button>\n" +
                        "    </div>");
                }
            }
        });

    }
    function deleteItem(iid){
        $.post('<{$MHS_DOMAIN}>/ajax/DeleteItem',{iid:iid},function(data,status){
            console.log(data,status);
            location.href="<{$MHS_DOMAIN}>/user?tab=item";
        })
    }

</script>
@inlude('js.common.item');

@endsection