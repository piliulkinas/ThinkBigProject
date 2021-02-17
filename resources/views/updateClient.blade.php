@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('errors'))
        <div class="alert-danger">{{ $errors }}</div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card p-3">
                <div class="d-flex">
                    <div class="mr-auto p-2">
                        <h2>Update Client Information</h2>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Email</th>
                            <th>Group</th>
                        </tr>
                    </thead>
                    <tbody>
                        <form method="POST" action="/updateClient/{{ $client->id }}">
                            @csrf
                            <tr>
                                <td><input value="{{ $client->name }}" name="name" required></td>
                                <td><input value="{{ $client->surname }}" name="surname" required></td>
                                <td><input value="{{ $client->email }}" name="email" required></td>
                                <td>
                                    <select class="form-control-sm" name="group_id">
                                        @foreach($groups as $group)
                                            @if($group->id == $client->group_id)
                                                <option value="{{ $group->id }}">{{ $group->group_name }}</option>
                                            @endif
                                        @endforeach
                                        @foreach ($groups as $group)
                                            @if($group->id != $client->group_id)
                                                <option value="{{ $group->id }}">{{ $group->group_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
                                <td><button type="submit" class="btn btn-success">Save</button></td>
                            </tr>
                        </form>
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</div>
@endsection
