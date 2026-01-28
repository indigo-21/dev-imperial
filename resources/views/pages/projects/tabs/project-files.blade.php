@extends('pages.projects.form')
@section('project-files-tab')
    <div class="row">
        {{-- Upload Form --}}
        <div class="col-md-12">
            <form action="{{ route('projects.project_file_upsert', $project->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <input type="hidden" name="project_file_id" value="">
                <div class="col-md-6">
                    {{-- File Description --}}
                    <div class="form-group">
                        <label for="description">File Description</label>
                        <input type="text" name="description" id="description" class="form-control"
                            placeholder="Enter a brief description">
                        <span class="text-danger error">{{$errors->first('description')}}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    {{-- File Upload --}}
                    <div class="form-group">
                        <label for="document">Select Document</label>
                        <input type="file" name="file" id="document" class="form-control-file">
                        <span class="text-danger error">{{$errors->first('file')}}</span>

                    </div>
                    {{-- Buttons --}}
                    <div class="form-group mt-3">
                        <button type="reset" class="btn btn-outline-secondary form-btn-cancel">Cancel</button>
                        <button type="submit" class="btn btn-primary ml-2" id="upload_btn">Submit</button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Document List Table --}}
        <div class="col-md-12">
            <h5 class="mb-3 text-center"><strong>Uploaded Documents</strong></h5>
            <table id="documentsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th>Description</th>
                        <th width="15%">File Name</th>
                        <th width="10%">Uploaded By</th>
                        <th width="10%">Date</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($project_files) > 0)
                        @foreach ($project_files as $project_file )
                            <tr class="project-file-row">
                                <td>{{$loop->iteration}}</td>
                                <td><span class="project-file-description">{{$project_file->description}}</span></td>
                                <td><a href="{{ asset('storage/uploads/' . $project_file->filename) }}" download>{{$project_file->filename}}</a></td>
                                <td>{{$project_file->created_user->firstname}} {{$project_file->created_user->lastname}}</td>
                                <td>{{$project_file->created_at->format("F d, Y")}}</td>
                                <td class="text-center d-flex justify-content-center align-items-center">
                                    <button class="btn btn-sm btn-outline-primary edit-document mr-3" data-project-id="{{$project_file->id}}" title="View"><i
                                            class="fas fa-eye"></i></button>
                                    <form action="{{ route("projects.project_file_destroy", $project_file->id) }}" method="POST"> 
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" class="btn btn-sm btn-outline-danger" data-project-id="{{$project_file->id}}" title="Delete"><i
                                            class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                            <tr>
                                <td colspan="6" class="text-center">No Data Result...</td>
                            </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection


@section("scripts")
        <script src="{{ asset('assets/custom/js/pages/projects/tabs/project-file.js') }}"></script>
@endsection
