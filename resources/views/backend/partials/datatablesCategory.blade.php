@if(count($row->modelCategory))
   	@foreach($row->modelCategory as $category)
		<span>{{ $category->getTranslation('title', app()->getLocale()) }}</span>
	@endforeach
@else
    <span>.....</span>
@endif