@if(!empty($row->roles()->pluck('id')->implode(' ')))
   {{ $row->roles()->pluck('name')->implode(' ') }}
@else
   <a class="without-role">{{ __('strings.Without a Role') }}</a>
@endif
