@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('message'))
        <div class="alert-success">{{ session('message') }}</div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card p-3">
                <div class="d-flex">
                    <div class="mr-auto p-2">
                        <h2>Scheduled emails</h2>
                    </div> 
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Time to send</th>
                            <th>Template name</th>
                            <th>To</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($planedMails as $planedMail)
                        <tr>
                            <td>{{ $planedMail->timeToSend }}</td>
                            <td>{{ $planedMail->name }}</td>
                            <td>{{ $planedMail->email }}</td>
                            <td>
                                <a class="btn btn-sm btn-danger mr-1" role="button" href="scheduledEmails/deletePlanedMail/{{ $planedMail->id }}">Delete</a>
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
