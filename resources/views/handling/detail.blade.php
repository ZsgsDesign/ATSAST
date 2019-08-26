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
    <nav id="navs" class="navbar justify-content-center" style="background-color: white; border:0px;box-shadow:0px">
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
    </nav>
    <br>
        <div data-spy="scroll" data-target="#navbar-detailed-page" data-offset="0">
            <card id="intro" class="p-3">
                <h5 class="text-primary text-center">暂无物品简介</h5>
                <article class="markdown-body" id="desc">
                </article>
            </card>
            <card id="comment">
                <div class="text-center">
                    <button type="button" class="btn btn-dark" onclick="refer=null;$('#comment-title').html('发布留言');$('#Comment').modal('show');"><i class="MDI comment-remove-outline"></i>发布评论</button>
                </div>
                <p class="text-center text-secondary">这里一条留言也没有～～</p>
                <div class="media ml-3">
                    <avatar class="mr-3 align-self-start"><img src="<{$r['avatar']}>"></avatar>
                    <div class="media-body">
                        <{if $r['uid'] == $userinfo['uid'] }><h5 class="mt-0 text-primary">我</h5><{else}><h5 class="mt-0"><a href="<{$MHS_DOMAIN}>/user/<{$r['uid']}>"><{$r['real_name']}></a></h5><{/if}>
                        <br><small><{$r['time']}></small>
                        <button type="button" class="btn btn-sm <{if $r['i_liked']}>btn-warning<{else}>btn-secondary<{/if}>" id="like-<{$r['mid']}>" onclick="likeComment(<{$r['mid']}>);"><i class="MDI heart"></i> <{if !$r['liked']}>喜欢<{else}><{$r['liked']}><{/if}></button> <!-- TODO -->
                        <button type="button" class="btn btn-primary btn-sm" onclick="refer=<{$r['mid']}>;$('#comment-title').html('回复<{$r['real_name']}>');$('#Comment').modal('show');"><i class="MDI comment"></i> <{if empty($r['comments'])}>评论<{else}><{count($r['comments'])}><{/if}></button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="seletedComment=<{$r['mid']}>;$('#Delete').modal('show');"><i class="MDI comment-remove-outline"></i> 移除此评论</button> <!-- 物品发布者可以删除所有人的评论 -->
                        <button type="button" class="btn btn-danger btn-sm" onclick="seletedComment=<{$r['mid']}>;$('#Delete').modal('show');"><i class="MDI delete"></i> 删除</button> <!-- 自己删除自己的评论 -->
                        <div class="media mt-3">
                            <avatar class="mr-3 align-self-start"><img src="<{$q['avatar']}>"></avatar>
                            <div class="media-body">
                                <h5 class="mt-0"><{if $q['uid'] == $userinfo['uid'] }>我<{else}><{$q['real_name']}><{/if}><strong> 回复 </strong><{if $q['refer_id'] == $userinfo['uid'] }>我<{else}><{$q['refer_real_name']}><{/if}></h5>
                                <br><small><{$q['time']}></small>
                                <button type="button" class="btn btn-sm <{if $q['i_liked']}>btn-warning<{else}>btn-secondary<{/if}>" id="like-<{$q['mid']}>" onclick="likeComment(<{$q['mid']}>);"><i class="MDI heart"></i> <{if !$q['liked']}>喜欢<{else}><{$q['liked']}><{/if}></button> <!-- TODO -->
                                <button type="button" class="btn btn-info btn-sm" onclick="refer=<{$q['mid']}>;$('#comment-title').html('回复 <{$q['real_name']}>');$('#Comment').modal('show');"><i class="MDI reply"></i> 回复</button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="seletedComment=<{$q['mid']}>;$('#Delete').modal('show');"><i class="MDI comment-remove-outline"></i> 移除此评论</button> <!-- 物品发布者可以删除所有人的评论 -->
                                <button type="button" class="btn btn-danger btn-sm" onclick="seletedComment=<{$q['mid']}>;$('#Delete').modal('show');"><i class="MDI delete"></i> 删除</button> <!-- 自己删除自己的评论 -->
                            </div>
                        </div>
                    </div>
                </div>
            </card>
            <card id="review" class="p-3">
                <h5 class="text-center text-info">借用评价</h5>
                <p class="text-center text-secondary">这里一条评价也没有～～</p>
                <div class="media mt-3">
                    <avatar class="mr-3 align-self-start"><img src="<{$r['avatar']}>"><span class="badge badge-pill top-fc <{if $r['renter_review']==1}>badge-success">好评<{else if $r['renter_review']==0}>badge-dark">中评<{else}>badge-warning">差评<{/if}></span></avatar>
                    <div class="media-body">
                        <h5 class="mt-0"><a href="<{$MHS_DOMAIN}>/user/<{$r['uid']}>"><{$r['real_name']}></a></h5>
                        <br><small>归还于 <{$r['return_time']}></small>
                    </div>
                </div>
            </card>
            <card id="about" class="p-3">
                <div class="row text-center">
                    <div class="col-md-3 col-6">
                        <statistic>
                            <h1><a href="<{$MHS_DOMAIN}>/user/<{$item_info['owner']}>"><{$publisher_info["publisher"]}></a></h1>
                            <p>出借者</p>
                        </statistic>
                    </div>
                    <div class="col-md-3 col-6">
                        <statistic>
                            <h1><{$publisher_info["publisher_credit"]}></h1>
                            <p>出借者信用</p>
                        </statistic>
                    </div>
                    <div class="col-md-3 col-6">
                        <statistic>
                            <h1><{$publisher_info["publisher_order_count"]}></h1>
                            <p>总出借笔数</p>
                        </statistic>
                    </div>
                    <div class="col-md-3 col-6">
                        <statistic>
                            <h1><{$publisher_info["publisher_item_count"]}></h1>
                            <p>发布物品数</p>
                        </statistic>
                    </div>
                </div>
            </card>

        </div>
</div>
<div class="modal fade" id="Delete" tabindex="-1" role="dialog" aria-labelledby="Delete" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">删除</h5>
            </div>
            <div class="modal-body">
                <p class="text-danger">您确定删除这个留言吗？</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" onclick="deleteComment();">确定</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="Comment" tabindex="-1" role="dialog" aria-labelledby="Comment" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="comment-title">发布留言</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="comment-text" class="bmd-label-floating">留言文本(不超过140字)</label>
                    <textarea class="form-control" id="comment-text" rows="6"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" onclick="sendComment($('#comment-text').val());">确定</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/3.0.1/github-markdown.min.css" integrity="sha256-HbgiGHMLxHZ3kkAiixyvnaaZFNjNWLYKD/QG6PWaQPc=" crossorigin="anonymous" />
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

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