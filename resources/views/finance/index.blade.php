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

    tbody tr{
        cursor: pointer;
    }

    div#filter button.dropdown-toggle {
        margin: 0 1rem;
    }

    div#filter span.bmd-form-group {
        padding-top : 0.5rem;
        margin-right: 0.5rem;
    }

    div#filter{
        text-align: right;
    }

    div#opr {
        display: inline-block;
    }
</style>
<div class="container mundb-standard-container">
    <div class="paper-card">
        <p>报销列表</p>
        <div id="filter">
            <div id="opr">
                <a class="btn btn-info" href="{{$ATSAST_DOMAIN}}/finance/initiate" role="button">发起报销</a>
            </div>
            <div class="btn-group">
                @if(isset($is_approver) && $is_approver)
                <div class="checkbox">
                    <label for="approval"><input class="form-control" type="checkbox" {{(isset($filter['approval']) && $filter['approval']) ? "" : "checked"}} id="approval" required><span>仅显示我发起的</span></label>
                </div>
                @endif
                <div class="checkbox">
                    <label for="hide_waiting"><input class="form-control" type="checkbox" {{(isset($filter['hide_waiting']) && $filter['hide_waiting']) ? "" : "checked"}} id="hide_waiting" required><span>审批中</span></label>
                </div>
                <div class="checkbox">
                    <label for="hide_back"><input class="form-control" type="checkbox" {{(isset($filter['hide_back']) && $filter['hide_back']) ? "" : "checked"}} id="hide_back" required><span>被驳回</span></label>
                </div>
                <div class="checkbox">
                    <label for="hide_pass"><input class="form-control" type="checkbox" {{(isset($filter['hide_pass']) && $filter['hide_pass']) ? "" : "checked"}} id="hide_pass" required><span>已通过</span></label>
                </div>
                <div class="checkbox">
                    <label for="hide_hang"><input class="form-control" type="checkbox" {{(isset($filter['hide_hang']) && $filter['hide_hang']) ? "" : "checked"}} id="hide_hang" required><span>被挂起</span></label>
                </div>
                <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if(isset($filter['orderBy']) && in_array($filter['orderBy'],array_keys($orderBy)) && isset($filter['order']) && ($filter['order'] == 'desc' || $filter['order'] == 'asc'))
                            {!!$order[$filter['order']]!!} {{$orderBy[$filter['orderBy']]}}
                    @else
                        排序
                    @endif
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" data-orderby="status" data-order="asc"><i style="font-size: 1.25rem;" class="MDI chevron-up"></i> 状态</a>
                    <a class="dropdown-item" href="#" data-orderby="status" data-order="desc"><i style="font-size: 1.25rem;" class="MDI chevron-down"></i> 状态</a>
                    <a class="dropdown-item" href="#" data-orderby="money" data-order="asc"><i style="font-size: 1.25rem;" class="MDI chevron-up"></i> 金额</a>
                    <a class="dropdown-item" href="#" data-orderby="money" data-order="desc"><i style="font-size: 1.25rem;" class="MDI chevron-down"></i> 金额</a>
                    <a class="dropdown-item" href="#" data-orderby="department_id" data-order="asc"><i style="font-size: 1.25rem;" class="MDI chevron-up"></i> 部门</a>
                    <a class="dropdown-item" href="#" data-orderby="department_id" data-order="desc"><i style="font-size: 1.25rem;" class="MDI chevron-down"></i> 部门</a>
                    <a class="dropdown-item" href="#" data-orderby="created_at" data-order="asc"><i style="font-size: 1.25rem;" class="MDI chevron-up"></i> 申报时间</a>
                    <a class="dropdown-item" href="#" data-orderby="created_at" data-order="desc"><i style="font-size: 1.25rem;" class="MDI chevron-down"></i> 申报时间</a>
                    <a class="dropdown-item" href="#" data-orderby="updated_at" data-order="asc"><i style="font-size: 1.25rem;" class="MDI chevron-up"></i> 改动时间</a>
                    <a class="dropdown-item" href="#" data-orderby="updated_at" data-order="desc"><i style="font-size: 1.25rem;" class="MDI chevron-down"></i> 改动时间</a>
                    <a class="dropdown-item" href="#" data-orderby="accepted_at" data-order="asc"><i style="font-size: 1.25rem;" class="MDI chevron-up"></i> 通过时间</a>
                    <a class="dropdown-item" href="#" data-orderby="accepted_at" data-order="desc"><i style="font-size: 1.25rem;" class="MDI chevron-down"></i> 通过时间</a>
                </div>
            </div>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>报销项目</th>
                    <th>申报者</th>
                    <th>金额</th>
                    <th>当前状态</th>
                    <th>申报时间</th>
                </tr>
            </thead>
            <tbody>
                @foreach($list as $r)
                <tr data-id="{{$r->id}}">
                    <td scope="row">{{$r->title}}</td>
                    <td>{{$r->username()}}</td>
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
    $('tbody tr').on('click',function(){
        var id = $(this).attr('data-id');
        window.location = 'finance/details/' + id;
    });

    $('input[type="checkbox"].form-control').on('change',function(){
        var filter = {};
        filter[$(this).attr('id')] = $(this).prop('checked') ? 0 : 1;
        filter_go(filter);
    });

    $('div.dropdown-menu a.dropdown-item').on('click',function(){
        var filter = {};
        filter['orderBy'] = $(this).attr('data-orderby');
        filter['order'] = $(this).attr('data-order');
        filter_go(filter);
    });

    function filter_go(filter = {}){
        var query = get_query();
        for(key in filter) {
            query[key] = filter[key];
        }
        var query_str = '?';
        for(key in query){
            query_str += key + '=' + query[key] + '&';
        }
        query_str = query_str.slice(0,-1);
        window.location = '/finance' + query_str;
    }

    function get_query() {
        var url = location.search;
        var theRequest = {};
        if (url.indexOf("?") != -1) {
            var str = url.substr(1);
            strs = str.split("&");
            for(var i = 0; i < strs.length; i ++) {
                theRequest[strs[i].split("=")[0]] = unescape(strs[i].split("=")[1]);
            }
        }
        return theRequest;
    }
});
</script>
@endsection
