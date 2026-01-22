@extends('pages.projects.form')
@section('project-files-tab')
    <div class="row">
        {{-- Upload Form --}}
        <div class="col-md-12">

            <form action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="col-md-6">
                    {{-- File Description --}}
                    <div class="form-group">
                        <label for="description">File Description</label>
                        <input type="text" name="description" id="description" class="form-control"
                            placeholder="Enter a brief description">
                    </div>
                </div>

                <div class="col-md-6">
                    {{-- File Upload --}}
                    <div class="form-group">
                        <label for="document">Select Document</label>
                        <input type="file" name="document" id="document" class="form-control-file">
                    </div>
                    {{-- Buttons --}}
                    <div class="form-group mt-3">
                        <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                        <button type="submit" class="btn btn-primary ml-2">Upload</button>
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
                        <th width="25%">Description</th>
                        <th width="25%">File Name</th>
                        <th width="20%">Uploaded By</th>
                        <th width="15%">Date</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Example demo data --}}
                    <tr>
                        <td>1</td>
                        <td>Site Layout Plan</td>
                        <td><a href="#">layout_plan.pdf</a></td>
                        <td>Sarah Thompson</td>
                        <td>2025-10-20</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-outline-primary" title="View"><i
                                    class="fas fa-eye"></i></a>
                            <a href="#" class="btn btn-sm btn-outline-danger" title="Delete"><i
                                    class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
