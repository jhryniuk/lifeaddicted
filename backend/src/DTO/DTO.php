<?php

namespace App\DTO;

interface DTO
{
    public function toArray():? array;
    public function toObject();
}