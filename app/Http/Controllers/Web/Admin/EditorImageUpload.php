<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EditorImageUpload extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate(['image' => 'required|image|max:4096']);
        $path = $request->file('image')->store('editor', 'public');
        return response()->json(['url' => asset('storage/' . $path)]);
    }
}
