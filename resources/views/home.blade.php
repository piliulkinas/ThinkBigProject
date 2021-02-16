@extends('layouts.app')

@section('content')
<div class="container">
    <div class="alert-danger">{{ $errors->first('planedTime') }}</div>
    @if(session('message'))
        <div class="alert-success">{{ session('message') }}</div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card p-3">
                <div class="d-flex">
                    <div class="mr-auto p-2">
                        <h2>Clients</h2>
                    </div>
                    <div class="p-2">
                        <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#createNewClientModal">Create new client</button>
                    </div>
                    <div class="p-2">
                        <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#sendEmailToGroup">Send email</button>
                    </div>
                </div>
                <!--Create new client Modal-->
                <div class="modal fade" id="createNewClientModal" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form method="POST" action="createNewClient">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title">Add new client</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <table class="table">
                                        <tr>
                                            <th>Firstname</th>
                                            <th>Lastname</th>
                                            <th>Email</th>
                                            <th>Group</th>
                                        </tr>
                                        <tr>
                                            <td><input type="text" name="name" id="name" placeholder="John"></td>
                                            <td><input type="text" name="surname" id="surname" placeholder="Smith"></td>
                                            <td><input type="email" name="email" id="email" placeholder="JohnSmith@smth.com"></td>
                                            <td>
                                                <select class="form-control-sm" name="group_id">
                                                    @foreach ($groups as $group)
                                                        <option value="{{ $group->id }}">{{ $group->group_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Create new client Modal end-->
                <!-- Send email to group Modal-->
                <div class="modal fade" id="sendEmailToGroup" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form method="POST" action="sendEmailToGroup">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title">Select additional information</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Clients Group</th>
                                                <th>Template</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select class="form-control-sm" id="selectGroup" name="group_id">
                                                        @foreach ($groups as $group)
                                                            <option value="{{ $group->id }}">{{ $group->group_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control-sm" id="selectTemplate" name="templateId">
                                                        @foreach ($templates as $template)
                                                            <option value="{{ $template->id }}">{{ $template->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="justify-content-end">Set time</td>
                                                <td><input type="datetime-local" id="planedTime" name="planedTime"> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Send email to group Modal end-->
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Email</th>
                            <th>Group</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                        <tr>
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->surname }}</td>
                            <td>{{ $client->email }}</td>
                            <td>
                                @foreach($groups as $group)
                                    @if($group->id == $client->group_id)
                                        {{ $group->group_name }}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <a class="btn btn-sm btn-danger mr-1" role="button" href="/deleteClient/{{ $client->id }}">Delete</a>
                                <a class="btn btn-sm btn-success mr-1" role="button" href="/showClient/{{ $client->id }}">Update</a>
                                <button class="btn btn-sm btn-primary" id="MailToClient" type="button" data-toggle="modal" data-target="#sendEmailToClient{{ $client->id }}">Send email</button>
                                <!-- send email to one client modal  -->
                                <div class="modal fade" id="sendEmailToClient{{ $client->id }}" role="dialog">
                                    <div class="modal-dialog modal-lg text-center">
                                        <div class="modal-content">
                                            <form method="POST" action="sendEmailToClient">
                                                @csrf
                                                <input type="hidden" id="clientId" name="clientId" value="{{ $client->id }}">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Select template</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table">
                                                        <tr>
                                                            <thead>
                                                                <th>Template</th>
                                                                <th>Set time</th>
                                                            </thead>
                                                        </tr>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <select class="form-control-sm" id="selectTemplate" name="templateId">
                                                                        @foreach ($templates as $template)
                                                                            <option value="{{ $template->id }}">{{ $template->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="datetime-local" id="planedTime" name="planedTime"> 
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Send</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- send email modal end -->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</div>
@endsection
