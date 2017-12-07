@extends('layouts.main')

@section('breadcrumbs')
	{!!  Breadcrumbs::render('page', $page) !!}
@endsection

@section('content')
	{!! $page->content !!}

	@include('content.contacts_map')

<form id="write_us" action="{{ route('letter') }}" method="post" class="write_us" accept-charset="utf-8">
	{{ csrf_field() }}
	<h3>Напишите нам</h3>
	<p>Оставьте телефон и наш менеджер свяжется с Вами в течение часа</p>


	<div class="inputs">
		<label>
			<i class="fa fa-user" aria-hidden="true"></i>
			<input type="text" name="name" value="" placeholder="Ваше имя">
		</label>
		<label>
			<i class="fa fa-phone" aria-hidden="true"></i>
			<input type="text" name="phone" value="" class="phone-mask" placeholder="Ваш телефон">
		</label>
		<label>
			<i class="fa fa-envelope" aria-hidden="true"></i>
			<input type="email" name="email" value="" placeholder="Ваш @mail">
		</label>
	</div>
	<div class="textarea">
		<label>
			<i class="fa fa-comment" aria-hidden="true"></i>
			<textarea name="text" placeholder="Ваше сообщение"></textarea>
		</label>
	</div>
	<input type="submit" class="btn" value="ОТПРАВИТЬ">
</form>
<p class="orange">
    Деятельность интернет-магазина осуществляется в соответствии с действующим Российским законодательством и, в частности, в соответствии с законом «О защите прав потребителей» № 2300-1 от 07.02.1992.                     <br>                     Вся информация на нашем сайте носит справочный характер и не является публичной офертой, определяемой положениями ст. 437 ГК РФ
</p>

@endsection