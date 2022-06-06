<?php

namespace App\Theory;

use Streams\Ui\Support\Component;

class FretboardComponent extends Component
{
    public string $component = 'fretboard';
    
    public string $template = 'theory/fretboard';

    public int $frets = 6;

    public string $root = 'C';
    
    public ?string $scale = null;

    public ?string $chord = null;
}
