<?php

namespace App\Persistence\Services\Work;

interface IDomainEvent
{
    function execute();
}