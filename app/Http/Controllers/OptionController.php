<?php

namespace App\Http\Controllers;

use App\Option;
use App\Http\Requests\StoreOptionRequest;
use Illuminate\Http\Request;

class OptionController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
        public function store(StoreOptionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function show(Option $option)
    {
        //return view('options.show')->with('option', $option);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Option  $Option
     * @return \Illuminate\Http\Response
     */
    public function edit(Option $option)
    {
        $type = $option->wager->settings->type; // или переписать на чистый sql  ?? Или эту строчку во вью использовать вместо type ??

        return view('options.edit')->with([
            'option' => $option,
            'wagerId' => $option->wager->id,
            'type' => $type,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Option  $Option
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOptionRequest $request, Option $option)
    {
        $item = Option::findOrFail($option->id);
        $item->update([
            'text' => $request->input('text'),
        ]);

        return redirect('/wagers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Option  $Option
     * @return \Illuminate\Http\Response
     */
    public function destroy(Option $option)
    {
        $item = Option::findOrFail($option->id);
        $item->delete();

        return redirect('/options');
    }
}
