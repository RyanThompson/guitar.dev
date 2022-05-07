<style>
    .fretboard {
        border: 2px solid #cccccc;
        border-left-width: 5px;
    }

    .fretboard__string {
        display: flex;
    }

    .fretboard__string:not(:last-of-type) {
        border-top: 2px solid #111111;
    }

    .fretboard__string:last-of-type {
        border-bottom: 2px solid #111111;
    }

    .fretboard__note {
        width: 7rem;
        height: 3rem;
        background: red;
        position: relative;
        border-right: 2px solid #cccccc;
    }

    .fretboard__note:first-child {
        width: 0;
    }

    .fretboard__note:first-child span {
        margin-left: -0.5rem;
    }

    .fretboard__note--fret::after,
    .fretboard__note--key::before {
        top: 0;
        left: 50%;
        z-index: 1;
        content: "";
        position: absolute;
        background: #ffffff;
        border-radius: 10rem;
        
        transform: translateY(calc(-50% - 2px));
    }

    .fretboard__note--key::before {
        opacity: 0.25;
        width: 2.5rem;
        height: 2.5rem;
        border: 2px solid #0000ff;
    }

    .fretboard__note--fret::after {
        opacity: 1;
        width: 2rem;
        height: 2rem;
        margin-left: .25rem;
        border: 2px solid #007606;
    }

    .fretboard__note--root::after {
        opacity: 1;
        width: 2rem;
        height: 2rem;
        margin-left: .25rem;
        background: #c8ffca;
    }

    .fretboard__note--open::before,
    .fretboard__note--open::after {
        left: -1rem !important;
    }

    .fretboard__note span {
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
    }

    .fretboard__string:last-of-type .fretboard__note {
        height: 0;
    }
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

<ul  style="margin-bottom: 2rem;">
    <li><strong>Key:</strong> {{ $key }}</li>
    <li><strong>Notes:</strong> {{ implode(', ', $notes) }}</li>
    @if ($chord)
    <li><strong>Chord:</strong> {{ implode(', ', array_map(function($degree) use ($theory, $key, $root) {
        return $theory->next($root, $degree - 1) . " (" . $degree . ") ";
    }, $chord)) }}</li>
    @endif
</ul>

<div class="fretboard">
    @for ($string = 0; $string < count($strings); $string++)
    <div class="fretboard__string" data-string="{{ $strings[$string] }}">
        @for ($fret = 0; $fret < $frets; $fret++)    
        @php
            $note = $theory->note($strings[$string], $fret);
            $degree = $theory->degree($note);
        @endphp
        <div class="
            fretboard__note
            {{ !$fret ? 'fretboard__note--open' : null }}
            {{ $note === $root ? 'fretboard__note--root' : null }}
            {{ in_array($note, $notes) ? 'fretboard__note--key' : null }}
            {{ in_array($note, $chordNotes) ? 'fretboard__note--fret' : null }}
            " data-note="{{ $note }}"><span>{{ $note }} {{ $degree ? "(" . $degree .  ")" : null }}</span></div>
        @endfor
    </div>    
    @endfor
</div>
