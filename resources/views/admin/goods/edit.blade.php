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
                <a href="{{route('admin.goods.index')}}">Товары</a>
            </li>
            <li class="active">Редактирование товара</li>
        </ul><!-- /.breadcrumb -->


    </div>

    <div class="page-content">

        <div class="page-header">
            <h1>
                Товары
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
                <form class="form-horizontal" role="form" action="{{route('admin.goods.update', $good->id)}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT">
                    <input name="_token" type="hidden" value="{{csrf_token()}}">

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-20"> Категория </label>
                        <div class="col-sm-9">
                            <select multiple="" name="categories[]" class="chosen-select form-control tag-input-style" id="form-field-20" data-placeholder="Выберите категории...">
                                <option value="">--Не выбрана--</option>
                                @foreach($categories as $cat)
                                <option value="{{$cat->id}}" @if ((old() && old('categories') && in_array($cat->id, old('categories'))) || (!old() && !empty($good) && $good->categories->count() && $good->categories->find($cat->id))) selected="selected" @endif>{{$cat->name}}</option>
                                @if($cat->categories->count()))
                                    @include('admin.goods.dropdown', ['cats' => $cat->categories()->orderBy('sort')->get(), 'index' => 1, 'good' => $good])
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-21"> Бренд </label>
                        <div class="col-sm-9">
                            <select name="brand_id" id="form-field-21">
                                <option value="">--Не выбран--</option>
                                @foreach($brands as $brand)
                                <option value="{{$brand->id}}" @if((old() && old('brand_id')==$brand->id) || (empty(old()) && $good->brand_id==$brand->id))selected="selected"@endif>{{$brand->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-0"> Название </label>
                        <div class="col-sm-9">
                            <input type="text" id="form-field-0" name="name" placeholder="Название" value="{{ old('name', $good->name) }}" class="col-sm-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> ЧПУ (URL) </label>
                        <div class="col-sm-9">
                            <input type="text" id="form-field-1" name="sysname" placeholder="sysname" value="{{ old('sysname', $good->sysname) }}" class="col-sm-5">
                            <span class="help-button" data-rel="popover" data-trigger="hover" data-placement="left" data-content="Если оставить пустым, будет автоматически сгенерированно из Названия" title="">?</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-23"> Описание </label>
                        <div class="col-sm-9">
                            <textarea name="descr" class="form-control limited" id="form-field-23" maxlength="200" class="col-sm-12">{{old('descr', $good->descr)}}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Изображение </label>
                        <div class="col-sm-9">
                            <div class="tabbable">
                                <ul class="nav nav-tabs" id="myTab">
                                    @if($good->img)
                                        <li class="active">
                                            <a data-toggle="tab" href="#field-img-now" aria-expanded="false">
                                                Текущее
                                            </a>
                                        </li>
                                    @endif
                                    <li @if(!$good->img) class="active" @endif>
                                        <a data-toggle="tab" href="#field-img-new" aria-expanded="true">
                                            Новое
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    @if($good->img)
                                        <div id="field-img-now" class="tab-pane fade active in">
                                            <ul class="ace-thumbnails clearfix">
                                                <li>
                                                    <a href="/{{$good->getImgSmallPath().$good->img}}"  data-rel="colorbox" class="cboxElement">
                                                        <img  src="/{{$good->getImgMainPath().$good->img}}">
                                                    </a>
                                                    <div class="tools">
                                                        <a href="{{route('admin.image.crop', ['img' => '/'.$good->getImgPath().$good->img, 'preview' => '/'.$good->getImgMainPath().$good->img, 'width' => $good->getMainSize('width'), 'height' => $good->getMainSize('height'), 'previews[0]' => '/'.$good->getImgPreviewPath().$good->img, 'widths[0]' => $good->getPreviewSize('width'), 'heights[0]' => $good->getPreviewSize('height'), 'previews[1]' => '/'.$good->getImgSmallPath().$good->img, 'widths[1]' => $good->getSmallSize('width'), 'heights[1]' => $good->getSmallSize('height') ])}}" title="Изменить">
                                                            <i class="ace-icon glyphicon glyphicon-camera"></i>
                                                        </a>
                                                    </div>
                                                </li>
                                            </ul>


                                        </div>
                                    @endif
                                    <div id="field-img-new" class="tab-pane fade @if(!$good->img) active in @endif">
                                        <input name="img" type="file" class="img-drop" accept="image/*" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Дополнительные изображения </label>
                        <div class="col-sm-9">
                            <div class="tabbable">
                                <ul class="nav nav-tabs" id="myTab">
                                    @if($good->photos())
                                        <li class="active">
                                            <a data-toggle="tab" href="#field-photos-now" aria-expanded="false">
                                                Текущие
                                            </a>
                                        </li>
                                    @endif
                                    <li @if(!$good->photos()) class="active" @endif>
                                        <a data-toggle="tab" href="#field-photos-new" aria-expanded="true">
                                            Добавить
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    @if($good->photos())
                                        <div id="field-photos-now" class="tab-pane fade active in">
                                            <ul class="ace-thumbnails photo-container clearfix">
                                                @foreach($good->photos as $photo)
                                                    <li class="photo-container-item">
                                                        <a href="/{{$photo->getImgSmallPath().$photo->img}}" data-rel="colorbox" title="{{$photo->name}}">
                                                            <img src="/{{$photo->getImgMainPath().$photo->img}}" />
                                                            <div class="tags">
                                                                <span class="label-holder label-delete" style="display: none;">
                                                                    <span class="label label-danger arrowed">На удаление</span>
                                                                </span>
                                                            </div>
                                                        </a>
                                                        <div class="tools tools-top">
                                                            <a href="#" class="photo-action-cancel" style="font-size:18px;display: none;" title="Отменить удаление">
                                                                <i class="ace-icon fa fa-link"></i>
                                                            </a>
                                                            <a href="#" class="photo-action-delete" style="font-size:18px;" title="На удаление">
                                                                <i class="ace-icon fa fa-times red"></i>
                                                            </a>

                                                            <a href="{{route('admin.image.crop', ['img' => '/'.$photo->getImgPath().$photo->img, 'preview' => '/'.$photo->getImgMainPath().$photo->img, 'width' => $photo->getMainSize('width'), 'height' => $photo->getMainSize('height'), 'previews[0]' => '/'.$photo->getImgPreviewPath().$photo->img, 'widths[0]' => $photo->getPreviewSize('width'), 'heights[0]' => $photo->getPreviewSize('height'), 'previews[1]' => '/'.$photo->getImgSmallPath().$photo->img, 'widths[1]' => $photo->getSmallSize('width'), 'heights[1]' => $photo->getSmallSize('height') ])}}" title="Изменить">
                                                                <i class="ace-icon glyphicon glyphicon-camera"></i>
                                                            </a>
                                                        </div>
                                                        <input type="hidden" name="p_ids[]" value="{{$photo->id}}">
                                                        <input type="hidden" class="input-delete" name="p_delete[]" value="0">
                                                    </li>
                                                @endforeach
                                            </ul>


                                        </div>
                                    @endif

                                    <div id="field-photos-new" class="tab-pane fade @if(!$good->photos()) active in @endif" style="height: 100px">
                                        <div class="dynamic-input">
                                            <div class="input-group dynamic-input-item col-sm-5" style="margin-bottom:5px;">
                                                <div class="col-sm-10">
                                                    <input type="file" name="photos[]" class="file-input-img col-sm-12"  accept="image/*" />
                                                </div>
                                                <div class="col-sm-2">
                                                    <a href="" class="input-group-addon plus">
                                                        <i class="glyphicon glyphicon-plus bigger-110"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group calculate">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-10"> Цена </label>
                        <div class="col-sm-9" style="padding-left: 12px;">
                            <div class="col-sm-2 input-group" style="float: left;">
                                <input name="price" value="{{old('price', $good->price)}}" placeholder="Цена" type="text" id="form-field-10" class="input-number form-control">
                                <span class="input-group-addon">
                                    <i class="fa fa-rub bigger-110"></i>
                                </span>
                            </div>
                            <div class="col-sm-2 input-group" style="float: left; margin-left: 20px;">
                                <input name="discount" value="{{old('discount', $good->discount)}}" placeholder="Скидка" type="text" class="form-control input-number">
                                <span class="input-group-addon">%</span>
                            </div>
                            <div class="col-sm-2 input-group" style="float: left; margin-left: 20px;">
                                <input name="price_old" value="{{old('price_old', $good->price_old)}}" placeholder="Старая цена" type="text" class="input-number form-control">
                                <span class="input-group-addon">
                                    <i class="fa fa-rub bigger-110"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-11"> Артикул </label>
                        <div class="col-sm-9">
                            <input type="text" id="form-field-11" name="article" placeholder="Название" value="{{ old('article', $good->article) }}" class="col-sm-2">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right"> Ярлыки </label>
                        <div class="col-sm-9">
                            <label class="block">
                                <input name="new" value="1" type="checkbox" @if ((old() && old('new')) || (!old() && $good->new)) checked="checked" @endif class="ace input-lg">
                                <span class="lbl bigger-120"> Новинка</span>
                            </label>
                            <label class="block">
                                <input name="act" value="1" type="checkbox" @if ((old() && old('act')) || (!old() && $good->act)) checked="checked" @endif class="ace input-lg">
                                <span class="lbl bigger-120"> Акция</span>
                            </label>
                            <label class="block">
                                <input name="hit" value="1" type="checkbox" @if ((old() && old('hit')) || (!old() && $good->hit)) checked="checked" @endif class="ace input-lg">
                                <span class="lbl bigger-120"> Хит</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right"> Наличие </label>
                        <div class="col-sm-9">
                            <label>
                                <input name="stock" type="radio" class="ace" value="1" @if ((old() && old('stock') == 1) || (!old() && $good->stock==1)) checked="checked" @endif>
                                <span class="lbl"> В наличии</span>
                            </label>&nbsp;
                            <label>
                                <input name="stock" type="radio" class="ace" value="0" @if ((old() && old('stock') == 0) || (!old() && $good->stock==0)) checked="checked" @endif>
                                <span class="lbl"> Под заказ</span>
                            </label>
                        </div>
                    </div>

                    @if($attributes->count())
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right"> Атрибуты </label>
                            <div class="col-sm-9">
                                <div class="dynamic-input">

                                    @if (old('attributes')['ids'])
                                        @foreach(old('attributes')['ids'] as $key_attr => $id)
                                            <div class="dynamic-input-item dynamic-attributes" style="margin-bottom:5px;">
                                                <div class="input-group col-sm-4" style="float:left;">
                                                    <a href="" class="input-group-addon @if($key_attr == 0)plus @else minus @endif">
                                                        <i class="glyphicon @if($key_attr == 0)glyphicon-plus @else glyphicon-minus @endif bigger-110"></i>
                                                    </a>
                                                    <select name="attributes[ids][]" class="col-sm-9 select-attribute" style="height: 34px"  placeholder="Атрибут">
                                                        <option value="">--Не выбран--</option>
                                                        @foreach($attributes as $key => $attribute)
                                                            <option value="{{$attribute->id}}" @if($attribute->id == $id)selected @endif  data-type="{{$attribute->type}}" data-unit="{{$attribute->unit}}" data-list="{{$attribute->list}}">{{$attribute->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="input-group col-sm-3 field field-value" style="float:left; display:none;">
                                                    <a class="input-group-addon">шт.</a>
                                                    <input class="col-sm-9" type="text" name="attributes[value][]" value="{{old('attributes')['value'][$key_attr]}}" placeholder="Значение">
                                                </div>
                                                <div class="col-sm-3 field field-values" style="float:left; display:none;">
                                                    <select name="attributes[values][]" class="col-sm-9" style="height: 34px" data-val="{{!empty(old('attributes')['values']) ? old('attributes')['values'][$key_attr] : ''}}">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                                <div style="clear:both"></div>
                                            </div>

                                        @endforeach
                                    @else
                                        @forelse($good->attributes as $key_attr => $atr)
                                            <div class="dynamic-input-item dynamic-attributes" style="margin-bottom:5px;">
                                                <div class="input-group col-sm-4" style="float:left;">
                                                    <a href="" class="input-group-addon @if($key_attr == 0)plus @else minus @endif">
                                                        <i class="glyphicon @if($key_attr == 0)glyphicon-plus @else glyphicon-minus @endif bigger-110"></i>
                                                    </a>
                                                    <select name="attributes[ids][]" class="col-sm-9 select-attribute" style="height: 34px"  placeholder="Атрибут">
                                                        <option value="">--Не выбран--</option>
                                                        @foreach($attributes as $key => $attribute)
                                                            <option value="{{$attribute->id}}" @if($attribute->id == $atr->id)selected @endif  data-type="{{$attribute->type}}" data-unit="{{$attribute->unit}}" data-list="{{$attribute->list}}">{{$attribute->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="input-group col-sm-3 field field-value" style="float:left; display:none;">
                                                    <a class="input-group-addon">шт.</a>
                                                    <input class="col-sm-9" type="text" name="attributes[value][]" value="{{$atr->pivot->value}}" placeholder="Значение">
                                                </div>
                                                <div class="col-sm-3 field field-values" style="float:left; display:none;">
                                                    <select name="attributes[values][]" class="col-sm-9" style="height: 34px" data-val="{{$atr->pivot->value}}">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                                <div style="clear:both"></div>
                                            </div>
                                        @empty
                                        <div class="dynamic-input-item dynamic-attributes" style="margin-bottom:5px;">
                                            <div class="input-group col-sm-4" style="float:left;">
                                                <a href="" class="input-group-addon plus">
                                                    <i class="glyphicon glyphicon-plus bigger-110"></i>
                                                </a>
                                                <select name="attributes[ids][]" class="col-sm-9 select-attribute" style="height: 34px"  placeholder="Атрибут">
                                                    <option value="">--Не выбран--</option>
                                                    @foreach($attributes as $key => $attribute)
                                                        <option value="{{$attribute->id}}" data-type="{{$attribute->type}}" data-unit="{{$attribute->unit}}" data-list="{{$attribute->list}}">{{$attribute->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input-group col-sm-3 field field-value" style="float:left; display:none;">
                                                <a class="input-group-addon">шт.</a>
                                                <input class="col-sm-9" type="text" name="attributes[value][]" placeholder="Значение">
                                            </div>
                                            <div class="col-sm-3 field field-values" style="float:left; display:none;">
                                                <select name="attributes[values][]" class="col-sm-9" style="height: 34px"></select>
                                            </div>
                                            <div style="clear:both"></div>
                                        </div>
                                        @endforelse
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-12"> Теги </label>
                        <div class="col-sm-9">
                            <select multiple="" name="tags[]" class="chosen-select form-control tag-input-style" id="form-field-12" data-placeholder="Выберите тэг...">
                                @foreach($tags as $tag)
                                <option value="{{$tag->id}}" @if((old() && old('tags') && in_array($tag->id, old('tags'))) || (!old() && $good->tags->count() && $good->tags->find($tag->id)))selected="selected" @endif>{{$tag->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-77"> С товаром покупают</label>
                        <div class="col-sm-9">
                            <div class="widget-box">
                                <div class="widget-header">
                                    <h4 class="smaller">
                                        Товары
                                        <small>Выберите из списка</small>
                                    </h4>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main">
                                        @for($i = 0; $i<5; $i++)
                                        <select name="buyalso[{{$i}}]" class="chosen-select chosen-autocomplite form-control" id="form-field-7{{$i}}" data-url="{{route('admin.goods.search')}}" data-placeholder="Начните ввод...">
                                            <option value="">  </option>
                                            @if($buyalso && $buyalso->has($i))
                                                <option value="{{$buyalso->get($i)->id}}" selected>{{$buyalso->get($i)->name}}</option>
                                            @endif
                                        </select>
                                        <br><br>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="editor2"> Текст </label>
                        <div class="col-sm-9">
                            <textarea class="ck-editor" id="editor2" name="text">{{ old('text', $good->text) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="video-url-field"> Видео (URL) </label>
                        <div class="col-sm-9">
                            <input type="text" id="video-url-field" name="video_url" placeholder="Ссылка на видео" value="{{ old('video_url', $good->video_url) }}" class="col-sm-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-6"> Title </label>
                        <div class="col-sm-9">
                            <input type="text" id="form-field-6" name="title" placeholder="Title" value="{{ old('title', $good->title) }}" class="col-sm-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-7"> Description </label>
                        <div class="col-sm-9">
                            <textarea id="form-field-7" name="description" placeholder="Description" class="col-sm-12">{{ old('description', $good->description) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-8"> Keywords </label>
                        <div class="col-sm-9">
                            <textarea id="form-field-8" name="keywords" placeholder="Keywords" class="col-sm-12">{{ old('keywords', $good->keywords) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-5"> Активность </label>
                        <div class="col-sm-9">
                            <label>
                                <input type="hidden" name="status" value="0">
                                <input name="status" @if ((old() && old('status')) || (empty(old()) && $good->status) ) checked="checked" @endif   value="1" class="ace ace-switch ace-switch-4 btn-empty" type="checkbox">
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
                            <a class="btn btn-info" href="{{route('admin.goods.index')}}">
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
