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
                                            <td><input type="text" name="name" id="name" placeholder="John" required></td>
                                            <td><input type="text" name="surname" id="surname" placeholder="Smith" required></td>
                                            <td><input type="email" name="email" id="email" placeholder="JohnSmith@smth.com" required></td>
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
                                                <td><input type="datetime-local" id="planedTime" name="planedTime" onchange="displayDivRepeat('orrepeat', this)"> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="container" id="orrepeat">
                                        <div class="row">
                                            <div class="col-sm">
                                                Do you want to repeat this email?
                                            </div>
                                            <div class="col-sm">
                                                <select class="form-control-sm"  onchange="displayDivDemo('hidden_tr', this)">
                                                    <option value="0">No</option>
                                                    <option value="1">Repeat</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="container" id="hidden_tr">
                                        <div class="row">
                                            <div class="col-sm">
                                                <label for="repeat">To repeat</label>
                                                    <select class="form-control-sm"  id="repeat" name="repeat">
                                                        <option value="No">No</option>
                                                        <option value="Every day">Every day</option>
                                                        <option value="Every week">Every week</option>
                                                        <option value="Every month">Every month</option>
                                                        <option value="Every year">Every year</option>
                                                    </select>
                                                </label>
                                            </div>
                                            <div class="col-sm">
                                                <label for="validUntil">How long</label>
                                                <select class="form-control-sm" id="validUntil" name="validUntil">
                                                    <option value="Week">Week</option>
                                                    <option value="Month">Month</option>
                                                    <option value="Year">Year</option>
                                                </select>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
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
                                                                    <input type="datetime-local" id="planedTime" name="planedTime" onchange="displayDivRepeat('orrepeatforone', this)"> 
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="container" id="orrepeatforone">
                                                        <div class="row">
                                                            <div class="col-sm">
                                                                Do you want to repeat this email?
                                                            </div>
                                                            <div class="col-sm">
                                                                <select class="form-control-sm"  onchange="displayDivDemo('hidden_div', this)">
                                                                    <option value="0">No</option>
                                                                    <option value="1">Repeat</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div><br>
                                                    <div class="container" id="hidden_div">
                                                        <div class="row">
                                                            <div class="col-sm">
                                                                <label for="repeat">To repeat</label>
                                                                    <select class="form-control-sm"  id="repeat" name="repeat">
                                                                        <option value="No">No</option>
                                                                        <option value="Every day">Every day</option>
                                                                        <option value="Every week">Every week</option>
                                                                        <option value="Every month">Every month</option>
                                                                        <option value="Every year">Every year</option>
                                                                    </select>
                                                                </label>
                                                            </div>
                                                            <div class="col-sm">
                                                                <label for="validUntil">How long</label>
                                                                <select class="form-control-sm" id="validUntil" name="validUntil">
                                                                    <option value="Week">Week</option>
                                                                    <option value="Month">Month</option>
                                                                    <option value="Year">Year</option>
                                                                </select>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
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

<style>
#hidden_tr {
    display: none;
}
#orrepeat {
    display: none;
}
#orrepeatforone {
    display: none;
}
#hidden_div {
    display: none;
}
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    function displayDivDemo(id, elementValue) {
        document.getElementById(id).style.display = elementValue.value == 1 ? 'block' : 'none';
    }
    function displayDivRepeat(id, elementValue) {
        document.getElementById(id).style.display = elementValue.value != null ? 'block' : 'none';
    }
</script>