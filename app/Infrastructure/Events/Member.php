<?php

namespace App\Infrastructure\Events;

class Member extends Eloquent
{
    use EventGenerator;

    public static function register($displayName, $email, $password)
    {
        $member = new static([ 'display_name' => $displayName, 'email' => $email, 'password' => $password, ]);

        $member->raise(new MemberJoined($member));

        return $member;
    }
}


http://www.slideshare.net/ShawnMcCool/laravelio-a-usecase-architecture     84+