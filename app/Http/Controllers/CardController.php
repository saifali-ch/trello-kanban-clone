<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Column;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CardController extends Controller
{
    public function index(Request $request) {
        $validator = Validator::make($request->all(), [
            'access_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(status: 400);
        }

        if (!$this->isValidAccessToken($request->access_token)) {
            return response()->json(status: 401);
        }

        $query = Card::select(['id', 'title', 'created_at', 'description', 'deleted_at']);

        if ($request->has('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->has('status')) {
            if ($request->status) {
                $query->withoutTrashed();
            } else {
                $query->onlyTrashed();
            }
        } else {
            $query->withTrashed();
        }

        $cards = $query->get();

        return response()->json($cards);
    }

    private function isValidAccessToken($accessToken) {
        return strcasecmp(config('auth.api_access_token'), $accessToken) === 0;
    }

    public function store(Request $request, Column $column) {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
        ]);

        $card = $column->cards()->create([
            'title' => $request->input('title'),
            'description' => $request->input('description', ''),
            'order' => $column->cards()->count() + 1,
        ]);

        return response()->json(['message' => 'Card added successfully', 'card' => $card]);
    }

    public function reorder(Request $request, Card $card) {
        $newColumnId = $request->input('new_column_id');
        $card->column_id = $newColumnId;
        $card->save();

        $oldColumnSortedCardIds = $request->input('old_column_sorted_card_ids');
        $newColumnSortedCardIds = $request->input('new_column_sorted_card_ids');

        $this->updateCardOrder($oldColumnSortedCardIds);
        $this->updateCardOrder($newColumnSortedCardIds);

        return response()->json(['message' => 'Cards reordered successfully!']);
    }

    protected function updateCardOrder($cardIds) {
        foreach ($cardIds as $index => $cardId) {
            $card = Card::find($cardId);
            $card->order = $index;
            $card->save();
        }
    }

    public function updateTitle(Request $request, Card $card) {
        $title = $request->input('title');
        $card->title = $title;
        $card->save();

        return response()->json(['message' => 'Cards title updated successfully!']);
    }

    public function updateDescription(Request $request, Card $card) {
        $description = $request->input('description');
        $card->description = $description;
        $card->save();

        return response()->json(['message' => 'Cards description updated successfully!']);
    }
}
