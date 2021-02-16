@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card p-3">
                <div class="d-flex">
                    <div class="mr-auto p-2">
                        <h2>Update Template</h2>
                    </div>
                </div>
                    <form method="POST" action="/templates/updateTemplate/{{ $template->id }}">
                        <table class="table">
                            @csrf
                            <tr>
                                <th>Name</th>
                                <th>Title</th>
                            </tr>
                            <tr>
                                <td><input type="text" name="name" id="name" value="{{ $template->name }}" required></td>
                                <td><textarea name="title" id="emailTitle" cols="60" rows="1" required>{{ $template->title }}</textarea></td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Content</h5><br>
                                    <p>Please use bookmarks: <br> !NAME! (for client name), !SURNAME! (for client surname), !EMAIL! (for client email)</p>
                                </td>
                                <td><textarea name="content" cols="60" rows="15" required>{{ $template->content }}</textarea></td>
                            </tr>
                        </table>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div> 
@endsection


