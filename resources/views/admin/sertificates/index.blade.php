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
            <li class="active">Сертификаты</li>
        </ul><!-- /.breadcrumb -->


    </div>

    <div class="page-content">

        <div class="page-header">
            <h1>
                Сертификаты
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    Список сертификатов
                </small>
            </h1>
        </div><!-- /.page-header -->

        @include('admin.message')

        <div class="row-blk">
            <div class="col-xs-12">

                <div class="table-header">
                    Список всех сертификатов
                    <div class="ibox-tools">
                        <a href="{{route('admin.sertificates.create')}}" class="btn btn-success btn-xs">
                            <i class="fa fa-plus"></i>
                            Добавить
                        </a>
                    </div>
                </div>

                <div>
                    <ul class="ace-thumbnails clearfix">
                        @foreach($sertificates as $photo)
                        <li>
                            <a href="/{{$photo->getImgPath().$photo->img}}" data-rel="colorbox">
                                <img src="/{{$photo->getImgPreviewPath().$photo->img}}" />
                            </a>
                            <div class="tools tools-bottom">

                                <form method="POST" action='{{route('admin.sertificates.destroy', $photo->id)}}' style="display:inline;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input name="_token" type="hidden" value="{{csrf_token()}}">
                                    <a href="#" class="action-delete" style="font-size:18px;">
                                        <i class="ace-icon fa fa-times red"></i>
                                    </a>
                                </form>
                                <a href="{{route('admin.image.crop', ['img' => '/'.$photo->getImgPath().$photo->img, 'preview' => '/'.$photo->getImgPreviewPath().$photo->img, 'width' => $photo->getPreviewSize('width'), 'height' => $photo->getPreviewSize('height')])}}" title="Изменить">
                                    <i class="ace-icon glyphicon glyphicon-camera"></i>
                                </a>
                            </div>
                        </li>
                        @endforeach
                    </ul>

                </div>

            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->


@stop