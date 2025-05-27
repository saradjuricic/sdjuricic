<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    @extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Profile Information') }}</div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">{{ __('Update Password') }}</div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Order History</div>
                <div class="card-body">
                    @if($orders->count() > 0)
                        @foreach($orders as $order)
                        <div class="border-bottom pb-2 mb-2">
                            <strong>Order #{{ $order->id }}</strong><br>
                            <small class="text-muted">{{ $order->created_at->format('M d, Y') }}</small><br>
                            <span class="badge badge-{{ $order->status == 'delivered' ? 'success' : 'warning' }}">
                                {{ ucfirst($order->status) }}
                            </span><br>
                            <strong>${{ $order->total }}</strong>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted">No orders yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
</x-app-layout>
