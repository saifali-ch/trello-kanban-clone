<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Spatie\DbDumper\Databases\MySql;

class BoardController extends Controller
{
    public function dumpDatabase() {
        MySql::create()
            ->setDbName(config('database.connections.mysql.database'))
            ->setUserName(config('database.connections.mysql.username'))
            ->setPassword(config('database.connections.mysql.password'))
            ->dumpToFile('board.sql');
        return response()->download(public_path('board.sql'));
    }
}
