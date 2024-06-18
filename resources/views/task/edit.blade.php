@extends('layouts.master')

@section('content')
    <h1>Edit Tugas</h1>
    <hr/>

    {!! Form::open(['url' => '/task/update/' . $task->id, 'class' => 'form-horizontal', 'role' => 'form']) !!}
            <!-- Project Field -->
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Mata Kuliah', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
            {!! Form::select('project_id', 
                $projects, 
                $selectedProject, 
                ['class' => 'col-sm-3 control-label']) !!}
                <span class="help-block text-danger">
                    {{ $errors -> first('project_id') }}
                </span>
            </div>
        </div>

        <!-- Name Field -->
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Tugas',  ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('name', $task->name, ['class' => 'form-control']) !!}
                <span class="help-block text-danger">
                    {{ $errors -> first('name') }}
                </span>
            </div>
        </div>
        <!-- Priority Field -->
        <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
            {!! Form::label('priority', 'Prioritas', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::number('priority', $task->priority, ['class' => 'form-control']) !!}
                <span class="help-block text-danger">
                    {{ $errors -> first('priority') }}
                </span>
            </div>
        </div>
        
        <!-- Project Status -->
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('status', 'Status', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
            {!! Form::select('status', 
                ['0' => 'Pending', '1' => 'Complete', '3' => 'In Progress'], 
                $task->status, 
                ['class' => 'col-sm-3 control-label']) !!}
                <span class="help-block text-danger">
                    {{ $errors -> first('project_id') }}
                </span>
            </div>
        </div>        
        <!-- Submit Button -->
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
                {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
    {!! Form::close() !!}
@endsection
