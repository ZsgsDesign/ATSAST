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
      {{-- <div class="input-group text-center">
              <div class="input-group-btn">
                  <button type="button" class="btn btn-raised btn-info" aria-label="Left Align" onclick="window.location.href=''">发布物品</button>
              </div>
      </div>
      <script>
          document.querySelector("#keyword").addEventListener('keyup',function(e){
              if(e.keyCode===13){
              }
          });
      </script>
      
      <br>
      <h5 class="text-center text-warning">没有搜到你找的物品哦</h5> <!-- 表达来自闲鱼 -->
      <p class="text-center">试试别的关键词</p>
      <div class="row">
          <div class="col-lg-3 col-md-4 col-6">
              <card class="item-card mb-3">
                  <div>
                      <a class="card-link" href=""><img class="card-img-top mhs-item-img" src=""></a>
                  </div>
                  <div class="card-body">
                      <h5 class="card-title mhs-item-text mundb-text-truncate-1"></h5>
                          <!-- 如果物品只有1个，那就禁用加号和减号 -->
                          <button id="minus" type="button" class="btn btn-sm btn-primary mhs-button-count" disabled="disabled" onclick=""><strong>-</strong></button>
                          <button id="count" type="button"></button>
                          <button id="" type="button" ><strong>+</strong></button>
                      <button class="btn btn-primary mhs-button" >立即借</button>
                      <button class="btn btn-primary mhs-button" ><i class="MDI cart"></i></button>
                      <button type="button" class="btn btn-primary mhs-button" onclick="location.href=''">编辑</button>
                      <button type="button" class="btn btn-warning mhs-button" onclick="
                      showDialog('您确定要下架「」吗？','下架物品','removeItem()');"><i class="MDI close-box"></i>下架</button>
                      <!-- 分享砍了 -->
                      <div class="row">
                          <div class="col-6">
                              <small><a href=""></a></small>
                          </div>
                          <div class="col-6">
                              <small> 笔借用</small>
                          </div>
                      </div>
                  </div>
              </card>
          </div>
      </div>
      <br>
      <br>
      <nav aria-label="Page navigation">
          <ul class="pagination justify-content-center">
              <li style="display:inherit" class="page-item disabled ">
                  <a class="page-link" href="" tabindex="-1"  aria-disabled="true" >首页</a>
                  <a class="page-link" href="" tabindex="-1"  aria-disabled="true" >上一页</a>
              </li>
                  <li class="page-item"></a></li>
              <li class="page-item ">
                  <a class="page-link" href="">下一页</a>
              </li>
          </ul>
        </nav> --}}
</div>
{{-- @include('js.common.item'); --}}

@endsection