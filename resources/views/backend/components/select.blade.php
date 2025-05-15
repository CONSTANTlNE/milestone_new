@php
        $zone = [
            [
                'id' => '1',
                'title' => 'Top Banner'
            ],
            [
                'id' => '2',
                'title' => 'Bottom Banner'
            ],
        ];
        $status = [
            [
                'id' => '1',
                'title' => 'გააქტიურება'
            ],
            [
                'id' => '0',
                'title' => 'დაბლოკვა'
            ],
        ];
        $icons = [
            [
                'id' => '1',
                'title' => 'Facebook',
                'icon' => 'facebook-square'
            ],
            [
                'id' => '2',
                'title' => 'Twitter',
                'icon' => 'twitter-square'
            ],
            [
                'id' => '3',
                'title' => 'Youtube',
                'icon' => 'youtube-square'
            ],
            [
                'id' => '4',
                'title' => 'Instagram',
                'icon' => 'instagram'
            ],
            [
                'id' => '5',
                'title' => 'Tiktok',
                'icon' => 'tiktok'
            ],
            [
                'id' => '6',
                'title' => 'Linkedin',
                'icon' => 'linkedin-square'
            ],
        ];
@endphp
<div class="col-md-{{ $width }}">
    <div class="form-group position-relative select-access">
        <label class="control-label font-w600"
               @if($required) for="validationTipSelect{{$title}}" @endif
               @if($disabled)  disabled @endif
        >
            {{ __('strings.'.$label) }} {{ empty($lang["name"]) ? '' : '- ('.$lang["name"].')' }}
        </label>

        <select class="select2 form-control select2"
                @if($required)   id="validationTipSelect{{$title}}"  required @endif
                name="{{ $title }}"
        >
            @if($staticData)
                @if(!empty($dataSingle))
                    {!! $dataSingle !!}
                @else
                    <option value="0">{{ __('strings.'.$placeHolder) }}</option>
                @endif
                @foreach($value as $val)
                    <option value="{{ $val->id }}"  {{(old($title)==$val->id)? 'selected':''}}>
                        {{ $val->getTranslation('title', app()->getLocale()) }} @if($val->name)- {{ $val->name }} @endif
                    </option>
                @endforeach
            @elseif($title == 'icon')
                @if(!empty($dataSingle))
                    {!! $dataSingle !!}
                @endif
                @foreach($icons as $s)
                    <option value="{{ $s['icon'] }}"  {{(old($title)==$s['title'])? 'selected':''}}>{{ $s['title'] }}</option>
                @endforeach
            @elseif($title == 'zone')
                @if(!empty($dataSingle))
                    {!! $dataSingle !!}
                @else
                    <option value="0">{{ __('strings.'.$placeHolder) }}</option>
                @endif
                @foreach($zone as $s)
                    <option value="{{ $s['id'] }}"  {{(old($title)==$s['id'])? 'selected':''}}>{{ $s['title'] }}</option>
                @endforeach
            @else
                @foreach($status as $s)
                    <option value="{{ $s['id'] }}"  {{(old($title)==$s['id'])? 'selected':''}}>{{ $s['title'] }}</option>
                @endforeach
            @endif
        </select>

    </div>
</div>
