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

            <li>
                <a href="{{route('admin.categories.index')}}">Каталог</a>
            </li>
            <li class="active">Редактирование категории</li>
        </ul><!-- /.breadcrumb -->


    </div>

    <div class="page-content">

        <div class="page-header">
            <h1>
                Категории товаров
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    Редактирование
                </small>
            </h1>
        </div><!-- /.page-header -->

        @include('admin.message')

        <div class="row-blk">
            <div class="col-xs-12 ace-thumbnails">
                <!-- PAGE CONTENT BEGINS -->
                <form class="form-horizontal" role="form" action="{{route('admin.categories.update', $category->id)}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT">
                    <input name="_token" type="hidden" value="{{csrf_token()}}">

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-20"> Категория </label>
                        <div class="col-sm-9">
                            <select name="id_parent" id="form-field-20">
                                <option value="">--Не выбрана--</option>
                                @foreach($categories as $cat)
                                <option value="{{$cat->id}}" @if ((old() && old('id_parent')==$cat->id) || (empty(old()) && $category->id_parent==$cat->id)) selected="selected" @endif>{{$cat->name}}</option>
                                @if($cat->categories->count()))
                                    @include('admin.categories.dropdown', ['cats' => $cat->categories()->where('id', '!=', $category->id)->orderBy('sort')->get(), 'index' => 1, 'category' => $category])
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-0"> Название </label>
                        <div class="col-sm-9">
                            <input type="text" id="form-field-0" name="name" placeholder="Название" value="{{ old('name', $category->name) }}" class="col-sm-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> ЧПУ (URL) </label>
                        <div class="col-sm-9">
                            <input type="text" id="form-field-1" name="sysname" placeholder="sysname" value="{{ old('sysname', $category->sysname) }}" class="col-sm-5">
                            <span class="help-button" data-rel="popover" data-trigger="hover" data-placement="left" data-content="Если оставить пустым, будет автоматически сгенерированно из Названия" title="">?</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right"> Ярлыки </label>
                        <div class="col-sm-9">
                            <label class="block">
                                <input name="new" value="1" type="checkbox" @if((old() && old('new')) || (!old() && $category->new))) checked="checked" @endif class="ace input-lg">
                                <span class="lbl bigger-120"> Новинка</span>
                            </label>
                            <label class="block">
                                <input name="act" value="1" type="checkbox" @if((old() && old('act')) || (!old() && $category->act))) checked="checked" @endif class="ace input-lg">
                                <span class="lbl bigger-120"> Акция</span>
                            </label>
                            <label class="block">
                                <input name="hit" value="1" type="checkbox" @if((old() && old('hit')) || (!old() && $category->hit))) checked="checked" @endif class="ace input-lg">
                                <span class="lbl bigger-120"> Хит</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Иконка </label>
                        <div class="col-sm-9">
                            <div class="tabbable">
                                <ul class="nav nav-tabs" id="myTab">
                                    @if($category->icon)
                                    <li class="active">
                                        <a data-toggle="tab" href="#field-icon-now" aria-expanded="false">
                                            Текущая
                                        </a>
                                    </li>
                                    @endif
                                    <li @if(!$category->icon) class="active" @endif>
                                        <a data-toggle="tab" href="#field-icon-new" aria-expanded="true">
                                            Новая
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    @if($category->icon)
                                    <div id="field-icon-now" class="tab-pane fade active in">
                                        <img src="/{{$category->getIconPath().$category->icon}}" />
                                    </div>
                                    @endif
                                    <div id="field-icon-new" class="tab-pane fade @if(!$category->icon) active in @endif">
                                        <input name="icon" type="file" class="img-drop" accept="image/*" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Изображение </label>
                        <div class="col-sm-9">
                            <div class="tabbable">
                                <ul class="nav nav-tabs" id="myTab">
                                    @if($category->img)
                                        <li class="active">
                                            <a data-toggle="tab" href="#field-img-now" aria-expanded="false">
                                                Текущее
                                            </a>
                                        </li>
                                    @endif
                                    <li @if(!$category->img) class="active" @endif>
                                        <a data-toggle="tab" href="#field-img-new" aria-expanded="true">
                                            Новое
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    @if($category->img)
                                        <div id="field-img-now" class="tab-pane fade active in">
                                            <ul class="ace-thumbnails clearfix">
                                                <li>
                                                    <a href="/{{$category->getImgPath().$category->img}}"  data-rel="colorbox" class="cboxElement">
                                                        <img  src="/{{$category->getImgPreviewPath().$category->img}}">
                                                    </a>
                                                    <div class="tools">
                                                        <a href="{{route('admin.image.crop', ['img' => '/'.$category->getImgPath().$category->img, 'preview' => '/'.$category->getImgPreviewPath().$category->img, 'width' => $category->getPreviewSize('width'), 'height' => $category->getPreviewSize('height') ])}}" title="Изменить">
                                                            <i class="ace-icon glyphicon glyphicon-camera"></i>
                                                        </a>
                                                    </div>
                                                </li>
                                            </ul>


                                        </div>
                                    @endif
                                    <div id="field-img-new" class="tab-pane fade @if(!$category->img) active in @endif">
                                        <input name="img" type="file" class="img-drop" accept="image/*" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Изображение на главной </label>
                        <div class="col-sm-9">
                            <div class="tabbable">
                                <ul class="nav nav-tabs" id="myTab">
                                    @if($category->img_main)
                                    <li class="active">
                                        <a data-toggle="tab" href="#field-img_main-now" aria-expanded="false">
                                            Текущая
                                        </a>
                                    </li>
                                    @endif
                                    <li @if(!$category->img_main) class="active" @endif>
                                        <a data-toggle="tab" href="#field-img_main-new" aria-expanded="true">
                                            Новая
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    @if($category->img_main)
                                    <div id="field-img_main-now" class="tab-pane fade active in">
                                        <img src="/{{$category->getImgMainPath().$category->img_main}}" />
                                    </div>
                                    @endif
                                    <div id="field-img_main-new" class="tab-pane fade @if(!$category->img_main) active in @endif">
                                        <input name="img_main" type="file" class="img-drop" accept="image/*" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="editor2"> Текст </label>
                        <div class="col-sm-9">
                            <textarea class="ck-editor" id="editor2" name="text">{{ old('text', $category->text) }}</textarea>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-6"> Title </label>
                        <div class="col-sm-9">
                            <input type="text" id="form-field-6" name="title" placeholder="Title" value="{{ old('title', $category->title) }}" class="col-sm-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-7"> Description </label>
                        <div class="col-sm-9">
                            <textarea id="form-field-7" name="description" placeholder="Description" class="col-sm-12">{{ old('description', $category->description) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-8"> Keywords </label>
                        <div class="col-sm-9">
                            <textarea id="form-field-8" name="keywords" placeholder="Keywords" class="col-sm-12">{{ old('keywords', $category->keywords) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-5"> Активность </label>
                        <div class="col-sm-9">
                            <label>
                                <input type="hidden" name="status" value="0">
                                <input name="status" @if ((old() && old('status')) || (empty(old()) && $category->status) ) checked="checked" @endif   value="1" class="ace ace-switch ace-switch-4 btn-empty" type="checkbox">
                                <span class="lbl"></span>
                            </label>
                        </div>
                    </div>

                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="btn btn-success" type="submit">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                                Сохранить
                            </button>
                            &nbsp; &nbsp; &nbsp;
                            <button class="btn" type="reset">
                                <i class="ace-icon fa fa-undo bigger-110"></i>
                                Обновить
                            </button>
                            &nbsp; &nbsp; &nbsp;
                            <a class="btn btn-info" href="{{route('admin.categories.index')}}">
                                <i class="ace-icon glyphicon glyphicon-backward bigger-110"></i>
                                Назад
                            </a>

                        </div>
                    </div>
                </form>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
@stop
