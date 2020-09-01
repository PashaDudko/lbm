<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWagerRequest;
use App\Wager;
use App\WagerSettings;
use Carbon\Carbon;
use App\Option;
use Illuminate\Http\Request;

class WagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wagers = Wager::all();

        return view('wagers.index')->with('wagers', $wagers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('wagers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreWagerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWagerRequest $request)
    {
//        $date = Carbon::now();
        $startDate = Carbon::parse($request->input('start_date')); // убрать эти 2 строчки, когда можно бует указывать
        $finishDate = Carbon::parse($request->input('finish_date'));// время при создании wager
        $newWagerId = Wager::create([
            'condition' => $request->input('condition'),
            'rate' => $request->input('rate') ?? 'fun',
            'user_id' => 1, // $user->id
            'start_date' => $startDate->format('Y-m-d H:i:s'),//$request->input('start_date'), //$date->format('Y-m-d H:i:s')
            'finish_date' => $finishDate->format('Y-m-d H:i:s'),//$request->input('finish_date'),//$date->modify('+7 day'),
        ])->id; // можно как-то по-другому получать айди?

        $newWagerSettingsId = WagerSettings::create([
            'wager_id' => $newWagerId,
        ])->id;

        Option::create([
            'wager_id' => $newWagerId,
        ]);

        $request->session()->flash('success','Wager was successfully created');

        return redirect()->route('wager-settings.edit', [$newWagerSettingsId]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Wager  $wager
     * @return \Illuminate\Http\Response
     */
    public function show(Wager $wager)
    {
        return view('wagers.show')->with([
            'wager' => $wager,
            'comments' => $wager->comments,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Wager  $wager
     * @return \Illuminate\Http\Response
     */
    public function edit(Wager $wager)
    {
        return view('wagers.edit')->with('wager', $wager);
    }

    /**
     * @param StoreWagerRequest $request
     * @param Wager $wager
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StoreWagerRequest $request, Wager $wager)
    {
        $item = Wager::findOrFail($wager->id);
        $item->update([
            'condition' => $request->input('condition'),
            'rate' => $request->input('rate'),
//            'img' => ,
//            'start_date' =>,
//            'finish_date' => ,
        ]);

        return redirect('/wagers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Wager  $wager
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wager $wager)
    {
        $item = Wager::findOrFail($wager->id);
        $item->delete();

        return redirect('/wagers');
    }
}
