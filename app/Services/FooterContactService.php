<?php

namespace App\Services;

use App\Models\FooterContact;

class FooterContactService
{
    public function index()
    {
        return FooterContact::orderBy('id', 'desc')->get();
    }

    public function update(FooterContact $contact, array $data)
    {
        $contact->update($data);
        return $contact->refresh();
    }
}