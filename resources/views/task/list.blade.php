@extends('layouts.master')

@section('content')
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8fafc;
        }
        .container {
            margin-top: 20px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border-radius: 10px 10px 0 0;
            font-size: 1.25rem;
            text-align: center;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .form-inline .form-group {
            margin-bottom: 1rem;
        }
        .table {
            margin-top: 20px;
        }
        .table th {
            background-color: #007bff;
            color: white;
        }
        .table td {
            vertical-align: middle;
        }
        .table .btn-xs {
            padding: .25rem .5rem;
            font-size: .75rem;
            line-height: 1.5;
        }
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
        .text-center h3 {
            margin-top: 20px;
        }
    </style>
    <h1>List Tugas <a href="{{ url('/task/create') }}" class="btn btn-primary pull-right btn-sm">Buat Tugas</a></h1>
    <hr/>

    @include('partials.flash_notification')

    <fieldset>
        <legend>Filter</legend>
        {!! Form::open(['route' => ['home'], 'class' => 'form-inline', 'method' => 'get']) !!}
            <div class="form-group">
                {!! Form::label('project_id', 'MataKuliah', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::select('project_id', $projects, $selectedProject, ['class' => 'form-control']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </fieldset>
    <hr/>

    @if(count($taskList))
        <form id="dataListForm" name="dataListForm" method="post" action="/"> 
            <div class="table-responsive">
                <table id="taskTable" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">No</th>
                            <th>Tugas</th>
                            <th>Prioritas</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($taskList as $index => $task)
                            <tr id="{{ $index + 1 }}">
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $task->name }}</td>
                                <td>
                                    <input type="hidden" name="sortorder[{{ $task->id }}]" class="sortinput" value="{{ $task->priority }}">
                                    <span class="priority-text">{{ $task->priority }}</span>
                                </td>
                                <td>{{ $status[$task->status] }}</td>
                                <td>
                                    <a href="{{ url('/task/edit/' . $task->id) }}" class="btn btn-primary btn-xs">Edit</a>
                                    <br/><br/>
                                    {!! Form::open(['route' => ['task.destroy', $task->id], 'class' => 'form-inline', 'method' => 'delete', 'onsubmit' => 'return confirm(\'Hapus Tugas ?\')']) !!}
                                        {!! Form::hidden('id', $task->id) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    @else
        <div class="text-center">
            <h3>Tidak ada Tugas</h3>
            <p><a href="{{ url('/task/create') }}">Buat Tugas Baru</a></p>
        </div>
    @endif

    <script>
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#project_id').on('change', function(){
                $(this).parents('form').submit();
            });

            var fixHelperModified = function(e, tr) {
                var $originals = tr.children();
                var $helper = tr.clone();
                $helper.children().each(function(index) {
                    $(this).width($originals.eq(index).width())
                });
                return $helper;
            },
            updateIndex = function(e, ui) {
                $('td.index', ui.item.parent()).each(function (i) {
                    $(this).html(i + 1);
                });
                $('input[type=text]', ui.item.parent()).each(function (i) {
                    $(this).val(i + 1);
                    $(this).parent().find('.priority-text').html(i + 1);
                });
            };

            $("#taskTable tbody").sortable({
                helper: fixHelperModified,
                stop: updateIndex,
                distance: 5,
                delay: 20,
                opacity: 0.6,
                cursor: 'move',
                update: function(event, ui) {
                    var url = "/task/update-sort-order";
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: $('#dataListForm').find('.sortinput').serializeArray(),
                        success: function (data){
                            console.log('Sort order updated');
                        }
                    });
                },
                change: function(event, ui) {
                    console.log('Row changed');
                }
            }).disableSelection();    
        });
    </script>
@endsection
