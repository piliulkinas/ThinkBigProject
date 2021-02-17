<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Template;

class TemplatesController extends Controller
{
    public function index(){
        $templates = $this->getTemplates();
        return view('templates')->with('templates', $templates);
    }

    public function createTemplate(Request $request){
        $this->validation($request);
        $template = new Template();
        $template->name = $request['name'];
        $template->title = $request['title'];
        $template->content = $request['content'];
        $template->created_at = date('Y-m-d H:i:s');
        $template->save();
        return redirect()->back();
    }

    public function updateTemplate(Request $request, $id){
        $this->validation($request);
        Template::where('id', $id)
        ->update(array(
            'name'      => $request['name'],
            'title'     => $request['title'],
            'content'   => $request['content'],
            'created_at'=> date('Y-m-d H:i:s')
        ));
        return redirect('/templates')->with('message', 'Template updated successfully!');
    }

    public function deleteTemplate($id){
        Template::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Template deleted successfully!');
    }

    public function readTemplate($id){
        $template = Template::where('id',$id)->first();
        return view('showTemplate')->with('template', $template);
    }

    public function showTemplate($id){
        $template = Template::where('id', $id)->first();
        return view('updateTemplate')->with('template', $template);
    }

    public function getTemplates(){
        $templates = Template::all()->sortByDesc('created_at');
        return $templates;
    }

    public function validation($request){
        $request->validate([
            'name'  => 'required|max:200',
            'title' => 'required|max:2000',
            'content' => 'required|max:10000',
        ]);
    }
}
