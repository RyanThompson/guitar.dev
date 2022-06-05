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

    public array $intervals = ['perfect_unison', 'minor_second', 'major_second', 'minor_third', 'major_third', 'perfect_fourth', 'perfect_fifth', 'major_sixth', 'minor_seventh', 'major_seventh', 'perfect_octave'];

    public array $scales = [
        'ionian' => [2, 2, 1, 2, 2, 2, 1],
        'dorian' => [2, 1, 2, 2, 2, 1, 2],
        'phrigian' => [1, 2, 2, 2, 1, 2, 2],
        'lydian' => [2, 2, 2, 1, 2, 2, 1],
        'mixolydian' => [2, 2, 1, 2, 2, 1, 2],
        'aeolian' => [2, 1, 2, 2, 1, 2, 2],
        'locrian' => [1, 2, 2, 1, 2, 2, 2],
        'major_pentatonic' => [2, 2, 3, 2],
        'minor_pentatonic' => [3, 2, 2, 3],
        'major_blues' => [2, 1, 1, 3, 2],
        'minor_blues' => [3, 2, 1, 1, 3],
    ];

    public function __construct($root = 'C')
    {
        $this->constructPrototype([
            'root' => $root,
        ]);
    }

    public function scale($scale = 'ionian', $root = null)
    {
        $semitone = 0;

        $root = $root ?: $this->key;

        $notes[] = $note = $root;

        $scale = Arr::get($this->scales, $scale, []);

        foreach ($scale as $interval) {
            $notes[] = $note = $this->nextNote($note, $interval);
        }

        return $notes;
    }

    public function nextNote($note, $interval)
    {
        $position = array_search($note, $this->notes);

        $target = ($position + $interval) % 12;

        return $this->notes[$target];
    }

    public function degree($note)
    {
        $degree = array_search($note, $this->scale($this->key));

        if ($degree === false) {
            return null;
        }

        return $degree + 1;
    }

    public function next($note, $degree = 1)
    {
        $notes = $this->scale($this->key);

        $position = array_search($note, $notes);

        $target = ($position + $degree) % 7;

        return $notes[$target];
    }
}
