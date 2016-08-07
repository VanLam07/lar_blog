@extends('layouts.manage')

@section('title', trans('manage.man_medias'))

@section('page_title', trans('manage.edit'))

@section('bodyAttrs', 'ng-app="ngFile" ng-controller="FileCtrl"')

@section('content')

{!! show_messes() !!}

@if($item)

{!! Form::open(['method' => 'put', 'route' => ['media.update', $item->id]]) !!}

<div class="row">
    <div class="col-sm-8">

        @include('manage.parts.lang_edit_tabs', ['route' => 'media.edit'])

        <div class="form-group">
            <label>{{trans('manage.name')}} (*)</label>
            {!! Form::text('locale[name]', $item->name, ['class' => 'form-control', 'placeholder' => trans('manage.name')]) !!}
            {!! error_field('locale.name') !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.slug')}}</label>
            {!! Form::text('locale[slug]', $item->slug, ['class' => 'form-control', 'placeholder' => trans('manage.slug')]) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.content')}}</label>
            {!! Form::textarea('locale[description]', $item->description, ['class' => 'form-control editor_content', 'rows' => 15, 'placeholder' => trans('manage.content')]) !!}
        </div>
        
        @if(cando('edit_other_posts'))
        <div class="form-group">
            <label>{{trans('manage.created_at')}}</label>
            <div class="time_group">
                <div class="t_field">
                    <span>{{trans('manage.day')}}</span>
                    <select name="time[day]">
                        {!! range_options(1, 31, $item->created_at->format('d')) !!}
                    </select>
                </div>
                <div class="t_field">
                    <span>{{trans('manage.month')}}</span>
                    <select name="time[month]">
                        {!! range_options(1, 12, $item->created_at->format('m')) !!}
                    </select>
                </div>
                <div class="t_field">
                    <span>{{trans('manage.year')}}</span>
                    <select name="time[year]">
                        {!! range_options(2010, 2030, $item->created_at->format('Y')) !!}
                    </select>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.author')}}</label>
            {!! Form::select('author_id', $users, $item->author_id, ['class' => 'form-control']) !!}
        </div>
        @endif

    </div>
    <div class="col-sm-4">

        <div class="form-group thumb_box" >
            <label>{{trans('manage.thumbnail')}}</label>
            <div class="thumb_group">
                <div class="thumb_item">
                    <a class="img_box">
                        @if($item->thumb_url)
                        <img class="img-responsive" src="{{getImageSrc($item->thumb_url)}}" alt="Thumbnail">
                        @endif
                    </a>
                    <input type="hidden" id="file_url" name="thumb_url" value="{{getImageSrc($item->thumb_url)}}">
                    <div class="btn_box">
                        @if($item->thumb_url)
                        <button type="button" class="close btn-remove-file"><i class="fa fa-close"></i></button>
                        @endif
                    </div>
                </div>
            </div>
            {!! error_field('thumb_url') !!}
            <div><button type="button" class="btn btn-default btn-popup-files" frame-url="/plugins/filemanager/dialog.php?type=1&field_id=file_url&field_img=file_src" data-toggle="modal" data-target="#files_modal">{{trans('manage.add_image')}}</button></div>
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.status')}}</label>
            {!! Form::select('status', [1 => trans('manage.enable'), 0 => trans('manage.disable')], $item->status, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.categories')}}</label>
            <ul class="cat-check-lists">
                @if($albums)
                @foreach($albums as $al)
                <li><label>{!! Form::checkbox('cat_ids[]', $al->id, in_array($al->id, $curr_albums)) !!} {{$al->name}}</label></li>
                @endforeach
                @endif
            </ul>
        </div>

        <div class="form-group">
            <label>{{trans('manage.views')}}</label>
            {!! Form::number('views', $item->views, ['class' => 'form-control']) !!}
        </div>
        
        <input type="hidden" name="lang" value="{{$lang}}">
        {!! error_field('lang') !!}

        <a href="{{route('media.index', ['status' => 1])}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.update')}}</button>

    </div>
</div>

{!! Form::close() !!}

@else
<p>{{trans('manage.no_item')}}</p>
@endif

@stop

@section('foot')
<script src="/plugins/tinymce/tinymce.min.js"></script>

<script>
    var files_url = '<?php echo route('file.index') ?>';
    var filemanager_title = '<?php echo trans('manage.man_files') ?>';
</script>

<script src="/adminsrc/js/tinymce_script.js"></script>

@include('files.modal')

@stop

