<?php

namespace App\Http\Controllers;

use App\Bet;
use App\Comment;
use App\Events\WagerHasFirstBet;
use App\Option;
use App\Wager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BettingController
{
    public function showWager(Wager $wager)
    {
//        dd(auth()->user()->id);
        $options = $wager->options;  // попробывать даже просто сделать return $wager->with('options);

        return view('betting.wager')->with([
            'wager' => $wager,
            'options' => $options,
            'comments' => $wager->comments,
            'betWasPlaced' => false,
//            'betWasSeen' => false, флаг будет использован если игрок открыл страницу но не ответил. Он не должен иметь право снова открывать этот вайджер
        ]);
    }

    public function createBetForOption(Wager $wager, Option $option)
    {
        $uuid = Str::uuid()->toString();

        Bet::create([
            'wager_id' => $wager->id,
            'option_id' => $option->id,
            'uuid' => $uuid,
        ]);

        $betsQuantity = Bet::where('wager_id', '=', $wager->id)->get()->count(); // вопрос по mysql: чем больше уловий в WHERE , тем бытсрее выполнитья запрос?

        if (1 == $betsQuantity) {
            $wager->first_bet_at_allotted_time = true;
            $wager->save();
            event(new WagerHasFirstBet($wager));
        }

        return view('betting.wager')->with([
            'wager' => $wager,
            'options' => $wager->options,
            'betWasPlaced' => true,
        ]);
    }

/*    public function formComment(Wager $wager)
    {
        return view('betting.comment')->with([
            'id' => $wager->id,
        ]);
    }*/

//    public function addComment(Request $request, Wager $wager)
    public function addComment(Request $request) // StoreCommentRequest $request
    {
        $uuid = Str::uuid()->toString();
        Comment::create([
            'uuid' => $uuid,
            'text' => $request->input('comment'),
            'wager_id' => $request->input('wager_id'),
        ]);
// Создать ивент, что бы на почту автору спора приходило извещение о новом комментарии, который нужно апрувнуть
        return redirect('/wagers');
    }

    public function publishComment(Request $request, Comment $comment)
    {
        $comment->published = true;
        $comment->save();

        return redirect()->back();
    }

    public function showWagerResult(Wager $wager)
    {
//        $now = Carbon::now();
//        $now = Carbon::parse('22-07-2020 10:00:01');
//        $totalDuration = $finishDate->diff($now)->format('%d-%h-%m');

//        dd($totalDuration);

//        var_dump($finishDate);die;
//        var_dump(date_diff(new DateTime(), new DateTime($wager->finish_at))->format('d-H-m'));die;
        $finishDate = Carbon::parse($wager->finish_at);
        $remaningTime = $finishDate->diff(Carbon::now())->format('%d-%h-%m');
        $remaningTime = explode('-', $remaningTime );

        $days = array_fill_keys(['days'], $remaningTime[0]);
        $hours = array_fill_keys(['hours'], $remaningTime[1]);
        $minutes = array_fill_keys(['minutes'], $remaningTime[2]);

        $remaningTimeArr = array_merge($days, $hours, $minutes);

        return view('betting.wager_finish')->with([
            'wager' => $wager,
            'remaning' => $remaningTimeArr,
            ]);
    }
}

