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
<script>
    function borrowImmediately(id,i){
        
    }
</script>
<div class="container mundb-standard-container"> 
    <h3 class="mhs-title mb-3 mt-3">物品详情</h3>
    <h5 class="mhs-title text-danger mb-3">抱歉，该物品已下架。</h5>
    <h5 class="mhs-title text-danger mb-3">此物品已删除，您现在查看的是它的存档。</h5>
        <div class="row">
            <div class="col-lg-4 col-sm-12 col-12 text-center">
                <figure class="figure">
                    <img class="mhs-item-img-detailed flo" src="">
                    <figcaption class="figure-caption text-center">
                        <div class="btn-group">
                            <small class="mt-2 mr-3">物品数量:</small>
                            <button id="minus0" type="button" class="btn btn-sm btn-primary" disabled="disabled" onclick="">-</button>
                            <button id="count0" type="button" class="btn btn-sm btn-primary"></button>
                            <button id="add0" type="button">+</button>
                        </div><br>
                        <button type="button" class="btn btn-raised btn-danger mhs-button-cart">立即借用</button>
                        <button class="btn btn-raised btn-warning mhs-button-cart" ><i class="MDI cart"></i>加入购物车</button>
                        <p>这是您发布的物品</p>
                        <button type="button" class="btn btn-raised mhs-button-cart btn-primary" onclick="location.href=''">编辑</button>
                        <button type="button" class="btn btn-warning mhs-button-cart btn-raised" onclick="
                    showDialog('您确定要下架「」？<br>此操作不可恢复','下架物品','removeItem(<{$item_info['iid']}>)');"><i class="MDI close-box"></i>下架</button>
                        <button type="button" class="btn btn-success mhs-button-cart btn-raised" onclick="
                    showDialog('您确定要上架「<{$item_info['name']}>」吗？','上架物品','restoreItem(<{$item_info['iid']}>)');"><i class="MDI check"></i>上架</button>
                    </figcaption>
                </figure>
            </div>

            <div class="col-lg-8 col-sm-12 col-12">
                <h4 class="text-left text-dark"><strong><{$item_info["name"]}></strong></h4>
                <table class="table table-borderless table-hover">
                    <tbody>
                    <tr>
                        <th scope="row"><i class="MDI clock"></i>发布时间</th>
                        <td><{$item_info["create_time"]}></td>
                    </tr>
                    <tr>
                        <th scope="row">借用时限</th>
                        <td><{$item_info["limit_time"]}>天</td>
                        <td>无限制</td>
                    </tr>
                    <tr>
                        <th scope="row">当前库存</th>
                        <td><{$item_info["count"]}></td>
                    </tr>
                    <tr>
                        <th scope="row">信用分限制</th>
                        <td>大于 <{$item_info["credit_limit"]}></td>
                    </tr>
                    <tr>
                        <th scope="row">物品地点</th>
                        <td><{$item_info["location"]}></td>
                    </tr>
                    <tr>
                        <th scope="row">出借笔数</th>
                        <td><{$item_info["order_count"]}></td>
                    </tr>
                    <tr>
                        <th scope="row">好评数</th>
                        <td><{$item_info["gcount"]}></td>
                    </tr>
                    <tr>
                        <th scope="row">中评数</th>
                        <td><{$item_info["mcount"]}></td>
                    </tr>
                    <tr>
                        <th scope="row">差评数</th>
                        <td><{$item_info["bcount"]}></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <br>
    <div id="navs-pos">
    </div>
    {{-- <nav id="navs" class="navbar justify-content-center" style="background-color: white; border:0px;box-shadow:0px">
        <ul class="nav" >
            <li class="nav-item">
                <a class="nav-link" href="#intro">简介</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#comment">留言<span class="badge badge-pill badge-light"><small><{count($messages)}></small></span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#review">评价<span class="badge badge-pill badge-light"><small><{count($reviews)}></small></span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#about">关于</a>
            </li>
        </ul>
    </nav> --}}
</div>


<script>
    document.addEventListener('DOMContentLoaded', function(){ // 在 DOM 完全加载完后执行
        $('#desc').html(marked("<{$item_info['desc']}>"));

        function isVisible(selectid) {
            return !($(window).scrollTop() > ($(selectid).offset().top + $(selectid).outerHeight()) || ($(window).scrollTop() + $(window).height()) < $(selectid).offset().top);
        }
        function getScrollTop() {
            let scrollTop = 0;
            if (document.documentElement && document.documentElement.scrollTop) {
                scrollTop = document.documentElement.scrollTop;
            } else if (document.body) {
                scrollTop = document.body.scrollTop;
            }
            return scrollTop;
        }
        function isTopOfScreen(selectid){
            return $(selectid).offset().top > getScrollTop() ? true :false;
        }

        $(window).scroll(function(){
            //console.log(document.querySelector('#navs'),document.querySelector('#comment').clientWidth);
            document.querySelector('#navs').style.width=document.querySelector('#comment').clientWidth+'px';
            if(!isVisible('#navs-pos')&&!isTopOfScreen('#navs-pos')) {
                $('#navs').addClass('d');
            } else {
                $('#navs').removeClass('d');
            }
        });
        document.body.onresize=function(){
            document.querySelector('#navs').style.width=document.querySelector('#comment').clientWidth+'px';
        }
    });

    let seletedComment = null;
    let refer = null;

    function likeComment(mid) {
        $.post('<{$MHS_DOMAIN}>/ajax/LikeMessage',{
            mid:mid
        },function (result) {
            result=JSON.parse(result);
            if(result.ret==200){
                let dat = parseInt($('#like-'+mid).text());
                dat = isNaN(dat)?1:++dat;
                $('#like-'+mid).html("<i class=\"MDI heart\"></i> "+dat);
                $('#like-'+mid).removeClass("btn-secondary");
                $('#like-'+mid).addClass("btn-warning");
                console.log($('#like-'+mid).html());
            }
        });
    }
    function deleteComment() {
        $.post('<{$MHS_DOMAIN}>/ajax/WithdrawMessage',{
            mid:seletedComment
    },function () {
            location.reload();
        });
    }
    function sendComment(content) {
        let data={};
        if(refer === null)
            data={iid:<{$item_info['iid']}>,content:content}
    else
        data={iid:<{$item_info['iid']}>,content:content,reference:refer};
        $.post('<{$MHS_DOMAIN}>/ajax/LeaveMessage', data ,function () {location.reload();});
    }
</script>
@inlude('js.common.item');

@endsection