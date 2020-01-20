<?php

namespace App\Exceptions;

use App\Data\VoteBuilder;
use Illuminate\Contracts\Support\Renderable;
use Throwable;

class AddressParsingException extends \Exception
{
    protected $voteBuilder;

    public function __construct($message, VoteBuilder $voteBuilder, $line)
    {
        $message .= "\n Pending: " . json_encode($voteBuilder->pending);
        $message .= "\n Current: $voteBuilder->current";
        $message .= "\n Line: $line";
        $message .= "\n People: " . json_encode($voteBuilder->getPeople());

        parent::__construct($message, 0, null);
        $this->voteBuilder = $voteBuilder;
    }

}
