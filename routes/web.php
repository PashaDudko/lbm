<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function () {
//    return view('welcome');
    return view('home');
});

//GET 	        /photos 	                index 	    photos.index
//GET 	        /photos/create 	            create 	    photos.create
//POST 	        /photos 	                store 	    photos.store
//GET 	        /photos/{photo} 	        show 	    photos.show
//GET 	        /photos/{photo}/edit 	    edit 	    photos.edit
//PUT/PATCH 	/photos/{photo} 	        update 	    photos.update
//DELETE 	    /photos/{photo} 	        destroy 	photos.destroy
Route::resources([
    'wagers' => 'WagerController',
    'options' => 'OptionController',
    'wager-settings' => 'WagerSettingsController',
//    'comments' => 'CommentController',
]);

Route::get('/betting/{wager}', 'BettingController@showWager')->name('betting.start')->middleware(['status.active','played.once']);//->middleware('auth', 'unplayed');
Route::get('/betting/{wager}/{option}/', 'BettingController@createBetForOption')->name('betting.bet');//->middleware('played.once');
//Route::get('/betting/{wager}/comment/', 'BettingController@formComment')->name('betting.form.comment');
//Route::post('/betting/{wager}/comment/', 'BettingController@addComment')->name('betting.add.comment');
Route::post('/betting/add-comment/', 'BettingController@addComment')->name('betting.add.comment');
Route::put('/betting/publish-comment/{comment}', 'BettingController@publishComment')->name('betting.publish.comment');
Route::get('/betting/result/{wager}', 'BettingController@showWagerResult')->name('betting.finish');//->middleware('auth');

//Route::get('/answer/{answer}/bet/', 'BetController@createBetForAnswer')->name('bets.create');


//Route::get('/home', 'HomeController@index')->name('home');
