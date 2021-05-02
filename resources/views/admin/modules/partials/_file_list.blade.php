@if($data)
    @foreach($data as $key => $item)
        <li class="dd-item" data-type="module">
            <div class="dd-handle dd3-handle"><em class="fa fa-ellipsis-v"></em></div>
            <div class="dd3-content">
                <div class="row">
                    <div class="col-md-9">
                        @include('helpers.form_control', [
                            'type' => 'text',
                            'name' => "filename_$key",
                            'value' => $item['name'],
                            'label' => trans('app.admin.module_file.name'),
                            'rules' => $rules
                        ])
                    </div>
                    <div class="col-md-3 m-auto">
                        <div class="pull-right">
                            <a data-src="{{ url("filemanager2/dialog.php?type=2&descending=0&lang=lt&akey=key&field_id=edit-$key") }}"
                               data-fancybox data-type="iframe" href="javascript:"
                               type="button" class="btn btn-purple btn-xs"
                               title="{{ trans('app.admin.edit') }}">
                                <em class="fa fa-pencil m-0"></em>
                            </a>
                            <button class="btn btn-danger btn-xs dd-delete" title="{{ trans('app.admin.delete') }}">
                                <em class="fa fa-trash-o m-0"></em>
                            </button>
                            <button type="button" class="btn btn-white btn-xs expand-button collapsed"
                                    data-toggle="collapse" data-target="#file-collapse-{{ $key }}"
                                    aria-expanded="false"
                                    aria-controls="file-collapse-{{ $key }}">
                                <em class="fa fa-compress m-0"></em>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 collapse" id="file-collapse-{{ $key }}">
                        <div class="col-md-6 pull-left">
                            @include('helpers.form_control', [
                                'type' => 'select',
                                'name' => "width_$key",
                                'id' => "width_$key",
                                'label' => trans('app.admin.module_file.width'),
                                'value' => $item['width'] ?? '',
                                'options' => [
                                    [
                                        'value' => 6,
                                        'text' => '50%'
                                    ],
                                    [
                                        'value' => 12,
                                        'text' => '100%'
                                    ]
                                ],
                                'rules' => $rules
                            ])
                        </div>
                        <div class="col-md-6 pull-left">
                            @include('helpers.form_control', [
                                'type' => 'select',
                                'name' => "open_$key",
                                'id' => "open_$key",
                                'label' => trans('app.admin.module_file.download_open'),
                                'value' => $item['open'] ?? '',
                                'options' => [
                                    [
                                        'value' => 0,
                                        'text' => trans('app.admin.module_file.download')
                                    ],
                                    [
                                        'value' => 1,
                                        'text' => trans('app.admin.module_file.open')
                                    ]
                                ],
                                'rules' => $rules
                            ])
                        </div>
                        <div class="col-md-12 pull-left">
                            @include('helpers.form_control', [
                                'type' => 'text',
                                'name' => "url_$key",
                                'value' => $item['url'],
                                'label' => trans('app.admin.module_file.url'),
                                'rules' => $rules
                            ])
                        </div>
                        <input type="hidden" id="key" value="{{ $key }}">
                        <input type="hidden" id="edit-{{ $key }}" data-key="{{ $key }}">
                        <input type="hidden" name="id_{{ $key }}" value="{{ $item['id'] ?? '' }}">
                    </div>
                </div>
            </div>
        </li>
    @endforeach
@endif
