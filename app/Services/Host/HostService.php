<?php

namespace App\Services\Host;

use App\Models\Host;

class HostService
{
    public function storeHost(array $requester)
    {
        return Host::create([
            'first_name'    => $requester['first_name'],
            'last_name'     => $requester['last_name'],
            'national_code' => $requester['national_code'],
            'phone_number'  => $requester['phone_number'],
            'email'         => $requester['email'],
        ]);
    }
}
