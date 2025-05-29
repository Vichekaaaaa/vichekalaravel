@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h2>Dashboard</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Total Contacts</h5>
                    <p class="card-text">{{ $totalContacts }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Total Tutorials</h5>
                    <p class="card-text">{{ $totalTutorials }}</p>
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('contacts.index') }}" class="btn btn-primary me-2">View Contacts</a>
@endsection