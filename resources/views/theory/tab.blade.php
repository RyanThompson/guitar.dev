<style>
    .tab {}

    .tab__string {
        display: flex;
        background: #ccc;
    }

    .tab__note {
        width: 30px;
    }

    .tab__note:first-child {
        border-left: 5px solid #333333;
    }

    .tab__note--root {
        background: #fff555;
    }

    /* .tab__note--fret::after,
    .tab__note--key::before {
        top: 0;
        left: 50%;
        z-index: 1;
        content: "";
        position: absolute;
        background: #ffffff;
        border-radius: 10rem;
        
        transform: translateY(calc(-50% - 2px));
    } */
    /* .tab__note span {
        top: 0;
        left: 53%;
        z-index: 5;
        content: "";
        color: #000000;
        font-size: .6rem;
        font-weight: bold;
        position: absolute;
        margin-left: .25rem;
        white-space: nowrap;
        
        transform: translateY(calc(-50% - 2px));
    } */

</style>

@php

    // $ordinalSuffix = function ($n) {
    //     return date('S',mktime(1,1,1,1,( (($n>=10)+($n>=20)+($n==0))*10 + $n%10) ));
    // };
    
    $strings = [
        'E',
        'B',
        'G',
        'D',
        'A',
        'E'
    ];

    $scale = Request::get('scale');
    
    $frets = Request::get('frets', 15);

    $key = strtoupper(Request::get('key', 'C'));
    $root = strtoupper(Request::get('root', $key));

    $chord = strtolower(Request::get('chord', 'major_triad'));
    
    $theory = new App\Theory\Theory($key);

    $notes = $theory->scale($scale);
    $chord = $theory->chord($chord);

@endphp
<div class="tab">
    @for ($string = 0; $string < count($strings); $string++) <div class="tab__string"
        data-string="{{ $strings[$string] }}">
        @for ($fret = 0; $fret < $frets; $fret++) @php $note=$theory->note($fret, $strings[$string]);
            $degree = $theory->degree($note);
            @endphp
            <div class="
            tab__note
            {{ !$fret ? 'tab__note--open' : null }}
            {{ $note === $root ? 'tab__note--root' : null }}
            {{ in_array($note, $notes) ? 'tab__note--key' : null }}
            {{ in_array($note, $chord) ? 'tab__note--fret' : null }}
            " data-note="{{ $note }}">
                @if (in_array($note, $chord))
                {{ $fret }}
                @else
                -
                @endif
            </div>
            @endfor
</div>
@endfor
</div>
