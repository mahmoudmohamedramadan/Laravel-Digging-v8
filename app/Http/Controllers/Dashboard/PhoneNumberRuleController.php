<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\{Rules\PhoneNumberRule, Http\Controllers\Controller, Http\Requests\PhoneNumberRequest};

class PhoneNumberRuleController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('custom_rules.phone');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'number' => new PhoneNumberRule,
        ]);

        // Another form to call the custom rule and in this case you may need to pass some parameters
        // $request->validate([
        //     'number' => new PhoneNumberRule(),
        // ]);

        return back()->with('success', 'correct number sent');
    }

    /**
     * Store the phone number with a custom request.
     *
     * @param  \App\Http\Requests\PhoneNumberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeWithCustomRequest(PhoneNumberRequest $request)
    {
        return back()->with('success', 'correct number sent');
    }
}
