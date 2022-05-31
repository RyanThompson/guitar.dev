<style>
    .tab {}

    .tab__string {
        display: flex;
        margin-top: 30px;
        height: 6em;
        background: #ccc;
    }

    .tab__note {
        width: calc(100% / 15);
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

$key = strtoupper(Request::get('key', 'G'));

$theory = new App\Theory\Theory([
'key' => $key,
]);

$ordinalSuffix = function ($n)
{
return date('S',mktime(1,1,1,1,( (($n>=10)+($n>=20)+($n==0))*10 + $n%10) ));
};

$strings = [
'E',
'B',
'G',
'D',
'A',
'E'
];

$root = strtoupper(Request::get('root', $key));

$chord = strtolower(Request::get('chord', 'maj'));

$notes = $theory->scale($key);

$frets = Request::get('frets', 15);

$chords = [
'maj' => [1, 3, 5],
'maj7' => [1, 3, 5, 7],
];

$chord = Arr::get($chords, $chord, []);

$chordNotes = array_map(function($degree) use ($root, $key, $theory) {
return $theory->next($root, $degree - 1);
}, $chord);

@endphp
<div class="tab">
    @for ($string = 0; $string < count($strings); $string++) <div class="tab__string"
        data-string="{{ $strings[$string] }}">
        @for ($fret = 0; $fret < $frets; $fret++) @php $note=$theory->note($strings[$string], $fret);
            $degree = $theory->degree($note);
            @endphp
            <div class="
            tab__note
            {{ !$fret ? 'tab__note--open' : null }}
            {{ $note === $root ? 'tab__note--root' : null }}
            {{ in_array($note, $notes) ? 'tab__note--key' : null }}
            {{ in_array($note, $chordNotes) ? 'tab__note--fret' : null }}
            " data-note="{{ $note }}">
                @if (in_array($note, $chordNotes))
                {{ $fret }}
                @else
                -
                @endif
            </div>
            @endfor
</div>
@endfor
</div>
