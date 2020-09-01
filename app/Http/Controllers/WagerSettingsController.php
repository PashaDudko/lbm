<?php

namespace App\Http\Controllers;

use App\Option;
use App\WagerSettings;
use Illuminate\Http\Request;

class WagerSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('wager_settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        'status' => 'created',
//            'type' => $request->input('type'),
//            'visibility' => 'public',
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WagerSettings  $wagerSettings
     * @return \Illuminate\Http\Response
     */
    public function show(WagerSettings $wagerSettings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WagerSettings  $wagerSettings
     * @return \Illuminate\Http\Response
     */
    public function edit(WagerSettings $wagerSetting)
    {
        return view('wager_settings.edit')->with('wagerSetting', $wagerSetting);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WagerSettings  $wagerSettings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WagerSettings $wagerSetting)
    {
        $item = WagerSettings::findOrFail($wagerSetting->id);
        $item->update([
            'bets_limit' => $request->input('bets_limit'),
            'status' => $request->input('status'),
            'type' => $request->input('type'),
            'enabled' => $request->input('enabled'),
            'visibility' => $request->input('visibility'),
        ]);

        $option = Option::where('wager_id', $wagerSetting->wager_id)->first();

        return redirect()->route('options.edit', [$option->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WagerSettings  $wagerSettings
     * @return \Illuminate\Http\Response
     */
    public function destroy(WagerSettings $wagerSettings)
    {
        //
    }
}
