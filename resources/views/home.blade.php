@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
            @forelse(auth()->user()->getReferrals() as $referral)
                <h4>
                    {{ $referral->program->name }}
                </h4>
                <code>
                    {{ $referral->link }}
                </code>
                <p>
                    Number of referred users: {{ $referral->relationships()->count() }}
                </p>
            @empty
                No referrals
            @endforelse
        </div>
    </div>
</div>
@endsection
