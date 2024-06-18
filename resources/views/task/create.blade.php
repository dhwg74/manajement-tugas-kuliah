@extends('layouts.master')

@section('content')
    <h1>Buat Tugas</h1>
    <hr/>

    {!! Form::open(['url' => '/task/store', 'class' => 'form-horizontal', 'role' => 'form']) !!}
            <!-- Project Field -->
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Project', ['class' => 'col-sm-3 control-label']) !!}
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
            {!! Form::label('name', 'Task Name', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                <span class="help-block text-danger">
                    {{ $errors -> first('name') }}
                </span>
            </div>
        </div>
        <!-- Priority Field -->
        <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
            {!! Form::label('priority', 'Priority', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::number('priority', null, ['class' => 'form-control']) !!}
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
                '', 
                ['class' => 'col-sm-3 control-label']) !!}
                <span class="help-block text-danger">
                    {{ $errors -> first('project_id') }}
                </span>
            </div>
        </div>        
        <!-- Submit Button -->
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
                {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
    {!! Form::close() !!}
@endsection
