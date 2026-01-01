@extends('layouts.admin')

@section('title', 'Admin Settings')
@section('page-title', 'System Settings')
@section('page-description', 'Configure platform settings and preferences')

@section('styles')
<style>
    .content-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .content-card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
</style>
@endsection

@section('content')
<div class="content-card">
    <div style="padding: 24px;">
        @include('admin.settings_backup')
    </div>
</div>
@endsection
