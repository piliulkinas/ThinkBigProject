@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('errors'))
        <div class="alert-danger">{{ $errors }}</div>
    @endif
    @if(session('message'))
        <div class="alert-success">{{ session('message') }}</div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card p-3">
                <div class="d-flex">
                    <div class="mr-auto p-2">
                        <h2>Templates</h2>
                    </div>
                    <div class="p-2">
                        <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#createNewTemplateModal">Create new template</button>
                    </div>
                </div>
                <!--Create new template Modal-->
                <div class="modal fade" id="createNewTemplateModal" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form method="POST" action="templates/createNewTemplate">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title">Create Template</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <table class="table">
                                        <tr>
                                            <th>Name</th>
                                            <th>Title</th>
                                        </tr>
                                        <tr>
                                            <td><input type="text" name="name" id="name" required></td>
                                            <td><textarea name="title" cols="60" rows="1" required></textarea></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h5>Content</h5><br>
                                                <p>Please use bookmarks: <br> !NAME! (for client name), !SURNAME! (for client surname), !EMAIL! (for client email)</p>
                                            </td>
                                            <td><textarea name="content" cols="60" rows="15" required></textarea></td>
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
                <!-- Create new template Modal end-->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Title</th>
                            <th>Created/updated at</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($templates as $template)
                        <tr>
                            <td><a href="/template/{{ $template->id }}">{{ $template->name }}</a></td>
                            <td>{{ $template->title }}</td>
                            <td>{{ $template->created_at }}</td>
                            <td>
                                <a class="btn btn-sm btn-danger mr-1" role="button" href="templates/deleteTemplate/{{ $template->id }}">Delete</a>
                                <a class="btn btn-sm btn-success mr-1" role="button" href="templates/showTemplate/{{ $template->id }}">Update</a>
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
