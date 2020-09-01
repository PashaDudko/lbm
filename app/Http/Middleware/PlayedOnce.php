<?php

namespace App\Http\Middleware;

use App\Http\Repository\BetRepository;
use Closure;
use Illuminate\Support\Facades\Auth;

class PlayedOnce
{
    private $betEntryRepository;

    /**
     * PlayedOnce constructor.
     * @param $betRepository
     */
    public function __construct(BetRepository $betRepository)
    {
        $this->betRepository = $betRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $wager = $request->wager;
//        auth()->user()->id
        $uuid = Auth::user()->uuid ?? ''; // в идеале надо получаить из куки или как-то присваивать когда игрок заходи в игру. Подумать!

        if (0 != count($this->betRepository->getBetEntries($wager, $uuid))) { // или поменять метод н статик и тогда конструктор не нужен?
            return 'Seems that you have already played';
        }

        return $next($request);
    }
}
