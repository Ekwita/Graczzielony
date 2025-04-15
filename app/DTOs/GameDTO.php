<?php

namespace App\DTOs;

class GameDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $year,
        public ?string $image
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'year' => $this->year,
            'image' => $this->image,
        ];
    }
}
