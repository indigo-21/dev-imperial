<x-app-layout>

     <x-slot name="importedLinks">
       <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/smoothness/jquery-ui.css">
    </x-slot>
    
    @section('style')
        <style>
            .short-input {
                width: 65px;
            }

            .section-item-row {
                border-bottom: 1px solid #ddd;
                padding-bottom: 25px;
            }

            .selectable-label {
                cursor: pointer;
            }

            .select-box {
                width: 20px;
                height: 20px;
                border: 2px solid #ced4da;
                border-radius: 4px;
                margin-right: 8px;
                flex-shrink: 0;
                transition: 0.2s;
            }

            .select-box.selected {
                background-color: #28a745;
                border-color: #28a745;
            }

            .select-box:hover {
                border-color: #28a745;
            }
            textarea{
                resize: none;
            }
            .section-items { cursor: move; }
            .ui-state-highlight { height: 200px; background: #f0f0f0; border: 1px dashed #ccc; }
            .section-item-row { background: #ffffff;}
        </style>
    @endsection

    <x-slot name="pageTitle">
        {{ isset($project) ? "Edit" : "Create" }} Project
    </x-slot>

    <x-slot name="content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-primary card-outline mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Project Information</h3>
                    </div>
                    <div class="card-body">
                        @isset($project)
                            @if ($project->high_risk_building >= 1)
                                 <div class="row">
                                    <!-- Project Reference -->
                                    <div class="col-md-4 mb-2 p-2 bg-danger text-white rounded">
                                        <strong>High Risk Building: {{$project->high_risk_building == 1 ? "Yes" : "Unsure"}}</strong>
                                    </div>
                                </div>
                            @endif
                            <div class="row">

                                <div class="col-md-4 mb-3">
                                    <strong>Project Reference:</strong>
                                    <p class="mb-0"> {{"PRJ-" . str_pad($project->id, 5, '0', STR_PAD_LEFT)}}</p>
                                </div>

                                <!-- Client -->
                                <div class="col-md-4 mb-3">
                                    <strong>Client:</strong>
                                    <p class="mb-0">{{$project->client->business_name}}</p>
                                </div>

                            </div>
                        @endisset
                        {{-- 🧭 PROJECT TABS SECTION --}}
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card card-outline card-primary">
                                    
                                    @isset($project)
                                        <div class="card-header p-0 border-bottom-0">
                                            <ul class="nav nav-tabs" id="projectTabs" role="tablist">
                                                @foreach ($tabs as $tab )
                                                    @php
                                                        $tab_name = ucfirst($tab);
                                                        // $tab_name = ucfirst(str_replace("-tab", "", $tab));
                                                        $is_active = $tab == Request::segment(3) ? "active" : "";
                                                    @endphp
                                                    <li class="nav-item">
                                                        <a class="nav-link {{$is_active}}" id="{{$tab."-tab"}}"
                                                            href="{{url("projects/edit/$tab/$project->id")}}" role="tab"
                                                            >{{str_replace("-", " ",$tab_name)}}</a>
                                                    </li>    
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endisset

                                    <div class="card-body">
                                        <div class="tab-content" id="projectTabsContent">
                                            @foreach ($tabs as $tab )
                                                @php
                                                    $current_tab = Request::segment(3) ?? "project-detail";
                                                    $is_active = $tab == $current_tab ? "show active" : "";
                                                @endphp
                                                <div class="tab-pane fade {{$is_active}}" id="{{$tab}}" role="tabpanel"
                                                    aria-labelledby="{{$tab}}">
                                                    @yield($tab."-tab")
                                                </div>    
                                            @endforeach

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

</x-app-layout>
