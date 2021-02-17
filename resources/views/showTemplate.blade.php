@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card p-3">
                <div class="d-flex">
                    <div class="mr-auto p-2">
                        <h2>Template</h2>
                    </div>
                </div>
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <th>Title</th>
                    </tr>
                    <tr>
                        <td>{{ $template->name }}</td>
                        <td>{{ $template->title }}</td>
                    </tr>
                </table>
                <table class="table">
                    <tr>
                        <th>Content</th>
                    </tr>
                    <tr>
                        <td>{{ $template->content }}</td>
                    </tr>
                </table>
                <div class="modal-footer">
                    <a class="btn btn-danger" href="/templates">Back</a>
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection


