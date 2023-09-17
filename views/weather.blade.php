@component('components.main', ['title' => 'Weather'])
    <div class="grid grid-cols-6 border border-black mb-2">
        <div class="bg-sky-500 text-white font-bold border-b border-black px-1">Location</div>
        <div class="border-b border-black px-1">{{ $location }}</div>
        <div class="bg-sky-500 text-white font-bold border-b border-black px-1">Area</div>
        <div class="border-b border-black px-1">{{ ucwords(strtolower($data['Location']['name'])) }}</div>
        <div class="bg-sky-500 text-white font-bold border-b border-black px-1">Country</div>
        <div class="border-b border-black px-1">{{ ucwords(strtolower($data['Location']['country'])) }}</div>
        <div class="bg-sky-500 text-white font-bold px-1">Continent</div>
        <div class="py-1">{{ ucwords(strtolower($data['Location']['continent'])) }}</div>
        <div class="bg-sky-500 text-white font-bold px-1">Coordinates</div>
        <div class="px-1">{{ $data['Location']['lat'] }} lat {{ $data['Location']['lon'] }} lon</div>
        <div class="bg-sky-500 text-white font-bold px-1">Elevation</div>
        <div class="px-1">{{ $data['Location']['elevation'] }} m</div>
    </div>
    @php($weather = $data['Location']['Period'])
    @foreach($data['Location']['Period'] as $key => $item)
    @php($currentDate = \Carbon\Carbon::parse($item['value'])->format('j F Y'))
    @php($periods = $item['Rep'])
        <div class="border border-black mb-1">
            <div class="text-2xl font-bold bg-blue-950 text-white px-1 border-b">{{ $currentDate }}</div>
            @foreach($periods as $period)
                <div class="text-xl font-bold bg-sky-500 text-white px-1 border-y border-black">{{ $period['$'] }}</div>
                @php($details = $period)
                @foreach($details as $k => $detail)
                    @if($k !== '$')
                        <div class="flex flex-row border-b border-slate-400">
                            <div class="w-64 px-1 bg-sky-200">{{ $legend[$k]['name'] }}</div>
                            <div class="w-auto px-1">
                                @switch($k)
                                    @case('W')
                                        @php($unit = (int) $legend[$k]['units'])
                                        {{ $weatherType[$unit] }}
                                        @break
                                    @case('V')
                                        {{ $visibility[$detail] }}
                                        @break
                                    @default
                                        {{ $detail }} {{ $legend[$k]['units'] }}
                                @endswitch()


                            </div>
                        </div>
                    @endif
                @endforeach
            @endforeach
        </div>
    @endforeach
@endcomponent