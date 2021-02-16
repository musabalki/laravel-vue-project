<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

class AdminController extends Controller
{
    public function addTag(Request $request)
    {
        $this->validate($request, [
            'tagName' => 'required'
        ]);
        return Tag::create(['tagName' => $request->tagName]);
    }
    public function getTag()
    {
        return Tag::all();
    }
    public function editTag(Request $request)
    {
        $this->validate($request, ['tagName' => 'required']);
        Tag::where('id', $request->id)->update(['tagName' => $request->tagName]);
        return response()->json([
            'tagName' => $request->tagName
        ]);
    }
    public function deleteTag(Request $request)
    {
        $this->validate($request, ['tagName' => 'required']);
        return Tag::where('id', $request->id)->delete();
    }
    public function upload(Request $request)
    {
        //$this->validate($request,['file'=>'required|mimes:png,jpg,jpeg']);
        $pName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $pName);
        return $pName;
    }
    public function deleteImage(Request $request)
    {
        $fileName = $request->imageName;
        $this->deleteFileFromServer($fileName);
        return 'done';
    }
    public function deleteFileFromServer($fileName)
    {
        
            $filePath = public_path() . '/uploads/' . $fileName;
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
            return;
    }
    public function addCategory(Request $request){
        $this->validate($request,['categoryname'=>'required','iconImage'=>'required']);
        return Category::create(['categoryName'=>$request->categoryName,'iconImage'=>$request->iconImage]);
    }
}
