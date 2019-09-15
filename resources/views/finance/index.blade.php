@extends('layouts.app')

@section('template')
<style>
    .paper-card {
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

    tr{
        cursor: pointer;
    }
</style>
<div class="container mundb-standard-container">
    <div class="paper-card">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>报销项目</th>
                    <th>金额</th>
                    <th>当前状态</th>
                    <th>申报时间</th>
                </tr>
            </thead>
            <tbody>
                @foreach($list as $r)
                <tr data-id="{{$r->id}}">
                    <td scope="row">{{$r->title}}</td>
                    <td>{{$r->money}}</td>
                    <td>{{$r->status == 0 ? '审批中' : (
                            $r->status == 1 ? '被驳回' : (
                                $r->status == 2 ? '被挂起' : '已通过'
                            )
                    )}}</td>
                    <td>{{$r->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$list->links()}}
    </div>
</div>
<script>
window.addEventListener("load",function() {
    $('tr').on('click',function(){
        var id = $(this).attr('data-id');
        window.location = 'finance/details/' + id;
    });
});
</script>
@endsection
