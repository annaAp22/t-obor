@extends('admin.layout')
@section('main')

    <div class="breadcrumbs" id="breadcrumbs">
        <script type="text/javascript">
            try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
        </script>

        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{route('admin.main')}}">Главная</a>
            </li>
            <li class="active">Статьи</li>
        </ul><!-- /.breadcrumb -->


    </div>

    <div class="page-content">

        <div class="page-header">
            <h1>
                Статьи
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    Список всех статей
                </small>
            </h1>
        </div><!-- /.page-header -->

        @include('admin.message')

        <div class="row-blk">
            <div class="col-xs-12">
                <div class="tabbable">


                        <div class="table-header">
                            Список всех статей

                            <div class="ibox-tools">
                                <a href="{{route('admin.articles.create')}}" class="btn btn-success btn-xs">
                                    <i class="fa fa-plus"></i>
                                    Добавить статью
                                </a>
                            </div>

                        </div>
                        <div>
                    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
                        <!-- PAGE CONTENT BEGINS -->
                        <div class="row-blk">

                            <!-- FILTERS -->
                            <div class="row-blk">
                                <form method="GET" action="{{route('admin.articles.index')}}">
                                    <div class="row-blk">
                                        <div class="col-xs-2">
                                            <div>
                                                <label>На страниц
                                                    <select name="f[perpage]" class="form-control input-sm">
                                                        <option value="10" @if (isset($filters['perpage']) &&  $filters['perpage']== 10) selected="selected" @endif>10</option>
                                                        <option value="25" @if (isset($filters['perpage']) &&  $filters['perpage']== 25) selected="selected" @endif>25</option>
                                                        <option value="50" @if (isset($filters['perpage']) &&  $filters['perpage']== 50) selected="selected" @endif>50</option>
                                                        <option value="100" @if (isset($filters['perpage']) &&  $filters['perpage']== 100) selected="selected" @endif>100</option>
                                                    </select> </label>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div>
                                                <label>Название:
                                                    <input type="text" name="f[name]" value="{{$filters['name'] or ''}}" class="form-control input-sm">
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-xs-3">
                                            <div>
                                                <label>Категория:
                                                    <select name="f[id_category]" id="form-field-20">
                                                        <option value="">--Не выбрана--</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{$category->id}}" @if(isset($filters['id_category']) && $filters['id_category']==$category->id)selected="selected"@endif>{{$category->name}}</option>
                                                            @if($category->categories->count()))
                                                            @include('admin.articles.dropdown', ['cats' => $category->categories()->orderBy('sort')->get(), 'index' => 1])
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xs-2">
                                            <div>
                                                <label>Тэг:
                                                    <select name="f[tag]" class="form-control input-sm">
                                                        <option value="">--Не выбрана--</option>
                                                        @foreach($tags as $tag)
                                                        <option value="{{$tag->id}}" @if (isset($filters['tag']) &&  $filters['tag']== $tag->id) selected="selected" @endif>{{$tag->name}}</option>
                                                        @endforeach
                                                    </select> </label>
                                            </div>
                                        </div>
                                        <div class="col-xs-2">
                                            <div>
                                                <label>ЧПУ:
                                                    <input type="text" name="f[sysname]" value="{{$filters['sysname'] or ''}}" class="form-control input-sm">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-blk">

                                        <div class="col-xs-4">
                                            <div>
                                                <label>Дата:
                                                    <div class="input-daterange input-group">
                                                        <input type="text" class="input-sm form-control" name="f[date_from]" value="{{$filters['date_from'] or ''}}">
                                                        <span class="input-group-addon">
                                                    <i class="fa fa-exchange"></i>
                                                </span>
                                                        <input type="text" class="input-sm form-control"  name="f[date_to]" value="{{$filters['date_to'] or ''}}">
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div>
                                                <label>Статус
                                                    <select name="f[status]" class="form-control input-sm">
                                                        <option value="" @if (!isset($filters['status'])) selected="selected" @endif>Все</option>
                                                        <option value="1" @if (isset($filters['status']) &&  $filters['status']==1) selected="selected" @endif>Опубликовано</option>
                                                        <option value="0" @if (isset($filters['status']) &&  $filters['status']==='0') selected="selected" @endif>Черновик</option>

                                                    </select> </label>
                                            </div>
                                        </div>
                                        <div class="col-xs-2">
                                            <div>
                                                <div class="checkbox">
                                                    <label class="block">
                                                        <input name="f[deleted]" value="1" type="checkbox" @if (isset($filters['deleted'])) checked="checked" @endif class="ace input-lg">
                                                        <span class="lbl bigger-120"> С удаленными</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div>
                                                <a class="btn  btn-xs" href="{{route('admin.articles.index')}}?refresh=1">
                                                    Сбросить
                                                    <i class="ace-icon glyphicon glyphicon-refresh  align-top bigger-125 icon-on-right"></i>
                                                </a>

                                                <button class="btn btn-info btn-xs" type="submit">
                                                    Фильтровать
                                                    <i class="ace-icon glyphicon glyphicon-search  align-top bigger-125 icon-on-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <table id="simple-table" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Дата</th>
                                    <th>Изображение</th>
                                    <th>ЧПУ</th>
                                    <th>Категории</th>
                                    <th>Теги</th>
                                    <th>Статус</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody class="ace-thumbnails clearfix">
                                @forelse($articles as $item)
                                    <tr @if($item->trashed())style="background-color: #F6CECE"@endif>
                                        <td>
                                            <a href="{{route('admin.articles.edit', $item->id)}}">{{$item->name}}</a>
                                        </td>
                                        <td>
                                            {{$item->dateLocale()}}
                                        </td>
                                        <td class="col-sm-1 center">
                                            @if($item->img)
                                                <a data-rel="colorbox" href="/{{$item->getImgPath().$item->img}}">
                                                    <img src="/{{$item->getImgPreviewPath().$item->img}}" width="100" />
                                                </a>
                                            @endif
                                        </td>
                                        <td>{{$item->sysname}}</td>
                                        <td>
                                            @foreach($item->categories as $category)
                                                <span class="label label-success arrowed">{{$category->name}}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($item->tags as $tag)
                                                <span class="label label-info arrowed-in-right arrowed">{{$tag->name}}</span>
                                            @endforeach
                                        </td>
                                        <td class="col-sm-1 center"><i class="ace-icon glyphicon @if($item->status) glyphicon-ok green @else glyphicon-remove red @endif  bigger-120"></i></td>
                                        <td>
                                            <div class="hidden-sm hidden-xs btn-group">
                                                @if($item->trashed())
                                                <form method="POST" action='{{route('admin.articles.restore', $item->id)}}' style="display:inline;">
                                                    <input type="hidden" name="_method" value="PUT">
                                                    <input name="_token" type="hidden" value="{{csrf_token()}}">
                                                    <button class="btn btn-xs btn-purple action-restore" type="button" style="border-width: 1px;">
                                                        <i class="ace-icon fa fa-undo bigger-120"></i>
                                                    </button>
                                                </form>
                                                @else
                                                <a class="btn btn-xs btn-info" href="{{route('admin.articles.edit', $item->id)}}">
                                                    <i class="ace-icon fa fa-pencil bigger-120"></i>
                                                </a>
                                                <form method="POST" action='{{route('admin.articles.destroy', $item->id)}}' style="display:inline;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input name="_token" type="hidden" value="{{csrf_token()}}">
                                                    <button class="btn btn-xs btn-danger action-delete" type="button" style="border-width: 1px;">
                                                        <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <p>Нет статей</p>
                                @endforelse
                                </tbody>
                            </table>

                            <div class="row-blk" style="border-bottom:none;">
                                <div class="col-xs-6">
                                    <div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
                                        {!! $articles->render() !!}
                                    </div>
                                </div>
                            </div>


                        </div><!-- /.row -->
                    </div>
                </div>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->


@stop