<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;
use App\Services\WordService;
use App\Http\Requests\WordShowRequest;
use App\Http\Resources\WordScoreResource;

class WordScoreController extends Controller
{
    public function index(Request $request) {
        return WordScoreResource::collection(Word::paginate(15));
    }

    public function show($word, WordShowRequest $request)
    {
        try {
            $word = (new WordService())
                ->setSourceService($request->get("source"))
                ->getWord($word);
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage(), "statusCode" => $e->getCode()]);
        }

        return new WordScoreResource($word);
    }
}
