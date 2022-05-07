<?php

namespace App\Theory;

use Streams\Core\Support\Traits\Prototype;

class Theory
{
    use Prototype {
        Prototype::__construct as constructPrototype;
    }

    public string $key = 'C';

    public array $notes = ['A', 'A#', 'B', 'C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#'];

    public function __construct(array $attributes = [])
    {
        $this->constructPrototype($attributes);
    }

    public function scale($root = null, $scale = [2, 2, 1, 2, 2, 2])
    {
        $root = $root ?: $this->key;

        $notes[] = $note = $root;

        foreach ($scale as $interval) {
            $notes[] = $note = $this->note($note, $interval);
        }

        return $notes;
    }

    public function note($root, $interval)
    {
        $position = array_search($root, $this->notes);

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
