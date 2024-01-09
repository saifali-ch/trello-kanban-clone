<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Column;
use Illuminate\Http\Request;
use Spatie\DbDumper\Databases\MySql;

class BoardController extends Controller
{
    public function getBoardData() {
        $columns = Column::with('cards')->get();
        return response()->json(['columns' => $columns]);
    }

    public function addColumn(Request $request) {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
        ]);

        $column = Column::create($validatedData);
        return response()->json(['message' => 'Column added successfully', 'column' => $column]);
    }

    public function deleteColumn(Column $column) {
        $column->cards()->delete();
        $column->delete();
        return response()->json(['message' => 'Column deleted successfully']);
    }

    public function dumpDatabase() {
        MySql::create()
            ->setDbName(config('database.connections.mysql.database'))
            ->setUserName(config('database.connections.mysql.username'))
            ->setPassword(config('database.connections.mysql.password'))
            ->dumpToFile('board.sql');
        return response()->download(public_path('board.sql'));
    }
}
