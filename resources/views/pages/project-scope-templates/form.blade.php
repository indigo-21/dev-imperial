<x-app-layout>
    <x-slot name="pageTitle">
        {{ isset($project) ? 'Edit' : 'Create' }} Project Scope Template
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                  
                    <form action="{{ isset($project) ? route('costPlans.update', $project->id) : route('costPlans.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($project))
                            @method('PUT')
                        @endif
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Project</label>
                                            <select class="form-control select2bs4" name="project_id" style="width: 100%;">
                                                <option value="">-- Select Project --</option>
                                                <option value="1">Project Alpha</option>
                                                <option value="2">Project Beta</option>
                                                <option value="3">Project Gamma</option>
                                                <option value="4">Project Delta</option>

                                            </select>
                                        </div>

                                        <div class="form-group">
                                               <div id="sections-wrapper">
                                                    <!-- Sections will appear here -->
                                                </div>

                                                <button type="button" class="btn btn-success mt-3" onclick="addSection()">+ Add Section</button>
                                                <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
    @section('scripts')
       <script>
            $(document).ready(function() {
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })
            })

            let sectionCount = 0;

            function addSection() {
            sectionCount++;

            let sectionHtml = `
                <div class="card mt-3 p-3 section-row">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="mb-0 section-label"></label>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteSection(this)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                    <input type="hidden" class="section-code" name="sections[${sectionCount}][code]" value="">
                    <input type="text" name="sections[${sectionCount}][name]" 
                        class="form-control mt-2" placeholder="Enter section name">
                </div>
            `;

            document.getElementById('sections-wrapper').insertAdjacentHTML('beforeend', sectionHtml);

            renumberSections();
        }

        function deleteSection(button) {
            button.closest('.section-row').remove();
            renumberSections();
        }

        function renumberSections() {
            let sections = document.querySelectorAll('.section-row');
            sections.forEach((row, index) => {
                let number = (index + 1) + ".00";
                row.querySelector('.section-label').innerText = "Section " + number;
                row.querySelector('.section-code').value = number;
            });
        }
       </script>

    @endsection
</x-app-layout>
