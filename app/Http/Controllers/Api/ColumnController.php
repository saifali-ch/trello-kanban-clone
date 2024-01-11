<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Column;
use Illuminate\Http\Request;

class ColumnController extends Controller
{
    public function index() {
        $columns = Column::with('cards')->orderBy('order')->get();
        return response()->json(['columns' => $columns]);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
        ]);

        $validatedData['order'] = Column::count();

        $column = Column::create($validatedData);
        return response()->json(['message' => 'Column added successfully', 'column' => $column]);
    }

    public function destroy(Column $column) {
        $column->cards()->delete();
        $column->delete();
        return response()->json(['message' => 'Column deleted successfully']);
    }

    protected function reorder(Request $request) {
        $columnIds = $request->input('column_ids');
        foreach ($columnIds as $index => $columnId) {
            $column = Column::find($columnId);
            $column->order = $index;
            $column->save();
        }

        return response()->json(['message' => 'Cards reordered successfully!']);
    }
}
