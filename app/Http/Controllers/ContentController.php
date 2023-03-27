<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Content;

class ContentController extends Controller
{
    public function saveWithVue(Request $request){
        $newContent = $request->all();
        $response = Content::create($newContent);
        return response()->json([
            'status' => 'success',
            'data' => $response
        ], 200);
    }

    public function indexContent()
    {
        return Content::all();
         
    }

    public function updateWithVue(Request $request, $id){
        $updatedContent = Content::find($id);

        $updatedContent->name = $request->input('name');
        $updatedContent->content = $request->input('content');
        $updatedContent->route = $request->input('route');
        $updatedContent->isActive = $request->input('isActive');

        $updatedContent->update();

        return response()->json([
            'status' => 200,
            'message' => 'Content is updated',
        ], 200);
        
    }

    public function deleteWithVue(Request $request, $id){
        $deletedContent = Content::find($id);
        $deletedContent->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Todo is deleted',
        ], 200);
    }
}
