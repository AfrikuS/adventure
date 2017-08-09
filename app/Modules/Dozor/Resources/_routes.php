<?php

Route::get('/dozor', 'Dozor\Http\Controllers\DozorController@index')->name('dozor_index_page');

Route::post('/dozor/start', 'Dozor\Http\Controllers\DozorController@startDozorQuest')->name('dozor_start_quest_action');
