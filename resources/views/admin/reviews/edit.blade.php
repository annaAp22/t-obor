@extends('admin.layout')
@section('css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.css" rel="stylesheet">
@endsection
@section('header')
    <div class="page-header">
        <h1><i class="glyphicon glyphicon-edit"></i> Reviews / Edit #{{$review->id}}</h1>
    </div>
@endsection

@section('main')
<div class="page-content">
    <div class="page-header">
        <h1>
            Отзывы о магазине
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Редактирование
            </small>
        </h1>
    </div><!-- /.page-header -->

    <div class="row-blk">
        <div class="col-md-12">

            <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group @if($errors->has('name')) has-error @endif">
                    <label for="name-field">Имя (Ф.И.О.)</label>
                    <input type="text" id="name-field" name="name" class="form-control" value="{{ is_null(old("name")) ? $review->name : old('name') }}" required/>
                    @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                    @endif
                </div>
                <div class="form-group @if($errors->has('email')) has-error @endif">
                    <label for="email-field">E-Mail</label>
                    <input type="text" id="email-field" name="email" class="form-control" value="{{ is_null(old("email")) ? $review->email : old('email') }}"/>
                    @if($errors->has("email"))
                        <span class="help-block">{{ $errors->first("email") }}</span>
                    @endif
                </div>
                <div class="form-group @if($errors->has('message')) has-error @endif">
                    <label for="message-field">Текст отзыва</label>
                    <textarea class="form-control" id="message-field" rows="3" name="message" required >{{ is_null(old("message")) ? $review->message : old('message') }}</textarea>
                    @if($errors->has("message"))
                        <span class="help-block">{{ $errors->first("message") }}</span>
                    @endif
                </div>
                <div class="form-group @if($errors->has('status')) has-error @endif">
                    <label for="status-field">Статус</label>
                    <select name="status" id="status-field" value="{{ is_null(old('status')) ? $review->status : old('status') }}">
                        <option value="0">Черновик</option>
                        <option value="1">Опубликован</option>
                    </select>
                    @if($errors->has("status"))
                        <span class="help-block">{{ $errors->first("status") }}</span>
                    @endif
                </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                    <a class="btn btn-link pull-right" href="{{ route('admin.reviews.index') }}"><i class="glyphicon glyphicon-backward"></i>  Назад</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script>
  <script>
    $('.date-picker').datepicker({
    });
  </script>
@endsection
