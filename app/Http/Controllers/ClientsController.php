<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Group;
use App\Models\Template;

class ClientsController extends Controller
{
    public function index(){
        $templates = $this->getTemplates();
        $clients = $this->getClients();
        $groups = $this->getGroups();
        return view('home')->with('clients',$clients)->with('groups',$groups)->with('templates', $templates);
    }

    public function createClient(Request $request){
        $this->validation($request);
        $client = new Client();
        $client->name = $request['name'];
        $client->surname = $request['surname'];
        $client->email = $request['email'];
        $client->group_id = $request['group_id'];
        $client->save();
        return redirect()->back();
    }

    public function deleteClient($id){
        Client::where('id',$id)->delete();
        return redirect()->back()->with('message', 'Client deleted successfully!');
    }

    public function updateClient(Request $request, $id){
        $this->validation($request);
        Client::where('id',$id)
        ->update(array(
            'name'      => $request['name'],
            'surname'   => $request['surname'],
            'email'     => $request['email'],
            'group_id'  => $request['group_id']
        ));
        return redirect('/home')->with('message', 'Client updated successfully!');
    }

    public function showClient($id){
        $client = Client::where('id',$id)->first();
        $groups = $this->getGroups();
        return view('updateClient')->with('client',$client)->with('groups',$groups);
    }

    public function getClients(){
        $clients = Client::all()->sortByDesc('group_id');
        return $clients;
    }
    
    public function getGroups(){
        $groups = Group::all()->sortBy('id');
        return $groups;
    }

    public function getTemplates(){
        $templates = Template::all()->sortByDesc('created_at');
        return $templates;
    }

    public function validation($request){
        $request->validate([
            'name'  => 'required|max:100',
            'surname' => 'required|max:100',
            'email' => 'required|email|max:255',
        ]);
    }
}
