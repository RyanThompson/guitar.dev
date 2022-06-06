<?php

namespace App\Theory;

use Illuminate\Support\Arr;
use Streams\Core\Support\Traits\Prototype;

class Theory
{
    use Prototype {
        Prototype::__construct as constructPrototype;
    }

    public string $key = 'C';

    public array $notes = ['A', 'A#', 'B', 'C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#'];

    public array $intervals = [
        0 => [
            'name' => 'Perfect Unison',
            'alt' => [
                'name' => 'Diminished Second',
            ],
        ],
        1 => [
            'name' => 'Minor Second',
            'alt' => [
                'name' => 'Augmented Unison',
            ],
        ],
        2 => [
            'name' => 'Major Second',
            'alt' => [
                'name' => 'Diminished Third',
            ],
        ],
        3 => [
            'name' => 'Minor Third',
            'alt' => [
                'name' => 'Augmented Second',
            ],
        ],
        4 => [
            'name' => 'Major Third',
            'alt' => [
                'name' => 'Diminished Fourth',
            ],
        ],
        5 => [
            'name' => 'Perfect Fourth',
            'alt' => [
                'name' => 'Augmented Third',
            ],
        ],
        6 => [
            'name' => 'Diminished Fifth',
            'alt' => [
                'name' => 'Augmented Fourth',
            ],
        ],
        7 => [
            'name' => 'Perfect Fifth',
            'alt' => [
                'name' => 'Diminished Sixth',
            ],
        ],
        8 => [
            'name' => 'Minor Sixth',
            'alt' => [
                'name' => 'Augmented Fifth',
            ],
        ],
        9 => [
            'name' => 'Major Sixth',
            'alt' => [
                'name' => 'Diminished Seventh',
            ],
        ],
        10 => [
            'name' => 'Minor Seventh',
            'alt' => [
                'name' => 'Augmented Sixth',
            ],
        ],
        11 => [
            'name' => 'Major Seventh',
            'alt' => [
                'name' => 'Diminished Octave',
            ],
        ],
        12 => [
            'name' => 'Perfect Octave',
            'alt' => [
                'name' => 'Augmented Seventh',
            ],
        ],
    ];

    public array $scales = [
        'ionian' => [
            'alt' => 'major',
            'steps' => [2, 2, 1, 2, 2, 2, 1],
        ],
        'dorian' => [
            'steps' => [2, 1, 2, 2, 2, 1, 2],
        ],
        'phrigian' => [
            'steps' => [1, 2, 2, 2, 1, 2, 2],
        ],
        'lydian' => [
            'steps' => [2, 2, 2, 1, 2, 2, 1],
        ],
        'mixolydian' => [
            'steps' => [2, 2, 1, 2, 2, 1, 2],
        ],
        'aeolian' => [
            'alt' => 'minor',
            'steps' => [2, 1, 2, 2, 1, 2, 2],
        ],
        'locrian' => [
            'steps' => [1, 2, 2, 1, 2, 2, 2],
        ],
        'major_pentatonic' => [
            'steps' => [2, 2, 3, 2],
        ],
        'minor_pentatonic' => [
            'steps' => [3, 2, 2, 3],
        ],
        'major_blues' => [
            'steps' => [2, 1, 1, 3, 2],
        ],
        'minor_blues' => [
            'steps' => [3, 2, 1, 1, 3],
        ],
    ];

    public array $chords = [
        'major_triad' => [
            'name' => 'Major Triad',
            'components' => [0, 4, 7],
        ],
        'major_sixth' => [
            'name' => 'Major Sixth',
            'components' => [0, 4, 7, 9],
        ],
        'dominant_seventh' => [
            'name' => 'Dominant Seventh',
            'components' => [0, 4, 7, 10],
        ],
        'major_seventh' => [
            'name' => 'Major Seventh',
            'components' => [0, 4, 7, 11],
        ],
        'augmented_triad' => [
            'name' => 'Augmented Triad',
            'components' => [0, 4, 8],
        ],
        'augmented_seventh' => [
            'name' => 'Augmented Seventh',
            'components' => [0, 4, 8, 10],
        ],
        'minor_triad' => [
            'name' => 'Minor Triad',
            'components' => [0, 3, 7],
        ],
        'minor_sixth' => [
            'name' => 'Minor Sixth',
            'components' => [0, 3, 7, 9],
        ],
        'minor_seventh' => [
            'name' => 'Minor Seventh',
            'components' => [0, 3, 7, 10],
        ],
        'minor_major_seventh' => [
            'name' => 'Minor-Major Seventh',
            'components' => [0, 3, 7, 11],
        ],
        'diminished_triad' => [
            'name' => 'Diminished Triad',
            'components' => [0, 3, 6],
        ],
    ];

    public function __construct($root = 'C')
    {
        $this->constructPrototype([
            'root' => $root,
        ]);
    }

    public function scale($scale = null, $root = null)
    {
        $root = $root ?: $this->key;
        $scale = $scale ?: 'ionian';

        $notes[] = $note = $root;

        if (!$scale = Arr::get($this->scales, $original = $scale, [])) {
            throw new \Exception("Scale [{$original}] not found.");
        }

        foreach ($scale['steps'] as $interval) {
            $notes[] = $note = $this->note($interval, $note);
        }

        return $notes;
    }

    public function chord(string $chord = 'major_triad', string $root = null)
    {
        $root = $root ?: $this->key;

        if (!$chord = Arr::get($this->chords, $original = $chord, [])) {
            throw new \Exception("Chord [{$original}] not found.");
        }

        $notes = [];

        foreach ($chord['components'] as $interval) {
            $notes[] = $this->note($interval);
        }

        return $notes;
    }

    public function note(int $interval, string $note = null)
    {
        $note = $note ?: $this->key;

        $position = array_search($note, $this->notes);

        $target = ($position + $interval) % 12;

        return $this->notes[$target];
    }

    public function degree($note)
    {
        return $this->interval($note) + 1;
    }

    public function interval(string $note)
    {
        $degree = array_search($note, $this->scale());

        if ($degree === false) {
            return null;
        }

        return $degree;
    }

    public function next(string $note, int $degree = 1, $scale = null)
    {
        $notes = $this->scale($scale, $this->key);

        $position = array_search($note, $notes);

        $target = ($position + $degree) % 7;

        return $notes[$target];
    }
}
