<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\{Rules\PhoneNumberRule, Http\Controllers\Controller, Http\Requests\PhoneNumberRequest};

class PhoneNumberRuleController extends Controller
{
    public function create()
    {
        return view('custome_rules.phone');
    }

    public function store(Request $request)
    {
        $request->validate([
            'number' => new PhoneNumberRule,
        ]);

        /* another form to call the custom rule and in this case you may need to pass some parameters */
        // $request->validate([
        //     'number' => new PhoneNumberRule(),
        // ]);

        return back()->with('success', 'correct number sent');
    }

    public function storeWithCustomRequest(PhoneNumberRequest $request)
    {
        return back()->with('success', 'correct number sent');
    }
}
